<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("User");
		$this->load->helper("header");
		$this->output->enable_profiler(true);
	}
	public function index()
	{
		$this->load->view("welcome_message");
	}
	public function login()
	{
		$this->redirect();
		add_less(["login.less"]);
		$data["pageType"] = "login";
		$data["errors"] = $this->session->flashdata("input_errors");
		$data["isLoggedIn"] = $this->load->view("partials/head", $data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/login");
	}
	public function register()
	{
		$this->redirect();
		add_less(["register.less"]);
		$data["pageType"] = "register";
		$data["errors"] = $this->session->flashdata("input_errors");
		$this->load->view("partials/head", $data);
		$this->load->view("partials/nav_user");
		$this->load->view("users/register");
	}
	public function process_registration()
	{
		$result = $this->User->validate_registration();
		if ($result != null) {
			$this->session->set_flashdata("input_errors", $result);
			redirect("users/register");
		} else {
			$form_data = $this->input->post();
			$this->User->create_user($form_data);

			$user = $this->User->get_user_by_email($form_data["email"]);
			//retrieve cart session here
			$this->session->set_userdata([
				"user_id" => $user["id"],
				"first_name" => $user["first_name"],
				"isLoggedIn" => 1,
			]);

			redirect("products/index");
		}
		redirect("users/register");
	}
	public function process_login()
	{
		$result = $this->User->validate_login();
		if ($result != "success") {
			$this->session->set_flashdata("input_errors", $result);
			redirect("users/login");
		} else {
			$email = $this->input->post("email");
			$user = $this->User->get_user_by_email($email);

			$result = $this->User->validate_login_match(
				$user,
				$this->input->post("password")
			);

			if ($result == "success") {
				$this->session->set_userdata([
					"user_id" => $user["id"],
					"first_name" => $user["first_name"],
					"isLoggedIn" => 1,
				]);
				redirect("products/index");
			} else {
				$this->session->set_flashdata("input_errors", $result);
				redirect("users/login");
			}
		}
		// redirect("users/login");
	}
	public function logoff()
	{
		$this->session->sess_destroy();
		redirect("products/index");
	}
	private function redirect()
	{
		if ($this->session->userdata("isLoggedIn") == 1) {
			redirect("products/home");
		}
	}
}
