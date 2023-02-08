<?php
// Creating the widget for services keyword 
class exertio_services_keyword_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_keyword_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By Keyword', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by keyword widget', 'exertio_framework' ), ) 
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
// Class exertio_services_keyword_widget ends here
} 
 
 
// Register and load the widget
function exertio_services_keyword_load_widget() {
    register_widget( 'exertio_services_keyword_widget' );
}
add_action( 'widgets_init', 'exertio_services_keyword_load_widget' );


/*WIDGET FOR SERVICES CATEGORY*/

// Creating the widget for services keyword 
class exertio_services_category_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_category_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By Category', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by category', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = ''; 
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['categories']))
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
                <ul>
                	<?php
					echo exertio_get_search_terms('service-categories','categories')
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
function exertio_services_category_load_widget() {
    register_widget( 'exertio_services_category_widget' );
}
add_action( 'widgets_init', 'exertio_services_category_load_widget' );

/*WIDGET FOR SERVICES ENGLISH LEVEL*/

// Creating the widget for services keyword 
class exertio_services_english_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_english_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By English Level', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by English Level', 'exertio_framework' ), ) 
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
                <ul>
                	<?php
					echo exertio_get_search_terms('services-english-level','english-level')
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
function exertio_services_english_load_widget() {
    register_widget( 'exertio_services_english_widget' );
}
add_action( 'widgets_init', 'exertio_services_english_load_widget' );

/*WIDGET FOR SERVICES RESPONSE TIME*/

class exertio_services_response_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_response_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By Response Time', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by Response time', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['response-time']))
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#response-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="response-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul>
                	<?php
					echo exertio_get_search_terms('response-time','response-time')
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
function exertio_services_response_load_widget() {
    register_widget( 'exertio_services_response_widget' );
}
add_action( 'widgets_init', 'exertio_services_response_load_widget' );

/*WIDGET FOR SERVICES DELIVERY TIME*/

class exertio_services_delivery_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_delivery_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By Delivery Time', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by Delivery time', 'exertio_framework' ), ) 
		);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		$collapsed = 'collapsed';
		$show = '';
		if(isset($instance['is_collaspe']) && $instance['is_collaspe'] == 'open' || isset($_GET['delivery-time']))
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#delivery-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="delivery-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul>
                	<?php
					echo exertio_get_search_terms('delivery-time','delivery-time')
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
function exertio_services_delivery_load_widget() {
    register_widget( 'exertio_services_delivery_widget' );
}
add_action( 'widgets_init', 'exertio_services_delivery_load_widget' );

/*WIDGET FOR SERVICES LOCATION*/

class exertio_services_location_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_location_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By Location', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by Location', 'exertio_framework' ), ) 
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
          <div class="panel-heading active"> <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-bs-toggle="collapse" href="#location-widget"> <?php echo esc_html($title); ?> </a> </div>
          <div id="location-widget" class="panel-collapse collapse <?php echo esc_attr($show); ?>" role="tabpanel" >
            <div class="panel-body <?php echo esc_attr($search); ?>">
                <ul>
                	<?php
					echo exertio_get_search_terms('services-locations','location')
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
function exertio_services_location_load_widget() {
    register_widget( 'exertio_services_location_widget' );
}
add_action( 'widgets_init', 'exertio_services_location_load_widget' );

/*WIDGET FOR SERVICES PRICE RANGE*/
class exertio_services_price_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
		  
		// Base ID of your widget
		'exertio_services_price_widget', 
		  
		// Widget name will appear in UI
		__('Exertio Services - Filter By Price', 'exertio_framework'), 
		  
		// Widget description
		array( 'description' => __( 'Services Search by Price', 'exertio_framework' ), ) 
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
		  <input class="widefat" class="<?php echo esc_attr($this->get_field_id( 'min_range' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'min_range' )); ?>" type="text" value="<?php echo esc_attr( $min_range ); ?>" />
        </div>
        <div class="form-group">
		  <label for="<?php echo esc_attr($this->get_field_id( 'max_range' )); ?>">
			<?php echo __( 'Maximum Range', 'exertio_framework' ); ?>
		  </label>
		  <input class="widefat" class="<?php echo esc_attr($this->get_field_id( 'max_range' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_range' )); ?>" type="text" value="<?php echo esc_attr( $max_range ); ?>" />
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
function exertio_services_price_load_widget() {
    register_widget( 'exertio_services_price_widget' );
}
add_action( 'widgets_init', 'exertio_services_price_load_widget' );
