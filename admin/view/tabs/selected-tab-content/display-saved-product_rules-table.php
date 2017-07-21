<table class="display_all_rules table widefat" style=" border-collapse: collapse;">
<thead style="font-size: smaller;background-color:lightgrey;">
		<tr style="font-size: inherit; border-bottom-style: solid; border-bottom-width: thin;">
			<th class="xa-table-header" style="font-size: inherit;word-wrap: break-word; width: 10px;"><?php esc_attr_e( 'Rule no.','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Offer Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Rule on','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Product/Category','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Check on','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Min','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Max','eh-dynamic-pricing-discounts' ); ?></th>
			<th style="word-wrap:break-word;width:5px;font-size: inherit;padding-right: 4px;padding-left: 4px;" class="xa-table-header" ><?php esc_attr_e( 'Discount Type','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Value','eh-dynamic-pricing-discounts' ); ?></th>
			<th style="word-wrap: break-word;width: 10px;font-size: inherit;padding-right: 4px;padding-left: 4px;" class="xa-table-header" ><?php esc_attr_e( 'Max Discount','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Allowed Roles','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'From Date','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'To Date','eh-dynamic-pricing-discounts' ); ?></th>
                                                            <th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Adjustment','eh-dynamic-pricing-discounts' ); ?></th>
			
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Alter','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Delete','eh-dynamic-pricing-discounts' ); ?></th>
		</tr>           
	</thead>
<tbody style="font-size: smaller;">
<?php
$allrules=array();
$allrules=get_option("xa_dp_rules",array());
if(isset($allrules['product_rules']))
{	
$allrules=$allrules['product_rules'];
foreach($allrules as $key=>$value)
{	
$customclass='';
if(isset($_GET['delete']) )
if($key==$_GET['delete'])
{$customclass='deleting';}

if(!isset($value['adjustment'])) {$value['adjustment']=null;}
echo '<tr class="'.$customclass.'" style="font-size: inherit;border-bottom:lightgrey; border-bottom-style: solid; border-bottom-width: thin;"><td>'.$key.'</td>';
	foreach($value as $key2=>$value2)
	{                  if($key2=='rule_on')
                                        {
                                                if($value2=='categories')
                                                {
                                                    $value2='All Products in';
                                                }
                                                elseif($value2=='products')
                                                {
                                                        $value2="Products";
                                                }
                                                else
                                                {
                                                      
                                                }
                                                
                                        
                                        }
                                        
                                    if( ($key2=='product_id' && empty($value2)) || ($key2=='category_id'  && empty($value2)) ) continue;
		if($key2=='product_id' && !empty($value2))
		{
                                                             echo '<td style="font-size: inherit;width:15%;padding-right: 4px;padding-left: 4px;" class="product_name" id='.implode(',',$value2).'>';
                                                            foreach($value2 as $_pid)
                                                            {
                                                                $product = wc_get_product( $_pid );
                                                               echo '<span class="highlight">'.$product->get_formatted_name().'</span></br>';
                                                            }
                                                            echo '</td>';
                                        }
		elseif($key2=='offer_name')
		{
			echo "<td style=\"font-size: inherit;width:12%;padding-right: 4px;padding-left: 4px;\">";
			if(!empty($value2))
				echo $value2;
			else
				echo '  -  ';
			echo "</td>";
                                                    if(!isset($value['rule_on']))
                                                    {
                                                        echo "<td style=\"font-size: inherit; padding-right: 4px;padding-left: 4px;\">";
			if(!empty($value2))
				echo "Products";
			echo "</td>";
                                                    }
                    
		}
		elseif($key2=='category_id'  && !empty($value2))
		{
			$category=get_product_category_by_id($value2);
			echo '<td style="font-size: inherit;width:10%;padding-right: 4px;padding-left: 4px;" class="category_name" id='.$value2.'><span class=" highlight">'.$category.'</span></td>';
		}
		else
		{
			echo "<td style=\"font-size: inherit;padding-right: 4px;padding-left: 4px; \">";
			if(!empty($value2))
				esc_attr_e( $value2,'eh-dynamic-pricing-discounts' );
			else
				echo '  -  ';
			echo "</td>";
		}

	}
	echo '<td style="margin-left: 0px; margin-right: 0px; padding-left: 0px; padding-right: 0px;">';
	echo '<button  type="submit" name="edit" value="'.$key.'" >'.__( 'Edit','eh-dynamic-pricing-discounts' ).'</button></td>';
	echo '<td><button  type="submit" name="delete" value="'.$key.'" >'.__( 'Delete','eh-dynamic-pricing-discounts' ).'</button>';
	echo "</td>";
	echo '</tr>';
}

}
?>
</tbody>
<tfoot></tfoot>
</table>