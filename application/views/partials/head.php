<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home</title>
        <!-- Latest jQuery CDN -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"
        ></script>
        <!-- Latest Bootstrap CDN -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
            crossorigin="anonymous"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <!-- Latest Material Icons (icons) CDN -->
        <link
            href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
            rel="stylesheet"
        />
        <!-- LESS styling -->
<?= put_less() ?>
        <script src="https://cdn.jsdelivr.net/npm/less"></script>
        <!-- Bootstrap JS CDN -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"
        ></script>
        <!-- CDN Library -->
<?= add_swiper() == true ? put_swiper() : "" ?>
    </head>
    <body>
        <!-- Insert login bar and navbar partial view -->
        <div class="px-3 py-1 border-bottom">
            <div class="navcontainer d-flex flex-wrap justify-content-center">
                <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto"></div>
                <div class="text-end">
                    <a href="" class="btn btn-sm text-dark">Hi, Mark!</a>
                    <a href="" class="btn btn-sm btn-outline-danger">Log off</a>
                    <a href="" class="btn btn-sm btn-outline-primary text-dark">Sign in</a>
                    <span>or</span>
                    <a href="" class="btn btn-sm btn-primary">Register</a>
                </div>
            </div>
        </div>