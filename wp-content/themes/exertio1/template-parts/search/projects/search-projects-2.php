<?php
$sort = '';
if (isset($_GET['sort']) && $_GET['sort'] != "")
{
	$sort = $_GET['sort'];
}
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
	$actionbar_space = 'actionbar_space';
}

?>
<section class="fr-list-side-bar section-padding bg-gray-light-color  actionbar_space exer-search-demand">
    <div class="container-fluid">
        <div class="row demand-add-padding">
            <div class="prj-sidebar-main">
                <div class="project-sidebar add-change">
                    <div class="heading">
                        <h4><?php echo esc_html__('Search Filters','exertio_theme'); ?></h4>
                        <?php
                        $project_page = '';
                        $project_page = fl_framework_get_options('project_search_page');
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($project_page)); ?>"><?php echo esc_html__('Clear Result','exertio_theme'); ?></a>
                    </div>
                    <div class="project-widgets">
                        <form action="<?php echo get_the_permalink(fl_framework_get_options('project_search_page')); ?>">
                            <?php dynamic_sidebar( 'exertio-project-widgets' ); ?>
                            <div class="submit-btn">
                                <?php
                                $sidebar_text = fl_framework_get_options('project_search_sidebar_text');
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
            <div class="exer-find-freelancer">
                <div class="services-filter-2">
                    <form>
                        <div class="heading-area">
                            <h4><?php echo esc_html__('Found ','exertio_theme'). $results->found_posts. esc_html__(' Results ','exertio_theme'); ?> </h4>
                        </div>
                        <div class="filters">
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
                            ?>
                        </div>
                    </form>
                </div>
            <?php
            if ($results->have_posts())
            {
                $list_type = 'list_1';
                $project_list_style = fl_framework_get_options('project_listing_style');
                if(isset($project_list_style) && $project_list_style != '')
                {
                    $list_type = $project_list_style;
                }

                $layout_type = new exertio_get_projects();
                while ($results->have_posts())
                {
                    echo '<div class="fr-right-detail-box-full">';
                    $results->the_post();
                    $project_id = get_the_ID();


                    $function = "exertio_projects_$list_type";

                    $fetch_output = $layout_type->$function($project_id);

                    echo ' '.$fetch_output . '</div>';
                }
                echo '<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">';
                fl_pagination($results);
                echo '</div>';
                wp_reset_postdata();
            }
            else
            {
                ?>
                <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <?php echo exertio_no_result_found('white'); ?>
                </div>
                <?php
            }
            ?>
        </div>
            <button class="close_project_detail">&#x2715</button>
            <div class="exer-fr-dtl-main">
                <div class="detail_loader" style="position: relative">
                    <div class="loader-outer" style="display: none;">
                        <div class="loading-inner">
                            <div class="loading-inner-meta">
                                <div> </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
                    <?php echo exertio_find_results_ajax('white'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
