<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
if(!class_exists('admin_actions_function'))
{
	class admin_actions_function
	{
		
			function func_enqueue_search_product_enhanced_select() 
			{
				global $wp_scripts;
				wp_enqueue_script('wc-enhanced-select'); // if your are using recent versions
				wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/admin/css/xa-dynamic-pricing-plugin-admin.css');
				
			}
			
			function func_enqueue_jquery() {
					wp_enqueue_style("jquery");
					}
			
			function func_enqueue_jquery_ui_datepicker()
			{
				//jQuery UI date picker file
				wp_enqueue_script('jquery-ui-datepicker');
				//jQuery UI theme css file
				wp_enqueue_style('e2b-admin-ui-css',plugins_url('css/jquery-ui.css',__FILE__) );
			}
				

			function register_sub_menu() 			/// Creates New Sub Menu under main Woocommerce menu
			{				
				add_submenu_page('woocommerce','Dynamic Pricing Main Page',__('Dynamic Pricing'),'manage_woocommerce','dynamic-pricing-main-page',array( $this, 'dynamic_pricing_admin_page')); 
			}

			function dynamic_pricing_admin_page() 			//Gets the plugin page and display to user
			{    	
				require('view/xa-dynamic-pricing-plugin-admin-display.php'); 
			}

			 function dynamic_pricing_main_page_init()			/// Adds fields and options to database and Register Settings 
			{ 
				
			}
		
		
	}
	
	
}