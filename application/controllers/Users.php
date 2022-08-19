<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Users extends CI_Controller
{
	/* Data variable to create uniformity to data passed to view */
	public $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model("User");
		$this->load->helper("header");
		$this->load->helper("main");
	}
	public function index()
	{
		redirect("products");
	}
	public function login()
	{
		$this->redirect_loggedin();
		add_less(["login.less"]);
		$this->data = $this->session->userdata();
		$this->data["title"] = "Baby Secret Shop Login";
		$this->data["pageType"] = "login";
		$this->data["type"] = "users";
		$this->data["errors"] = $this->session->flashdata("input_errors");
		/* View section */
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/login");
	}
	public function register()
	{
		$this->redirect_loggedin();
		add_less(["register.less"]);
		$this->data = $this->session->userdata();
		$this->data["title"] = "Baby Secret Shop Register";
		$this->data["pageType"] = "register";
		$this->data["type"] = "users";
		/* Error */
		$this->data["errors"] = $this->session->flashdata("input_errors");
		/* View adding head, nav, and main */
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/register");
	}
	public function profile()
	{
		$this->redirect_loggedout();
		add_less(["profile.less"]);
		add_js(["profile.js"]);
		$this->data = $this->session->userdata();
		$this->data["title"] = "Baby Secret Shop Profile";
		/* Get all info*/
		$email = $this->session->userdata("email");
		$user = $this->User->get_by_parameter("users", "email", $email);
		if (!empty($user["shipping_address_id"])) {
			$shipping = $this->User->get_address($user["shipping_address_id"]);
			$user["shipping"] = $shipping[0];
		}
		if (!empty($user["billing_address_id"])) {
			$billing = $this->User->get_address($user["billing_address_id"]);
			$user["billing"] = $billing[0];
		}
		$this->data = array_merge($this->data, $user);
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->data["success"] = $this->session->flashdata("success_message");
		/* View adding head, nav, and main */
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user", $this->data);
		$this->load->view("users/profile", $this->data);
	}
	public function process_registration()
	{
		$this->check_post("register");
		$result = $this->User->validate_registration();
		if ($result != null) {
			$this->session->set_flashdata("input_errors", $result);
			redirect("register");
		} else {
			$form_data = $this->input->post(null, true);
			$this->User->create_user($form_data);
			$email = $form_data["email"];
			$user = $this->User->get_by_parameter("users", "email", $email);
			$session_data = profile_array($user);
			$this->session->set_userdata($session_data);
		}
		redirect("register");
	}
	public function process_login()
	{
		$this->check_post("login");
		$result = $this->User->validate_login();
		if ($result != "success") {
			$this->session->set_flashdata("input_errors", $result);
			redirect("login");
		} else {
			$email = $this->input->post("email");
			$user = $this->User->get_by_parameter("users", "email", $email);
			$result = $this->User->validate_password_hash(
				$user,
				$this->input->post("password")
			);

			if ($result == "success") {
				$session_data = profile_array($user);
				$this->session->set_userdata($session_data);
				redirect("products");
			} else {
				$this->session->set_flashdata("input_errors", $result);
				redirect("login");
			}
		}
		redirect("login");
	}
	/* Address type(1-shipping,2-billing,3-billing and shipping) */
	public function process_shipping_address()
	{
		$this->check_post("profile");
		$email = $this->session->userdata("email");
		$user = $this->User->get_by_parameter("users", "email", $email);
		$post = $this->input->post(null, true);
		$result = $this->User->validate_address();
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
		} elseif (!empty($user["shipping_address_id"])) {
			$this->User->update_by_parameters("addresses", $post, [
				"id" => ["=", $user["shipping_address_id"]],
			]);
			$this->session->set_flashdata(
				"success_message",
				"Successfully change your shipping address."
			);
		} else {
			$id = $this->User->create_address($post, 1);
			$this->User->update_by_parameters(
				"users",
				["shipping_address_id" => $id],
				["email" => ["=", $this->session->userdata("email")]]
			);
			$this->session->set_flashdata(
				"success_message",
				"Successfully added your shipping address."
			);
		}
		redirect("profile");
	}
	public function process_billing_address()
	{
		$this->check_post("profile");
		$email = $this->session->userdata("email");
		$user = $this->User->get_by_parameter("users", "email", $email);
		$post = $this->input->post(null, true);
		$result = $this->User->validate_address();
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
		} elseif (
			isset($post["same_shipping"]) &&
			$post["same_shipping"] == "on"
		) {
			if (!empty($user["shipping_address_id"])) {
				/* Deletes the old billing address then change the
				 shipping address type and user billing address id*/
				if (!empty($user["billing_address_id"])) {
					$this->User->delete_by_id(
						"addresses",
						$user["billing_address_id"]
					);
				}
				$this->User->update_by_parameters(
					"users",
					["billing_address_id" => $user["shipping_address_id"]],
					["email" => ["=", "$email"]]
				);
				$this->User->update_by_parameters(
					"addresses",
					["address_type_id" => 3],
					["id" => ["=", $user["shipping_address_id"]]]
				);
				$this->session->set_flashdata(
					"success_message",
					"Successfully change your billing address."
				);
			} else {
				$this->session->set_flashdata(
					"input_errors",
					"Please enter a shipping address first."
				);
			}
			/* Create billing address if same as shipping */
		} elseif (
			!empty($user["billing_address_id"]) &&
			$user["billing_address_id"] == $user["shipping_address_id"]
		) {
			$id = $this->User->create_address($post, 2);
			$this->User->update_by_parameters(
				"users",
				["billing_address_id" => $id],
				["email" => ["=", "$email"]]
			);
			$this->User->update_by_parameters(
				"addresses",
				["address_type_id" => 1],
				["id" => ["=", $user["shipping_address_id"]]]
			);
			$this->session->set_flashdata(
				"success_message",
				"Successfully added your billing address."
			);
			/* Update billing address if it exist but is not same as shipping */
		} elseif (!empty($user["billing_address_id"])) {
			$this->User->update_by_parameters("addresses", $post, [
				"id" => ["=", $user["billing_address_id"]],
			]);
			$this->session->set_flashdata(
				"success_message",
				"Successfully change your billing address."
			);
			/* Create new billing address */
		} else {
			$id = $this->User->create_address($post, 2);
			$this->User->update_by_parameters(
				"users",
				["billing_address_id" => $id],
				["email" => ["=", "$email"]]
			);
			$this->session->set_flashdata(
				"success_message",
				"Successfully added your billing address."
			);
		}
		redirect("profile");
	}
	public function process_edit()
	{
		$current = $this->session->userdata();
		$result = $this->User->validate_edit($current);
		echo $result;
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
			redirect("profile");
			return;
		}
		$post = $this->input->post(null, true);
		$this->User->update_profile($post, $current["id"]);
		$new = $this->User->get_by_parameter("users", "id", $current["id"]);
		$session_data = profile_array($new);
		$this->session->set_userdata($session_data);
		$this->session->set_flashdata(
			"success_message",
			"Successfully edited your profile."
		);
		redirect("profile");
	}
	public function process_password()
	{
		$result = $this->User->validate_password();
		$id = $this->session->userdata("id");
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
		} else {
			$password = $this->input->post("old_password");
			$user = $this->User->get_by_parameter("users", "id", $id);
			$result = $this->User->validate_password_hash($user, $password);
			if ($result == "success") {
				$this->User->update_password(
					$id,
					$this->input->post("new_password")
				);
				$this->session->set_flashdata(
					"success_message",
					"Successfully change your password."
				);
			} else {
				$this->session->set_flashdata("input_errors", $result);
			}
		}
		redirect("profile");
	}
	public function logoff()
	{
		$this->session->sess_destroy();
		redirect("products");
	}
	/* Redirect user if logged in by Markad */
	private function redirect_loggedin()
	{
		if ($this->session->userdata("is_logged_in") == 1) {
			redirect("products");
			return;
		}
	}
	/* Redirect user if not logged in by Markad */
	private function redirect_loggedout()
	{
		if (
			(!empty($this->session->userdata("is_logged_in")) &&
				$this->session->userdata("is_logged_in") == 0) ||
			empty($this->session->userdata("is_logged_in"))
		) {
			redirect("login");
			return;
		}
	}
	/* Redirect user if there is no post data by Markad */
	private function check_post($previous_url)
	{
		if (!$this->input->post(null, true)) {
			redirect("users/$previous_url");
			return;
		}
	}
	private function store_data()
	{
	}
}
