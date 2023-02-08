<?php
$sort = $list_style = '';
if (isset($_GET['sort']) && $_GET['sort'] != "")
{
	$sort = $_GET['sort'];
}
if (isset($_GET['list-style']) && $_GET['list-style'] != "")
{
	$list_style = $_GET['list-style'];
}
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
	$actionbar_space = 'actionbar_space';
}

?>
<section class="fr-lance-details bg-gray-color section-padding <?php echo esc_attr($actionbar_space); ?>">
  <div class="container">
    <div class="row">
		<?php
        if(fl_framework_get_options('freelancer_sidebar') == 'left')
        {
            ?>
            <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 col-xl-4">
                <div class="project-sidebar">
                    <div class="heading">
                        <h4><?php echo esc_html__('Search Filters','exertio_theme'); ?></h4>
                        <?php
                            $freelancer_page = '';
                            $freelancer_page = fl_framework_get_options('freelancer_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($freelancer_page)); ?>"><?php echo esc_html__('Clear Result','exertio_theme'); ?></a>
                    </div>
                    <div class="project-widgets">
                        <form action="<?php echo get_the_permalink(fl_framework_get_options('freelancer_search_page')); ?>">
                            <?php dynamic_sidebar( 'exertio-freelancer-widgets' ); ?>
                            <div class="submit-btn">
                                <?php
                                    $sidebar_text = fl_framework_get_options('freelancer_search_sidebar_text');
                                    if(isset($sidebar_text) && $sidebar_text != '')
                                    {
                                        ?> 
                                        <p><i><?php echo esc_html($sidebar_text); ?> </i></p>
                                        <?php
                                    }
                                ?>
                                <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>">
                                <button class="btn btn-theme btn-block" type="submit"> <?php echo esc_html__('Filter Result','exertio_theme'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-lg-8 col-xl-8 col-sm-12 col-md-12 col-xl-8">
        <div class="row">
        	<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                <div class="services-filter-2">
                	<form>
						<div class="heading-area">
							<h4><?php echo esc_html__('Found ','exertio_theme'). $results->found_posts. esc_html__(' Results ','exertio_theme'); ?> </h4>

					</div>
						<div class="filters">
							<ul class="top-filters">
									<?php
										$list_active = $grid_active = '';
										if($list_style == 'list')
										{
											$list_active= 'active';
										}
										else if($list_style == 'grid')
										{
											$grid_active = 'active';
										}
										else
										{
											$grid_active = 'active';	
										}
									?>
									<li>
										<a href="javascript:void(0)" class="services-list-icon protip <?php echo esc_attr($list_active); ?> list-style" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'List View', 'exertio_theme' ); ?>" data-list-style="list">
											<span></span>
											<span></span>
											<span></span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" class="services-grid-icon protip <?php echo esc_attr($grid_active); ?> list-style" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo __( 'Grid View', 'exertio_theme' ); ?>" data-list-style="grid">
											<span></span>
											<span></span>
											<span></span>
										</a>
									</li>
								</ul>
							<select class="default-select" name="sort" id="order_by">
								<option value=""><?php echo __( 'Sort by', 'exertio_theme' ); ?></option>
								<option value="desc" <?php if($sort == 'desc'){ echo "selected"; } ?>> <?php echo __( 'Date: Descending', 'exertio_theme' ); ?></option>
								<option value="asc" <?php if($sort == 'asc'){ echo "selected"; } ?>> <?php echo __( 'Name: Ascending', 'exertio_theme' ); ?></option>
							</select>
							<?php
							if(isset($_GET) && $_GET != '')
							{
								$all_filters = $_GET;
								//print_r($all_filters);

								foreach($all_filters as $key => $value)
								{
									if($key == 'sort' || $key == 'list-style')
									{

									}
									else
									{
										if(is_array($value))
										{
											foreach($value as $key2 => $value2)
											{
												echo '<input type="hidden" name="'.$key.'[]" value="'.$value2.'">';
											}
										}
										else
										{
											echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
										}
									}
								}
							}
							echo '<input type="hidden" name="list-style" value="grid">';
							?>
						</div>
                    </form>
                </div>
            </div>
          <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
            	<?php
                    $freelancer_ad1 = fl_framework_get_options('freelancer_search_ad1');
                    if(isset($freelancer_ad1) && $freelancer_ad1 != '')
                    {
                        ?>
                        <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                            <div class="adverts">
                                <?php echo wp_return_echo($freelancer_ad1); ?>
                            </div>
                        </div>
                        <?php
                    }
				?>
            	<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                	<div class="row grid">
				<?php
					if($list_style == 'grid')
                    {
                        $list_type = 'grid_1';
                        $freelancer_list_style = fl_framework_get_options('freelancer_grid_style');
                        if(isset($freelancer_list_style) && $freelancer_list_style != '')
                        {
                            $list_type = $freelancer_list_style;
                        }
                    }
                    else if($list_style == 'list')
                    {
                        $list_type = 'list_1';
                        $freelancer_list_style = fl_framework_get_options('freelancer_listing_style');
                        if(isset($freelancer_list_style) && $freelancer_list_style != '')
                        {
                            $list_type = $freelancer_list_style;
                        }
                    }
                    else
                    {
                        $freelancer_list_style = fl_framework_get_options('freelancer_grid_style');
                        if(isset($freelancer_list_style) && $freelancer_list_style != '')
                        {
                            $list_type = $freelancer_list_style;
                        }
                    }
					if ($results->have_posts())
					{
						$layout_type = new exertio_get_freelancers_class();
						while ($results->have_posts())
						{
							$results->the_post();
							$freelancer_id = get_the_ID();
							$function = "exertio_freelancer_$list_type";

							$fetch_output = $layout_type->$function($freelancer_id);
							echo ' '.$fetch_output;
						}
					}
					else
					{
						?>
						<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 grid-item">
							<?php echo exertio_no_result_found('white'); ?> 
						</div>
						<?php
					}
					echo '</div></div>';
					$freelancer_ad2 = fl_framework_get_options('freelancer_search_ad2');
					if(isset($freelancer_ad2) && $freelancer_ad2 != '')
					{
						?>
						<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
							<div class="adverts">
								<?php echo wp_return_echo($freelancer_ad2); ?>
							</div>
						</div>
						<?php
					}
					echo '<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">';
					fl_pagination($results);
					echo '</div>';
					wp_reset_postdata();
                ?>
        </div>
        </div>
		</div>
		</div>
		<?php
        if(fl_framework_get_options('freelancer_sidebar') == 'right')
        {
            ?>
            <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 col-xl-4">
                <div class="project-sidebar">
                    <div class="heading">
                        <h4><?php echo esc_html__('Search Filters','exertio_theme'); ?></h4>
                        <?php
                            $freelancer_page = '';
                            $freelancer_page = fl_framework_get_options('freelancer_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($freelancer_page)); ?>"><?php echo esc_html__('Clear Result','exertio_theme'); ?></a>
                    </div>
                    <div class="project-widgets">
                        <form action="">
                            <?php dynamic_sidebar( 'exertio-freelancer-widgets' ); ?>
                            <div class="submit-btn">
                                <?php
                                    $sidebar_text = fl_framework_get_options('freelancer_search_sidebar_text');
                                    if(isset($sidebar_text) && $sidebar_text != '')
                                    {
                                        ?> 
                                        <p><i><?php echo esc_html($sidebar_text); ?> </i></p>
                                        <?php
                                    }
                                ?>
                                <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>">
                                <button class="btn btn-theme btn-block" type="submit"> <?php echo esc_html__('Filter Result','exertio_theme'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
  </div>
</section>