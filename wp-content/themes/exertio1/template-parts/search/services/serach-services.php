<?php
$title_value = $cat_value = $sort = $list_style = '' ;
$cat_value = [];
if (isset($_GET['title']) && $_GET['title'] != "")
{
	$title_value = $_GET['title'];
}
if (isset($_GET['categories']) && $_GET['categories'] != "")
{
	$cat_value = $_GET['categories'];
}
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
<section class="fr-services-serch bg-gray-light-color">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-xs-12 col-xl-12 col-sm-12 col-md-12">
        <form  action="<?php echo get_the_permalink(fl_framework_get_options('services_search_page')); ?>">
          <div class="fr-serices-content">
            <ul>
              <li>
                <div class="form-group">
                  <input type="text" placeholder="<?php echo esc_attr__( 'What are you looking for?', 'exertio_theme' ); ?>" class="form-control" name="title" value="<?php echo esc_attr($title_value); ?>">
                </div>
              </li>
                <li>
                    <select class="multi_select" name="categories[]">
                        <option value=""> <?php echo __( 'Select Category', 'exertio_theme' ); ?> </option>
                        <?php echo get_hierarchical_terms('service-categories','', $cat_value ); ?>
                    </select>
                </li>
              <li> <button type="submit" class="btn btn-style btn-block"><?php echo __( 'Search', 'exertio_theme' ); ?></button> </li>
            </ul>
            </div>
            <?php
				if(isset($_GET) && $_GET != '')
				{
					$all_filters = $_GET;

					
					foreach($all_filters as $key => $value)
					{
						if($key == 'title')
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
			?>
        </form>
      </div>
    </div>
  </div>
</section>


<section class="fr-top-srvices section-padding padding-top-bottom-3 bg-gray-light-color  <?php echo esc_attr($actionbar_space); ?>">
  <div class="container">
    <div class="row">
    	<?php
		$sidebar_postion = '';
		$sidebar_postion = fl_framework_get_options('service_sidebar');
		if(isset($sidebar_postion) & $sidebar_postion == 'left')
		{
			?>
            <div class="col-xl-4 col-xs-12 col-sm-12 col-md-12">
                <div class="service-side position-sticky">
                    <div class="heading">
                        <h4><?php echo esc_html__('Search Filters','exertio_theme'); ?></h4>
                        <?php
                            $services_page = '';
                            $services_page = fl_framework_get_options('services_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($services_page)); ?>"><?php echo esc_html__('Clear Result','exertio_theme'); ?></a>
                    </div>
                    <div class="service-widget">
                    <form action="<?php echo get_the_permalink(fl_framework_get_options('services_search_page')); ?>">
                        <?php dynamic_sidebar( 'exertia-services-widgets' ); ?>
                        <div class="submit-btn">
                            <?php
                                $sidebar_text = fl_framework_get_options('sevices_search_sidebar_text');
                                if(isset($sidebar_text) && $sidebar_text != '')
                                {
                                    ?> 
                                    <p><i><?php echo esc_html($sidebar_text); ?> </i></p>
                                    <?php
                                }
                            ?>
                            <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>">
                            <input type="hidden" name="list-style" value="<?php echo esc_attr($list_style); ?>">
                            <button class="btn btn-theme btn-block" type="submit"> <?php echo esc_html__('Filter Result','exertio_theme'); ?></button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <?php
		}
		?>
        <div class="col-xl-8 col-xs-12 col-sm-12 col-md-12">
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
                                                <a href="javascript:void(0)" class="services-grid-icon protip <?php echo esc_attr($grid_active); ?> list-style" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Grid View', 'exertio_theme' ); ?>" data-list-style="grid">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </a>
                                            </li>
                                        </ul>
                                    <select class="default-select" name="sort" id="order_by">
                                        <option value=""><?php echo __( 'Sort by', 'exertio_theme' ); ?></option>
                                        <option value="new-old" <?php if($sort == 'new-old'){ echo "selected"; } ?>> <?php echo __( 'Date: New to old', 'exertio_theme' ); ?></option>
                                        <option value="old-new" <?php if($sort == 'old-new'){ echo "selected"; } ?>> <?php echo __( 'Date: Old to new', 'exertio_theme' ); ?></option>
                                    </select>
                                    <?php
                                    if(isset($_GET) && $_GET != '')
                                    {
                                        $all_filters = $_GET;
                                        
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
                <?php
					$service_ad1 = fl_framework_get_options('sevices_search_ad1');
					if(isset($service_ad1) && $service_ad1 != '')
					{
						?>
						<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
							<div class="adverts">
								<?php echo wp_return_echo($service_ad1); ?>
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
                        $servicce_list_style = fl_framework_get_options('service_grid_style');
                        if(isset($servicce_list_style) && $servicce_list_style != '')
                        {
                            $list_type = $servicce_list_style;
                        }
                    }
                    else if($list_style == 'list')
                    {
                        $list_type = 'list_1';
                        $servicce_list_style = fl_framework_get_options('service_listing_style');
                        if(isset($servicce_list_style) && $servicce_list_style != '')
                        {
                            $list_type = $servicce_list_style;
                        }
                    }
                    else
                    {
                        $servicce_list_style = fl_framework_get_options('service_grid_style');
                        if(isset($servicce_list_style) && $servicce_list_style != '')
                        {
                            $list_type = $servicce_list_style;
                        }
                    }
                    
                    
                    if ($results->have_posts())
                    {
                        $layout_type = new exertio_get_services();
                        while ($results->have_posts())
                        {
                            $results->the_post();
                            $service_id = get_the_ID();
                            $function = "exertio_listings_$list_type";
                            $fetch_output = $layout_type->$function($service_id);
                            echo ' '.$fetch_output;
                        }
						
                        wp_reset_postdata();
                    }
                    else
                    {
						?>
                        <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 grid-item">
                        	<?php echo exertio_no_result_found('white'); ?> 
                        </div>
                        <?php
                    }
					$service_ad2 = fl_framework_get_options('sevices_search_ad2');
					if(isset($service_ad2) && $service_ad2 != '')
					{
						?>
						<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 grid-item">
							<div class="adverts">
								<?php echo wp_return_echo($service_ad2); ?>
							</div>
						</div>
						<?php
					}
					echo '<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12 grid-item">';
					fl_pagination($results);
					echo '</div>';
                ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($sidebar_postion) & $sidebar_postion == 'right')
		{
			?>
            <div class="col-xl-4 col-xs-12 col-sm-4 col-md-4">
                <div class="service-side position-sticky">
                    <div class="heading">
                        <h4><?php echo esc_html__('Search Filters','exertio_theme'); ?></h4>
                        <?php
                            $services_page = '';
                            $services_page = fl_framework_get_options('services_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($services_page)); ?>"><?php echo esc_html__('Clear Result','exertio_theme'); ?></a>
                    </div>
                    <div class="service-widget">
                    <form action="<?php echo get_the_permalink(fl_framework_get_options('services_search_page')); ?>">
                        <?php dynamic_sidebar( 'exertia-services-widgets' ); ?>
                        <div class="submit-btn">
                            <?php
                                $sidebar_text = fl_framework_get_options('sevices_search_sidebar_text');
                                if(isset($sidebar_text) && $sidebar_text != '')
                                {
                                    ?> 
                                    <p><i><?php echo esc_html($sidebar_text); ?> </i></p>
                                    <?php
                                }
                            ?>
                            <input type="hidden" name="sort" value="<?php echo esc_attr($sort); ?>">
                            <input type="hidden" name="list-style" value="<?php echo esc_attr($list_style); ?>">
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