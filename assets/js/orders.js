$(document).ready(function () {
	$("#search-sort").on("submit", function () {
		$.get(
			`${base_url}vendors/orders_html`,
			$(this).serialize(),
			function (res) {
				$("tbody").html(res);
				$(".status-select").on("change", function () {
					$(this).parent("form").submit();
				});
			}
		);
		return false;
	});
	$("#filter").change(function () {
		$("#search-sort").submit();
	});
	$("#search-sort").submit();
	/* change status on change */
});
