<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
<!-- Collapsible category sidebar -->
        <div class="container">
            <div class="row">
                <div class="flex-shrink-0 bg-white col-2 border">
                    <div class="form-group has-search mt-3">
                        <span class="material-icons-outlined form-control-feedback"> search </span>
                        <input type="text" class="form-control" placeholder="Search" />
                    </div>
                    <a
                        href="/"
                        class="d-flex align-items-center pb-3 my-3 link-dark text-decoration-none border-bottom"
                    >
                        <span class="material-icons-outlined me-2"> child_care </span>
                        <span class="fs-5 fw-semibold">Categories</span>
                    </a>
                    <ul class="list-group">
<?php foreach ($categories as $row) { ?>
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-1">
                            <a class="text-decoration-none" href=""><?= $row[
                            	"name"
                            ] ?>
                            <span class="badge bg-primary"><?= $row[
                            	"count"
                            ] ?></span>
                            </a>
                        </li>
<?php } ?>                   
                    </ul>
                </div>
                <!-- Main content -->
                <div class="col-10">
                    <div class="row my-3">
                        <h1 class="col-9 display-6">Feeding (Page 2)</h1>
                        <div class="form-floating col-3 text-right">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort by
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Most popular</a></li>
                                    <li><a class="dropdown-item" href="#">Price ascending</a></li>
                                    <li><a class="dropdown-item" href="#">Price descending</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">First</a>
                            </li>
                            <li class="page-item" disabled><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                    <ul class="row align-items-center">
<?php foreach ($products as $row) { ?>
                        <li class="col-6 col-md-3 text-decoration-none list-unstyled">
                            <div class="card">
                                <img class="card-img-top" src="../Assets/imgs/<?= $picture_main[
                                	$row["id"]
                                ] ?>" alt="<?= $row["name"] ?>" />
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
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </body>
</html>
