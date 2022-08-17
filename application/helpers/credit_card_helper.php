<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Credit Card Functions
 * by Markad
 */

/*
 * Truncates a card number retaining only the first 4 and the last 4 digits.  It then returns the truncated form.
 */
function truncate_card($card_num)
{
	$padsize = strlen($card_num) < 7 ? 0 : strlen($card_num) - 7;
	return substr($card_num, 0, 4) .
		str_repeat("X", $padsize) .
		substr($card_num, -3);
}

/**
 * Validates a card expiry date.  Finds the midnight on first day of the following
 * month and ensures that is greater than the current time (cards expire at the
 * end of the printed month).  Assumes basic sanity checks have already been performed
 * on month/year (i.e. length, numeric, etc).
 */
function card_expiry_valid($month, $year)
{
	$expiry_date = mktime(0, 0, 0, $month + 1, 1, $year);
	return $expiry_date > time();
}

/**
 * Strips all non-numerics from the card number.
 */
function card_number_clean($number)
{
	return preg_replace("/[^0-9]/", "", $number);
}

/**
 * Uses the Luhn algorithm (aka Mod10) <http://en.wikipedia.org/wiki/Luhn_algorithm>
 * to perform basic validation of a credit card number.
 */
function card_number_valid($card_number)
{
	$card_number = strrev(card_number_clean($card_number));
	$sum = 0;

	for ($i = 0; $i < strlen($card_number); $i++) {
		$digit = substr($card_number, $i, 1);

		// Double every second digit
		if ($i % 2 == 1) {
			$digit *= 2;
		}

		// Add digits of 2-digit numbers together
		if ($digit > 9) {
			$digit = ($digit % 10) + floor($digit / 10);
		}

		$sum += $digit;
	}

	// If the total has no remainder it's OK
	return $sum % 10 == 0;
}
?>
