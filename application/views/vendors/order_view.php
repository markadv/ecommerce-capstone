        <!-------------Order Info---------------->
        <div class="container py-3">
            <div class="row">
                <div class="col-3">
                    <ul class="list-group">
                        <li class="list-group-item">Order ID: 1</li>
                        <li class="list-group-item">Shipping info:</li>
                        <li class="list-group-item">
                            <p>Name: <?= $addresses["s_first_name"] .
                            	" " .
                            	$addresses["s_last_name"] ?></p>
                            <p>Address 1: <?= $addresses["s_address1"] ?></p>
                            <p>Address 2: <?= $addresses["s_address2"] ?></p>
                            <p>City: <?= $addresses["s_city"] ?></p>
                            <p>State: <?= $addresses["s_state"] ?></p>
                            <p>Zip: <?= $addresses["s_postal_code"] ?></p>
                        </li>
                        <li class="list-group-item">Billing info:</li>
                        <li class="list-group-item">
                            <p>Name: <?= $addresses["b_first_name"] .
                            	" " .
                            	$addresses["b_last_name"] ?></p>
                            <p>Address 1: <?= $addresses["b_address1"] ?></p>
                            <p>Address 2: <?= $addresses["b_address2"] ?></p>
                            <p>City: <?= $addresses["b_city"] ?></p>
                            <p>State: <?= $addresses["b_state"] ?></p>
                            <p>Zip: <?= $addresses["b_postal_code"] ?></p>
                        </li>
                    </ul>
                </div>
                <div class="col-9">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Item</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($products as $row) { ?>
                            <tr>
                                <td><?= $row["product_id"] ?></td>
                                <td><?= $row["name"] ?></td>
                                <td>&#8369;<?= $row["price"] ?></td>
                                <td><?= $row["quantity"] ?></td>
                                <td>&#8369;<?= $total = number_format(
                                	$row["price"] * $row["quantity"],
                                	2
                                ) ?></td>
                            </tr>
<?php } ?> 
                        </tbody>
                    </table>
                    <ul class="list-group d-inline-block">
                        <a href="<?= base_url() ?>/vendors/orders"<li class="list-group-item bg-success text-white">
                            Status: <?= convert_status(
                            	$addresses["status"]
                            ) ?></li></a>
                        <li class="list-group-item">
                            <p>Subtotal: &#8369;<?= $total ?></p>
                            <p>Shipping: &#8369;100.00</p>
                            <p>Total price: &#8369;<?= number_format(
                            	(float) $total + 100,
                            	2
                            ) ?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
