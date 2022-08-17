        <!-- Cart -->
        <div class="container">
            <div class="border border-primary bg-light mt-3 row">
                <div class="col-10">
                    <span class="material-icons-outlined align-middle"> local_shipping </span>
                    <span>Select free shipping voucher below to enjoy shipping discount</span>
                </div>
                <a class="col-2 text-primary" href="<?= base_url() ?>products/catalog">Go back to shoppping</a>
            </div>
            
<?php
$price_total = 0;
if (isset($cart)) { ?>
            <div class="border bg-light my-3 row">
                <div class="col-5">
                    <input type="checkbox" name="check_all" value="1" />
                    <span>Product</span>
                </div>
                <span class="col-1">Unit price</span>
                <span class="col-2">Quantity</span>
                <span class="col-2">Total price</span>
                <span class="col-2">Actions</span>
            </div>
<?php foreach ($products as $row) {
	$price_total += $row["price"] * $cart[$row["id"]]; ?>
            <div class="border row align-items-center my-3">
                <div class="col-12 w-100 py-2 bg-light">
                    <input type="checkbox" name="shop" value="ph" />
                    <span>Brand</span>
                </div>
                <form action="<?= base_url() ?>products/add_item" method="post" class="product-form needs-validation">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                    <input 
                            type="hidden"
                            name="product_id"
                            value="<?= $row["id"] ?>" />
                    <div class="w-100">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <input type="checkbox" name="check_all" value="1" />
                                <img
                                    src="<?= base_url() ?>assets/imgs/<?= $picture_main[
	$row["id"]
] ?>"
                                    alt="<?= $row["name"] ?>" />
                                <a href="<?= base_url() ?>/products/show_product/<?= $row[
	"id"
] ?>"><?= $row["name"] ?></a>
                            </div>
                            <div data-price="<?= $row[
                            	"price"
                            ] ?>" class="col-1 price">&#8369;<?= $row[
	"price"
] ?></div>
                            <div class="col-2"><input class="quantity" type="number" name="quantity" min="1" step="1" value="<?= $cart[
                            	$row["id"]
                            ] ?>"/></div>
                            <div data-total-price="<?= $row["price"] *
                            	$cart[
                            		$row["id"]
                            	] ?>" class="total-price col-2">&#8369;
                                <?= number_format(
                                	$row["price"] * $cart[$row["id"]],
                                	2
                                ) ?>
                            </div>
                            <div class="col-2">
                                <a class="btn btn-danger" href="">Delete</a>
                                <!-- Future implementation <a href="">Find similar</a> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="border row align-items-center my-3 py-2">
                <div class="w-100">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <!-- Future implementation -->
                            <!-- <input type="checkbox" name="check_all" value="1" />
                            <label for="check_all">Select all(2)</label>
                            <a class="btn btn-danger" href="">Delete</a>
                            <a href="">Remove inactive</a> -->
                        </div>
                        <div class="col-3">
                            <!-- <label for="voucher">Voucher:</label><input type="text" name="voucher" /> -->
                        </div>
                        <div id="sum-price" class="col-2">&#8369; <?= number_format(
                        	$price_total,
                        	2
                        ) ?></div>
                        <div class="col-2">
                            <a class="btn btn-primary" href="<?= base_url() ?>products/checkout">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
<?php
}} else { ?>
    <h2 class="display-6">Hmm... something is missing...</h2>
    <?php }
?>
            
        </div>
    </body>
</html>
