<?php
// Register and load the widget
function diviner_fp_grid_widget() {
    register_widget( 'diviner_fp_grid' );
}
add_action( 'widgets_init', 'diviner_fp_grid_widget' );

// Creating the widget
class diviner_fp_grid extends WP_Widget {

    function __construct() {
        parent::__construct(

// Base ID of your widget
            'diviner_fp_grid',

// Widget name will appear in UI
            esc_html__('D - Featured Posts 2 x 2', 'diviner'),

// Widget description
            array( 'description' => esc_html__( 'This Widget will show posts in a 2 Column Grid.', 'diviner' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {

        $title                  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $category 		        = isset( $instance['category'] ) ? $instance['category'] : 0;
        ?>


            <?php
                echo $args['before_widget'];
                if ( ! empty( $title ) )
                    echo $args['before_title'] . $title . $args['after_title'];
            ?>

            <div class="row">
                <?php
                    include get_template_directory() . '/framework/featured_areas/featured-posts-grid.php';
                ?>
            </div>

        <?php
    	   echo $args['after_widget'];
        ?>

    <?php
    }

// Widget Backend
    public function form( $instance ) {

        /* Set up some default widget settings. */
       $defaults = array(
           'title'              => esc_html__( 'Featured Posts Area', 'diviner' ),
           'category'           => 0,
       );
       $instance = wp_parse_args( (array) $instance, $defaults );
         ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'diviner' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>


        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e('Category:', 'diviner'); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<option value="0" <?php if ( !$instance['category'] ) echo 'selected="selected"'; ?>><?php _e('--None--', 'diviner'); ?></option>
				<?php
				$categories = get_categories(array('type' => 'post'));

				foreach( $categories as $cat ) {
					echo '<option value="' . esc_attr( $cat->cat_ID ) . '"';

					if ( $cat->cat_ID == $instance['category'] ) echo  ' selected="selected"';

					echo '>' . esc_html( $cat->cat_name . ' (' . $cat->category_count . ')' );

					echo '</option>';
				}
				?>
			</select>
		</p>

        <?php
    }


    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']      =   ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : ''; '';
        $instance['category']           =   ( ! empty( $new_instance['category'] ) ) ? (int)$new_instance['category'] : 0;
        return $instance;
    }
}