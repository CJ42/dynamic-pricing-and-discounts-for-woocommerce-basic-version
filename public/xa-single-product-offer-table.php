<?php  
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
    global $offers;
    
                 if(!function_exists("list_buy_and_get_offer_on_offers_table")) 
         {
            function list_buy_and_get_offer_on_offers_table($offers)
            {   global $product;        
                $dummy_option=array('buy_get_free_rules'=>array(),);
                $rules_option_array=get_option('xa_dp_rules',$dummy_option);
                $rules= $rules_option_array['buy_get_free_rules'];
                foreach($rules as $rule)
                {
                $fromdate=$rule['from_date'];
                $todate=$rule['to_date'];
                $user_role=$rule['allow_roles'];
                $offer_name=$rule['offer_name'];
                    if( $user_role=='all' || current_user_can($user_role)){}
                    else{ return false;}
                    $now=date('d-m-Y');
                    $return=false;
                    if(empty($fromdate) && empty($todate))
                    {
                            $return= true;
                    }
                    elseif(empty($fromdate) && empty($todate)==false  && (strtotime($now) <= strtotime($todate)))
                    {
                            $return= true;
                    }
                    elseif(empty($fromdate)==false && (strtotime($now) >= strtotime($fromdate)) && empty($todate))
                    {
                           $return= true;
                    }
                    elseif((strtotime($now) >= strtotime($fromdate))  && (strtotime($now) <= strtotime($todate)))
                    {
                            $return= true;
                    }
                    else
                    {
                            $return= false;
                    }

                    if(is_product()==true && $return===true && !empty($product) && is_string($product)===false)
                    {  
                        $cpid = is_wc_version_gt_eql('2.7')?$product->get_id():$product->id;
                        foreach($rule['purchased_product_id'] as $pid=>$qnty)
                        {   
                            if($pid==$cpid){$offers['buy_and_get_free_offers'][]=$offer_name;}
                        }
                    }
                    
                }
                return $offers;
            }
}

$offers=apply_filters('offer_table_offer_items',list_buy_and_get_offer_on_offers_table($offers));

    ?>

<style>
    .xa_offer_header{
        text-align: center;   
    }
</style>
<div class="xa_offer_table">    
    <div class="xa_offer_header"  ><h4><?php  echo apply_filters('offer_table_description_text',__('Offers','eh-dynamic-pricing-discounts'));  ?></h4></div>
    
            <div class="xa_offer_content">    
                <ul class="xa_offer_table_list">
                    <?php 
                        foreach($offers as $type=>$offer)
                        {
                             foreach($offer as $offr)
                               {   ?>
                               <li class="<?php echo $type ?>_item  xa_offer_table_list_item "><span class="xa_offer_item_span"><?php echo $offr ?></span></li>
                           <?php    

                               }
                        }
                            ?>
                </ul>
        </div>
</div>

