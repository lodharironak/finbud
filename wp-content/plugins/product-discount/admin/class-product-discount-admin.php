<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://http://192.168.0.28/finbud/
 * @since      1.0.0
 *
 * @package    Product_Discount
 * @subpackage Product_Discount/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Product_Discount
 * @subpackage Product_Discount/admin
 * @author     Ronak  <roank@gmail.com>
 */
class Product_Discount_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->init();
	}
	public function init()
    {
    	/**
		 * By default call this function in admin side
		 *		
		 */
    	add_action('admin_menu', array($this, 'test_plugin_setup_menu'));
    	// add_action('wp_ajax_Product_Discount_Admin', array($this, 'Product_Discount_Admin'));
    	// add_action('wp_ajax_nopriv_Product_Discount_Admin', array($this, 'Product_Discount_Admin'));
    }

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-discount-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-discount-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'save_discount', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	}
	// Create a admin page in Admin panel
	public function test_plugin_setup_menu(){

		add_menu_page(
            __('Product Discount', 'Product_Discount_Admin'),
            __('Product Discount', 'Product_Discount_Admin'),
            'manage_options',
            'Product_Discount',
            array($this, 'Product_Discount_Admin'),
          	'dashicons-calculator'  	
           
        );
        add_submenu_page(
            'Product_Discount',
            __('Discount Count', 'Product_Discount_Admin'),
            __('Discount Count', 'Product_Discount_Admin'),
            'manage_options',
            'Discount Count',
            array($this, 'Product_Discount_Admin'),
        );
      
	}
	function save_discount()
	{
		$cdcoptval = get_option('custom_discount'); // Get option 
		if (isset($_POST['pronu'])) {
				
			$value = $_POST['pronu'];
			if (empty($cdcoptval)){
			
				add_option('custom_discount', $value);
				echo "Value Added Successfully";
			}
			else
			{
				if ($cdcoptval == $value) 
				{
					echo "Value Already Exists";
				}
				else
				{
					echo "Value Updated Successfully";
				}
				
				update_option('custom_discount', $value);
			}
		}
		wp_die();
	}
	// Call Back function for the Product discount
	function Product_Discount_Admin()
	{
		$cdcoptval = get_option('custom_discount'); // Get option
		?>
		<!-- Form for the Tabbing in Product Discount -->
	    <div>
	        <?php screen_icon();
	        ?>
	        <h2>Product Discount</h2>
                <nav class="nav-tab-wrapper">
				  <a href="?page=Product_Discount" class="nav-tab nav-tab-active">Simple Product</a>
				  <a href="?page=Product_Discount" class="nav-tab">Variation Product</a>
				</nav><br><br>
                    <div id="pac-container">
                        <input type="number" name="pac_input" class="pronu" placeholder="% Discount" value="<?php echo $cdcoptval?>"><br><br>
                    </div>
	            <button id="disave" type="button" name="pac_submit">Save</button>
	    </div>
	    <!-- /.wrap -->
	 	<?php
	}
}