<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- ------------------Error Indicator-------->
        <div class="error"><p><?= isset($errors) ? $errors : "" ?></p></div>
        <!-- ---------------------------Login Form-------------------------------->
        <div class="container text-center">
            <main class="form-signin w-100 m-auto">
                <form action="<?= base_url() ?>users/process_login" method="POST" class="needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <img id="logo" class="bi me-2" src="../Assets/imgs/sleepingbaby.png" alt="Vilage88 Logo" />
                    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                    <div class="form-floating">
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="floatingInput"
                            placeholder="name@example.com"
                            required
                        />
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            id="floatingPassword"
                            placeholder="Password"
                            required
                        />
                        <label for="floatingPassword">Password</label>
                    </div>

                    <input type="submit" class="w-100 btn btn-lg btn-primary" value="Sign in" />
                    <a href="<?= base_url() ?>users/register">Don't have an account? Sign up</a>
                    <p class="mt-5 mb-3 text-muted">Mark Timothy Advento&copy; 2022</p>
                </form>
            </main>
        </div>
        <!------------------------------------------------------------------------->
    </body>
</html>
