<?php
$fl_id = get_the_ID();
global $exertio_theme_options;
$post_author = get_post_field( 'post_author', $fl_id );
$user_info = get_userdata($post_author);
?>
<div class="fr-recent-employers sidebar-box">
	<?php
	if(isset($exertio_theme_options['detail_sidebar_about']) && $exertio_theme_options['detail_sidebar_about'] != '')
	{
		?>
		<div class="sidebar-heading">
			<h3><?php echo esc_html($exertio_theme_options['detail_sidebar_about']); ?></h3>
		</div>
		<?php
	}
	?>
  <ul>
	<?php
	if($exertio_theme_options['freelancer_phone_number'] && $exertio_theme_options['freelancer_phone_number'] == 2)
	{
		?>
		<li>
			<i class="fas fa-mobile-alt"></i>
			<div class="meta">
				<span><?php echo esc_html__('Contact Number','exertio_theme'); ?></span>
				<p><?php echo esc_attr(get_post_meta( $fl_id, '_freelancer_contact_number' , true )); ?></p>
			</div>
		</li>
		<?php
	}
	else if($exertio_theme_options['freelancer_phone_number'] && $exertio_theme_options['freelancer_phone_number'] == 3)
	{
		if(!is_user_logged_in())
		{
			?>
            <li>
                <i class="fas fa-mobile-alt"></i>
                <div class="meta">
                    <span><?php echo esc_html__('Contact Number','exertio_theme'); ?></span>
                    <p><?php echo esc_html__('Signin to view','exertio_theme'); ?></p>
                </div>
            </li>
            <?php
		}
		else
		{
			?>
			<li>
				<i class="fas fa-mobile-alt"></i>
				<div class="meta">
					<span><?php echo esc_html__('Contact Number','exertio_theme'); ?></span>
					<p><?php echo esc_attr(get_post_meta( $fl_id, '_freelancer_contact_number' , true )); ?></p>
				</div>
			</li>
			<?php
		}
	}
	/*EMAIL DETAIL*/
	if($exertio_theme_options['freelancer_email'] && $exertio_theme_options['freelancer_email'] == 2)
	{
		?>
		<li>
			<i class="far fa-envelope"></i>
			<div class="meta">
				<span><?php echo esc_html__('Email Address','exertio_theme'); ?></span>
				<p><?php echo esc_attr($user_info->user_email); ?></p>
			</div>
		</li>
		<?php
	}
	else if($exertio_theme_options['freelancer_email'] && $exertio_theme_options['freelancer_email'] == 3)
	{
		if(!is_user_logged_in())
		{
			?>
            <li>
                <i class="far fa-envelope"></i>
                <div class="meta">
                    <span><?php echo esc_html__('Email Address','exertio_theme'); ?></span>
                    <p><?php echo esc_html__('Signin to view','exertio_theme'); ?></p>
                </div>
            </li>
            <?php
		}
		else
		{
			?>
			<li>
				<i class="far fa-envelope"></i>
				<div class="meta">
					<span><?php echo esc_html__('Email Address','exertio_theme'); ?></span>
					<p><?php echo esc_attr($user_info->user_email); ?></p>
				</div>
			</li>
			<?php
		}
	}
	
	if($exertio_theme_options['detail_page_gender'] && $exertio_theme_options['detail_page_gender'] == 2)
	{
		?>
		<li>
			<i class="fas fa-venus-mars"></i>
			<div class="meta">
				<span><?php echo esc_html__('Gender','exertio_theme'); ?></span>
				<p>
					<?php
						$gender = '';
						$gender = get_post_meta( $fl_id, '_freelancer_gender' , true );
						if(isset($gender) && $gender == 0)
						{
							echo esc_html__('Male','exertio_theme');
						}
						else if(isset($gender) && $gender == 1)
						{
							echo esc_html__('Female','exertio_theme');;
						}
						else if(isset($gender) && $gender == 2)
						{
							echo esc_html__('Other','exertio_theme');;
						}
					?>
				</p>
			</div>
		</li>
		<?php
	}
	if($exertio_theme_options['detail_page_type'] && $exertio_theme_options['detail_page_type'] == 2)
	{
	?>
    <li>
        <i class="fas fa-user-tie"></i>
        <div class="meta">
            <span><?php echo esc_html__('Freelancer Type','exertio_theme'); ?></span>
            <p><?php echo get_term_names('freelance-type', '_freelance_type', $fl_id, '', ',' ); ?></p>
        </div>
    </li>
    <?php
	}
	if($exertio_theme_options['detail_page_eglish_level'] && $exertio_theme_options['detail_page_eglish_level'] == 2)
	{
	?>
    <li>
        <i class="fas fa-tasks"></i>
        <div class="meta">
            <span><?php echo esc_html__('English Level','exertio_theme'); ?></span>
            <p><?php echo get_term_names('freelancer-english-level', '_freelancer_english_level', $fl_id, '', ',' ); ?></p>
        </div>
    </li>
    <?php
	}
	if($exertio_theme_options['detail_page_language'] && $exertio_theme_options['detail_page_language'] == 2)
	{
	?>
    <li>
        <i class="fas fa-language"></i>
        <div class="meta">
            <span><?php echo esc_html__('Languages','exertio_theme'); ?></span>
			<p>
			<?php
				$saved_languages = wp_get_post_terms($fl_id, 'freelancer-languages', array( 'fields' => 'all' ));
				if(!empty($saved_languages) && ! is_wp_error($saved_languages))
				{
					$i=0;
					$total = count($saved_languages);
					foreach($saved_languages as $saved_language)
					{
						$i++;
						echo  esc_html($saved_language->name);
						if ($i != $total) echo', ';
					}
				}
			?>
            </p>
        </div>
    </li>
    <?php
	}
    if($exertio_theme_options['detail_page_specialization'] && $exertio_theme_options['detail_page_specialization'] == 2)
    {
        ?>
        <li>
            <i class="fas fa-certificate"></i>
            <div class="meta">
                <span><?php echo esc_html__('Specialization','exertio_theme'); ?></span>
                <p>
                    <?php
                    $saved_specializations = wp_get_post_terms($fl_id, 'freelancer-specialization', array( 'fields' => 'all' ));
                    if(!empty($saved_specializations) && ! is_wp_error($saved_specializations))
                    {
                        $i=0;
                        $total = count($saved_specializations);
                        foreach($saved_specializations as $saved_specialization)
                        {
                            $i++;
                            echo  esc_html($saved_specialization->name);
                            if ($i != $total) echo', ';
                        }
                    }
                    ?>
                </p>
            </div>
        </li>
        <?php
    }
	?>
  </ul>
</div>


