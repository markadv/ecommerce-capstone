<?php defined("BASEPATH") or exit("No direct script access allowed"); ?>
	<!-- Error Indicator -->
		<div class="error"><p><?= isset($errors) ? $errors : "" ?></p></div>
		<div class="success"><p><?= isset($success) ? $success : "" ?></p></div>
		<div class="container mt-3">
			<!-- Search -->
		<div class="mb-3 row">
			<div class="col-12 col-md-9">
				<form class="d-flex w-100 ms-auto me-auto" role="search">
					<input
						class="form-control me-2"
						type="search"
						placeholder="Search"
						aria-label="Search"
					/>
					<button class="btn btn-outline-primary" type="submit">Search</button>
				</form>
			</div>
		<!------Add product-------->
			<div class="col-12 col-md-3">
				<button
					id="add_product"
					class="btn btn-primary w-100"
					data-bs-toggle="modal"
					data-bs-target="#product"
				>
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
					<tr class="product_info_<?= $row["id"] ?>">
						<td><?= $row["id"] ?></td>
						<td>
							<div class="img_container">
								<img class="product_image" src="<?= base_url() .
        	"assets/imgs/" .
        	$picture_main[$row["id"]] ?>" alt="<?= $row["name"] ?>" />
							</div>
						</td>
						<td><?= $row["name"] ?></td>
						<td><?= $row["quantity"] ?></td>
						<td><?= isset($sold[$row["id"]]) ? $sold[$row["id"]] : 0 ?></td>
						<td> &#8369 <?= $row["price"] ?></td>
						<td>
							<a class="btn btn-outline-primary edit_product"
								data-bs-toggle="modal"
								data-bs-target="#product_<?= $row["id"] ?>"
								data-id=<?= $row["id"] ?>
								>
								Edit
							</a>
							<a
								class="btn btn-danger delete_product"
								data-bs-toggle="modal"
								data-bs-target="#delete_product"
								data-id=<?= $row["id"] ?>
								href=""
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
	<form id="delete_product_form" action="<?= base_url() ?>vendors/delete_product/" method="post">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" /> 
		<input type="hidden" name="product_id" value="" />
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
	<!-- ------------------------------------------Update modal------------------------------------------------------------- -->
<?php foreach ($products as $product) { ?>
	<form id="add_product_form" action="<?= base_url() ?>vendors/add_product/" method="post" enctype="multipart/form-data">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
		<input type="hidden" name="product_id" value="<?= $product["id"] ?>" />
		<div
			class="modal fade"
			id="product_<?= $product["id"] ?>"
			data-bs-backdrop="static"
			data-bs-keyboard="true"
			tabindex="-1"
			aria-labelledby="staticBackdropLabel"
			aria-hidden="true"
		>
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="add_update_modal_title">Edit product</h5>
						<button
							type="button"
							class="btn-close"
							data-bs-dismiss="modal"
							aria-label="Close"
						></button>
					</div>
					<div class="modal-body">
						<!------Update/add input field-------->
						<div class="mb-1">
							<label for="name" class="form-label">Product Name</label>
							<input
								type="text"
								required
								class="form-control"
								id="name"
								name="name"
								value="<?= $product["name"] ?>"
							/>
						</div>
						<div class="mb-2">
							<label for="Description" class="form-label">Description</label>
							<textarea
								class="form-control"
								required
								id="description"
								name="description"
								rows="3"
							><?= $product["description"] ?></textarea>
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
									value="<?= $product["quantity"] ?>"
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
									value="<?= $product["price"] ?>"
								/>
							</div>
							<!-- ----Category Dropdown------ -->
							<div class="mb-1 col-12 dropdown">
								<button
									class="btn btn-primary dropdown-toggle w-100"
									type="button" data-bs-toggle="dropdown"
									aria-expanded="false">
									<?= $product["category"] ?>
								</button>
								<input type="hidden" name="category-selected" value="<?= $product[
        	"category_id"
        ] ?>"/>
								<ul class="dropdown-menu w-100">
<?php foreach ($categories as $category) { ?>
									<li class="category position-relative">
										<input name="category-<?= $category[
          	"id"
          ] ?>" class="w-75 dropdown-item" type="text" value="<?= $category[
	"name"
] ?>" readonly/>
										<a href="" class="material-icons-outlined text-decoration-none modal_edit">
											edit
										</a>
										<a href="" class="material-icons-outlined text-decoration-none modal_delete">
											delete
										</a>
									</li>
<?php } ?>
								</ul>
							</div>

							<div class="mb-1 col-12">
								<label for="add_category" class="form-label">Add new category</label>
								<input type="text" class="form-control" id="add_category" name="add_category" />
							</div>
							<!------Images-------->
							<ul class="p-4" id="sortable">
<?php foreach ($all_images[$product["id"]] as $row) { ?>
								<li class="border bg-light row align-items-center">
									<span class="material-icons-outlined col-1">
drag_handle
</span>
									<div class="col-3">
										<img
											class="modal_image text-center"
											src="<?= base_url() ?>assets/imgs/<?= $row ?>"
											alt="mouse"
										/>
										<div class="d-block text-center">
											<input type="radio" 
											name="main_image"
											value="<?= $product["id"] ?>"
											class="d-inline-block"
											/>
											<label for="main_image" class="m-0 p-0 text-centerd d-inline-block">main</labale>
										</div>
									</div>
									<input
											type="file"
											name="files[]"
											class="image-upload form-control col-6"
										/>
									<span id="delete-image" data-id="$row" class="material-icons-outlined col-1"> delete </span>
								</li>
<?php } ?>
							</ul>
						</div>
					</div>

					<div class="modal-footer">
						<button
							type="button"
							class="btn btn-secondary"
							data-bs-dismiss="modal"
						>
							Close
						</button>
						<a href="<?= base_url() ?>products/show_product/<?= $product[
	"id"
] ?>" class="btn btn-success">Preview</a>
						<input type="submit" class="btn btn-primary" value="Update" />
					</div>
				</div>
			</div>
		</div>
	</form>
<?php } ?>
<form id="add_product_form" action="<?= base_url() ?>vendors/add_product/" method="post" enctype="multipart/form-data">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
		<input type="hidden" name="product_id" value="" />
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
						<h5 class="modal-title" id="add_update_modal_title">Edit product</h5>
						<button
							type="button"
							class="btn-close"
							data-bs-dismiss="modal"
							aria-label="Close"
						></button>
					</div>
					<div class="modal-body">
						<!------Update/add input field-------->
						<div class="mb-1">
							<label for="name" class="form-label">Product Name</label>
							<input
								type="text"
								required
								class="form-control"
								id="name"
								name="name"
								value=""
							/>
						</div>
						<div class="mb-2">
							<label for="Description" class="form-label">Description</label>
							<textarea
								class="form-control"
								required
								id="description"
								name="description"
								rows="3"
							></textarea>
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
									value=""
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
									value=""
								/>
							</div>
							<!-- ----Category Dropdown------ -->
							<div class="mb-1 col-12 dropdown">
								<button
									class="btn btn-primary dropdown-toggle w-100"
									type="button" data-bs-toggle="dropdown"
									aria-expanded="false">
									<?= $product["category"] ?>
								</button>
								<input type="hidden" name="category-selected" value="<?= $product[
        	"category_id"
        ] ?>"/>
								<ul class="dropdown-menu w-100">
<?php foreach ($categories as $category) { ?>
									<li class="category position-relative">
										<input name="category-<?= $category[
          	"id"
          ] ?>" class="w-75 dropdown-item" type="text" value="<?= $category[
	"name"
] ?>" readonly/>
										<a href="" class="material-icons-outlined text-decoration-none modal_edit">
											edit
										</a>
										<a href="" class="material-icons-outlined text-decoration-none modal_delete">
											delete
										</a>
									</li>
<?php } ?>
								</ul>
							</div>

							<div class="mb-1 col-12">
								<label for="add_category" class="form-label">Add new category</label>
								<input type="text" class="form-control" id="add_category" name="add_category" />
							</div>
							<!------Images-------->
							<ul class="p-4" id="sortable">
<?php for ($i = 0; $i < 5; $i++) { ?>
								<li class="border bg-light row align-items-center">
									<span class="material-icons-outlined col-1">
drag_handle
</span>
									<div class="col-3">
										<img
											class="modal_image text-center"
											src=""
											alt=""
										/>
										<div class="d-block text-center">
											<input type="radio" 
											name="main_image"
											value=""
											class="d-inline-block"
											/>
											<label for="main_image" class="m-0 p-0 text-centerd d-inline-block">main</labale>
										</div>
									</div>
									<input
											data-id=$i
											type="file"
											name="files[]"
											class="image-upload form-control col-6"
										/>
									<span id="delete-image" data-id="$row" class="material-icons-outlined col-1"> delete </span>
								</li>
<?php } ?>
							</ul>
						</div>
					</div>

					<div class="modal-footer">
						<button
							type="button"
							class="btn btn-secondary"
							data-bs-dismiss="modal"
						>
							Close
						</button>
						<a href="<?= base_url() ?>products/show_product/<?= $product[
	"id"
] ?>" class="btn btn-success">Preview</a>
						<input type="submit" class="btn btn-primary" value="Update" />
					</div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>
