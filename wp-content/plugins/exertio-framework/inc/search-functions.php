<?php
if (!function_exists('exertio_get_search_terms'))
{
	function exertio_get_search_terms( $texonomy_name ='', $slug_key = '')
	{
		$hierarchy ='';
		if(is_page_template( 'page-services-search.php'))
		{
			$show_have_posts = fl_framework_get_options('services_sidebar_show_all_terms');
			$count_option = fl_framework_get_options('services_sidebar_count');
		}
		else if(is_page_template( 'page-project-search.php'))
		{
			$show_have_posts = fl_framework_get_options('project_sidebar_show_all_terms');
			$count_option = fl_framework_get_options('project_sidebar_count');
		}
		else if(is_page_template( 'page-freelancer-search.php'))
		{
			$show_have_posts = fl_framework_get_options('freelancer_sidebar_show_all_terms');
			$count_option = fl_framework_get_options('freelancer_sidebar_count');
		}
		else if(is_page_template( 'page-employer-search.php'))
		{
			$show_have_posts = fl_framework_get_options('employer_sidebar_show_all_terms');
			$count_option = fl_framework_get_options('employer_sidebar_count');
		}
		$hide_empty =false;
		if($show_have_posts == 1)
		{
			$hide_empty = true;	
		}
		$taxonomies = get_terms( array(
			'taxonomy' => $texonomy_name,
			'hide_empty' => $hide_empty,
			'orderby'      => 'name',
			'parent' => 0
		) );		

		$options = '';



		$slug_value =array();
		if (isset($_GET[$slug_key]) && $_GET[$slug_key] != "")
		{
			$slug_value = $_GET[$slug_key];
		}

		foreach($taxonomies as $term)
		{
			$show_count = (isset($count_option) && $count_option == 1) ? ' ('.$term->count.')' : '';
			if(is_array( $slug_value))
			{
				if(in_array($term->term_id, $slug_value)){ $checked = 'checked ="checked"';}else{$checked = ''; }
			}
			else
			{
				if($term->term_id == $slug_value){ $checked = 'checked ="checked"';}else{$checked = ''; }
			}
			
			$termchildren = get_term_children( $term->term_id, $texonomy_name );

			$defaults_args = array(
									'format'    => 'slug',
									'separator' => ' ',
									'link'      => false,
									'inclusive' => true,
									'extra-class' => '',
								);


			//$tt = exertio_get_term_parents_list($term->term_id, $texonomy_name, $defaults_args);
			$tt = '';
			$options .='<li class="'.esc_attr($tt).'"> 
							<div class="pretty p-icon p-thick p-curve">
								<input type="checkbox" name="'.$slug_key.'[]" value="'.$term->term_id.'"  id="'.$term->term_id.'" '.$checked.'/>
								<div class="state p-warning">
									<i class="icon fa fa-check"></i>
									<label></label>
								</div>
							</div>
							<span for="'.$term->term_id.'">'.$term->name.''.$show_count.'</span>';
							
					//Parent code ends					
					if(!empty($termchildren))
					{
						$options .= exertio_get_search_terms_childs($term->term_id, $texonomy_name, $slug_key, $hide_empty, $count_option);
					}
			$options .='</li>';
			
		}	
		return $options;
	}
}

if (!function_exists('exertio_get_search_terms_childs'))
{
	function exertio_get_search_terms_childs( $term_id ='', $texonomy_name = '', $slug_key = '', $hide_empty = '', $count_option = '')
	{
			$options = '';

			$slug_value =array();
			if (isset($_GET[$slug_key]) && $_GET[$slug_key] != "")
			{
				$slug_value = $_GET[$slug_key];
			}
			$taxonomies = get_terms( array(
				'taxonomy' => $texonomy_name,
				'hide_empty' => $hide_empty,
				'orderby'      => 'name',
				'parent' => $term_id
			) );
			
					
			$options .='<ul>';
			foreach($taxonomies as $child) 
			{
			$termchildren = get_term_children( $child->term_id, $texonomy_name );

				$show_count = ($count_option == 1) ? ' ('.$child->count.')' : '';
				
				if(is_array( $slug_value))
				{
					if(in_array($child->term_id, $slug_value)){ $checked = 'checked ="checked"';}else{$checked = ''; }
				}
				else
				{
					if($child->term_id == $slug_value){ $checked = 'checked ="checked"';}else{$checked = ''; }
				}
				 
				$defaults_args = array(
									'format'    => 'slug',
									'separator' => ' ',
									'link'      => false,
									'inclusive' => true,
									'extra-class' => '',
								);


				$tt = exertio_get_term_parents_list($child->term_id, $texonomy_name, $defaults_args);
				$tt = '';
				$options .='<li  class="'.esc_attr($tt).'">
				<div class="pretty p-icon p-thick p-curve">
					<input type="checkbox" name="'.$slug_key.'[]" value="'.$child->term_id.'" id="'.$child->term_id.'" '.$checked.'/>
					<div class="state p-warning">
						<i class="icon fa fa-check"></i>
						<label></label>
					</div>
				</div>
				<span for="'.$child->term_id.'">'.$child->name.''. $show_count. '</span>';	
				
					if(!empty($termchildren) ){
						$options .= exertio_get_search_terms_childs( $child->term_id, $texonomy_name , $slug_key, $hide_empty, $count_option);
					}
				$options .='</li>';			
			}
			$options .='</ul>';

			return $options;
		
	}
}



function exertio_get_term_parents_list( $term_id, $taxonomy, $args = array() ) {
    $list = '';
    $term = get_term( $term_id, $taxonomy );
    if ( is_wp_error( $term ) ) { return $term; }
    if ( ! $term ) {return $list; }
    $term_id = $term->term_id;
    $defaults = array( 'format'    => 'name', 'separator' => '/', 'link'      => true,  'inclusive' => true, );
    $args = wp_parse_args( $args, $defaults );
 
    foreach ( array( 'link', 'inclusive' ) as $bool ) {
        $args[ $bool ] = wp_validate_boolean( $args[ $bool ] );
    }
    $parents = get_ancestors( $term_id, $taxonomy, 'taxonomy' );
    if ( $args['inclusive'] ) { array_unshift( $parents, $term_id ); }
    $extra_class = ( isset($args['extra-class']) && $args['extra-class'] != "") ? $args['extra-class'] : "";
    foreach ( array_reverse( $parents ) as $term_id ) {
        $parent = get_term( $term_id, $taxonomy );
        $name   = ( 'slug' === $args['format'] ) ? $parent->slug : $parent->name;
        if ( $args['link'] ) {
            $list .= '<a href="' . esc_url( get_term_link( $parent->term_id, $taxonomy ) ) . '">' . $name . '</a>' . $args['separator'];
        } else {            
            $list .= $extra_class.$name . $args['separator'];
        }
    }
 
    return $list;
}


    

if (!function_exists('exertio_multiquery_checkboxes'))
{
    function exertio_multiquery_checkboxes($args = array(), $get_key = '', $search_key = '') {
		$args = array();
		if (is_array($_GET[$get_key]) && count($_GET[$get_key]) > 1) {
			$args['relation'] = 'OR';
		}
		if (is_array($_GET[$get_key]) && count($_GET[$get_key]) > 0)
		{
			foreach ($_GET[$get_key] as $fetch_key => $fetch_value)
			{
				$args[] = array(
					'key' => $search_key,
					'value' => $fetch_value,
					'compare' => '=',
				);
			}
		}
        return $args;
    }
}
