<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendor extends CI_Model
{
	function get_order_details_by_filter($get)
	{
		$clean_get = $this->security->xss_clean($get);
		/* get back later */
		// $search = !empty($clean_get["search"])
		// 	? "WHERE billings.first_name LIKE %" . $clean_get["search"] . "%"
		// 	: "WHERE billings.first_name LIKE %%";

		$filter = !empty($clean_get["filter"] && $clean_get["filter"] !== 0)
			? "WHERE order_details.status = " . $clean_get["filter"]
			: "";
		$query = "SELECT order_details.*, billings.first_name, billings.last_name,
                CONCAT_WS(',',addresses.address1,addresses.address2,addresses.city,addresses.state,addresses.postal_code) AS address
                FROM billings
                LEFT JOIN order_details
					ON billings.id = order_details.billing_id
                LEFT JOIN addresses
					ON billings.billing_address_id = addresses.id
                $filter
				GROUP BY billing_id";
		return $this->db->query($query)->result_array();
	}
	function get_order_details()
	{
		$query = "SELECT order_details.*, billings.first_name, billings.last_name,
                CONCAT_WS(',',addresses.address1,addresses.address2,addresses.city,addresses.state,addresses.postal_code) AS address
                FROM billings
                LEFT JOIN order_details ON billings.id = order_details.billing_id
                LEFT JOIN addresses ON billings.billing_address_id = addresses.id
                GROUP BY billing_id";
		return $this->db->query($query)->result_array();
	}
	function change_order_status($post)
	{
		$id = $this->security->xss_clean($post["order_id"]);
		$status = $this->security->xss_clean($post["order_status"]);
		$query = "UPDATE order_details SET status = $status WHERE id = $id";
		return $this->db->query($query);
	}
	function update_category_table($categories)
	{
		$clean_categories = $this->security->xss_clean($categories);
		$results = [];
		foreach ($clean_categories as $key => $value) {
			$query = "INSERT INTO categories (id,name)
				VALUES ($key,?)
				ON DUPLICATE KEY UPDATE
					name=?";
			$values = [$value, $value];
			array_push($results, $this->db->query($query, $values));
		}
		return $results;
	}
	function get_addresses_by_order_id($id)
	{
		$id = $this->security->xss_clean($id);
		$query = "SELECT order_details.id as order_id, shippings.first_name AS s_first_name, shippings.last_name AS s_last_name,
				billings.first_name AS b_first_name, billings.last_name AS b_last_name, order_details.status,
				s.address1 AS s_address1, s.address2 AS s_address2, s.city AS s_city, s.state AS s_state, s.postal_code AS s_postal_code,
                b.address1 AS b_address1, b.address2 AS b_address2, b.city AS b_city, b.state AS b_state, b.postal_code AS b_postal_code,
                order_details.status
                FROM order_details
                LEFT JOIN shippings ON order_details.shipping_id = shippings.id
                LEFT JOIN addresses AS s ON shippings.shipping_address_id = s.id 
                LEFT JOIN billings ON order_details.billing_id = billings.id
                LEFT JOIN addresses AS b ON billings.billing_address_id = b.id 
                WHERE order_details.id = $id";
		return $this->db->query($query)->result_array();
	}
	function get_products_by_order_id($id)
	{
		$id = $this->security->xss_clean($id);
		$query = "SELECT *
                FROM order_items
                LEFT JOIN products ON order_items.product_id = products.id
                WHERE order_items.order_detail_id = $id";
		return $this->db->query($query)->result_array();
	}
	function delete_category()
	{
	}
	function update_product($post)
	{
		$query = "UPDATE products SET name=?,description=?,category_id=?,price=?
			WHERE id=?";
		$values = [
			$post["name"],
			$post["description"],
			$post["category-selected"],
			$post["price"],
			$post["product_id"],
		];
		return $this->db->query($query, $values);
	}
	function add_update_product($post)
	{
		$query = "INSERT INTO products (id,name,description,category_id,price,inventory_id,brand_id,active)
			VALUES (?,?,?,?,?,?,?,?)
			ON DUPLICATE KEY UPDATE
				name=?, description=?,category_id=?,price=?";
		$values = [
			$post["product_id"],
			$post["name"],
			$post["description"],
			$post["category-selected"],
			$post["price"],
			$post["product_id"],
			1,
			1,
			$post["name"],
			$post["description"],
			$post["category-selected"],
			$post["price"],
		];
		$this->db->query($query, $values);
		if (!empty($this->db->insert_id())) {
			$id = $this->db->insert_id();
		}
		if ($this->db->affected_rows() > 0 && !empty($this->db->insert_id())) {
			$id = $this->db->insert_id();
			$query2 = "UPDATE products SET inventory_id = $id WHERE id = $id";
			$this->db->query($query2);
		}
		return $id;
	}
	function add_update_inventory($post, $id)
	{
		$clean_id = $this->security->xss_clean($id);
		$clean_post = $this->security->xss_clean($post);
		$query = "INSERT INTO inventories (id,quantity)
				VALUES ($clean_id,?)
				ON DUPLICATE KEY UPDATE
					quantity=?";
		$values = [$clean_post["stocks"], $clean_post["stocks"]];
		return $this->db->query($query, $values);
	}
	function add_image($params)
	{
		foreach ($params as $key => $value) {
			$query =
				"INSERT INTO images (product_id,url,is_main) VALUES (?,?,1)";
			$values = [$key, $value];
			$this->db->query($query, $values);
		}
	}
	function get_all_images()
	{
		$query = "SELECT products.id, GROUP_CONCAT(images.url)as images
                FROM products
                LEFT JOIN images ON products.id=images.product_id
				GROUP BY products.id";
		return $this->db->query($query)->result_array();
	}
}
