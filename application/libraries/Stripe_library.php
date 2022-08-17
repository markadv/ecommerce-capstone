<?php
defined("BASEPATH") or exit("No direct script access allowed");
/*
Simple library for stripe. Do not use for production.
By Markad
*/
class Stripe_library
{
	var $CI;
	var $api_error;

	function __construct()
	{
		$this->api_error = "";
		$this->CI = &get_instance();
		$this->CI->load->config("stripe");

		// Include the Stripe PHP bindings library
		require APPPATH . "third_party/stripe-php/init.php";

		// Set API key
		\Stripe\Stripe::setApiKey($this->CI->config->item("stripe_api_key"));
	}

	function addCustomer($email, $token)
	{
		try {
			// Add customer to stripe
			$customer = \Stripe\Customer::create([
				"email" => $email,
				"source" => $token,
			]);
			return $customer;
		} catch (Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
	}

	function createCharge($customerId, $itemName, $itemPrice)
	{
		// Convert price to cents
		$itemPriceCents = $itemPrice * 100;
		$currency = $this->CI->config->item("stripe_currency");

		try {
			// Charge a credit or a debit card
			$charge = \Stripe\Charge::create([
				"customer" => $customerId,
				"amount" => $itemPriceCents,
				"currency" => $currency,
				"description" => $itemName,
			]);

			// Retrieve charge details
			$chargeJson = $charge->jsonSerialize();
			return $chargeJson;
		} catch (Exception $e) {
			$this->api_error = $e->getMessage();
			return false;
		}
	}
}
