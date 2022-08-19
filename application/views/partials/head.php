<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= $title ?></title>
        <!-- Latest jQuery CDN -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"
        ></script>
        <!-- Latest Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!-- Preload google -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <!-- Latest Material Icons (icons) CDN -->
        <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet"
        />
        <!-- Overwrite bootstrap default -->
        <link rel="stylesheet" href="<?= base_url() ?>/assets/styles/bootstrap.min.css">
        <!-- LESS styling -->
<?= put_less() ?>
        <script src="https://cdn.jsdelivr.net/npm/less" ></script>
        <!-- CDN Library -->
<?= put_cdn() ?>
        <!-- JS -->
<?= put_js() ?>
        <!-- Global variables -->
        <script>var base_url = '<?php echo base_url(); ?>';</script>
    </head>
    <body>
        <!-- Insert login bar partial view -->
        <div class="px-3 py-1 border-bottom">
            <div class="navcontainer d-flex flex-wrap justify-content-center">
                <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto"></div>
                <div class="text-end">
<?php
if (isset($is_logged_in) && $is_logged_in == 1) { ?>
                    <a href="<?= base_url() ?>profile" class="btn btn-sm text-dark">Hi, <?= $first_name ?>!</a>
                    <a href="<?= base_url() ?>logoff" class="btn btn-sm btn-outline-danger">Log off</a>
<?php }
if (!isset($is_logged_in)) {
	if (isset($pageType) && $pageType == "register") { ?>
                    <a href="<?= base_url() ?>login" class="btn btn-sm btn-outline-primary text-dark">Sign in</a>
<?php } elseif (isset($pageType) && $pageType == "login") { ?>
                    <a href="<?= base_url() ?>register" class="btn btn-sm btn-primary">Register</a>
<?php } else { ?>
                    <a href="<?= base_url() ?>register" class="btn btn-sm btn-primary">Register</a>
                    <span>or</span>
                    <a href="<?= base_url() ?>login" class="btn btn-sm btn-outline-primary text-dark">Sign in</a>
<?php }
}
?>
                </div>
            </div>
        </div>
