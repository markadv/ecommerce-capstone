<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Products extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("User");
		$this->load->helper("header");
	}
	public function index()
	{
		add_js(["home.js"]);
		add_less(["home.less"]);
		add_cdn(["swiper"]);
		$this->load->view("partials/head");
		$this->load->view("partials/nav_user");
		$this->load->view("products/home");
	}
}
