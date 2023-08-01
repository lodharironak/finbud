<?php 
if ( !class_exists( 'CSF_Field_image_sizes' ) ) {
	/**
	 *
	 * Field: Image sizes.
	 *
	 * @version 1.0.0
	 * @since 1.0.0
	 */
	class CSF_Field_image_sizes extends CSF_Fields {

		/**
		 * Field constructor.
		 *
		 * @param array  $field  The field type.
		 * @param string $value  The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where  To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		/**
		 * Render field
		 *
		 * @return void
		 */
		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'chosen'      => false,
					'multiple'    => false,
					'placeholder' => '',
				)
			);

			$this->value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

			echo wp_kses_post( $this->field_before() );

			// Get the image sizes.
			global $_wp_additional_image_sizes;
			$sizes = array();

			foreach ( get_intermediate_image_sizes() as $_size ) {
				if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {

					$width  = get_option( "{$_size}_size_w" );
					$height = get_option( "{$_size}_size_h" );
					$crop   = (bool) get_option( "{$_size}_crop" ) ? 'hard' : 'soft';

					$sizes[$_size] = ucfirst( "{$_size} - $crop:{$width}x{$height}" );

				} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {

					$width  = $_wp_additional_image_sizes[$_size]['width'];
					$height = $_wp_additional_image_sizes[$_size]['height'];
					$crop   = $_wp_additional_image_sizes[$_size]['crop'] ? 'hard' : 'soft';

					$sizes[$_size] = ucfirst( "{$_size} - $crop:{$width}X{$height}" );
				}
			}
			$sizes = array_merge(
				$sizes,
				array(
					'full'   => __( 'Original uploaded image', 'woo-product-gallery-slider' ),
					'_' => __( 'Set custom size(PRO)', 'woo-product-gallery-slider' ),
				)
			);

			if ( !empty( $sizes ) ) {

				$multiple_name    = ( $args['multiple'] ) ? '[]' : '';
				$multiple_attr    = ( $args['multiple'] ) ? ' multiple="multiple"' : '';
				$chosen_rtl       = ( is_rtl() ) ? ' chosen-rtl' : '';
				$chosen_attr      = ( $args['chosen'] ) ? ' class="spf-chosen' . $chosen_rtl . '"' : '';
				$placeholder_attr = ( $args['chosen'] && $args['placeholder'] ) ? ' data-placeholder="' . $args['placeholder'] . '"' : '';

				if ( !empty( $sizes ) ) {

					echo '<select name="' . esc_attr( $this->field_name( $multiple_name ) ) . '"' . wp_kses_post( $multiple_attr . $chosen_attr . $placeholder_attr ) . $this->field_attributes() . '>'; // phpcs:ignore

					if ( $args['placeholder'] && empty( $args['multiple'] ) ) {
						if ( !empty( $args['chosen'] ) ) {
							echo '<option value=""></option>';
						} else {
							echo '<option value="">' . wp_kses_post( $args['placeholder'] ) . '</option>';
						}
					}

					foreach ( $sizes as $option_key => $option ) {

						if ( is_array( $option ) && !empty( $option ) ) {

							echo '<optgroup label="' . esc_attr( $option_key ) . '">';

							foreach ( $option as $sub_key => $sub_value ) {
								$selected = ( in_array( $sub_key, $this->value, true ) ) ? ' selected' : '';
								echo '<option value="' . esc_attr( $sub_key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $sub_value ) . '</option>';
							}
							echo '</optgroup>';
						} else {
							$selected = ( in_array( $option_key, $this->value, true ) ) ? ' selected' : '';
							echo '<option value="' . esc_attr( $option_key ) . '" ' . esc_attr( $selected ) . '>' . esc_attr( $option ) . '</option>';
						}
					}

					echo '</select>';

				} else {

					echo !empty( $this->field['empty_message'] ) ? esc_html( $this->field['empty_message'] ) : esc_html__( 'No image sizes found.', 'woo-product-gallery-slider' );

				}
			}

			echo wp_kses_post( $this->field_after() );

		}

	}
}