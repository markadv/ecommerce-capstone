<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendors extends CI_Controller
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
		$this->check_ip();
		$this->check_role();
		add_less(["home.less"]);
		$data = $this->session->userdata();
		$this->load->view("partials/head", $data);
		$this->load->view("partials/nav_admin");
		$this->load->view("vendors/dashboard");
	}
	public function login()
	{
		$this->check_ip();
		add_less(["login.less"]);
		$this->data = $this->session->userdata();
		$this->data["pageType"] = "login";
		$this->data["type"] = "admins";
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("users/login");
	}
	public function products()
	{
		$this->check_ip();
		$this->check_role();
		add_less(["products_list.less"]);
		add_cdn(["jqueryui"]);
		add_js(["products_list.js"]);
		$this->data = $this->session->userdata();
		$this->data["products"] = $this->Product->get_products();
		$this->data["picture_main"] = $this->Product->get_pictures_main();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("partials/product_modal");
		$this->load->view("vendors/products_list", $this->data);
	}
	public function order_view()
	{
		$this->check_ip();
		$this->check_role();
		add_js(["home.js"]);
		add_less(["home.less"]);
		add_cdn(["swiper"]);
		$this->data = $this->session->userdata();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("vendors/order_view");
	}
	public function test()
	{
		var_dump($this->Vendor->get_pictures_main());
	}
	private function check_ip()
	{
		if ($this->input->ip_address() !== "::1") {
			redirect("products");
		}
	}
	private function check_post($previous_url)
	{
		if (!$this->input->post()) {
			redirect("vendors/$previous_url");
			return;
		}
	}
	private function check_role()
	{
		if ($this->session->userdata("role") != 1) {
			redirect("products");
		}
	}
}
