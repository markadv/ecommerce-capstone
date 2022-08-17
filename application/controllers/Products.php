<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Products extends CI_Controller
{
	public $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Product");
		$this->load->helper("header");
		// $this->output->enable_profiler(true);
	}
	/* Home page
	Get all products (for now) then get all the products main picture.
	Load to view.
	*/
	public function index()
	{
		add_js(["home.js"]);
		add_less(["home.less"]);
		add_cdn(["swiper"]);
		$this->data = $this->session->userdata();
		$this->data["products"] = $this->Product->get_products();
		$this->data["picture_main"] = $this->Product->get_images_main();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/home");
	}
	/* Catalog
	Get all the categories.
	Get all products (for now) then get all the products main picture.
	Load to view.
	*/
	public function catalog()
	{
		add_less(["catalog.less"]);
		$this->data = $this->session->userdata();
		$this->data["products"] = $this->Product->get_products();
		$this->data["categories"] = $this->Product->get_categories();
		$this->data["picture_main"] = $this->Product->get_images_main();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/catalog");
	}
	/* Show product
	Get the product info and pictures.
	Load to view.
	*/
	public function show_product($id)
	{
		add_js(["show_product.js"]);
		add_less(["show_product.less"]);
		add_cdn(["swiper"]);
		$this->data = $this->session->userdata();
		$this->data["product"] = $this->Product->get_product_by_id($id);
		$this->data["pictures"] = explode(
			",",
			$this->Product->get_images_by_id($id)["pictures"]
		);
		$this->data["sold"] = $this->Product->get_sold($id);
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/show_product");
	}
	/* Show cart
	Make sure that cart exist before loading cart values.
	Load to view.
	*/
	public function cart()
	{
		add_less(["cart.less"]);
		add_js(["cart.js"]);
		$this->data = $this->session->userdata();
		if (isset($this->data["cart"])) {
			$cart = $this->Product->convert_cart_to_array($this->data["cart"]);
			$imagesArray = $this->Product->get_images_main_by_ids($cart);
			$this->data["picture_main"] = $this->Product->convert_two_key_array(
				$imagesArray
			);
			$this->data["products"] = $this->Product->get_products_by_ids(
				$cart
			);
		}
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/cart");
	}
	public function checkout()
	{
		$this->data = $this->session->userdata();
		if (!isset($this->data["cart"]) || empty($this->data["cart"])) {
			redirect("products/catalog");
		}
		add_js(["checkout.js"]);
		add_less(["checkout.less"]);
		$this->load->model("User");
		$cart = $this->Product->convert_cart_to_array($this->data["cart"]);
		$imagesArray = $this->Product->get_images_main_by_ids($cart);
		$this->data["picture_main"] = $this->Product->convert_two_key_array(
			$imagesArray
		);
		$this->data["products"] = $this->Product->get_products_by_ids($cart);
		if (
			isset($this->data["isLoggedIn"]) &&
			$this->data["isLoggedIn"] == 1
		) {
			$user = $this->User->get_by_parameter(
				"users",
				"email",
				$this->data["email"]
			);
			if (!empty($user["shipping_address_id"])) {
				$this->data["shipping_address"] = $this->User->get_address(
					$user["shipping_address_id"]
				)[0];
			}
			if (!empty($user["billing_address_id"])) {
				$this->data["billing_address"] = $this->User->get_address(
					$user["billing_address_id"]
				)[0];
			}
		}
		$this->data["last_name"] = $user["last_name"];
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/checkout");
	}
	/* Add items
	Retain values even in different view
	*/
	public function add_item()
	{
		$cart = $this->session->userdata("cart")
			? $this->session->userdata("cart")
			: [];
		$post = $this->input->post();
		$cartAdded[$post["product_id"]] = $post["quantity"];
		foreach ($cartAdded as $key => $value) {
			$cart[$key] = $value;
		}
		$this->session->set_userdata("cart", $cart);
		$this->input->get();
		redirect("products/cart");
	}
	/* 
	Remove items
	*/
	public function remove_item()
	{
	}
	public function process_order()
	{
		if (empty($this->input->post())) {
			redirect("products/checkout");
		}
		$validate = $this->Product->validate_order();
		if ($validate !== "success") {
			/* Add error message here */
			redirect("products/checkout");
			return;
		}
		$post = $this->input->post();
		$user = $this->session->userdata();
		$this->load->helper("products");
		//loading of model,library, and variables
		$this->load->library("stripe_lib");
		$products = $this->Product->get_all_products();
		$cart = $this->session->userdata("cart");
		$cartTotal = get_cart_table($cart, $products);
		$total = get_price_quantity($cartTotal);
		$stripe = new \Stripe\StripeClient(
			"sk_test_51LQzpALsr5tFgVvFG2WyKg2otyW8CgFZ29s70mhCCuoPUTrmxiBp3svFo4aZV9oMHhb444wIlibnP3YLSYV9sUcz00ZksqBl8b"
		);
		$token = $stripe->tokens->create([
			"card" => [
				"number" => $post["card_number"],
				"exp_month" => $post["expiration_month"],
				"exp_year" => "20" . $post["expiration_year"],
				"cvc" => $post["cvc"],
			],
		]);
		// Add customer to stripe
		$customer = $this->stripe_lib->addCustomer($post["email"], $token);
		if ($customer) {
			// Charge a credit or a debit card
			$charge = $this->stripe_lib->createCharge(
				$customer->id,
				"Various",
				$total["totalPrice"]
			);
			if (
				$charge["amount_refunded"] == 0 &&
				empty($charge["failure_code"]) &&
				$charge["paid"] == 1 &&
				$charge["captured"] == 1
			) {
				$payment_status = $charge["status"];
				$transaction_id = $charge["balance_transaction"];
				$transaction = [
					"transaction_id" => $charge["balance_transaction"],
					"paid_amount" => $charge["amount"] / 100,
					"paid_Currency" => $charge["currency"],
					"payment_status" => $payment_status,
				];
			}
		}
		$payment = ["user_id" => $user["id"], "amount" => $total["totalPrice"]];
		$this->Product->add_payment($payment, $transaction_id, $payment_status);
		$paymentId = $this->db->insert_id();
		$this->Product->add_order($payment, $paymentId);
		$orderId = $this->db->insert_id();
		foreach ($cart as $key => $value) {
			$this->Product->add_order_items($orderId, $key, $value);
		}
		$this->session->unset_userdata(["cart", "total", "cartTotal"]);
		$this->session->set_flashdata("success", $transaction);
		redirect("/products/success");
	}
	public function test()
	{
	}
}
