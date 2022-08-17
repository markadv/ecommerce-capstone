$(document).ready(function () {
	$("[name=same_shipping").click(function () {
		if ($(this).is(":checked")) {
			$("[name=address1_billing]").val($("[name=address1_shipping]").val());
			$("[name=address2_billing]").val($("[name=address2_shipping]").val());
			$("[name=city_billing]").val($("[name=city_shipping]").val());
			$("[name=state_billing]").val($("[name=state_shipping]").val());
			$("[name=postal_code_billing]").val(
				$("[name=postal_code_shipping]").val()
			);
			$("[name=form_billing_address input");
			$("[name=form_billing_address [type=submit]");
			$("[name=form_billing_address [type=checkbox]");
		} else {
			$("[name=address1_billing]").val("");
			$("[name=address2_billing]").val("");
			$("[name=city_billing]").val("");
			$("[name=state_billing]").val("");
			$("[name=postal_code_billing]").val("");
			$("[name=form_billing_address input");
		}
	});
});
