$(document).ready(function () {
	$("input[name=confirm_password]").keyup(function () {
		if ($(this).val() == $("input[name=password]").val()) {
			$(this).prev().css("color", "rgb(124, 255, 141)");
		} else {
			$(this).prev().css("color", "rgb(111, 111, 111)");
		}
	});
	$("input[type=number], input[type=text], input[type=password]").focus(function () {
		$(this).parent().css("border-bottom", "2px solid white");
	});
	$("input[type=number], input[type=text], input[type=password").focusout(function () {
		$(this).parent().css("border-bottom", "2px solid rgb(24, 24, 24)");
	});
});
