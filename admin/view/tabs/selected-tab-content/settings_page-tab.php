<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
           
$dummy_settings['product_rules_on_off']='enable';
$dummy_settings['combinational_rules_on_off']='disable';
$dummy_settings['cat_comb_rules_on_off']='disable';
$dummy_settings['category_rules_on_off']='disable';
$dummy_settings['cart_rules_on_off']='disable';
$dummy_settings['buy_and_get_free_rules_on_off']='disable';
$dummy_settings['price_table_on_off']='enable';
$dummy_settings['offer_table_on_off']='disable';
$dummy_settings['offer_table_position']='woocommerce_before_add_to_cart_button';
$dummy_settings['auto_add_free_product_on_off']='enable';
$dummy_settings['pricing_table_qnty_shrtcode']='nos.';
$dummy_settings['show_discount_in_line_item']='yes';
$dummy_settings['pricing_table_position']='woocommerce_before_add_to_cart_button';
$dummy_settings['mode']='best_discount';
$dummy_settings['disable_shop_page_calculation']='no';
$dummy_settings['disable_product_page_calculation']='no';
$dummy_settings['recuring_rule_id_array']='';
$dummy_settings['show_on_sale']='yes';

$settings=get_option('xa_dynamic_pricing_setting',$dummy_settings);    
extract($settings);
if(!isset($disable_shop_page_calculation))
{
    $disable_shop_page_calculation="no";
}
if(!isset($cat_comb_rules_on_off))
{
    $cat_comb_rules_on_off="enable";
}
if(!isset($disable_product_page_calculation))
{
    $disable_product_page_calculation="no";
}
if(!isset($pricing_table_qnty_shrtcode))
{
    $pricing_table_qnty_shrtcode="nos.";
}
if(!isset($show_discount_in_line_item))
{
    $show_discount_in_line_item="yes";
}
if(!isset($mode))
{
    $mode="best_discount";
}
if(!isset($buy_and_get_free_rules_on_off))
{
    $buy_and_get_free_rules_on_off="enable";
}
if(!isset($pricing_table_position))
{
    $pricing_table_position="woocommerce_before_add_to_cart_button";
}
if(!isset($offer_table_position))
{
    $offer_table_position="woocommerce_before_add_to_cart_button";
}
if(!isset($offer_table_on_off))
{
    $offer_table_on_off="disable";
}
if(!isset($show_on_sale))
{
    $show_on_sale="yes";
}

?>

</br><form method="GET">
<table class="table"style="font-size: small;margin-left: 20px;" >
	<tbody style="font-size: inherit;width: 100%;">
            <div style="border-style: solid; border-width: 1px; border-color: grey;background: lightsteelblue">
                <span style='margin-left:20px;'> <?php _e('Modes','eh-dynamic-pricing-discounts');?></span>
            </div>
                <tr  style='height:50px;'>
                        <td  style='min-width: 300px;'>
                            <?php _e('Product Rules','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='product_rules_on_off'  selected='<?php   echo $product_rules_on_off  ?>'>
                                <option value='enable'     <?php  echo(($product_rules_on_off=='enable')?'selected':'');  ?> >Enable</option>
                                <option value='disable'   <?php  echo(($product_rules_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                        </td>
                    </tr>
                    <tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                          <?php _e('Combinational Rules','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='combinational_rules_on_off'  selected='<?php   echo $combinational_rules_on_off  ?>'>
                                <option value='enable'  <?php  echo(($combinational_rules_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($combinational_rules_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                        </td>
                    </tr>
                    <tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                            <?php _e('Category Rules','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='category_rules_on_off'  selected='<?php   echo $category_rules_on_off  ?>'>
                                <option value='enable'  <?php  echo(($category_rules_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($category_rules_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                        </td>
                    </tr>
                    <tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                            
                            <?php _e('Cart Rules ','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='cart_rules_on_off'  selected='<?php   echo $cart_rules_on_off  ?>'>
                                <option value='enable'  <?php  echo(($cart_rules_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($cart_rules_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                        </td>
                    </tr>
                   <tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                            
                            <?php _e('Buy and Get Free Rules ','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='buy_and_get_free_rules_on_off'  selected='<?php   echo $buy_and_get_free_rules_on_off  ?>'>
                                <option value='enable'  <?php  echo(($buy_and_get_free_rules_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($buy_and_get_free_rules_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                        </td>
                    </tr>
                   <tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                            
                               <?php _e('Category Combinational Rules','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='cat_comb_rules_on_off'  selected='<?php   echo $cat_comb_rules_on_off  ?>'>
                                <option value='enable'  <?php  echo(($cat_comb_rules_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($cat_comb_rules_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                        </td>
                    </tr>

	</tbody>
	<tfoot>
	</tfoot>
</table>
<table class="table"style="font-size: small;margin-left: 20px;" >
	<tbody style="font-size: inherit;width: 100%;">
            <div style="border-style: solid; border-width: 1px; border-color: grey;background: lightsteelblue">
                <span style='margin-left:20px;'> <?php _e('Functionality','eh-dynamic-pricing-discounts');?> </span>
            </div>
                <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                            
                            <?php _e('Display Prices Table on Product Page','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='price_table_on_off' selected='<?php   echo $price_table_on_off  ?>'>
                                <option value='enable'  <?php  echo(($price_table_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($price_table_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                            
                            <?php _e('(Valid only for "Product Rules", and atleast 2 product rules should be there to get this table)','eh-dynamic-pricing-discounts');?>
                        </td>
                </tr>
                	<tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                            
                            <?php _e('Position of Pricing Table on Product Page','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='pricing_table_position'  selected='<?php   echo $pricing_table_position  ?>'>
                                <option value='woocommerce_before_single_product'  <?php  echo(($pricing_table_position=='woocommerce_before_single_product')?'selected':'');  ?>><?php _e('Before Product','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_single_product'  <?php  echo(($pricing_table_position=='woocommerce_after_single_product')?'selected':'');  ?>><?php _e('After Product','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_before_single_product_summary'  <?php  echo(($pricing_table_position=='woocommerce_before_single_product_summary')?'selected':'');  ?>><?php _e('Before Product Summary','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_single_product_summary'  <?php  echo(($pricing_table_position=='woocommerce_single_product_summary')?'selected':'');  ?>><?php _e('In Product Summary','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_single_product_summary'  <?php  echo(($pricing_table_position=='woocommerce_after_single_product_summary')?'selected':'');  ?>><?php _e('After Product Summary','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_before_add_to_cart_button'  <?php  echo(($pricing_table_position=='woocommerce_before_add_to_cart_button')?'selected':'');  ?>><?php _e('Before Add To Cart Button','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_add_to_cart_button'  <?php  echo(($pricing_table_position=='woocommerce_after_add_to_cart_button')?'selected':'');  ?>><?php _e('After Add To Cart Button','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_before_add_to_cart_form'  <?php  echo(($pricing_table_position=='woocommerce_before_add_to_cart_form')?'selected':'');  ?>><?php _e('Before Add To Cart Form','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_add_to_cart_form'  <?php  echo(($pricing_table_position=='woocommerce_after_add_to_cart_form')?'selected':'');  ?>><?php _e('After Add To Cart Form','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_product_thumbnails'  <?php  echo(($pricing_table_position=='woocommerce_product_thumbnails')?'selected':'');  ?>><?php _e('Product Thumbnails','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_product_meta_start'  <?php  echo(($pricing_table_position=='woocommerce_product_meta_start')?'selected':'');  ?>><?php _e('Product Meta Start','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_product_meta_end'  <?php  echo(($pricing_table_position=='woocommerce_product_meta_end')?'selected':'');  ?>><?php _e('Product Meta End','eh-dynamic-pricing-discounts');?></option>
                                
                            </select>
                        </td>
                    </tr>
                    <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                             <?php _e('Display Offers Table on Product Page','eh-dynamic-pricing-discounts');?>
                           
                        </td>
                        <td>
                            <select name='offer_table_on_off' selected='<?php   echo $offer_table_on_off  ?>'>
                                <option value='enable'  <?php  echo(($offer_table_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($offer_table_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                            
                            <?php _e('(Valid For All Rules)','eh-dynamic-pricing-discounts');?>
                        </td>
                </tr>
                	<tr  style='height:50px;'>
                        <td style='min-width: 300px;'>
                            
                            <?php _e('Position of Offers Table on Product Page','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='offer_table_position'  selected='<?php   echo $offer_table_position  ?>'>
                                <option value='woocommerce_before_single_product'  <?php  echo(($offer_table_position=='woocommerce_before_single_product')?'selected':'');  ?>><?php _e('Before Product','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_single_product'  <?php  echo(($offer_table_position=='woocommerce_after_single_product')?'selected':'');  ?>><?php _e('After Product','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_before_single_product_summary'  <?php  echo(($offer_table_position=='woocommerce_before_single_product_summary')?'selected':'');  ?>><?php _e('Before Product Summary','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_single_product_summary'  <?php  echo(($offer_table_position=='woocommerce_single_product_summary')?'selected':'');  ?>><?php _e('In Product Summary','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_single_product_summary'  <?php  echo(($offer_table_position=='woocommerce_after_single_product_summary')?'selected':'');  ?>><?php _e('After Product Summary','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_before_add_to_cart_button'  <?php  echo(($offer_table_position=='woocommerce_before_add_to_cart_button')?'selected':'');  ?>><?php _e('Before Add To Cart Button','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_add_to_cart_button'  <?php  echo(($offer_table_position=='woocommerce_after_add_to_cart_button')?'selected':'');  ?>><?php _e('After Add To Cart Button','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_before_add_to_cart_form'  <?php  echo(($offer_table_position=='woocommerce_before_add_to_cart_form')?'selected':'');  ?>><?php _e('Before Add To Cart Form','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_after_add_to_cart_form'  <?php  echo(($offer_table_position=='woocommerce_after_add_to_cart_form')?'selected':'');  ?>><?php _e('After Add To Cart Form','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_product_thumbnails'  <?php  echo(($offer_table_position=='woocommerce_product_thumbnails')?'selected':'');  ?>><?php _e('Product Thumbnails','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_product_meta_start'  <?php  echo(($offer_table_position=='woocommerce_product_meta_start')?'selected':'');  ?>><?php _e('Product Meta Start','eh-dynamic-pricing-discounts');?></option>
                                <option value='woocommerce_product_meta_end'  <?php  echo(($offer_table_position=='woocommerce_product_meta_end')?'selected':'');  ?>><?php _e('Product Meta End','eh-dynamic-pricing-discounts');?></option>
                                
                            </select>
                        </td>
                    </tr>
                                       
                <tr  style='height:50px;'>
                        <td>
                             <?php _e('Short Code For Quantity:','eh-dynamic-pricing-discounts');?>
                            
                        </td>
                        <td>
                            <input type="text" name="pricing_table_qnty_shrtcode" value='<?php echo $pricing_table_qnty_shrtcode;   ?>' />
                            <?php _e('Short Code For Quantity:','eh-dynamic-pricing-discounts');?>                            
                        </td>
                        
                </tr>
                    
                <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                            
                             <?php _e('Automatically Add Free Product to cart','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='auto_add_free_product_on_off' selected='<?php   echo $auto_add_free_product_on_off  ?>'>
                                <option value='enable'  <?php  echo(($auto_add_free_product_on_off=='enable')?'selected':'');  ?>>Enable</option>
                                <option value='disable'  <?php  echo(($auto_add_free_product_on_off=='disable')?'selected':'');  ?>>Disable</option>
                            </select>
                            
                            <?php _e('( if purchased and free products are same in rule then it will be automatically added to cart )','eh-dynamic-pricing-discounts');?>
                        </td>   
                        
                </tr>
                 <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                           
                             <?php _e('Show Discounts on each Line Item on Cart Page','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='show_discount_in_line_item' selected='<?php   echo $show_discount_in_line_item  ?>'>
                                <option value='yes'  <?php  echo(($show_discount_in_line_item=='yes')?'selected':'');  ?>>Yes</option>
                                <option value='no'  <?php  echo(($show_discount_in_line_item=='no')?'selected':'');  ?>>No</option>
                            </select>
                            
                            <?php _e('(  To use this feature "Buy and Get Free Offers" should be disabled [above] )','eh-dynamic-pricing-discounts');?>
                        </td>   
                </tr>
            <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                           
                           <?php _e('Calculation Mode','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='mode' selected='<?php   echo $mode  ?>'>
                                <option value='best_discount'  <?php  echo(($mode=='best_discount')?'selected':'');  ?>>Best Discount</option>
                                <option value='strict'  <?php  echo(($mode=='strict')?'selected':'');  ?>>Strict</option>
                            </select>
                            
                            <?php _e('( Strict mode uses strict check for Min and Max attributes of rules against the products ,works for product rules )','eh-dynamic-pricing-discounts');?>
                        </td>   
                </tr>
            <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                          
                            <?php _e('Speed-up Shop Page','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='disable_shop_page_calculation' selected='<?php   echo $mode  ?>'>
                                <option value='yes'  <?php  echo(($disable_shop_page_calculation=='yes')?'selected':'');  ?>>Yes</option>
                                <option value='no'  <?php  echo(($disable_shop_page_calculation=='no')?'selected':'');  ?>>No</option>
                            </select>                            
                            <?php _e('( if this mode is enabled user will not see discounted price on shop page.The discount will be directly applied on cart page)','eh-dynamic-pricing-discounts');?>
                        </td>   
                </tr>
            <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                         
                         <?php _e('Speed-up Product Page','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='disable_product_page_calculation' selected='<?php   echo $mode  ?>'>
                                <option value='yes'  <?php  echo(($disable_product_page_calculation=='yes')?'selected':'');  ?>>Yes</option>
                                <option value='no'  <?php  echo(($disable_product_page_calculation=='no')?'selected':'');  ?>>No</option>
                            </select>                            
                            <?php _e('( if this mode is enabled user will not see discounted price on product page.The discount will be directly applied on cart page)','eh-dynamic-pricing-discounts');?>
                        </td>   
                </tr>
               <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                         
                         <?php _e('Repeat These  Rules:','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <input type="text" name="recuring_rule_id_array" id="recuring_rule_id_array" value=<?php echo $recuring_rule_id_array; ?> ></input>
                            </br> <?php _e('( specify rules which you want to repeat even after successful execution seperated by comma, sample value="product_rules:1,product_rules:2"  for product rule number 1 and 2)','eh-dynamic-pricing-discounts');?>
                        </td>   
                </tr>
                <tr  style='height:50px;'>
                        <td   style='min-width: 300px;'>
                          
                            <?php _e('Apply Discount on Sale Price (No = Regular Price)','eh-dynamic-pricing-discounts');?>
                        </td>
                        <td>
                            <select name='show_on_sale' selected='<?php   echo $mode  ?>'>
                                <option value='yes'  <?php  echo(($show_on_sale=='yes')?'selected':'');  ?>>Yes</option>
                                <option value='no'  <?php  echo(($show_on_sale=='no')?'selected':'');  ?>>No</option>
                            </select>                            
                            <?php _e('( Show "On Sale" on all products which are discounted)');?>
                        </td>   
                </tr>
                      
                    
	</tbody>
	<tfoot>
	</tfoot>
</table>
    </br>
</br>
<p class="submit"   ><input type="submit" style='width:100px;'   name="submit" id="submit" class="button button-primary" value="Save"></p>

</form>





 

