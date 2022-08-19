$(document).ready(function () {
	$("#search-sort").on("submit", function () {
		$.get(
			`${base_url}vendors/orders_html`,
			$(this).serialize(),
			function (res) {
				$("tbody").html(res);
			}
		);
		return false;
	});
	$("#filter").change(function () {
		$("#search-sort").submit();
	});
	$("#search-sort").submit();
	/* change status on change */
	$(".status-select").on("change", function () {
		$(this).parent("form").submit();
	});
});
