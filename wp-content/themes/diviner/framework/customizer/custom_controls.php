<?php
  if (class_exists('WP_Customize_Control')) {
    class Customizer_Range_Value_Control extends WP_Customize_Control {
  	public $type = 'diviner-range-value';

  	/**
  	 * Render the control's content.
  	 *
  	 * @author soderlind
  	 * @version 1.2.0
  	 */
  	public function render_content() {
  		?>
  		<label>
  			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
  			<div class="range-slider"  style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
  				<span  style="width:100%; flex: 1 0 0; vertical-align: middle;"><input class="range-slider__range" type="range" value="<?php echo esc_attr( $this->value() ); ?>"
  																																				  <?php
  																																					$this->input_attrs();
  																																					$this->link();
  																																					?>
  				>
  				<span class="range-slider__value">0</span></span>
  			</div>
  			<?php if ( ! empty( $this->description ) ) : ?>
  			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
  			<?php endif; ?>
  		</label>
  		<?php
  	}

  	/**
  	 * Plugin / theme agnostic path to URL
  	 *
  	 * @see https://wordpress.stackexchange.com/a/264870/14546
  	 * @param string $path  file path
  	 * @return string       URL
  	 */
  	private function abs_path_to_url( $path = '' ) {
  		$url = str_replace(
  			wp_normalize_path( untrailingslashit( ABSPATH ) ),
  			home_url(),
  			wp_normalize_path( $path )
  		);
  		return esc_url_raw( $url );
  	}
  }


  class Diviner_Toggle_Control extends WP_Customize_Control {

    	/**
    	 * The type of customize control.
    	 *
    	 * @access public
    	 * @since  1.3.4
    	 * @var    string
    	 */
    	public $type = 'diviner-toggle';

    	/**
    	 * Enqueue scripts and styles.
    	 *
    	 * @access public
    	 * @since  1.0.0
    	 * @return void
    	 */

    	/**
    	 * Add custom parameters to pass to the JS via JSON.
    	 *
    	 * @access public
    	 * @since  1.0.0
    	 * @return void
    	 */
    	public function to_json() {
    		parent::to_json();

    		// The setting value.
    		$this->json['id']           = $this->id;
    		$this->json['value']        = $this->value();
    		$this->json['link']         = $this->get_link();
    		$this->json['defaultValue'] = $this->setting->default;
    	}

    	/**
    	 * Don't render the content via PHP.  This control is handled with a JS template.
    	 *
    	 * @access public
    	 * @since  1.0.0
    	 * @return void
    	 */
    	public function render_content() {}

    	/**
    	 * An Underscore (JS) template for this control's content.
    	 *
    	 * Class variables for this control class are available in the `data` JS object;
    	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
    	 *
    	 * @see    WP_Customize_Control::print_template()
    	 *
    	 * @access protected
    	 * @since  1.3.4
    	 * @return void
    	 */
    	protected function content_template() {
    		?>
    		<label class="toggle">
    			<div class="toggle--wrapper">

    				<# if ( data.label ) { #>
    					<span class="customize-control-title">{{ data.label }}</span>
    				<# } #>

    				<input id="toggle-{{ data.id }}" type="checkbox" class="toggle--input" value="{{ data.value }}" {{{ data.link }}} <# if ( data.value ) { #> checked="checked" <# } #> />
    				<label for="toggle-{{ data.id }}" class="toggle--label"></label>
    			</div>

    			<# if ( data.description ) { #>
    				<span class="description customize-control-description">{{ data.description }}</span>
    			<# } #>
    		</label>
    		<?php
    	}
    }

    class Diviner_WP_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'diviner' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );

            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                esc_html($this->label),
                $dropdown
            );
        }
    }


    class Diviner_Custom_Heading_Control extends WP_Customize_Control {

        public $type    =   'diviner-heading';

        /**
         * Render the control's content.
         */
        public function render_content() {

            printf('<label class="customize-control-heading"><h3 class="sub-section-title">%s</h3></label>', esc_html($this->label));

        }
    }


    class WP_Customize_Gallery_Control extends WP_Customize_Control
    {

        public function to_json() {
            parent::to_json();


        }
        public $type = 'diviner-image-gallery';

        public function render_content()
        {
            ?>
            <label>
                <span class="customize-control-title">
                    <?php echo esc_html($this->label); ?>
                </span>

                <?php if ($this->description) { ?>
                    <span class="description customize-control-description">
                        <?php echo wp_kses_post($this->description); ?>
                    </span>
                <?php }

                $val    =   json_decode( $this->value(), true );
                ?>

                <div class="gallery-screenshot row row-cols-<?php echo esc_attr($val['cols']) ?> clearfix">
                    <?php
                        $ids = explode(',', $val['ids']);
                        foreach ($ids as $attachment_id) {
                            $img = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                            echo '<div class="screen-thumb"><img src="' . esc_url($img[0]) . '" /></div>';
                        }
                    ?>
                </div>

                <input id="edit-gallery" class="button upload_gallery_button" type="button"
                       value="<?php esc_attr_e('Add/Edit Gallery', 'diviner') ?>"/>
                <input id="clear-gallery" class="button upload_gallery_button" type="button"
                       value="<?php esc_attr_e('Clear', 'diviner') ?>"/>
                <input type="hidden" class="gallery_values" <?php echo esc_attr($this->link()) ?>
                       value="<?php echo esc_attr($this->value()); ?>">
            </label>
            <?php
        }
    }
    
    class Diviner_Custom_Link_Control extends WP_Customize_Control {
	    
	    public $type = "diviner-link";
	    
	    public function render_content() {
		    ?>
		    <label>
		    	<div id="<?php echo $this->id ?>">
			    	<p><?php echo $this->description ?></p>
		    		<a class="button button-primary"><?php echo $this->label ?></a>
		    	</div>
		    </label>
		    <?php
	    }
    }
    
    class Diviner_Custom_Text_Control extends WP_Customize_Control {
	    
	    public $type = "diviner-custom-text";
	    
	    public function render_content() {
		    ?>
		    <label>
		    	<div id="<?php echo $this->id ?>">
			    	<p><?php echo $this->description ?></p>
		    	</div>
		    </label>
		    <?php
	    }
    }
    
    class Diviner_Upsell_Pro_Control extends WP_Customize_Control {
	    
	    public $type = "diviner-upsell-pro";
	    
	    public function render_content() {
		    ?>
		    
	    	<p id="diviner-pro-upsell">
		    	<label>
	    		<a class="upsell-pro button widefat" href="https://www.indithemes.com/product/diviner-pro" title="<?php _e('Get Diviner Pro!', 'diviner'); ?>" target="_blank"><?php _e('Show me Diviner Pro!', 'diviner') ?></a>
	    		
	    		</label>
	    	</p>
		    
		    <?php
	    }
    }
    
    class Diviner_Upsell_Links_Control extends WP_Customize_Control {
	    
	    public $type = "diviner-upsell";
	    
	    public function render_content() {
		    ?>
		    <label>
		    	<div id="theme-links">
		    		<a class="documentation custom_link button button-documentation" href="https://docs.indithemes.com/diviner" title="<?php _e('Find your way through the Theme', 'diviner'); ?>" target="_blank"><?php _e('Theme Documentation', 'diviner') ?></a>
		    		<a class="theme-demos custom_link button button-theme-page" href="https://indithemes.com/product/diviner" title="<?php _e('Check out the possibilities!', 'diviner'); ?>" target="_blank"><?php _e('Theme Demos', 'diviner') ?></a>
		    		<a class="contact-us custom_link button button-contact-us" href="mailto:mail@indithemes.com" title="<?php _e('Suggestions, Comments, Support and everything else', 'diviner'); ?>" target="_blank"><?php _e('Contact Us', 'diviner') ?></a>
		    	</div>
		    </label>
		    <?php
	    }
    }
}