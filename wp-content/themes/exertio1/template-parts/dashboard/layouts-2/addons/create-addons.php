<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

$fid = get_user_meta( $current_user_id, 'freelancer_id' , true );
$is_update = '';
	if(isset($_GET['aid']))
	{
		$aid = $_GET['aid'];
		$is_update = $aid;
	}
	else
	{
		$aid = get_user_meta( $current_user_id, '_processing_addon_id' , true );
		if(isset($aid) && $aid =='')
		{
			$my_post = array(
				'post_title' => '',
				'post_status' => 'pending',
				'post_author' => $current_user_id,
				'post_type' => 'addons'
			);
			$aid = wp_insert_post($my_post);
			update_user_meta( $current_user_id, '_processing_addon_id', $aid );
				
		}
	}

$post	=	get_post($aid);
if($post == '')
{
	$my_post = array(
		'post_title' => '',
		'post_status' => 'pending',
		'post_author' => $current_user_id,
		'post_type' => 'addons'
	);
	$aid = wp_insert_post($my_post);
	update_user_meta( $current_user_id, '_processing_addon_id', $aid );
	$post	=	get_post($aid);
}

	if( $current_user_id == $post->post_author )
	{
		?>
		<div class="content-wrapper">
        <div class="notch"></div>
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2><?php echo esc_html__('Create Addons ','exertio_theme'); ?></h2>
                    <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
						<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
						<?php echo exertio_dashboard_extention_return(); ?>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-8 col-lg-12 col-md-12 grid-margin stretch-card">
            <form id="addon_form">
                <div class="card mb-4">
                    <div class="card-body">
                      <h4 class="card-title"><?php echo esc_html__('Addon Details','exertio_theme'); ?></h4>
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Addon Title ','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="addon_title" value="<?php echo esc_attr($post->post_title); ?>" required data-smk-msg="<?php echo esc_attr__('Give title to your addon please', 'exertio_theme' ); ?>">
                          <input type="hidden" id="is_update" name="is_update" value="<?php echo esc_attr($is_update); ?>" />
                        </div>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Price','exertio_theme').' ('.$exertio_theme_options['fl_currency'].')'; ?></label>
                          <input type="text" class="form-control" name="addon_price" value="<?php echo esc_attr(get_post_meta( $aid, '_addon_price', true )); ?>" required data-smk-msg="<?php echo esc_attr__('Please provide addon price without currency sign', 'exertio_theme' ); ?>" data-smk-type="number">
                        </div>
                        
                        <div class="form-group col-md-12">
                          <label><?php echo esc_html__('Description','exertio_theme'); ?></label>
                          <textarea name="addon_desc" id="" class="form-control"><?php echo esc_attr($post->post_content); ?></textarea>
                          
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-theme" id="fl_addon_btn" data-post-id="<?php echo esc_attr($aid) ?>">
                                        <?php echo esc_html__('Create Addon','exertio_theme'); ?>
                                        <input type="hidden" id="save_pro_nonce" value="<?php echo wp_create_nonce('fl_save_pro_secure'); ?>"  />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            
          </div>
        </div>
        </div>
	<?php
    }
	else
	{
		echo exertio_redirect(home_url('/'));
	}
	?>