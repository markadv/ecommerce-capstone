$(document).ready(function () {
	$("#sidebarCollapse").on("click", function () {
		$("#sidebar").toggleClass("active");
		$(this).toggleClass("active");
	});
	$("form").on("submit", function () {
		$.get(
			`${base_url}products/catalog_html`,
			$(this).serialize(),
			function (res) {
				$("#catalog_container").html(res);
			}
		);
		return false;
	});
	$("input").keyup(function () {
		$("form").submit();
	});
	$("select").change(function () {
		$("form").submit();
	});
	$("form").submit();
});
