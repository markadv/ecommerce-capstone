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
	public function index()
	{
		add_js(["home.js"]);
		add_less(["home.less"]);
		add_cdn(["swiper"]);
		$this->data = $this->session->userdata();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/home");
	}
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
	public function show_product($id)
	{
		add_js(["show_product.js"]);
		add_less(["show_product.less"]);
		add_cdn(["swiper"]);
		$this->data = $this->session->userdata();
		$this->data["product"] = $this->Product->get_product_by_id($id);
		$this->data["pictures"] = $this->Product->get_images_by_id($id);
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("products/show_product");
	}
	public function test()
	{
		var_dump($this->Product->get_product_by_id(1));
	}
}
