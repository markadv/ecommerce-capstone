    <!-- Main content -->
        <div class="container mt-3">
            <div class="mb-3">
                <!-----Search------------------------------------>
                <form id="search-sort" class="row"  method="GET" role="search">
                    <div class="col-12 col-md-9">
                        <div class="d-flex w-100 ms-auto me-auto">
                            <input name="search" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <!-----Status Sort----------------------------------->
                        <select id="filter" name="filter" class="form-select" aria-label="Default select example">
                            <option value="0" selected>Show all</option>
<?php foreach ($status as $key => $value) { ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
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
