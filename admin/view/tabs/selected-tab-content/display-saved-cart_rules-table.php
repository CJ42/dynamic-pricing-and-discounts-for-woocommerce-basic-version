<table class="display_all_rules table widefat" style=" border-collapse: collapse;width:100%;">
<thead style="font-size: smaller;background-color: lightgrey;">
		<tr style="font-size: inherit; border-bottom-style: solid; border-bottom-width: thin;">
			<th class="xa-table-header" style="font-size: inherit;word-wrap: break-word; width: 10px;"><?php esc_attr_e( 'Rule no.','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Offer Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Check on','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Min','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Max','eh-dynamic-pricing-discounts' ); ?></th>
			<th style="word-wrap:break-word;width:5px;font-size: inherit;" class="xa-table-header" ><?php esc_attr_e( 'Discount Type','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Value','eh-dynamic-pricing-discounts' ); ?></th>
			<th style="word-wrap: break-word;width: 10px;font-size: inherit;" class="xa-table-header" ><?php esc_attr_e( 'Max Discount','eh-dynamic-pricing-discounts' ); ?></th>
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
$allrules=get_option('xa_dp_rules',array());
if(isset($allrules['cart_rules']))
{	

$allrules=$allrules['cart_rules'];
foreach($allrules as $key=>$value)
{	echo '<tr style="font-size: inherit;border-bottom: lightgrey; border-bottom-style: solid; border-bottom-width: thin;"><td>'.$key.'</td>';
	if(!isset($value['adjustment'])) {$value['adjustment']=null;}
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
                		elseif($key2=='check_on')
		{
			echo "<td style=\"font-size: inherit; \">";
			if(!empty($value2))
				esc_attr_e(  str_replace('Quantity','No. of Items',$value2),'eh-dynamic-pricing-discounts' );
			else
				echo '  -  ';
			echo "</td>";
		}
		else
		{
			echo "<td style=\"font-size: inherit; \">";
			if(!empty($value2))
				esc_attr_e( $value2,'eh-dynamic-pricing-discounts' );
			else
				echo '  -  ';
			echo "</td>";
		}

	}
	echo "<td>";
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