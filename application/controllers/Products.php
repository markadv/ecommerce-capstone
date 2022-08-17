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
		$this->load->model("User");
		$cart = $this->Product->convert_cart_to_array($this->data["cart"]);
		$imagesArray = $this->Product->get_images_main_by_ids($cart);
		$this->data["picture_main"] = $this->Product->convert_two_key_array(
			$imagesArray
		);
		$this->data["products"] = $this->Product->get_products_by_ids($cart);
		add_less(["checkout.less"]);
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
	}
	public function test()
	{
	}
}
