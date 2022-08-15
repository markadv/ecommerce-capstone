<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- Error Indicator -->
        <div class="error"><p><?= isset($errors) ? $errors : "" ?></p></div>
        <div class="success"><p><?= isset($success) ? $success : "" ?></p></div>
        <!-- Profile -->
        <h1 class="h1 mx-5 mt-5 fw-normal">Profile</h1>
        <div class="container">
            <div class="form-signin w-100">
                <form action="<?= base_url() ?>users/process_edit" method="POST" class="needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <h2 class="h3 mb-3 fw-normal">Edit Information</h2>
                    <div class="form-floating">
                        <input
                            type="email"
                            name="email"
                            class="form-control form_top"
                            id="floatingInput"
                            placeholder="name@example.com"
                            value="<?= $email ?>"
                            required
                        />
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="mobile"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="09170000000"
                            value="<?= $mobile ?>"
                            required
                        />
                        <label for="floatingInput">Mobile</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="first_name"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Michael"
                            value="<?= $first_name ?>"
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
                            value="<?= $last_name ?>"
                            required
                        />
                        <label for="floatingInput">Last name</label>
                    </div>
                    <input type="submit" class="w-100 btn btn-lg btn-primary" value="Save" />
                </form>
            </div>
            <div class="form-signin w-100">
                <form action="<?= base_url() ?>users/process_password" method="POST" class="needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <h2 class="h3 mb-3 fw-normal">Change Password</h2>
                    <div class="form-floating">
                        <input
                            type="password"
                            name="old_password"
                            class="form-control form_top"
                            id="floatingPassword"
                            placeholder="Old Password"
                            required
                        />
                        <label for="floatingPassword">Old Password</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="password"
                            name="new_password"
                            class="form-control form_mid"
                            id="floatingPassword"
                            placeholder="New Password"
                            required
                        />
                        <label for="floatingPassword">New Password</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control form_bot"
                            id="floatingPassword"
                            placeholder="Confirm Password"
                            required
                        />
                        <label for="floatingPassword">Confirm Password</label>
                    </div>
                    <input type="submit" class="w-100 btn btn-lg btn-primary" value="Save" />
                </form>
            </div>
            <div class="form-signin w-100">
                <form action="<?= base_url() ?>users/process_shipping_address" method="POST" class="needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <h2 class="h3 mb-3 fw-normal">Shipping address</h2>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address1"
                            class="form-control form_top address1_shipping"
                            id="floatingInput"
                            placeholder="123 Sesame St."
                            value = "<?= isset($shipping["address1"])
                            	? $shipping["address1"]
                            	: "" ?>"
                            required
                        />
                        <label for="address1">Address 1</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address2"
                            class="form-control form_mid address2_shipping"
                            id="floatingInput"
                            placeholder="Brgy. Numbers"
                            value = "<?= isset($shipping["address2"])
                            	? $shipping["address2"]
                            	: "" ?>"
                        />
                        <label for="address2">Address 2</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="city"
                            class="form-control form_mid city_shipping"
                            id="floatingInput"
                            placeholder="Math City"
                            value = "<?= isset($shipping["city"])
                            	? $shipping["city"]
                            	: "" ?>"
                        />
                        <label for="city">City</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="state"
                            class="form-control form_mid state_shipping"
                            id="floatingInput"
                            placeholder="Metro Manila"
                            value = "<?= isset($shipping["state"])
                            	? $shipping["state"]
                            	: "" ?>"
                            required
                        />
                        <label for="state">State</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="postal_code"
                            class="form-control form_bot postal_code_shipping"
                            id="floatingInput"
                            placeholder="0001"
                            value = "<?= isset($shipping["postal_code"])
                            	? $shipping["postal_code"]
                            	: "" ?>"
                            required
                        />
                        <label for="state">Postal code</label>
                    </div>
                    <input type="submit" class="w-100 btn btn-lg btn-primary" value="Save" />
                </form>
            </div>
            <div class="form-signin w-100">
                <form id="form_billing_address" action="<?= base_url() ?>users/process_billing_address" method="POST" class="needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <h2 class="h3 mb-3 fw-normal">Billing address</h2>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address1"
                            class="form-control form_top address1_billing"
                            id="floatingInput"
                            placeholder="123 Sesame St."
                            value = "<?= isset($billing["address1"])
                            	? $billing["address1"]
                            	: "" ?>"
                            required
                        />
                        <label for="address1">Address 1</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="address2"
                            class="form-control form_mid address2_billing"
                            id="floatingInput"
                            placeholder="Brgy. Numbers"
                            value = "<?= isset($billing["address2"])
                            	? $billing["address2"]
                            	: "" ?>"
                        />
                        <label for="address2">Address 2</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="city"
                            class="form-control form_mid city_billing"
                            id="floatingInput"
                            placeholder="Math City"
                            value = "<?= isset($billing["city"])
                            	? $billing["city"]
                            	: "" ?>"
                            required
                        />
                        <label for="city">City</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="state"
                            class="form-control form_mid state_billing"
                            id="floatingInput"
                            placeholder="Metro Manila"
                            value = "<?= isset($billing["state"])
                            	? $billing["state"]
                            	: "" ?>"
                            required
                        />
                        <label for="state">State</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="text"
                            name="postal_code"
                            class="form-control form_bot postal_code_billing"
                            id="floatingInput"
                            placeholder="Metro Manila"
                            value = "<?= isset($billing["postal_code"])
                            	? $billing["postal_code"]
                            	: "" ?>"
                            required
                        />
                        <label for="state">Postal code</label>
                    </div>
                    <input type="submit" class="w-100 btn btn-lg btn-primary" value="Save" />
                    <input id="same_shipping" type="checkbox" name="same_shipping" />
                    <label for="same_shipping"> Same as shipping</label><br />
                </form>
            </div>
        </div>
    </body>
</html>
