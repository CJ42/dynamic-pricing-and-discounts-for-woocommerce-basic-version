</br>
    <script>
    jQuery(function() {
        jQuery( ".datepicker" ).datepicker({
            dateFormat : "dd-mm-yy"
        });
    });
	
	jQuery(window).load(function(){					
			
						jQuery('.insert').click( function() {
							var row_no=((jQuery('#product_list >tbody >tr').length)+1);
							var element_id="product_id" + row_no;
							jQuery('#product_list').append('<tr><td name="row_num">		\
		'  + row_no + '	\
		</td>	\
			<td>	\
			<?php
				if(is_wc_version_gt_eql('2.7'))
				{	?>
									<select  class="wc-product-search"  style="width: 100%;font-size: inherit;" name="'+element_id+'" id="'+ element_id +'" data-placeholder="Search for a product" data-action="woocommerce_json_search_products_and_variations" data-multiple="false" ></select>	\
			<?php
				}else{
					?>
				<input type="hidden" class="wc-product-search"  style="width: 100%;font-size: inherit;" name="'+element_id+'" id="'+ element_id +'" data-placeholder="Search for a product" data-action="woocommerce_json_search_products_and_variations" data-multiple="false" />	\
			<?php
				}
				?>
			</td>	\
			<td style="width: 20%;font-size: inherit;">	\
				<input type="number" name="quantity'+row_no+'" style="width: 100%;font-size: small;" value="1" />	\
			</td></tr>');
			jQuery('#'+element_id).trigger( 'wc-enhanced-select-init' );
								
	})
	
	})

    </script>
	<table name="product_list" id="product_list" class="widefat shipping_pro_boxes" style="width: 80%;font-size: inherit;">
	<thead style="font-size: inherit;">
		<tr style="font-size: inherit;">
			<th class="xa-table-header" style="font-size: inherit;width:10%"><?php esc_attr_e( '#Row no','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Product Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Quantity','eh-dynamic-pricing-discounts' ); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if(isset($_GET['product_id1']) && !empty($_GET['product_id1']) && isset($_GET['quantity1']) && !empty($_GET['quantity1']) && isset($_GET['edit']) && !empty($_GET['edit'])  )
	{
		echo '<input name="update"  type="hidden" value="'.$_GET['edit'].'" />';
		$pid_field='product_id1';
	$qnty_field='quantity1';
	$product_id_array=array();
	$fieldcount=1;
	do{						
			?>			
		<tr>
		<td name="row_num">
		<?php echo $fieldcount;?>
		</td>
			<td>
			<?php
			if(is_wc_version_gt_eql('2.7'))
			{	?>
				<select class="wc-product-search"  style="width: 50%;" name="<?php echo $pid_field; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations">
				<?php
					$product_id = $_GET[$pid_field];
					$product = wc_get_product( $product_id );
                    echo "<option value=$product_id   selected>".explode("<",$product->get_formatted_name() )[0]." </option>"; 
                    
					?>
				</select>	
				<?php
			}
			else{	?>
				
				                <input type="hidden" class="wc-product-search" data-multiple="false" style="width: 50%;" name="<?php echo $pid_field; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-selected="<?php
					$product_id = $_GET[$pid_field];
					$product = wc_get_product( $product_id );
                    echo explode("<",$product->get_formatted_name() )[0]; 
                    ?>" value="<?php echo $product_id; ?>" />
		<?php	}  ?>

				
			</td>

			<td style="width: 20%;font-size: inherit;">
				<input type="number" name="<?php echo $qnty_field;?>" style="width: 100%;font-size: small;"   value="<?php echo $_GET[$qnty_field]; ?>"  />
			</td>
		</tr>

	<?php 
			$fieldcount++;
			$pid_field='product_id'.$fieldcount;
			$qnty_field='quantity'.$fieldcount;
			
		}while(isset($_GET[$pid_field]) && !empty($_GET[$pid_field]) && isset($_GET[$qnty_field]) && !empty($_GET[$qnty_field]));
					
	}
	else
	{
		?><tr>
		<td name="row_num">
		1
		</td>
			<td>
			<?php if(is_wc_version_gt_eql('2.7')) {	?>
                <select type="hidden" class="wc-product-search" data-multiple="false" style="width: 100%;font-size: inherit;" name="product_id1" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations"  ></select>
			<?php }	
			else{		?>
				<input type="hidden" class="wc-product-search" data-multiple="false" style="width: 100%;font-size: inherit;" name="product_id1" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations"  />
				
		<?php	}	?>
				
			</td>

			<td style="width: 20%;font-size: inherit;">
				<input type="number" name="quantity1" style="width: 100%;font-size: small;"   value="1"  />
			</td>
		</tr>
		<?php 
	}		
	?>
		
		
	</tbody>
	<tfoot>
	<tr>
	<td colspan=3>
	<a href="#" class="button insert" name="insertbtn" id="insertbtn" ><?php _e('Add Rule','eh-dynamic-pricing-discounts'); ?></a></td>
	</tr>
	</tfoot>
	</table>
<table class="table"style="font-size: small;    margin: auto;" >
	<thead style="font-size: inherit;">
		<tr style="font-size: inherit;">
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Offer Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Adjustment','eh-dynamic-pricing-discounts' ); ?></th>
			<th style="word-wrap:break-word;width:5px;font-size: inherit;" class="xa-table-header" ><?php esc_attr_e( 'Discount Type','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Value','eh-dynamic-pricing-discounts' ); ?></th>
			<th style="word-wrap: break-word;width: 10px;font-size: inherit;" class="xa-table-header" ><?php esc_attr_e( 'Max Discount','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Allowed Roles','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'From Date','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'To Date','eh-dynamic-pricing-discounts' ); ?></th>
		</tr>
	</thead>
	<tbody style="font-size: inherit;width: 100%;">
		<tr style="font-size: inherit;width: 100%;">
			<td style="font-size: inherit;width:20%;">
			<?php 
			if(!empty($_GET['edit'])  )
			{
				echo '<input type="hidden" name="update" value="'.$_GET['edit'].'" >' ;
			}
			
			?>
			
			<input autocomplete="off" type=text name="offer_name"  size=13 style="font-size: inherit;width:100%" value="<?php if(!empty($_GET['offer_name'])) echo $_GET['offer_name'];  ?>"/>
			</td>
                                                            <td style="font-size: inherit;width:4%;"><input type=text name="adjustment" size=4 style="font-size: inherit;width: 100%;" value="<?php if(!empty($_GET['adjustment'])) echo $_GET['adjustment'];  ?>" ></td>
			<td style="font-size: inherit;width:8%;">
			<select name="discount_type" id="discount_type" style="font-size: inherit;width: 100%;min-width:100px;" >
			<option value='Percent Discount' style="font-size: inherit;"   <?php if(!empty($_GET['discount_type']) && $_GET['discount_type'] =='Percent Discount') echo'Selected';  ?> > <?php _e('Percent Discount','eh-dynamic-pricing-discounts'); ?></option>
			<option value='Flat Discount' style="font-size: inherit;"   <?php if(!empty($_GET['discount_type']) && $_GET['discount_type'] =='Flat Discount') echo'Selected';  ?> ><?php _e('Flat Discount','eh-dynamic-pricing-discounts'); ?></option>
			</select>
			</td>
			<td style="font-size: inherit;width:4%;"><input type=text name="value" size=1 style="font-size: inherit;width: 100%;" value="<?php if(!empty($_GET['value'])) echo $_GET['value'];  ?>" ></td>
			<td style="font-size: inherit;width:4%;"><input type=text name="max_discount" size=1 style="font-size: inherit;width: 100%;"  value="<?php if(!empty($_GET['max_discount'])) echo $_GET['max_discount'];  ?>" ></td>
			</td>
			<td  style="overflow:visible;font-size: inherit;width:10%;min-width:110px;">
				<select name="allow_roles" class="roles_select"  style="font-size: inherit;width: 100%;min-width:110px;">
					<?php 
					global $wp_roles;
					$roles = $wp_roles->get_names();    
					echo '<option value="all" ';
					if(!empty($_GET['allow_roles']) && $_GET['allow_roles'] =='all') 
					echo' Selected ';
					echo'>';
                                                                                                    
                                                                                                    _e('All','eh-dynamic-pricing-discounts'); 
                                                                                                    
                                                                                                    echo'</option>';
					foreach($roles as $key=>$value)
					{
					echo "<option value=$key ";
					if(!empty($_GET['allow_roles']) && $_GET['allow_roles'] ==$key) echo' Selected ';
					echo"	>";
                                                                                                    _e($value,'eh-dynamic-pricing-discounts');
                                                                                                    echo "</option>";
					}
					?>
				</select>
			</td>
			<td style="font-size: inherit;width:8%;min-width:80px;">
			<p class="form-field form-field-wide" style="font-size: inherit;width: 100%;">
				<input type="text" class="datepicker" name="from_date" id="from_date" maxlength="10" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}" placeholder="<?php _e('From Date','eh-dynamic-pricing-discounts'); ?>" style="font-size: inherit;width: 100%;min-width:80px;"  value="<?php if(!empty($_GET['from_date'])) echo $_GET['from_date'];  ?>"  >
				
			</p>
			</td>
			<td style="font-size: inherit;width:8%;min-width:80px;">
			<p class="form-field form-field-wide" style="font-size: inherit;width: 100%;">
				<input type="text" class="datepicker" name="to_date" id="to_date" maxlength="10" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}"  placeholder="<?php _e('To Date','eh-dynamic-pricing-discounts'); ?>" style="font-size: inherit;width: 100%;min-width:80px;"  value="<?php if(!empty($_GET['to_date'])) echo $_GET['to_date'];  ?>" >
				
			</p>
			</td>
			
		</tr>
		
	</tbody>
	<tfoot>
	</tfoot>
</table>


<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php 
if(isset($_GET['edit']))
{
	_e('Update Rule','eh-dynamic-pricing-discounts');;
}
else
{
	_e('Save New Rule','eh-dynamic-pricing-discounts');
}


?>"></p>

