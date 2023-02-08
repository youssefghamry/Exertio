<?php
// Creating the widget for projects
class exertio_projects_keyword_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_projects_keyword_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Keyword', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Prokject Search by keyword widget', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		$title_value = '';
		if (isset($_GET['title']) && $_GET['title'] != "")
		{
			$title_value = $_GET['title'];
		}
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['title']))
		{
			$collapsed = '';
			$show = 'show';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#search-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="search-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body">
              <div class="form-group">
                <input type="text" class="form-control" name="title" placeholder="<?php echo __( 'What are you looking for', 'exertio_framework' ); ?>" value="<?php echo esc_attr($title_value); ?>">
              </div>
            </div>
          </div>
        </div>
		<?php
	}
			  
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		
		// Widget admin form
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title:', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
          </div>
          <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		return $instance;
	}
// Class exertio_project_keyword_widget ends here
} 
 
// Register and load the widget
function exertio_projects_keyword_load_widget() {
    register_widget( 'exertio_projects_keyword_widget' );
}
add_action( 'widgets_init', 'exertio_projects_keyword_load_widget' );


/*CATEGORY WIDGETS*/
class exertio_project_category_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_category_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Category', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by category', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['category']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#category-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="category-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php
					echo exertio_get_search_terms('project-categories','category')
					?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_category_load_widget() {
    register_widget( 'exertio_project_category_widget' );
}
add_action( 'widgets_init', 'exertio_project_category_load_widget' );



/*FREELANCER TYPE*/

class exertio_project_freelncer_type_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_freelncer_type_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Freelancer Type', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by freelancer type', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['freelancer-type']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelancer-type-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="freelancer-type-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php
					echo exertio_get_search_terms('freelancer-type','freelancer-type')
					?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_freelncer_type_load_widget() {
    register_widget( 'exertio_project_freelncer_type_widget' );
}
add_action( 'widgets_init', 'exertio_project_freelncer_type_load_widget' );





/*WIDGET FOR PROJECT PRICE RANGE*/
class exertio_projects_price_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_projects_price_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Price', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Price', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open'  || isset($_GET['price-min']) || isset($_GET['price-max']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$price_min ='';
		if(isset($_GET['price-min']) && $_GET['price-min'] !='')
		{
			$price_min = $_GET['price-min'];	
		}
		$price_max ='';
		if(isset($_GET['price-max']) && $_GET['price-max'] !='')
		{
			$price_max = $_GET['price-max'];	
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#price-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="price-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body">
                <div class="range-slider">
                    <input type="text" class="services-range-slider" value="" data-min="<?php echo esc_attr($instance['min_range']); ?>" data-max="<?php echo esc_attr($instance['max_range']); ?>" data-from="<?php echo esc_attr($price_min); ?>" data-to="<?php echo esc_attr($price_max); ?>"/>
                </div>
                <div class="extra-controls">
                    <input type="text" class="services-input-from form-control" value="<?php echo esc_attr($price_min); ?>" name="price-min"/>
                    <input type="text" class="services-input-to form-control" value="<?php echo esc_attr($price_max); ?>"  name="price-max"/>
                </div>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		
		if ( isset( $instance[ 'min_range' ] ) )
		{
			$min_range = $instance[ 'min_range' ];
		}
		else
		{
			$min_range = __( '0', 'exertio_framework' );
		}
		
		if ( isset( $instance[ 'max_range' ] ) )
		{
			$max_range = $instance[ 'max_range' ];
		}
		else
		{
			$max_range = __( '100', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'min_range' )); ?>">
			<?php echo __( 'Minimum Range', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'min_range' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'min_range' )); ?>" type="text" value="<?php echo esc_attr( $min_range ); ?>" />
        </div>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'max_range' )); ?>">
			<?php echo __( 'Maximum Range', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_range' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_range' )); ?>" type="text" value="<?php echo esc_attr( $max_range ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['min_range'] = ( ! empty( $new_instance['min_range'] ) ) ? strip_tags( $new_instance['min_range'] ) : '';
		$instance['max_range'] = ( ! empty( $new_instance['max_range'] ) ) ? strip_tags( $new_instance['max_range'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_projects_price_load_widget() {
    register_widget( 'exertio_projects_price_widget' );
}
add_action( 'widgets_init', 'exertio_projects_price_load_widget' );



/*PROJECT DURATION*/

class exertio_project_duration_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_duration_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Duration', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Duration', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['project-duration']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#project-duration-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="project-duration-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php
					echo exertio_get_search_terms('project-duration','project-duration')
					?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_duration_load_widget() {
    register_widget( 'exertio_project_duration_widget' );
}
add_action( 'widgets_init', 'exertio_project_duration_load_widget' );


/*PROJECT LEVEL*/

class exertio_project_level_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_level_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Level', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Level', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['project-level']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#project-level-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="project-level-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('project-level','project-level'); ?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_level_load_widget() {
    register_widget( 'exertio_project_level_widget' );
}
add_action( 'widgets_init', 'exertio_project_level_load_widget' );


/*PROJECT ENGLISH LEVEL*/

class exertio_project_english_level_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_english_level_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By English Level', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by English Level', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['english-level']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#english-level-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="english-level-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php
					echo exertio_get_search_terms('english-level','english-level')
					?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_english_level_load_widget() {
    register_widget( 'exertio_project_english_level_widget' );
}
add_action( 'widgets_init', 'exertio_project_english_level_load_widget' );

/*PROJECT LOCATION*/
class exertio_project_locations_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_locations_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Location', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Location', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['location']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#locations-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="locations-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('locations','location'); ?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_locations_load_widget() {
    register_widget( 'exertio_project_locations_widget' );
}
add_action( 'widgets_init', 'exertio_project_locations_load_widget' );

/*PROJECT SKILLS*/
class exertio_project_skills_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_skills_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Skills', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Skills', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['skill']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#skills-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="skills-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('skills','skill'); ?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_skills_load_widget() {
    register_widget( 'exertio_project_skills_widget' );
}
add_action( 'widgets_init', 'exertio_project_skills_load_widget' );

/*PROJECT SKILLS*/
class exertio_project_languages_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_languages_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Languages', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Languages', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['language']))
		{
			$collapsed = '';
			$show = 'show';
		}
		$search = '';
		if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
		{
			$search = 'add-search';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#languages-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="languages-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('languages','language'); ?>
                </ul>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		<div class="form-group">
			<label for="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>">
			<?php echo __( 'Want to allow search in list?', 'exertio_framework' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_search' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_search' )); ?>">
				<option value="yes" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'yes') { echo 'selected'; } ?>> <?php echo __( 'Yes', 'exertio_framework' ); ?></option>
				<option value="no" <?php if(isset($instance['is_search']) && $instance['is_search'] == 'no') { echo 'selected'; } ?>><?php echo __( 'No', 'exertio_framework' ); ?></option>
			</select>
		</div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		$instance['is_search'] = ( ! empty( $new_instance['is_search'] ) ) ? strip_tags( $new_instance['is_search'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_languages_load_widget() {
    register_widget( 'exertio_project_languages_widget' );
}
add_action( 'widgets_init', 'exertio_project_languages_load_widget' );


/*PROJECT PRICES TYPE*/
class exertio_project_price_type_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_project_price_type_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Projects - Filter By Price Type', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Projects Search by Price Type', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['language']))
		{
			$collapsed = '';
			$show = 'show';
		}
		?>
        <div class="panel panel-default">
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#price-type-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="price-type-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body">
            	<?php
					$price_type = '';
					if(isset($_GET['price-type']) && $_GET['price-type'] !='')
					{
						$price_type = $_GET['price-type'];
					}
					
                ?>
                <select class="default-select" name="price-type">
                	<option value=""><?php echo __( 'Select price type', 'exertio_framework' ); ?></option>
                    <option value="1" <?php if($price_type == 'fixed' || $price_type == 1) { echo 'selected="selected"'; } ?>><?php echo __( 'Fixed Price', 'exertio_framework' ); ?></option>
                    <option value="2" <?php if($price_type == 'hourly' || $price_type == 2) { echo 'selected="selected"'; } ?>><?php echo __( 'Hourly Price', 'exertio_framework' ); ?></option>
                </select>
            </div>
          </div>
        </div>
		<?php
	}
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) )
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = __( 'New title', 'exertio_framework' );
		}
		// Widget admin form
		
		?>
		<p>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
          	<option value="close" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'close') { echo 'selected'; } ?>> <?php echo __( 'Close', 'exertio_framework' ); ?></option>
            <option value="open" <?php if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open') { echo 'selected'; } ?>><?php echo __( 'Open', 'exertio_framework' ); ?></option>
          </select>
         </div>
		</p>
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['is_collaspe'] = ( ! empty( $new_instance['is_collaspe'] ) ) ? strip_tags( $new_instance['is_collaspe'] ) : '';
		return $instance;
	}
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_project_price_type_load_widget() {
    register_widget( 'exertio_project_price_type_widget' );
}
add_action( 'widgets_init', 'exertio_project_price_type_load_widget' );