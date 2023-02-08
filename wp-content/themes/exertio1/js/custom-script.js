(function ($) {
	"use strict";

	
	//if(typeof localize_vars_frontend === 'undefined' && localize_vars_frontend != null)
	$(window).load(function() {
		$(".exertio-loader-container").fadeOut("slow");
	});
	var localize_vars;
	if(typeof localize_vars_frontend != 'undefined')
	{
		localize_vars = localize_vars_frontend;
	}
	else
	{
		localize_vars = '';
	}
	var owl_rtl = false;
	if( localize_vars.is_rtl == true)
	{
		owl_rtl = true;
	}
	$(document).ready(function(){
		if ( $( ".project-sidebar .panel-body, .service-side .panel-body" ).length )
		{
			$(".project-sidebar .panel-body, .service-side .panel-body").niceScroll();
			$(".project-sidebar .panel-body, .service-side .panel-body").mouseover(function() {
				$(this).getNiceScroll().resize(); 
			});
		}
	});
	$(document).ready(function(){
		if ( $( ".popup-video" ).length )
		{
			jQuery("a.popup-video").YouTubePopUp( { autoplay: 0 } );
		}
		$('.post-type-change').on('change', function() {
			var post_value = this.value;
			if(post_value === "Freelancer")
			{
				$('.hero-one-form').attr('action', localize_vars.freelancer_search_link);	
			}
			if(post_value === "Employers")
			{
				$('.hero-one-form').attr('action', localize_vars.employer_search_link);	
			}
			if(post_value === "Projects")
			{
				$('.hero-one-form').attr('action', localize_vars.project_search_link);	
			}
			if(post_value === "Services")
			{
				$('.hero-one-form').attr('action', localize_vars.services_search_link);	
			}
		});
		if ( $( ".services-range-slider" ).length )
		{
			var $servicesRange = $(".services-range-slider"),
			$servicesInputFrom = $(".services-input-from"),
			$servicesInputTo = $(".services-input-to"),
			instance,
			min = 0,
			max = 900000000,
			from = 0,
			to = 0;
			$servicesRange.ionRangeSlider({
				skin: "round",
				type: "double",
				min: min,
				max: max,
				from: 0,
				to: 900000000,
				onStart: updateInputs,
				onChange: updateInputs
			});
			instance = $servicesRange.data("ionRangeSlider");
			function updateInputs (data) {
				from = data.from;
				to = data.to;
				
				$servicesInputFrom.prop("value", from);
				$servicesInputTo.prop("value", to);	
			}
			$servicesInputFrom.on("input", function () {
				var val = $(this).prop("value");
				
				if (val < min) {
					val = min;
				} else if (val > to) {
					val = to;
				}
				
				instance.update({
					from: val
				});
			});
			$servicesInputTo.on("input", function () {
				var val = $(this).prop("value");
				
				if (val < from) {
					val = from;
				} else if (val > max) {
					val = max;
				}
				
				instance.update({
					to: val
				});
			});
		}
		if ( $( "#order_by" ).length )
		{
			$('#order_by').on('change', function() {
				$(this).closest("form").submit();
			});
			
		}
		$( ".list-style" ).on( "click", function() {
				var list_style = $(this).data('list-style');
				$("input[name=list-style]").val(list_style);
			    $(this).closest("form").submit();
			});
			
		$( ".show-skills" ).on( "click", function() {
				$( this ).parent().addClass('active');
			    $(this).hide();
			});


	});
	$.protip();
	$('select').select2();
	$('.btn').on('click', function() {
    var $this = $(this);
	  $this.button('loading');
		setTimeout(function() {
		   $this.button('reset');
	   }, 8000);
	});
	var $container = $('.grid');
	$container.imagesLoaded(function(){
	  $container.masonry({
		itemSelector : '.grid-item',
		percentPosition: true,
		layoutMode: 'masonry',
		transitionDuration: '0.7s',
	  });
	});
	
$(document).ready(function(){
  $("a.scroll").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
		  var hash = this.hash;
		  $('html, body').animate({
			scrollTop: $(hash).offset().top
		  }, 800, function(){
			window.location.hash = hash;
		  });
		} 
	  });
});
	
	
	$('.not_loggedin_chat_toggler').click(function(){
		$(this).find($(".fas")).addClass("fa-spinner fa-spin" );
		$(this).find($(".fas")).removeClass("fa-angle-right" );
		$.post(localize_vars.freelanceAjaxurl,{action: 'whizzchat_notloggedin'}).done(function (response)
		{
			if ( true === response.success )
			{
				toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".fas").addClass("fa-angle-right" );
				$(".fas").removeClass("fa-spinner fa-spin" );
			}
			else
			{
				$(".fas").addClass("fa-angle-right" );
				$(".fas").removeClass("fa-spinner fa-spin" );
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$('.loader-outer').hide();
			}

		})
	});
	
	if ( $( "#signup-form" ).length )
	{
		$('#password-field').passtrength({
			minChars: 4,
			tooltip:true,
			textWeak:localize_vars.pass_textWeak,
			textMedium:localize_vars.pass_textMedium,
			textStrong:localize_vars.pass_textStrong,
			textVeryStrong:localize_vars.pass_textVeryStrong,
			passwordToggle: false,
		});
	}
	$('#signup-btn').click(function(){
		if( $('form#signup-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('span.bubbles').addClass('view');
			$("#signup-btn").attr("disabled", true);
			var redirect_id = $(this).attr('data-redirect-id');
		  $.post(localize_vars.freelanceAjaxurl, {action: 'sign_up', signup_data: $("form#signup-form").serialize(), security:$('#register_nonce').val(), redirect_id:redirect_id }).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					//this_value.find('span.bubbles').removeClass("view");
					$('#signup-btn').attr("disabled", false);
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					if(get_notification[3] != '')
					{
						this_value.find('span.bubbles').removeClass("view");
						$("#fl_user_id").val(get_notification[3]);
						$(".fr_resend_email").css("display", "block");
					}
					else if(get_notification[2] != '')
					{
						window.location = get_notification[2];
					}

				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#signup-btn').attr("disabled", false);
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#signup-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	$('.fr_send_email').click(function(){
		var val_user_id = $('#fl_user_id').val();
		var val_nonce_id = $('#register_nonce').val();
			$.post(localize_vars.freelanceAjaxurl, {action: 'sign_up_resend',user_id:val_user_id, security:val_nonce_id}).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					$('#signup-form').find('span.bubbles').removeClass("view");
					$('#signup-form').trigger("reset");
					setTimeout(function(){
						window.location = get_notification[2];
					}, 60000);
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				else
				{
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			 });
	});
	$('#signin-btn').click(function(){
		if( $('form#signin-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$("#signin-btn").attr("disabled", true);
			var redirect_id = $(this).attr('data-redirect-id');
			

		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_sign_in', signin_data: $("form#signin-form").serialize(), redirect_id:redirect_id }).done(function (response)
                    {
						var get_notification = response.split('|');
						if ($.trim(get_notification[0]) == '1')
						{
							this_value.find('div.bubbles').removeClass("view");
							toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							window.location = get_notification[2];
						}
						else
						{
							this_value.find('div.bubbles').removeClass("view");
							$('#signin-btn').attr("disabled", false);
							toastr.error(get_notification[1], '', {timeOut: 80000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}
						
                    }).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#signup-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 800000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});

$('#forget_btn').click(function(){
		if( $('form#fl-forget-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$("#forget_btn").attr("disabled", true);
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_forget_pwd', forget_pwd_data: $("form#fl-forget-form").serialize(), security:$('#fl_forget_pwd_nonce').val()}).done(function (response)
                    {
						if ( true === response.success ) 
						{
							this_value.find('div.bubbles').removeClass("view");
							$('#forget_btn').attr("disabled", false);
							toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							$('#forget_pwd').modal('hide');
							$('#fl-forget-form').trigger("reset"); 
						}
						else
						{
							this_value.find('div.bubbles').removeClass("view");
							$('#forget_btn').attr("disabled", false);
							toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}
						
                    }).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#forget_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
if(localize_vars.is_reset !="" && localize_vars.is_reset == 1)
{
	if(localize_vars.reset_status.status == false)
	{
		toastr.error(localize_vars.reset_status.r_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
	}
	else
	{
		toastr.success(localize_vars.reset_status.r_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
		$('input[name=requested_user_id]').val(localize_vars.reset_status.requested_id);
		$(window).load(function() {
			$('#mynewpass').modal('show');
		});
	}
}
	
if(localize_vars.activation_is_set !="" && localize_vars.activation_is_set == 1)
{
	if(localize_vars.activation_is_set_msg.activation_status == false)
	{
		toastr.error(localize_vars.activation_is_set_msg.status_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
	}
	else
	{
		toastr.success(localize_vars.activation_is_set_msg.status_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
	}
}
$('.btn-reset-new').click(function(){
		if( $('form#mynewPass').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$(".btn-reset-new").attr("disabled", true);
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_forgot_pass_new', forget_pwd_data: $("form#mynewPass").serialize(), security:$('#fl_forget_new_pwd_nonce').val()}).done(function (response)
                    {
						if ( true === response.success ) 
						{
							this_value.find('div.bubbles').removeClass("view");
							$('.btn-reset-new').attr("disabled", false);
							toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							setTimeout(function(){
									 window.location = response.data.page_link;
									}, 800);
						}
						else
						{
							this_value.find('div.bubbles').removeClass("view");
							$('.btn-reset-new').attr("disabled", false);
							toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}
						
                    }).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('.btn-reset-new').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});





$(document).on('keyup', '#bidding-price', function() {

	var total_amount = $('input#bidding-price').val();
	var percentage = localize_vars.proAdminCost;
  
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL, {action: 'fl_calc_bid_price_fixed',  total_amount:total_amount, percentage:percentage }).done(function (response)
	{
		if ( true === response.success)
		{
			$("#service-price").html(response.data.admin_charges);
			$("#earning-price").html(response.data.earning);
		}
	})
});

/*FOR TOTAL CODE MINTUS ADMIN COST FOR HOURLY*/

$(document).on('keyup', '#bidding_price, #bid-hours', function() {
	
	var hourly_amount = $('input#bidding_price').val();
	var bid_hours = $('input#bid-hours').val();

	var percentage = localize_vars.proAdminCost;
  
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL, {action: 'fl_calc_bid_price',  hourly_amount:hourly_amount, bid_hours:bid_hours, percentage:percentage }).done(function (response)
	{
		if ( true === response.success)
		{
			$("#service-price").html(response.data.admin_charges);
			$("#earning-price").html(response.data.earning);
		}
	})
});
$('.price-breakdown').on('click', function() {
	$(".price-section").toggle(350);
});

/*SUBMIT PROJECT BID*/

$('#btn_project_bid').on('click', function() {
		if( $('form#bid_form').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#btn_project_bid").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_place_bid', bid_data: $("form#bid_form").serialize(), security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					if(response.data.page)
					{
						location.replace(response.data.page);
					}
					else
					{
						setTimeout(function(){
						  location.reload(true);
						},600);
					}
				}
				else
				{
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					$('#btn_project_bid').attr("disabled", false);	
				}
				
			}).fail(function () {
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
						$(".btn-loading .bubbles").removeClass("view");
						$('#btn_project_bid').attr("disabled", false);	
					   });
		}
	});

if ( $( ".fr-services2-box" ).length )
{
	$(".fl_addon_checkbox").prop("checked", false);
}
/*SERVICE DETAIL PAGE ADDONS CHECKBOXES*/
$(document).on('click', '.fl_addon_checkbox', function() {
	$('.loader-outer').show();
	var addon_price = $(this).attr("data-addon-price");
	var service_price = $('.project-price.service').find('.price' ).attr("data-service-price");
	var service_id = $(this).attr("data-service-id");

	if($(this).prop('checked'))
	{
		var calc = 'plus';
	}
	else
	{
		var calc = 'minus';
	}
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		$.post(freelanceAjaxURL, {action: 'fl_calc_services_price',  service_price:service_price, addon_price:addon_price, calc:calc, service_id:service_id }).done(function (response)
		{
			if ( true === response.success)
			{
				$('.loader-outer').hide();
				$('.project-price.service .price').html(response.data.cal_data_html);
				$('#buy_service small span').html(response.data.cal_data_html);
				$('#buy_service_woo small span').html(response.data.cal_data_html);
				$('.project-price.service .price').attr('data-service-price', response.data.cal_data)
				$('.loader-outer').hide();
			}
			else
			{
				$('.loader-outer').hide();
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			}

		}).fail(function () {
		$('.loader-outer').hide();
		toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
		});
});

/*BUY SERVICE*/
$(document).on('click', '#buy_service', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars.Msgconfirm,
			content: localize_vars.serviceBuy,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars.YesSure,
					btnClass: 'btn-theme',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var sid = this_value.attr("data-sid");
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_purchase_services', security:$('#gen_nonce').val(), sid:sid, purchase_data: $("form#purchased_addon_form").serialize() }).done(function (response)
							{
								if ( true === response.success)
								{
									$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									if(response.data.page)
									{
										location.replace(response.data.page);
									}
									else
									{
										setTimeout(function(){
										  location.reload(true);
										},600);
									}
									 
								}
								else
								{
									$('.loader-outer').hide();
									toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								}
								
							}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });

					}
				},
				cancel: {
					text: localize_vars.cancel,
					action: function(){ }
				}
			}
		});
	});

/*BUY SERVICE*/
$(document).on('click', '#buy_service_woo', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars.Msgconfirm,
			content: localize_vars.serviceBuy,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {
				ok: {
					text: localize_vars.YesSure,
					btnClass: 'btn-theme',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var sid = this_value.attr("data-sid");
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						$.post(freelanceAjaxURL, {action: 'fl_deposit_custom_service_callback', security:$('#gen_nonce').val(), sid:sid, deposit_custom_service_data: $("form#purchased_addon_form").serialize() }).done(function (response)
						{
							if ( true === response.success)
							{
								$('.loader-outer').hide();
								toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								if(response.data.page)
								{
									location.replace(response.data.page);
								}
								else
								{
									setTimeout(function(){
										location.reload(true);
									},600);
								}

							}
							else
							{
								$('.loader-outer').hide();
								toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							}

						}).fail(function () {
							$('.loader-outer').hide();
							toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
						});

					}
				},
				cancel: {
					text: localize_vars.cancel,
					action: function(){ }
				}
			}
		});
	});


/*FRONT END JAVASCRIPT*/
if ( $( ".client-slider" ).length )
{
	$('.client-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}
if ( $( ".sign-in" ).length )
{
	$('.sign-in').owlCarousel({
		loop: true,
		margin: 0,
		autoplay: false,
		nav: true,
		rtl:owl_rtl,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}

/* owl-carousel comments*/
	if ( $( ".header-cat-slider" ).length )
{
	$('.header-cat-slider').owlCarousel({
		loop: false,
		margin: 10,
		autoplay: false,
		nav: false,
		dots:false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 2
			},
			600: {
				items: 3
			},
			1000: {
				items: 4
			},
			1300: {
				items: 6
			},
			1600: {
				items: 8
			}
		}
	});
}
if ( $( ".explore-slider" ).length )
{
	$('.explore-slider').owlCarousel({
		loop: false,
		margin: 10,
		autoplay: false,
		nav: false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items: 4
			}
		}
	});
}
if ( $( ".top-lancer-slider" ).length )
{
	$('.top-lancer-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}
if ( $( ".top-services-2" ).length )
{
	$('.top-services-2').owlCarousel({
		loop: false,
		margin: 20,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items:4
			}
		}
	});
}
/* owl-carousel comments*/
if ( $( ".recomended-slider" ).length )
{
	$('.recomended-slider').owlCarousel({
		loop: false,
		margin: 10,
		nav: true,
		dots:false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items: 4
			}
			
		}
	});
}

$(document).ready(function() {
    $('.default-select').select2();
});

$(document).ready(function() {
  $('.fr-slick-thumb ').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
	//rtl: true,
    itemWidth: 100,
    itemMargin: 10,
    asNavFor: '.fr-slick',
	prevText:'<i class="fas fa-angle-left"></i>',
	nextText:'<i class="fas fa-angle-right"></i>',
  });
  $('.fr-slick').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
	//rtl: true,
    sync: ".fr-slick-thumb ",
	prevText:'<i class="fas fa-angle-left"></i>',
	nextText:'<i class="fas fa-angle-right"></i>',
  });
});

	
/*MARK FAV*/

	$(document).on('click', '.mark_fav', function () {
	$('.loader-outer').show();
	var post_id = $(this).attr('data-post-id');
	$.post(localize_vars.freelanceAjaxurl, {action: 'fl_mark_fav_project', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
	{
		if ( true === response.success ) 
		{
			toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		else
		{
			toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		
	}).fail(function () {
				toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
				$('.loader-outer').hide();
			   });
	});


	$(document).on('click', '.delete_fav_project', function () {
	var this_value = $(this);
	$.confirm({
				title: localize_vars.Msgconfirm,
				content: localize_vars.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							$('.loader-outer').show();
							var post_id = this_value.attr('data-post-id');
							$.post(localize_vars.freelanceAjaxurl, {action: 'fl_delete_fav_project', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
							{
								if ( true === response.success ) 
								{
									toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
										location.reload(true);
									}, 600);
								}
								else
								{
									toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									$('.loader-outer').hide();
								}
								
							}).fail(function () {
										toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
										$('.loader-outer').hide();
									   });

						}
					},
					cancel: {
						text: localize_vars.confimNo,
						action: function(){ }
					}
				}
			});
	});



/*SERVICES MARK AS SAVED*/

$('.save_service').on('click', function() {
	$('.loader-outer').show();
	var post_id = $(this).attr('data-post-id');
	$.post(localize_vars.freelanceAjaxurl, {action: 'fl_mark_fav_services', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
	{
		if ( true === response.success ) 
		{
			toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		else
		{
			toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		
	}).fail(function () {
				toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
				$('.loader-outer').hide();
			   });
	});

$('.delete_saved_service').on('click', function() {
	var this_value = $(this);
	$.confirm({
				title: localize_vars.Msgconfirm,
				content: localize_vars.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							$('.loader-outer').show();
							var post_id = this_value.attr('data-post-id');
							$.post(localize_vars.freelanceAjaxurl, {action: 'fl_delete_saved_services', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
							{
								if ( true === response.success ) 
								{
									toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									$('.loader-outer').hide();
									setTimeout(function(){
										location.reload(true);
									}, 600);
								}
								else
								{
									toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									$('.loader-outer').hide();
								}
								
							}).fail(function () {
										toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
										$('.loader-outer').hide();
									   });

						}
					},
					cancel: {
						text: localize_vars.confimNo,
						action: function(){ }
					}
				}
			});
	});

/*EMPLOYER DETAIL PAGE PAGINATION */
	$(document).on('click', '.emp_pro_pagination', function () {
			var pageno = $(this).attr('data-page-number');
			var author = $(this).attr('data-post-author');
			var this_value = $(this);
			$('.loader-outer').show();
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_get_paged_projects', pageno: pageno, author: author, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$("div.fl-navigation").find('.emp_pro_pagination').removeClass("active");
					this_value.addClass('active');

					$(".posted-projects").html('');
					$(".posted-projects").html(response.data.html);
					$(".emp-profile-pagination").html(response.data.pagination);
					$('.loader-outer').hide();
					$( ".show-skills" ).on( "click", function() {
						$( this ).parent().addClass('active');
						$(this).hide();
					});
				}
				else
				{
					$('.loader-outer').hide();
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});
	
	
/*FOLLOW EMPLOYERS*/

	$(document).on('click', '.follow-employer', function () {
		$('.loader-outer').show();
		var emp_id = $(this).attr('data-emp-id');
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_follow_employer', security:$('#gen_nonce').val(), emp_id:emp_id}).done(function (response)
		{
			if ( true === response.success ) 
			{
				toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$('.loader-outer').hide();
			}
			else
			{
				toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$('.loader-outer').hide();
			}
			
		}).fail(function () {
					toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
					$('.loader-outer').hide();
				   });
	});

/*FOLLOW FREELANCER*/

	$(document).on('click', '.follow-freelancer', function () {
		var this_value =$(this);
		this_value.find('i.fa-heart').remove();
		this_value.prepend('<i class="fa fa-spinner fa-spin"></i>');
		var fid = $(this).attr('data-fid');
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_follow_freelancer', security:$('#gen_nonce').val(), fid:fid}).done(function (response)
		{
			if ( true === response.success ) 
			{
				toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				this_value.find('i.fa-spinner').hide();
				this_value.prepend('<i class="fa fa-heart active"></i>');
			}
			else
			{
				toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				this_value.find('i.fa-spinner').hide();
				//this_value.prepend('<i class="fa fa-heart active"></i>');
			}
			
		}).fail(function () {
					toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
					this_value.find('i.fa-spinner').hide();
					this_value.prepend('<i class="fa fa-heart"></i>');
				   });
	});
	
$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("data-toggle"));
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
	
	
	var counterUp = window.counterUp["default"]; // import counterUp from "counterup2"
    
    var $counters = $(".counter");
    
    /* Start counting, do this on DOM ready or with Waypoints. */
    $counters.each(function (ignore, counter) {
        counterUp(counter, {
            duration: 1000,
            delay: 16
        });
    });
	if ( $( ".elbow" ).length )
	{
		$('.elbow').owlCarousel({
			loop:true,
			margin:0,
			autoplay:true,
			nav:true,
			rtl:owl_rtl,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})
	}
	if($('.my-testimonials').length > 0)
	{
		$(".my-testimonials").owlCarousel({
			margin: 0,
			smartSpeed: 600,
			autoplay: 5000, //Set AutoPlay to 5 seconds

			loop: true,
			responsiveClass: true,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
			nav: false,
			dots: false,
			rtl:owl_rtl,
			responsive: {
				0: {
					items: 1
				},
				480: {
					items: 1
				},
				769: {
					items: 1
				},
				1000: {
					items: 1
				}
			}

		});
	}
	
/*EMPLOYER PACKAGE*/
$(document).on('click', '.emp-purchase-package', function () {
			var this_value = $(this);
			this_value.find('span.bubbles').addClass("view");
			var product_id = $(this).attr('data-product-id');
			var emp_nonce = $(".employer_package_nonce"). val();
			$(".emp-purchase-package").attr("disabled", true);
	alert
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_employer_package_callback', security:emp_nonce, product_id:product_id }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('span.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.cart_page;
				}
				else
				{
					this_value.find('span.bubbles').removeClass("view");
					$(".emp-purchase-package").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('span.bubbles').removeClass("view");
						$(".emp-purchase-package").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});	


/*FREELANCER PACKAGE*/
$(document).on('click', '.freelancer-purchase-package', function () {
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			var product_id = $(this).attr('data-product-id');
			var freelancer_nonce = $(".freelancer_package_nonce"). val();
			$(".freelancer-purchase-package").attr("disabled", true);
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_freelancer_package_callback', security:freelancer_nonce, product_id:product_id }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.cart_page;
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$(".freelancer-purchase-package").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$(".freelancer-purchase-package").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});	

	/*REPORT*/
	$('#btn-report').click(function(){
		if( $('form#report-form').smkValidate() )
		{
			var this_value = $(this);
			var post_id = $(this).attr('data-post-id');
			this_value.find('span.bubbles').addClass('view');
			$("#btn-report").attr("disabled", true);
			$.post(localize_vars.freelanceAjaxurl, {action: 'fl_report_call_back', report_data: $("form#report-form").serialize(), post_id: post_id, security:$('#fl_report_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-report').attr("disabled", false);
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#report-modal').modal('hide');
					$('#report-form').trigger("reset"); 
				}
				else
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-report').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#report-form').trigger("reset"); 
				}

			}).fail(function () {
				this_value.find('span.bubbles').removeClass("view");
				$('#btn-report').attr("disabled", false);
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
			   });
		}
	});
	
	/*REPORT*/
	$('#btn-hire-freelancer').click(function(){
		if( $('form#hire-freelancer-form').smkValidate() )
		{
			var this_value = $(this);
			var freelancer_id = $(this).attr('data-freelancer-id');
			this_value.find('span.bubbles').addClass('view');
			$("#btn-hire-freelancer").attr("disabled", true);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.post(freelanceAjaxURL, {action: 'hire_freelancer_call_back', hire_freelancer_data: $("form#hire-freelancer-form").serialize(), freelancer_id:freelancer_id, security:$('#fl_hire_freelancer_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-hire-freelancer').attr("disabled", false);
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#report-modal').modal('hide');
					$('#hire-freelancer-form').trigger("reset"); 
				}
				else
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-hire-freelancer').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#hire-freelancer-form').trigger("reset"); 
				}

			}).fail(function () {
				this_value.find('span.bubbles').removeClass("view");
				$('#btn-hire-freelancer').attr("disabled", false);
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
			   });
		}
	});
	
	
	$(document).ready(function(){
	      // Options search field
	      $('.project-sidebar .panel-body.add-search, .service-side .panel-body.add-search').before(
	          '<div class="search-finder"><input class="search form-control"  type="text" />'
	          +'<span class="search-clear-btn"><a href="" onclick="return false;" class="search-clear"><i class="fas fa-times"></i></a></span></div>'
	          );
		
		$('.project-sidebar .search, .service-side .search').keyup(function(){
	        var valThis = $(this).val().toLowerCase();
	          $(this).parent().parent().find('input[type=checkbox]').each(function(){
	             var text = $("span[for='"+$(this).attr('id')+"']").text().toLowerCase();
				  //console.log(valThis.contains(text));
				 (text.indexOf(valThis) != -1) ? $(this).parent().show() : $(this).parent().hide();
				  (text.indexOf(valThis) != -1) ? $(this).show() : $(this).hide();
				  
				  if(text.indexOf(valThis) != -1){
					   $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").show();
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().removeClass("sub_li_hide");
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().parent().removeClass("sub_ul_hide");
				  }
				  else{
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").hide();
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().addClass("sub_li_hide");
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().parent().addClass("sub_ul_hide");
				  }
				  
	         });
	  });
		
		$(".project-sidebar .search-clear, .service-side .search-clear").on('click', function(){
	        $(".search").val("");

			$(".project-sidebar, .service-side").find(".sub_ul_hide").removeClass("sub_ul_hide");
			$(".project-sidebar, .service-side").find(".sub_li_hide").removeClass("sub_li_hide");
	        $('input[type=checkbox]').each(function(){
	        	$(this).parent().show();
				$(this).parent().parent().find("span").show();
	        });
	      });
	});
	if(localize_vars_frontend.exertio_notification == true)
	{
		setInterval(exertio_automate_notification, localize_vars_frontend.notification_time);
		var title = document.title;
		function exertio_automate_notification(){
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.post(freelanceAjaxURL, {action: 'exertio_notification_ajax'}).done(function (response)
			{
				if ( true === response.success )
				{
					var n_count = response.data.count;
					if(n_count > 0)
					{
						$(".notification-list").html(response.data.n_list);
						$("a.notification-click .badge-container").html('<span class="badge bg-danger">'+n_count+'</span>');
						document.title = '('+response.data.count+') '+title;
					}
				}
				else
				{
					console.log('error');
				}

			}).fail(function () {
				console.log('error 2');
			});
		}


		//$(document).on('click', 'a.notification-click', function () {
		$('a.notification-click').on('click', function(){
			var this_value = $(this);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.post(freelanceAjaxURL, {action: 'exertio_read_notifications', security:$('#gen_nonce').val()}).done(function (response)
			{
				if ( true === response.success )
				{
					$( ".notification-click .badge-container span.badge" ).remove();
					document.title = title;
				}
				else
				{
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			}).fail(function () {
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});

			});
		});
	}
	
	$('.arrow-down').on('click', function() {
			//$(".cpt-dropdown-header").show();
		$(".cpt-dropdown-header").toggle();
		});
	$('.cpt-dropdown-header li').on('click', function() {
			//var post_value = this.value;
			var post_value = $(this).attr('data-cpt');
			if(post_value === "freelancer")
			{
				$('.cpt-header-form').attr('action', localize_vars.freelancer_search_link);	
				$('.cpt-header-form input').attr("placeholder", localize_vars.searchTalentText);
			}
			if(post_value === "employer")
			{
				$('.cpt-header-form').attr('action', localize_vars.employer_search_link);
				$('.cpt-header-form input').attr("placeholder", localize_vars.searchEmpText);
			}
			if(post_value === "project")
			{
				$('.cpt-header-form').attr('action', localize_vars.project_search_link);
				$('.cpt-header-form input').attr("placeholder", localize_vars.findJobText);
			}
			if(post_value === "service")
			{
				$('.cpt-header-form').attr('action', localize_vars.services_search_link);
				$('.cpt-header-form input').attr("placeholder", localize_vars.searchServiceText);
			}
			$(".cpt-dropdown-header").toggle();
		});
	$(document).ready(function(){
		if ( $( ".services-range-slider" ).length )
		{
			var $servicesRange = $(".services-range-slider"),
				$servicesInputFrom = $(".services-input-from"),
				$servicesInputTo = $(".services-input-to"),
				instance,
				min = 0,
				max = 9000,
				from = 0,
				to = 0;
			$servicesRange.ionRangeSlider({
				skin: "round",
				type: "double",
				min: min,
				max: max,
				from: 0,
				to: 9000,
				onStart: updateInputs,
				onChange: updateInputs
			});
			instance = $servicesRange.data("ionRangeSlider");
			function updateInputs (data) {
				from = data.from;
				to = data.to;

				$servicesInputFrom.prop("value", from);
				$servicesInputTo.prop("value", to);
			}
			$servicesInputFrom.on("input", function () {
				var val = $(this).prop("value");

				if (val < min) {
					val = min;
				} else if (val > to) {
					val = to;
				}

				instance.update({
					from: val
				});
			});
			$servicesInputTo.on("input", function () {
				var val = $(this).prop("value");

				if (val < from) {
					val = from;
				} else if (val > max) {
					val = max;
				}

				instance.update({
					to: val
				});
			});
		}
		$('.default-select').select2();
	});
	$(".show_detail_project").on( "click", function() {
		$('.detail_loader .loader-outer').show();
		var post_id = $(this).attr('data-post-id');
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_detail_search_page', post_id:post_id }).done(function (response)
		{
			$('.close_project_detail').css("display", "block");
			$('.exer-fr-dtl-main').css("display", "block");
			if ( true === response.success )
			{
				$('.detail_loader .loader-outer').hide();
				$(".exer-fr-dtl-main").html(response.data.html);
			}
			else
			{
				$('.detail_loader .loader-outer').hide();
				$(".exer-fr-dtl-main").html(response.data.html);
			}

		}).fail(function () {
		});
	});
	$(".close_project_detail").on("click",function(){
		$('.exer-fr-dtl-main').css("display", "none");
		$('.close_project_detail').css("display", "none");
	});
})(jQuery);