<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://webtechsofts.com/
 * @since      1.0.0
 *
 * @package    Visa_Order
 * @subpackage Visa_Order/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Visa_Order
 * @subpackage Visa_Order/admin
 * @author     Web Tech Softs <info@webtechsofts.com>
 */
class Visa_Order_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Visa_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Visa_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/visa-order-admin.css', array(), $this->version, 'all' );

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
		 * defined in Visa_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Visa_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/visa-order-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add countries list in product table.
	 *
	 * @since    1.0.0
	 */
	public function woocommerce_product_options_general_product_data_function() {
        global $woocommerce;
        $countries_obj   = new WC_Countries();
        $countries   = $countries_obj->__get('countries');
        ?>
        <div class="product_custom_field">
            <p class="form-field country_list_field ">
                <label for="country_list">Sale price ($)</label>
                <select name="country_list" id="country_list">
                    <option value="">Select Country</option>
                    <?php foreach ($countries as $single) {?>
                        <option value="<?php echo $single; ?>"><?php echo $single; ?></option>
                    <?php } ?>
                </select>
            </p>
        </div>
        <?php
	}

	/**
	 * save countries from products table.
	 *
	 * @since    1.0.0
	 */
	public function woocommerce_admin_process_product_object_function($product) {
        if (isset($_POST['country_list']))
            $product->update_meta_data('country_list', sanitize_text_field($_POST['country_list']));
	}

}
