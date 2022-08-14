<?php
defined("BASEPATH") or exit("No direct script access allowed");

class User extends CI_Model
{
	/* This is for getting the user by email */
	function get_user_by_email($email)
	{
		$query = "SELECT * FROM users WHERE email=?";
		$result = $this->db
			->query($query, $this->security->xss_clean($email))
			->result_array();
		return !empty($result) ? $result[0] : 0;
	}
	/* This is for getting the user by email */
	function get_user_by_mobile($mobile)
	{
		$query = "SELECT * FROM users WHERE mobile=?";
		$result = $this->db
			->query($query, $this->security->xss_clean($mobile))
			->result_array();
		return !empty($result) ? $result[0] : 0;
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
			"required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"last_name",
			"Last Name",
			"required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"mobile",
			"Mobile",
			"required|exact_length[11]|is_natural"
		);
		$this->form_validation->set_rules("last_name", "Last Name", "required");
		$this->form_validation->set_rules(
			"password",
			"Password",
			"required|min_length[8]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"confirm_password",
			"Confirm Password",
			"required|matches[password]"
		);

		if (!$this->form_validation->run()) {
			return validation_errors();
		} elseif ($this->get_user_by_email($this->input->post("email"))) {
			return "Email has already been registered.";
		} elseif ($this->get_user_by_mobile($this->input->post("mobile"))) {
			return "Mobile has already been registered.";
		}
	}
	function validate_login()
	{
		$this->form_validation->set_error_delimiters("<div>", "</div>");
		$this->form_validation->set_rules(
			"email",
			"Email",
			"required|valid_email"
		);
		$this->form_validation->set_rules(
			"password",
			"Password",
			"required|min_length[8]"
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
}
