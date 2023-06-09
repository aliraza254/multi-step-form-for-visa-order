<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://webtechsofts.com/
 * @since      1.0.0
 *
 * @package    Visa_Order
 * @subpackage Visa_Order/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Visa_Order
 * @subpackage Visa_Order/includes
 * @author     Web Tech Softs <info@webtechsofts.com>
 */
class Visa_Order {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Visa_Order_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'VISA_ORDER_VERSION' ) ) {
			$this->version = VISA_ORDER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'visa-order';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
        $this->wts_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Visa_Order_Loader. Orchestrates the hooks of the plugin.
	 * - Visa_Order_i18n. Defines internationalization functionality.
	 * - Visa_Order_Admin. Defines all hooks for the admin area.
	 * - Visa_Order_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-visa-order-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-visa-order-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-visa-order-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-visa-order-public.php';

        /**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-visa-order-short-code.php';
        /**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-visa-order-settings.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/settings/fields-details.php';

		$this->loader = new Visa_Order_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Visa_Order_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Visa_Order_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Visa_Order_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $plugin_admin, 'woocommerce_product_options_general_product_data_function' );
		$this->loader->add_action( 'woocommerce_admin_process_product_object', $plugin_admin, 'woocommerce_admin_process_product_object_function' );

	}

    private function wts_shortcodes() {

        $shortcode_admin = new Visa_Order_ShortCode( $this->get_plugin_name(), $this->get_version() );
        add_shortcode( 'all_products_list', array($shortcode_admin, 'all_products_list_function') );
        add_shortcode( 'multi_step_form', array($shortcode_admin, 'multi_step_form_function') );
        $this->loader->add_action( 'wp_footer', $shortcode_admin, 'wp_footer_function' );
        $this->loader->add_filter( 'woocommerce_add_cart_item_data', $shortcode_admin, 'woocommerce_add_item_data_function', 99, 2 );
        $this->loader->add_filter( 'woocommerce_get_item_data', $shortcode_admin, 'woocommerce_get_item_data_function', 99, 2 );
        $this->loader->add_filter( 'woocommerce_checkout_create_order_line_item', $shortcode_admin, 'woocommerce_checkout_create_order_line_item_function', 99, 4 );
        $this->loader->add_filter( 'woocommerce_add_to_cart_redirect', $shortcode_admin, 'woocommerce_add_to_cart_redirect_function', 99, 4 );
        $this->loader->add_filter( 'woocommerce_add_to_cart_validation', $shortcode_admin, 'woocommerce_add_to_cart_validation_function', 99, 5 );
    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Visa_Order_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Visa_Order_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
