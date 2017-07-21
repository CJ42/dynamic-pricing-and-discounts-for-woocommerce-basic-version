<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

include 'valid-rules-class/valid-rules.php';
include 'calculation-handler.php';

$GLOBALS['woocommerce_get_price_hook_name']='woocommerce_get_price';
if(is_wc_version_gt_eql('2.7.0')==true)
{
    $GLOBALS['woocommerce_get_price_hook_name']='woocommerce_product_get_price';
}
$GLOBALS['woocommerce_get_sale_price_hook_name']='woocommerce_get_sale_price';
if(is_wc_version_gt_eql('2.7')==true)
{
    $GLOBALS['woocommerce_get_sale_price_hook_name']='woocommerce_product_get_sale_price';

}

function eh_speedup_shop_page()
{
    if(is_shop() && isset($GLOBALS['settings']['disable_shop_page_calculation']) && $GLOBALS['settings']['disable_shop_page_calculation']=='yes' )
    {    
        return true;
    }

    return false;
    
}
function eh_speedup_product_page()
{
    if(is_product() && isset($GLOBALS['settings']['disable_product_page_calculation']) && $GLOBALS['settings']['disable_product_page_calculation']=='yes' )
    {   
        return true;
    }
 
    return false;
    
}


if(!is_admin() )
{

add_filter('woocommerce_get_price_html','xa_variable_page_get_price_html',20,2);              // update sale price on product variation page
add_filter($GLOBALS['woocommerce_get_price_hook_name'], 'xa_discounted_sale_price', 22, 2);         // update sale price on product page
add_filter($GLOBALS['woocommerce_get_sale_price_hook_name'], 'xa_discounted_sale_price', 22, 2);    // update sale price on product page
}


$dummy_settings['product_rules_on_off']='enable';
$dummy_settings['combinational_rules_on_off']='enable';
$dummy_settings['category_rules_on_off']='enable';
$dummy_settings['cart_rules_on_off']='enable';
$dummy_settings['price_table_on_off']='enable';
$dummy_settings['auto_add_free_product_on_off']='enable';
$dummy_settings['pricing_table_qnty_shrtcode']='nos.';
$dummy_settings['show_discount_in_line_item']='yes';
$dummy_settings['pricing_table_position']='woocommerce_before_add_to_cart_button';
$dummy_settings['show_on_sale']='no';
$GLOBALS['settings']=get_option('xa_dynamic_pricing_setting',$dummy_settings);

if(isset($GLOBALS['settings']['show_on_sale']) && $GLOBALS['settings']['show_on_sale']=='no')
{
    $GLOBALS['woocommerce_get_sale_price_hook_name']='woocommerce_product_get_regular_price';
}
function eh_get_price_excluding_tax($product)
{
	if(is_wc_version_gt_eql('2.7'))
	{
			if ( function_exists( 'wc_get_price_excluding_tax' ) ) {
				$display_price = wc_get_price_excluding_tax( $product);
			}

	}else{
				$display_price=$product->get_price_excluding_tax();
			}

    return $display_price;

}


$show_discount_in_line_item=isset($GLOBALS['settings']['show_discount_in_line_item'])?$GLOBALS['settings']['show_discount_in_line_item']:'yes';
if($show_discount_in_line_item=='yes')
{

    add_action('woocommerce_before_calculate_totals','xa_show_discount_on_line_item',1,1);
    add_filter( 'woocommerce_cart_item_price', 'on_display_cart_item_price_html', 100, 3 );
    include_once('xa_show_discount_on_line_item.php');   

}



function on_display_cart_item_price_html( $html, $cart_item, $cart_item_key )
{

        $_product = $cart_item['data'];
        return $cart_item['data']->get_price_html();
}

add_action( 'wc_ajax_get_refreshed_fragments','xa_wc_ajax_get_refreshed_fragments' , 1 );

if(isset($GLOBALS['settings']['show_discount_in_line_item']) && $GLOBALS['settings']['show_discount_in_line_item']=='yes')
	{
		add_action('woocommerce_before_calculate_totals' , 'xa_calculate_and_apply_discount');
	}
	else
	{
		add_action('woocommerce_cart_calculate_fees' , 'xa_calculate_and_apply_discount_and_add_fee');
	}
function  xa_wc_ajax_get_refreshed_fragments()
{
	global $woocommerce;	
	$cart=$woocommerce->cart;
	$cart->calculate_totals();	
}

function xa_calculate_and_apply_discount( $cart ){
	
	global $woocommerce;
	if(empty($cart))
	{		
		$cart=$woocommerce->cart;
	}
    $active_modes= get_allowed_modes();
    $prod_list= xa_dp_initialize_product_array_from_cart_obj($cart);
    $cart_key_pid_mapping=xa_dp_initialize_cartkey_pid_mapping_from_cart_obj($cart);
    $obj = new xa_calculation_handler($prod_list,$active_modes,$cart_key_pid_mapping);
    $discount=$obj->xa_get_dynamic_discount();
}

function xa_calculate_and_apply_discount_and_add_fee( $cart ){
	
	global $woocommerce;
	if(empty($cart))
	{		
		$cart=$woocommerce->cart;
	}
    $active_modes= get_allowed_modes();
    $prod_list= xa_dp_initialize_product_array_from_cart_obj($cart);
    $cart_key_pid_mapping=xa_dp_initialize_cartkey_pid_mapping_from_cart_obj($cart);
    $obj = new xa_calculation_handler($prod_list,$active_modes,$cart_key_pid_mapping);

    $discount=$obj->xa_get_dynamic_discount();
    $label=__( 'Discount','eh-dynamic-pricing-discounts' );
	$label = apply_filters( 'eha_change_discount_label_filter', $label);
	$cart->add_fee(	$label , -$discount);
   
}


function get_allowed_modes()
{

    $active_modes=array();
    if( $GLOBALS['settings']['product_rules_on_off']=='enable')
    {
        $active_modes[]='product_rules';
    }
    return $active_modes;
}
function xa_dp_initialize_product_array_from_cart_obj(WC_Cart $cart )
{

    $product_array=array();

    foreach($cart->cart_contents as $hash_id=>$hash)
    {
        if(strpos( $hash_id, 'free' ) !== false)
        {
            continue;
        }
        if(isset($hash['variation_id']) && $hash['variation_id']!=0)
        {
            $pid=$hash['variation_id'];
        }
        else
        {
            $pid=$hash['product_id'];
        }
        $quantity=$hash['quantity'];
        if(isset($product_array[$pid])  && is_numeric($product_array[$pid]) && $product_array[$pid]>0)
        {
            $product_array[$pid]+=$quantity;
        }
        else
        {
            $product_array[$pid]=$quantity;
        }

    }
    return $product_array;
}
function xa_dp_initialize_cartkey_pid_mapping_from_cart_obj(WC_Cart $cart )
{

    $product_array=array();

    foreach($cart->cart_contents as $hash_id=>$hash)
    {
        if(strpos( $hash_id, 'free' ) !== false)
        {
            continue;
        }
        if(isset($hash['variation_id']) && $hash['variation_id']!=0)
        {
            $pid=$hash['variation_id'];
        }
        else
        {
            $pid=$hash['product_id'];
        }
        if(!isset($product_array[$pid]))
        {
            $product_array[$pid]=array();
        }

        $product_array[$pid][]=$hash_id;
        $cart->cart_contents[$hash_id]['dynamic_discount']=0;

    }
    return $product_array;
}
function get_settings_status($setting_name)
{
    if(!isset($GLOBALS['settings'][$setting_name]))
    {
        return 'disable';
    }
    return $GLOBALS['settings'][$setting_name];
}


$pricing_table_hook=isset($GLOBALS['settings']['pricing_table_position']) ? $GLOBALS['settings']['pricing_table_position'] : 'woocommerce_before_add_to_cart_button';
add_action($pricing_table_hook, 'xa_show_pricing_table', 40 );


function xa_show_pricing_table()
{

    if($GLOBALS['settings']['price_table_on_off']=='enable')
    {
        include "xa-single-product-pricing-table.php";
    }

}
$offer_table_hook=isset($GLOBALS['settings']['offer_table_position']) ? $GLOBALS['settings']['offer_table_position'] : 'woocommerce_before_add_to_cart_button';
add_action($offer_table_hook, 'xa_show_offer_table', 40 );


function xa_show_offer_table()
{

    if(isset($GLOBALS['settings']['offer_table_on_off']) && $GLOBALS['settings']['offer_table_on_off']=='enable')
    {
        include "xa-single-product-offer-table.php";
    }

}

function xa_variable_page_get_price_html($price,$product )
{
    if(eh_speedup_product_page()===true)
    {
        return $price;
    }
    if(eh_speedup_shop_page()===true)
    {
        return $price;
    }
    if($product->is_type( 'variable' ) )
    {
        
        $prices = $product->get_variation_prices( true );	
       
       if(isset($prices['sale_price'])) {unset($prices['sale_price']);  }
        foreach($prices['regular_price'] as $vpid=>$amt)
        {	
            $vproduct = new WC_Product_Variation( $vpid );			
			
            $sp= xa_discounted_sale_price($amt, $vproduct);
            $prices['sale_price'][$vpid]= $sp;
        }
        if(!isset($prices['sale_price']) || is_null($prices['sale_price'] ))
        {
            $prices['sale_price'] =array();
        }
        if(is_null($prices['regular_price'] ))
        {
            $prices['regular_price'] =array();
        }
        sort($prices['sale_price']);
        $min_sale_price = current( $prices['sale_price'] );
        $max_sale_price = end( $prices['sale_price'] );
        $min_reg_price=current( $prices['regular_price'] );
        $max_reg_price=end( $prices['regular_price'] );
        //echo "<pre>";   print_r($prices['sale_price']); echo "</pre>";
        $min_price =$min_sale_price<$min_reg_price?$min_sale_price:$min_reg_price;
        $max_price=$max_sale_price<$max_reg_price?$max_sale_price:$max_reg_price;
        //$regular_price     = $min_reg_price !== $max_reg_price ? sprintf( _x( '%1$s&ndash;%2$s', 'Price range: from-to', 'woocommerce' ), wc_price( $min_reg_price ), wc_price( $max_reg_price ) ) : wc_price( $min_reg_price );
        if($min_price==$min_reg_price && $max_price ==$max_reg_price)
        {
        }
        else
        {
            //$price     = $min_price !== $max_price ? sprintf( _x( '%1$s&ndash;%2$s', 'Price range: from-to', 'woocommerce' ), wc_price( $min_price ), wc_price( $max_price ) ) : wc_price( $min_price );
			if(!function_exists('wc_format_price_range'))
			{
				function wc_format_price_range( $from, $to )
				{
					$price = sprintf( _x( '%1$s &ndash; %2$s', 'Price range: from-to', 'woocommerce' ), is_numeric( $from ) ? wc_price( $from ) : $from, is_numeric( $to ) ? wc_price( $to ) : $to );
					return apply_filters( 'woocommerce_format_price_range', $price, $from, $to );
				}				
			}
                                                          if(is_wc_version_gt_eql('2.7'))
			{
                                                                    //$price=wc_format_price_range( $min_sale_price, $max_sale_price ) ;
                                                                     if ( $min_sale_price !==$min_reg_price ) {
                                                                        $price = wc_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ), $min_sale_price) . $product->get_price_suffix();
                                                                    } else {
                                                                        $price = wc_price( wc_get_price_to_display( $product ) ) . $product->get_price_suffix();
                                                                    }
                                
                                                                }
			else{
				$price=$product->get_price_html_from_to( $min_sale_price, $max_sale_price ) ;
			}
            
        }

        $price             = apply_filters( 'woocommerce_variable_sale_price_html', $price, $product );
        return apply_filters( 'eha_variable_sale_price_html', $price, $min_sale_price,$max_sale_price ,$min_reg_price,$max_reg_price);
    }
    elseif($product->is_type( 'variation' ))
    {	
        $new_price=xa_discounted_sale_price('',$product );
        if($new_price<=0)
        {
            $new_price=$price;
        }
        if($new_price<$product->get_regular_price())
        {
            return wc_format_sale_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ), $new_price ) . $product->get_price_suffix();
        }   // before it was not giving canceled regular price for individual variable prods
        else{
            return wc_price($new_price);
        }
    }
    else
    {
         
        return $price;
    }

}
function xa_discounted_sale_price($price,$product)
{  
    
    if(eh_speedup_product_page()===true)
    {
        return $price;
    }
    if(eh_speedup_shop_page()===true)
    {
        return $price;
    }
    remove_filter($GLOBALS['woocommerce_get_price_hook_name'], 'xa_discounted_sale_price', 22, 2);         // update sale price on product page
    remove_filter($GLOBALS['woocommerce_get_sale_price_hook_name'], 'xa_discounted_sale_price', 22, 2);    // update sale price on product page

    if(empty($price))
    {
        $price=$product->get_price();
    }

    if((is_product() or is_shop()) )
    {
        if($product->is_type( 'variation' ))
        {
            
        }
        $pid=is_wc_version_gt_eql('2.7')?$product->get_id():$product->id;
		global $woocommerce;
		$parray=xa_dp_initialize_product_array_from_cart_obj($woocommerce->cart);
		if(isset($parray[$pid]) && $parray[$pid]>0)
		{
			$pqnty=$parray[$pid];
		}
		else
		{
			$pqnty=1;
		}
		
        $prod_list=array($pid=>$pqnty);
        $modes  = get_allowed_modes();
        $obj=new xa_calculation_handler($prod_list,$modes) ;

        $discounted_price=$obj->xa_get_dynamic_discount();
		
		$discounted_price=$discounted_price/$pqnty;
        if(($price-$discounted_price)==$product->get_price())
        {
            $result=$product->get_price();
            add_filter($GLOBALS['woocommerce_get_price_hook_name'], 'xa_discounted_sale_price', 22, 2);         // update sale price on product page
            add_filter($GLOBALS['woocommerce_get_sale_price_hook_name'], 'xa_discounted_sale_price', 22, 2);    // update sale price on product page

            return $result;
        }
        if($price>=$discounted_price)
        {

            add_filter($GLOBALS['woocommerce_get_price_hook_name'], 'xa_discounted_sale_price', 22, 2);         // update sale price on product page
            add_filter($GLOBALS['woocommerce_get_sale_price_hook_name'], 'xa_discounted_sale_price', 22, 2);    // update sale price on product page

            return $price-$discounted_price;
        }
        else
        {
            add_filter($GLOBALS['woocommerce_get_price_hook_name'], 'xa_discounted_sale_price', 22, 2);         // update sale price on product page
            add_filter($GLOBALS['woocommerce_get_sale_price_hook_name'], 'xa_discounted_sale_price', 22, 2);    // update sale price on product page

            return $price;
        }


    }
    else
    {
        add_filter($GLOBALS['woocommerce_get_price_hook_name'], 'xa_discounted_sale_price', 22, 2);         // update sale price on product page
        add_filter($GLOBALS['woocommerce_get_sale_price_hook_name'], 'xa_discounted_sale_price', 22, 2);    // update sale price on product page

        return $price;
    }


}


class xa_dynamic_pricing_plugin_Public {

    private $xa_dynamic_pricing_plugin;


    private $version;

    public function __construct( $xa_dynamic_pricing_plugin, $version ) {

        $this->xa_dynamic_pricing_plugin = $xa_dynamic_pricing_plugin;
        $this->version = $version;

    }

    public function enqueue_styles()
    {


        wp_enqueue_style( $this->xa_dynamic_pricing_plugin, plugin_dir_url( __FILE__ ) . 'css/xa-dynamic-pricing-plugin-public.css', array(), $this->version, 'all' );

    }

    public function enqueue_scripts() {


        wp_enqueue_script( $this->xa_dynamic_pricing_plugin, plugin_dir_url( __FILE__ ) . 'js/xa-dynamic-pricing-plugin-public.js', array( 'jquery' ), $this->version, false );

    }
}