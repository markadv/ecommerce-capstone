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
		$this->output->enable_profiler(true);
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
		$this->load->view("products/home", $this->data);
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
		$this->load->view("partials/nav_user", $this->data);
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
		$this->load->view("partials/nav_user", $this->data);
		$this->load->view("products/show_product");
	}
	public function cart()
	{
		add_less(["cart.less"]);
		$this->data = $this->session->userdata();
		$cart = $this->Product->convert_cart_to_array($this->data["cart"]);
		$this->data["products"] = $this->Product->get_products_by_ids($cart);
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user", $this->data);
		$this->load->view("products/cart");
	}
	public function add_cart()
	{
		$cart = $this->session->userdata("cart")
			? $this->session->userdata("cart")
			: [];
		$post = $this->input->post();
		$cartAdded[$post["product_id"]] = $post["quantity"];
		foreach ($cartAdded as $key => $value) {
			if (!isset($cart[$key])) {
				$cart[$key] = $value;
			} else {
				$cart[$key] += $value;
			}
		}
		$this->session->set_userdata("cart", $cart);
		$this->input->get();
		redirect("products/catalog");
	}
	public function test()
	{
		$result = $this->Product->convert_cart_to_array(
			$this->session->userdata("cart")
		);
		var_dump($this->Product->get_images_by_ids($result));
		// var_dump($this->Product->get_images_by_id(1));
	}
}
