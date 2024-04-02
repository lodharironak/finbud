<?php
// Register and load the widget
function diviner_fp_slider_widget() {
    register_widget( 'diviner_fp_slider' );
}
add_action( 'widgets_init', 'diviner_fp_slider_widget' );

// Creating the widget
class diviner_fp_slider extends WP_Widget {

    function __construct() {
        parent::__construct(

// Base ID of your widget
            'diviner_fp_slider',

// Widget name will appear in UI
            esc_html__('D - Posts Slider', 'diviner'),

// Widget description
            array( 'description' => esc_html__( 'This Widget will show a Featured Posts Slider.', 'diviner' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {

        $title                          = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $post_count                     = isset( $instance['post_count'] ) ? $instance['post_count'] : 2;
        $category_slider		        = isset( $instance['category_slider'] ) ? $instance['category_slider'] : 0;
        $enable_title                   = isset( $instance['enable_title'] ) ? $instance['enable_title'] : 1;
        ?>

            <?php
                echo $args['before_widget'];
                if ( ! empty( $title || $instance['enable_title'] == '' ) )
                    echo $args['before_title'] . $title . $args['after_title'];
            ?>

            <div class="row no-gutters">
                    <?php
                    include get_template_directory() . '/framework/featured_areas/posts-slider.php';
                    ?>
            </div>
            <?php
        	   echo $args['after_widget'];
    }


// Widget Backend
    public function form( $instance ) {

        /* Set up some default widget settings. */
       $defaults = array(
           'title'              => esc_html__( 'Featured Posts Slider', 'diviner' ),
           'post_count'         => 2,
           'category_slider'    => 0,
           'enable_title'       => 1
       );
       $instance = wp_parse_args( (array) $instance, $defaults );
         ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'diviner' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>


        <h3><?php esc_html_e('Slider', 'diviner'); ?></h3>

        <p>
            <label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Number of Posts:', 'diviner' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="number" value="<?php echo esc_attr( $instance['post_count'] ); ?>" />
        </p>

        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category_slider' ) ); ?>"><?php _e('Category for Slider:', 'diviner'); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category_slider' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category_slider' ) ); ?>">
				<option value="0" <?php if ( !$instance['category_slider'] ) echo 'selected="selected"'; ?>><?php _e('--None--', 'diviner'); ?></option>
				<?php
				$categories = get_categories(array('type' => 'post'));

				foreach( $categories as $cat ) {
					echo '<option value="' . esc_attr( $cat->cat_ID ) . '"';

					if ( $cat->cat_ID == $instance['category_slider'] ) echo  ' selected="selected"';

					echo '>' . esc_html( $cat->cat_name . ' (' . $cat->category_count . ')' );

					echo '</option>';
				}
				?>
			</select>
		</p>

        <p>
            <label for="<?php echo $this->get_field_id( 'enable_title' ); ?>"><?php _e( 'Enable the Posts Title Area', 'diviner' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'enable_title' ); ?>" name="<?php echo $this->get_field_name( 'enable_title' ); ?>" type="checkbox" value="1" <?php checked( $instance['enable_title'], 1 ); ?> />
        </p>


    <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']      		=   ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['post_count']      	=   ( ! empty( $new_instance['post_count'] ) ) ? (int)$new_instance['post_count'] : 2;
        $instance['category_slider']   	=   ( ! empty( $new_instance['category_slider'] ) ) ? (int)$new_instance['category_slider'] : 0;
        $instance['enable_title']      	=   ( ! empty( $new_instance['enable_title'] ) ) ? diviner_sanitize_checkbox($new_instance['enable_title']) : 1;
        return $instance;
    }
} // Class post author ends here
