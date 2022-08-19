$(document).ready(function () {
	$("form").submit(function () {
		$.post(`${base_url}catalog_html`, $(this).serialize(), function (res) {
			$("#catalog_container").html(res);
		});
		return false;
	});
	$("#catalog-search").on("input", function () {
		$("form").submit();
	});
	$("select").change(function () {
		$("form").submit();
	});
	$(".categories-selection").click(function () {
		$("#category_id").attr("value", $(this).data("id"));
		$("h1").text($(this).data("name"));
		$("form").submit();
	});
	$("form").submit();
});
