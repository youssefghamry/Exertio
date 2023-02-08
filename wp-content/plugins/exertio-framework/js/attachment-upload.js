/*ON CHNAGE PRICE TYPE FIXED OR HOURLY*/
jQuery(document).on('change', '.project-type', function() {
//alert(this.value);
	if(this.value == '2')
	{
		jQuery(".hourly-field").show();
		jQuery(".fixed-field").hide();
	}
	else if(this.value == '1')
	{
		jQuery(".fixed-field").show();
		jQuery(".hourly-field").hide();
	}

});
	
	jQuery('.datetimepicker').datetimepicker({
		timepicker:false,
		format:'d/m/Y',
		lazyInit:true,
	});	

jQuery("#update_database").click( function(e) {
	e.preventDefault();

	jQuery(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
	jQuery(this).attr("disabled", true);
	jQuery.ajax({
		type : "post",
		//dataType : "json",
		url : exertio_localize_vars.ajaxurl,
		data : {action: "update_database_table"},
		success: function(response)
		{
			if(response)
			{
				//alert(response);
				location.reload();
			}
			else
			{
				alert("Something went wrong");
			}
		}
	});
});




var meta_gallery_frame_event;
	  jQuery('#attachment_btn').on('click', function(e){
                if (meta_gallery_frame_event) {
                        meta_gallery_frame_event.open();
                        return;
                }
                meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
                        title: exertio_localize_vars.selectAttachments,
                        button: { text:  exertio_localize_vars.attachmentAdd },
                        library: { type: ['image','application/pdf', 'doc', 'docx.'] },
						multiple: true,
						//dwt_listing_event_idz.button
                });
				meta_gallery_frame_event.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame_event.options.library ),
						multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray_events;
				var attachment_eventz;
				meta_gallery_frame_event.on('open', function() {
					var event_selection = meta_gallery_frame_event.state().get('selection');
					var library_event = meta_gallery_frame_event.state('gallery-edit').get('library');
					var event_ids = jQuery('#attachments_ids').val();
					if (event_ids) {
						idsArray_events = event_ids.split(',');
						idsArray_events.forEach(function(id) {
							attachment_eventz = wp.media.attachment(id);
							attachment_eventz.fetch();
							event_selection.add( attachment_eventz ? [ attachment_eventz ] : [] );
						});
					}
				});
				meta_gallery_frame_event.on('ready', function() {
					jQuery( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var images_event;
		meta_gallery_frame_event.on('select', function() {
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			images_event = meta_gallery_frame_event.state().get('selection');
			//imageHTML += '<ul class="dwt_listing_gallery">';
			images_event.each(function(attachment_eventz) {
				//imageHTML = '';
                console.debug(attachment_eventz.attributes);
				imageIDArray.push(attachment_eventz.attributes.id);
				
				if(attachment_eventz.attributes.type == 'application')
				{
						imageHTML += '<li id="data-'+attachment_eventz.attributes.id+'"><span class="freelance_icon_brand"><a href="javascript:void(0)" id="'+attachment_eventz.attributes.id+'" class="close-thik"></a><img id="'+attachment_eventz.attributes.id+'" src="'+attachment_eventz.attributes.icon+'"></span></li>';
				}
				else
				{
								
					if (typeof attachment_eventz.attributes.sizes.thumbnail === 'undefined') {
						imageHTML += '<li id="data-'+attachment_eventz.attributes.id+'"><span class="freelance_icon_brand"><a href="javascript:void(0)" id="'+attachment_eventz.attributes.id+'" class="close-thik"></a><img id="'+attachment_eventz.attributes.id+'" src="'+attachment_eventz.attributes.url+'"></span></li>';
					}
					else
					{
						imageHTML += '<li id="data-'+attachment_eventz.attributes.id+'"><span class="freelance_icon_brand"><a href="javascript:void(0)" id="'+attachment_eventz.attributes.id+'" class="close-thik"></a><img id="'+attachment_eventz.attributes.id+'" src="'+attachment_eventz.attributes.sizes.thumbnail.url+'"></span></li>';
					}

				}
				
				
				
			});
			//imageHTML += '</ul>';
			metadataString = imageIDArray.join(",");
			if (metadataString) {
				jQuery("#attachments_ids").val(metadataString);
				jQuery(".freelance_gallery").html(imageHTML);
			}
		});
		meta_gallery_frame_event.open();
      });
	  
	  jQuery(document).on('click', 'a.close-thik', function() {
			  if(confirm(exertio_localize_vars.ConfirmText))
			  {
					var id = jQuery(this).attr('id');
					var saved_ids = jQuery('#attachments_ids').val();
					var nameArr  = saved_ids.split(',');
					 var updated_ids = jQuery.grep(nameArr, function(value) {
					  return value != id;
					});
					jQuery(".freelance_gallery li#data-"+id).hide();
					jQuery("#attachments_ids").val(updated_ids);
			  }
			});
			
			
			/*SERVICES ADD NEW VIDEO FIELDS*/ 
			jQuery(document).ready(function(){
				var maxField = 10; 
				var addButton = jQuery('.add_button'); 
				var wrapper = jQuery('.field_wrapper'); 
				var fieldHTML = '<div class="ui-state-default"><span class="dashicons dashicons-move"></span><input type="url" name="video_urls[]" value=""/><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" >	</a></div>'; 
				var x = 1; 
				
				jQuery(addButton).click(function(){
					
					if(x < maxField){ 
						x++; 
						jQuery(wrapper).append(fieldHTML); 
					}
					else
					{
						alert(exertio_localize_vars.maxTemUrlFields);	
					}
				});
				
				jQuery(wrapper).on('click', '.remove_button', function(e){
					if(confirm(exertio_localize_vars.ConfirmText))
					{
						e.preventDefault();
						jQuery(this).parent('div').remove(); 
						x--; 
					}
				});
			});
			
			
			
			
			
			
			
			
			
			/* FOR SINGLE Profile IMAGE UPLOAD */
			
			jQuery('#single_attachment_btn').on('click', function(e){
                /*if (meta_gallery_frame_event) {
                        meta_gallery_frame_event.open();
                        return;
                }*/
                meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
                        title: exertio_localize_vars.selectImage,
                        button: { text:  exertio_localize_vars.selectImage },
                        library: { type: 'image'},
						multiple: false,
                });
				meta_gallery_frame_event.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame_event.options.library ),
						multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray_events;
				var attachment_eventz;
				meta_gallery_frame_event.on('open', function() {
					var event_selection = meta_gallery_frame_event.state().get('selection');
					var library_event = meta_gallery_frame_event.state('gallery-edit').get('library');
					var event_ids = jQuery('#profile_attachment_ids').val();
					if (event_ids) {
						idsArray_events = event_ids.split(',');
						idsArray_events.forEach(function(id) {
							attachment_eventz = wp.media.attachment(id);
							attachment_eventz.fetch();
							event_selection.add( attachment_eventz ? [ attachment_eventz ] : [] );
						});
					}
				});
				meta_gallery_frame_event.on('ready', function() {
					jQuery( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var images_event;
		meta_gallery_frame_event.on('select', function() {
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			images_event = meta_gallery_frame_event.state().get('selection');
			//imageHTML += '<ul class="dwt_listing_gallery">';
			images_event.each(function(attachment_eventz) {
				//imageHTML = '';
                console.debug(attachment_eventz.attributes);
				imageIDArray.push(attachment_eventz.attributes.id);
				
					if (typeof attachment_eventz.attributes.sizes.thumbnail === 'undefined') {
						imageHTML += '<li id="data-'+attachment_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_eventz.attributes.id+'" src="'+attachment_eventz.attributes.url+'"></span><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" ></a></li>';
					}
					else
					{
						imageHTML += '<li id="data-'+attachment_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_eventz.attributes.id+'" src="'+attachment_eventz.attributes.sizes.thumbnail.url+'"></span><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" ></a></li>';
					}

				
			});
			//imageHTML += '</ul>';
			metadataString = imageIDArray.join(",");
			if (metadataString) {
				jQuery("#profile_attachment_ids").val(metadataString);
				jQuery(".freelance_gallery").html(imageHTML);
			}
		});
		meta_gallery_frame_event.open();
      });
	/* REMOVE PROFILE IMAGE */
		var freelance_gallery = jQuery('.freelance_gallery'); 
		jQuery(freelance_gallery).on('click', '.remove_button', function(e){
				if(confirm(exertio_localize_vars.ConfirmText))
				{
					e.preventDefault();
					jQuery(this).parent('li').remove(); //Remove field html
					jQuery("#profile_attachment_ids").val('');
				}
			});



			/* FOR SINGLE BANNER IMAGE UPLOAD */
			jQuery('#banner_img_btn').on('click', function(e){
                /*if (meta_gallery_frame_event) {
                        meta_gallery_frame_event.open();
                        return;
                }*/
                meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
                        title: exertio_localize_vars.selectImage,
                        button: { text:  exertio_localize_vars.selectImage },
                        library: { type: 'image'},
						multiple: false,
                });
				meta_gallery_frame_event.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame_event.options.library ),
						multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray_banner_events;
				var attachment_banner_eventz;
				meta_gallery_frame_event.on('open', function() {
					var event_selection_banner = meta_gallery_frame_event.state().get('selection');
					var library_event_banner = meta_gallery_frame_event.state('gallery-edit').get('library');
					var event_banner_ids = jQuery('#banner_img_id').val();
					if (event_banner_ids) {
						idsArray_banner_events = event_banner_ids.split(',');
						idsArray_banner_events.forEach(function(id) {
							attachment_banner_eventz = wp.media.attachment(id);
							attachment_banner_eventz.fetch();
							event_selection_banner.add( attachment_banner_eventz ? [ attachment_banner_eventz ] : [] );
						});
					}
				});
				meta_gallery_frame_event.on('ready', function() {
					jQuery( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var images_banner_event;
		meta_gallery_frame_event.on('select', function() {
			var imageIDBannerArray = [];
			var imageHTMLBanner = '';
			var metadataStringBanner = '';
			images_banner_event = meta_gallery_frame_event.state().get('selection');
			//imageHTMLBanner += '<ul class="dwt_listing_gallery">';
			images_banner_event.each(function(attachment_banner_eventz) {
				//imageHTMLBanner = '';
                console.debug(attachment_banner_eventz.attributes);
				imageIDBannerArray.push(attachment_banner_eventz.attributes.id);
				
					if (typeof attachment_banner_eventz.attributes.sizes.thumbnail === 'undefined') {
						imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.url+'"></span><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" >	</a></li>';
					}
					else
					{
						imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.sizes.thumbnail.url+'"></span><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" >	</a></li>';
					}

				
			});
			//imageHTMLBanner += '</ul>';
			metadataStringBanner = imageIDBannerArray.join(",");
			if (metadataStringBanner) {
				jQuery("#banner_img_id").val(metadataStringBanner);
				jQuery(".freelance_banner_gallery").html(imageHTMLBanner);
			}
		});
		meta_gallery_frame_event.open();
      });
	  /* REMOVE BANNER IMAGE */
		var freelance_banner_gallery = jQuery('.freelance_banner_gallery'); 
		jQuery(freelance_banner_gallery).on('click', '.remove_button', function(e){
				if(confirm(exertio_localize_vars.ConfirmText))
				{
					e.preventDefault();
					jQuery(this).parent('li').remove(); //Remove field html
					jQuery("#banner_img_id").val('');
				}
			});
	  
	  
	  
	  /*JQUEY SORABLE*/
	    jQuery( function() {
			jQuery( ".sortable" ).sortable();
			//jQuery( "#sortable" ).disableSelection();
		  } );
		  
/* SKILLES AJAX WORK ADD/REMOVE SKILLS */
		jQuery(document).ready(function(){
			jQuery(".add_new_skills").click( function(e) {
			  e.preventDefault(); 
			  tax_name = jQuery(this).attr("data-taxonomy-name");
				var wrapper = jQuery('.skills_wrapper'); 
			  jQuery.ajax({
				 type : "post",
				 //dataType : "json",
				 url : exertio_localize_vars.ajaxurl,
				 data : {action: "get_my_terms", tax_name : tax_name},
				 success: function(response) {
					if(response) {
					   jQuery(wrapper).append(response);
					}
					else {
					   alert("Something went wrong");
					}
				 }
			  });
			});
			/* REMOVE SKILLS */
			var wrapper = jQuery('.skills_wrapper'); 
			jQuery(wrapper).on('click', '.remove_button', function(e){
					if(confirm(exertio_localize_vars.ConfirmText))
					{
						e.preventDefault();
						jQuery(this).parent('div').remove(); //Remove field html
					}
				});
		});


		jQuery(document).ready(function(){
			
		/* AWARDS AJAX WORK ADD/REMOVE */
			
			jQuery(".add_new_award").click( function(e) {
			  e.preventDefault(); 
				var wrapper = jQuery('.award_wrapper');
				var awardsCountFirst = jQuery('.award_wrapper .ui-state-default').length;
				awardsCount = awardsCountFirst+1;
				alert(awardsCount);

				var fieldHTML = '<div class="ui-state-default" id="award_'+awardsCount+'"><span class="dashicons dashicons-move"></span><div class="col-4"><input type="text" name="award_name[]" value="" placeholder="'+exertio_localize_vars.awardName+'"></div><div class="col-4"><input type="text" class="datetimepicker" name="award_date[]" placeholder="'+exertio_localize_vars.awardDate+'" autocomplete="off"></div><div class="col-4"><button type="button" class="award_img_btn_'+awardsCount+' button button-primary button-large">'+exertio_localize_vars.selectImage+'</button><input type="hidden" class="award_img_id_'+awardsCount+'" name="award_img_id[]" value=""><div class="award_banner_gallery_'+awardsCount+' sort_imgs"></div></div><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" ></a></div>'; 
				
				jQuery(wrapper).append(fieldHTML);
				
				jQuery('.datetimepicker').datetimepicker({
					timepicker:false,
					format:'d/m/Y',
					lazyInit:true,
				});
				
				
				jQuery('.award_img_btn_'+awardsCount).on('click', function(e){
                /*if (meta_gallery_frame_event) {
                        meta_gallery_frame_event.open();
                        return;
                }*/
                meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
                        title: exertio_localize_vars.selectImage,
                        button: { text:  exertio_localize_vars.selectImage },
                        library: { type: 'image'},
						multiple: false,
                });
				meta_gallery_frame_event.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame_event.options.library ),
						multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray_banner_events;
				var attachment_banner_eventz;
				meta_gallery_frame_event.on('open', function() {
					var event_selection_banner = meta_gallery_frame_event.state().get('selection');
					var library_event_banner = meta_gallery_frame_event.state('gallery-edit').get('library');
					var event_banner_ids = jQuery('.award_img_id_'+awardsCount).val();
					if (event_banner_ids) {
						idsArray_banner_events = event_banner_ids.split(',');
						idsArray_banner_events.forEach(function(id) {
							attachment_banner_eventz = wp.media.attachment(id);
							attachment_banner_eventz.fetch();
							event_selection_banner.add( attachment_banner_eventz ? [ attachment_banner_eventz ] : [] );
						});
					}
				});
				meta_gallery_frame_event.on('ready', function() {
					jQuery( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var images_banner_event;
		meta_gallery_frame_event.on('select', function() {
			var imageIDBannerArray = [];
			var imageHTMLBanner = '';
			var metadataStringBanner = '';
			images_banner_event = meta_gallery_frame_event.state().get('selection');
			imageHTMLBanner += '<ul class="award_listing_gallery">';
			images_banner_event.each(function(attachment_banner_eventz) {
				//imageHTMLBanner = '';
                console.debug(attachment_banner_eventz.attributes);
				imageIDBannerArray.push(attachment_banner_eventz.attributes.id);
				
					if (typeof attachment_banner_eventz.attributes.sizes.thumbnail === 'undefined') {
						imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.url+'"></span></li>';
					}
					else
					{
						imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.sizes.thumbnail.url+'"></span></li>';
					}

				
			});
			imageHTMLBanner += '</ul>';
			metadataStringBanner = imageIDBannerArray.join(",");
			if (metadataStringBanner) {
				jQuery(".award_img_id_"+awardsCount).val(metadataStringBanner);
				jQuery(".award_banner_gallery_"+awardsCount).html(imageHTMLBanner);
			}
		});
		meta_gallery_frame_event.open();
      });
			});
			
			
				/* FOR THE UPDATE AWARD IMAGE */
				jQuery(".award_img_btn").on('click', function(e){
					
					var award_img_init = jQuery(this).attr("data-award-init");
					var award_gallary = jQuery(this).attr("data-award-galary");
					meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
							title: exertio_localize_vars.selectImage,
							button: { text:  exertio_localize_vars.selectImage },
							library: { type: 'image'},
							multiple: false,
					});
					meta_gallery_frame_event.states.add([
						new wp.media.controller.Library({
							priority:   20,
							toolbar:    'main-gallery',
							filterable: 'uploaded',
							library:    wp.media.query( meta_gallery_frame_event.options.library ),
							multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
							editable:   true,
							allowLocalEdits: true,
							displaySettings: true,
							displayUserSettings: true
						}),
					]);
					var idsArray_banner_events;
					var attachment_banner_eventz;
					meta_gallery_frame_event.on('open', function() {
						var event_selection_banner = meta_gallery_frame_event.state().get('selection');
						var library_event_banner = meta_gallery_frame_event.state('gallery-edit').get('library');
						var event_banner_ids = jQuery('#'+award_img_init).val();
						if (event_banner_ids) {
							idsArray_banner_events = event_banner_ids.split(',');
							idsArray_banner_events.forEach(function(id) {
								attachment_banner_eventz = wp.media.attachment(id);
								attachment_banner_eventz.fetch();
								event_selection_banner.add( attachment_banner_eventz ? [ attachment_banner_eventz ] : [] );
							});
						}
					});
					meta_gallery_frame_event.on('ready', function() {
						jQuery( '.media-modal' ).addClass( 'no-sidebar' );
					});
			 var images_banner_event;
			meta_gallery_frame_event.on('select', function() {
				var imageIDBannerArray = [];
				var imageHTMLBanner = '';
				var metadataStringBanner = '';
				images_banner_event = meta_gallery_frame_event.state().get('selection');
				imageHTMLBanner += '<ul class="award_listing_gallery">';
				images_banner_event.each(function(attachment_banner_eventz) {
					//imageHTMLBanner = '';
					console.debug(attachment_banner_eventz.attributes);
					imageIDBannerArray.push(attachment_banner_eventz.attributes.id);
					
						if (typeof attachment_banner_eventz.attributes.sizes.thumbnail === 'undefined') {
							imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.url+'"></span></li>';
						}
						else
						{
							imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.sizes.thumbnail.url+'"></span></li>';
						}
				});
				imageHTMLBanner += '</ul>';
				metadataStringBanner = imageIDBannerArray.join(",");
				if (metadataStringBanner) {
					jQuery("#"+award_img_init).val(metadataStringBanner);
					jQuery("."+award_gallary).html(imageHTMLBanner);
				}
			});
			meta_gallery_frame_event.open();
		  });
		  
		  
		  
		  
			/* REMOVE AWARD */
			var wrapper = jQuery('.award_wrapper'); 
			jQuery(wrapper).on('click', '.remove_button', function(e){
					if(confirm(exertio_localize_vars.ConfirmText))
					{
						e.preventDefault();
						jQuery(this).parent('div').remove(); //Remove field html
					}
				});
				
				
				
				
				
				
				
				/* PROJECTS ADD REMOVE */
				jQuery(".add_new_project").click( function(e) {
				  e.preventDefault(); 
				var wrapper = jQuery('.project_wrapper');
				var projectsCountFirst = jQuery('.project_wrapper .ui-state-default').length;
				projectsCount = projectsCountFirst+1;

				var fieldHTML = '<div class="ui-state-default" id="project_'+projectsCount+'"><span class="dashicons dashicons-move"></span><div class="col-4"><input type="text" name="project_name[]" value="" placeholder="'+exertio_localize_vars.projectName+'"></div><div class="col-4"><input type="url" class="" name="project_url[]" placeholder="'+exertio_localize_vars.projectURL+'" autocomplete="off"></div><div class="col-4"><button type="button" class="project_img_btn_'+projectsCount+' button button-primary button-large">'+exertio_localize_vars.selectImage+'</button><input type="hidden" class="project_img_id_'+projectsCount+'" name="project_img_id[]" value=""><div class="project_banner_gallery_'+projectsCount+' sort_imgs"></div></div><a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" ></a></div>'; 
				
				jQuery(wrapper).append(fieldHTML);
				
				
				jQuery('.project_img_btn_'+projectsCount).on('click', function(e){
                meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
                        title: exertio_localize_vars.selectImage,
                        button: { text:  exertio_localize_vars.selectImage },
                        library: { type: 'image'},
						multiple: false,
                });
				meta_gallery_frame_event.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame_event.options.library ),
						multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray_banner_events;
				var attachment_banner_eventz;
				meta_gallery_frame_event.on('open', function() {
					var event_selection_banner = meta_gallery_frame_event.state().get('selection');
					var library_event_banner = meta_gallery_frame_event.state('gallery-edit').get('library');
					var event_banner_ids = jQuery('.project_img_id_'+projectsCount).val();
					if (event_banner_ids) {
						idsArray_banner_events = event_banner_ids.split(',');
						idsArray_banner_events.forEach(function(id) {
							attachment_banner_eventz = wp.media.attachment(id);
							attachment_banner_eventz.fetch();
							event_selection_banner.add( attachment_banner_eventz ? [ attachment_banner_eventz ] : [] );
						});
					}
				});
				meta_gallery_frame_event.on('ready', function() {
					jQuery( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var images_banner_event;
		meta_gallery_frame_event.on('select', function() {
			var imageIDBannerArray = [];
			var imageHTMLBanner = '';
			var metadataStringBanner = '';
			images_banner_event = meta_gallery_frame_event.state().get('selection');
			imageHTMLBanner += '<ul class="project_listing_gallery">';
			images_banner_event.each(function(attachment_banner_eventz) {
				//imageHTMLBanner = '';
                console.debug(attachment_banner_eventz.attributes);
				imageIDBannerArray.push(attachment_banner_eventz.attributes.id);
				
					if (typeof attachment_banner_eventz.attributes.sizes.thumbnail === 'undefined') {
						imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.url+'"></span></li>';
					}
					else
					{
						imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.sizes.thumbnail.url+'"></span></li>';
					}

				
			});
			imageHTMLBanner += '</ul>';
			metadataStringBanner = imageIDBannerArray.join(",");
			if (metadataStringBanner) {
				jQuery(".project_img_id_"+projectsCount).val(metadataStringBanner);
				jQuery(".project_banner_gallery_"+projectsCount).html(imageHTMLBanner);
			}
		});
		meta_gallery_frame_event.open();
      });
			});
			
			
				/* FOR THE UPDATE PROJECT IMAGE */
				jQuery(".project_img_btn").on('click', function(e){
					
					var project_img_init = jQuery(this).attr("data-project-init");
					var project_gallary = jQuery(this).attr("data-project-galary");
					meta_gallery_frame_event = wp.media.frames.meta_gallery_frame_event = wp.media({
							title: exertio_localize_vars.selectImage,
							button: { text:  exertio_localize_vars.selectImage },
							library: { type: 'image'},
							multiple: false,
					});
					meta_gallery_frame_event.states.add([
						new wp.media.controller.Library({
							priority:   20,
							toolbar:    'main-gallery',
							filterable: 'uploaded',
							library:    wp.media.query( meta_gallery_frame_event.options.library ),
							multiple:   meta_gallery_frame_event.options.multiple ? 'reset' : false,
							editable:   true,
							allowLocalEdits: true,
							displaySettings: true,
							displayUserSettings: true
						}),
					]);
					var idsArray_banner_events;
					var attachment_banner_eventz;
					meta_gallery_frame_event.on('open', function() {
						var event_selection_banner = meta_gallery_frame_event.state().get('selection');
						var library_event_banner = meta_gallery_frame_event.state('gallery-edit').get('library');
						var event_banner_ids = jQuery('#'+project_img_init).val();
						if (event_banner_ids) {
							idsArray_banner_events = event_banner_ids.split(',');
							idsArray_banner_events.forEach(function(id) {
								attachment_banner_eventz = wp.media.attachment(id);
								attachment_banner_eventz.fetch();
								event_selection_banner.add( attachment_banner_eventz ? [ attachment_banner_eventz ] : [] );
							});
						}
					});
					meta_gallery_frame_event.on('ready', function() {
						jQuery( '.media-modal' ).addClass( 'no-sidebar' );
					});
				var images_banner_event;
				meta_gallery_frame_event.on('select', function() {
				var imageIDBannerArray = [];
				var imageHTMLBanner = '';
				var metadataStringBanner = '';
				images_banner_event = meta_gallery_frame_event.state().get('selection');
				imageHTMLBanner += '<ul class="project_listing_gallery">';
				images_banner_event.each(function(attachment_banner_eventz) {
					//imageHTMLBanner = '';
					console.debug(attachment_banner_eventz.attributes);
					imageIDBannerArray.push(attachment_banner_eventz.attributes.id);
					
						if (typeof attachment_banner_eventz.attributes.sizes.thumbnail === 'undefined') {
							imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.url+'"></span></li>';
						}
						else
						{
							imageHTMLBanner += '<li id="data-'+attachment_banner_eventz.attributes.id+'"><span class="freelance_icon_brand"><img id="'+attachment_banner_eventz.attributes.id+'" src="'+attachment_banner_eventz.attributes.sizes.thumbnail.url+'"></span></li>';
						}
				});
				imageHTMLBanner += '</ul>';
				metadataStringBanner = imageIDBannerArray.join(",");
				if (metadataStringBanner) {
					jQuery("#"+project_img_init).val(metadataStringBanner);
					jQuery("."+project_gallary).html(imageHTMLBanner);
				}
				});
				meta_gallery_frame_event.open();
				});
				
				
				/* REMOVE PROJECT */
				var wrapper = jQuery('.project_wrapper'); 
				jQuery(wrapper).on('click', '.remove_button', function(e){
					if(confirm(exertio_localize_vars.ConfirmText))
					{
						e.preventDefault();
						jQuery(this).parent('div').remove(); //Remove field html
					}
				});
				
				
				
				
				/* EXPERIENCE ADD/REMOVE */
				jQuery(document).on('click', '.add_new_expe', function (e) {
				  e.preventDefault(); 
				var wrapper = jQuery('.expe_wrapper');
				var expeCountFirst = jQuery('.expe_wrapper .ui-state-default').length;
				expeCount = expeCountFirst+1;

				var fieldHTML = '<div class="ui-state-default" id="expe_'+expeCount+'"><span class="dashicons dashicons-move"></span><span class="count">'+expeCount+'</span>	<div class="col-12"><div class="col-4"><label>'+exertio_localize_vars.expeName+'</label><input type="text" name="expe_name[]" ></div><div class="col-4"><label>'+exertio_localize_vars.expeCompName+'</label> <input type="text" class="" name="expe_company_name[]"></div></div><div class="col-12"> <div class="col-4"> <label>'+exertio_localize_vars.startDate+'</label><input type="text" name="expe_start_date[]" class="expe_start_date_'+expeCount+'"></div> <div class="col-4"><label>'+exertio_localize_vars.endDate+'</label> <input type="text" name="expe_end_date[]" class="expe_end_date_'+expeCount+'"><p>'+exertio_localize_vars.endDatemsg+'</p></div></div><div class="col-12"><div class="col-8"><label>'+exertio_localize_vars.expeDesc+'</label><textarea name="expe_details[]"></textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" ></a></div>';
				
				jQuery(wrapper).append(fieldHTML);
				
				
				jQuery(function(){
				 jQuery('.expe_start_date_'+expeCount).datetimepicker({
				  format:'Y/m/d',
				  onShow:function( ct ){
				   this.setOptions({
					maxDate:jQuery('.expe_end_date_'+expeCount).val()?jQuery('.expe_end_date_'+expeCount).val():false
				   })
				  },
				  timepicker:false
				 });
				 jQuery('.expe_end_date_'+expeCount).datetimepicker({
				  format:'Y/m/d',
				  onShow:function( ct ){
				   this.setOptions({
					minDate:jQuery('.expe_start_date_'+expeCount).val()?jQuery('.expe_start_date_'+expeCount).val():false
				   })
				  },
				  timepicker:false
				 });
				});
				
			});
			
				/* REMOVE EXPERIENCE */
				var wrapper = jQuery('.expe_wrapper'); 
				jQuery(wrapper).on('click', '.remove_button', function(e){
					if(confirm(exertio_localize_vars.ConfirmText))
					{
						e.preventDefault();
						jQuery(this).parent('div').remove(); //Remove field html
					}
				});
				
				
				
				  
				  var expeCount = jQuery('.expe_wrapper .ui-state-default').length;
					var expeCount = expeCount+1;
					var i;
					for (i = 1; i < expeCount; i++) { 
						jQuery('.expe_start_date_'+i).datetimepicker({
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
						 jQuery('.expe_end_date_'+i).datetimepicker({
						  format:'Y/m/d',
						  minDate:jQuery('.expe_start_date_'+i).val(),
						  timepicker:false
						 });
						 
					}
				
				
				
	/* EXPERIENCE ADD/REMOVE */
	jQuery(document).on('click', '.add_new_edu', function (e) {
	  e.preventDefault(); 
	var wrapper = jQuery('.edu_wrapper');
	var eduCountFirst = jQuery('.edu_wrapper .ui-state-default').length;
	eduCount = eduCountFirst+1;
	
	var fieldHTML = '<div class="ui-state-default" id="edu_'+eduCount+'"><span class="dashicons dashicons-move"></span><span class="count">'+eduCount+'</span>	<div class="col-12"><div class="col-4"><label>'+exertio_localize_vars.eduName+'</label><input type="text" name="edu_name[]" ></div><div class="col-4"><label>'+exertio_localize_vars.eduInstName+'</label> <input type="text" class="" name="edu_inst_name[]"></div></div><div class="col-12"> <div class="col-4"> <label>'+exertio_localize_vars.startDate+'</label><input type="text" name="edu_start_date[]" class="edu_start_date_'+eduCount+'"></div> <div class="col-4"><label>'+exertio_localize_vars.endDate+'</label> <input type="text" name="edu_end_date[]" class="edu_end_date_'+eduCount+'"><p>'+exertio_localize_vars.eduEndDatemsg+'</p></div></div><div class="col-12"><div class="col-8"><label>'+exertio_localize_vars.expeDesc+'</label><textarea name="edu_details[]"></textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><img src="'+exertio_localize_vars.pluginUrl+'/images/error.png" ></a></div>';
	
	jQuery(wrapper).append(fieldHTML);
	
	
	jQuery(function(){
	 jQuery('.edu_start_date_'+eduCount).datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
		maxDate:jQuery('.edu_end_date_'+eduCount).val()?jQuery('.edu_end_date_'+eduCount).val():false
	   })
	  },
	  timepicker:false
	 });
	 jQuery('.edu_end_date_'+eduCount).datetimepicker({
	  format:'Y/m/d',
	  onShow:function( ct ){
	   this.setOptions({
		minDate:jQuery('.edu_start_date_'+eduCount).val()?jQuery('.edu_start_date_'+eduCount).val():false
	   })
	  },
	  timepicker:false
	 });
	});
	
	});
	
	/* REMOVE EDUCATION */
	var wrapper = jQuery('.edu_wrapper'); 
	jQuery(wrapper).on('click', '.remove_button', function(e){
		if(confirm(exertio_localize_vars.ConfirmText))
		{
			e.preventDefault();
			jQuery(this).parent('div').remove(); //Remove field html
		}
	});
	
	
	
	  
	var eduCount = jQuery('.edu_wrapper .ui-state-default').length;
	var eduCount = eduCount+1;
	var i;
	for (i = 1; i < eduCount; i++) { 
		jQuery('.edu_start_date_'+i).datetimepicker({
		  format:'Y/m/d',
		  onSelectDate:function(ct,$i){
			  var eduCount2 = jQuery('.edu_wrapper .ui-state-default').length;
				var eduCount2 = eduCount2+1;
				for (j = 1; j < eduCount2; j++) { 
					jQuery('.edu_end_date_'+j).datetimepicker({
						minDate:jQuery('.edu_start_date_'+j).val(),
						timepicker:false, 
					});
				}
			},
		  timepicker:false
		 });
		 jQuery('.edu_end_date_'+i).datetimepicker({
		  format:'Y/m/d',
		  minDate:jQuery('.edu_start_date_'+i).val(),
		  timepicker:false
		 });
		 
	}				
				
				
				
});

if (jQuery( ".custom-range-slider" ).length > 0){jQuery(".custom-range-slider").ionRangeSlider({skin: "round"});}
jQuery('#exertio_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	jQuery('.loader-outer').show();
	//fields
	//var freelanceAjaxURL = $("#freelance_ajax_url").val();
	jQuery.post(exertio_localize_vars.ajaxurl,{action : 'exertio_get_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		jQuery('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "flex");
			console.log(response.data.fields);
			jQuery('.additional-fields-container').html(response.data.fields);
			if (jQuery( ".custom-range-slider" ).length > 0){jQuery(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "none");
		}
	});
 });
jQuery('#exertio_serivces_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	jQuery('.loader-outer').show();
	//fields
	//var freelanceAjaxURL = $("#freelance_ajax_url").val();
	jQuery.post(exertio_localize_vars.ajaxurl,{action : 'exertio_get_services_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		jQuery('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "flex");
			console.log(response.data.fields);
			jQuery('.additional-fields-container').html(response.data.fields);
			if (jQuery( ".custom-range-slider" ).length > 0){jQuery(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "none");
		}
	});
 });
jQuery('#exertio_freelancer_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	jQuery('.loader-outer').show();
	//fields
	//var freelanceAjaxURL = $("#freelance_ajax_url").val();
	jQuery.post(exertio_localize_vars.ajaxurl,{action : 'exertio_get_freelancer_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		jQuery('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "flex");
			console.log(response.data.fields);
			jQuery('.additional-fields-container').html(response.data.fields);
			if (jQuery( ".custom-range-slider" ).length > 0){jQuery(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "none");
		}
	});
 });
jQuery('#exertio_freelancer_cat_parent').on('change', function ()
{
	var cat_parent = $(this).val();
	jQuery('.loader-outer').show();
	//fields
	//var freelanceAjaxURL = $("#freelance_ajax_url").val();
	jQuery.post(exertio_localize_vars.ajaxurl,{action : 'exertio_get_employer_custom_fields', cat_parent:cat_parent}).done( function(response) 
	{
		jQuery('.additional-fields').css("display", "block");
		
		if (true === response.success) {
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "flex");
			console.log(response.data.fields);
			jQuery('.additional-fields-container').html(response.data.fields);
			if (jQuery( ".custom-range-slider" ).length > 0){jQuery(".custom-range-slider").ionRangeSlider({skin: "round"});}
		}
		else
		{
			jQuery('.loader-outer').hide();
			jQuery('.additional-fields').css("display", "none");
		}
	});
 });
		
		  
