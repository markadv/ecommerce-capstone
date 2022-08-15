<?php
/*
Dynamically add LESS,Javascript, and optional CDN files to header page
Created by Markad
*/
/* Check if function exist. If not, run it to trigger default in config. */
if (!function_exists("add_js")) {
	/* Add JS file */
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

/* Check if function exist. If not, run it to trigger default in config. */
if (!function_exists("add_less")) {
	/* Add LESS file */
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

/* Check if function exist. If not, run it to trigger default in config. */
if (!function_exists("add_cdn")) {
	/* Add LESS file */
	function add_cdn($file = "")
	{
		$str = "";
		$controller = &get_instance();
		$header_cdn = $controller->config->item("header_cdn");

		if (empty($file)) {
			return;
		}

		if (is_array($file)) {
			if (!is_array($file) && count($file) <= 0) {
				return;
			}
			foreach ($file as $item) {
				$header_cdn[] = $item;
			}
			$controller->config->set_item("header_cdn", $header_cdn);
		} else {
			$str = $file;
			$header_cdn[] = $str;
			$controller->config->set_item("header_cdn", $header_cdn);
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
				"assets/" .
				"js/" .
				$item .
				'"></script>' .
				"\n";
		}

		return $str;
	}
}

if (!function_exists("put_cdn")) {
	function put_cdn()
	{
		$str = "";
		$controller = &get_instance();
		$header_cdn = $controller->config->item("header_cdn");
		foreach ($header_cdn as $item) {
			if ($item == "swiper") {
				$str =
					"\t\t" .
					'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />' .
					"\n\t\t" .
					'<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>' .
					"\n";
			}
			if ($item == "jqueryui") {
				$str =
					"\t\t" .
					'<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">' .
					"\n\t\t" .
					'<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>' .
					"\n";
			}
		}
		return $str;
	}
}
