<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Review extends CI_Model
{
	/* This is for getting the reviews from product */
	public function get_reviews_from_product_id($id)
	{
		$safe_id = $this->security->xss_clean($id);

		$query = "SELECT CONCAT(users.first_name,' ',users.last_name) AS reviewer_name, reviews.id,
            reviews.content, TIMESTAMPDIFF(SECOND,reviews.created_at,NOW()) AS time_difference, DATE_FORMAT(reviews.created_at, '%M %D %Y') AS review_date
            FROM reviews LEFT JOIN users ON reviews.user_id=users.id 
            WHERE reviews.product_id=? ORDER BY reviews.created_at DESC";

		return $this->db->query($query, $safe_id)->result_array();
	}
	/* This is for getting the replies from review */
	public function get_replies_from_review_id($id)
	{
		$safe_id = $this->security->xss_clean($id);

		$query = "SELECT CONCAT(users.first_name,' ',users.last_name) AS replier_name, replies.id,
            replies.content, TIMESTAMPDIFF(SECOND,replies.created_at,NOW()) AS time_difference, DATE_FORMAT(replies.created_at, '%M %D %Y') AS reply_date
            FROM replies LEFT JOIN users ON replies.user_id=users.id 
            WHERE replies.review_id=? ORDER BY replies.created_at ASC";

		return $this->db->query($query, $safe_id)->result_array();
	}
	/* This is for validating message */
	public function validate_message()
	{
		if ($this->input->post("review")) {
			$this->form_validation->set_error_delimiters("<div>", "</div>");
			$this->form_validation->set_rules("review", "Review", "required");
		} elseif ($this->input->post("reply")) {
			$this->form_validation->set_error_delimiters("<div>", "</div>");
			$this->form_validation->set_rules("reply", "Reply", "required");
		}

		if (!$this->form_validation->run()) {
			return validation_errors();
		} else {
			return "success";
		}
	}
	/* This is for cleaning data and adding review */
	public function add_review_db($post)
	{
		$query =
			"INSERT INTO reviews(user_id, product_id, content) VALUES (?, ?, ?)";
		$values = [
			$this->security->xss_clean($this->session->userdata("user_id")),
			$this->security->xss_clean($post["product_id"]),
			$this->security->xss_clean($post["review"]),
		];

		$this->db->query($query, $values);
	}
	/* This is for cleaning data and adding replies */
	public function add_reply_db($post)
	{
		$query =
			"INSERT INTO replies(user_id, review_id, content) VALUES (?, ?, ?)";
		$values = [
			$this->security->xss_clean($this->session->userdata("user_id")),
			$this->security->xss_clean($post["review_id"]),
			$this->security->xss_clean($post["reply"]),
		];

		$this->db->query($query, $values);
	}
}
