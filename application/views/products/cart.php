        <!-- Cart -->
        <div class="container">
            <div class="border border-primary bg-light mt-3 row">
                <div class="col-10">
                    <span class="material-icons-outlined align-middle"> local_shipping </span>
                    <span>Select free shipping voucher below to enjoy shipping discount</span>
                </div>
                <a class="col-2 text-primary" href="">Go back to shoppping</a>
            </div>
            <div class="border bg-light my-3 row">
                <div class="col-6">
                    <input type="checkbox" name="check_all" value="1" />
                    <span>Product</span>
                </div>
                <span class="col-1">Unit price</span>
                <span class="col-2">Quantity</span>
                <span class="col-1">Total price</span>
                <span class="col-2">Actions</span>
            </div>
<?php foreach ($products as $row) { ?>
            <div class="border row align-items-center my-3">
                <div class="col-12 w-100 py-2 bg-light">
                    <input type="checkbox" name="shop" value="ph" />
                    <span>Brand</span>
                </div>
                <div class="border w-100">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <input type="checkbox" name="check_all" value="1" />
                            <img src="<?= base_url() ?>assets/imgs/<?= $picture_main[
	$row["id"]
] ?>"
                                alt="<?= $row["name"] ?>" />
                            <a href="">Dr. Browns Natural Flow Baby Bottle</a>
                        </div>
                        <div class="col-1">&#8369;100</div>
                        <div class="col-2"><input type="number" name="quantity" value="1" min="1" step="1" /></div>
                        <div class="col-1">&#8369;100</div>
                        <div class="col-2">
                            <a href="">Delete</a>
                            <a href="">Find similar</a>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>
            <div class="border row align-items-center my-3">
                <div class="border w-100">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <input type="checkbox" name="check_all" value="1" />
                            <label for="check_all">Select all(2)</label>
                            <a href="">Delete</a>
                            <a href="">Remove inactive</a>
                        </div>
                        <div class="col-3">
                            <label for="voucher">Voucher:</label><input type="text" name="voucher" />
                        </div>
                        <div class="col-1">&#8369;200</div>
                        <div class="col-2">
                            <a class="btn btn-primary" href="">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
