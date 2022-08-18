<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Vendors extends CI_Controller
{
	public $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Product");
		$this->load->model("User");
		$this->load->model("Vendor");
		$this->load->helper("header");
		$this->load->helper("products");
		$this->output->enable_profiler(true);
	}
	public function index()
	{
		redirect("vendors/orders");
	}
	public function login()
	{
		$this->check_ip();
		$this->redirect_loggedin();
		add_less(["login.less"]);
		$this->data = $this->session->userdata();
		$this->data["pageType"] = "login";
		$this->data["type"] = "admins";
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("users/login");
	}
	public function orders()
	{
		$this->check_ip();
		$this->check_role();
		add_less(["orders.less"]);
		add_js(["orders.js"]);
		$this->data = $this->session->userdata();
		$this->data["status"] = order_details_status();
		$this->data["order_details"] = $this->Vendor->get_order_details();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("vendors/orders");
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
		$this->data["picture_main"] = $this->Product->get_images_main();
		$sold = $this->Product->get_all_sold();
		$this->data["sold"] = $this->Product->convert_two_key_array_sold($sold);
		$this->data["categories"] = $this->Product->get_categories();
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->data["success"] = $this->session->flashdata("success_message");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("vendors/products_list");
	}
	public function order_view($id)
	{
		$this->check_ip();
		$this->check_role();
		add_less(["order_view.less"]);
		add_cdn(["swiper"]);
		$this->data = $this->session->userdata();
		$this->data["addresses"] = $this->Vendor->get_addresses_by_order_id(
			$id
		)[0];
		$this->data["products"] = $this->Vendor->get_products_by_order_id($id);
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("vendors/order_view");
	}
	public function delete_product()
	{
		$id = $this->input->post()["product_id"];
		$result = $this->Product->delete_product($id);
		if ($result) {
			$this->session->set_flashdata(
				"success_message",
				"Successfully deleted product."
			);
		} else {
			$this->session->set_flashdata("input_errors", $result);
		}
		redirect("vendors/products");
		var_dump($this->input->post());
	}
	public function add_product()
	{
		var_dump($this->input->post());
	}
	public function change_order_status()
	{
		$post = $this->input->post();
		$this->Vendor->change_order_status($post);
		redirect("vendors/orders");
	}
	private function check_ip()
	{
		if ($this->input->ip_address() !== "::1") {
			redirect("products");
		}
	}
	public function orders_html()
	{
		$this->data = $this->session->userdata();
		$this->data["status"] = order_details_status();
		$this->data["order_details"] = $this->Vendor->get_order_details();
		$this->load->view("partials/orders_html", $this->data);
	}
	private function check_role()
	{
		$user = $this->User->get_by_parameter(
			"users",
			"email",
			$this->session->userdata("email")
		);
		$role = $this->User->convert_hash(
			$user,
			$this->session->userdata("role")
		);
		if ($role != 1) {
			redirect("products");
		}
	}

	private function redirect_loggedin()
	{
		if ($this->session->userdata("is_logged_in") == 1) {
			redirect("vendors");
			return;
		}
	}
}
