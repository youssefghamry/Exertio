<?php
global $exertio_theme_options;
$user_id = get_current_user_id();
$zoom_client_ids = get_user_meta($user_id, '_sb_zoom_client_id', true);
$zoom_secret_keys = get_user_meta($user_id, '_sb_zoom_client_secret', true);
$zoom_reg_emails = get_user_meta($user_id, '_sb_zoom_email', true);
?>
<div class="content-wrapper">
    <div class="notch"></div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2><?php echo esc_html__('Zoom Credentials', 'exertio_theme'); ?></h2>
                        <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme'); ?>&nbsp;</p>
                            <?php echo exertio_dashboard_extention_return(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post"  class="exertio_zoom_auth">
        <div class="card-widget mb-4">
            <div class="card">              
                <div class="card-body">    
                    <div class="form-group col-md-12">
                        <label><?php echo esc_html__('Zoom Email Address', 'exertio_theme'); ?></label>
                        <input type="email" class="form-control" name="email_address" value="<?php echo '' . ($zoom_reg_emails); ?>" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Please enter registered email address', 'exertio_theme'); ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label><?php echo esc_html__('Client ID', 'exertio_theme'); ?></label>
                        <input type="text" class="form-control" name="client_id" value="<?php echo '' . ($zoom_client_ids); ?>" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Please provide your client ID', 'exertio_theme'); ?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label><?php echo esc_html__('Client Secret', 'exertio_theme'); ?></label>
                        <input type="text" class="form-control" name="client_secret" value="<?php echo '' . ($zoom_secret_keys); ?>" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Enter client secret', 'exertio_theme'); ?>">
                    </div>
                    <div class="col-md-12">
                     <div class="fr-sigin-requirements">
                                <div class="form-group">
                                <div class="pretty p-icon p-thick p-curve">
                                  <input type="checkbox" required name="term_condition" data-smk-msg="<?php echo esc_attr__('You must need to accept terms and conditions','exertio_theme'); ?>">
                                  <div class="state p-warning"> <i class="icon fa fa-check"></i>
                                    <label> </label>
                                  </div>
                                </div>

                                  <span class="sr-style"><?php echo esc_html__('I agree to the','exertio_theme'); ?> <a href="<?php echo get_the_permalink($exertio_theme_options['terms_condition_page']); ?>"><?php echo esc_html__('Terms and Conditions','exertio_theme'); ?></a></span> </div>
                              </div>
                              </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-theme" data-user-id ="<?php echo '' . $user_id ?>" id="save_zoom_cred">
                            <?php echo esc_html__('Save Credentials', 'exertio_theme'); ?>
                        </button>
                        <?php $keys_link = (isset($exertio_theme_options['zoom_keys_link']) && $exertio_theme_options['zoom_keys_link'] != "") ? $exertio_theme_options['zoom_keys_link'] : "#";?>
                    </div>
                    <p class="n_getzoom_link" style="font-size: 14px;position: absolute;font-weight: 500;bottom: 20px;right: 45px;"><a href="<?php echo ''.($keys_link);?>" target="_blank" ><?php echo esc_html__('How to find Zoom Keys?', 'nokri'); ?></a></p>
                </div>
            </div>
        </div>
    </form>