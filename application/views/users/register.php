<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- ------------------Error Indicator-------->
        <div class="error"><p><?= isset($errors) ? $errors : "" ?></p></div>
        <!-- ---------------------------Registration Form-------------------------------->
        <div class="container text-center">
            <main class="form-signin w-100 m-auto">
                <form action="<?= base_url() ?>users/process_registration" method="POST" class="needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <img id="logo" class="bi me-2" src="../Assets/imgs/sleepingbaby.png" alt="Vilage88 Logo" />
                    <h1 class="h3 mb-3 fw-normal">Please register</h1>
                    <div class="form-floating has-validation">
                        <input
                            type="email"
                            name="email"
                            class="form-control form_top"
                            id="floatingInput"
                            placeholder="name@example.com"
                            required
                        />
                        <label for="floatingInput">Email address</label>
                        <div class="invalid-tooltip">Please choose an email.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="mobile"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="09171234567"
                            required
                        />
                        <label for="floatingInput">Mobile</label>
                        <div class="invalid-tooltip">Please enter your mobile.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="first_name"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Michael"
                            required
                        />
                        <label for="floatingInput">First Name</label>
                        <div class="invalid-tooltip">Please enter your first name.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="text"
                            name="last_name"
                            class="form-control form_mid"
                            id="floatingInput"
                            placeholder="Choi"
                            required
                        />
                        <label for="floatingInput">Last Name</label>
                        <div class="invalid-tooltip">Please enter your last name.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="password"
                            name="password"
                            class="form-control form_mid"
                            id="floatingPassword"
                            placeholder="Password"
                            required
                        />
                        <label for="floatingPassword">Password</label>
                        <div class="invalid-tooltip">Please enter a password.</div>
                    </div>
                    <div class="form-floating has-validation">
                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control form_bot"
                            id="floatingPassword"
                            placeholder="Confirm Password"
                            required
                        />
                        <label for="floatingPassword">Confirm Password</label>
                        <div class="invalid-tooltip">Please confirm your password.</div>
                    </div>
                    <input type="submit" class="w-100 btn btn-lg btn-primary" value="Register" />
                    <a href="<?= base_url() ?>users/login">Already have an account? Sign in</a>
                    <p class="mt-5 mb-3 text-muted">Mark Timothy Advento&copy; 2022</p>
                </form>
            </main>
        </div>
        <!------------------------------------------------------------------------->
    </body>
</html>
