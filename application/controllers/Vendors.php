<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendors extends CI_Controller
{
	public $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Vendor");
		$this->load->helper("header");
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
		add_less(["admin_products.less"]);
		add_cdn(["jqueryui"]);
		add_js(["products_list.js"]);
		$this->data = $this->session->userdata();
		$this->data["products"] = $this->Vendor->get_products();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("partials/add_modal");
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
		var_dump($this->Vendor->get_products());
	}
	public function process_login()
	{
		$this->check_ip();
		$this->check_post("login");
		$result = $this->Vendor->validate_login();
		if ($result != "success") {
			$this->session->set_flashdata("input_errors", $result);
		} else {
			$email = $this->input->post("email");
			$user = $this->Vendor->get_by_parameters("users", [
				"email" => ["=", $email],
				"role_id" => ["=", 1],
			])[0];
			$result = $this->Vendor->validate_login_match(
				$user,
				$this->input->post("password")
			);

			if ($result == "success") {
				$session_data = $this->Vendor->profile_array($user);
				$this->session->set_userdata($session_data);
				redirect("admins");
				return;
			} else {
				$this->session->set_flashdata("input_errors", $result);
			}
		}
		redirect("vendors/login");
	}
	private function check_ip()
	{
		if ($this->input->ip_address() !== "::1") {
			redirect("users");
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
