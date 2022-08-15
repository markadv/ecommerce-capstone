        <!-- Main content -->
        <div class="container">
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
                        <option value="1">Order in process</option>
                        <option value="2">Shipped</option>
                        <option value="3">Cancelled</option>
                    </select>
                </div>
            </div>
            <!-----Order List----------------------------------->
            <div class="table-container">
                <table class="table table-light table-striped">
                    <thead>
                        <tr>
                            <th class="col-1" scope="col-1">Order id</th>
                            <th class="col-2" scope="col-1">Name</th>
                            <th class="col-1" scope="col-1">Date</th>
                            <th class="col" scope="col-1">Billing address</th>
                            <th class="col-1" scope="col-1">Total</th>
                            <th class="col-2" scope="col-1">status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="">100</a></td>
                            <td>Bob</td>
                            <td>9/6/2014</td>
                            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium enim, qui,</td>
                            <td>$143</td>
                            <td>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">Order in process</option>
                                    <option value="2">Shipped</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </td>
                        </tr>
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
