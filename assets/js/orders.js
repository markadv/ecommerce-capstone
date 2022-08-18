$(document).ready(function () {
	$("select").change(function () {
		$(this).parent("form").submit();
	});
});
