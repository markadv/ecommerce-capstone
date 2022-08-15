        <div class="container pt-3">
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
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="img_container">
                                    <img class="product_image" src="../Assets/imgs/product1.jpg" alt="mouse" />
                                </div>
                            </td>
                            <td>Keyboard</td>
                            <td>123</td>
                            <td>10</td>
                            <td>$143</td>
                            <td>
                                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#product">
                                    Edit
                                </a>
                                <a
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete_product"
                                    href="#"
                                    >Delete</a
                                >
                            </td>
                        </tr>
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
        <form action="/products/delete_product" method="post">
            <div
                class="modal fade"
                id="delete_product"
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
                            <input type="hidden" name="id" value="1" />
                            <p>Are you sure you want to delete this product?</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-danger" value="delete" />
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- ------------------------------------------Update/add modal------------------------------------------------------------- -->
        <form action="/products/edit_product" method="post">
            <div
                class="modal fade"
                id="product"
                data-bs-backdrop="static"
                data-bs-keyboard="true"
                tabindex="-1"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!------Upadte/add input field-------->
                            <input type="hidden" name="id" value="1" />
                            <div class="mb-1">
                                <label for="name" class="form-label">Product Name</label>
                                <input
                                    type="text"
                                    required
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    value="product name"
                                />
                            </div>

                            <div class="mb-2">
                                <label for="Description" class="form-label">Description</label>
                                <textarea class="form-control" required id="Description" name="description" rows="3">
111</textarea
                                >
                            </div>

                            <div class="row">
                                <div class="mb-1 col-6">
                                    <label for="stocks" class="form-label">Inventory</label>
                                    <input
                                        type="number"
                                        required
                                        class="form-control"
                                        id="stocks"
                                        name="stocks"
                                        value="10"
                                    />
                                </div>

                                <div class="mb-1 col-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input
                                        type="number"
                                        required
                                        class="form-control"
                                        id="price"
                                        name="price"
                                        value="10"
                                    />
                                </div>
                                <!------Category Dropdown-------->
                                <div class="mb-1 col-12 dropdown">
                                    <button
                                        class="btn btn-primary dropdown-toggle w-100"
                                        type="button"
                                        id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        Category
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li class="position-relative">
                                            <a class="dropdown-item" href="#"><input class="w-75" type="text" /></a>
                                            <span id="modal_edit" class="material-icons-outlined"> edit </span>
                                            <span id="modal_delete" class="material-icons-outlined"> delete </span>
                                        </li>
                                        <li class="position-relative">
                                            <a class="dropdown-item" href="#"><input class="w-75" type="text" /></a>
                                            <span id="modal_edit" class="material-icons-outlined"> edit </span>
                                            <!-- <i class="fas fa-pen position-absolute" style="right: 40px; top: 5px"></i> -->
                                            <span id="modal_delete" class="material-icons-outlined"> delete </span>
                                        </li>
                                        <li class="position-relative">
                                            <a class="dropdown-item" href="#"><input class="w-75" type="text" /></a>
                                            <span id="modal_edit" class="material-icons-outlined"> edit </span>
                                            <!-- <i class="fas fa-pen position-absolute" style="right: 40px; top: 5px"></i> -->
                                            <span id="modal_delete" class="material-icons-outlined"> delete </span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mb-1 col-12">
                                    <label for="add_new_categ" class="form-label">Add new category</label>
                                    <input
                                        type="number"
                                        required
                                        class="form-control"
                                        id="add_new_categ"
                                        name="add_new_categ"
                                        value="10"
                                    />
                                </div>
                                <!------Images-------->
                                <div class="mb-4 col-12">
                                    <label for="add_new_categ" class="form-label">images</label>
                                    <input type="button" value="upload Image" class="btn btn-primary" />
                                </div>

                                <div class="row align-items-center">
                                    <i class="fas fa-bars col-1"></i>
                                    <div class="col-4">
                                        <img class="modal_image" src="../Assets/imgs/product1.jpg" alt="mouse" />
                                    </div>
                                    <p class="col-3">img.png</p>
                                    <span class="material-icons-outlined col-1"> delete </span>
                                    <input class="col-1" type="checkbox" />
                                    <p class="col-1 m-0 p-0">main</p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="button" class="btn btn-success" value="preview" />
                            <input type="submit" class="btn btn-primary" value="update" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
