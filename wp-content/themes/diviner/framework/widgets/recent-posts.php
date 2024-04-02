<?php
// Register and load the widget
function diviner_recent_posts_widget() {
    register_widget( 'diviner_recent_posts' );
}
add_action( 'widgets_init', 'diviner_recent_posts_widget' );

// Creating the widget
class diviner_recent_posts extends WP_Widget {

    function __construct() {
        parent::__construct(

// Base ID of your widget
            'diviner_recent_posts',

// Widget name will appear in UI
            esc_html__('D - Recent Posts', 'diviner'),

// Widget description
            array( 'description' => esc_html__( 'This Widget will show Most Recent Posts. Meant for use in Sidebar Areas.', 'diviner' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {

        $title                  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $post_count 		    = isset( $instance['post_count'] ) ? $instance['post_count'] : 4;


                echo $args['before_widget'];
                if ( ! empty( $title ) )
                    echo $args['before_title'] . $title . $args['after_title'];
            ?>

                <?php
                    include get_template_directory() . '/framework/featured_areas/recent-posts.php';
                ?>

        <?php
    	   echo $args['after_widget'];

    }

// Widget Backend
    public function form( $instance ) {

        /* Set up some default widget settings. */
       $defaults = array(
           'title'              => '',
		   'post_count'         => 4,
       );
       $instance = wp_parse_args( (array) $instance, $defaults );
         ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'diviner' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>


        <p>
            <label for="<?php echo $this->get_field_id( 'post_count' ); ?>"><?php _e( 'Number of Posts:', 'diviner' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="number" value="<?php echo esc_attr( $instance['post_count'] ); ?>" />
        </p>

        <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']              =   ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['post_count']         =   ( ! empty( $new_instance['post_count'] ) ) ? absint($new_instance['post_count']) : 4;
        return $instance;
    }
}
    