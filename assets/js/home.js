$(document).ready(function () {
	var swiper = new Swiper(".swiper", {
		// Optional parameters
		speed: 400,
		// If we need pagination
		pagination: {
			el: ".swiper-pagination",
			dynamicBullets: true,
		},

		// Navigation arrows
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		// Autoplay
		autoplay: {
			delay: 4000,
		},
		loop: true,
	});
});
