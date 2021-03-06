<table class="display_all_rules table widefat" style=" border-collapse: collapse;">
<thead style="font-size: smaller;background-color: lightgrey;">
		<tr style="font-size: inherit; border-bottom-style: solid; border-bottom-width: thin;">
			<th class="xa-table-header" style="font-size: inherit;word-wrap: break-word; width: 10px;"><?php esc_attr_e( 'Rule no.','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Offer Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Purchased Product','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Purchased Quantity','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Free Product','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Free Quantity','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Allowed Roles','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'From Date','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'To Date','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;padding-right: 4px;padding-left: 4px;"><?php esc_attr_e( 'Adjustment','eh-dynamic-pricing-discounts' ); ?></th>	
                                                            <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Alter','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Delete','eh-dynamic-pricing-discounts' ); ?></th>
                 </tr>
	</thead>
<tbody style="font-size: smaller;">
<?php
$allrules=array();
$allrules=get_option("xa_dp_rules",array());
if(isset($allrules['buy_get_free_rules']))
{	
$allrules=$allrules['buy_get_free_rules'];
foreach($allrules as $key=>$value)
{	
$customclass='';
if(isset($_GET['delete']) )
if($key==$_GET['delete'])
{$customclass='deleting';}

if(!isset($value['adjustment'])) {$value['adjustment']=null;}
echo '<tr class="'.$customclass.'" style="font-size: inherit;border-bottom: lightgrey; border-bottom-style: solid; border-bottom-width: thin;"><td>'.$key.'</td>';
	foreach($value as $key2=>$value2)
	{
		if($key2=='offer_name')
		{
			echo "<td style=\"font-size: inherit;width:15%;\">";
			if(!empty($value2))
				echo $value2;
			else
				echo '  -  ';
			echo "</td>";
		}
		elseif($key2=='purchased_product_id')
		{	
			echo '<td style="font-size: inherit;width:15%;">';
			foreach($value2 as $pid=>$qnty)
			{
				$product = wc_get_product( $pid );
				echo '<span style="font-size: inherit;float:none;display: table-row; margin-top:10px" class="product_name highlight" id='.$pid.'>'.$product->get_formatted_name().'</span>';
			}
			echo "</td>";
			
			echo '<td style="font-size: inherit;width:5%;">';
			foreach($value2 as $pid=>$qnty)
			{
				$product = wc_get_product( $pid );
				echo '<span style="font-size: inherit;display: table-row;" class="product_quantity" id='.$pid.'>'.$qnty.'</span>';
			}
			echo "</td>";
		}
		elseif($key2=='free_product_id')
		{	
			echo '<td style="font-size: inherit;width:15%;">';
			foreach($value2 as $pid=>$qnty)
			{
				$product = wc_get_product( $pid );
				echo '<span style="font-size: inherit;float:none;display: table-row; margin-top:10px" class="product_name highlight" id='.$pid.'>'.$product->get_formatted_name().'</span>';
			}
			echo "</td>";
			
			echo '<td style="font-size: inherit;width:5%;">';
			foreach($value2 as $pid=>$qnty)
			{
				$product = wc_get_product( $pid );
				echo '<span style="font-size: inherit;display: table-row;" class="product_quantity" id='.$pid.'>'.$qnty.'</span>';
			}
			echo "</td>";
		}
		else
		{
			echo "<td style=\"font-size: inherit; \">";
			if(!empty($value2))
				echo $value2;
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