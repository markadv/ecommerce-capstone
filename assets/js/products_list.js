$(document).ready(function () {
	$(function () {
		$("#sortable").sortable();
	});
	$(".category").children("a").hide();
	$(".category").hover(
		function () {
			$(this).children("a").show();
		},
		function () {
			$(this).children("a").hide();
		}
	);
	$(".modal_edit").click(function (e) {
		e.preventDefault();
		e.stopPropagation();
		$(this).siblings("input").prop("readonly", false);
		focus();
	});
	$(".category")
		.children("input")
		.focusout(function () {
			$(this).children("input").prop("readonly", false);
		});
	$(".modal_delete").click(function (e) {
		e.preventDefault();
		e.stopPropagation();
		$("#confirm-category-delete").attr(
			"data-id",
			$(this).siblings("input").attr("name")
		);
		$("#delete_category").modal("show");
	});
	$("#confirm-category-delete").click(function () {
		var data = $("#confirm-category-delete").attr("data-id");
		$(`[name=${data}]`).attr("value", "remove-category");
		$(`[name=${data}]`).parent().hide();
	});
	$("#add_product").bind("click", function () {
		$("#add_update_modal_title").text("Add product");
	});
	$(".edit_product").bind("click", function () {
		$("#add_update_modal_title").text("Edit product");
	});
	$(".delete_product").bind("click", function () {
		$("#delete_product_form")
			.children("[name=product_id]")
			.attr("value", $(this).attr("data-id"));
	});
	$(".category")
		.children("input")
		.click(function () {
			var category_id = $(this).attr("name").split("-")[1];
			var category = $(this).val();
			console.log(category);
			$(this)
				.parent()
				.parent()
				.siblings("[name=category-selected]")
				.val(category_id);
			$(this).parent().parent().siblings("button").text(category);
		});
});
