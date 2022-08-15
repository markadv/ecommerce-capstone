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
			/* If not string, preserve the format of value*/
			if (is_numeric($value)) {
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
			if (is_numeric($value)) {
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
		$where = implode(",", $where);
		return $this->db->query($query . $set . "WHERE " . $where, $values);
	}
	function get_type_address($type, $id)
	{
		if ($type == "shipping") {
			$column = ["shippingAddress_id", "IsShipping"];
		} elseif ($type == "billing") {
			$column = ["billingAddress_id", "IsBilling"];
		}
		$query =
			"SELECT * from addresses LEFT JOIN users ON addresses.id = users." .
			$column[0] .
			" WHERE addresses." .
			$column[1] .
			" = 1 AND addresses.id=?";
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
			"INSERT INTO users (role_id, first_name, last_name, email, mobile, password_hash, salt) VALUES (1,?,?,?,?,?,?)";
		$values = [
			$this->security->xss_clean($user["first_name"]),
			$this->security->xss_clean($user["last_name"]),
			$this->security->xss_clean($user["email"]),
			$this->security->xss_clean($user["mobile"]),
			md5($this->security->xss_clean($user["password"]) . $salt),
			$salt,
		];

		return $this->db->query($query, $values);
	}
	function create_address($address, $type)
	{
		$this->security->xss_clean($type);
		$query = "INSERT INTO addresses (address1, address2, city, state, postal_code, IsBilling,IsShipping,IsPhysical)
		VALUES (?,?,?,?,?,$type[0],$type[1],$type[2])";
		$values = [
			$this->security->xss_clean($address["address1"]),
			$this->security->xss_clean($address["address2"]),
			$this->security->xss_clean($address["city"]),
			$this->security->xss_clean($address["state"]),
			$this->security->xss_clean($address["postal_code"]),
		];
		$this->db->query($query, $values);
		return $this->db->insert_id();
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
			"trim|required|exact_length[11]|is_natural"
		);
		$this->form_validation->set_rules(
			"last_name",
			"Last Name",
			"trim|required"
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

	/* This is for matching password */
	function validate_login_match($user, $password)
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
			"role" => $user["role_id"],
		];
		return $details;
	}
}
