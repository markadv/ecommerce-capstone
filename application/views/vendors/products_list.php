<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
        <!-- Error Indicator -->
        <div class="error"><p><?= isset($errors) ? $errors : "" ?></p></div>
        <div class="success"><p><?= isset($success) ? $success : "" ?></p></div>
        <div class="container mt-3">
            <!-- Search -->
            <div class="mb-3 row">
                <div class="col-12 col-md-9">
                    <form class="d-flex w-100 ms-auto me-auto" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
                <!------Add product-------->
                <div class="col-12 col-md-3">
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#product">
                        Add new product
                    </button>
                </div>
            </div>
            <!------Product Table-------->
            <div class="table-container">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th scope="col-1">ID</th>
                            <th scope="col-2">Picture</th>
                            <th scope="col-4">Name</th>
                            <th scope="col-1">Inventory</th>
                            <th scope="col-1">Qty Sold</th>
                            <th scope="col-1">Current Price</th>
                            <th scope="col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($products as $row) { ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td>
                                <div class="img_container">
                                    <img class="product_image" src="<?= base_url() .
                                    	"assets/imgs/" .
                                    	$picture_main[
                                    		$row["id"]
                                    	] ?>" alt="<?= $row["name"] ?>" />
                                </div>
                            </td>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["quantity"] ?></td>
                            <td><?= isset($sold[$row["id"]])
                            	? $sold[$row["id"]]
                            	: 0 ?></td>
                            <td> &#8369 <?= $row["price"] ?></td>
                            <td>
                                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#product">
                                    Edit
                                </a>
                                <a
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete_product_<?= $row[
                                    	"id"
                                    ] ?>"
                                    href="#"
                                    >Delete</a
                                >
                            </td>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!------Pagination-------->
        <nav class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link text-primary" href="#">1</a></li>
                <li class="page-item"><a class="page-link text-primary" href="#">2</a></li>
                <li class="page-item"><a class="page-link text-primary" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link text-primary" href="#">Next</a>
                </li>
            </ul>
        </nav>

        <!-- ------------------------------------------Delete modal------------------------------------------------------------- -->
<?php foreach ($products as $row) { ?>
        <form action="<?= base_url() ?>vendors/delete_product/" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" /> 
            <input type="hidden" name="product_id" value="<?= $row["id"] ?>" />
            <div
                class="modal fade"
                id="delete_product_<?= $row["id"] ?>"
                data-bs-backdrop="static"
                data-bs-keyboard="true"
                tabindex="-1"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Delete product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this product?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-danger" value="Delete" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
<?php } ?>
    </body>
</html>
