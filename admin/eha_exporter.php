<?php
	if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }   
    add_action( 'admin_init', 'eha_export_rules' );
   function eha_export_rules()
    {   
        if(isset($_POST['eha-export']))
       {
           $rules=get_option("xa_dp_rules",array());
           $tab_c=$_POST['tab'];
           nocache_headers();
           header( 'Content-Type: application/csv; charset=utf-8' );
           header( 'Content-Disposition: attachment; filename='.$tab_c.'-export-' . date( 'm-d-Y' ) . '.csv' );
           header( "Expires: 0" );

           $headers_printed=false;
           foreach($rules[$tab_c]  as $ruleno=>$rule)
           {
                   if($headers_printed==false)
                   {    $header_str="";
                        $headers_printed=true;

                            foreach($rule as $header=>$val)
                           {
                                    if($header=='product_id')
                                    {
                                        $header_str.= $header.",";
                                    }
                                    else
                                    {
                                        $header_str.= $header.",";
                                    }

                           }                           
                        echo rtrim($header_str,',').PHP_EOL;
                   }
                    $val_str="";
                    foreach($rule as $key=>$val)
                    {  
                        if(is_array($val))
                        {   
                            foreach($val as $k=>$v)
                            {
                                $val_str.=$v."<=".$k.":";
                            }
                            $val_str=rtrim($val_str,":").",";
                        }
                        elseif(empty($val))
                        {                                                       
                            $val_str.="NULL,";
                        }
                        else
                        {                        
                            $val_str.=$val.",";
                        }                           
                    }
                    echo rtrim($val_str,",").PHP_EOL ;
           }
           exit;

       }       
}