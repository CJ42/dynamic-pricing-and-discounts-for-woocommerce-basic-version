<?php
/**
 * Plugin Name:       Dynamic Pricing and Discounts for WooCommerce Basic Version
 * Plugin URI:        https://www.xadapter.com/product/dynamic-pricing-discounts-woocommerce/
 * Description:     This plugin helps you to set discounts and pricing dynamically based on minimum quantity,weight,price and allow you to set maximum allowed discounts on every rule.
 * Version:           2.3.0
 * Author:                  XAdapter
 * Author URI:        https://www.xadapter.com/vendor/extensionhawk/
  */
        if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
define('xa_root_path',plugin_dir_path( __FILE__ ));
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( !class_exists( 'woocommerce' ) ) { 
    
add_action( 'admin_init', 'eh_dp_my_plugin_deactivate' );
          function eh_dp_my_plugin_deactivate() {
              
               if ( !class_exists( 'woocommerce' ) )
               { 
                                    deactivate_plugins( plugin_basename( __FILE__ ) );
                                   wp_safe_redirect( admin_url('plugins.php') );
                                    
               }
          }

    
}
//$GLOBALS['final_discount'] =array('22'=>array(2,),);
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-xa-dynamic-pricing-plugin-activator.php
 */
if(!function_exists('activate_xa_dynamic_pricing_plugin'))
{
    function activate_xa_dynamic_pricing_plugin() {
                   
        if ( is_plugin_active('eh-dynamic-pricing-discounts_basic_version/eh-dynamic-pricing-discounts_basic_version.php') ){ 
        deactivate_plugins( basename( __FILE__ ) );
		wp_die( __("Oops! You tried installing the premium version without deactivating and deleting the basic version. Kindly deactivate and delete Dynamic Pricing and Discounts for WooCommerce Extension and then try again", "eh-dynamic-pricing-discounts" ), "", array('back_link' => 1 ));
	}
                  if ( !class_exists( 'woocommerce' ) ) { exit('Please Install and Activate Woocommerce Plugin First, Then Try Again!!');}
                  
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xa-dynamic-pricing-plugin-activator.php';
	xa_dynamic_pricing_plugin_Activator::activate();
}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-xa-dynamic-pricing-plugin-deactivator.php
 */
if(!function_exists('deactivate_xa_dynamic_pricing_plugin'))
{
    function deactivate_xa_dynamic_pricing_plugin() {
      if ( !class_exists( 'woocommerce' ) )
               { 
          new WP_Error( '1', 'Dynamic Pricing And Discounts Plugin could not start because WooCommerce Plugin is Deactivated!!' );
               }
               
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xa-dynamic-pricing-plugin-deactivator.php';
	xa_dynamic_pricing_plugin_Deactivator::deactivate();
}
}


register_activation_hook( __FILE__, 'activate_xa_dynamic_pricing_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_xa_dynamic_pricing_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-xa-dynamic-pricing-plugin.php';

add_action('init','eh_dy_load_plugin_textdomain'); 
add_action('init','eh_dp_init'); 

if(!function_exists('eh_dy_load_plugin_textdomain'))
{
    function eh_dy_load_plugin_textdomain() {
        load_plugin_textdomain( 'eh-dynamic-pricing-discounts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }
}
if(!function_exists('eh_dp_init'))
{
    function eh_dp_init()
        {
         if ( is_admin() ) {
                                include("admin/eha_exporter.php");
                                include("admin/eha_importer.php");
                        }

        }
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

if(!function_exists('run_xa_dynamic_pricing_plugin'))
{
    function run_xa_dynamic_pricing_plugin() {
                $plugin = new xa_dynamic_pricing_plugin();
                $plugin->run();


        }
}
    global $offers;
    $offers=array();
if(!function_exists('eh_dp_plugin_settings_link'))
{
            function eh_dp_plugin_settings_link($links) { 
          $settings_link = '<a href="admin.php?page=dynamic-pricing-main-page&tab=settings_page">Settings</a>'; 
           $doc_link='<a href="https://www.xadapter.com/category/product/dynamic-pricing-and-discounts-for-woocommerce/" target="_blank">' . __('Documentation', 'eha_multi_carrier_shipping') . '</a>';
           $support_link='<a href="https://www.xadapter.com/support/forum/dynamic-pricing-discounts-woocommerce/" target="_blank">' . __('Support', 'eha_multi_carrier_shipping') . '</a>';
                    
          array_unshift($links, $support_link); 
          array_unshift($links, $doc_link); 
          array_unshift($links, $settings_link); 
          return $links; 
        }
}

 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'eh_dp_plugin_settings_link' );
add_filter('plugin_row_meta', 'eh_plugin_row_meta', 10, 2);


function eh_plugin_row_meta($links, $file) {
        if ($file == plugin_basename(__FILE__)) {
            $row_meta = array(
                   '<a href="plugin-install.php?tab=plugin-information&amp;plugin=dynamic-pricing-and-discounts-for-woocommerce-basic-version&amp;TB_iframe=true&amp;width=772&amp;height=316" class="thickbox open-plugin-details-modal" aria-label="More information about Dynamic Pricing and Discounts for WooCommerce" data-title="Dynamic Pricing and Discounts for WooCommerce">' . __('View details', 'eha_multi_carrier_shipping') . '</a>',
                    
            );
            unset($links[2]);
            return array_merge($links, $row_meta);
        }
        return (array) $links;
    }
    
try {
      run_xa_dynamic_pricing_plugin();
   
}
catch(Exception $e) {
}
