<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.xadapter.com
 * @since      1.0.0
 *
 * @package    xa_dynamic_pricing_plugin
 * @subpackage xa_dynamic_pricing_plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    xa_dynamic_pricing_plugin
 * @subpackage xa_dynamic_pricing_plugin/includes
 * @author     Your Name <email@example.com>
 */
class xa_dynamic_pricing_plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
                        $dummy_option=array('product_rules'=>array(),'combinational_rules'=>array(),'cat_combinational_rules'=>array(),'category_rules'=>array(),'cart_rules'=>array(),'buy_get_free_rules'=>array());
                        update_option('xa_dp_rules',get_option('xa_dp_rules',$dummy_option));
	}

}