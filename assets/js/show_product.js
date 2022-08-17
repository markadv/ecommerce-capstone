$(document).ready(function () {
	var swiper = new Swiper(".mySwiper", {
		loop: true,
		slidesPerView: 4,
		freeMode: true,
		watchSlidesProgress: true,
	});
	var swiper2 = new Swiper(".mySwiper2", {
		loop: true,
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		thumbs: {
			swiper: swiper,
		},
	});
	$("#add-shopping-cart").click(function () {
		$("form").on("submit", function (e) {
			e.preventDefault();
			var dataString = $($this).serialize();
			$.ajax({
				type: "POST",
				url: "http://secretshop/products/add_cart",
				data: dataString,
				success: function (message) {
					alert(message);
				},
			});
		});
	});
});
