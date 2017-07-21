</br>
    <script>
    jQuery(function() {
        jQuery( ".datepicker" ).datepicker({
            dateFormat : "dd-mm-yy"
        });
    });
    
    jQuery(document).ready(function () {
         jQuery('#rule_on').change(function () {
                                                                            if(jQuery( 'option:selected',this).val()==='products')
                                                                            {
                                                                                    <?php if(is_wc_version_gt_eql('2.7'))
                                                                                    {  
                                                                                            echo "var selectbox ='";
                                                                                            eh_product_search_select2_field();
                                                                                            echo "'";
                                                                                    }else
                                                                                    {?>
                                                                                            var selectbox ='<input type="hidden" class="wc-product-search" data-multiple="true"  id="product_id" name="product_id" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations"  \
                                                                                    data-selected=""  value="" /> ';

                                                                                            <?php
                                                                                    }
                                                                                    ?>
                                                                                
                                                                                   jQuery(this).closest('td').next('td').html(selectbox);     
                                                                                   jQuery('.wc-product-search').trigger('wc-enhanced-select-init');
                                                                            }else if(jQuery( 'option:selected',this).val()==='categories')
                                                                            {
                                                                               
                                                                          <?php eh_categories_search_select2_field();			?>					
                                                           ;
                                                                                jQuery(this).closest('td').next('td').html(selectbox);         
                                                                                jQuery("#category_id").select2();
                                                                            }else{
																				jQuery(this).closest('td').next('td').html("<select id='product_category_combo'  name='product_category_combo' class='categorycombo' style='width:100%;' disabled ></select>");
																			}
                                                                           });
    });

    </script>
<table class="table"style="font-size: small;    margin: auto;  " >
	<thead style="font-size: inherit;">
		<tr style="font-size: inherit;">
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Offer Name','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Rule On','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Product','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Adjustment','eh-dynamic-pricing-discounts' ); ?></th>
			<th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Check on','eh-dynamic-pricing-discounts' ); ?></th>


		</tr>
	</thead>
	<tbody style="font-size: inherit;width: 100%;">
		<tr style="font-size: inherit;width: 100%;">
			<td style="font-size: inherit;width:16%;">
			<?php 
			//print_r($_GET);
			if(isset($_GET['edit']) && !empty($_GET['edit'])  )
			{
				echo '<input type="hidden" name="update" value="'.$_GET['edit'].'" >' ;
				
			}
			?>
			
			<input autocomplete="off" type=text name="offer_name"  size=13 style="font-size: inherit;width:100%" value="<?php if(!empty($_GET['offer_name'])) echo $_GET['offer_name'];  ?>"/>
			</td>
                        <td style="    width: 10%;">
                            
                            <select id="rule_on" name="rule_on" >
                                <option value="products"   <?php if(!empty($_GET['rule_on']) && $_GET['rule_on'] =='products') echo'Selected';  ?>   >Products</option>
                                <option value="categories" <?php if(!empty($_GET['rule_on']) && $_GET['rule_on'] =='categories') echo'Selected';  ?> >All Products in Category</option>                               
                                <option value="cart" <?php if(!empty($_GET['rule_on']) && $_GET['rule_on'] =='cart') echo'Selected';  ?> >All Products in Cart</option>                               
                                
                            </select>
                        </td>
                        
                            <td style="font-size: inherit;">
                            <?php   if ((isset($_GET['rule_on']) && $_GET['rule_on']=='products') || !isset($_GET['rule_on'])) { 
                                                                eh_product_search_select2_field();
                            } 
                            elseif(isset($_GET['rule_on']) && $_GET['rule_on']=='categories')
                            {
                                			echo '<select id="product_category_combo" class="categorycombo"   style="width:100%;"  name="category_id" id="category_id">';
				
				$selected_categories=array();
				if(isset($_GET['category_id']))
				{$selected_categories=array($_GET['category_id']);}
			
			$product_category=get_terms( 'product_cat', array('fields' => 'id=>name','hide_empty'=>false,'orderby' => 'title', 'order' => 'ASC',));

			if ($product_category) 
				foreach ( $product_category as $product_id=>$product_name) :
			echo '<option value="' . $product_id .'"';
			if (!empty($selected_categories) && in_array($product_id,$selected_categories)) echo ' selected="selected"';
			echo '>' . esc_js( $product_name ) . '</option>';
			endforeach;
																		
                                                   echo  "<select>";
                            } 
								else{
									echo "<select id='product_category_combo'  name='product_category_combo' class='categorycombo' style='width:100%;' disabled ></select>";
								}
                            ?>                                     
                                                                
                                                                
			</td>
                                                            <script type="text/javascript">
			jQuery(document).ready(function() {
			jQuery("#category_id").select2();
			});
			</script>
                                                            <td style="font-size: inherit;width:4%;"><input type=text name="adjustment" size=4 style="font-size: inherit;width: 100%;" value="<?php if(!empty($_GET['adjustment'])) echo $_GET['adjustment'];  ?>" ></td>
			<td style="font-size: inherit;width:8%;max-width:76px;min-width:76px;">
			<select name="check_on" class="all-options" style="font-size: inherit;width: 100%;min-width:76px;"  >
			<option value="Quantity"  style="font-size: inherit;" <?php if(!empty($_GET['check_on']) && $_GET['check_on'] =='Quantity')echo'Selected';  ?> ><?php _e('Quantity','eh-dynamic-pricing-discounts'); ?></option>
			<option value="Weight" style="font-size: inherit;" <?php if(!empty($_GET['check_on']) && $_GET['check_on'] =='Weight')echo'Selected';  ?>><?php _e('Weight','eh-dynamic-pricing-discounts'); ?></option>
			<option value="Price" style="font-size: inherit;" <?php if(!empty($_GET['check_on']) && $_GET['check_on'] =='Price')echo'Selected';  ?>><?php _e('Price','eh-dynamic-pricing-discounts'); ?></option>
			</select>
			</td>

		</tr>
		
	</tbody>
	<tfoot>
	</tfoot>
</table>
    
    <table class="table"style="font-size: small;    margin: auto;   margin-top: 30px;" >
	<thead style="font-size: inherit;">
                                <tr style="font-size: inherit;">
                                                <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Min','eh-dynamic-pricing-discounts' ); ?></th>
                                                <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Max','eh-dynamic-pricing-discounts' ); ?></th>
                                                <th style="word-wrap:break-word;width:5px;font-size: inherit;" class="xa-table-header" ><?php esc_attr_e( 'Discount Type','eh-dynamic-pricing-discounts' ); ?></th>
                                                <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Value','eh-dynamic-pricing-discounts' ); ?></th>                                      
                                                <th style="word-wrap: break-word;width: 10px;font-size: inherit;" class="xa-table-header" ><?php esc_attr_e( 'Max Discount','eh-dynamic-pricing-discounts' ); ?></th>
                                                <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'Allowed Roles','eh-dynamic-pricing-discounts' ); ?></th>
                                                <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'From Date','eh-dynamic-pricing-discounts' ); ?></th>
                                                <th class="xa-table-header" style="font-size: inherit;"><?php esc_attr_e( 'To Date','eh-dynamic-pricing-discounts' ); ?></th>
                                </tr>
	</thead>
        <tbody style="font-size: inherit;width: 100%;">
            			<td style="font-size: inherit;width:4%;"><input type=text name="min" size=1 style="font-size: inherit;width: 100%;" value="<?php if(!empty($_GET['min'])) echo $_GET['min'];  ?>" ></td>
			<td style="font-size: inherit;width:4%;"> <input type=text name="max" size=1 style="font-size: inherit;width: 100%;"  value="<?php if(!empty($_GET['max'])) echo $_GET['max'];  ?>" ></td>
			<td style="font-size: inherit;width:12%;max-width:125px;min-width:125px;">
			<select name="discount_type" id="discount_type" style="font-size: inherit;width: 100%;min-width:125px;" >
			<option value='Percent Discount' style="font-size: inherit;"   <?php if(!empty($_GET['discount_type']) && $_GET['discount_type'] =='Percent Discount') echo'Selected';  ?> ><?php _e('Percent Discount','eh-dynamic-pricing-discounts'); ?></option>
			<option value='Flat Discount' style="font-size: inherit;"   <?php if(!empty($_GET['discount_type']) && $_GET['discount_type'] =='Flat Discount') echo'Selected';  ?> ><?php _e('Flat Discount','eh-dynamic-pricing-discounts'); ?></option>
			<option value='Fixed Price' style="font-size: inherit;"   <?php if(!empty($_GET['discount_type']) && $_GET['discount_type'] =='Fixed Price') echo'Selected';  ?> ><?php _e('Fixed Price','eh-dynamic-pricing-discounts'); ?></option>
			</select>
			</td>
			<td style="font-size: inherit;width:4%;"><input type=text name="value" size=1 style="font-size: inherit;width: 100%;" value="<?php if(!empty($_GET['value'])) echo $_GET['value'];  ?>" ></td>
			
			<td style="font-size: inherit;width:4%;"><input type=text name="max_discount" size=1 style="font-size: inherit;width: 100%;"  value="<?php if(!empty($_GET['max_discount'])) echo $_GET['max_discount'];  ?>" ></td>
			</td>
			<td  style="overflow:visible;font-size: inherit;width:10%;max-width:110px;min-width:110px;">
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
        </tbody>
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


 

