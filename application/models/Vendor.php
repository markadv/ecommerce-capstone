<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendor extends CI_Model
{
	function get_products()
	{
		$query = "SELECT products.*, (SELECT GROUP_CONCAT(images.url  SEPARATOR ',') WHERE NOT images.IsMain = 1) as img_arr, (SELECT images.url WHERE images.IsMain = 1) as img_main,
                inventories.quantity, categories.name as category, orderItems.quantity AS sold
                FROM products
                LEFT JOIN images ON products.id=images.product_id
                LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id
                LEFT JOIN orderItems ON products.id=orderItems.product_id";
		return $this->db->query($query)->result_array();
	}
	function get_by_parameters($table, $param)
	{
		$query = "SELECT * FROM $table WHERE ";
		$where = [];
		$values = [];
		foreach ($param as $key => $value) {
			/* If numeric, preserve the format of value*/
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
		$where = implode(" AND ", $where);
		return $this->db->query($query . $where, $values)->result_array();
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
	function update_by_parameters($table, $change, $param)
	{
		$query = "UPDATE $table SET ";
		$where = [];
		$set = [];
		$values = [];
		foreach ($change as $key => $value) {
			/* If numeric, preserve the format of value*/
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
			/* If numeric, preserve the format of value*/
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
