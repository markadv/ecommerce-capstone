<?php
/*
Dynamically add Javascript files to header page
Check if function exist. If not, run it to trigger default in config. 
Created by Markad
*/
if (!function_exists("add_js")) {
	function add_js($file = "")
	{
		$str = "";
		$controller = &get_instance();
		$header_js = $controller->config->item("header_js");

		/* If config is empty and no user input, return */
		if (empty($file)) {
			return;
		}

		if (is_array($file)) {
			if (!is_array($file) && count($file) <= 0) {
				return;
			}
			foreach ($file as $item) {
				$header_js[] = $item;
			}
			$controller->config->set_item("header_js", $header_js);
		} else {
			$str = $file;
			$header_js[] = $str;
			$controller->config->set_item("header_js", $header_js);
		}
	}
}

//Dynamically add LESS files to header page
if (!function_exists("add_less")) {
	function add_less($file = "")
	{
		$str = "";
		$controller = &get_instance();
		$header_less = $controller->config->item("header_less");

		if (empty($file)) {
			return;
		}

		if (is_array($file)) {
			if (!is_array($file) && count($file) <= 0) {
				return;
			}
			foreach ($file as $item) {
				$header_less[] = $item;
			}
			$controller->config->set_item("header_less", $header_less);
		} else {
			$str = $file;
			$header_less[] = $str;
			$controller->config->set_item("header_less", $header_less);
		}
	}
}

/* Putting LESS files together */
if (!function_exists("put_less")) {
	function put_less()
	{
		$str = "";
		$controller = &get_instance();
		$header_less = $controller->config->item("header_less");

		foreach ($header_less as $item) {
			$str .=
				"\t\t" .
				'<link rel="stylesheet/less" href="' .
				base_url() .
				"assets/" .
				"styles/" .
				$item .
				'"/>' .
				"\n";
		}

		return $str;
	}
}
/* Putting JS files together */
if (!function_exists("put_js")) {
	function put_js()
	{
		$str = "";
		$controller = &get_instance();
		$header_js = $controller->config->item("header_js");

		foreach ($header_js as $item) {
			$str .=
				"\t\t" .
				'<script src="' .
				base_url() .
				"/assets" .
				"js/" .
				$item .
				'"></script>' .
				"\n";
		}

		return $str;
	}
}

/* Return swipe library */
function add_swiper()
{
	return $bool;
}
function put_swiper($bool = false)
{
	$str =
		"\t\t" .
		'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />' .
		"\n\t\t" .
		'<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>' .
		"\n";

	return $str;
}
