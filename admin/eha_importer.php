<?php
	if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
    add_action( 'admin_init', 'eha_import_rules' );
   function eha_import_rules()
    {  
       $rules_array=get_option("xa_dp_rules",array());
       $col_names_default=array();
       $col_names_default['product_rules']=array('offer_name','rule_on','product_id','category_id','check_on','min','max','discount_type','value','max_discount','allow_roles','from_date','to_date','adjustment',);
       $col_names_default['combinational_rules']=array("offer_name",  "product_id",  "discount_type",  "value",  "max_discount",  "allow_roles",  "from_date",  "to_date",  "adjustment",  );
       $col_names_default['cat_combinational_rules']=array("offer_name",  "cat_id",  "discount_type",  "value",  "max_discount",  "allow_roles",  "from_date",  "to_date",  "adjustment", );
       $col_names_default['category_rules']=array("offer_name",  "category_id",  "check_on",  "min",  "max",  "discount_type",  "value",  "max_discount",  "allow_roles",  "from_date",  "to_date",  "adjustment",  );
       $col_names_default['cart_rules']=array("offer_name",  "check_on",  "min",  "max",  "discount_type",  "value",  "max_discount",  "allow_roles",  "from_date",  "to_date",  "adjustment",  );
       $col_names_default['buy_get_free_rules']=array("offer_name",  "purchased_product_id",  "free_product_id",  "allow_roles",  "from_date",  "to_date",  "adjustment",  );
       $colums_which_are_array_type=array('product_id' , 'cat_id' , 'purchased_product_id','free_product_id',); 
       if(isset($_POST['import_tab']) && !empty($_POST['import_tab']))
       {
           $tab=$_POST['import_tab'];
           $col_names=$col_names_default[$tab];
           $tmp=explode( '.', $_FILES['import_file']['name'] );
            $extension = end($tmp  );
           if( $extension != 'csv' ) {
                   wp_die( __( 'Please upload a valid .csv file' ) );
           }
           else
           {
               	$import_file = $_FILES['import_file']['tmp_name'];
	if( empty( $import_file ) ) {
		wp_die( __( 'Please upload a file to import' ) );
	}
                    $settings = file_get_contents( $import_file ) ;
                    $settings=explode("\r",$settings);
                    $header_present=false;
                    foreach($settings as $row)
                    {
                        $row= trim(str_replace("\n", "", $row));
                        $new_rule=array();
                        $cols=explode(',',$row);
                        if($cols[0]=='offer_name' && $header_present==false )
                        {   $header_present=true;
                            $col_names=array();
                            foreach($cols as $field)
                            {
                                $col_names[]=$field;
                            }      
                        }
                        else
                        {       
                                foreach($col_names as $field)
                                   {    
                                        $val=trim(current($cols));
                                        if(empty($val)) continue;
                                        if( in_array($field,$colums_which_are_array_type)===true &&  $val!="NULL" ) {
                                                  
                                                  $ary=explode(':',current($cols));   
                                                  $new_arr=array();
                                                  foreach($ary as $element)
                                                  {
                                                        $key_and_val=explode('<=',$element);
                                                        $ival=current($key_and_val);
                                                        $ikey=end($key_and_val);
                                                        if($ival!==$ikey)
                                                        {
                                                            $new_arr[$ikey]=$ival;
                                                        }else
                                                        {
                                                            $new_arr[]=$ival;
                                                        }
                                                  }
                                                  $new_rule[$field]=$new_arr;
                                                  next($cols);
                                        }
                                        else
                                        {
                                                if($val=="NULL") $val=NULL;
                                                $new_rule[$field]=$val;           
                                                next($cols);
                                        }
                                   }
                                  if(!empty($new_rule)) 
                                  {
                                      if(empty($rules_array[$tab]))
                                      {
                                            $rules_array[$tab][1]=$new_rule;                                                 
                                      }
                                      else
                                      {
                                            $rules_array[$tab][]=$new_rule;                                                 
                                      }
                              
                                  }
                        }
                    }
                   update_option('xa_dp_rules',$rules_array);
					function eha_admin_notice_import_success() {
						?>
						<div class="notice notice-success is-dismissible" style="background: chartreuse;">
							<p><?php _e( 'Imported Successfully!', 'eh-dynamic-pricing-discounts' ); ?></p>
						</div>
						<?php
					}
					add_action( 'admin_notices', 'eha_admin_notice_import_success' );
           }
       }

}