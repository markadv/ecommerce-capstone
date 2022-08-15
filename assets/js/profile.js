$(document).ready(function () {
	$("#same_shipping").click(function () {
		if ($(this).is(":checked")) {
			$(".address1_billing").val($(".address1_shipping").val());
			$(".address2_billing").val($(".address2_shipping").val());
			$(".city_billing").val($(".city_shipping").val());
			$(".state_billing").val($(".state_shipping").val());
			$(".postal_code_billing").val($(".postal_code_shipping").val());
			$("#form_billing_address input");
			$("#form_billing_address [type=submit]");
			$("#form_billing_address [type=checkbox]");
		} else {
			$(".address1_billing").val("");
			$(".address2_billing").val("");
			$(".city_billing").val("");
			$(".state_billing").val("");
			$(".postal_code_billing").val("");
			$("#form_billing_address input");
		}
	});
});
