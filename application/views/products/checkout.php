        <!-- Checkout info -->
        <div class="container">
            <div class="border bg-light my-3 row">
                <div class="col-6">
                    <span>Product</span>
                </div>
                <span class="col-2 text-right">Unit price</span>
                <span class="col-2 text-right">Quantity</span>
                <span class="col-2 text-right">Total price</span>
            </div>
<?php
$price_total = 0;
foreach ($products as $row) {
	$price_total += $row["price"] * $cart[$row["id"]]; ?>
            <div class="border row align-items-center my-3">
                <div class="col-12 w-100 py-2 bg-light">
                    <span>Baby Secret Shop</span>
                </div>
                <div class="border-top w-100">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <img src="<?= base_url() ?>assets/imgs/<?= $picture_main[
	$row["id"]
] ?>"
                                alt="<?= $row["name"] ?>" />
                            <span><?= $row["name"] ?></span>
                        </div>
                        <div class="col-2 text-right">&#8369;<?= $row[
                        	"price"
                        ] ?></div>
                        <div class="col-2 text-right"><?= $cart[
                        	$row["id"]
                        ] ?></div>
                        <div class="col-2 text-right">&#8369;<?= number_format(
                        	$row["price"] * $cart[$row["id"]],
                        	2
                        ) ?></div>
                    </div>
                </div>
            </div>
<?php
}
?>
            <div class="border row align-items-center my-3">
                <div class="w-100">
                    <div class="row align-items-center">
                        <div class="col-10">Merchandise subtotal</div>
                        <div class="col-2 text-right">&#8369; <?= number_format(
                        	$price_total,
                        	2
                        ) ?></div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-10">Shipping subtotal</div>
                        <div class="col-2 text-right">&#8369; 100.00</div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-10">Total</div>
                        <div class="col-2 text-right">&#8369; <?= number_format(
                        	$price_total + 100,
                        	2
                        ) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shipping address, class form_top/mid/bot uses underscore to make sure it doesn't interfer with bootstrap -->
        <div class="container justify-content-start">
            <form action="<?= base_url() ?>products/process_order" method="POST" class="needs-validation">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                <div class="form-signin w-100">
                    <h2 class="h3 mb-3 fw-normal">Shipping address</h2>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address1_shipping"
                            class="form-control form_top"
                            id="floatingInput"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["address1"]
                            	: "" ?>
                            placeholder="123 Sesame St."
                            required
                        />
                        <label for="address1">Address 1:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address2_shipping"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Brgy. Numbers"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["address2"]
                            	: "" ?>
                            required
                        />
                        <label for="address2">Address 2:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="city_shipping"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Math City"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["city"]
                            	: "" ?>
                            required
                        />
                        <label for="city">City:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="state_shipping"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Metro Manila"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["state"]
                            	: "" ?>
                            required
                        />
                        <label for="state">State:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="postal_code_shipping"
                            class="form-control form_bot"
                            id="floatingInput"
                            placeholder="0001"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["postal_code"]
                            	: "" ?>
                            required
                        />
                        <label for="state">Postal code</label>
                    </div>
                    <!-- Billing address -->
                    <h2 class="h3 mb-3 fw-normal">Billing address</h2>
                    <input type="checkbox" name="same_shipping" value="1" />
                    <label for="same_shipping"> Same as shipping</label><br />
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address1_billing"
                            class="form-control form-top"
                            id="floatingInput"
                            placeholder="123 Sesame St."
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["address1"]
                            	: "" ?>
                            required
                        />
                        <label for="address1">Address 1:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address2_billing"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Brgy. Numbers"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["address2"]
                            	: "" ?>
                            required
                        />
                        <label for="address2">Address 2:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="city_billing"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Math City"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["city"]
                            	: "" ?>
                            required
                        />
                        <label for="city">City:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="state_billing"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Metro Manila"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["state"]
                            	: "" ?>
                            required
                        />
                        <label for="state">State:</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="postal_code_billing"
                            class="form-control form_bot"
                            id="floatingInput"
                            placeholder="0001"
                            value=<?= isset($shipping_address) &&
                            !empty($shipping_address)
                            	? $shipping_address["postal_code"]
                            	: "" ?>
                            required
                        />
                        <label for="state">Postal code</label>
                    </div>
                    <!-- Billing info -->
                    <h1 class="h3 mb-3 fw-normal">Billing info</h1>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="first_name"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Michael"
                            value=<?= isset($first_name) && !empty($first_name)
                            	? $first_name
                            	: "" ?>
                            required
                        />
                        <label for="floatingInput">First name</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="last_name"
                            class="form-control form_bot"
                            id="floatingInput"
                            placeholder="Choi"
                            value=<?= isset($last_name) && !empty($last_name)
                            	? $last_name
                            	: "" ?>
                            required
                        />
                        <label for="floatingInput">Last name</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="email"
                            name="email"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="name@example.com"
                            value=<?= isset($email) && !empty($email)
                            	? $email
                            	: "" ?>
                        />
                        <label for="floatingInput">Email address</label>
                        <div class="invalid-tooltip">Please enter your email.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="card_number"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="1234567890123456"
                            required
                        />
                        <label for="floatingInput">Credit card:</label>
                        <div class="invalid-tooltip">Please enter your credit card number.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="cvc"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="123"
                            required
                        />
                        <label for="floatingInput">CVC:</label>
                        <div class="invalid-tooltip">Please enter CVC.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="expiration_month"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="01"
                            required
                        />
                        <label for="floatingInput">Expiration month:</label>
                        <div class="invalid-tooltip">Please enter credit card expiration.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="expiration_year"
                            class="form-control form_bot"
                            id="floatingInput"
                            placeholder="2024"
                            required
                        />
                        <label for="floatingInput">Expiration year:</label>
                        <div class="invalid-tooltip">Please enter credit card expiration.</div>
                    </div>
                    <!-- Removed. For future implementation. -->
                    <!-- <input type="checkbox" name="save_cc" value="1" /> -->
                    <!-- <label for="same_cc"> Save credit card</label><br /> -->
                </div>
                <div class="border row align-items-center mt-1 w-100">
                    <div class="w-100">
                        <div class="row align-items-center">
                            <div class="col-10">Merchandise subtotal</div>
                            <div class="col-2 text-right">&#8369; <?= number_format(
                            	$price_total,
                            	2
                            ) ?></div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-10">Shipping subtotal</div>
                            <div class="col-2 text-right">&#8369; 100.00</div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-10">Total</div>
                            <div class="col-2 text-right">&#8369; <?= number_format(
                            	$price_total + 100,
                            	2
                            ) ?></div>
                        </div>
                    </div>
                </div>
                <input class="btn btn-sm btn-primary my-3" type="submit" value="Submit order" />
            </form>
        </div>
    </body>
</html>
