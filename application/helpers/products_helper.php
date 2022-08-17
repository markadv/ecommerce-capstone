<?php
defined("BASEPATH") or exit("No direct script access allowed");
function get_total_price($cart, $products)
{
	$total_price = 0;
	foreach ($products as $row) {
		$total_price += $cart[$row["id"]] * $row["price"];
	}
	return $total_price;
}
function create_transaction_message($charge)
{
	$transaction_message = [
		"transaction_id" => $charge["balance_transaction"],
		"paid_amount" => $charge["amount"] / 100,
		"paid_Currency" => $charge["currency"],
		"payment_status" => $charge["status"],
		"receipt_url" => $charge["receipt_url"],
	];
	return $transaction_message;
}
function create_payment($charge)
{
	$payments = [
		$charge["balance_transaction"],
		$charge["amount"] / 100,
		"stripe",
		$charge["status"],
	];
	return $payments;
}
function create_shipping_address($post)
{
	$shipping = [
		"address1" => $post["address1_shipping"],
		"address2" => $post["address2_shipping"],
		"city" => $post["city_shipping"],
		"state" => $post["state_shipping"],
		"postal_code" => $post["postal_code_shipping"],
	];
	return $shipping;
}
function create_billing_address($post)
{
	$billing = [
		"address1" => $post["address1_billing"],
		"address2" => $post["address2_billing"],
		"city" => $post["city_billing"],
		"state" => $post["state_billing"],
		"postal_code" => $post["postal_code_billing"],
	];
	return $billing;
}
