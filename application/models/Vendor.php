<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendor extends CI_Model
{
	function get_order_details_dashboard()
	{
		$query = "SELECT order_details.*, billings.first_name,
                CONCAT_WS(',',addresses.address1,addresses.address2,addresses.city,addresses.state,addresses.postal_code)
                AS address
                FROM billings
                LEFT JOIN order_details ON billings.id = order_details.billing_id
                LEFT JOIN addresses ON billings.billing_address_id = addresses.id
                GROUP BY billing_id";
		return $this->db->query($query)->result_array();
	}
}
