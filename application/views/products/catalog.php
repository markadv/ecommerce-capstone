<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
         <!-- Error Indicator -->
<?php if (!empty($success)) { ?>
		<p class="success">Your transaction <?= $success[
  	"payment_status"
  ] ?>. Your transaction id is <?= $success["transaction_id"] ?></p>
		<p class="success">Transaction amount is &#8369;<?= number_format(
  	$success["paid_amount"],
  	2
  ) ?>.</p>
    <p class="success"><a href="<?= $success[
    	"receipt_url"
    ] ?>">Receipt Link</a></p>
<?php } ?>
        <!-- Collapsible category sidebar -->
        <form action="<?= base_url() ?>catalog_html" class="container" method="POST">
            <input type="hidden" id="category_id" name="category_id"  />
            <div class="row">
                <div class="flex-shrink-0 bg-white col-2 border">
                    <div class="form-group has-search mt-3">
                        <span class="material-icons-outlined form-control-feedback"> search </span>
                        <input id="catalog-search" name="search" type="text" class="form-control" placeholder="Search"/>
                    </div>
                    <a
                        href="/"
                        class="d-flex align-items-center pb-3 my-3 link-dark text-decoration-none border-bottom"
                    >
                        <span class="material-icons-outlined me-2"> child_care </span>
                        <span class="fs-5 fw-semibold">Categories</span>
                    </a>
                    <ul class="list-group">
                        <li class="categories-selection list-group-item list-group-item-action d-flex justify-content-between align-items-center p-1"
                            data-id=""
                            data-name="Show all">
                            <a class="text-decoration-none" >
                                Show all
                            <span class="badge bg-primary"></span>
                            </a>
                        </li>
<?php foreach ($categories as $row) { ?>
                        <li class="categories-selection list-group-item list-group-item-action d-flex justify-content-between align-items-center p-1"
                            data-id=<?= $row["id"] ?>
                            data-name="<?= $row["name"] ?>">
                            <a class="text-decoration-none" >
                                <?= $row["name"] ?>
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
                        <h1 class="col-9 display-6">Show all</h1>
                        <div class="form-floating col-3 text-right">
                            <div class="dropdown">
                                <select id="catalog-sort" name="sort" class="form-select">
                                    <option value="1">Most popular</option>
                                    <option value="2">Price ascending</option>
                                    <option value="3">Price descending</option>
                                </select>
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
                    <ul id="catalog_container" class="row align-items-center">
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
            <input class="d-none" type="submit"/>
        </form>
    </body>
</html>
