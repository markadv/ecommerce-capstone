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
		$this->load->helper("main");
		$this->output->enable_profiler(true);
	}
	public function index()
	{
		redirect("vendors/orders");
	}
	public function login()
	{
		$this->redirect_loggedin();
		add_less(["login.less"]);
		$this->data = $this->session->userdata();
		$this->data["title"] = "Vendor login";
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
		$this->data["title"] = "Vendor orders";
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
		$this->data["title"] = "Vendor products";
		$this->data["all_images"] = convert_images_string(
			$this->Vendor->get_all_images()
		);
		$this->data["products"] = $this->Product->get_products_limit(30);
		$this->data["picture_main"] = $this->Product->get_images_main();
		$sold = $this->Product->get_all_sold();
		$this->data["sold"] = convert_two_key_array_sold($sold);
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
		$this->data["title"] = "Vendor order";
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
		if (empty($this->input->post())) {
			redirect("products/list");
		}
		$post = $this->input->post();
		/* Get all category and create id=>value pair*/
		$categories = convert_categories($post);
		/* change all the category values based on latest submit */
		$this->Vendor->update_category_table($categories);
		/* Check if add or edit
		If with product_id, then is is edit.
		*/
		$insert_id = $this->Vendor->add_update_product($post);
		$inventory_id = !empty($post["product_id"])
			? $post["product_id"]
			: $insert_id;
		$this->upload($inventory_id);
		$result_inventory = $this->Vendor->add_update_inventory(
			$post,
			$inventory_id
		);
		/* old version in case not allowed */
		// if (!empty($post["product_id"])) {
		// 	$result_products = $this->Vendor->update_product($post);
		// 	$result_inventory = $this->Vendor->update_inventory($post);
		// } else {
		// }
		redirect("products/list");
	}
	public function change_order_status()
	{
		$get = $this->input->get();
		$this->Vendor->change_order_status($get);
		redirect("orders");
	}
	private function check_ip()
	{
		if ($this->input->ip_address() !== "::1") {
			redirect("products");
		}
	}
	private function upload($id)
	{
		$this->load->library("upload");
		$imagePath = realpath(APPPATH . "../assets/imgs");
		$number_of_files_uploaded = count($_FILES["files"]["name"]);

		for ($i = 0; $i < $number_of_files_uploaded; $i++) {
			$_FILES["userfile"]["name"] = $_FILES["files"]["name"][$i];
			$_FILES["userfile"]["type"] = $_FILES["files"]["type"][$i];
			$_FILES["userfile"]["tmp_name"] = $_FILES["files"]["tmp_name"][$i];
			$_FILES["userfile"]["error"] = $_FILES["files"]["error"][$i];
			$_FILES["userfile"]["size"] = $_FILES["files"]["size"][$i];
			//configuration for upload your images
			$config = [
				"file_name" => time() . uniqid(),
				"allowed_types" => "jpg|jpeg|png|gif",
				"max_size" => 0,
				"overwrite" => false,
				"upload_path" => $imagePath,
			];
			$this->upload->initialize($config);
			$errCount = 0; //counting errrs
			if (!$this->upload->do_upload()) {
				$error = ["error" => $this->upload->display_errors()];
				$theImages[] = [
					"errors" => $error,
				]; //saving arrors in the array
			} else {
				$filename = $this->upload->data();
				$theImages[] = [
					"fileName" => $filename["file_name"],
				];
				$params = [$id => $filename["file_name"]];
				$this->Vendor->add_image($params);
			} //if file uploaded
		} //for loop end
	}
	public function orders_html()
	{
		$get = $this->input->get();
		$this->data["status"] = order_details_status();
		$this->data[
			"order_details"
		] = $this->Vendor->get_order_details_by_filter($get);
		$this->load->view("partials/orders_html", $this->data);
	}
	private function check_role()
	{
		$user = $this->User->get_by_parameter(
			"users",
			"email",
			$this->session->userdata("email")
		);
		$role = convert_hash($user, $this->session->userdata("role"));
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
