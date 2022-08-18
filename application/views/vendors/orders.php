        <!-- Main content -->
        <div class="container mt-3">
            <div class="mb-3 row">
                <!-----Search------------------------------------>
                <div class="col-12 col-md-9">
                    <form class="d-flex w-100 ms-auto me-auto" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-12 col-md-3">
                    <!-----Status Sort----------------------------------->
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Show all</option>
<?php foreach ($status as $key => $value) { ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
<?php } ?>
                    </select>
                </div>
            </div>
            <!-----Order List----------------------------------->
            <div class="table-container">
                <table class="table table-light table-striped w-100">
                    <thead>
                        <tr>
                            <th class="col-1" scope="col-1">Order id</th>
                            <th class="col-2" scope="col-2">Name</th>
                            <th class="col-1" scope="col-1">Date</th>
                            <th class="col-5" scope="col-5">Billing address</th>
                            <th class="col-1" scope="col-1">Total</th>
                            <th class="col-3" scope="col-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($order_details as $row) {
	$date = date_create($row["created_at"]); ?>
                        <tr>
                            <td><a href="<?= base_url() ?>vendors/order_view/<?= $row[
	"id"
] ?>"><?= $row["id"] ?></a></td>
                            <td><?= $row["first_name"] .
                            	" " .
                            	$row["last_name"] ?></td>
                            <td><?= date_format($date, "m/d/Y") ?> </td>
                            <td><?= $row["address"] ?></td>
                            <td>&#8369;<?= number_format(
                            	$row["total"],
                            	2
                            ) ?></td>
                            <td>
                                <form action="<?= base_url() ?>vendors/change_order_status" method="POST" class="needs-validation">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                                    <input type="hidden" name="order_id" value="<?= $row[
                                    	"id"
                                    ] ?>" />
                                    <select name="order_status" class="form-select w-100">
<?php foreach ($status as $key => $value) { ?>
                                        <option value="<?= $key ?>" <?= $key ==
$row["status"]
	? "selected"
	: "" ?>><?= $value ?></option>
<?php } ?>
                                    </select>
                                </form>
                            </td>
                        </tr>
<?php
} ?>
                    </tbody>
                </table>
            </div>
            <!-----Pagination----------------------------------->
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
        </div>
    </body>
</html>
