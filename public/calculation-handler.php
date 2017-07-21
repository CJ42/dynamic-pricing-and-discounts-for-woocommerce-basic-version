<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
 include  "valid-rules-class/valid-rules.php";
 include "valid-rules-class/product-rules.php";
 
 
 if(!class_exists('xa_calculation_handler'))
{
    class xa_calculation_handler
        {
            
            protected $cart_array=array();
            protected $all_valid_rules=array();
            public       $running_max_discount=array();
            public       $running_max=array();
            public       $_price=array();
            public       $_weight=array();
            public       $modes=array();
            public       $ps=array();
            public       $modes_obj=array();
             public function __construct($cartobj,$modes=array(),$cart_keys=array()) 
            { 
                               $this->cart_keys=$cart_keys;
                               $this->init($cartobj,$modes,array(),$running_max_discount,$running_max,$_price,$_weight);
                            
            }
            
            function re_init()
            {
                 foreach($this->modes as $mode)
                                 {
                                     if(!isset($this->all_valid_rules[$mode]))
                                     {
                                         $this->all_valid_rules[$mode]=array();
                                     }
                                     $classname='xa_'.$mode;
                                     $mode_obj= new $classname($this->cart_array,$this->all_valid_rules[$mode],$this->running_max_discount,$this->running_max,$this->_price,$this->_weight,$this->cart_keys);
                                     $this->all_valid_rules[$mode]= $mode_obj->get_valid_rules();
                                     $this->modes_obj[$mode]=$mode_obj;
                                 }
            }
          public   function init($cartobj,$modes,$rules_option_array,&$running_max_discount,&$running_max,&$_price,&$_weight)
            {
                                if(empty($rules_option_array))
                                {   
                                    $dummy_option=array('product_rules'=>array(),'combinational_rules'=>array(),'cat_combinational_rules'=>array(),'category_rules'=>array(),'cart_rules'=>array());
                                    $rules_option_array=get_option('xa_dp_rules',$dummy_option);
                                    unset($rules_option_array['buy_get_free_rules']); // not using in this class because i have already used it before.
                                    foreach($rules_option_array as $md=>$rules)
                                    {
                                        foreach($rules as $rule_no=>$rule)
                                        {
                                            $rules_option_array[$md][$rule_no]['rule_no']=$rule_no;
                                        }
                                    }
                                }
                            
                                 $this->cart_array=$cartobj;
                              
                                $this->modes=$modes;
                                if(empty($running_max_discount))
                                {
                                    $running_max_discount= initialize_running_max_discount($rules_option_array);
                                }
                                 $this->running_max_discount= $running_max_discount;
                                if(empty($running_max))
                                {
                                    $running_max= initialize_running_max($rules_option_array);
                                }
                                $this->running_max=$running_max;
                             
                                 if(empty($_price) || empty($_weight))
                                {
                                     
                                      initialize_price_and_weight_array($this->cart_array,$_price,$_weight);
                                }
                                  $this->_price=$_price;
                                  $this->_weight= $_weight;
                                    //global $offers;
                                foreach($modes as $mode)
                                 {
                                    if(empty($rules_option_array) || empty($rules_option_array[$mode]) || empty($_price))
                                    {
                                        continue;
                                    }
                                    
                                     $classname='xa_'.$mode;
                                    
                                     $mode_obj= new $classname($this->cart_array,$rules_option_array[$mode],$this->running_max_discount,$this->running_max,$this->_price,$this->_weight,$this->cart_keys);
                                    
                                     $this->all_valid_rules[$mode]= $mode_obj->get_valid_rules();
                                    // $offers[$mode]=$mode_obj->active_rules;
                                 }
                                 
            }
            
            function is_cart_empty()
            {
                $count=0;
                foreach($this->cart_array  as $pid=>$qnty)
                {
                    $count+=$qnty;
                }
                if($count>0)
                {
                    return false;
                }
                else {
                               return true;
                        }
            }
            
            function  xa_get_dynamic_discount()
            {  
                    $dis=0;
                   $i=10;
                  $prev_prod_array=array();
                  
                    while($prev_prod_array!= $this->cart_array)
                    {       
                        $prev_prod_array= $this->cart_array;
                       
                            $this->re_init();
                     
                            foreach ($this->cart_array as $pid=>$qnty)
                            {
                                if($qnty<=0)
                                {
                                    unset($this->cart_array[$pid]);
                                }
                            }
                            if(empty($this->cart_array))
                            {
                                 return $dis;
                            }
                            $this->ps=array();
                            foreach($this->modes as $mode)
                            {
                                $this->modes_obj[$mode]->possible_solutions($this->ps);
                            }
                            
                            $result=$this->get_max_from_possible_solutions($this->ps); 

                            if($result===0)
                            {
                                    return $dis;
                            }
                            else
                            {
                                    $rule_no=$result['rule_no'];
                                    $mode=$result['mode'];
                                    $selected_prods=$result['selected_prods'];
                                    $dis += $this->modes_obj[$mode]->execute_rule($rule_no,$this->running_max_discount, $selected_prods,$this->cart_keys);  	// update $discount_amt and $tmp_pa and  $r_max_discount					
                                   
                            }
                          
                    }
                    
                    return $dis;
                    
            }       // end  function xa_get_dynamic_discount() 

             public function get_max_from_possible_solutions($_ps)
            {	$max_dp=0;
                    $tmp_dp=0;
                    $max_dp_rule_no=-1;
                    $max_mode="";
                    $selected_prods=array();
                   
                    foreach($_ps as $rule_no=>$rules_subset)
                    {
                              $rno=$rule_no;
                              $rule_no= explode(":",$rule_no);
                              $mode=$rule_no[1];
                              $rule_no=$rule_no[0];

                           if($this->running_max_discount[$rno]==0  && !empty($this->running_max_discount[$rno]))
                            {         
                                    continue;
                            }

                           $tmp_dp=max(array_keys($rules_subset));
                           if($max_dp<$tmp_dp)
                            {
                                    $max_dp=$tmp_dp;
                                    $max_dp_rule_no=$rule_no;
                                    $max_mode=$mode;
                                    $selected_prods=$_ps[$rno][$max_dp][$max_dp];   
                            }
                    }
                   
                    if($max_dp==0 || $max_dp_rule_no===-1)
                    { 
                            return 0;
                    }
                    //print_r(array('max_dp'=>$max_dp,'rule_no'=>$max_dp_rule_no,'mode'=>$max_mode,'selected_prods'=>$selected_prods));
                    return array('max_dp'=>$max_dp,'rule_no'=>$max_dp_rule_no,'mode'=>$max_mode,'selected_prods'=>$selected_prods);

          }   // end function get_max_from_possible_solutions


        }         // end class
 }


    
      function initialize_running_max_discount($rules_array)              // array for checking max discount amt that can be used per  rule
        {
            $_result=array();
            foreach($rules_array as $mode=>$rules)
            {	
                    foreach($rules as $rule_no=>$rule)
                    {
                            if($rule['max_discount']===0)
                            {
                                    $rule['max_discount']=9999999999;
                            }
                            if($rule_no==0)
                            {
                                continue;
                            }
                            $_result[$rule_no.":".$mode]=$rule['max_discount'];
                    }
            }
            return $_result;
        }
    

        
     function initialize_running_max($rules_array)               //array for checking min max
        {
              $_result=array();
            foreach($rules_array as $mode=>$rules)
            {	
                    
                    foreach($rules as $rule_no=>$rule)
                    { 
                        if(!isset($rule['check_on']))
                        {
                            continue;                                                          // may create error 1156651 try to set some default check on
                        }
                            if(isset($rule['max']) )
                            {
                                        if( $rule['max']===0)
                                        { $rule['max']=9999999999;}
                            }
                            else
                            {
                                $rule['max']=9999999999;
                            }
                            if($mode=='product_rules')
                            {       $pids=array();
                                    if(isset($rule['rule_on']) &&  $rule['rule_on']=='categories' &&  empty($rule['product_id']))
                                   {
                                           $pids=eha_get_products_from_category_by_ID($rule['category_id']);
                                   }
                                   elseif(isset($rule['rule_on']) &&  $rule['rule_on']=='cart' &&  empty($rule['product_id']))
                                   {
                                        global $woocommerce;
                                         $items = $woocommerce->cart->get_cart();
                                        foreach($items as $cart_key=>$line_array)
                                        {
                                                if(!empty($line_array['variation_id']))
                                                {
                                                    $pids[]=$line_array['variation_id'];
                                                }
                                                else
                                                {
                                                    $pids[]=$line_array['product_id'];
                                                }
                                        }
                                   }
                                   else
                                   {
                                        foreach($rule['product_id'] as $vpid)
                                         {
                                              $prod_obj = wc_get_product($vpid);
                                             if(get_class($prod_obj)=='WC_Product_Variable')
                                             {
                                                 foreach($prod_obj->get_children() as $cpid)
                                                 {
                                                     $pids[]=$cpid;
                                                 }
                                             }else
                                             {
                                                 $pids[]=$vpid;
                                             }
                                         }
                                   }
                                   

                                   
                                foreach($pids as $pid)
                                {
                                    $_result[$rule_no.":".$mode][$pid][$rule['check_on']]=0;
                                }
                                
                            }
                            else
                            {
                                $_result[$rule_no.":".$mode][$rule['check_on']]=0;
                            }
                            
                    }
            }
            return $_result;
        }
    

    
    function initialize_price_and_weight_array($cart_product_array,&$price,&$weight)
    {
        foreach($cart_product_array as $pid=>$qnty)
        {         
             $product=wc_get_product( $pid );
             $price[$pid]=$product->get_price();
             $weight[$pid]=$product->get_weight();
         }
    }
    
    function super_set($array) 
            {
                    @@ ini_set('memory_limit', '1024M');
                    $results = array(array());
                    foreach ($array as $element) 
                    {
                            foreach ($results as $combination) 
                            {
                                    $results[] = array_merge(array($element), $combination);
                            }
                    }

                    return $results;
            }