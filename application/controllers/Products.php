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
		$this->load->helper("main");
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
		$this->data["title"] = "Baby Secret Shop";
		$this->data["feature"] = $this->Product->get_products_home(30);
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
		add_js(["catalog.js"]);
		$this->data = $this->session->userdata();
		$this->data["title"] = "Baby Secret Shop Catalog";
		$this->data["categories"] = $this->Product->get_categories();
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->data["success"] = $this->session->flashdata("success_message");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/catalog");
	}
	public function catalog_html()
	{
		$this->data["products"] = $this->Product->get_products_by_filter(
			$this->input->post()
		);
		$this->data["picture_main"] = $this->Product->get_images_main();
		$this->load->view("partials/catalog_html", $this->data);
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
		$this->data["title"] = "Baby Secret Shop Product";
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
		$this->data["title"] = "Baby Secret Shop Cart";
		if (isset($this->data["cart"]) && !empty($this->data["cart"])) {
			$cart = get_cart_keys($this->data["cart"]);
			$imagesArray = $this->Product->get_images_main_by_ids($cart);
			$this->data["picture_main"] = convert_two_key_array($imagesArray);
			$this->data["products"] = $this->Product->get_products_by_ids(
				$cart
			);
		}
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/cart");
	}
	/*  Checkout page for cart. First check if there are items inside
	the cart. Then load all the product information. After than, check
	if user is logged in to provide form value.
	*/
	public function checkout()
	{
		$this->data = $this->session->userdata();
		if (!isset($this->data["cart"]) || empty($this->data["cart"])) {
			redirect("catalog");
		}
		add_js(["checkout.js"]);
		add_less(["checkout.less"]);
		$this->data["title"] = "Baby Secret Shop Checkout";
		$this->load->model("User");
		$cart = get_cart_keys($this->data["cart"]);
		$imagesArray = $this->Product->get_images_main_by_ids($cart);
		$this->data["picture_main"] = convert_two_key_array($imagesArray);
		$this->data["products"] = $this->Product->get_products_by_ids($cart);
		if (
			isset($this->data["is_logged_in"]) &&
			$this->data["is_logged_in"] == 1
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
			$this->data["last_name"] = $user["last_name"];
		}
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->data["success"] = $this->session->flashdata("success_message");
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
		redirect("cart");
	}
	/* 
	Remove items
	*/
	public function remove_item($id)
	{
		$cart = $this->session->userdata("cart");
		unset($cart[$id]);
		$this->session->set_userdata("cart", $cart);
		redirect("cart");
	}
	public function process_order()
	{
		if (empty($this->input->post())) {
			redirect("checkout");
			return;
		}
		$result = $this->Product->validate_order();
		if ($result !== "success") {
			/* Add error message here */
			$this->session->set_flashdata("input_errors", $result);
			redirect("checkout");
			return;
		}
		$shipping_fee = 100;
		$this->load->model("User");
		$this->load->library("stripe_library");
		$post = $this->input->post();
		$user = $this->session->userdata();
		$cart = $user["cart"];
		$user_id =
			$user["is_logged_in"] == 1
				? $this->User->get_by_parameter(
					"users",
					"email",
					$user["email"]
				)["id"]
				: ($user_id = null);
		/* Get prices thru database */
		$cart_keys = get_cart_keys($cart);
		$products = $this->Product->get_products_by_ids($cart_keys);
		// $cartTotal = get_cart_table($cart, $products);
		$total = get_total_price($cart, $products) + $shipping_fee;
		$stripe = new \Stripe\StripeClient(
			"sk_test_51LQzpALsr5tFgVvFG2WyKg2otyW8CgFZ29s70mhCCuoPUTrmxiBp3svFo4aZV9oMHhb444wIlibnP3YLSYV9sUcz00ZksqBl8b"
		);
		$token = $stripe->tokens->create([
			"card" => [
				"number" => $post["card_number"],
				"exp_month" => $post["expiration_month"],
				"exp_year" => $post["expiration_year"],
				"cvc" => $post["cvc"],
			],
		]);
		/* Add customer to stripe. You can add more info but for simplicity sake,
		 I will be using the email only. */
		$customer = $this->stripe_library->addCustomer($post["email"], $token);
		if ($customer) {
			// Charge a credit or a debit card
			$charge = $this->stripe_library->createCharge(
				$customer->id,
				"Various",
				$total
			);
			/* Check this to know if success or fail */
			if (
				$charge["amount_refunded"] == 0 &&
				empty($charge["failure_code"]) &&
				$charge["paid"] == 1 &&
				$charge["captured"] == 1
			) {
				/* success or fail message */
			}
		}
		$transaction_message = create_transaction_message($charge);
		/* Add payment info to db */
		$payments = create_payment($charge);
		$payment_id = $this->Product->add_payment($payments);
		/* Add payment shipping address to db */
		$shipping_address = create_shipping_address($post);
		$shipping_address_id = $this->User->create_address(
			$shipping_address,
			1
		);
		$shipping_id = $this->Product->add_shipping(
			$shipping_address_id,
			$shipping_fee,
			$post
		);
		/* Add payment biling address to db */
		$billing_address = create_billing_address($post);
		$billing_address_id = $this->User->create_address($billing_address, 2);
		$billing_id = $this->Product->add_billing($billing_address_id, $post);
		$order_details_id = $this->Product->add_order_details(
			$payment_id,
			$billing_id,
			$shipping_id,
			$user_id,
			$total,
			$user["is_logged_in"]
		);
		foreach ($cart as $key => $value) {
			$this->Product->add_order_items($key, $value, $order_details_id);
		}
		/* Extra miles history
		$result = $this->Product->get_order_details_json()
		 */
		$this->session->unset_userdata("cart");
		$this->session->set_flashdata("success_message", $transaction_message);
		redirect("catalog");
	}
	function test()
	{
		var_dump($this->Product->get_categories());
	}
}
