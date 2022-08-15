<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- Partial user nav -->
        <nav class="navbar border-bottom px-5 bg-light">
            <div class="container-fluid">
                <a
                    href="<?= base_url() ?>"
                    class="d-flex align-items-center text-center my-2 my-lg-0 me-lg-auto text-black text-decoration-none"
                >
                    <img id="logo" src="..\Assets\imgs\sleepingbaby.png" alt="baby logo" />
                    <span class="h4">Baby Secret Shop</span>
                </a>
                <form class="d-flex w-50 ms-auto me-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
                <a href="#" class="cart position-relative" aria-label="View your shopping cart">
                    <span class="material-icons-outlined md-64 text-primary"> shopping_cart </span>
                    <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-primary">
                        9
                        <span class="visually-hidden">items in cart</span>
                    </span>
                </a>
            </div>
        </nav>