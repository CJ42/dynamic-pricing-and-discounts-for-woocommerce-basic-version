<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
if ( ! defined( 'WPINC' ) ) {
	die;
}
                                                            if(isset($_GET['submit'])  )
			{
                                                                                                    $prev_data=array ( 
                                                                                                                    'product_rules_on_off' => !empty($_GET['product_rules_on_off'])?$_GET['product_rules_on_off']:'enable',
                                                                                                                    'combinational_rules_on_off' => 'disable',
                                                                                                                    'category_rules_on_off' => 'disable',
                                                                                                                    'cat_comb_rules_on_off' => 'disable',
                                                                                                                    'cart_rules_on_off' => 'disable',
                                                                                                                    'buy_and_get_free_rules_on_off' => 'disable',
                                                                                                                    'price_table_on_off' => !empty($_GET['price_table_on_off'])?$_GET['price_table_on_off']:'disable',
                                                                                                                    'offer_table_on_off' => !empty($_GET['offer_table_on_off'])?$_GET['offer_table_on_off']:'disable',
                                                                                                                    'auto_add_free_product_on_off' => !empty($_GET['auto_add_free_product_on_off'])?$_GET['auto_add_free_product_on_off']:'enable',
                                                                                                                    'pricing_table_qnty_shrtcode'=>!empty($_GET['pricing_table_qnty_shrtcode'])?$_GET['pricing_table_qnty_shrtcode']:'nos.',
                                                                                                                    'show_discount_in_line_item'=>!empty($_GET['show_discount_in_line_item'])?$_GET['show_discount_in_line_item']:'yes',
                                                                                                                    'disable_shop_page_calculation'=>!empty($_GET['disable_shop_page_calculation'])?$_GET['disable_shop_page_calculation']:'no',
                                                                                                                    'disable_product_page_calculation'=>!empty($_GET['disable_product_page_calculation'])?$_GET['disable_product_page_calculation']:'no',
                                                                                                                    'pricing_table_position'=>!empty($_GET['pricing_table_position'])?$_GET['pricing_table_position']:'woocommerce_before_add_to_cart_button',
                                                                                                                    'offer_table_position'=>!empty($_GET['offer_table_position'])?$_GET['offer_table_position']:'woocommerce_before_add_to_cart_button',
                                                                                                                     'mode'=>!empty($_GET['mode'])?$_GET['mode']:'best_discount',
                                                                                                                    'recuring_rule_id_array'=>!empty($_GET['recuring_rule_id_array'])?$_GET['recuring_rule_id_array']:'',
                                                                                                                    'show_on_sale'=>!empty($_GET['show_on_sale'])?$_GET['show_on_sale']:'',
                                                                                                                    
                                                                                                        );
					

					update_option('xa_dynamic_pricing_setting',$prev_data);
					?>
					<div class="notice notice-success is-dismissible">
					<p><?php _e( 'Saved Successfully','eh-dynamic-pricing-discounts' ); ?></p>
					</div>
					<?php
					wp_safe_redirect( admin_url('admin.php?page=dynamic-pricing-main-page&tab='.$active_tab) );
			}
			else
			{
				echo '<div class="notice notice-error is-dismissible">';
				echo '<p>'._e( 'Please Enter All Fields!! Then Save','eh-dynamic-pricing-discounts' ).'</p> </div>';
					
			}
   