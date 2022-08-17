<?php
defined("BASEPATH") or exit("No direct script access allowed");

class User extends CI_Model
{
	function get_by_parameter($table, $unique, $param)
	{
		$query = "SELECT * FROM $table WHERE $unique=?";
		$result = $this->db
			->query($query, $this->security->xss_clean($param))
			->result_array();
		return !empty($result) ? $result[0] : 0;
	}
	function update_by_parameters($table, $change, $param)
	{
		$query = "UPDATE $table SET ";
		$where = [];
		$set = [];
		$values = [];
		foreach ($change as $key => $value) {
			/* If numeric, preserve the format of value*/
			if (gettype($value) == "integer" || gettype($value) == "double") {
				array_push(
					$set,
					$key . " = " . $this->security->xss_clean($value) . " "
				);
				/* If string, preserve the format of string*/
			} else {
				array_push($set, $key . " = ? ");
				array_push($values, $value);
			}
		}
		foreach ($param as $key => $value) {
			/* If numeric, preserve the format of value*/
			if (gettype($value) == "integer" || gettype($value) == "double") {
				array_push(
					$where,
					$key .
						" " .
						$this->security->xss_clean($value[0]) .
						" " .
						$this->security->xss_clean($value[1]) .
						" "
				);
				/* If string, preserve the format of string*/
			} else {
				array_push($where, $key . $value[0] . "?");
				array_push($values, $value[1]);
			}
		}
		$set = implode(",", $set);
		$where = implode(" AND ", $where);
		return $this->db->query($query . $set . "WHERE " . $where, $values);
	}
	function update_information($post, $id)
	{
		$query = "UPDATE users SET first_name=?, last_name=?, email=?, mobile=? WHERE id = $id";
		$values = [
			$this->security->xss_clean($post["first_name"]),
			$this->security->xss_clean($post["last_name"]),
			$this->security->xss_clean($post["email"]),
			$this->security->xss_clean($post["mobile"]),
		];

		return $this->db->query($query, $values);
	}
	function update_password($id, $password)
	{
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$query = "UPDATE users SET password_hash=?,salt=? WHERE id = $id";
		$values = [md5($this->security->xss_clean($password) . $salt), $salt];

		return $this->db->query($query, $values);
	}
	function get_address($id)
	{
		$query = "SELECT * from addresses WHERE id=?";
		$values = [$this->security->xss_clean($id)];
		return $this->db->query($query, $values)->result_array();
	}
	function get_billing_address($id)
	{
		$query =
			"SELECT * from addresses LEFT JOIN userAddresses ON addresses.id = userAddresses.address_id WHERE userAddresses.IsBilling = 1 AND userAddresses.id=?";
		$values = [$this->security->xss_clean($id)];
		return $this->db->query($query, $values)->result_array();
	}

	/* This is for creating the user by email */
	function create_user($user)
	{
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$query =
			"INSERT INTO users (role_hash, first_name, last_name, email, mobile, password_hash, salt) VALUES (?,?,?,?,?,?,?)";
		$values = [
			md5("2" . $salt),
			$this->security->xss_clean($user["first_name"]),
			$this->security->xss_clean($user["last_name"]),
			$this->security->xss_clean($user["email"]),
			$this->security->xss_clean($user["mobile"]),
			md5($this->security->xss_clean($user["password"]) . $salt),
			$salt,
		];

		return $this->db->query($query, $values);
	}
	/* Create address and return id. by Markad*/
	function create_address($address, $type)
	{
		$clean_type = $this->security->xss_clean($type);
		$clean_postal_code = $this->security->xss_clean(
			$address["postal_code"]
		);
		$query = "INSERT INTO addresses (address1, address2, city, state, postal_code, address_type_id)
		VALUES (?,?,?,?,'$clean_postal_code',$clean_type)";
		$values = [
			$this->security->xss_clean($address["address1"]),
			$this->security->xss_clean($address["address2"]),
			$this->security->xss_clean($address["city"]),
			$this->security->xss_clean($address["state"]),
		];
		$this->db->query($query, $values);
		return $this->db->insert_id();
	}
	function delete_by_id($table, $id)
	{
		$cleanId = $this->security->xss_clean($id);
		$query = "DELETE FROM $table WHERE id= $cleanId";
		return $this->db->query($query);
	}
	function validate_registration()
	{
		$this->form_validation->set_error_delimiters("<div>", "</div>");
		$this->form_validation->set_rules(
			"email",
			"Email",
			"trim|required|valid_email|max_length[256]"
		);
		$this->form_validation->set_rules(
			"first_name",
			"First Name",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"last_name",
			"Last Name",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"mobile",
			"Mobile",
			"required|exact_length[11]"
		);
		$this->form_validation->set_rules(
			"password",
			"Password",
			"trim|required|min_length[8]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"confirm_password",
			"Confirm Password",
			"trim|required|matches[password]"
		);

		if (!$this->form_validation->run()) {
			return validation_errors();
		} elseif (
			$this->get_by_parameter(
				"users",
				"email",
				$this->input->post("email")
			)
		) {
			return "Email has already been registered.";
		} elseif (
			$this->get_by_parameter(
				"users",
				"mobile",
				$this->input->post("mobile")
			)
		) {
			return "Mobile has already been registered.";
		}
	}
	function validate_login()
	{
		$this->form_validation->set_error_delimiters("<div>", "</div>");
		$this->form_validation->set_rules(
			"email",
			"Email",
			"trim|required|valid_email"
		);
		$this->form_validation->set_rules(
			"password",
			"Password",
			"trim|required|min_length[8]"
		);

		if (!$this->form_validation->run()) {
			return validation_errors();
		} else {
			return "success";
		}
	}
	function validate_address()
	{
		$this->form_validation->set_error_delimiters("<div>", "</div>");
		$this->form_validation->set_rules(
			"address1",
			"Address line 1",
			"trim|required|min_length[3]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"address2",
			"Address line 2",
			"trim|min_length[3]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"city",
			"City",
			"trim|required|min_length[3]|max_length[46]|alpha_numeric_spaces"
		);
		$this->form_validation->set_rules(
			"state",
			"State",
			"trim|required|min_length[3]|max_length[46]|alpha_numeric_spaces"
		);
		$this->form_validation->set_rules(
			"postal_code",
			"Postal code",
			"trim|required|exact_length[4]|numeric"
		);

		if (!$this->form_validation->run()) {
			return validation_errors();
		} else {
			return "success";
		}
	}
	function validate_edit($user)
	{
		$this->form_validation->set_error_delimiters("<div>", "</div>");
		$this->form_validation->set_rules(
			"email",
			"Email",
			"trim|required|valid_email|max_length[256]"
		);
		$this->form_validation->set_rules(
			"first_name",
			"First Name",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"last_name",
			"Last Name",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"mobile",
			"Mobile",
			"required|exact_length[11]"
		);
		/* If email or mobile is changed
		 check if email or mobile is already in database */
		if (!$this->form_validation->run()) {
			return validation_errors();
		} elseif (
			$user["email"] !== $this->input->post("email") &&
			!$this->get_by_parameter(
				"users",
				"email",
				$this->input->post("email")
			)
		) {
			return "Email has already been registered.";
		} elseif (
			$user["mobile"] !== $this->input->post("mobile") &&
			$this->get_by_parameter(
				"users",
				"mobile",
				$this->input->post("mobile")
			)
		) {
			return "Mobile has already been registered.";
		} else {
			return "success";
		}
	}
	function validate_password()
	{
		$this->form_validation->set_rules(
			"old_password",
			"Old Password",
			"required|min_length[8]"
		);
		$this->form_validation->set_rules(
			"new_password",
			"New Password",
			"required|min_length[8]"
		);
		$this->form_validation->set_rules(
			"confirm_password",
			"Confirm Password",
			"required|matches[new_password]"
		);
		if (!$this->form_validation->run()) {
			return validation_errors();
		} else {
			return "success";
		}
	}
	/* This is for matching password */
	function validate_password_hash($user, $password)
	{
		$password_hash = md5(
			$this->security->xss_clean($password) . $user["salt"]
		);

		if ($user && $user["password_hash"] == $password_hash) {
			return "success";
		} else {
			return "Incorrect email/password.";
		}
	}
	function profile_array($user)
	{
		$details = [
			"email" => $user["email"],
			"mobile" => $user["mobile"],
			"first_name" => $user["first_name"],
			"isLoggedIn" => 1,
			//create hash later
			"role" => $user["role_hash"],
		];
		return $details;
	}
	function convert_hash($user, $role_hash)
	{
		$role = [
			md5("1" . $user["salt"]) => 1,
			md5("2" . $user["salt"]) => 2,
			md5("3" . $user["salt"]) => 3,
		];
		return isset($role[$role_hash]) ? $role[$role_hash] : 0;
	}
}
