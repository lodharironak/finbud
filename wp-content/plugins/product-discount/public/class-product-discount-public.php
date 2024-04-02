<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://http://192.168.0.28/finbud/
 * @since      1.0.0
 *
 * @package    Product_Discount
 * @subpackage Product_Discount/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Product_Discount
 * @subpackage Product_Discount/public
 * @author     Ronak  <roank@gmail.com>
 */
class Product_Discount_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}	
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Discount_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Discount_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-discount-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Discount_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Discount_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-discount-public.js', array( 'jquery' ), $this->version, false );

	}
	public function custom_price_format($price, $product){
		$val = get_option('custom_discount');

		// Main price
		$regular_price = $product->is_type('variable') ? $product->get_variation_regular_price( 'min', true ) : $product->get_regular_price();
		$sale_price = $product->is_type('variable') ? $product->get_variation_sale_price( 'min', true ) : $product->get_sale_price();

	   	// Percentage calculated
		// $percentage = round( ( $regular_price / 100 ) * $val ).'%';
		$percentage = round( ( $regular_price / 100 ) * $val ).'%';
	    $percentage_txt =  $regular_price - $percentage; 
	    return $percentage_txt;
	}
}
