<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- Partial user nav -->
        <nav class="navbar border-bottom px-5 py-4 bg-light">
            <div class="container-fluid">
                <a
                    href="<?= base_url() ?>"
                    class="d-flex align-items-center text-center my-2 my-lg-0 me-lg-auto text-black text-decoration-none"
                >
                    <img id="logo" src="<?= base_url() ?>assets/imgs/sleepingbaby.png" alt="baby logo" />
                    <span class="h4">Baby Secret Shop</span>
                </a>
                <form action="<?= base_url() ?>products/catalog" class="d-flex w-50 ms-auto me-auto" method="GET" role="search">
                    <input name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <input class="btn btn-outline-primary" type="submit" value="Search" />
                </form>
                <a href="<?= base_url() ?>products/cart" class="cart position-relative" aria-label="View your shopping cart">
                    <span class="material-icons-outlined md-64 text-primary"> shopping_cart </span>
                    <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-primary">
                        <?= isset($cart) ? count($cart) : 0 ?>
                        <span class="visually-hidden">items in cart</span>
                    </span>
                </a>
            </div>
        </nav>