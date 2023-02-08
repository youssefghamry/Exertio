<?php
// Creating the widget for projects
class exertio_employer_keyword_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_employer_keyword_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Employer - Filter By Keyword', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Employer Search by keyword widget', 'exertio_framework' ), ) 
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
                <input type="text" class="form-control" name="title" placeholder="<?php echo __( 'Keyword or employer name', 'exertio_framework' ); ?>" value="<?php echo esc_attr($title_value); ?>">
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
function exertio_employer_keyword_load_widget() {
    register_widget( 'exertio_employer_keyword_widget' );
}
add_action( 'widgets_init', 'exertio_employer_keyword_load_widget' );


/*DEPARTMENTS WIDGETS*/
class exertio_employer_department_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_employer_department_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Employer - Filter By Category', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Employer Search by department', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#department-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="department-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('departments','department'); ?>
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
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo  esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </div>
        <div class="form-group">
        	<label for="<?php echo  esc_attr($this->get_field_id( 'is_collaspe' )); ?>">
			<?php echo __( 'Widget state open or closed', 'exertio_framework' ); ?>
		  </label>
          <select class="widefat" id="<?php echo  esc_attr($this->get_field_id( 'is_collaspe' )); ?>" name="<?php echo  esc_attr($this->get_field_name( 'is_collaspe' )); ?>">
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
function exertio_employer_department_load_widget() {
    register_widget( 'exertio_employer_department_widget' );
}
add_action( 'widgets_init', 'exertio_employer_department_load_widget' );


/*NO OF EMPLOYEES WIDGETS*/
class exertio_employer_count_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_employer_count_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Employer - Filter By No of Employees', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Employer Search by Number of Emplyees', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#employer-count-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="employer-count-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('employees-number','no-of-employees'); ?>
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
		  <label for="<?php echo  esc_attr($this->get_field_id( 'title' )); ?>">
			<?php echo __( 'Title', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" id="<?php echo  esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo  esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
function exertio_employer_count_load_widget() {
    register_widget( 'exertio_employer_count_widget' );
}
add_action( 'widgets_init', 'exertio_employer_count_load_widget' );


/*NO OF EMPLOYEES WIDGETS*/
class exertio_employer_location_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_employer_location_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Employer - Filter By Location', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Employer Search by Location', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#employer-location-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="employer-location-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('employer-locations','location'); ?>
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
function exertio_employer_location_load_widget() {
    register_widget( 'exertio_employer_location_widget' );
}
add_action( 'widgets_init', 'exertio_employer_location_load_widget' );