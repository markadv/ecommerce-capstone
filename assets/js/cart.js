$(document).ready(function () {
	$("form").submit(function (e) {
		e.preventDefault();
		console.log($("form").prop("action"));
		$.ajax({
			type: "POST",
			url: $("form").prop("action"),
			data: $(this).serialize(),
			dataType: "json",
			success: function (data) {
				alert(data);
			},
		});
	});
	$(".quantity").bind("input", function () {
		$(this)
			.parent()
			.siblings(".total-price")
			.html(
				"&#8369; " +
					parseFloat(
						$(this).parent().siblings(".price").data("price") * $(this).val()
					).toFixed(2)
			)
			.attr(
				"data-total-price",
				$(this).parent().siblings(".price").data("price") * $(this).val()
			);
		total_calculate();
		$(this).closest("form").submit();
	});
	function total_calculate() {
		totalPrice = 0;
		$(".total-price").each(function () {
			totalPrice += parseFloat($(this).attr("data-total-price"));
		});
		console.log(totalPrice);
		$("#sum-price").html("&#8369; " + parseFloat(totalPrice).toFixed(2));
	}
});
