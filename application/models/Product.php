<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Product extends CI_Model
{
	function get_product_by_id()
	{
	}
	function get_products()
	{
		$query = "SELECT products.* , inventories.quantity, categories.name as category,
                orderItems.quantity AS sold FROM products
                LEFT JOIN inventories ON products.inventory_id=inventories.id
                LEFT JOIN categories ON products.category_id=categories.id
                LEFT JOIN orderItems ON products.id=orderItems.product_id";
		return $this->db->query($query)->result_array();
	}
	function get_pictures()
	{
		$query = "SELECT products.id (SELECT GROUP_CONCAT(images.url  SEPARATOR ',') WHERE images.IsMain = 0) AS img_arr,
                (SELECT images.url WHERE images.IsMain = 1) AS img_main,
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
	function get_pictures_main()
	{
		$query = "SELECT products.id, images.url FROM images
                LEFT JOIN products ON images.product_id=products.id
				WHERE images.IsMain = 1";
		$result = $this->db->query($query)->result_array();
		// return $result;
		return $this->convert_two_key_array($result);
	}
	function convert_two_key_array($array)
	{
		$newArr = [];
		foreach ($array as $row) {
			$newArr[$row["id"]] = $row["url"];
		}
		return $newArr;
	}
}
