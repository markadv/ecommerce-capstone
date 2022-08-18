<?php defined("BASEPATH") or exit("No direct script access allowed");
foreach ($order_details as $row) {
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
	: "" ?> ><?= $value ?></option>
<?php } ?>
                                    </select>
                                </form>
                            </td>
                        </tr>
<?php
} ?>
