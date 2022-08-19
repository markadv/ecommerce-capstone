<?php
foreach ($products as $row) { ?>
                        <li class="col-6 col-md-3 list-unstyled">
                            <a
                                href="<?= base_url() ?>products/show_product/<?= $row[
	"id"
] ?>"
                                class="d-block text-decoration-none">
                            <div class="card">
                                <img
                                    class="card-img-top"
                                    src="<?= base_url() ?>assets/imgs/<?= $picture_main[
	$row["id"]
] ?>"
                                    alt="<?= $row["name"] ?>" />
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $row["name"] ?>
                                    </h5>
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
                            </a>
                        </li>
<?php } ?>
