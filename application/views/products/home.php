<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- Slider main container -->
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div id="slide1" class="swiper-slide"></div>
                <div id="slide2" class="swiper-slide"></div>
                <div id="slide3" class="swiper-slide"></div>
                ...
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination text-primary"></div>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <div>
            <h1 class="text-center text-primary mt-1">Featured Products</h1>
            <div class="container w-100">
                <ul class="row align-items-center">
<?php foreach ($products as $row) { ?>
                    <li class="col-6 col-md-3 mt-5 text-decoration-none list-unstyled">
                        <div class="card">
                            <img class="card-img-top"
                                src="<?= base_url() ?>assets/imgs/<?= $picture_main[
	$row["id"]
] ?>"
                                alt="<?= $row["name"] ?>" />
                            <div class="card-body">
                                <a href="<?= base_url() ?>products/show_product/<?= $row[
	"id"
] ?>" class="d-block"
                                    ><h5 class="card-title"><?= $row[
                                    	"name"
                                    ] ?></h5></a
                                >
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <span class="material-icons-sharp"> grade </span>
                                <p class="card-text">&#8369;<?= $row[
                                	"price"
                                ] ?></p>
                            </div>
                        </div>
                    </li>
<?php } ?>
                </ul>
                <a
                    class="w-100 d-block text-center display-6 text-decoration-none text-primary mb-3"
                    href="<?= base_url() ?>products/catalog"
                    class="show_all"
                    >Show all products</a
                >
            </div>
        </div>
    </body>
</html>
