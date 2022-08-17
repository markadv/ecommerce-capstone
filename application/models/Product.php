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
				WHERE products.id = $cleanId && products.active=1";
		return $this->db->query($query)->result_array()[0];
	}
	function get_products_by_ids($idArr)
	{
		$cleanIdArr = implode(",", $this->security->xss_clean($idArr));
		$query = "SELECT products.* , inventories.quantity, categories.name as category
                FROM products
				LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id
				WHERE products.id IN ($cleanIdArr) && products.active=1";
		return $this->db->query($query)->result_array();
	}
	function get_products()
	{
		$query = "SELECT products.* , inventories.quantity, categories.name as category
				FROM products
                LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id
				WHERE products.active=1";
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
	function get_all_sold()
	{
		$query = "SELECT product_id, SUM(quantity) as sold
                FROM order_items
				GROUP BY product_id";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	function add_order_details(
		$payment_id,
		$billing_id,
		$shipping_id,
		$user_id,
		$total,
		$is_logged_in
	) {
		$clean_payment_id = $this->security->xss_clean($payment_id);
		$clean_billing_id = $this->security->xss_clean($billing_id);
		$clean_shipping_id = $this->security->xss_clean($shipping_id);
		$clean_user_id = $this->security->xss_clean($user_id);
		$clean_total = $this->security->xss_clean($total);
		$clean_is_logged_in = $this->security->xss_clean($is_logged_in);
		$query = "INSERT INTO order_details (payment_id, billing_id, shipping_id, user_id, status, total, is_logged_in)
		VALUES ($clean_payment_id,$clean_billing_id,$clean_shipping_id,$clean_user_id,'Order in process',$clean_total,$clean_is_logged_in)";
		$this->db->query($query);
		return $this->db->insert_id();
	}
	function add_order_items($id, $quantity, $order_details_id)
	{
		$clean_id = $this->security->xss_clean($id);
		$clean_quantity = $this->security->xss_clean($quantity);
		$clean_order_details_id = $this->security->xss_clean($order_details_id);
		$query = "INSERT INTO order_items (product_id, order_detail_id, quantity)
		VALUES ($clean_id,$clean_quantity,$clean_order_details_id)";
		$this->db->query($query);
		return $this->db->insert_id();
	}
	function get_order_details_json()
	{
	}
	function add_order_histories()
	{
	}
	function add_payment($payments)
	{
		$clean_payments = $this->security->xss_clean($payments);
		$query = "INSERT INTO payments (transaction_id, amount, provider, status)
		VALUES (?,?,?,?)";
		$this->db->query($query, $clean_payments);
		return $this->db->insert_id();
	}
	function add_shipping($id, $fee, $post)
	{
		$clean_id = $this->security->xss_clean($id);
		$clean_fee = $this->security->xss_clean($fee);
		$query = "INSERT INTO shippings (shipping_address_id, first_name, last_name, amount, shipping_company, status)
		VALUES ($clean_id,?,?,$clean_fee,?,?)";
		$values = [
			$this->security->xss_clean($post["first_name_shipping"]),
			$this->security->xss_clean($post["last_name_shipping"]),
			"Default",
			"Order in process",
		];
		$this->db->query($query, $values);
		return $this->db->insert_id();
	}
	function add_billing($id, $post)
	{
		$clean_id = $this->security->xss_clean($id);
		$query = "INSERT INTO billings (billing_address_id, first_name, last_name)
		VALUES ($clean_id,?,?)";
		$values = [
			$this->security->xss_clean($post["first_name_billing"]),
			$this->security->xss_clean($post["last_name_billing"]),
		];
		$this->db->query($query, $values);
		return $this->db->insert_id();
	}
	function delete_product($id)
	{
		$query =
			"UPDATE products SET active = 0, deleted_at = NOW() WHERE ID = ?";
		$value = $this->security->xss_clean($id);
		return $this->db->query($query, $value);
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
			"first_name_shipping",
			"First Name in shipping",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"last_name_shipping",
			"Last Name in shipping",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"first_name_billing",
			"First Name in billing",
			"trim|required|min_length[3]|max_length[46]"
		);
		$this->form_validation->set_rules(
			"last_name_billing",
			"Last Name in billing",
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
			"trim|required|exact_length[2]|in_list[01,02,03,04,05,06,07,08,09,10,11,12]"
		);
		$this->form_validation->set_rules(
			"expiration_year",
			"Expiration year",
			"trim|required|exact_length[4]"
		);
		if (!$this->form_validation->run()) {
			return validation_errors();
		} else {
			return "success";
		}
	}
	/* transfer to helper */
	function convert_two_key_array($array)
	{
		$newArr = [];
		foreach ($array as $row) {
			$newArr[$row["id"]] = $row["url"];
		}
		return $newArr;
	}
	function convert_two_key_array_sold($array)
	{
		$newArr = [];
		foreach ($array as $row) {
			$newArr[$row["product_id"]] = $row["sold"];
		}
		return $newArr;
	}
	function get_cart_keys($cart)
	{
		$arr = [];
		foreach ($cart as $key => $value) {
			array_push($arr, $key);
		}
		return $arr;
	}
}
