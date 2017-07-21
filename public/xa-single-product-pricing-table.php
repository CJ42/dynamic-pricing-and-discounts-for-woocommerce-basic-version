<?php  
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
                     
    ob_start( );?>


<table class='xa_sp_table' style=' width:100%;   margin-right: auto;'>
    <style>
        .xa_sp_table_cell
        {
                padding-right:40px;
                text-align: right;
            
        }
        .xa_sp_table_head2 tr td
        {
            text-align: center;
        }
    </style>
    <thead class='xa_sp_table_head2' style="font-size: 14px;  "><tr ><td width=30% ></td><td width=30% ></td><td  ></td></tr></thead>
    <thead class='xa_sp_table_head1' style="font-size: 14px;   background:lightgrey"><tr><td colspan="3"  style='text-align:center;'><?php _e('Bulk Product Offers','eh-dynamic-pricing-discounts');?></td></tr></thead>
     <thead class='xa_sp_table_head2' style="font-size: 14px;  background:lightyellow; "><tr ><td width=10px><?php _e('Min','eh-dynamic-pricing-discounts');?></td><td><?php _e('Max','eh-dynamic-pricing-discounts');?></td><td><?php _e('Offer','eh-dynamic-pricing-discounts');?></td></tr></thead>
    <tbody class='xa_sp_table_body'>
        <?php
            global $post;
            $pid = $post->ID;
            
            $product_rules=get_option('xa_dp_rules')['product_rules'];
            
                    if(isset(get_option('xa_dynamic_pricing_setting')['pricing_table_qnty_shrtcode']) && !empty(get_option('xa_dynamic_pricing_setting')['pricing_table_qnty_shrtcode']))
                    {
                        $pricing_table_qnty_shrtcode=get_option('xa_dynamic_pricing_setting')['pricing_table_qnty_shrtcode'];
                    }
                    else
                    {
                        $pricing_table_qnty_shrtcode=__("nos",'eh-dynamic-pricing-discounts' );
                    }
            
            
            $count=0;

            $Weight=get_option('woocommerce_weight_unit');
            $Quantity=$pricing_table_qnty_shrtcode;;
            $Price=get_option('woocommerce_currency');

            foreach($product_rules as $rule)
            {
                if( isset($rule['rule_on']) && $rule['rule_on']=='categories'  )   // removed check " &&  empty($rule1['product_id'])" 
                    {
                    $rule['product_id']=eha_get_products_from_category_by_ID($rule['category_id']);
                    }
                if(isset($rule['product_id']) && !empty($rule['product_id']))
                {   foreach($rule['product_id'] as $rule_pid)
                    {     
                        $prod=wc_get_product($rule_pid);
                        //$parent_id=is_wc_version_gt_eql('2.7')?$prod->get_parent_id():$prod->parent_id;
                        $parent_id=wp_get_post_parent_id( $rule_pid);
                        
                    if($rule_pid==$pid|| $parent_id==$pid)
                             {   
                              switch ($rule['check_on']) 
                                 {
                                      case 'Weight':   $unit=$Weight;
                                                              break;
                                       case 'Quantity':   $unit=$Quantity;
                                                                              break;
                                       case 'Price':   $unit=$Price;
                                                                              break;

                                      default:
                                          break;
                                 }


                                 $count++;
                                 echo "<tr  class='xa_sp_table_body_row' style='font-size:14px; font-family: Verdana;'>";
                                 echo "<td class='xa_sp_table_cell'>$rule[min] ".__($unit,'eh-dynamic-pricing-discounts' )." </td>";
                                 echo "<td class='xa_sp_table_cell'>";
                                 echo(isset($rule['max'])?  $rule['max']: '-');
                                 echo " ".__($unit,'eh-dynamic-pricing-discounts' )."</td>";
                                 echo "<td class='xa_sp_table_cell'>$rule[value]";
                                 if($rule['discount_type']=='Percent Discount'){   echo "   % ".__( "Discount",'eh-dynamic-pricing-discounts' )."</td>";  }
                                 elseif($rule['discount_type']=='Flat Discount'){   echo "   $Price ".__("Discount",'eh-dynamic-pricing-discounts' )."</td>";  }
                                 elseif($rule['discount_type']=='Fixed Price'){   echo "   $Price ".__("Fixed Price",'eh-dynamic-pricing-discounts' )."</td>";  }
                                 else{    echo " $Price ".__( $rule['discount_type'],'eh-dynamic-pricing-discounts' );}
                                 echo "</tr>";
                             }
                    }
                }
            }
            ?>
    
    </tbody>
    
    <tfoot></tfoot>
</table>


<?php      $output = ob_get_clean( );
if($count>1)
{
    echo $output;
}
