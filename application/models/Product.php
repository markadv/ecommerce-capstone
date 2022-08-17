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
	function get_images_by_ids($idArr)
	{
		$results = [];
		foreach ($idArr as $value) {
			$results[$value] = explode(
				",",
				$this->get_images_by_id($value)["pictures"]
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
