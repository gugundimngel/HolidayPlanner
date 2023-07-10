"use strict";

// *** General Variables *** //
var $window = $(window),
	$document = $(document),
	$this = $(this),
	$html = $("html"),
	$body = $("body");
// *** On ready *** //
$document.on("ready", function () {
	responsiveClasses();
	imageBG();
	//fitVideos();
	//lightboxImage();
	//lightboxGallery();
	//lightboxIframe();
	onePageNav();
	scrollToAnchor();
	stickyHeaderBar();
	stickyhotelsearch(); 
	sliderBanner();
	sliderServices2();
	sliderTopDestinations();
	sliderPopularPackages();
	sliderTestimonials();
	sliderInstagramFeed();
	sliderPriceRange();
	//bannerTabs();
	hotelInfoTabs();
	sliderRelatedPosts();
	sliderAirfaresCalender();
	sliderHotelPreview();
	sliderPostPrevNext();
	//languageSelect();
	//countrySelect();
	itemClickCounter();
	formDatepicker();
	dropdownPassengers();
	multipleDestinations();
	sliderFeaturedCars();
	optionsSelect2();
	formLabelStyle1();
	menuMain();
	mobileMenuSidePanel();
	mobileMenu();
	sliderImageBG();
	optimizeSliderImageBG();	
	sectionParallaxImageBG();
	bannerParallaxImageBG();	
});
// *** On load *** //
$window.on("load", function () {
	websiteLoading();
	popupRegister();
	popupLogin();
	popupLanguageChoice();
	popupForgotPass();
})
	// *** On resize *** //
	.on("resize", function () {
		responsiveClasses();
		//bannerTabs();
		hotelInfoTabs();
	})
	// *** On scroll *** //
	.on("scroll", function () {
		scrollTopIcon();
		stickyHeaderBar();
		stickyhotelsearch();
	});
// *** Responsive Classes *** //
function responsiveClasses() {
	var jRes = jRespond([
		{
			label: "smallest",
			enter: 0,
			exit: 479
		}, {
			label: "handheld",
			enter: 480,
			exit: 767
		}, {
			label: "tablet",
			enter: 768,
			exit: 991
		}, {
			label: "laptop",
			enter: 992,
			exit: 1199
		}, {
			label: "desktop",
			enter: 1200,
			exit: 10000
		}
	]);
	jRes.addFunc([
		{
			breakpoint: "desktop",
			enter: function () { $body.addClass("device-lg"); },
			exit: function () { $body.removeClass("device-lg"); }
		}, {
			breakpoint: "laptop",
			enter: function () { $body.addClass("device-md"); },
			exit: function () { $body.removeClass("device-md"); }
		}, {
			breakpoint: "tablet",
			enter: function () { $body.addClass("device-sm"); },
			exit: function () { $body.removeClass("device-sm"); }
		}, {
			breakpoint: "handheld",
			enter: function () { $body.addClass("device-xs"); },
			exit: function () { $body.removeClass("device-xs"); }
		}, {
			breakpoint: "smallest",
			enter: function () { $body.addClass("device-xxs"); },
			exit: function () { $body.removeClass("device-xxs"); }
		}
	]);
}
// *** RTL Case *** //
var HTMLDir = $("html").css("direction"),
	carouselRtl,
	selectRtl,
	slickDirection;
// If page is RTL
if (HTMLDir == "rtl") {
	$("body").addClass("direction-rtl");
	
	carouselRtl = true;
	selectRtl = "rtl";
	slickDirection = true;
} else {
	carouselRtl = false;
	selectRtl = false;
	slickDirection = false;
}
// *** Image Background *** //
function imageBG() {
	$(".img-bg").each(function () {
		var $this = $(this),
			imgSrc = $this.find("img").attr("src");

		if ($this.parent(".section-image").length) {
			$this.css("background-image", "url('" + imgSrc + "')");
		} else {
			$this.prepend("<div class='bg-element'></div>");
			var bgElement = $this.find(".bg-element");
			bgElement.css("background-image", "url('" + imgSrc + "')");
		}
		$this.find("img").css({ "opacity": 0, "visibility": "hidden" });
	});
}
// *** Fit Videos *** //
function fitVideos() {
	$("#full-container").fitVids();
}
// *** Banner Parallax Image BG *** //
function bannerParallaxImageBG() {
	var bannerParallax = $(".banner-parallax"),
		imgSrc = bannerParallax.children("img:first-child").attr("src");
	bannerParallax.prepend("<div class='bg-element'></div>");
	var bgElement = bannerParallax.find("> .bg-element");
	bgElement.css("background-image", "url('" + imgSrc + "')").attr("data-stellar-background-ratio", 0.2);
}
// *** Lightbox Iframe *** //
function lightboxIframe() {
	$(".lightbox-iframe").magnificPopup({
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});
}
// *** Lightbox Image *** //
function lightboxImage() {
	$(".lightbox-img").magnificPopup({
		type: 'image',
		gallery: {
			enabled: false
		},
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});
}
// *** Lightbox Gallery *** //
function lightboxGallery() {
	$( ".list-lightbox-gallery" ).each( function() {
		$(this).find(".lightbox-gallery").magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			},
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	} );
}
// *** Scroll Top Icon *** //
function scrollTopIcon() {
	var windowScroll = $(window).scrollTop();
	if (windowScroll > 800) {
		$(".scroll-top-icon").addClass("show");
	} else {
		$(".scroll-top-icon").removeClass("show");
	}
}
$(".scroll-top").on("click", function (e) {
	e.preventDefault();
	$("html, body").animate({
		scrollTop: 0
	}, 1200); //1200 easeInOutExpo
});
// *** One Page Nav *** //
function onePageNav() {
	var stickyBar = $(".header-bar.sticky"),
		stickyBarHeight = stickyBar.height() - 20,
		offsetDifference = (!stickyBar) ? 0 : stickyBarHeight;
	$.scrollIt({
		upKey: false,
		downKey: false,
		scrollTime: 600,
		activeClass: 'current',
		onPageChange: null,
		topOffset: -offsetDifference
	});
}
// *** Scroll To Anchor *** //
function scrollToAnchor() {
	var stickyBar = $(".header-bar.sticky"),
		stickyBarHeight = stickyBar.height(),
		offsetDifference = (!stickyBar) ? 0 : stickyBarHeight;
	$(".scroll-to").on("click", function (e) {
		e.preventDefault();
		var $anchor = $(this);

		// scroll to specific anchor
		$("html, body").stop().animate({
			scrollTop: $($anchor.attr("href")).offset().top - offsetDifference
		}, 800 );
	});
}
// *** Slider Image BG *** //
function sliderImageBG() {
	$(".slider-img-bg .slick-slide").each(function () {
		var $this = $(this),
			imgSrc = $this.find(".slide").children("img").attr("src");
		$this.prepend("<div class='bg-element'></div>");
		var bgElement = $this.find("> .bg-element");
		bgElement.css("background-image", "url('" + imgSrc + "')");
	});
}
// *** Optimize Slider Image BG *** //
function optimizeSliderImageBG() {
	$(".slider-img-bg").each(function () {
		var imgHeight = $(this).closest("div").height();

		if ($(".banner-parallax").children(".banner-slider").length > 0) {
			// $( ".banner-parallax, .banner-parallax .row > [class*='col-']" ).height( $( ".banner-slider" ).height() );
		}

		$(this).find(".owl-item > li .slide").children("img").css({
			"display": "none",
			"height": imgHeight,
			"opacity": 0
		});
	});
}
// Custom banner height
$(".banner-parallax").each(function () {
	var customBannerHeight = $(this).data("banner-height"),
		boxContent = $(this).find(".row > [class*='col-']");
	$(this).css("min-height", customBannerHeight);
	$(boxContent).css("min-height", customBannerHeight);
});

// *** Section Parallax Image BG *** //
function sectionParallaxImageBG() {
	$(".section-parallax").each(function () {
		var parallaxSection = $(this),
			imgSrc = parallaxSection.children("img:first-child").attr("src");

		parallaxSection.prepend("<div class='bg-element'></div>");
		var bgElement = parallaxSection.find("> .bg-element");
		bgElement.css("background-image", "url('" + imgSrc + "')").attr("data-stellar-background-ratio", 0.2);
	});
}
// *** Slider Banner *** //
function sliderBanner() {
	var sliderBanner = $('.slider-banner > .slick-slider');
	sliderBanner.slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		infinite: false,
		rtl: slickDirection,
		arrows: false,
		touchThreshold: 20
	});
}
// *** Slider Services 2 *** //
function sliderServices2() {
	var sliderServices2 = $('.slider-services-2 > .slick-slider');
	sliderServices2.slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: true,
		infinite: false,
		rtl: slickDirection,
		arrows: false,
		touchThreshold: 20,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});
}
// *** Slider Top Destinations *** //
function sliderTopDestinations() {
	$(".slider-top-destinations").each(function () {
		var sliderTopDestinations = $(this).find(".slick-slider");
		sliderTopDestinations.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			dots: false,
			rtl: slickDirection,
			arrows: true,
			touchThreshold: 20,
			// centerMode: true,
			infinite: true,
			appendArrows: $(this).find('.slick-arrows'),
			prevArrow: '<a href="javascript:;" class="slick-prev"><i class="fas fa-arrow-down"></i></a>',
			nextArrow: '<a href="javascript:;" class="slick-next"><i class="fas fa-arrow-up"></i></a>',
			responsive: [
				{
					breakpoint: 1400,
					settings: {
						slidesToShow: 4
					}
				},
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1
					}
				}
			]
		});
	});
}


// *** Slider Popular Packages *** //
function sliderPopularPackages() {
	$( ".slider-popular-packages" ).each( function() {
		var sliderPopularPackages = $(this).find( ".slick-slider" );
		sliderPopularPackages.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			dots: false,
			infinite: false,
			rtl: slickDirection,
			arrows: true,
			touchThreshold: 20,
			// centerMode: true,
			appendArrows: $(this).find('.slick-arrows'),
			prevArrow: '<a href="javascript:;" class="slick-prev"><i class="fas fa-arrow-down"></i></a>',
			nextArrow: '<a href="javascript:;" class="slick-next"><i class="fas fa-arrow-up"></i></a>',
			responsive: [
				{
					breakpoint: 1400,
					settings: {
						slidesToShow: 4
					}
				},
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1
					}
				}
			]
		});
	} );
}

 
// *** Slider Testimonials *** //
function sliderTestimonials() {
	var sliderTestimonials = $('.slider-testimonials > .slick-slider');
	sliderTestimonials.slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		infinite: false,
		rtl: slickDirection,
		arrows: false,
		touchThreshold: 20,
		// centerMode: true,
		responsive: [
			{
				breakpoint: 1400,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});
}
// *** Slider Instagram Feed *** //
function sliderInstagramFeed() {
	var sliderInstagramFeed = $('.slider-instagram-feed > .slick-slider');
	sliderInstagramFeed.slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		dots: false,
		infinite: true,
		rtl: slickDirection,
		arrows: false,
		touchThreshold: 20,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 5
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 4
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2
				}
			}
		]
	});
}


// *** Menu Main *** //
function menuMain() {
	// Firing Superfish plugin
	$(".menu-main").superfish({
		popUpSelector: "ul",
		cssArrows: true,
		delay: 0,
		speed: 150,
		speedOut: 150,
		animation: {
			opacity: "show",
			marginTop: 0
		}, //  , height : "show"
		animationOut: {
			opacity: "hide",
			marginTop: 20
		}
	});
}


// *** Mobile Menu Side Panel *** //
function mobileMenuSidePanel() {
	$("body").append("<div class='popup-preview-overlay'>");

	$(".popup-preview-overlay").add(".side-panel-close").on("click", function (e) {
		e.preventDefault();
		$(".popup-preview-overlay").toggleClass("viewed");
		$(".side-panel-menu").removeClass("viewed");
		$(".menu-mobile-btn").find(".hamburger").toggleClass("is-active");
		$("html").toggleClass("scroll-lock");
	});
}


// *** Mobile Menu *** //
function mobileMenu() {
	// Cloning Main Menu to Mobile Menu
	$("#menu-main").children().clone().appendTo("#menu-mobile");

	// console.log( $( "#menu-mobile-wrap" ).outerHeight() );

	$(".menu-mobile a").each(function (e) {
		if ($(this).next(".sub-menu").length) {
			// $( this ).addClass( "ddddddd" );
			$(this).closest("li").addClass("has-ul");
		}
	})

	$(".menu-mobile a").on("click", function (e) {
		var $this = $(this);
		if ($this.next(".sub-menu").length) {
			e.preventDefault();
			if ($this.next().hasClass("viewed")) {
				$this.next().removeClass("viewed");
				$this.parent().find(".active").removeClass("active")
				$this.next().slideUp(250);
			} else {
				$this.parent().parent().find(".active").removeClass("active");
				$this.parent("ul").find(".active").removeClass("active")
				$this.parent().parent().find("li .sub-menu").removeClass("viewed");
				$this.parent().parent().find("li .sub-menu").slideUp(250);
				$this.toggleClass("active");
				$this.next().toggleClass("viewed");
				$this.next().slideToggle(250);
			}
		}
	});

	// Toggle Mobile Menu
	$(".menu-mobile-btn").on("click", function (e) {
		e.preventDefault();
		$(this).find(".hamburger").toggleClass("is-active");
		$("#menu-mobile-wrap").stop().slideToggle(200);
	});

	$(".menu-mobile-btn").on("click", function (e) {
		e.preventDefault();
		$(".side-panel-menu").addClass("viewed");
		$(".popup-preview-overlay").addClass("viewed");
		$html.addClass("scroll-lock");
	});
}


// *** Sticky Nav *** //
function stickyHeaderBar() {
	var windowScroll = $(window).scrollTop(),
		headerBar = $(".header-bar");

	headerBar.each(function () {
		var $this = $(this);

		if ($this.hasClass("sticky")) {
			if (windowScroll > $this.offset().top) {
				$this.addClass("is-sticky");
				// logo.attr( "src" , logoSrc ); 
			} else {
				$this.removeClass("is-sticky");
			}
		}
	});
}

function stickyhotelsearch() {
	var windowScroll = $(window).scrollTop(),
		hotelsearch = $(".hotel_content_sec");

	hotelsearch.each(function () {
		var $this = $(this);
 
		if ($this.hasClass("sticky")) {
			if (windowScroll > $this.offset().top) {
				$this.addClass("is-sticky");
				// logo.attr( "src" , logoSrc );
			} else {
				$this.removeClass("is-sticky");
			}
		}
	});
}


// *** Scroll To *** //
$(".scroll-to").on("click", function (e) {
	e.preventDefault();
	var $anchor = $(this);

	// scroll to specific anchor
	$("html, body").stop().animate({
		scrollTop: $($anchor.attr("href")).offset().top
	}, 1200);
});


// *** Website Loading *** //
function websiteLoading() {
	$("#website-loading").find(".loader, .logo-loader").delay(1500).fadeOut(250);
	$("#website-loading").delay(2000).fadeOut(300);
}




// *** Banner Reservation Tabs *** //
function bannerTabs() {
	$(".br-tabs > li").addClass("br-item");

	// Variables
	var clickedTab = $(".br-tabs > .active");
	var tabWrapper = $(".br-tabs-content");
	var activeTab = tabWrapper.find(".active");
	var activeTabHeight = activeTab.outerHeight();

	// Show tab on page load
	activeTab.show();

	// Set height of wrapper on page load
	tabWrapper.height(activeTabHeight);

	$(".br-tabs .br-item").on("click", function () {

		if (!$(this).hasClass("active")) {
			// Remove class from active tab
			$(".br-tabs .br-item").removeClass("active");

			// Add class active to clicked tab
			$(this).addClass("active");

			// Update clickedTab variable
			clickedTab = $(".br-tabs .active");

			// fade out active tab
			activeTab.animate({ top: 10 }, { duration: 200, queue: false }).fadeOut(200, function () {

				// Remove active class all tabs
				$(".br-tabs-content > li").removeClass("active");

				// Get index of clicked tab
				var clickedTabIndex = clickedTab.index();

				// Add class active to corresponding tab
				$(".br-tabs-content > li").eq(clickedTabIndex).addClass("active");

				
				// update new active tab
				activeTab = $(".br-tabs-content > .active");
				
				// Update variable
				activeTabHeight = activeTab.outerHeight();
				
				// Animate height of wrapper to new tab height
				tabWrapper.stop().delay(0).animate({
					height: activeTabHeight
				}, 200, function () {
					
					// Fade in active tab
					activeTab.delay(0).css("top", 10)
					.animate({ top: 0 }, { duration: 150, queue: false }).fadeIn(100, function() {
					});
					
				});
				
			});
		}
	});
}


// *** Popup Login Register *** //
if ($(".popup-preview-2").length) {
	$("body").append("<div class='popup-preview-overlay-2'>");
}
function popupRegister() {
	$( ".popup-preview-register" ).each( function() {
		var $this = $( this ),
		btnRegister = $this.find( ".popup-btn-register" ),
			popupBg = $this.find(".popup-bg"),
			popupClose = $this.find(".popup-close");
		$(".popup-btn-register").add(popupBg).add(popupClose).on("click", function (e) {
			e.preventDefault();
			$(".popup-preview-register").toggleClass("viewed");
			$(".popup-preview-login").removeClass("viewed");
			
			if($(".popup-preview-register").hasClass("viewed")){
				
				$(".popup-preview-overlay-2").addClass("viewed");
					$("html").addClass("scroll-lock");
			}else{
				$(".popup-preview-overlay-2").removeClass("viewed");
				$("html").removeClass("scroll-lock");				
			}
		
			
			
		});
	});
}

function popupLogin() {
	$(".popup-preview-login").each(function () {
		var $this = $(this),
			popupBg = $this.find(".popup-bg"),
			popupClose = $this.find(".popup-close");
		$(".popup-btn-login").add(popupBg).add(popupClose).on("click", function (e) {
			e.preventDefault();
			$(".popup-preview-login").toggleClass("viewed");
			$(".popup-preview-overlay-2").toggleClass("viewed");
			$("html").toggleClass("scroll-lock");
		});
	});
}

function popupForgotPass() {
	$(".popup-preview-forgotpass").each(function () {
		var $this = $(this),
		btnForgotpass = $this.find( ".popup-btn-forgotpass" ),
			popupBg = $this.find(".popup-bg"),
			popupClose = $this.find(".popup-close");
		$(".popup-btn-forgotpass").add(popupBg).add(popupClose).on("click", function (e) {
			e.preventDefault();
			$(".popup-preview-forgotpass").toggleClass("viewed");
			$(".popup-preview-login").removeClass("viewed");
			
			if($(".popup-preview-forgotpass").hasClass("viewed")){
				
				$(".popup-preview-overlay-2").addClass("viewed");
					$("html").addClass("scroll-lock");
			}else{
				$(".popup-preview-overlay-2").removeClass("viewed");
				$("html").removeClass("scroll-lock");				
			} 

		});  
	});
}


function popupLanguageChoice() {
	$(".popup-language-choice").each(function () {
		var $this = $(this),
			popupBg = $this.find(".popup-bg"),
			popupClose = $this.find(".popup-close");
		$(".popup-btn-language-choice").add(popupBg).add(popupClose).on("click", function (e) {
			e.preventDefault();
			$(".popup-language-choice").toggleClass("viewed");
			$(".popup-preview-overlay-2").toggleClass("viewed");
			$("html").toggleClass("scroll-lock");
		});
	});
}


// *** Slider Price Range *** //
function sliderPriceRange() {
	if (jQuery('.price-range').length > 0) {
		$('.price-range').slider();
	}
}


// *** Options Select2 *** //
function optionsSelect2() {
	$(".options-select2").select2({
		dir: selectRtl,
		minimumResultsForSearch: -1
	});
}


// *** Dashboard User Upload Image *** //
function formLabelStyle1() {
	$("form.with-label-style-1").each(function () {
		var $this = $(this),
			onClass = "on",
			showClass = "show";

		$this.find("input, textarea").on("checkval", function () {
			var label = $(this).prev("label");
			if (this.value !== "") {
				label.addClass(showClass);
			} else {
				label.removeClass(showClass);
			}
		}).on("keyup", function () {
			$(this).trigger("checkval");
		}).on("focus", function () {
			$(this).prev("label").addClass(onClass);
		}).on("blur", function () {
			$(this).prev("label").removeClass(onClass);
		}).trigger("checkval");
	});
}


// *** Slider Related Posts *** //
function sliderRelatedPosts() {
	var sliderRelatedPosts = $('.slider-related-posts > .slick-slider');
	sliderRelatedPosts.slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		dots: false,
		infinite: false,
		rtl: slickDirection,
		arrows: false,
		touchThreshold: 20,
		responsive: [
			{
				breakpoint: 1400,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1
				}
			}
		]
	});
}


// *** Slider Airfares Calender *** //
function sliderAirfaresCalender() {
	var sliderAirfaresCalender = $('.slider-airfares-calender > .slick-slider');
	sliderAirfaresCalender.slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: false,
		infinite: false,
		rtl: slickDirection,
		arrows: true,
		touchThreshold: 20,
		appendArrows: sliderAirfaresCalender.next('.slick-arrows'),
		prevArrow: '<a href="javascript:;" class="slick-prev"><i class="fas fa-arrow-down"></i></a>',
		nextArrow: '<a href="javascript:;" class="slick-next"><i class="fas fa-arrow-up"></i></a>'
	});
}


// *** Slider Hotel Preview *** //
function sliderHotelPreview() {
	var sliderHotelPreview = $('.slider-hotel-preview > .slick-slider');
	var sliderHotelPreviewThumbs = $('.slider-hotel-preview-thumbs > .slick-slider');

	sliderHotelPreview.slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		dots: false,
		infinite: true,
		rtl: slickDirection,
		arrows: true,
		touchThreshold: 20,
		appendArrows: sliderHotelPreview.next('.slick-arrows'),
		prevArrow: '<a href="javascript:;" class="slick-prev"><i class="fas fa-arrow-down"></i></a>',
		nextArrow: '<a href="javascript:;" class="slick-next"><i class="fas fa-arrow-up"></i></a>',
		asNavFor: sliderHotelPreviewThumbs
	});

	sliderHotelPreviewThumbs.slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		dots: false,
		infinite: true,
		rtl: slickDirection,
		arrows: false,
		touchThreshold: 20,
		appendArrows: sliderHotelPreviewThumbs.next('.slick-arrows'),
		prevArrow: '<a href="javascript:;" class="slick-prev"><i class="fas fa-arrow-down"></i></a>',
		nextArrow: '<a href="javascript:;" class="slick-next"><i class="fas fa-arrow-up"></i></a>',
		centerMode: true,
		focusOnSelect: true,
		asNavFor: sliderHotelPreview,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 5
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 4
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2
				}
			}
		]
	});
}


// *** Hotel Info Tabs *** //
function hotelInfoTabs() {
	$(".hi-tabs > li").addClass("hi-item");

	// Variables
	var clickedTab = $(".hi-tabs > .active");
	var tabWrapper = $(".hi-tabs-content");
	var activeTab = tabWrapper.find(".active");
	var activeTabHeight = activeTab.outerHeight();

	// Show tab on page load
	activeTab.show();

	// Set height of wrapper on page load
	tabWrapper.height(activeTabHeight);

	$(".hi-tabs .hi-item").on("click", function () {	

		if (!$(this).hasClass("active")) {
			// Remove class from active tab
			$(".hi-tabs .hi-item").removeClass("active");

			// Add class active to clicked tab
			$(this).addClass("active");

			// Update clickedTab variable
			clickedTab = $(".hi-tabs .active");

			// fade out active tab
			activeTab.animate({ top: 0 }, 0, function () {

				// Remove active class all tabs
				$(".hi-tabs-content > li").removeClass("active");

				// Get index of clicked tab
				var clickedTabIndex = clickedTab.index();

				// Add class active to corresponding tab
				$(".hi-tabs-content > li").eq(clickedTabIndex).addClass("active");

				// update new active tab
				activeTab = $(".hi-tabs-content > .active");

				// Update variable
				activeTabHeight = activeTab.outerHeight();

				// Animate height of wrapper to new tab height
				tabWrapper.stop().delay(0).animate({
					height: activeTabHeight
				}, 200, function () {

					// Fade in active tab
					activeTab.delay(0)
						.animate({ top: 0 }, 0 );

				});
			});
		}
	});
}


// *** Slider Hotel Preview *** //
function sliderPostPrevNext() {
	var sliderPostPrevNext = $('.slider-post-prev-next > .slick-slider');

	sliderPostPrevNext.slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		vertical: true,
		verticalSwiping: true,
		dots: false,
		infinite: true,
		// rtl: slickDirection,
		arrows: true,
		touchThreshold: 20,
		appendArrows: '.post-prev-next-arrows',
		prevArrow: '<div class="previous"><span class="arrow"><i class="far fa-arrow-alt-circle-left"></i>Previous</span></div><!-- .previous end -->',
		nextArrow: '<div class="next"><span class="arrow"><i class="far fa-arrow-alt-circle-right"></i>Next</span></div><!-- .next end -->'
	});
}


// *** Form Datepicker *** //
function formDatepicker() {

	var dateToday = new Date();
	var dateAsYMD = new Date();

	var month = dateAsYMD.getMonth() + 1;
	var day = dateAsYMD.getDate();

	var outputDateAsYMD = dateAsYMD.getFullYear() + '/' +
		(('' + month).length < 2 ? '0' : '') + month + '/' +
		(('' + day).length < 2 ? '0' : '') + day;

	// alert(outputDateAsYMD);

	$("#datepicker-time-start, #datepicker-time-end").attr("placeholder", outputDateAsYMD);
	
	function getData(){
		var arr = [];
	 $.ajax({
		 async: false,
	   url:"https://zapbooking.com/Calender/fare",
	   method:'GET',
	   success:function(data)
	   {
		  var r = $.parseJSON(data);
		  	console.log(r);
		arr = r;
	   }
	  });
	   return arr;
	}
	//var dayrates = [];
	//  dayrates = getData();
	//var dayrates = [100, 150, 150, 150, 150, 250, 250];
	var dates = $("#datepicker-time-start, #datepicker-time-end").datepicker({
		defaultDate: "+2d",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: 'yy/mm/dd',
		minDate: dateToday,
		onSelect: function (selectedDate) {
		
			var option = this.id == "datepicker-time-start" ? "minDate" : "maxDate",
				instance = $(this).data("datepicker"),
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			dates.not(this).datepicker("option", option, date);
			
		}  /* beforeShowDay: function(date) {
      var selectable = true;
      var classname = "";
      var title = "" + dayrates[date.getDay()];
      return [selectable, classname, title];
    } */
	});
	
	
	var datesd = $("#hoteldatepicker-time-start, #hoteldatepicker-time-end").datepicker({
		defaultDate: "+2d",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: 'yy/mm/dd',
		minDate: dateToday,
		onSelect: function (selectedDate) {
			if(this.id == "hoteldatepicker-time-start"){
				 setTimeout(function() {
                 $('#hoteldatepicker-time-end').focus();
                }, 500);
				
			}
			else if(this.id == "hoteldatepicker-time-end"){
				$('.show-dropdown-passengers').focus();
			}
			var option = this.id == "hoteldatepicker-time-start" ? "minDate" : "maxDate",
				instance = $(this).data("datepicker"),
				date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
			datesd.not(this).datepicker("option", option, date);
			
		}  /* beforeShowDay: function(date) {
      var selectable = true;
      var classname = "";
      var title = "" + dayrates[date.getDay()];
      return [selectable, classname, title];
    } */
	});
var n = dateToday.getFullYear();
	$(".datepicker-2-time-start").datepicker({
		dateFormat: 'yy/mm/dd',
		minDate: dateToday,
	});
	$(".datepicker-adulttime-start").datepicker({
		dateFormat: 'dd/mm/yy',
		
		changeMonth: true,
   changeYear: true,
   maxDate: -parseInt((365 * 12) + parseInt(12 / 4)),
                    minDate: -parseInt((365 * 100) + parseInt(100 / 4)),
                    yearRange: '1900:'+n
	});
	var n = dateToday.getFullYear();
	$(".datepicker-3-time-start").datepicker({
		dateFormat: 'dd/mm/yy',
 changeMonth: true,
   changeYear: true,
   yearRange: n+":c+78"
	});
	$(".datepicker-child-time-start").datepicker({
		dateFormat: 'dd/mm/yy',
 changeMonth: true,
   changeYear: true,
   minDate: -parseInt((365 * 12) + parseInt(12 / 4)),
    maxDate: -parseInt((365 * 2))
	});
	$(".datepicker-infant-time-start").datepicker({
		dateFormat: 'dd/mm/yy',
 changeMonth: true,
   changeYear: true,
  maxDate: -0,
    minDate: -parseInt((365 * 2))
	});
	
	
	
	
	$("#multipicker1").datepicker({
		minDate:0,onSelect:function(e,t){
			var l=$("#multipicker1").datepicker("getDate");
			l.setDate(l.getDate()),
			$("#multipicker2").datepicker("option","minDate",l)
		},
		dateFormat:"yy/mm/dd"})
		$("#multipicker2").datepicker({
			minDate:0,onSelect:function(e,t){
				var l=$("#multipicker2").datepicker("getDate");
				l.setDate(l.getDate()),
				$("#multipicker3").datepicker("option","minDate",l)
				},
				dateFormat:"yy/mm/dd"}),
				$("#multipicker3").datepicker({
					minDate:0,onSelect:function(e,t){
						var l=$("#multipicker3").datepicker("getDate");l.setDate(l.getDate()),$("#multipicker4").datepicker("option","minDate",l)
						},
						dateFormat:"yy/mm/dd"}),
						$("#multipicker4").datepicker({
							minDate:0,onSelect:function(e,t){
								var l=$("#multipicker4").datepicker("getDate");l.setDate(l.getDate()),$("#multipicker5").datepicker("option","minDate",l)
								},dateFormat:"yy/mm/dd"}),
								$("#multipicker5").datepicker({
									minDate:0,onSelect:function(e,t){
										var l=$("#multipicker5").datepicker("getDate");l.setDate(l.getDate()),$("#multipicker6").datepicker("option","minDate",l)},dateFormat:"yy/mm/dd"}),
										$("#multipicker6").datepicker({
											minDate:0,
											onSelect:function(e,t){
												var l=$("#multipicker6").datepicker("getDate");
												l.setDate(l.getDate()),
												$("#multipicker7").datepicker("option","minDate",l)},dateFormat:"yy/mm/dd"}),
												$("#multipicker7").datepicker();
}


$(document).ready(function () {
	$('#filterprice').on('change', function(){
		var favorite = [];
		var ffavorite = [];
		
            $.each($("input[name='package_type']:checked"), function(){
                favorite.push($(this).val());
            }); 
			 $.each($("input[name='flight']:checked"), function(){
                ffavorite.push($(this).val());
            }); 
			  $('#mloader').show(); 
			$.ajax({
				type: 'get',
				url: site_url+'/searchpackage', 
				data: {
					ptype: favorite, 
					flight: ffavorite, 
				 	price: $('#mprice').val(), 
					slug: $('#mslug').val(),
					filter: $('#filterprice option:selected').val(),
				},
				success: function(res){
					$('#mloader').hide();
					$('#ajaxResultContainer').html(res);
				}
			});
	}); 
	$('.myListicheck').on('change', function(){
		var favorite = [];
		var ffavorite = [];
		
            $.each($("input[name='package_type']:checked"), function(){
                favorite.push($(this).val());
            }); 
			 $.each($("input[name='flight']:checked"), function(){
                ffavorite.push($(this).val());
            }); 
			  $('#mloader').show(); 
			$.ajax({
				type: 'get',
				url: site_url+'/searchpackage', 
				data: {
					ptype: favorite, 
					flight: ffavorite, 
				 	price: $('#mprice').val(), 
					slug: $('#mslug').val(),
					filter: $('#filterprice option:selected').val(),
				},
				success: function(res){
					$('#mloader').hide();
					$('#ajaxResultContainer').html(res);
				}
			});
	}); 
	$('.flightfilter').on('change', function(){
		var ffavorite = [];
		var favorite = [];
		
            $.each($("input[name='flight']:checked"), function(){
                ffavorite.push($(this).val());
            }); 
			$.each($("input[name='package_type']:checked"), function(){
                favorite.push($(this).val());
            });
			  $('#mloader').show(); 
			$.ajax({
				type: 'get',
				url: site_url+'/searchpackage', 
				data: {
					ptype: favorite, 
					flight: ffavorite, 
				 	price: $('#mprice').val(), 
					/*duration: $('#mduration').val(),  					
					city: $('#mcity').val(),  */
					slug: $('#mslug').val(),
					filter: $('#filterprice option:selected').val(),
					/* tslug: $('#tslug').val(), */
				  /* here goes Data from S2 */
				},
				success: function(res){
					$('#mloader').hide();
					$('#ajaxResultContainer').html(res);
				}
			});
	}); 
	$( ".pslider-range-price" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".pslider-range"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");
 
		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
				  $('#mloader').show(); 
				  $('#mprice').val(minCheck+'_'+maxCheck);
				  var favorite = [];
				  var ffavorite = [];
				$.each($("input[name='package_type']:checked"), function(){
                favorite.push($(this).val());
            }); 
			$.each($("input[name='flight']:checked"), function(){
                ffavorite.push($(this).val());
            });
                $.ajax({
						type: 'get',
						url: site_url+'/searchpackage', 
						data: {
							 ptype: favorite,
							price: minCheck+'_'+maxCheck, 
							flight: ffavorite, 
							filter: $('#filterprice option:selected').val(),
							slug: $('#mslug').val(),

						},
						success: function(res){
							$('#mloader').hide();
							$('#ajaxResultContainer').html(res);
						}
					});
            },
			slide: function (event, ui) {
				$this.find(".price").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
			}
		});

		$this.find(".price").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
	} );
	
	$( ".slider-range-price" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".slider-range"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");

		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
				
				if ($(window).width() < 991) {
			}else{
				$(".price1").each(function(){
                    if($(this).attr("price")<=ui.values[ 0 ] || $(this).attr("price")>=ui.values[ 1 ])
                    {
                        $(this).hide();
                    }
                    if($(this).attr("price")>=ui.values[ 0 ] && $(this).attr("price")<=ui.values[ 1 ])
                    {
                        $(this).show();
                    }
                }); 
			}
                //doFilter("price", minCheck + "#" + maxCheck, null);
            },
			slide: function (event, ui) {
				$this.find(".price").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
				$(".pricenew").val(ui.values[0] + "-"+ui.values[1]);
			}
		});

		$this.find(".price").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
			$(".pricenew").val(sliderRange.slider("values", 0) + "-"+sliderRange.slider("values", 1));
	} );
	$( ".slider-range-price-return" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".slider-range"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");

		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
                doFilter("returnprice", minCheck + "#" + maxCheck, null);
            },
			slide: function (event, ui) {
				$this.find(".retprice").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
			}
		});

		$this.find(".retprice").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
	} );
	$( ".slider-range-price-time-round" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".slider-range-r"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");

		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
                doFilterDRT("deptime", minCheck + "#" + maxCheck, null);
            },
			slide: function (event, ui) {
				$this.find(".time").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
			}
		});

		$this.find(".time").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
	} );
	
	$( ".slider-range-price-time" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".slider-range-t"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");

		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
				if ($(window).width() < 991) {
			}else{
                $(".price111onword").each(function(){
				if($(this).attr("timedep")<ui.values[ 0 ] || $(this).attr("timedep")>ui.values[ 1 ])
				{
				$(this).hide();
				}
				if($(this).attr("timedep")>ui.values[ 0 ] && $(this).attr("timedep")<ui.values[ 1 ])
				{
				$(this).show();
				}
				}); 
			}				

            },
			slide: function (event, ui) {
				$this.find(".time").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
				$(".timenew").val(ui.values[0] + "-"+ui.values[1]);
			}
		});

		$this.find(".time").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
			$(".timenew").val(sliderRange.slider("values", 0) + "-"+sliderRange.slider("values", 1));
	} );
	
	/*$( ".pslider-range-time" ).each( function() {
		var $this = $(this),
			sliderRange = $this.find(".pslider-range-t"),
			valMin = sliderRange.data("slider-min-value"),
			valMax = sliderRange.data("slider-max-value"),
			valStart = sliderRange.data("range-start-value"),
			valEnd = sliderRange.data("range-end-value"),
			valueSign = sliderRange.data("slider-value-sign");

		sliderRange.slider({
			range: true,
			min: valMin,
			max: valMax,
			values: [valStart, valEnd],
			stop: function (event, ui) {
				
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
                doFilter("deptime", minCheck + "#" + maxCheck, null);
            },
			slide: function (event, ui) {
				$this.find(".time").val(valueSign + ui.values[0] + " - " + valueSign + ui.values[1]);
			}
		});

		$this.find(".time").val(valueSign + sliderRange.slider("values", 0) +
			" - " + valueSign + sliderRange.slider("values", 1));
	} );*/



	$(".slider-range-time").each( function() {
		var $this = $(this),
			sliderRange = $this.find(".slider-range"),
			sliderTime1 = $this.find(".slider-time-1"),
			sliderTime2 = $this.find(".slider-time-2"),
			timeStartMinutes = sliderRange.data("time-start-minutes"),
			timeEndMinutes = sliderRange.data("time-end-minutes");
		
			sliderRange.slider({
				range: true,
				min: 0,
				max: 1440,
				step: 15,
				values: [timeStartMinutes, timeEndMinutes],
				stop: function (event, ui) {
				alert();
                var minCheck = parseInt(ui.values[0]);
                var maxCheck = parseInt(ui.values[1]);
                doFilter("deptime", minCheck + "#" + maxCheck, null);
            },
				slide: function (e, ui) {
					var hours1 = Math.floor(ui.values[0] / 60);
					var minutes1 = ui.values[0] - (hours1 * 60);
		
					if (hours1.length == 1) hours1 = '0' + hours1;
					if (minutes1.length == 1) minutes1 = '0' + minutes1;
					if (minutes1 == 0) minutes1 = '00';
					if (hours1 >= 12) {
						if (hours1 == 12) {
							hours1 = hours1;
							minutes1 = minutes1 + " PM";
						} else {
							hours1 = hours1 - 12;
							minutes1 = minutes1 + " PM";
						}
					} else {
						hours1 = hours1;
						minutes1 = minutes1 + " AM";
					}
					if (hours1 == 0) {
						hours1 = 12;
						minutes1 = minutes1;
					}

					sliderTime1.html(hours1 + ':' + minutes1);
		
					var hours2 = Math.floor(ui.values[1] / 60);
					var minutes2 = ui.values[1] - (hours2 * 60);
		
					if (hours2.length == 1) hours2 = '0' + hours2;
					if (minutes2.length == 1) minutes2 = '0' + minutes2;
					if (minutes2 == 0) minutes2 = '00';
					if (hours2 >= 12) {
						if (hours2 == 12) {
							hours2 = hours2;
							minutes2 = minutes2 + " PM";
						} else if (hours2 == 24) {
							hours2 = 11;
							minutes2 = "59 PM";
						} else {
							hours2 = hours2 - 12;
							minutes2 = minutes2 + " PM";
						}
					} else {
						hours2 = hours2;
						minutes2 = minutes2 + " AM";
					}

					sliderTime2.html(hours2 + ':' + minutes2);
				}
			});
	} );
});


// *** Language Select *** //
function languageSelect() {
	$("#select-language").countrySelect({
		defaultCountry: "gb",
		onlyCountries: ['eg', 'gb'],
		preferredCountries: false,
		responsiveDropdown: true
	});
}


// *** Item Click Increase & Decrease Counter *** //
function itemClickCounter() {
	jQuery.fn.allowDigitsOnly = function () {
		return this.each(function () {
			$(this).keydown(function (e) {
				var key = e.charCode || e.keyCode || 0;
				return (
					key == 8 ||
					key == 9 ||
					key == 46 ||
					key == 110 ||
					key == 190 ||
					(key >= 35 && key <= 40) ||
					(key >= 48 && key <= 57) ||
					(key >= 96 && key <= 105));
			});
		});
	};

	var inputField = $(".counter-add-item input");
	inputField.allowDigitsOnly();

	$(".onewaytrip .increase-btn").on("click", function (e) {
		e.preventDefault();
		var inputField = $(this).prev("input");
		var currentInputValue = parseInt(inputField.val());
		inputField.val(currentInputValue + 1);
		var adult = $('.onewaytrip .onewayadult').val();
		var child = $('.onewaytrip .onewaychild').val();
		var infant = $('.onewaytrip .onewayinfants').val();
		var tottalpx = parseInt(adult) + parseInt(child) + parseInt(infant);
		$('.onewaytrip .roundpessanger').val(tottalpx+" Passengers");
		
	});

	$(".onewaytrip .decrease-btn").on("click", function (e) {
		e.preventDefault();
		var inputField = $(this).next("input");
		var currentInputValue = parseInt(inputField.val());
		inputField.val(currentInputValue - 1);
$('.onewaytrip .onewayadult').val(1);
		if (currentInputValue < 1) {
			inputField.val("0");
			$('.onewaytrip .onewayadult').val(1);
		}
		var adult = $('.onewaytrip .onewayadult').val();
		var child = $('.onewaytrip .onewaychild').val();
		var infant = $('.onewaytrip .onewayinfants').val();
		var tottalpx = parseInt(adult) + parseInt(child) + parseInt(infant);
		$('.onewaytrip .roundpessanger').val(tottalpx+" Passengers");
	});
	
		$(".roundtrip .increase-btn").on("click", function (e) {
		e.preventDefault();
		var inputField = $(this).prev("input");
		var currentInputValue = parseInt(inputField.val());
		inputField.val(currentInputValue + 1);
		var adult = $('.roundtrip .onewayadult').val();
		var child = $('.roundtrip .onewaychild').val();
		var infant = $('.roundtrip .onewayinfants').val();
		var tottalpx = parseInt(adult) + parseInt(child) + parseInt(infant);
		$('.roundtrip .roundpessanger').val(tottalpx+" Passengers");
		
	});

	$(".decrease-btn").on("click", function (e) {
		e.preventDefault();
		var inputField = $(this).next("input");
		var currentInputValue = parseInt(inputField.val());
		inputField.val(currentInputValue - 1);
$('.roundtrip .onewayadult').val(1);
		if (currentInputValue < 1) {
			inputField.val("0");
			$('.roundtrip .onewayadult').val(1);
		}
		var adult = $('.roundtrip .onewayadult').val();
		var child = $('.roundtrip .onewaychild').val();
		var infant = $('.roundtrip .onewayinfants').val();
		var tottalpx = parseInt(adult) + parseInt(child) + parseInt(infant);
		$('.roundtrip .roundpessanger').val(tottalpx+" Passengers");
	});
	
	$(".multiincrease-btn").on("click", function (e) {
	
		e.preventDefault();
		var inputField = $(this).prev("input");
		var currentInputValue = parseInt(inputField.val());
		inputField.val(currentInputValue + 1);
		var adult = $('.multionewayadult').val();
		var child = $('.multionewaychild').val();
		var infant = $('.multionewayinfants').val();
		var tottalpx = parseInt(adult) + parseInt(child) + parseInt(infant);
		$('.multiroundtrip .multiroundpessanger').val(tottalpx+" Passengers");
		
	});
	
	$(".multidecrease-btn").on("click", function (e) {
		e.preventDefault();
		var inputField = $(this).next("input");
		var currentInputValue = parseInt(inputField.val());
		inputField.val(currentInputValue - 1);
		$('.multiroundtrip .multionewayadult').val(1);
		if (currentInputValue < 1) {
			inputField.val("0");
			$('.multiroundtrip .multionewayadult').val(1);
		}
		var adult = $('.multiroundtrip .multionewayadult').val();
		var child = $('.multiroundtrip .multionewaychild').val();
		var infant = $('.multiroundtrip .multionewayinfants').val();
		var tottalpx = parseInt(adult) + parseInt(child) + parseInt(infant);
		$('.multiroundtrip .multiroundpessanger').val(tottalpx+" Passengers");
	});
}


// *** Show Dropdown Passsengers *** //
function dropdownPassengers() {
	$(".show-dropdown-passengers").each( function() {
		var $this = $(this),
			dropdownPassengers = $this.siblings(".list-dropdown-passengers");
	
		$this.on( "focus", function() {
			$(".list-dropdown-passengers").removeClass("is-active");
			dropdownPassengers.addClass("is-active");
		} )
	
		dropdownPassengers.find(".btn-reservation-passengers").on("click", function () {
			$this.siblings(".list-dropdown-passengers").removeClass("is-active");
		} )
	} );

}

// *** Multi Multiple Destinations *** //
function multipleDestinations() {
	var cloneWrap = $(".multiple-destinations").find(".form-group:first-child"),
		clonedElement = cloneWrap.find(".fields-row:first-child");

	$(".btn-multiple-destinations").on("click", function() {
		clonedElement.clone().appendTo(cloneWrap);

		var clonedElementLast = cloneWrap.find(".fields-row:last-child");

		clonedElementLast.find(".hasDatepicker").removeClass("hasDatepicker datepicker-2-time-start").removeAttr("id").datepicker({ dateFormat: 'yy/mm/dd' });
		clonedElementLast.find(".list-dropdown-passengers").removeClass("is-active");

		var liHeight = $(this).closest("li").outerHeight();

		$(this).closest(".br-tabs-content").height(liHeight);


		dropdownPassengers();
	});
}


// *** Slider Featured Cars *** //
function sliderFeaturedCars() {
	$(".slider-featured-cars").each(function () {
		var sliderFeaturedCars = $(this).find(".slick-slider");
		sliderFeaturedCars.slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			dots: false,
			infinite: false,
			rtl: slickDirection,
			arrows: true,
			touchThreshold: 20,
			// centerMode: true,
			appendArrows: $(this).find('.slick-arrows'),
			prevArrow: '<a href="javascript:;" class="slick-prev"><i class="fas fa-arrow-down"></i></a>',
			nextArrow: '<a href="javascript:;" class="slick-next"><i class="fas fa-arrow-up"></i></a>',
			responsive: [
				{
					breakpoint: 1400,
					settings: {
						slidesToShow: 3
					}
				},
				{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3
					}
				},
				{
					breakpoint: 992,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 1
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1
					}
				}
			]
		});
	});
}


// *** Country Select *** //
function countrySelect() {
	$("#select-country").countrySelect({
		defaultCountry: "us",
		// onlyCountries: ['eg', 'gb'],
		preferredCountries: false,
		responsiveDropdown: true
	});
}

/* var c = 1;
$(document).delegate('#addhotelRoom', "click", function () {
	var html = $('#divroom1').html();
	c++;
	if ( $('.box').length == 3 ) {
		$('#addhotelRoom').hide();
	}	 
		$('<div class="box" id="divroom'+c+'"><div class="roomTxt"><span id="RoomNumer1">Room '+c+':</span></div>'+
						'<div class="left pull-left">'+ 
							'<span class="txt">'+
								'<span id="Label7">Adult <em>(Above 12 years)</em></span>'+
							'</span>'+
						'</div>'+
						'<div class="right pull-right">'+
							'<div id="field1" class="PlusMinusRow">'+
								'<a class="decrease-btn" href="javascript:;">-</a>'+
								'<span id="Adults_room_1_1" class="PlusMinus_number">4</span>'+
								'<a class="increase-btn" href="javascript:;">+</a>'+
							'</div>'+
						'</div>'+
						'<div class="spacer"></div>'+
						'<div class="left pull-left">'+
							'<span class="txt">'+
								'<span id="Label9">Child <em>(Below 12 years)</em></span>'+
							'</span>'+
						'</div>'+
						'<div class="right pull-right">'+
							'<div id="field2" class="PlusMinusRow">'+
								'<a class="decrease-btn" href="javascript:;">-</a>'+
								'<span id="Children_room_1_1" class="PlusMinus_number">2</span>'+
								'<a class="increase-btn" href="javascript:;">+</a>'+
							'</div>'+
						'</div>'+
						'<div class="clearfix"></div>'+
						'<div class="child_age">'+
							'<span>Age(s) of Children</span>'+
							'<select id="Child_Age_1_1" style="display: inline;"><option option="selected">1</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option></select>'+
							'<select id="Child_Age_1_2" style="display: inline;"><option option="selected">1</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option></select>'+
						'</div></div>').insertAfter('#divroom1');
	
		
	
});	 */

 function ShowAmenity() {
	if(document.getElementById("allamenity").style.display=="none")
	{
		$("#allamenity").show(200);
	}
	else
	{
		$("#allamenity").hide(300);
	}
}

$(document).ready(function(){
	$(document).on("click", ".amenity_show_hide", function() {
		$(this).text($(this).text() == 'Show All Amenities' ? 'Hide All Amenities' : 'Show All Amenities');
	});
	$(document).delegate('#removehotelRoom', 'click', function(){
		$('#roomshtml .box:last-child').remove();
	});
	$(document).delegate('.book_now_new', 'click', function(){
		
		var traceID = $(this).attr('tracid');
		var resultIndex = $(this).attr('resIndex');
		
		var isinternational = $(this).attr('isinternational');
		var isReturn = $(this).attr('isReturn');
		book_now(traceID, resultIndex,isinternational,isReturn);
	});
	
	function book_now(traceID, resultIndex, isinternational, isReturn)
	{
			window.location.href = site_url+"/Review/Checkout?tid="+traceID+"&RIndex="+resultIndex+"&isINT="+isinternational+"&isReturn="+isReturn;
		
	}
});

