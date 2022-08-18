<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Reviews extends CI_Controller
{
	/* Loads model and store needed session data in variable */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Product");
		$this->load->model("Review");
	}
	/* This is for product review 
	-Get products info by id
	-Check for review
	-Check for replies under that review, store than in the review
	*/
	public function index($id)
	{
		$current_user = $this->session->userdata("first_name");
		if (!$current_user) {
			redirect("signin");
		} else {
			$inbox = [];
			$product = $this->Product->get_product_by_id($id);
			$reviews = $this->Review->get_reviews_from_product_id($id);
			foreach ($reviews as $review) {
				$replies = $this->Review->get_replies_from_review_id(
					$review["id"]
				);
				$review["replies"] = $replies;
				$inbox[] = $review;
			}
			$this->load->view("templates/header");
			$this->load->view("products/showsnip");
			$this->load->view("templates/navbar", [
				"name" => $current_user,
				"product" => $product,
				"id" => $id,
				"inbox" => $inbox,
			]);
			$this->load->view("products/show");
		}
	}
	/* Validate review then redirect or add */
	public function add_review($id)
	{
		$result = $this->Review->validate_message();

		if ($result != "success") {
			$this->session->set_flashdata("input_errors", $result);
		} else {
			$this->Review->add_review_db($this->input->post());
		}
		redirect("show/$id");
	}

	/* Validate reply then redirect or add */
	public function add_reply($id)
	{
		$result = $this->Review->validate_message();
		if ($result != "success") {
			$this->session->set_flashdata("input_errors", validation_errors());
		} else {
			$this->Review->add_reply_db($this->input->post());
		}
		redirect("show/$id");
	}
}
