<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Product extends CI_Model
{
	function get_product_by_id($id)
	{
		$cleanId = $this->security->xss_clean($id);
		$query = "SELECT products.* , inventories.quantity, categories.name as category
                FROM products
				LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id
				WHERE products.id = $cleanId";
		return $this->db->query($query)->result_array()[0];
	}
	function get_products_by_ids($idArr)
	{
		$cleanIdArr = implode(",", $this->security->xss_clean($idArr));
		$query = "SELECT products.* , inventories.quantity, categories.name as category
                FROM products
				LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id
				WHERE products.id IN ($cleanIdArr)";
		return $this->db->query($query)->result_array();
	}
	function get_products()
	{
		$query = "SELECT products.* , inventories.quantity, categories.name as category
				FROM products
                LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id";
		return $this->db->query($query)->result_array();
	}
	function get_images_by_id($id)
	{
		$query = "SELECT (SELECT GROUP_CONCAT(images.url  SEPARATOR ',')) AS pictures
                FROM images
                LEFT JOIN products ON images.product_id=products.id
				WHERE products.id=$id";
		return $this->db->query($query)->result_array()[0];
	}
	/* test */
	function get_images_by_ids($idArr)
	{
		$results = [];
		foreach ($idArr as $value) {
			$results[$value] = explode(
				",",
				$this->get_images_main($value)["pictures"]
			);
		}
		return $results;
	}
	function get_images_main()
	{
		$query = "SELECT products.id, images.url FROM images
                LEFT JOIN products ON images.product_id=products.id
				WHERE images.is_main = 1";
		$result = $this->db->query($query)->result_array();
		// return $result;
		return $this->convert_two_key_array($result);
	}
	function get_images_main_by_ids($idArr)
	{
		$cleanIdArr = implode(",", $this->security->xss_clean($idArr));
		$query = "SELECT products.id, images.url FROM images
                LEFT JOIN products ON images.product_id=products.id
				WHERE images.is_main = 1 AND products.id IN ($cleanIdArr)";
		$result = $this->db->query($query)->result_array();
		return $result;
		// return $this->convert_two_key_array($result);
	}
	/* Get all images */
	function get_images()
	{
		$query = "SELECT products.id (SELECT GROUP_CONCAT(images.url  SEPARATOR ',') WHERE images.is_main = 0) AS img_arr,
                (SELECT images.url WHERE images.is_main = 1) AS img_main,
                FROM images
                LEFT JOIN products ON images.product_id=products.id";
		return $this->db->query($query)->result_array();
	}
	function get_categories()
	{
		$query = "SELECT categories.name, COUNT(category_id) AS count FROM categories
                LEFT JOIN products ON categories.id=products.category_id
                GROUP BY categories.id";
		return $this->db->query($query)->result_array();
	}

	function get_sold($id)
	{
		$query = "SELECT SUM(quantity) as sold
                FROM order_items
				WHERE product_id=$id";
		$result = $this->db->query($query)->result_array();
		return $result[0]["sold"];
	}
	function validate_order()
	{
		$this->form_validation->set_error_delimiters("<div>", "</div>");
		$this->form_validation->set_rules(
			"address1_shipping",
			"Address line 1 shipping",
			"trim|required|min_length[3]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"address2_shipping",
			"Address line 2 shipping",
			"trim|min_length[3]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"city_shipping",
			"City shipping",
			"trim|required|min_length[3]|max_length[46]|alpha_numeric_spaces"
		);
		$this->form_validation->set_rules(
			"state_shipping",
			"State shipping",
			"trim|required|min_length[3]|max_length[46]|alpha_numeric_spaces"
		);
		$this->form_validation->set_rules(
			"postal_code_shipping",
			"Postal code shipping",
			"trim|required|exact_length[4]|numeric"
		);
		$this->form_validation->set_rules(
			"address1_billing",
			"Address line 1 billing",
			"trim|required|min_length[3]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"address2_billing",
			"Address line 2 billing",
			"trim|min_length[3]|max_length[256]"
		);
		$this->form_validation->set_rules(
			"city_billing",
			"City billing",
			"trim|required|min_length[3]|max_length[46]|alpha_numeric_spaces"
		);
		$this->form_validation->set_rules(
			"state_billing",
			"State billing",
			"trim|required|min_length[3]|max_length[46]|alpha_numeric_spaces"
		);
		$this->form_validation->set_rules(
			"postal_code_billing",
			"Postal code billing",
			"trim|required|exact_length[4]|numeric"
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
			"email",
			"Email",
			"trim|required|valid_email|max_length[256]"
		);
		$this->form_validation->set_rules(
			"card_number",
			"Card Number",
			"trim|required|exact_length[16]|numeric"
		);
		$this->form_validation->set_rules(
			"cvc",
			"CVC",
			"trim|required|exact_length[3]|numeric"
		);
		$this->form_validation->set_rules(
			"expiration_month",
			"Expiration month",
			"trim|required|exact_length[2]|is_list[01,02,03,04,05,06,07,08,09,10,11,12]"
		);
		$this->form_validation->set_rules(
			"expiration_year",
			"Expiration year",
			"trim|required|exact_length[4]"
		);
	}
	function convert_two_key_array($array)
	{
		$newArr = [];
		foreach ($array as $row) {
			$newArr[$row["id"]] = $row["url"];
		}
		return $newArr;
	}
	function convert_cart_to_array($cart)
	{
		$arr = [];
		foreach ($cart as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}
}
