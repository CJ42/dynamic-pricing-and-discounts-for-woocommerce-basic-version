<?php  
add_shortcode('eha_dynamic_pricing_offers_list_short_code', 'eha_dynamic_pricing_offers_list_short_code');
function eha_dynamic_pricing_offers_list_short_code($atts, $content = null)
{
            $selected_type='';
            if(!empty($atts)  && isset($atts['type']))
            {
                $selected_type=$atts['type'];
            }
            $dummy_option=array('buy_get_free_rules'=>array(),);
            $rules_option_array=get_option('xa_dp_rules',$dummy_option);
            foreach($rules_option_array as $rule_type=>$rule_array)      
            {
                if(!empty($selected_type)  && $rule_type!=$selected_type) continue;
                $offertp=ucwords($rule_type);
                $offertp= str_replace('Cat_combinational', 'Category Combinational ', $offertp);
                $offertp= str_replace('Buy_get_free_rules', 'BOGO', $offertp);
                $offertp=explode('_',$offertp);
                $offertp=$offertp[0];
                $offertp=$offertp.' Offers';
                if(empty($rule_array)) continue;
              echo   "<div id='offertype' name='offertype' class='offertype $rule_type'>";
              echo "<h2>".$offertp."</h2><table class='widefat fixed'>";
              echo "<tr id=offerrow_head' class='offerrow_head' font-size='14px'>"
                    . "<th class='offername_head' width='25%'>Offer Name</th>"
                    . "<th class='ofrmin_head' width='15%'>Buy Minimum</th>"
                    . "<th class='ofrmax_head' width='15%'>Buy Maximum</th>"
                    . "<th class='offervalue_head' width='15%'>Offer value</th>"
                    . "<th class='offermaxdis_head' width='10%'>Maximum Discount</th>"
                    . "<th class='offerdate_head' width='20%'>Valid Till</th>"
                                . "</tr>";
                foreach($rule_array as $ruleno=>$rule)
                    {
                            $fromdate=$rule['from_date'];
                            $todate=$rule['to_date'];
                            $user_role=$rule['allow_roles'];
                            $offer_name=$rule['offer_name'];
                            if( $user_role=='all' || current_user_can($user_role)){} else{ continue;}
                            $now=date('d-m-Y');
                            $return=false;
                            if(empty($fromdate) && empty($todate)) {}
                            elseif(empty($fromdate) && empty($todate)==false  && (strtotime($now) <= strtotime($todate))) {}
                            elseif(empty($fromdate)==false && (strtotime($now) >= strtotime($fromdate)) && empty($todate)) {}
                            elseif((strtotime($now) >= strtotime($fromdate))  && (strtotime($now) <= strtotime($todate))) {}
                            else{continue; }
                            $rule['max_discount']=empty($rule['max_discount'])?'-':wc_price($rule['max_discount']);
                            $rule['max']=empty($rule['max'])?'-':($rule['max']."  </br>".$rule['check_on']);
                            $rule['min']=empty($rule['min'])?'-':($rule['min']."  </br>".$rule['check_on']);
                            $rule['value']=empty($rule['value'])?'-':($rule['value']. "</br>(".$rule['discount_type'].")");
                            echo "<tr id=offerrow' class='offerrow ' style='font-size:14px;padding:2px;'>"
                            . "<td class='offername' style='padding:10px;'>".$rule['offer_name']."</td>"
                            . "<td class='ofrmin'  style='text-align:center;padding:5px;'>".$rule['min']."  </td>"
                            . "<td class='ofrmax'  style='text-align:center;padding:5px;'>".$rule['max']."  </td>"
                            . "<td class='offervalue' style='text-align:center;padding:5px;'>".$rule['value']."</td>"
                            . "<td class='offermaxdis'  style='text-align:center;padding:5px;'>".$rule['max_discount']."</td>"
                            . "<td class='offerdate'  style='text-align:center;padding:5px;'>".$rule['to_date']."</td>"
                                        . "</tr>";
                    }              
               echo "</table></div>";         
            }

}

 function get_product_category_by_id( $category_id ) {
    $term = get_term_by( 'id', $category_id, 'product_cat', 'ARRAY_A' );
    return $term['name'];
}
function eh_categories_search_select2_field()
{
	
				$selected_categories=array();
				if(isset($_GET['category_id']))
				{$selected_categories=array($_GET['category_id']);}
			
			$product_category=get_terms( 'product_cat', array('fields' => 'id=>name','hide_empty'=>false,'orderby' => 'title', 'order' => 'ASC',));
                                                                echo 'var selectbox =\'<select id="product_category_combo" class="categorycombo"   style="width:100%;"  name="category_id"> ';
			if ($product_category) 
				foreach ( $product_category as $product_id=>$product_name) :
			echo '<option value="' . $product_id .'" >' . esc_js( $product_name ) . '</option> ';
			endforeach;
			echo "</select>'";
}

function eh_product_search_select2_field($name='product_id',$style="width:100%;",$tab='product_rules',$multiple=true)
{
	if(is_wc_version_gt_eql('2.7'))
	{
		echo '<select style='.$style;
		if($multiple) echo ' multiple="multiple" ';
		echo 'data-action="woocommerce_json_search_products_and_variations" class="wc-product-search" name="'.$name.'[]" id="'.$name.'[]" data-placeholder="';esc_attr_e( 'Search for a product&hellip;', 'eh-dynamic-pricing-discounts' ); echo '" >';

                                        if(isset($_GET['edit']))
                                       {
                                            $rules=get_option('xa_dp_rules');
                                            $opn=$rules[$tab][$_GET['edit']];
                                        }
		if(isset($opn[$name]))
		foreach ( $opn[$name] as $product_id ) {
				$product = wc_get_product( $product_id );
				if ( is_object( $product ) ) {
					echo '<option value="' . esc_attr( $product_id ) . '"' . str_replace("'",'"',selected( true, true, false )) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
				}
		}
		echo "</select>";
	}
	else{  ?>
<input type="hidden" class="wc-product-search" data-multiple="true"  name="product_id" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'eh-dynamic-pricing-discounts' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-selected="<?php
                                                                $json_ids    = array();
                                                                if(isset($_GET['edit']))
                                                               {
                                                                    $rules=get_option('xa_dp_rules');
                                                                    $opn=$rules[$tab][$_GET['edit']];
                                                                }
                                                                if(isset($opn['product_id']))
                                                                foreach ( $opn['product_id'] as $product_id ) {
                                                                        $product = wc_get_product( $product_id );
                                                                        if ( is_object( $product ) ) {
                                                                                $json_ids[ $product_id ] = wp_kses_post( $product->get_formatted_name() );
                                                                        }
                                                                }

                                                                echo esc_attr( json_encode( $json_ids ) );
                                                                ?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />
<?php
	}
	
}


function is_wc_version_gt_eql( $version )
{
    return eha_get_wc_version() && version_compare( eha_get_wc_version(), $version, '>=' );
}
if ( ! function_exists( 'eha_get_wc_version' ) )
{
	function eha_get_wc_version() {
		// If get_plugins() isn't available, require it
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// Create the plugins folder and file variables
		$plugin_folder = get_plugins( '/' . 'woocommerce' );
		$plugin_file = 'woocommerce.php';

		// If the plugin version number is set, return it
		if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
			return $plugin_folder[$plugin_file]['Version'];

		} else {
			// Otherwise return null
			global $woocommerce;
			return get_option( 'woocommerce_version', null );
		}
	}	
	
}

			function eha_get_products_from_category_by_ID( $category_id ) 
			{

											$products_IDs = new WP_Query( array(
															'post_type' => 'product',
															'post_status' => 'publish',
															'fields' => 'ids', 
															'tax_query' => array(
																			array(
																							'taxonomy' => 'product_cat',
																							'field' => 'term_id',
																							'terms' => $category_id,
																							'operator' => 'IN',
																			)
															)
											) );
											
											return $products_IDs->posts;
							}
