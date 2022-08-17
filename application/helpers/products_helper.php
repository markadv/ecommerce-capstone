<?php
defined("BASEPATH") or exit("No direct script access allowed");
function get_cart_data($cart)
{
    $quantity = 0;
    if (!empty($cart)) {
        foreach ($cart as $value) {
            $quantity += $value;
        }
    }
    return $quantity;
}
function get_cart_table($cart, $products)
{
    foreach ($cart as $key => $value) {
        foreach ($products as $rows) {
            if ($rows["id"] == $key) {
                $cartTotal[] = [
                    "id" => $key,
                    "name" => $rows["name"],
                    "price" => $rows["price"],
                    "quantity" => $value,
                ];
            }
        }
    }
    return $cartTotal;
}
function get_price_quantity($cartTotal)
{
    $totalPrice = 0;
    $quantity = 0;
    foreach ($cartTotal as $row) {
        $totalPrice += $row["price"] * $row["quantity"];
        $quantity += $row["quantity"];
    }
    return ["totalPrice" => $totalPrice, "quantity" => $quantity];
}
?>
