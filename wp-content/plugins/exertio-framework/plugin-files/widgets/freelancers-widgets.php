<?php
// Creating the widget for projects
class exertio_freelancer_keyword_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelancer_keyword_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Keyword', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by keyword widget', 'exertio_framework' ), )
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
                <input type="text" class="form-control" name="title" placeholder="<?php echo __( 'Keyword or freelancer name', 'exertio_framework' ); ?>" value="<?php echo esc_attr($title_value); ?>">
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
function exertio_freelancer_keyword_load_widget() {
    register_widget( 'exertio_freelancer_keyword_widget' );
}
add_action( 'widgets_init', 'exertio_freelancer_keyword_load_widget' );


/*FREELANCER TYPE WIDGETS*/
class exertio_freelance_type_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelance_type_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Freelancer Type', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by Freelancer type', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['freelance-type']))
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelance-type"> <?php echo esc_html($title); ?> </a> </div>
          <div id="freelance-type" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('freelance-type','freelance-type'); ?>
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

/*FREELANCER TYPE WIDGETS*/
class exertio_freelance_specialization_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelance_specialization_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Freelancer specialization', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by Specialization', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['freelancer-specialization']))
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelancer-specialization"> <?php echo esc_html($title); ?> </a> </div>
          <div id="freelancer-specialization" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('freelancer-specialization','freelancer-specialization'); ?>
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
function exertio_freelance_specialization_load_widget() {
    register_widget( 'exertio_freelance_specialization_widget' );
}
add_action( 'widgets_init', 'exertio_freelance_specialization_load_widget' );


/*ENGLISH LEVEL WIDGETS*/
class exertio_english_level_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_english_level_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By English Level', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by English Level', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#english-level"> <?php echo esc_html($title); ?> </a> </div>
          <div id="english-level" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('freelancer-english-level','english-level'); ?>
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
function exertio_english_level_load_widget() {
    register_widget( 'exertio_english_level_widget' );
}
add_action( 'widgets_init', 'exertio_english_level_load_widget' );


/*LANGUAGE WIDGETS*/
class exertio_freelancer_language_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelancer_language_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Freelancer Language', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by Freelancer Language', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelancer-language"> <?php echo esc_html($title); ?> </a> </div>
          <div id="freelancer-language" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('freelancer-languages','language'); ?>
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
function exertio_freelancer_language_load_widget() {
    register_widget( 'exertio_freelancer_language_widget' );
}
add_action( 'widgets_init', 'exertio_freelancer_language_load_widget' );

/*LOCATION WIDGETS*/
class exertio_freelancer_location_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelancer_location_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Freelancer Location', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by Freelancer Location', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelancer-location"> <?php echo esc_html($title); ?> </a> </div>
          <div id="freelancer-location" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('freelancer-locations','location'); ?>
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
function exertio_freelancer_location_load_widget() {
    register_widget( 'exertio_freelancer_location_widget' );
}
add_action( 'widgets_init', 'exertio_freelancer_location_load_widget' );

/*SKILLS WIDGETS*/
class exertio_freelancer_skills_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelancer_skills_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Skills', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by Freelancer Skills', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelancer-skills"> <?php echo esc_html($title); ?> </a> </div>
          <div id="freelancer-skills" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul class="main">
                	<?php echo exertio_get_search_terms('freelancer-skills','skill'); ?>
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
function exertio_freelancer_skills_load_widget() {
    register_widget( 'exertio_freelancer_skills_widget' );
}
add_action( 'widgets_init', 'exertio_freelancer_skills_load_widget' );

/*WIDGET FOR SERVICES PRICE RANGE*/
class exertio_freelancer_price_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_freelancer_price_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Freelancer - Filter By Price Rate', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Freelancer Search by Price Rate', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['price-min']) || isset($_GET['price-max']))
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
function exertio_freelancer_price_load_widget() {
    register_widget( 'exertio_freelancer_price_widget' );
}
add_action( 'widgets_init', 'exertio_freelancer_price_load_widget' );

/*GENDER WIDGET*/
class exertio_freelancer_gender_widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(

        // Base ID of your widget
            'exertio_freelancer_gender_widget',

            // Widget name will appear in UI
            __('Exertio Freelancer - Filter By Gender', 'exertio_framework'),

            // Widget description
            array( 'description' => __( 'Freelancer Search by Gender', 'exertio_framework' ), )
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
        $is_ad_type = '';
        $search = '';
        if(isset($instance['is_search']) && $instance['is_search'] == 'yes')
        {
            $search = 'add-search';
        }
        $is_ad_type = '';
        if (isset($_GET['gender']) && $_GET['gender'] != "") {
            if ($_GET['gender'] == '0') {
                $is_ad_type = 'male';
            }
            if ($_GET['gender'] == '1') {
                $is_ad_type = 'female';
            }
            if ($_GET['gender'] == '2') {
                $is_ad_type = 'other';
            }
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#freelancer-gender-widget"> <?php echo esc_html($title); ?> </a> </div>
            <div id="freelancer-gender-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
                <div class="panel-body ">
                    <select class="category form-control submit_on_select" name="gender" data-placeholder="<?php echo __('Select Option', 'adforest') ?>">
<!--                        <option label=""></option>-->
                        <?php
                        $conditions = array('0' => __('Male', 'exertio_theme'),'1' => __('Female', 'exertio_theme'), '2' => __('Other', 'exertio_theme'));
                        foreach ($conditions as $key => $val) {
                            ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php
                            if ($is_ad_type === $key) {
                                echo esc_attr("selected");
                            }
                            ?>>
                                <?php echo esc_html($val); ?>
                            </option>
                            <?php
                        }
                        ?>
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
function exertio_freelancer_gender_load_widget() {
    register_widget( 'exertio_freelancer_gender_widget' );
}
add_action( 'widgets_init', 'exertio_freelancer_gender_load_widget' );