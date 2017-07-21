<?php
        if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

function xa_show_discount_on_line_item($cart)
{
        $cart = $cart->get_cart();
		foreach ( $cart as $cart_item_key => $values ) {
			$_product           = $values['data'];
			$original_product=wc_get_product($_product->get_id());
			if(isset($values['dynamic_discount']) && !empty($values['dynamic_discount'])  && $values['dynamic_discount']!==0)
			{
				$dynamic_discount = $values['dynamic_discount'];
			}
			else
			{
				$dynamic_discount=0;
			}
			$_product->set_price($original_product->get_price()- ($dynamic_discount/$values['quantity']));
		}
		
}