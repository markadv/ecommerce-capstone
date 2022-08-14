<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("User");
	}
	public function index()
	{
		$this->load->view("welcome_message");
	}
}
