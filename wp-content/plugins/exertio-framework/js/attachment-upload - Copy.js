var meta_gallery_frame_brand;
	jQuery('#attachment_btn').on('click', function(e){
                // sonu code here.
                if ( meta_gallery_frame_brand ) {
                        meta_gallery_frame_brand.open();
                        return;
                }
                // Sets up the media library frame
                meta_gallery_frame_brand = wp.media.frames.meta_gallery_frame_brand = wp.media({
                        title: 'Selct Images',
                        button: { text:  'button' },
                        library: { type: ['image','pdf', 'doc', 'docx.', 'xls ', 'xlsx'] },
						multiple: true
                });
				// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
				meta_gallery_frame_brand.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame_brand.options.library ),
						multiple:   meta_gallery_frame_brand.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray;
				var attachmentz;
				meta_gallery_frame_brand.on('open', function() {
					var selection = meta_gallery_frame_brand.state().get('selection');
					var library = meta_gallery_frame_brand.state('gallery-edit').get('library');
					var idsArray = jQuery('#attachments_ids').val();
					if (idsArray) {
						idsArray_selection = idsArray.split(',');
						idsArray_selection.forEach(function(id) {
							attachmentz = wp.media.attachment(id);
							attachmentz.fetch();
							selection.add( attachmentz ? [ attachmentz ] : [] );
						});
					}
				});
				meta_gallery_frame_brand.on('ready', function() {
					jQuery( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var imagesz;
		// When an image is selected, run a callback.
		//meta_gallery_frame.on('update', function() {
		meta_gallery_frame_brand.on('select', function() {
			var imageIDArrayz = [];
			var imageHTMLz = '';
			var metadataStringz = '';
			imagesz = meta_gallery_frame_brand.state().get('selection');
			//imageHTMLz += '<ul class="freelance_gallery">';
			imagesz.each(function(attachmentz) {
				//get image object
				imageHTMLz = '';
                //console.debug(attachmentz.attributes);
				imageIDArrayz.push(attachmentz.attributes.id);
				if(attachmentz.attributes.subtype == 'pdf' || attachmentz.attributes.subtype == 'doc' || attachmentz.attributes.subtype == 'docx' || attachmentz.attributes.subtype == 'xls' || attachmentz.attributes.subtype == 'xlsx')
				{
				imageHTMLz += '<li><span class="freelance_icon_brand"><img id="'+attachmentz.attributes.id+'" src="'+attachmentz.attributes.icon+'"></span></li>';
				}
				else
				{
				imageHTMLz += '<li><span class="freelance_icon_brand"><img id="'+attachmentz.attributes.id+'" src="'+attachmentz.attributes.url+'"></span></li>';
				}
				//alert(attachmentz.attributes.subtype);
			});
			//imageHTMLz += '</ul>';
			metadataStringz = imageIDArrayz.join(",");
			if (metadataStringz) {
				jQuery("#attachments_ids").val(metadataStringz);
				jQuery("#freelance_gall_render_html .freelance_gallery").append(imageHTMLz);
			}
		});
			// Finally, open the modal
			meta_gallery_frame_brand.open();
        });
		


