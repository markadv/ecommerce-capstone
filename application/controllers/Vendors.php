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
		$this->check_ip();
		$this->check_role();
		add_less(["dashboard.less"]);
		$this->data = $this->session->userdata();
		$this->data["status"] = order_details_status();
		$this->data[
			"order_details"
		] = $this->Vendor->get_order_details_dashboard();
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("vendors/dashboard");
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
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->data["success"] = $this->session->flashdata("success_message");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_admin");
		$this->load->view("partials/product_modal");
		$this->load->view("vendors/products_list");
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
		var_dump($result);
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
	public function test()
	{
		var_dump($this->Vendor->get_order_details_dashboard());
	}
}
