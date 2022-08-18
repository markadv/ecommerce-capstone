$(document).ready(function () {
	$("select").change(function () {
		$(this).parent("form").submit();
	});
	$.get(`${base_url}vendors/orders_html`, function (res) {
		$("#order_table").html(res);
	});
	// $("form").on("submit", function () {
	// 	$.get(
	// 		`${base_url}vendors/orders_html`,
	// 		$(this).serialize(),
	// 		function (res) {
	// 			$("tbody").html(res);
	// 		}
	// 	);
	// 	return false;
	// });
	// $("form").submit();
});
