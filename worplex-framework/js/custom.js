jQuery(function () {
	"use strict";

	//Loader	
	jQuery(function preloaderLoad() {
		if (jQuery('.preloader').length) {
			jQuery('.preloader').delay(200).fadeOut(300);
		}
		jQuery(".preloader_disabler").on('click', function () {
			jQuery("#preloader").hide();
		});
	});

	// Dashbaord Nav Scrolling
	jQuery(window).on('load resize', function () {
		var wrapperHeight = window.innerHeight;
		var headerHeight = jQuery(".header-light").height();
		var winWidth = jQuery(window).width();

		if (winWidth > 992) {
			jQuery(".dashboard-inner").css('max-height', wrapperHeight - headerHeight);
		} else {
			jQuery(".dashboard-inner").css('max-height', '');
		}
	});

	// Script Navigation
	! function (n, e, i, a) {
		n.navigation = function (t, s) {
			var o = {
				responsive: !0,
				mobileBreakpoint: 992,
				showDuration: 300,
				hideDuration: 300,
				showDelayDuration: 0,
				hideDelayDuration: 0,
				submenuTrigger: "hover",
				effect: "fade",
				submenuIndicator: !0,
				hideSubWhenGoOut: !0,
				visibleSubmenusOnMobile: !1,
				fixed: !1,
				overlay: !0,
				overlayColor: "rgba(0, 0, 0, 0.5)",
				hidden: !1,
				offCanvasSide: "left",
				onInit: function () { },
				onShowOffCanvas: function () { },
				onHideOffCanvas: function () { }
			},
				u = this,
				r = Number.MAX_VALUE,
				d = 1,
				f = "click.nav touchstart.nav",
				l = "mouseenter.nav",
				c = "mouseleave.nav";
			u.settings = {};
			var t = (n(t), t);
			n(t).find(".nav-menus-wrapper").prepend("<span class='nav-menus-wrapper-close-button'>✕</span>"), n(t).find(".nav-search").length > 0 && n(t).find(".nav-search").find("form").prepend("<span class='nav-search-close-button'>✕</span>"), u.init = function () {
				u.settings = n.extend({}, o, s), "right" == u.settings.offCanvasSide && n(t).find(".nav-menus-wrapper").addClass("nav-menus-wrapper-right"), u.settings.hidden && (n(t).addClass("navigation-hidden"), u.settings.mobileBreakpoint = 99999), v(), u.settings.fixed && n(t).addClass("navigation-fixed"), n(t).find(".nav-toggle").on("click touchstart", function (n) {
					n.stopPropagation(), n.preventDefault(), u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")
				}), n(t).find(".nav-menus-wrapper-close-button").on("click touchstart", function () {
					u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")
				}), n(t).find(".nav-search-button").on("click touchstart", function (n) {
					n.stopPropagation(), n.preventDefault(), u.toggleSearch()
				}), n(t).find(".nav-search-close-button").on("click touchstart", function () {
					u.toggleSearch()
				}), n(t).find(".megamenu-tabs").length > 0 && y(), n(e).resize(function () {
					m(), C()
				}), m(), s !== a && u.callback("onInit")
			};
			var v = function () {
				n(t).find("li").each(function () {
					n(this).children(".nav-dropdown,.megamenu-panel").length > 0 && (n(this).children(".nav-dropdown,.megamenu-panel").addClass("nav-submenu"), u.settings.submenuIndicator && n(this).children("a").append("<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"))
				})
			};
			u.showSubmenu = function (e, i) {
				g() > u.settings.mobileBreakpoint && n(t).find(".nav-search").find("form").slideUp(), "fade" == i ? n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).fadeIn(u.settings.showDuration) : n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).slideDown(u.settings.showDuration), n(e).addClass("nav-submenu-open")
			}, u.hideSubmenu = function (e, i) {
				"fade" == i ? n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).fadeOut(u.settings.hideDuration) : n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).slideUp(u.settings.hideDuration), n(e).removeClass("nav-submenu-open").find(".nav-submenu-open").removeClass("nav-submenu-open")
			};
			var h = function () {
				n("body").addClass("no-scroll"), u.settings.overlay && (n(t).append("<div class='nav-overlay-panel'></div>"), n(t).find(".nav-overlay-panel").css("background-color", u.settings.overlayColor).fadeIn(300).on("click touchstart", function (n) {
					u.hideOffcanvas()
				}))
			},
				p = function () {
					n("body").removeClass("no-scroll"), u.settings.overlay && n(t).find(".nav-overlay-panel").fadeOut(400, function () {
						n(this).remove()
					})
				};
			u.showOffcanvas = function () {
				h(), "left" == u.settings.offCanvasSide ? n(t).find(".nav-menus-wrapper").css("transition-property", "left").addClass("nav-menus-wrapper-open") : n(t).find(".nav-menus-wrapper").css("transition-property", "right").addClass("nav-menus-wrapper-open")
			}, u.hideOffcanvas = function () {
				n(t).find(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open").on("webkitTransitionEnd moztransitionend transitionend oTransitionEnd", function () {
					n(t).find(".nav-menus-wrapper").css("transition-property", "none").off()
				}), p()
			}, u.toggleOffcanvas = function () {
				g() <= u.settings.mobileBreakpoint && (n(t).find(".nav-menus-wrapper").hasClass("nav-menus-wrapper-open") ? (u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")) : (u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")))
			}, u.toggleSearch = function () {
				"none" == n(t).find(".nav-search").find("form").css("display") ? (n(t).find(".nav-search").find("form").slideDown(), n(t).find(".nav-submenu").fadeOut(200)) : n(t).find(".nav-search").find("form").slideUp()
			};
			var m = function () {
				u.settings.responsive ? (g() <= u.settings.mobileBreakpoint && r > u.settings.mobileBreakpoint && (n(t).addClass("navigation-portrait").removeClass("navigation-landscape"), D()), g() > u.settings.mobileBreakpoint && d <= u.settings.mobileBreakpoint && (n(t).addClass("navigation-landscape").removeClass("navigation-portrait"), k(), p(), u.hideOffcanvas()), r = g(), d = g()) : k()
			},
				b = function () {
					n("body").on("click.body touchstart.body", function (e) {
						0 === n(e.target).closest(".navigation").length && (n(t).find(".nav-submenu").fadeOut(), n(t).find(".nav-submenu-open").removeClass("nav-submenu-open"), n(t).find(".nav-search").find("form").slideUp())
					})
				},
				g = function () {
					return e.innerWidth || i.documentElement.clientWidth || i.body.clientWidth
				},
				w = function () {
					n(t).find(".nav-menu").find("li, a").off(f).off(l).off(c)
				},
				C = function () {
					if (g() > u.settings.mobileBreakpoint) {
						var e = n(t).outerWidth(!0);
						n(t).find(".nav-menu").children("li").children(".nav-submenu").each(function () {
							n(this).parent().position().left + n(this).outerWidth() > e ? n(this).css("right", 0) : n(this).css("right", "auto")
						})
					}
				},
				y = function () {
					function e(e) {
						var i = n(e).children(".megamenu-tabs-nav").children("li"),
							a = n(e).children(".megamenu-tabs-pane");
						n(i).on("click.tabs touchstart.tabs", function (e) {
							e.stopPropagation(), e.preventDefault(), n(i).removeClass("active"), n(this).addClass("active"), n(a).hide(0).removeClass("active"), n(a[n(this).index()]).show(0).addClass("active")
						})
					}
					if (n(t).find(".megamenu-tabs").length > 0)
						for (var i = n(t).find(".megamenu-tabs"), a = 0; a < i.length; a++) e(i[a])
				},
				k = function () {
					w(), n(t).find(".nav-submenu").hide(0), navigator.userAgent.match(/Mobi/i) || navigator.maxTouchPoints > 0 || "click" == u.settings.submenuTrigger ? n(t).find(".nav-menu, .nav-dropdown").children("li").children("a").on(f, function (i) {
						if (u.hideSubmenu(n(this).parent("li").siblings("li"), u.settings.effect), n(this).closest(".nav-menu").siblings(".nav-menu").find(".nav-submenu").fadeOut(u.settings.hideDuration), n(this).siblings(".nav-submenu").length > 0) {
							if (i.stopPropagation(), i.preventDefault(), "none" == n(this).siblings(".nav-submenu").css("display")) return u.showSubmenu(n(this).parent("li"), u.settings.effect), C(), !1;
							if (u.hideSubmenu(n(this).parent("li"), u.settings.effect), "_blank" == n(this).attr("target") || "blank" == n(this).attr("target")) e.open(n(this).attr("href"));
							else {
								if ("#" == n(this).attr("href") || "" == n(this).attr("href")) return !1;
								e.location.href = n(this).attr("href")
							}
						}
					}) : n(t).find(".nav-menu").find("li").on(l, function () {
						u.showSubmenu(this, u.settings.effect), C()
					}).on(c, function () {
						u.hideSubmenu(this, u.settings.effect)
					}), u.settings.hideSubWhenGoOut && b()
				},
				D = function () {
					w(), n(t).find(".nav-submenu").hide(0), u.settings.visibleSubmenusOnMobile ? n(t).find(".nav-submenu").show(0) : (n(t).find(".nav-submenu").hide(0), n(t).find(".submenu-indicator").removeClass("submenu-indicator-up"), u.settings.submenuIndicator ? n(t).find(".submenu-indicator").on(f, function (e) {
						return e.stopPropagation(), e.preventDefault(), u.hideSubmenu(n(this).parent("a").parent("li").siblings("li"), "slide"), u.hideSubmenu(n(this).closest(".nav-menu").siblings(".nav-menu").children("li"), "slide"), "none" == n(this).parent("a").siblings(".nav-submenu").css("display") ? (n(this).addClass("submenu-indicator-up"), n(this).parent("a").parent("li").siblings("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), n(this).closest(".nav-menu").siblings(".nav-menu").find(".submenu-indicator").removeClass("submenu-indicator-up"), u.showSubmenu(n(this).parent("a").parent("li"), "slide"), !1) : (n(this).parent("a").parent("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), void u.hideSubmenu(n(this).parent("a").parent("li"), "slide"))
					}) : k())
				};
			u.callback = function (n) {
				s[n] !== a && s[n].call(t)
			}, u.init()
		}, n.fn.navigation = function (e) {
			return this.each(function () {
				if (a === n(this).data("navigation")) {
					var i = new n.navigation(this, e);
					n(this).data("navigation", i)
				}
			})
		}
	}
		(jQuery, window, document), jQuery(document).ready(function () {
			jQuery("#navigation").navigation()
		});

	// Product Preview
	jQuery('.sp-wrap').smoothproducts();

	// Tooltip
	jQuery('[data-bs-toggle="tooltip"]').tooltip();

	// Snackbar for wishlist Product
	jQuery('.snackbar-wishlist').click(function () {
		Snackbar.show({
			text: 'Your Job was added to wishlist successfully!',
			pos: 'top-right',
			showAction: false,
			actionText: "Dismiss",
			duration: 3000,
			textColor: '#fff',
			backgroundColor: '#151515'
		});
	});

	// Bottom To Top Scroll Script
	jQuery(window).on('scroll', function () {
		var height = jQuery(window).scrollTop();
		if (height > 100) {
			jQuery('#back2Top').fadeIn();
		} else {
			jQuery('#back2Top').fadeOut();
		}
	});


	// Script For Fix Header on Scroll
	jQuery(window).on('scroll', function () {
		var scroll = jQuery(window).scrollTop();

		if (scroll >= 50) {
			jQuery(".header").addClass("header-fixed");
		} else {
			jQuery(".header").removeClass("header-fixed");
		}
	});

	// reviews-slide
	jQuery('.reviews-slide').slick({
		slidesToShow: 1,
		arrows: true,
		dots: false,
		infinite: true,
		autoplaySpeed: 2000,
		autoplay: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					arrows: true,
					dots: false,
					slidesToShow: 1
				}
			},
			{
				breakpoint: 600,
				settings: {
					arrows: true,
					dots: false,
					slidesToShow: 1
				}
			}
		]
	});

	// item Slide
	jQuery('.review-slide').slick({
		slidesToShow: 3,
		arrows: true,
		dots: false,
		infinite: true,
		speed: 500,
		cssEase: 'linear',
		autoplaySpeed: 2000,
		autoplay: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					arrows: true,
					dots: false,
					slidesToShow: 3
				}
			},
			{
				breakpoint: 600,
				settings: {
					arrows: true,
					dots: false,
					slidesToShow: 1
				}
			}
		]
	});

	// Home Slider
	jQuery('.imployer-explore').slick({
		centerMode: false,
		slidesToShow: 6,
		speed: 500,
		infinite: true,
		cssEase: 'linear',
		autoplaySpeed: 2000,
		autoplay: true,
		arrows: false,
		dots: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					slidesToShow: 4
				}
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
					slidesToShow: 3
				}
			}
		]
	});

	// item Slide
	jQuery('.slide_items').slick({
		slidesToShow: 4,
		arrows: true,
		dots: false,
		infinite: true,
		speed: 500,
		cssEase: 'linear',
		autoplaySpeed: 2000,
		autoplay: true,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					arrows: true,
					dots: false,
					slidesToShow: 3
				}
			},
			{
				breakpoint: 600,
				settings: {
					arrows: true,
					dots: false,
					slidesToShow: 1
				}
			}
		]
	});



});

jQuery(document).ready(function () {
	if (jQuery('[data-background]').length > 0) {
		jQuery('[data-background]').each(function () {
			var background, backgroundmobile, v_this;
			v_this = jQuery(this);
			background = jQuery(this).attr('data-background');
			backgroundmobile = jQuery(this).attr('data-background-mobile');
			if (v_this.attr('data-background').substr(0, 1) === '#') {
				return v_this.css('background-color', background);
			} else if (v_this.attr('data-background-mobile') && device.mobile()) {
				return v_this.css('background-image', 'url(' + backgroundmobile + ')');
			} else {
				return v_this.css('background-image', 'url(' + background + ')');
			}
		});
	}

	if (jQuery('.worplex-user-form').find('.form-security-fields').length > 0) {
		var request = jQuery.ajax({
			url: worplex_cscript_vars.ajax_url,
			method: "POST",
			data: {
				adding: 'reg_referrer_field',
				action: 'worplex_add_form_referrer_field_call'
			},
			dataType: "json"
		});
		request.done(function (response) {
			jQuery('.worplex-user-form').find('.form-security-fields').html(response.html);
		});
	}
});

function worplex_submit_msg_alert(msg, alert_class = 'worplex-alert-info') {
    var id = Math.floor(Math.random() * 1000000) + 1;
    jQuery('body').find('.worplex-alert-msg').remove();
    jQuery('body').append('<div id="alert-' + id + '" class="worplex-alert-msg ' + alert_class + '">' + msg + '</div>');
    setTimeout(function(){ jQuery('#alert-' + id).remove(); }, 8000);
}

jQuery(document).on('submit', '.worplex-user-form', function (ev) {

	ev.preventDefault();
	
	var this_form = jQuery(this);
	var this_btn = this_form.find('button[type=submit]');
	var button_html = this_btn.html();
	var from_element = this_form[0];
	var form_data = new FormData(from_element);
	
	if (!this_form.hasClass('ajax-processing')) {
		if (this_form.hasClass('loding-onall-con')) {
			this_form.append('<div class="worplex-loder-con"><div class="worplex-loder-iner"><div class="worplex-loader"></div></div></div>');
			var elem_to_got = this_form.find('.worplex-loder-con');
			jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);
		}
		this_btn.html(worplex_cscript_vars.submiting);

		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: worplex_cscript_vars.ajax_url,
			processData: false,
			contentType: false,
			data: form_data,
			success: function(data) {
				if (data.error == '0') {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-success');
				} else if (data.error == '2') {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-info');
				} else {
					worplex_submit_msg_alert(data.msg, 'worplex-alert-danger');
				}
				if (typeof data.redirect !== undefined && data.redirect != undefined && data.redirect != '') {
					if (data.redirect == 'same') {
						window.location.reload();
					} else {
						window.location.replace(data.redirect);
					}
					return false;
				}
				this_btn.html(button_html);
				this_form.removeClass('ajax-processing');
				if (this_form.hasClass('loding-onall-con')) {
					this_form.find('.worplex-loder-con').remove();
				}
			},
			error: function() {
				this_btn.html(button_html);
				this_form.removeClass('ajax-processing');
				if (this_form.hasClass('loding-onall-con')) {
					this_form.find('.worplex-loder-con').remove();
				}
			}
		});
	}
	
	this_form.addClass('ajax-processing');
});

jQuery(document).on('click', '.login-to-regconv', function (ev) {
	ev.preventDefault();
	var reg_con_holder = jQuery('.popup-signupsec-con');
	var log_con_holder = jQuery('.popup-loginsec-con');

	log_con_holder.hide();
	reg_con_holder.slideDown();
});

jQuery(document).on('click', '.reg-to-loginconv', function (ev) {
	ev.preventDefault();
	var reg_con_holder = jQuery('.popup-signupsec-con');
	var log_con_holder = jQuery('.popup-loginsec-con');

	reg_con_holder.hide();
	log_con_holder.slideDown();
});

jQuery('.worplex-user-pkg-buybtn').on('click', function(ev) {
	ev.preventDefault();
    var _this = jQuery(this);
    var this_parent = _this.parents('.pricing_wrap');

    var pkg_id = _this.data('id');

    this_parent.append('<div class="worplex-loder-con"><div class="worplex-loder-iner"><div class="worplex-loader"></div></div></div>');
	var elem_to_got = this_parent.find('.worplex-loder-con');
	jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: worplex_cscript_vars.ajax_url,
        data: {
            pkg_id: pkg_id,
            action: 'worplex_member_pckgbuy_call'
        },
        success: function(data) {
			if (data.error == '0') {
				worplex_submit_msg_alert(data.msg, 'worplex-alert-success');
			} else if (data.error == '2') {
				worplex_submit_msg_alert(data.msg, 'worplex-alert-info');
			} else {
				worplex_submit_msg_alert(data.msg, 'worplex-alert-danger');
			}
			if (typeof data.redirect !== undefined && data.redirect != undefined && data.redirect != '') {
				window.location.href = data.redirect;
				return false;
			}
            this_parent.find('.worplex-loder-con').remove();
        },
        error: function() {
            this_parent.find('.worplex-loder-con').remove();
        }
    });
});


jQuery('.jobdet-applybtn-act').on('click', function() {
	var _this = jQuery(this);
	var job_id = _this.data('id');
	var apply_form = jQuery('#worplex-apply-job-popup').find('form');
	var apply_input = apply_form.find('input[name="apply_job_id"]');
	if (apply_input.length > 0) {
		apply_input.remove();
	}
	apply_form.append('<input type="hidden" name="apply_job_id" value="' + job_id + '">');
});

function worplex_form_image_file_change(e) {
    var img_test = '';
    var allow_file_types = ['image/jpg', 'image/jpeg', 'image/png'];
    var allow_file_size = 10400;
    if (e.target.files.length > 0) {
        var dropd_file = e.target.files[0];
        var file_type = dropd_file.type;
        var file_size = dropd_file.size;
        file_size = parseFloat(file_size / 1024).toFixed(2);
        if (!(allow_file_types.indexOf(file_type) >= 0)) {
            worplex_submit_msg_alert('Error: Only image with .png or .jpg extension is allowed to upload.', 'worplex-alert-danger');
            img_test = 'fail';
        }
        if (file_size > allow_file_size && img_test != 'fail') {
            worplex_submit_msg_alert('Error: Image size is too big to upload. Please use optimized image only.', 'worplex-alert-danger');
            img_test = 'fail';
        }
    } else {
        img_test = 'fail';
    }

    if (img_test != 'fail') {
        if (e.target.files.length > 0) {
            
            var logo_img_con = jQuery('#logofile-name-container').find('.logo-img-con');
            //
            var img_reader = new FileReader();
            img_reader.addEventListener("load", function() {
				var img_src = img_reader.result;
				logo_img_con.find('img').attr('src', img_src);
				logo_img_con.find('i').hide();
				logo_img_con.find('img').removeAttr('style');
			}, false);
            img_reader.readAsDataURL(dropd_file);
        }
    }
}

jQuery('.worplex-favcandidate-btn').on('click', function() {
    var _this = jQuery(this);
    var this_icon = _this.find('i');
    var post_id = _this.data('id');
    this_icon.attr('class', 'worplex-fa worplex-faicon-circle-notch worplex-faicon-spin');

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: worplex_cscript_vars.ajax_url,
        data: {
            post_id: post_id,
            action: 'worplex_candidate_like_favourite_ajax'
        },
        success: function(data) {
            var totalFavorites = data.total_favorites;
            this_icon.attr('class', 'lni lni-heart-filled position-absolute');
            updateTotalFavorites(totalFavorites); // Call a function to update the total favorites count on the page
        },
        error: function() {
            this_icon.attr('class', 'lni lni-heart position-absolute');
        }
    });
});



function updateTotalFavorites(count) {
    // Assuming you have a DOM element with the ID 'totalFavoritesCount' to display the count
    var totalFavoritesCountElement = jQuery('#totalFavoritesCount');
    if (totalFavoritesCountElement.length > 0) {
        totalFavoritesCountElement.text(count);
    }
}

// For Candidate Bookmarks

jQuery('.worplex-delete-post-btn').on('click', function() {
    var post_id = jQuery(this).data('id');
    var _this = jQuery(this);
    
    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: worplex_cscript_vars.ajax_url,
        data: {
            post_id: post_id,
            action: 'worplex_remove_from_favorites_ajax'
        },
        success: function(data) {
            _this.closest('.worplex-post-item').remove();
        },
        error: function() {
            // Handle error if necessary
        }
        
    });
});


 

// Job Category

// when click on any category then show there jobs 
//put first form class here
jQuery('.worplex-jobfilter-form').find('input[type="radio"]').on('change', function() {
	jQuery(this).parents('form').submit();
});

 
 //candidate function Zubair
 
 jQuery('.worplex-favjab-btn').on('click', function() {
    var _this = jQuery(this);
    var this_icon = _this.find('i');

    var post_id = _this.data('id');

    this_icon.attr('class', 'worplex-fa worplex-faicon-circle-notch worplex-faicon-spin');

    jQuery.ajax({
        type: "POST",
        dataType: "json",
        url: worplex_cscript_vars.ajax_url,
        data: {
            post_id: post_id,
            action: 'worplex_job_like_favourite_ajax'
        },
        success: function(data) {
            this_icon.attr('class', 'lni lni-heart-filled position-absolute');
        },
        error: function() {
            this_icon.attr('class', 'lni lni-heart position-absolute');
        }
    });
});

jQuery('.worplex-alrdy-favjab').on('click', function() {
	worplex_submit_msg_alert(worplex_cscript_vars.alredy_saved, 'worplex-alert-info');
});



// Employer dashboard zubair bookmarks

jQuery(document).ready(function(jQuery) {
            jQuery('.worplex-delete-post-btn').click(function(e) {
                e.preventDefault();
                var postId = jQuery(this).data('id');
                var button = jQuery(this);

                // Perform an AJAX request to unlike the post
                jQuery.ajax({
                    url: worplex_cscript_vars.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'worplex_delete_post_emply',
                        post_id: postId,
                    },
                    success: function(response) {
                        // Assuming the unlike operation is successful, remove the table row from the DOM
                        button.closest('div').remove();
                    },
                });
            });
        });


// Employer dashboard shorting zubair

jQuery('.worplex-sort-name').find('select').on('change', function() {
    jQuery(this).parents('form').submit();
});			

function submitForm() {
    // Get the selected value from the dropdown
    const selectedOption = document.querySelector(".form-control").value;
    
    // You can perform any action here with the selected value, such as sending it to a server or processing it locally
    console.log("Selected option:", selectedOption);
			document.getElementById("jobForm").submit();
}

// //when you click on show button then submit the form
// //put first, form class here
jQuery('.worplex-jobfilter-form').find('input[type="radio"]').on('change', function() {
	jQuery(this).parents('form').submit();
});

jQuery(document).on('submit', '.worplex-jobfilter-form', function (ev) {

	ev.preventDefault();

	var this_form = jQuery(this);
	// add a div above row to contain all row for loading by ajax class="worplex-all-job-listing-con"
	var this_par = this_form.parents('.worplex-all-listing-con');
	var from_element = this_form[0];
	var form_data = new FormData(from_element);

	if (!this_form.hasClass('ajax-processing')) {
	// add a div above on posts (where shown jobs with class like class="worplex-alljobs-list")
		this_par.append('<div class="worplex-loder-con"><div class="worplex-loder-iner"><div class="worplex-loader"></div></div></div>');
		var elem_to_got = this_par.find('.worplex-loder-con .worplex-loader');
		jQuery('html, body').animate({scrollTop: elem_to_got.offset().top - 100}, 1000);

		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: worplex_cscript_vars.ajax_url,
			processData: false,
			contentType: false,
			data: form_data,
			success: function(data) {
				
				this_par.find('.worplex-alljobs-list').html(data.html);

				this_par.find('.worplex-loder-con').remove();
				this_form.removeClass('ajax-processing');
				//
				var data_query = jQuery(this_form[0].elements).not(':input[name="action"],:input[name="numposts"],:input[name="orderby"]').serialize();
				var current_url = location.protocol + "//" + location.host + location.pathname + "?" + data_query; //window.location.href;
				window.history.pushState(null, null, decodeURIComponent(current_url));
			},
			error: function() {
				this_par.find('.worplex-loder-con').remove();
				this_form.removeClass('ajax-processing');
			}
		});
	}

	this_form.addClass('ajax-processing');
});
