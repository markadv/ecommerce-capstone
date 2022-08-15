<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Admins extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Admin");
		$this->load->helper("header");
	}
	public function index()
	{
		add_less(["home.less"]);
		$data = $this->session->userdata();
		$this->load->view("partials/head", $data);
		$this->load->view("partials/nav_admin");
		$this->load->view("admins/dashboard");
	}
	public function products()
	{
		add_less(["admin_products.less"]);
		$data = $this->session->userdata();
		$this->load->view("partials/head", $data);
		$this->load->view("partials/nav_admin");
		$this->load->view("admins/admin_products");
	}
	public function order_view()
	{
		add_js(["home.js"]);
		add_less(["home.less"]);
		add_cdn(["swiper"]);
		$data = $this->session->userdata();
		$this->load->view("partials/head", $data);
		$this->load->view("partials/nav_admin");
		$this->load->view("admins/order_view");
	}
}
