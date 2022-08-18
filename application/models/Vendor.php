<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendor extends CI_Model
{
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
}
