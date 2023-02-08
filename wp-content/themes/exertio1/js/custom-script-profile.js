(function ($) {
	"use strict";
	var text = $('.col-md-12.grid-margin .mr-md-3 h2').text();
	$(".col-md-12.grid-margin .mr-md-3 .ext").text('/ '+text);	 
	//alert(text);
	$( window ).load(function() {
		if ( $( "#usermodal" ).length )
		{
			$('#usermodal').modal('show');
		}
	});
	
	jQuery('#datepickerdefault').datetimepicker({
		timepicker:false,
		format:'Y/m/d',
		lazyInit:true,
		//minDate:'0',
	});

	$( document ).ready(function() {
		$.datetimepicker.setLocale(localize_vars_frontend.exertio_local);
	});

	$('.general_select').select2();
	$('.general_select_2').select2({ minimumResultsForSearch: -1 });
	$('.multi_select').select2({
		tags: true
		});
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

     //>=, not <=
    if (scroll >= 300) {
        $(".sidebar-offcanvas").addClass("top");
    }
	else
	{
		$(".sidebar-offcanvas").removeClass("top");	
	}
});
$(document).on('change', '#project_location_remote', function () {
	if($('#project_location_remote').prop('checked'))
	{
		$('.project_location').prop('disabled', true);
	}
	else
	{
		$('.project_location').prop('disabled', false);
	}
});

/*FOR THE MULTI SELECT2 APPEND AT THE END*/	
//$("select").on("select2:select", function (evt) {
//  var element = evt.params.data.element;
//  var $element = $(element);
//
//  $element.detach();
//  $(this).append($element);
//  $(this).trigger("change");
//});	
	
	
	$( ".sortable" ).sortable();
	$(".proposal-box-scrollable").niceScroll({cursorcolor:"#999",});
	$(".history-body").niceScroll({cursorcolor:"#999",});
	

	$( ".addon-toggle" ).on( "click", function() {
		$( ".addons-detail" ).toggle( "fast");
	});
	if ( $( ".history-body" ).length )
	{
		$('.history-body').scrollTop($('.history-body').get(0).scrollHeight, -1);
	}
	$('.fl-textarea').richText({
		fonts: false,
		fontColor:false,
		imageUpload: false,
		fileUpload: false,
		videoEmbed: false,
		urls: false,
		table: false,
		removeStyles: true,
		heading: false,
		useParagraph: true,
		});	
	
	var body = $('body');
	$('[data-toggle="minimize"]').on("click", function() {
      body.toggleClass('sidebar-icon-only');
    });
	
    $(function() {
		$('[data-toggle="offcanvas"]').on("click", function() {
			$('.sidebar-offcanvas').toggleClass('active')
		});
	});
	
	$('.attachment_switch').click(function(){
		if($(this).prop("checked") == true){
			$('.img-wrapper').show();
			$('.attachment-box').show();
			$(this).val('yes');
		}
		else if($(this).prop("checked") == false){
			$('.img-wrapper').hide();
			$('.attachment-box').hide();
			$(this).val('no');
		}
	});
	
	/* PROFILE SELECTION FROM THE MENU */
	$(document.body).on('click', '.profile_selection', function () {
		var this_value = $(this);
		var active_profile = this_value.attr("data-profile-active");

		$('.loader-outer').show();
		var freelanceAjaxURL = $("#freelance_ajax_url").val();

		$.post(freelanceAjaxURL, {action: 'exertio_user_switch', active_profile: active_profile, security:$('#gen_nonce').val()}).done(function (response)
		{
			if ( true === response.success ) 
			{
				$(".btn-loading .bubbles").removeClass("view");
				location.reload(true);
				$('.loader-outer').hide();
			}
			else
			{
				$('.loader-outer').hide();
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".btn-loading .bubbles").removeClass("view");
			}

		}).fail(function () {
			$('.loader-outer').hide();
					toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
				   });
});

	

	$(document).on('click', '#abc', function () {
		if(!!navigator.geolocation) {
	
			var map;
	
			var mapOptions = {
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
	
			map = new google.maps.Map(document.getElementById('google_canvas'), mapOptions);
	
	

	
	
			navigator.geolocation.getCurrentPosition(function(position) {
	
				var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	
				var infowindow = new google.maps.InfoWindow({
					map: map,
					position: geolocate,
					/*content:
						'<h1>Location pinned from HTML5 Geolocation!</h1>' +
						'<h2>Latitude: ' + position.coords.latitude + '</h2>' +
						'<h2>Longitude: ' + position.coords.longitude + '</h2>'*/
				});
	
				map.setCenter(geolocate);
			//console.log(infowindow);
			
			
        var geocoder = new google.maps.Geocoder;

        var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(11);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
			  console.log(results[0]);
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
			  document.getElementById("searchMapInput").value = results[0]['formatted_address'];
			  document.getElementById('loc_lat').value = position.coords.latitude;
              document.getElementById('loc_long').value = position.coords.longitude;
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      //}

			
			
			
			});
	
		} else {
			document.getElementById('google_canvas').innerHTML = 'No Geolocation Support.';
		}
	});
	




	/*UPLOAD PROFILE IMAGE*/
	$(document).on('change', '#emp_profile_pic', function () {
		$('.loader-outer').show();
        var fd = new FormData();
        var files_data = $('#emp_profile_pic');
		var name = $('#emp_profile_pic').attr("name");
		var pid = $(this).attr('data-post-id');
		var post_meta = $(this).attr('data-post-meta');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('emp_profile_pic[' + j + ']', file);
            });
        });
		
        fd.append('action', 'emp_profile_pic');

		fd.append('post-id', pid);
		fd.append('post-meta', post_meta);
		fd.append('field-name', name);
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		
        $.ajax({
            type: 'POST',
            url: freelanceAjaxURL,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.loader-outer').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1")
                {
					toastr.success(res_arr[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".profile-img-container").html('<img src="'+res_arr[2]+'" class="img-fluid" > <i class="mdi mdi-close" id="delete_image" data-post-id="'+pid+'" data-post-meta ="'+post_meta+'" data-attachment-id="'+res_arr[3]+'"></i>');
                }
                else
                {
                    toastr.error(res_arr[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
                }

            }
        });
	});

	/*UPLOAD COBER IMAGE*/
	$(document).on('change', '#emp_cover_image', function () {
			 $('.loader-outer').show();
			var fd = new FormData();
			var files_data = $('#emp_cover_image');
			
			var name = $('#emp_cover_image').attr("name");
			var pid = $(this).attr('data-post-id');
			var post_meta = $(this).attr('data-post-meta');
			
			$.each($(files_data), function (i, obj) {
				$.each(obj.files, function (j, file) {
					fd.append('banner_img[' + j + ']', file);
				});
			});
			
			fd.append('action', 'emp_profile_pic');

			fd.append('post-id', pid);
			fd.append('post-meta', post_meta);
			fd.append('field-name', name);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			
			$.ajax({
				type: 'POST',
				url: freelanceAjaxURL,
				data: fd,
				contentType: false,
				processData: false,
				success: function (res) {
					$('.loader-outer').hide();
					var res_arr = res.split("|");
					if ($.trim(res_arr[0]) == "1")
					{
						toastr.success(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						$(".banner-img-container").html('<img src="'+res_arr[2]+'" class="img-fluid" ><i class="mdi mdi-close" id="delete_image" data-post-id="'+pid+'" data-post-meta ="'+post_meta+'" data-attachment-id="'+res_arr[3]+'"></i>');
					}
					else
					{
						toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					}
	
				}
			});
		});
		
/*DELET IMAGE FROM PROFILE*/	
	
	$(document).on('click', '#delete_image', function () {
		var post_id = $(this).attr('data-post-id');
		var post_meta = $(this).attr('data-post-meta');
		var attachment_id = $(this).attr('data-attachment-id');
		
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.remove,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						
						$.post(freelanceAjaxURL, {action: 'fl_delete_image', post_id:post_id , post_meta: post_meta, attachment_id: attachment_id }).done(function (response)
						{
							var get_notification = response.split('|');
							if ($.trim(get_notification[0]) == '1')
							{
								$('.loader-outer').hide();
								toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								location.reload(true);
							}
							else
							{
								$('.loader-outer').hide();
								toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							}
							
						});
					}
				},
				cancel: {
					text: localize_vars_frontend.cancel,
					action: function(){ }
				}
			}
		});
	});
	
	
	
	/*SAVE EMPLOYER PROFILE*/
	
	$('#employer_profile_btn').click(function(){
		var this_value = $(this);
		
		if( $('form#employer_form').smkValidate() ){
			this_value.find('div.bubbles').addClass("view");
			$("#employer_profile_btn").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'employer_profile', emp_data: $("form#employer_form").serialize(), post_id: post_id, security:$('#save_pro_nonce').val() }).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					 location.reload(true);
					}, 1000);

					
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#employer_profile_btn').attr("disabled", false);
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#employer_profile_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	
	/* CHANGE PASSWORD */
	
	$(document).on('click', '#change_password_btn', function (){
		if( $('form#change_pass_form').smkValidate() ){
			$('.loader-outer').show();
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_change_password', pass_data: $("form#change_pass_form").serialize(), security:$('#change_psw_nonce').val()  }).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					$('.loader-outer').hide();
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  location.reload(true);
					}, 1000);
				}
				else
				{
					$('.loader-outer').hide();
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	
	/* DELETE ACCOUNT */
	
	$(document).on('click', '#delete_account', function (){
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.AccDel,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_delete_account', security:$('#delete_pro_nonce').val() }).done(function (response)
							{
								var get_notification = response.split('|');
								if ($.trim(get_notification[0]) == '1')
								{
									$('.loader-outer').hide();
									toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
									  window.location = get_notification[2];
									}, 1000);
								}
								else
								{
									$('.loader-outer').hide();
									toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								}
								
							}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });

					}
				},
				cancel: {
					text: localize_vars_frontend.cancel,
					action: function(){ }
				}
			}
		});
	});

	
	/* UPLOAD PROJECT ATTACHMENTS */
	$(document).on('change', '#project_attachments', function () {
			 $('.myprogress').css('width', '0');
			var fd = new FormData();
			var files_data = $('#project_attachments');
			
			var name = $('#project_attachments').attr("name");
			var pid = $(this).attr('data-post-id');
			$.each($(files_data), function (i, obj) {
				$.each(obj.files, function (j, file) {
					fd.append('project_attachments[' + j + ']', file);
				});
			});
			$.each( files_data[0]['files'], function( key, value) {
			  var kb = value["size"]/1000;
			  var mb = kb/1000;
			  $('.attachment-box').show();
			  $(".attachment-box").append('<div class="attachments temp-atatchment"><i class="fad fa-spinner fa-spin"></i> <span class="attachment-data"> <h4> '+value["name"]+'</h4> <p>'+value["size"]+' Bytes</p>  </span></div>');
			});
			fd.append('action', 'project_attachments');

			fd.append('post-id', pid);
			fd.append('field-name', name);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.ajax({
				type: 'POST',
				url: freelanceAjaxURL,
				data: fd,
				contentType: false,
				processData: false,
				success: function (res) {
					$('.loader-outer').hide();
					var res_arr = res.split("|");
					if ($.trim(res_arr[0]) == "1")
					{
						$('.temp-atatchment').hide();
						$(".attachment-box").append(res_arr[2]);
						$(".project_attachment_ids").val(res_arr[3]);
					}
					else
					{
						$('.temp-atatchment').hide();
						toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						$('.temp-atatchment').hide();
						$(".attachment-box").append(res_arr[2]);
					}
	
				}
			});
		});
		
	/*DELETE PROJECT ATTACHMENTS*/	
	$(document).on('click', '.btn-pro-clsoe-icon', function () {
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.AccDel,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var attach_id = this_value.attr('data-id');
						var pid = this_value.attr('data-pid');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'delete_project_attachment', attach_id:attach_id, pid:pid }).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									
									var deleted_id = '.pro-atta-'+attach_id;
									
									$(deleted_id).hide();
									
									$(".project_attachment_ids").val(response.data.newData);
									//toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
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
					text: localize_vars_frontend.cancel,
					action: function(){ }
				}
			}
		});
	});
		
	$('#create_project_btn').click(function(){
		if( $('form#project_form').smkValidate() ){
			$('.loader-outer').show();
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'create_project', project_data: $("form#project_form").serialize(), post_id: post_id, security:$('#create_project_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  window.location.replace(response.data.pid);
					}, 1000);
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
	});
	
	
	/*SIMPLE JUST CANCEL PROJECT*/
	$(document).on('click', '.cancel_project', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var pid = this_value.attr('data-pid');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_simple_cancel_project', security:$('#gen_nonce').val(), pid:pid }).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									window.location = response.data.page;
								}
								else
								{
									$('.loader-outer').hide();
									toastr.error(response.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								}
								
							}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });

					}
				},
				cancel: {
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});

	
	/*ADD OR REMOVE SKILLS*/
	$(document).on('click', '.add_new_skills',function(e) {
			  e.preventDefault(); 
			  $('.fa-plus').hide();
			  $('.add_new_skills').attr("disabled", "disabled").button('refresh');
			  $(".add_new_skills").prepend("<i class='fas fa-circle-notch fast-spin'></i>");
			  var tax_name = $(this).attr("data-taxonomy-name");
				var wrapper = $('.skills_wrapper'); 
				var freelanceAjaxURL = $("#freelance_ajax_url").val();
			  $.ajax({
				 type : "post",
				 url : freelanceAjaxURL,
				 data : {action: "get_my_skills_terms", tax_name : tax_name},
				 success: function(response) {
					if(response) {
					   $(wrapper).append(response);
					   $('.general_select').select2();
					   $('.fa-circle-notch').remove();
					   $('.fa-plus').show();
					   $('.add_new_skills').removeAttr("disabled").button('refresh');
					}
				 }
			  });
			});
	/* REMOVE SKILLS */
	var wrapper = $('.skills_wrapper'); 
	$(wrapper).on('click', '.remove_button', function(e){
			var this_value = $(this);
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.AccDel,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							e.preventDefault();
							this_value.parent('div').remove();
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		});
	
	
	/* AWARDS AJAX WORK ADD/REMOVE */
			
	$(document).on('click', '.add_new_award',function(e) {
	  e.preventDefault(); 

		var wrapper = $('.award_wrapper');
		var pid = $(this).attr('data-post-id');
		
		var awardsCountFirst = $('.award_wrapper .ui-state-default').length;
		var awardsCount = awardsCountFirst+1;

		var fieldHTML = '<div class="ui-state-default" id="award_'+awardsCount+'"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-5"><input type="text" name="award_name[]" value="" placeholder="'+localize_vars_frontend.awardName+'" class="form-control"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-4"><input type="text" class="datetimepicker form-control" name="award_date[]" placeholder="'+localize_vars_frontend.awardDate+'" autocomplete="off"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-3"><button type="button" class="btn btn-theme award_img_btn">'+localize_vars_frontend.selectImage+'</button><input type="file" id="img_upload_id_'+awardsCount+'" name="img_upload_id_'+awardsCount+'" accept = "image/*" class="award_img_btn"  data-no-off-file-id="award_img_id_'+awardsCount+'" data-post-id="'+pid+'" data-active_id="'+awardsCount+'"/></div></div><div class="form-row"><div class="form-group col-md-12"><input type="hidden" class="award_img_id_'+awardsCount+'" name="award_img_id[]" value=""><div class="award_banner_gallery_'+awardsCount+' sort_imgs"></div></div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>'; 
		
		
		$(wrapper).append(fieldHTML);
		$('html, body').animate({
			scrollTop: $("#award_"+awardsCount).offset().top
		}, 2000);
		$('.datetimepicker').datetimepicker({
			timepicker:false,
			format:'d/m/Y',
			lazyInit:true,
		});
		
	});	
		
		
		$(document).on('change', '.award_img_btn', function (e){
			e.preventDefault();
			
				var this_value = $(this);
				var CountFileNo = this_value.attr("data-no-off-file-id");
				var activeID = this_value.attr("data-active_id");
				
			 $('.loader-outer').show();
			var fd = new FormData();
			var files_data = $('#img_upload_id_'+activeID+'');

			var name = this_value.attr("name");
			var pid = $(this).attr('data-post-id');
			$.each($(files_data), function (i, obj) {
				$.each(obj.files, function (j, file) {
					fd.append('img_upload_id_'+activeID+'[' + j + ']', file);
				});
			});
			fd.append('action', 'upload_img_return_id');
			//$(this).attr('data-post-id')
			//fd.append('data-post-id')
			fd.append('post-id', pid);
			fd.append('field-name', name);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			
			$.ajax({
				type: 'POST',
				url: freelanceAjaxURL,
				data: fd,
				contentType: false,
				processData: false,
				success: function (res) {
					$('.loader-outer').hide();
					var res_arr = res.split("|");
					if ($.trim(res_arr[0]) == "1")
					{
						toastr.success(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						$('.fa-spinner-third').remove();
						$("."+CountFileNo).val(res_arr[3]);
						//$('#store-image').css("background-image", "url(" + res_arr[1] + ")");
						$(".award_banner_gallery_"+activeID).html('<a href="'+res_arr[2]+'" target="_blank"><img src="'+res_arr[2]+'" class="img-fluid" ></a>');
					}
					else
					{
						toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					}
	
				}
			});
		});
	
	var awardCount = $('.award_wrapper .ui-state-default').length;
	var awardCount = awardCount+1;
	var i;
	for (i = 1; i < awardCount; i++) { 
		$('.edu_start_date_'+i).datetimepicker({
		  format:'Y/m/d',
		  onSelectDate:function(ct,$i){
			  var eduCount2 = jQuery('.edu_wrapper .ui-state-default').length;
				var eduCount2 = eduCount2+1;
				var j;
				for (j = 1; j < eduCount2; j++) { 
					jQuery('.edu_end_date_'+j).datetimepicker({
						minDate:jQuery('.edu_start_date_'+j).val(),
						timepicker:false, 
					});
				}
			},
		  timepicker:false
		 });
		 $('.edu_end_date_'+i).datetimepicker({
		  format:'Y/m/d',
		  minDate:jQuery('.edu_start_date_'+i).val(),
		  timepicker:false
		 });
		$('.datetimepicker').datetimepicker({
			timepicker:false,
			format:'d/m/Y',
			lazyInit:true,
		}); 
	}
  
	/* REMOVE AWARD */
	var awardWrapper = $('.award_wrapper'); 
		$(awardWrapper).on('click', '.remove_button', function(e){
			var this_value = $(this);
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.AccDel,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							e.preventDefault();
							this_value.parent('div').remove(); //Remove field html
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		});

	
	
	/* PROJECT AJAX WORK ADD/REMOVE */
			
	$(document).on('click', '.add_new_project',function(e) {
	  e.preventDefault(); 

		var projectWrapper = $('.project_wrapper');
		var pid = $(this).attr('data-post-id');
		
		var projetCountFirst = $('.project_wrapper .ui-state-default').length;
		var projectCount = projetCountFirst+1;

		var fieldHTML = '<div class="ui-state-default" id="project_'+projectCount+'"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-5"><input type="text" name="project_name[]" value="" placeholder="'+localize_vars_frontend.projectName+'" class="form-control"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-4"><input type="text" class="form-control" name="project_url[]" placeholder="'+localize_vars_frontend.projectURL+'" autocomplete="off"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-3"><button type="button" class="btn btn-theme project_img_btn">'+localize_vars_frontend.selectImage+'</button><input type="file" id="project_img_upload_id_'+projectCount+'" name="project_img_upload_id_'+projectCount+'" accept = "image/*" class="project_img_btn" data-project-no-off-file-id="project_img_id_'+projectCount+'" data-post-id="'+pid+'" data-project-active-id="'+projectCount+'"/></div></div><div class="form-row"><div class="form-group col-md-12"><input type="hidden" class="project_img_id_'+projectCount+'" name="project_img_id[]" value=""><div class="project_banner_gallery_'+projectCount+' sort_imgs"></div></div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>'; 
		
		$(projectWrapper).append(fieldHTML);		

		$('html, body').animate({
			scrollTop: $("#project_"+projectCount).offset().top
		}, 2000);
	});	
		
		
	$(document).on('change', '.project_img_btn', function (e){
		e.preventDefault();
		
			var this_value = $(this);
			var ProjectCountFileNo = this_value.attr("data-project-no-off-file-id");
			var activeID = this_value.attr("data-project-active-id");
		 $('.loader-outer').show();
		var fd = new FormData();
		var files_data = $('#project_img_upload_id_'+activeID+'');

		var name = this_value.attr("name");
		var pid = $(this).attr('data-post-id');
		$.each($(files_data), function (i, obj) {
			$.each(obj.files, function (j, file) {
				fd.append('project_img_upload_id_'+activeID+'[' + j + ']', file);
			});
		});
		fd.append('action', 'upload_img_return_id');

		fd.append('post-id', pid);
		fd.append('field-name', name);
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		
		$.ajax({
			type: 'POST',
			url: freelanceAjaxURL,
			data: fd,
			contentType: false,
			processData: false,
			success: function (res) {
				$('.loader-outer').hide();
				var res_arr = res.split("|");
				if ($.trim(res_arr[0]) == "1")
				{
					toastr.success(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('.fa-spinner-third').remove();
					$("."+ProjectCountFileNo).val(res_arr[3]);
					
					$(".project_banner_gallery_"+activeID).html('<a href="'+res_arr[2]+'" target="_blank"><img src="'+res_arr[2]+'" class="img-fluid" ></a>');
				}
				else
				{
					toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			}
		});
	});
	
	
  
	/* REMOVE PROJECT */
	var projectWrapper = $('.project_wrapper'); 
	$(projectWrapper).on('click', '.remove_button', function(e){
			var this_value = $(this);
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.AccDel,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							e.preventDefault();
							this_value.parent('div').remove();
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		});

	


	/* EXPERIENCE AJAX WORK ADD/REMOVE */
			
	$(document).on('click', '.add_new_expe', function (e) {
	  e.preventDefault(); 
	var expWrapper = $('.expe_wrapper');
	var expeCountFirst = $('.expe_wrapper .ui-state-default').length;
	expeCount = expeCountFirst+1;

	var fieldHTML = '<div class="ui-state-default" id="expe_'+expeCount+'"><i class="far fa-arrows"></i><span class="count">'+expeCount+'</span><div class="form-row"><div class="form-group col-md-6"><label>'+localize_vars_frontend.expeName+'</label><input type="text" name="expe_name[]"  class="form-control"></div><div class="form-group col-md-6"><label>'+localize_vars_frontend.expeCompName+'</label> <input type="text"  class="form-control" name="expe_company_name[]"></div></div><div class="form-row"> <div class="form-group col-md-6"> <label>'+localize_vars_frontend.startDate+'</label><input type="text" name="expe_start_date[]" class="expe_start_date_'+expeCount+' form-control" autocomplete="off"></div> <div class="form-group col-md-6"><label>'+localize_vars_frontend.endDate+'</label> <input type="text" name="expe_end_date[]" class="expe_end_date_'+expeCount+' form-control" autocomplete="off"><p>'+localize_vars_frontend.endDatemsg+'</p></div></div><div class="form-row"><div class="form-group col-md-12"><label>'+localize_vars_frontend.expeDesc+'</label><textarea name="expe_details[]" class="form-control"></textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
	
	$(expWrapper).append(fieldHTML);
	
		$('html, body').animate({
			scrollTop: $("#expe_"+expeCount).offset().top
		}, 2000);
	$(function(){
	 $('.expe_start_date_'+expeCount).datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
		maxDate:$('.expe_end_date_'+expeCount).val()?$('.expe_end_date_'+expeCount).val():false
	   })
	  },
	  timepicker:false
	 });
	 $('.expe_end_date_'+expeCount).datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
		minDate:$('.expe_start_date_'+expeCount).val()?$('.expe_start_date_'+expeCount).val():false
	   })
	  },
	  timepicker:false
	 });
	});
	
});

	/* REMOVE EXPERIENCE */
	var expWrapper = $('.expe_wrapper'); 
	$(expWrapper).on('click', '.remove_button', function(e){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.AccDel,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						e.preventDefault();
						this_value.parent('div').remove();
					}
				},
				cancel: {
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});
	
	
	
	  
	  var expeCount = $('.expe_wrapper .ui-state-default').length;
		var expeCount = expeCount+1;
		var i;
		for (i = 1; i < expeCount; i++) { 
			$('.expe_start_date_'+i).datetimepicker({
			  format:'Y/m/d',
			  onSelectDate:function(ct,$i){
				  var expeCount2 = jQuery('.expe_wrapper .ui-state-default').length;
					var expeCount2 = expeCount2+1;
					for (j = 1; j < expeCount2; j++) { 
						jQuery('.expe_end_date_'+j).datetimepicker({
							minDate:jQuery('.expe_start_date_'+j).val(),
							timepicker:false, 
						});
					}
				},
			  timepicker:false
			 });
			 $('.expe_end_date_'+i).datetimepicker({
			  format:'Y/m/d',
			  minDate:$('.expe_start_date_'+i).val(),
			  timepicker:false
			 });
			 
		}




	/* EDUCATION ADD/REMOVE */
	$(document).on('click', '.add_new_edu', function (e) {
		
		e.preventDefault(); 
		var eduWrapper = $('.edu_wrapper');
		var eduCountFirst = $('.edu_wrapper .ui-state-default').length;
		eduCount = eduCountFirst+1;
		
		var fieldHTML = '<div class="ui-state-default" id="edu_'+eduCount+'"><i class="far fa-arrows"></i><span class="count">'+eduCount+'</span>	<div class="form-row"><div class="form-group col-md-6"><label>'+localize_vars_frontend.eduName+'</label><input type="text" name="edu_name[]" class="form-control"></div><div class="form-group col-md-6"><label>'+localize_vars_frontend.eduInstName+'</label> <input type="text" class="form-control" name="edu_inst_name[]"></div></div><div class="form-row"> <div class="form-group col-md-6"> <label>'+localize_vars_frontend.startDate+'</label><input type="text" name="edu_start_date[]" class="edu_start_date_'+eduCount+' form-control" autocomplete="off"></div> <div class="form-group col-md-6"><label>'+localize_vars_frontend.endDate+'</label> <input type="text" name="edu_end_date[]" class="edu_end_date_'+eduCount+' form-control" autocomplete="off"><p>'+localize_vars_frontend.eduEndDatemsg+'</p></div></div><div class="form-row"><div class="form-group col-md-12"><label>'+localize_vars_frontend.expeDesc+'</label><textarea name="edu_details[]" class="form-control"></textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
		
		$(eduWrapper).append(fieldHTML);
		$('html, body').animate({
			scrollTop: $("#edu_"+eduCount).offset().top
		}, 2000);
		
		$(function(){
		 $('.edu_start_date_'+eduCount).datetimepicker({
		  format:'Y/m/d',
		  onShow:function( ct ){
		   this.setOptions({
			maxDate:$('.edu_end_date_'+eduCount).val()?$('.edu_end_date_'+eduCount).val():false
		   })
		  },
		  timepicker:false
		 });
		 $('.edu_end_date_'+eduCount).datetimepicker({
		  format:'Y/m/d',
		  onShow:function( ct ){
		   this.setOptions({
			minDate:$('.edu_start_date_'+eduCount).val()?$('.edu_start_date_'+eduCount).val():false
		   })
		  },
		  timepicker:false
		 });
		});
	
	});
	
	/* REMOVE EDUCATION */
	var eduWrapper = $('.edu_wrapper'); 
	$(eduWrapper).on('click', '.remove_button', function(e){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.AccDel,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						e.preventDefault();
						this_value.parent('div').remove(); //Remove field html
					}
				},
				cancel: {
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});
	
	
	
	  
	var eduCount = $('.edu_wrapper .ui-state-default').length;
	var eduCount = eduCount+1;
	var i;
	for (i = 1; i < eduCount; i++) { 
		$('.edu_start_date_'+i).datetimepicker({
		  format:'Y/m/d',
		  onSelectDate:function(ct,$i){
			  var eduCount2 = jQuery('.edu_wrapper .ui-state-default').length;
				var eduCount2 = eduCount2+1;
				var j;
				for (j = 1; j < eduCount2; j++) { 
					jQuery('.edu_end_date_'+j).datetimepicker({
						minDate:jQuery('.edu_start_date_'+j).val(),
						timepicker:false, 
					});
				}
			},
		  timepicker:false
		 });
		 $('.edu_end_date_'+i).datetimepicker({
		  format:'Y/m/d',
		  minDate:jQuery('.edu_start_date_'+i).val(),
		  timepicker:false
		 });
		 
	}				




	/*SAVE FEELANCER PROFILE PROFILE*/
	
	$('#fl_profile_btn').click(function(){
		if( $('form#freelancer_form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$("#fl_profile_btn").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_profile_save', fl_data: $("form#freelancer_form").serialize(), post_id: post_id, security:$('#save_pro_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  location.reload(true);
					}, 1000);
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#fl_profile_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#fl_profile_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	
	$('#fl_addon_btn').click(function(){
		if( $('form#addon_form').smkValidate() ){
			$('.loader-outer').show();
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_addon_save', fl_data: $("form#addon_form").serialize(), post_id: post_id, security:$('#save_pro_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$('.loader-outer').hide();
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  window.location.replace(response.data.pid);
					}, 1000);
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
	});
	
	
	
	/*DELETE ADDON*/
	
	$(document).on('click', '.remove_addon', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var pid = this_value.attr('data-pid');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_remove_addon', security:$('#gen_nonce').val(), pid:pid}).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
									 location.reload(true);
									}, 1000);
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
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});
	
	
		/*DELETE PROJECT ATTACHMENTS*/	
	$(document).on('click', '.btn_delete_services_attachment', function () {
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.AccDel,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var attach_id = this_value.attr('data-id');
						var sid = this_value.attr('data-sid');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'delete_service_attachment', attach_id:attach_id, sid:sid }).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									
									var deleted_id = '.pro-atta-'+attach_id;
									
									$(deleted_id).hide();
									$(".services_attachment_ids").val(response.data.returned_ids);
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
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
					text: localize_vars_frontend.cancel,
					action: function(){ }
				}
			}
		});
	});

	
	
	
	/* UPLOAD SERVICES ATTACHMENTS */
	$(document).on('change', '#services_attachments', function () {
			 $('.myprogress').css('width', '0');
			var fd = new FormData();
			var files_data = $('#services_attachments');
			
			var name = $('#services_attachments').attr("name");
			var pid = $(this).attr('data-post-id');
			$.each($(files_data), function (i, obj) {
				$.each(obj.files, function (j, file) {
					fd.append('services_attachments[' + j + ']', file);
				});
			});
			$.each( files_data[0]['files'], function( key, value) {
			  var kb = value["size"]/1000;
			  var mb = kb/1000;
			  $('.attachment-box').show();
			  $(".attachment-box").append('<div class="attachments temp-atatchment"><i class="fad fa-spinner fa-spin"></i> <span class="attachment-data"> <h4> '+value["name"]+'</h4> <p>'+kb+' KB</p>  </span></div>');
			});
			fd.append('action', 'services_attachments');

			fd.append('post-id', pid);
			fd.append('field-name', name);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.ajax({
				type: 'POST',
				url: freelanceAjaxURL,
				data: fd,
				contentType: false,
				processData: false,
				success: function (res) {
					$('.loader-outer').hide();
					var res_arr = res.split("|");
					if ($.trim(res_arr[0]) == "1")
					{
						$('.temp-atatchment').hide();
						$(".attachment-box").append(res_arr[2]);
						$(".services_attachment_ids").val(res_arr[3]);
					}
					else
					{
						$('.temp-atatchment').hide();
						toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						$('.temp-atatchment').hide();
						$(".attachment-box").append(res_arr[2]);
						//$(".services_attachment_ids").val(res_arr[3]);
					}
	
				}
			});
		});
	
	
	
	/*SAVE SERVICES*/
	
	$('#fl_services_btn').click(function(){
		if( $('form#services_form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			$("#fl_services_btn").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_service_save', fl_data: $("form#services_form").serialize(), post_id: post_id, security:$('#save_service_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('div.bubbles').removeClass("view");

					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  window.location.replace(response.data.pid);
					}, 1000);
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$("#fl_services_btn").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$("#fl_services_btn").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	$(document).ready(function(){
				var maxField = localize_vars_frontend.maxVideoAllowed;
				var addButton = $('.add_youtube_more'); 
				var wrapper = $('.youtube_field_wrapper');
				var video_fields_Lenghth = $( ".youtube_field_wrapper .ui-sortable-handle" ).length;
				var fieldHTML = '<div class="ui-state-default"><i class="fas fa-arrows-alt"></i><div class="form-row"><input type="url" name="video_urls[]" value="" class="form-control"/></div><a href="javascript:void(0);" class="yt_url_remove"><i class="fas fa-times"></i></a></div>'; 
				var x = 1; 
				if(video_fields_Lenghth > 0)
				{
					var x = video_fields_Lenghth+1;		
				}
				else
				{
					var x = 1;
				}
				//$(addButton).click(function(){
					$(document).on('click', '.add_youtube_more', function (){

					if(x <= maxField){ 
						x++; 
						$(wrapper).append(fieldHTML);
					}
					else
					{
						//alert(exertio_localize_vars.maxAllowedFields);
						toastr.error(localize_vars_frontend.maxAllowedFields, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					}
				});
				
				$(wrapper).on('click', '.yt_url_remove', function (){
					var this_value = $(this);
					$.confirm({
						title: localize_vars_frontend.Msgconfirm,
						content: localize_vars_frontend.AreYouSure,
						type: 'green',
						theme: 'light',
						icon: 'mdi mdi-alert-outline ',
						buttons: {   
							ok: {
								text: localize_vars_frontend.confimYes,
								btnClass: 'btn-primary',
								keys: ['enter'],
								action: function(){
									this_value.parent('div').remove();
									x--;
								}
							},
							cancel: {
								text: localize_vars_frontend.confimNo,
								action: function(){ }
							}
						}
					});
				});
			});
			
			
			
	/*CANCEL SERVICES*/
	$(document).on('click', '.cancel_service', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var pid = this_value.attr('data-pid');
						var status = this_value.attr('data-status');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_cancel_service', security:$('#gen_nonce').val(), pid:pid, status:status }).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
										location.reload(true);
									}, 600);
								}
								else
								{
									$('.loader-outer').hide();
									toastr.error(response.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								}
								
							}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });

					}
				},
				cancel: {
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});
	
	/*COVER LETTER TOGGLE*/
	$(document).on('click', '.cover-letter', function (){
		var pid = $(this).attr('data-prpl-id');
		$(".showhide_"+pid).slideToggle( "slow");
	});
	
	
	/*ASSIGN PROJECT TO FREELANCER*/
	
	$(document).on('click', '#assign_project', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						this_value.find('div.bubbles').addClass("view");
						$("#assign_project").attr("disabled", true);
						var pid = this_value.attr('data-pid');
						var fl_id = this_value.attr('data-fl-id');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_assign_project', security:$('#gen_nonce').val(), pid:pid, fl_id:fl_id }).done(function (response)
							{
								if ( true === response.success ) 
								{
									this_value.find('div.bubbles').removeClass("view");
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									window.location = response.data.page;
								}
								else
								{
									this_value.find('div.bubbles').removeClass("view");
									$("#assign_project").attr("disabled", false);
									toastr.error(response.data.message, '', {timeOut: 15000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								}
								
							}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$("#assign_project").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 15000, "closeButton": true, "positionClass": "toast-top-right"});
					   });

					}
				},
				cancel: {
					text: localize_vars_frontend.confimNo,
					keys: ['esc'],
					action: function(){ }
				}
			}
		});
	});
	
	
	/*ON CHNAGE PRICE TYPE FIXED OR HOURLY*/
	
	$(document).on('change', '.project-type', function() {
		if(this.value == '2')
		{
			$(".hourly-field").show();
			
			$(".fixed-field").hide();
			$(".fixed-field input").attr("disabled","disabled");
			$(".hourly-field  input").removeAttr("disabled");
		}
		else if(this.value == '1')
		{
			$(".fixed-field").show();
			$(".hourly-field").hide();
			
			$(".hourly-field input").attr("disabled","disabled");
			$(".fixed-field input").removeAttr("disabled");
		}
	  
	});
	
	
	
	$(document).on('click', '#history_msg_btn', function (){
		if( $('form#send_himstory_msg').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#history_msg_btn").attr("disabled", true);
			
			var post_id = $(this).attr('data-post-id');
			var fl_id = $(this).attr('data-fl-id');
			var msg_author = $(this).attr('data-msg-author');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_history_msg', fl_data: $("form#send_himstory_msg").serialize(), msg_author: msg_author, post_id: post_id, fl_id: fl_id, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#history_msg_btn').attr("disabled", false);
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  location.reload(true);
					}, 1000);
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#history_msg_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#history_msg_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});

/*GENERAL FILE UPLOADER*/

	$(document).on('change', '#gen_attachment_uploader', function () {
			 //$('.loader-outer').show();
			 $('.myprogress').css('width', '0');
			var fd = new FormData();
			var files_data = $('#gen_attachment_uploader');
			
			var name = $('#gen_attachment_uploader').attr("name");
			var pid = $(this).attr('data-post-id');
			$.each($(files_data), function (i, obj) {
				$.each(obj.files, function (j, file) {
					fd.append('gen_attachment_uploader[' + j + ']', file);
				});
			});
			//console.log(files_data[0]['files']);
			$.each( files_data[0]['files'], function( key, value) {
			  //console.log( value['name'] );
			  var kb = value["size"]/1000;
			  var mb = kb/1000;
			  $('.attachment-box').show();
			  $(".attachment-box").append('<div class="attachments temp-atatchment"><i class="fad fa-spinner fa-spin"></i> <span class="attachment-data"> <h4> '+value["name"]+'</h4> <p>'+value["size"]+' Bytes</p>  </span></div>');
			});
			fd.append('action', 'gen_atatchment_uploader');
			//$(this).attr('data-post-id')
			//fd.append('data-post-id')
			fd.append('post-id', pid);
			fd.append('field-name', name);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.ajax({
				type: 'POST',
				url: freelanceAjaxURL,
				data: fd,
				contentType: false,
				processData: false,
				success: function (res) {
					$('.loader-outer').hide();
					var res_arr = res.split("|");
					if ($.trim(res_arr[0]) == "1")
					{
						
						//alert(res_arr[1]);
						toastr.success(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						$('.temp-atatchment').hide();
						$(".attachment-box").append(res_arr[2]);
						var ex_values = $("#history_attachments_ids").val();
						if(ex_values != '')
						{
							var new_val = ex_values+','+res_arr[3];
							$("#history_attachments_ids").val(new_val);
						}
						else
						{
							$("#history_attachments_ids").val(res_arr[3]);
						}
					}
					else
					{
						$('.temp-atatchment').hide();
						toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						$('.temp-atatchment').hide();
						$(".attachment-box").append(res_arr[2]);
					}
	
				}
			});
		});

	/*DELETE GENERAL ATTACHMENTS*/	
	$(document).on('click', '.general-delete', function () {
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.AccDel,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var attach_id = this_value.attr('data-id');
						var pid = this_value.attr('data-pid');
						var ex_values = $("#history_attachments_ids").val();
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'delete_gen_atatchment', attach_id:attach_id, pid:pid, ex_values:ex_values }).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									
									var deleted_id = '.pro-atta-'+attach_id;
									
									$(deleted_id).hide();
									$("#history_attachments_ids").val(response.data.ids);
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
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
					text: localize_vars_frontend.cancel,
					action: function(){ }
				}
			}
		});
	});



	$(document).on('click', '.history_attch_dwld', function (){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$(".history_attch_dwld").attr("disabled", true);
			
			var msg_id = $(this).attr('data-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'history_msg_atatchment_download', msg_id: msg_id, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					
					toastr.success(response.data.message, '', {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  window.location = response.data.attachments;
						this_value.find('div.bubbles').removeClass("view");
					}, 4000);
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('.history_attch_dwld').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('.history_attch_dwld').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});
	
	$(document).on('click', '#project_status', function () {
		var this_value = $(this);
		var status = $(".prject_status").val();
		if(status == 'complete')
		{
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
								$('#review-modal').modal({ backdrop: 'static', keyboard: false });
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		}
		else if(status == 'cancel')
		{
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
								$('#review-modal-cancel').modal({ backdrop: 'static', keyboard: false });
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		}
	});
	$(".stars-1").rating({
	  "click": function (e) {
		var stars = e.stars;
		$("#stars-1").val(stars);
	  }

	});
	$(".stars-2").rating({
	  "click": function (e) {
		var stars = e.stars;
		$("#stars-2").val(stars);
	  }

	});
	$(".stars-3").rating({
	  "click": function (e) {
		var stars = e.stars;
		$("#stars-3").val(stars);
	  }

	});
	
	
	$(document).on('click', '#rating-btn', function () {
		if( $('form#rating-form').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#rating-btn").attr("disabled", true);
			var post_id = $(this).attr('data-pid');
			var status = $(this).attr('data-status');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_project_status_rating', rating_data: $("form#rating-form").serialize(), post_id: post_id,status: status, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.page;
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#rating-btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#rating-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	$(".reward_box").hide();
	$(document).on('click', '#reward_tip_checkbox', function () {
		if($(this).is(":checked")) {
			$(".reward_box").show(300);
		} else {
			$(".reward_box").hide(200);
		}
	});
	
	$(document).on('click', '#cancel-btn', function () {
		if( $('form#review-modal-cancel').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#rating-btn").attr("disabled", true);
			var post_id = $(this).attr('data-pid');
			var status = $(this).attr('data-status');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_project_status_rating', rating_data: $("form#review-modal-cancel").serialize(), post_id: post_id,status: status, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#rating-btn').attr("disabled", false);
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.page;
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#rating-btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#rating-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	/*SERVICE MESSAGE HISTORY*/
	$(document).on('click', '#service_history_msg_btn', function (){
		var this_value =$(this);
		if( $('form#send_service_msg').smkValidate() ){
			this_value.find('div.bubbles').addClass("view");
			$(this).attr("disabled", true);
			
			var post_id = $(this).attr('data-post-id');
			var sender_id = $(this).attr('data-sender-id');
			var receiver_id = $(this).attr('data-receiver-id');

		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_send_service_msg', fl_data: $("form#send_service_msg").serialize(), sender_id: sender_id, post_id: post_id, receiver_id: receiver_id, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  location.reload(true);
					}, 500);
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#service_history_msg_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#service_history_msg_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	/*SEVICES COMPLTE STATUS*/
	$(document).on('click', '#service_status', function () {
		var this_value = $(this);
		var status = $(".service_status").val();
		if(status == 'complete')
		{
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
								$('#review-service').modal({ backdrop: 'static', keyboard: false });
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		}
		else if(status == 'cancel')
		{
			$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
								$('#review-service-cancel').modal({ backdrop: 'static', keyboard: false });
						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
		}
	});
	
	
	/*SERVICE RATING */
	$(document).on('click', '#service_rating_btn', function () {
		if( $('form#service_rating_form').smkValidate() ){
			var this_value =$(this);
			this_value.find('div.bubbles').addClass("view");
			$("#service_rating_btn").attr("disabled", true);
			var ongoing_sid = $(this).attr('data-ongoing-sid');
			var service_sid = $(this).attr('data-service-sid');
			var status = $(this).attr('data-status');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_service_rating', rating_data: $("form#service_rating_form").serialize(), ongoing_sid: ongoing_sid,service_sid:service_sid, status: status, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.page;
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#service_rating_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#service_rating_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
	$(document).on('click', '#cancel-service-btn', function () {
		if( $('form#cancel-service-from').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#rating-btn").attr("disabled", true);
			var ongoing_sid = $(this).attr('data-ongoing-sid');
			var service_sid = $(this).attr('data-service-sid');
			var status = $(this).attr('data-status');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_service_rating', cancel_feedback: $("form#cancel-service-from").serialize(), ongoing_sid: ongoing_sid, service_sid:service_sid, status: status, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.page;
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#rating-btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#rating-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});


$(document).on('click', '.delete_followed_employer', function () {
	var this_value = $(this);
	$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							$('.loader-outer').show();
							var post_id = this_value.attr('data-post-id');
							$.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_delete_followed_employer', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
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
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
	});
	
$(document).on('click', '.delete_followed_freelancer', function () {
	var this_value = $(this);
	$.confirm({
				title: localize_vars_frontend.Msgconfirm,
				content: localize_vars_frontend.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars_frontend.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							this_value.find('div.bubbles').addClass("view");
							$(".delete_followed_freelancer").attr("disabled", true);
							var post_id = this_value.attr('data-post-id');
							$.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_delete_followed_freelancer', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
							{
								if ( true === response.success ) 
								{
									toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									this_value.find('div.bubbles').removeClass("view");
									setTimeout(function(){
										location.reload(true);
									}, 600);
								}
								else
								{
									toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									this_value.find('div.bubbles').removeClass("view");
									$('.delete_followed_freelancer').attr("disabled", false);
								}
								
							}).fail(function () {
										toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
										this_value.find('div.bubbles').removeClass("view");
										$('#service_rating_btn').attr("disabled", false);
									   });

						}
					},
					cancel: {
						text: localize_vars_frontend.confimNo,
						action: function(){ }
					}
				}
			});
	});

$(document).ready(function(){
				var faqMaxFields = localize_vars_frontend.maxFaqAllowed; 
				var faqWrapper = $('.faqs-wrapper');
				var faqsLenghth = $( ".faqs-box" ).length;
				if(faqsLenghth > 0)
				{
					var x = faqsLenghth+1;		
				}
				else
				{
					var x = 1;
				}
				
				
				$(document).on('click', '.add_faq_more', function (){

					if(x <= faqMaxFields){ 

						var faqFieldHTML = '<div class="faqs-box"><h4>'+localize_vars_frontend.faqNo+' '+x+'</h4><ul><li><i class="fas fa-arrows-alt"></i></li><li class="faq_more_remove"><i class="fas fa-times"></i></li></ul><div class="faqs-box-meta"><div class="form-group"><input type="text" name="faqs-title[]" value="" class="form-control"></div><div class="form-group"><textarea name="faq-answer[]" id="" class="form-control"></textarea></div></div></div>'; 
						$(faqWrapper).append(faqFieldHTML);
						x++;
					}
					else
					{
						//alert(localize_vars_frontend.maxFaqAllowed);
						toastr.error(localize_vars_frontend.maxAllowedFields, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
							
					}
				});
				
				//Once remove button is clicked
				$(faqWrapper).on('click', '.faq_more_remove', function (){
					var this_value = $(this);
					$.confirm({
						title: localize_vars_frontend.Msgconfirm,
						content: localize_vars_frontend.AreYouSure,
						type: 'green',
						theme: 'light',
						icon: 'mdi mdi-alert-outline ',
						buttons: {   
							ok: {
								text: localize_vars_frontend.confimYes,
								btnClass: 'btn-primary',
								keys: ['enter'],
								action: function(){
									//e.preventDefault();
									this_value.closest('div.faqs-box').remove(); //Remove field html
									x--; //Decrement field counter
								}
							},
							cancel: {
								text: localize_vars_frontend.confimNo,
								action: function(){ }
							}
						}
					});
				});
			});
			
			
$(document).on('click', '#deposit-funds-btn', function () {
		if( $('form#deposit-funds-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			$("#deposit-funds-btn").attr("disabled", true);
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_deposit_funds_callback', deposit_fund_data: $("form#deposit-funds-form").serialize(), security:$('#fl_deposit_funds_nonce').val() }).done(function (response)
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
					$("#deposit-funds-btn").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$("#deposit-funds-btn").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});	
	
	
	
	$(document).on('click', '#dispute-project-btn', function () {
		if( $('form#dispute-project-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			$("#dispute-project-btn").attr("disabled", true);
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_dispute_project_callback', dispute_project_data: $("form#dispute-project-form").serialize(), security:$('#fl_dispute_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					location.reload(true);
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$("#dispute-project-btn").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$("#dispute-project-btn").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
	
$(document).on('click', '#dispute_msg_btn', function (){
		if( $('form#send_himstory_msg').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#dispute_msg_btn").attr("disabled", true);
			
			var post_id = $(this).attr('data-post-id');

		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_dispute_msg', dispute_data: $("form#send_himstory_msg").serialize(), post_id: post_id, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  location.reload(true);
					}, 1000);
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#dispute_msg_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#dispute_msg_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});


	$(document).on('click', '#dispute-service-btn', function () {
		if( $('form#dispute-service-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			$("#dispute-service-btn").attr("disabled", true);
			$.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_dispute_service_callback', dispute_service_data: $("form#dispute-service-form").serialize(), security:$('#fl_dispute_nonce').val() }).done(function (response)
			{
				if ( true === response.success )
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					location.reload(true);
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$("#dispute-service-btn").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			}).fail(function () {
				this_value.find('div.bubbles').removeClass("view");
				$("#dispute-service-btn").attr("disabled", false);
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
			});
		}
	});
	$(document).on('click', '#dispute_service_msg_btn', function (){
		if( $('form#send_himstory_service_msg').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#dispute_service_msg_btn").attr("disabled", true);

			var post_id = $(this).attr('data-post-id');

			$.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_dispute_service_msg', dispute_service_data: $("form#send_himstory_service_msg").serialize(), post_id: post_id, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success )
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
						location.reload(true);
					}, 1000);
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#dispute_service_msg_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			}).fail(function () {
				$(".btn-loading .bubbles").removeClass("view");
				$('#dispute_service_msg_btn').attr("disabled", false);
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
			});
		}
	});
$(document).on('click', '#paypal_pm_btn', function (){
		if( $('form#paypal_pm_form').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#paypal_pm_btn").attr("disabled", true);
			var default_payout = $("#default_payout"). val();
			var payment_method = $(this).attr('data-peyment-method');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_save_payment_method', payment_method_data: $("form#paypal_pm_form").serialize(), payment_method: payment_method, default_payout: default_payout, security:$('#gen_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					  location.reload(true);
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#paypal_pm_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#paypal_pm_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});	
$(document).on('click', ' #payoneer_pm_btn', function (){
		if( $('form#payoneer_pm_form').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#payoneer_pm_btn").attr("disabled", true);
			var default_payout = $("#default_payout"). val();
			var payment_method = $(this).attr('data-peyment-method');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_save_payment_method', payment_method_data: $(" form#payoneer_pm_form").serialize(), payment_method: payment_method, default_payout: default_payout, security:$('#gen_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					  location.reload(true);
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#payoneer_pm_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#payoneer_pm_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
$(document).on('click', '#bank_pm_btn', function (){
		if( $('form#bank_pm_form').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#bank_pm_btn").attr("disabled", true);
			var default_payout = $("#default_payout"). val();
			var payment_method = $(this).attr('data-peyment-method');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_save_payment_method', payment_method_data: $("form#bank_pm_form").serialize(), payment_method: payment_method, default_payout: default_payout, security:$('#gen_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					$(".btn-loading .bubbles").removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					  location.reload(true);
				}
				else
				{
					$(".btn-loading .bubbles").removeClass("view");
					$('#bank_pm_btn').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$(".btn-loading .bubbles").removeClass("view");
						$('#bank_pm_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});

	if ($(".attachment-box").length > 0)
    {
        $(".attachment-box").sortable({
            stop: function (event, ui) {
                $('.project_attachment_ids').val('');
                var current_img = '';
                $(".attachment-box .ui-state-default img").each(function (index) {
                    current_img = current_img + $(this).attr('data-img-id') + ",";
                });
                $('.project_attachment_ids').val(current_img.replace(/,\s*$/, ""));
            }
        });
        $(".attachment-box").disableSelection();
    }
	
	if ($(".attachment-box-services").length > 0)
    {
        $(".attachment-box-services").sortable({
            stop: function (event, ui) {
                $('.services_attachment_ids').val('');
                var current_img = '';
                $(".attachment-box-services .ui-state-default img").each(function (index) {
                    current_img = current_img + $(this).attr('data-img-id') + ",";
                });
                $('.services_attachment_ids').val(current_img.replace(/,\s*$/, ""));
            }
        });
        $(".attachment-box-services").disableSelection();
    }
	
	$(document).on('click', '.register_email_again', function (){
		$('.loader-outer').show();
		$.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_resend_activation_email'}).done(function (response)
		{
			if ( true === response.success ) 
			{
				$('.loader-outer').hide();
				$('.register_email_again').remove();
				toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			}
			else
			{
				$('.loader-outer').hide();
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			}
		})
	});
	
	
	$(document).on('click', '#freelancer_setting_btn', function (){

		$(".btn-loading .bubbles").addClass("view");
		$("#paypal_pm_btn").attr("disabled", true);

		$.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_save_freelancer_settings', settings_data: $("form#freelancer-setting-form").serialize(), security:$('#gen_nonce').val()}).done(function (response)
		{
			if ( true === response.success ) 
			{
				$(".btn-loading .bubbles").removeClass("view");
				toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				  location.reload(true);
			}
			else
			{
				$(".btn-loading .bubbles").removeClass("view");
				$('#paypal_pm_btn, #bank_pm_btn, #payoneer_pm_btn').attr("disabled", false);
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			}

		}).fail(function () {
					$(".btn-loading .bubbles").removeClass("view");
					$('#paypal_pm_btn, #bank_pm_btn, #payoneer_pm_btn').attr("disabled", false);
					toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
				   });
	});
	
	$('#fl_verification_btn').click(function(){
		if( $('form#verification_form').smkValidate() ){
			$('.loader-outer').show();
			//var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_verification_save', fl_verification_data: $("form#verification_form").serialize(), security:$('#save_verification_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					//$('.loader-outer').hide();
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					setTimeout(function(){
					  window.location.replace(response.data.pid);
					}, 1000);
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
	});
	
	$(document).on('click', '#fl_revoke_verification', function (){
					var this_value = $(this);
					$.confirm({
						title: localize_vars_frontend.Msgconfirm,
						content: localize_vars_frontend.AreYouSure,
						type: 'green',
						theme: 'light',
						icon: 'mdi mdi-alert-outline ',
						buttons: {   
							ok: {
								text: localize_vars_frontend.confimYes,
								btnClass: 'btn-primary',
								keys: ['enter'],
								action: function(){
									$('.loader-outer').show();
									var freelanceAjaxURL = $("#freelance_ajax_url").val();

									$.post(freelanceAjaxURL, {action: 'fl_revoke_verification' }).done(function (response)
									{
										if ( true === response.success ) 
										{
											$('.loader-outer').hide();
											toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
											setTimeout(function(){
											  window.location.replace(response.data.pid);
											}, 1000);
										}
										else
										{
											$('.loader-outer').hide();
											toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
										}

									});
								}
							},
							cancel: {
								text: localize_vars_frontend.confimNo,
								action: function(){ }
							}
						}
					});
				});
	$(document).on('change', '.verification_doc_btn1', function (e){
			e.preventDefault();
			
				var this_value = $(this);
				
				
			 $('.loader-outer').show();
			var fd = new FormData();
			var files_data = $('#img_upload_id');

			var name = $(this).attr("name");
			var pid = this_value.attr('data-post-id');
			$.each($(files_data), function (i, obj) {
				$.each(obj.files, function (j, file) {
					fd.append('#img_upload_id[' + j + ']', file);
				});
			});
			fd.append('action', 'upload_img_return_id');
			//$(this).attr('data-post-id')
			//fd.append('data-post-id')
			fd.append('post-id', pid);
			fd.append('field-name', name);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.ajax({
				type: 'POST',
				url: freelanceAjaxURL,
				data: fd,
				contentType: false,
				processData: false,
				success: function (res) {
					$('.loader-outer').hide();
					var res_arr = res.split("|");
					if ($.trim(res_arr[0]) == "1")
					{
						toastr.success(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						//$('.fa-spinner-third').remove();
						$(".attachment_id").val(res_arr[3]);
						//$('#store-image').css("background-image", "url(" + res_arr[1] + ")");
						$(".banner-img-container").html('<a href="'+res_arr[2]+'" target="_blank"><img src="'+res_arr[2]+'" class="img-fluid" ></a>');
					}
					else
					{
						toastr.error(res_arr[1], '', {timeOut: 10000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					}
	
				}
			});
		});
	
	
	$(document).on('change', '#verification_img_upload1', function () {
		$('.loader-outer').show();
        var fd = new FormData();
        var files_data = $('#verification_img_upload');
		var name = $('#verification_img_upload').attr("name");
		var pid = $(this).attr('data-post-id');
		//var post_meta = $(this).attr('data-post-meta');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('verification_img_upload[' + j + ']', file);
            });
        });
		
        fd.append('action', 'fl_verification_save');

		fd.append('post-id', pid);
		//fd.append('post-meta', post_meta);
		fd.append('field-name', name);
		var freelanceAjaxURL = $("#freelance_ajax_url").val();;
		
        $.ajax({
            type: 'POST',
            url: freelanceAjaxURL,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.loader-outer').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1")
                {
					toastr.success(res_arr[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".attachment_id").val(res_arr[3]);
					$(".banner-img-container").html('<a href="'+res_arr[2]+'" target="_blank"><img src="'+res_arr[2]+'" class="img-fluid" ></a>');
                }
                else
                {
                    toastr.error(res_arr[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
                }

            }
        });
	});

	/*UPLOAD VERIFICATION DOC*/
	$(document).on('change', '#verification_doc', function () {
		$('.loader-outer').show();
        var fd = new FormData();
        var files_data = $('#verification_doc');
		var name = $('#verification_doc').attr("name");
		var pid = $(this).attr('data-post-id');
		var post_meta = $(this).attr('data-post-meta');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('verification_doc[' + j + ']', file);
            });
        });
		
        fd.append('action', 'verification_doc');

		fd.append('post-id', pid);
		fd.append('post-meta', post_meta);
		fd.append('field-name', name);
		var freelanceAjaxURL = $("#freelance_ajax_url").val();;
		
        $.ajax({
            type: 'POST',
            url: freelanceAjaxURL,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.loader-outer').hide();
                var res_arr = res.split("|");

                if ($.trim(res_arr[0]) == "1")
                {
					//toastr.success(res_arr[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".profile-img-container").html('<img src="'+res_arr[2]+'" class="img-fluid" >');
					$(".attachment_id").val(res_arr[3]);
                }
                else
                {
                    toastr.error(res_arr[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
                }

            }
        });
	});
	
	
	/*REMOVE PROPOSAL*/
	$(document).on('click', '.remove_proposal', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var pid = this_value.attr('data-pid');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_remove_proposal', security:$('#gen_nonce').val(), pid:pid }).done(function (response)
							{
								if ( true === response.success ) 
								{
									$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
										location.reload(true);
									}, 600);
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
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});
	
	/*EDIT PROPOSAL MODAL*/
	$(document).on('click', '.edit-proposal', function (){
		var this_value = $(this);

			this_value.find(".bubbles").addClass("view");
			$(".edit-proposal").attr("disabled", true);
			var pid = this_value.attr('data-pid');
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			  $.post(freelanceAjaxURL, {action: 'fl_edit_proposal_modal', security:$('#gen_nonce').val(), pid:pid }).done(function (response)
				{
					if ( true === response.success ) 
					{
						this_value.find(".bubbles").removeClass("view");
						$(".edit-proposal").attr("disabled", false);
						$(".my-proposal-modal").html(response.data.html);
						$('#edit-proposal').modal('show');

						$(document).on('keyup', '#bidding-price', function() {
							var total_amount = $('input#bidding-price').val();
							var percentage = localize_vars.proAdminCost;

						  var admin_charges = (total_amount/100)*percentage;
						  $("#service-price").html(admin_charges.toFixed(2));

						  var earning = total_amount-admin_charges;
						  $("#earning-price").html(earning.toFixed(2));
						});

						/*FOR TOTAL CODE MINTUS ADMIN COST FOR HOURLY*/
						$(document).on('keyup', '#bidding_price, #bid-hours', function() {
							var hourly_amount = $('input#bidding_price').val();
							var bid_hours = $('input#bid-hours').val();
							var total_amount = hourly_amount*bid_hours;
							var percentage = localize_vars.proAdminCost;
							var admin_charges = (total_amount/100)*percentage;
							$("#service-price").html(admin_charges.toFixed(2));

							var earning = total_amount-admin_charges;
							$("#earning-price").html(earning.toFixed(2));
						});
						$('.price-breakdown').on('click', function() {
							$(".price-section").toggle(350);
						});
					}
					else
					{
						this_value.find(".bubbles").removeClass("view");
						$(".edit-proposal").attr("disabled", false);
						toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					}

				}).fail(function () {
					this_value.find(".bubbles").removeClass("view");
					$(".edit-proposal").attr("disabled", false);
					toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
		   });

	});
	
	
	/*EDIT PROJECT BID*/
$(document.body).on('click', '#btn_edit_project_bid', function () {
		if( $('form#bid_form').smkValidate() ){
			var this_value = $(this);
			this_value.find(".bubbles").addClass("view");
			$("#btn_project_bid").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
		  $.post(freelanceAjaxURL, {action: 'fl_edit_proposal_done', bid_data: $("form#bid_form").serialize(), security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					setTimeout(function(){
						location.reload(true);
					}, 600);
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
	
	/*MILESTONE TOGGLE*/
	$(document).on('click', '.show-milestone-detail', function (){
		var pid = $(this).attr('data-ml-id');
		$(".mlhide-"+pid).slideToggle( "fast");
	});
	/*CREATE MILESTONE*/
$(document.body).on('click', '#create-milestone', function () {
		if( $('form#milestone-form').smkValidate() ){
			var this_value = $(this);
			this_value.find(".bubbles").addClass("view");
			$("#create-milestone").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
		  $.post(freelanceAjaxURL, {action: 'fl_create_milestone', milestone_data: $("form#milestone-form").serialize(), security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					setTimeout(function(){
						location.reload(true);
					}, 600);
				}
				else
				{
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					$('#create-milestone').attr("disabled", false);	
				}

			}).fail(function () {
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
						$(".btn-loading .bubbles").removeClass("view");
						$('#create-milestone').attr("disabled", false);	
					   });
		}

});
	
	
	
/*MILESTONE PAY*/
	$(document).on('click', '.milestone-paid', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars_frontend.Msgconfirm,
			content: localize_vars_frontend.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars_frontend.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var pid = this_value.attr('data-pid');
						var mid = this_value.attr('data-mid');
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_pay_milestone', security:$('#gen_nonce').val(), pid:pid, mid:mid }).done(function (response)
							{
								if ( true === response.success ) 
								{
									//$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
										location.reload(true);
									}, 600);
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
					text: localize_vars_frontend.confimNo,
					action: function(){ }
				}
			}
		});
	});
/*CREATE PAYOUT*/
$(document.body).on('click', '#create-payout-btn', function () {
		if( $('form#create_payout-form').smkValidate() ){
			var this_value = $(this);
			this_value.find(".bubbles").addClass("view");
			$("#create-payout-btn").attr("disabled", true);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
		  $.post(freelanceAjaxURL, {action: 'fl_create_payout_manually', manual_payout_data: $("form#create_payout-form").serialize(), security:$('#gen_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					setTimeout(function(){
						location.reload(true);
					}, 600);
				}
				else
				{
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					$('#create-payout-btn').attr("disabled", false);	
				}

			}).fail(function () {
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
						$(".btn-loading .bubbles").removeClass("view");
						$('#create-payout-btn').attr("disabled", false);	
					   });
		}

});
	/*SET USER TYPE AFTER SOCIAL MEDIA AND FOR OLD USERS BOTH*/
$(document.body).on('click', '#set-user-type', function () {
	if( $('form#user-selection-form').smkValidate() ){
		var this_value = $(this);
		this_value.find(".bubbles").addClass("view");
		$("#set-user-type").attr("disabled", true);
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
	  $.post(freelanceAjaxURL, {action: 'exertio_user_selection', user_selection_data: $("form#user-selection-form").serialize(),  security:$('#gen_nonce').val()}).done(function (response)
		{
			if ( true === response.success ) 
			{
				toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".btn-loading .bubbles").removeClass("view");
				setTimeout(function(){
					location.reload(true);
				}, 600);
			}
			else
			{
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".btn-loading .bubbles").removeClass("view");
				$('#set-user-type').attr("disabled", false);	
			}

		}).fail(function () {
					toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					$(".btn-loading .bubbles").removeClass("view");
					$('#set-user-type').attr("disabled", false);	
				   });
	}
});
/*SET USER TYPE FOR OLD USERS THAT WAS BOTH CONDITION*/
$(document.body).on('click', '#set-user-type-update', function () {
	if( $('form#user-selection-form-update').smkValidate() ){
		var this_value = $(this);
		this_value.find(".bubbles").addClass("view");
		$("#set-user-type-update").attr("disabled", true);
		var previous_user = $(this).attr('data-previous-user');
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
	  $.post(freelanceAjaxURL, {action: 'exertio_previous_user', user_selection_data: $("form#user-selection-form-update").serialize(), previous_user:previous_user, security:$('#gen_nonce').val()}).done(function (response)
		{
			if ( true === response.success ) 
			{
				toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".btn-loading .bubbles").removeClass("view");
				setTimeout(function(){
					location.reload(true);
				}, 600);
			}
			else
			{
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".btn-loading .bubbles").removeClass("view");
				$('#set-user-type-update').attr("disabled", false);	
			}

		}).fail(function () {
					toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					$(".btn-loading .bubbles").removeClass("view");
					$('#set-user-type-update').attr("disabled", false);	
				   });
	}
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
	
	
	
	
if ($( ".custom-range-slider" ).length > 0){$(".custom-range-slider").ionRangeSlider({skin: "round"});}
$('#exertio_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	$('.loader-outer').show();
	//fields
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL,{action : 'exertio_get_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		$('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "block");
			$('.additional-fields-container').html(response.data.fields);
			if ($( ".custom-fields-theme-selects" ).length > 0) {$('.custom-fields-theme-selects').select2({ width:'100%'});}
			if ($( ".custom-range-slider" ).length > 0){$(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "none");
		}
	});
 });
	
$('#exertio_services_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	$('.loader-outer').show();
	//fields
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL,{action : 'exertio_get_services_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		$('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "block");
			$('.additional-fields-container').html(response.data.fields);
			if ($( ".custom-fields-theme-selects" ).length > 0) {$('.custom-fields-theme-selects').select2({ width:'100%'});}
			if ($( ".custom-range-slider" ).length > 0){$(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "none");
		}
	});
 });
$('#exertio_freelancer_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	$('.loader-outer').show();
	//fields
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL,{action : 'exertio_get_freelancer_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		$('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "block");
			$('.additional-fields-container').html(response.data.fields);
			if ($( ".custom-fields-theme-selects" ).length > 0) {$('.custom-fields-theme-selects').select2({ width:'100%'});}
			if ($( ".custom-range-slider" ).length > 0){$(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "none");
		}
	});
 });
$('#exertio_employer_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	$('.loader-outer').show();
	//fields
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL,{action : 'exertio_get_employer_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		$('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "block");
			$('.additional-fields-container').html(response.data.fields);
			if ($( ".custom-fields-theme-selects" ).length > 0) {$('.custom-fields-theme-selects').select2({ width:'100%'});}
			if ($( ".custom-range-slider" ).length > 0){$(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			$('.loader-outer').hide();
			$('.additional-fields').css("display", "none");
		}
	});
 });
	$(document).on('click', '#deposit-funds-custom-btn', function () {
		if( $('form#deposit-funds-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			$("#deposit-funds-custom-btn").attr("disabled", true);
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'fl_deposit_custom_funds_callback', deposit_custom_fund_data: $("form#deposit-funds-form").serialize(), security:$('#fl_deposit_funds_nonce').val() }).done(function (response)
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
					$("#deposit-funds-custom-btn").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$("#deposit-funds-custom-btn").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});

})(jQuery);