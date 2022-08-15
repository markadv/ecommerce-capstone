<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Users extends CI_Controller
{
	public $data = [];
	public function __construct()
	{
		parent::__construct();
		$this->load->model("User");
		$this->load->helper("header");
		$this->output->enable_profiler(true);
	}
	public function index()
	{
		redirect("shops");
	}
	public function login()
	{
		$this->redirect_loggedin();
		add_less(["login.less"]);
		$this->data = $this->session->userdata();
		$this->data["pageType"] = "login";
		$this->data["type"] = "users";
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/login");
	}
	public function register()
	{
		$this->redirect_loggedin();
		add_less(["register.less"]);
		$this->data = $this->session->userdata();
		$this->data["pageType"] = "register";
		$this->data["type"] = "users";
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/register");
	}
	public function profile()
	{
		$this->check_loggedin();
		add_less(["profile.less"]);
		add_js(["profile.js"]);
		$this->data = $this->session->userdata();
		/* Get all info*/
		$email = $this->session->userdata("email");
		$user = $this->User->get_by_parameter("users", "email", $email);
		if (!empty($user["shippingAddress_id"])) {
			$shipping = $this->User->get_type_address(
				"shipping",
				$user["shippingAddress_id"]
			);
			$user["shipping"] = $shipping[0];
		}
		if (!empty($user["billingAddress_id"])) {
			$billing = $this->User->get_type_address(
				"billing",
				$user["billingAddress_id"]
			);
			$user["billing"] = $billing[0];
		}
		$this->data = array_merge($this->data, $user);
		$this->data["errors"] = $this->session->flashdata("input_errors");
		$this->data["success"] = $this->session->flashdata("success_message");
		$this->load->view("partials/head", $this->data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/profile", $this->data);
	}
	public function process_registration()
	{
		$this->check_post("register");
		$result = $this->User->validate_registration();
		if ($result != null) {
			$this->session->set_flashdata("input_errors", $result);
			redirect("users/register");
		} else {
			$form_data = $this->input->post();
			$this->User->create_user($form_data);
			$email = $form_data["email"];
			$user = $this->User->get_by_parameter("users", "email", $email);
			$session_data = $this->User->profile_array($user);
			$this->session->set_userdata($session_data);
		}
		redirect("users/register");
	}
	public function process_login()
	{
		$this->check_post("login");
		$result = $this->User->validate_login();
		if ($result != "success") {
			$this->session->set_flashdata("input_errors", $result);
			redirect("users/login");
		} else {
			$email = $this->input->post("email");
			$user = $this->User->get_by_parameter("users", "email", $email);
			$result = $this->User->validate_login_match(
				$user,
				$this->input->post("password")
			);

			if ($result == "success") {
				$session_data = $this->User->profile_array($user);
				$this->session->set_userdata($session_data);
				redirect("shops");
			} else {
				$this->session->set_flashdata("input_errors", $result);
				redirect("users/login");
			}
		}
		redirect("users/login");
	}
	public function process_shipping_address()
	{
		$this->check_post("profile");
		$email = $this->session->userdata("email");
		$user = $this->User->get_by_parameter("users", "email", $email);
		$post = $this->input->post();
		$result = $this->User->validate_address();
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
		} elseif (!empty($user["shippingAddress_id"])) {
			$this->User->update_by_parameters("addresses", $post, [
				"id" => ["=", $user["shippingAddress_id"]],
			]);
			$this->session->set_flashdata(
				"success_message",
				"Successfully change your shipping address."
			);
		} else {
			$id = $this->User->create_address($post, [0, 1, 0]);
			$this->User->update_by_parameters(
				"users",
				["shippingAddress_id" => $id],
				["email" => ["=", $this->session->userdata("email")]]
			);
			$this->session->set_flashdata(
				"success_message",
				"Successfully change your shipping address."
			);
		}
		redirect("users/profile");
	}
	public function process_billing_address()
	{
		$this->check_post("profile");
		$email = $this->session->userdata("email");
		$user = $this->User->get_by_parameter("users", "email", $email);
		$post = $this->input->post();
		$result = $this->User->validate_address();
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
		} elseif ($post["same_shipping"] == "on") {
			if (!empty($user["shippingAddress_id"])) {
				if (!empty($user["billingAddress_id"])) {
					$this->User->delete_by_id(
						"addresses",
						$user["billingAddress_id"]
					);
				}
				$this->User->update_by_parameters(
					"users",
					["billingAddress_id" => $user["shippingAddress_id"]],
					["email" => ["=", "$email"]]
				);
				$this->User->update_by_parameters(
					"addresses",
					["IsBilling" => 1],
					["id" => ["=", $user["shippingAddress_id"]]]
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
		} elseif (!empty($user["billingAddress_id"])) {
			unset($post["same_shipping"]);
			$this->User->update_by_parameters("addresses", $post, [
				"id" => ["=", $user["billingAddress_id"]],
			]);
		} else {
			unset($post["same_shipping"]);
			$id = $this->User->create_address($post, [1, 0, 0]);
			$this->User->update_by_parameters(
				"users",
				["billingAddress_id" => $id],
				["email" => ["=", "$email"]]
			);
		}
		redirect("users/profile");
	}
	public function process_edit()
	{
		$current = $this->session->userdata();
		$result = $this->User->validate_edit($current);
		echo $result;
		if ($result !== "success") {
			$this->session->set_flashdata("input_errors", $result);
			redirect("users/profile");
			return;
		}
		$post = $this->input->post();
		$this->User->update_information($post, $current["id"]);
		$new = $this->User->get_by_parameter("users", "id", $current["id"]);
		$session_data = $this->User->profile_array($new);
		$this->session->set_userdata($session_data);
		$this->session->set_flashdata(
			"success_message",
			"Successfully edited your profile."
		);
		redirect("users/profile");
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
			$result = $this->User->validate_login_match($user, $password);
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
		redirect("users/profile");
	}
	public function logoff()
	{
		$this->session->sess_destroy();
		redirect("shops");
	}
	/*
	Redirect user if logged in by Markad
	*/
	private function redirect_loggedin()
	{
		if ($this->session->userdata("isLoggedIn") == 1) {
			redirect("shops");
			return;
		}
	}
	/*
	Redirect user if not logged in by Markad
	*/
	private function check_loggedin()
	{
		if (
			(!empty($this->session->userdata("isLoggedIn")) &&
				$this->session->userdata("isLoggedIn") == 0) ||
			empty($this->session->userdata("isLoggedIn"))
		) {
			redirect("users/login");
			return;
		}
	}
	/*
	Redirect user if there is no post data by Markad
	*/
	private function check_post($previous_url)
	{
		if (!$this->input->post()) {
			redirect("users/$previous_url");
			return;
		}
	}
}
