</br>
    <script>
    jQuery(function() {
        jQuery( ".datepicker" ).datepicker({
            dateFormat : "dd-mm-yy"
        });
    });
	
	jQuery(window).load(function(){					
			
						jQuery('.insertpurchased').click( function() {
							var row_no=((jQuery('#purchased_product_list >tbody >tr').length)+1);
							var element_id="purchased_product_id" + row_no;
							jQuery('#purchased_product_list').append('<tr><td name="row_num">		\
		'  + row_no + '	\
		</td>	\
			<td>	\
			<?php 
			global $wpdb;
			try
			{
				$product_var=$wpdb->get_col( $wpdb->prepare( 
				"SELECT distinct ID FROM $wpdb->posts
										join
											(SELECT distinct post_id FROM $wpdb->postmeta where meta_key =%s 
											and meta_value<>%s) as t1 
										on ID=t1.post_id where ping_status='closed' 
											and post_parent=0 and post_status='publish' and post_type='product'
				",'_product_attributes','a:0:{}'
			) ); 
			} catch (Exception $ex) {

			}
			if(is_wc_version_gt_eql('2.7'))
			{	?>
			<select  class="wc-product-search"  style="width: 100%;font-size: inherit;" name="'+element_id+'" id="'+ element_id +'" data-placeholder="Search for a product" data-action="woocommerce_json_search_products_and_variations" > \
			</select> \
			<?php }
			else{	?>
				<input type="hidden" class="wc-product-search"  style="width: 100%;font-size: inherit;" name="'+element_id+'" id="'+ element_id +'" data-placeholder="Search for a product" data-action="woocommerce_json_search_products_and_variations" data-multiple=""    data-exclude="<?php 

                        if(!empty($product_var))
                        {
                            echo implode(',',$product_var);
                        }
                        ?>" />	\
		<?php }
			?>
			</td>	\
			<td style="width: 20%;font-size: inherit;">	\
				<input type="number" name="purchased_quantity'+row_no+'" style="width: 100%;font-size: small;" value="1" />	\
			</td></tr>');
			jQuery('#'+element_id).trigger( 'wc-enhanced-select-init' );
								
	})
	
	})
	jQuery(window).load(function(){					
			
						jQuery('.insertfree').click( function() {
							var row_no=((jQuery('#free_product_list >tbody >tr').length)+1);
							var element_id="free_product_id" + row_no;
							jQuery('#free_product_list').append('<tr><td name="row_num">		\
		'  + row_no + '	\
		</td>	\
			<td>	\
			<?php if(is_wc_version_gt_eql('2.7'))
			{	?>
			<select  class="wc-product-search"  style="width: 100%;font-size: inherit;" name="'+element_id+'" id="'+ element_id +'" data-placeholder="Search for a product" data-action="woocommerce_json_search_products_and_variations" > \
			</select> \
			<?php }
			else{	?>
				<input type="hidden" class="wc-product-search"  style="width: 100%;font-size: inherit;" name="'+element_id+'" id="'+ element_id +'" data-placeholder="Search for a product" data-action="woocommerce_json_search_products_and_variations" data-multiple=""    data-exclude="<?php 

                        if(!empty($product_var))
                        {
                            echo implode(',',$product_var);
                        }
                        ?>" />	\
		<?php }
			?>
			</td>	\
			<td style="width: 20%;font-size: inherit;">	\
				<input type="number" name="free_quantity'+row_no+'" style="width: 100%;font-size: small;" value="1" />	\
			</td></tr>');
			jQuery('#'+element_id).trigger( 'wc-enhanced-select-init' );
								
	})
	
	})

    </script>
    <!----------------------------------------------------------------------Purchased Products Table--------------------------------------------------------------->
    
    <span ><h2 style="text-align:center;background: lightgray;">Purchased Products Table </h2><span style="text-align:center;background: lightblue;font-size: 12px;display: block;margin-bottom: 10px;margin-top: -10px;">(If the below combination of products is found the rule will be set as valid and free products will be automatically added to cart)</span></span>
    
	<table name="purchased_product_list" id="purchased_product_list" class="widefat" style="width: 80%;font-size: inherit;">
	<thead style="font-size: inherit;">
		<tr style="font-size: inherit;">
			<th class="xa-table-header" style="font-size: inherit;width:10%"><?php esc_attr_e( '#Row no','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Product Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Quantity','eh-dynamic-pricing-discounts' ); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if(isset($_GET['purchased_product_id1']) && !empty($_GET['purchased_product_id1']) && isset($_GET['purchased_quantity1']) && !empty($_GET['purchased_quantity1']) && isset($_GET['edit']) && !empty($_GET['edit'])  )
	{
		echo '<input name="update"  type="hidden" value="'.$_GET['edit'].'" />';
		$pid_field='purchased_product_id1';
	$qnty_field='purchased_quantity1';
	$product_id_array=array();
	$fieldcount=1;
	do{		
				
			?>			
		<tr>
		<td name="row_num">
		<?php echo $fieldcount;?>
		</td>
			<td>
			<?php if(is_wc_version_gt_eql('2.7'))
			{	?>
				                <select class="wc-product-search" data-multiple="false" style="width: 50%;" name="<?php echo $pid_field; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" ><?php
					$product_id = $_GET[$pid_field];
					$product = wc_get_product( $product_id );
                    echo "<option value=".$product_id." selected> ".$product->get_formatted_name()."</option>"; 
                    ?>  </select>		
			
		<?php	}
			else
			{	?>
				                <input type="hidden" class="wc-product-search" data-multiple="false" style="width: 50%;" name="<?php echo $pid_field; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-selected="<?php
					$product_id = $_GET[$pid_field];
					$product = wc_get_product( $product_id );
                    echo explode("<",$product->get_formatted_name() )[0]; 
                    ?>" value="<?php echo $product_id; ?>"     data-exclude="<?php 
                        if(!empty($product_var))
                        {
                            echo implode(',',$product_var);
                        }
                        ?>"  />
	<?php   } ?>

				
			</td>

			<td style="width: 20%;font-size: inherit;">
				<input type="number" name="<?php echo $qnty_field;?>" style="width: 100%;font-size: small;"   value="<?php echo $_GET[$qnty_field]; ?>"  />
			</td>
		</tr>

	<?php 
			$fieldcount++;
			$pid_field='purchased_product_id'.$fieldcount;
			$qnty_field='purchased_quantity'.$fieldcount;
			
		}while(isset($_GET[$pid_field]) && !empty($_GET[$pid_field]) && isset($_GET[$qnty_field]) && !empty($_GET[$qnty_field]));
					
	}
	else
	{
		?><tr>
		<td name="row_num">
		1
		</td>
			<td>
			<?php if(is_wc_version_gt_eql('2.7'))
			{	?>
				                <select class="wc-product-search" data-multiple="false" style="width: 50%;" name="purchased_product_id1" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" ></select>			
			
		<?php	}
			else
			{	?>
				<input type="hidden" class="wc-product-search cls" data-multiple="false" style="width: 100%;font-size: inherit;" name="purchased_product_id1" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations"   data-exclude="<?php 
										if(!empty($product_var))
										{
											echo implode(',',$product_var);
										}
										?>"   />
	<?php   } ?>
                
			</td>

			<td style="width: 20%;font-size: inherit;">
				<input type="number" name="purchased_quantity1" style="width: 100%;font-size: small;"   value="1"  />
			</td>
		</tr>
		<?php 
	}		
	?>
		
		
	</tbody>
	<tfoot>
	<tr>
	<td colspan=3>
	<a href="#" class="button insert insertpurchased" name="insertbtn" id="insertbtn" ><?php esc_attr_e( 'Add Rule','eh-dynamic-pricing-discounts' ); ?></a></td>
	</tr>
	</tfoot>
	</table>
    <!----------------------------------------------------------------------End of Free Products Table--------------------------------------------------------------->
    
    <!--------------------------------------------------------------Table For Free Products--------------------------------------------------------------------------->
    <span ><h2 style="text-align:center;background: lightgray;">Free Products Table </h2><span style="text-align:center;background: lightblue;font-size: 12px;display: block;margin-bottom: 10px;margin-top: -10px;">(The Below Products Will Be Automatically Added to Cart if the rule is valid)</span></span>
    <table name="free_product_list" id="free_product_list" class="widefat" style="width: 80%;font-size: inherit;">
	<thead style="font-size: inherit;">
		<tr style="font-size: inherit;">
			<th class="xa-table-header" style="font-size: inherit;width:10%"><?php esc_attr_e( '#Row no','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Product Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Quantity','eh-dynamic-pricing-discounts' ); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if(isset($_GET['free_product_id1']) && !empty($_GET['free_product_id1']) && isset($_GET['free_quantity1']) && !empty($_GET['free_quantity1']) && isset($_GET['edit']) && !empty($_GET['edit'])  )
	{
	echo '<input name="update"  type="hidden" value="'.$_GET['edit'].'" />';
	$pid_field='free_product_id1';
	$qnty_field='free_quantity1';
	$product_id_array=array();
	$fieldcount=1;
	do{		
				
			?>			
		<tr>
		<td name="row_num">
		<?php echo $fieldcount;?>
		</td>
			<td>
<?php if(is_wc_version_gt_eql('2.7'))
			{	?>
				                <select class="wc-product-search" data-multiple="false" style="width: 50%;" name="<?php echo $pid_field; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" ><?php
					$product_id = $_GET[$pid_field];
					$product = wc_get_product( $product_id );
                    echo "<option value=".$product_id." selected> ".$product->get_formatted_name()."</option>"; 
                    ?>  </select>		
			
		<?php	}
			else
			{	?>
				                <input type="hidden" class="wc-product-search" data-multiple="false" style="width: 50%;" name="<?php echo $pid_field; ?>" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-selected="<?php
					$product_id = $_GET[$pid_field];
					$product = wc_get_product( $product_id );
                    echo explode("<",$product->get_formatted_name() )[0]; 
                    ?>" value="<?php echo $product_id; ?>"     data-exclude="<?php 
                        if(!empty($product_var))
                        {
                            echo implode(',',$product_var);
                        }
                        ?>"  />
	<?php   } ?>

				
			</td>

			<td style="width: 20%;font-size: inherit;">
				<input type="number" name="<?php echo $qnty_field;?>" style="width: 100%;font-size: small;"   value="<?php echo $_GET[$qnty_field]; ?>"  />
			</td>
		</tr>

	<?php 
			$fieldcount++;
			$pid_field='free_product_id'.$fieldcount;
			$qnty_field='free_quantity'.$fieldcount;
			
		}while(isset($_GET[$pid_field]) && !empty($_GET[$pid_field]) && isset($_GET[$qnty_field]) && !empty($_GET[$qnty_field]));
					
	}
	else
	{
		?><tr>
		<td name="row_num">
		1
		</td>
			<td>
			<?php if(is_wc_version_gt_eql('2.7'))
			{	?>
				                <select class="wc-product-search" data-multiple="false" style="width: 50%;" name="free_product_id1" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" ></select>			
			
		<?php	}
			else
			{	?>
				<input type="hidden" class="wc-product-search cls" data-multiple="false" style="width: 100%;font-size: inherit;" name="free_product_id1" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;','eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations"   data-exclude="<?php 
										if(!empty($product_var))
										{
											echo implode(',',$product_var);
										}
										?>"   />
	<?php   } ?>
                
			</td>

			<td style="width: 20%;font-size: inherit;">
				<input type="number" name="free_quantity1" style="width: 100%;font-size: small;"   value="1"  />
			</td>
		</tr>
		<?php 
	}		
	?>
		
		
	</tbody>
	<tfoot>
	<tr>
	<td colspan=3>
	<a href="#" class="button insert insertfree" name="freeinsertbtn" id="freeinsertbtn" ><?php esc_attr_e( 'Add Rule','eh-dynamic-pricing-discounts' ); ?></a></td>
	</tr>
	</tfoot>
	</table>
    <!----------------------------------------------------------------------End of Free Products Table--------------------------------------------------------------->
    
<table class="table"style="font-size: small;    margin: auto;" >
	<thead style="font-size: inherit;">
		<tr style="font-size: inherit;">
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Offer Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Adjustment','eh-dynamic-pricing-discounts' ); ?></th>
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
			<td style="font-size: inherit;width:4%;"><input type=text name="adjustment" size=1 style="font-size: inherit;width: 100%;" value="<?php if(!empty($_GET['adjustment'])) echo $_GET['adjustment'];  ?>" ></td>
			
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

