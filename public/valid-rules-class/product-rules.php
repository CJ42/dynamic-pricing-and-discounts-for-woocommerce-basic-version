<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
    if(!class_exists('xa_product_rules'))
    {
        class xa_product_rules extends xa_valid_rules
        {

           function __construct(&$cart_array,$rules_array,&$running_max_discount,&$running_max,$price,$weight,$cart_keys=array())
            {
               if(empty($rules_array) || empty($price))
               {
                  
               }
               else
               {
                 $this->cart_keys=$cart_keys;
                 $this->cart_array=&$cart_array;
                 foreach($this->cart_array as $pid=>$qnty)
                 {
                     $this->cart_array_org[$pid]=$qnty;
                 }
                 $this->rules_array=$rules_array;
                 $this->running_max_discount=&$running_max_discount;
                 $this->running_max=&$running_max;
                 $this->_price=$price;
                 $this->_weight=$weight;
                 $this->mode='product_rules';
                 
                 $this->update_product_valid_rules();
               }

                 
                 
            }


           
           function  update_product_valid_rules()
           { 
               $this->valid_rules=array();
              
                 foreach($this->rules_array as $rule1)
                 {          $pids=array();
                            if( isset($rule1['rule_on']) && $rule1['rule_on']=='categories'  )   // removed check " &&  empty($rule1['product_id'])" 
                            {
                                    $pids=eha_get_products_from_category_by_ID($rule1['category_id']);
                                    
                            }elseif(isset($rule1['rule_on']) && $rule1['rule_on']=='cart' )
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
                                 foreach($rule1['product_id'] as $vpid)
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
                                   $rule1['product_id']=$pids;
                     if($this->check_rule($rule1)===true)
                     {
                          $this->valid_rules[$rule1['rule_no']]=$rule1;
                     }
                   
                 }
           }
           
           function check_rule(&$rule)
            {   
               
                $prod_array=$this->cart_array;
                $pids=$rule['product_id'] ;
                $rule['min_valid_qnty']=$this->get_min_valid_quantity($rule);
                $rule_no=$rule['rule_no'];
                $min=(empty($rule['min'])==true)?1:$rule['min'];
                $max=(empty($rule['max'])==true )?999999:$rule['max'];
                
                if($max<$min && $max!=0)
                {	
                        return false;
                }
                $rule['mapping']=array();

                  
                 if(is_array($pids))
                foreach($pids as $pid)
                {     
                    if(isset($rule['discount_type']) && $rule['discount_type']=='Flat Discount'  && isset($this->running_max[$rule_no.":".$this->mode][$pid]['min'])  &&   $this->running_max[$rule_no.":".$this->mode][$pid]['min']==1 )
                    {   
                        return false;
                    }
                 
                    if(array_key_exists(strval($pid),$prod_array) && $this->check_date_range_and_roles($rule,$pid)  ==true && $this->check_min_max_weight_price_quantity($rule['check_on'],$min,$max,$pid,$rule_no)==true  )
                        {  
                                if ( !isset($rule['mapping'])  || !in_array($pid,$rule['mapping'])) 
                                {	$rule['mapping'][]=$pid;
                                }
                        }
                }
              if(isset($rule['mapping'])  && !empty($rule['mapping']))
                        {
                            return true;
                        }
                else {   
                            return false;
                        }
                
            }

            function get_min_valid_quantity($rule)
            {

                    
                    extract($rule);
                    $min_valid_qnty=array();
                    foreach($product_id as $pid)
                    {
                               if(!isset($this->_price[$pid]))
                               {
                                   continue;
                               }
                                $unit_price=$this->_price[$pid];
                                $unit_weight=$this->_weight[$pid];
                                $min_valid_qnty[$pid]=1;
                                if($check_on=='Price')
                                {
                                        if(!empty($this->_price) && array_key_exists($pid,$this->_price)===true)
                                        {
                                                $min_valid_qnty[$pid]=ceil(floatval($min)/floatval($unit_price));
                                        }
                                }
                                elseif($check_on=='Quantity')
                                {	if(!empty($this->_weight) && array_key_exists($pid,$this->_weight)===true)
                                        {
                                                 $min_valid_qnty[$pid]=ceil($min);
                                        }
                                }
                                elseif($check_on=='Weight')
                                {
                                        $min_valid_qnty[$pid]=ceil(floatval($min)/floatval($unit_weight));
                                }
                                else
                                {
                                        $min_valid_qnty[$pid]=1;
                                }
                                
                    }
                    return $min_valid_qnty;
            }
            
            function check_roles($role)
            {
                    if($role=='all' || current_user_can($role))
                    {
                            return true;
                    }

                    return false;
            }

        function check_min_max_weight_price_quantity($check_on,$min,$max,$pid,$rule_no)
        {	
             if(isset($this->running_max_discount[$rule_no.":".$this->mode])  && ($this->running_max_discount[$rule_no.":".$this->mode]<=0) && !empty($this->running_max_discount[$rule_no.":".$this->mode]))
                { 
                 return false;
                }
                $Weight=$this->_weight[$pid];
                $cq=$this->cart_array[$pid];
                $Price=$this->_price[$pid] ;
                $Quantity=1;
                
                switch ($check_on) 
                {
               case 'Weight':   $unit=$Weight;
                                       break;
                case 'Quantity':   $unit=$Quantity;
                                                       break;
                case 'Price':   $unit=$Price;
                                                       break;
               default:
                   break;
              }
              $settings=get_option('xa_dynamic_pricing_setting');
            if(  isset($settings['mode']) && $settings['mode']=='strict'   )                                            //mode strict :it will not search for best discount rule 
                {
                    if(!(isset($this->cart_array_org[$pid])  && $this->cart_array_org[$pid]>=$min && $this->cart_array_org[$pid]<=$max ))
                    {
                        return false;
                    }
                }

 
                if(isset($this->running_max[$rule_no.":".$this->mode][$pid][$check_on]) && ($this->running_max[$rule_no.":".$this->mode][$pid][$check_on]+$unit)<=$max  && apply_filters('eha_dp_skip_product',false,$pid,$rule,$this->mode)==false)
                {
                    
                }
                else
                {  
                return false;
                }
               

                
                if(isset($this->running_max[$rule_no.":". $this->mode][$pid]['min']) &&  $this->running_max[$rule_no.":".$this->mode][$pid]['min']==1 && ($this->running_max[$rule_no.":".$this->mode][$pid][$check_on]<=$max  || $max==0  || empty($max)))
                { 
                   return true;
                }
                
                
                switch($check_on)
                {	
                case "Weight":      if((($Weight * $this->cart_array[$pid])>=$min)  && (($this->running_max[$rule_no.":".$this->mode][$pid]['Weight']+$Weight)<=$max  || $max==0  || empty($max)))
                                                {      return true;}
                                                else    
                                                {   
                                                        return false;
                                                }
                                                break;
                case "Quantity":    if(($cq>=$min)     && (($this->running_max[$rule_no.":".$this->mode][$pid]['Quantity']+$Quantity)<=$max  || $max==0 || empty($max)))
                                                {    
                                                    return true;}
                                                else
                                                {       
                                                    return false;
                                                }
                                                break;
                case "Price":           if((($Price * $this->cart_array[$pid]) >=$min )      && (($this->running_max[$rule_no.":".$this->mode][$pid]['Price']+$Price)<=$max  || $max==0 || empty($max)))
                                                {      return true;}
                                                else
                                                {   
                                                    return false;
                                                }
                                                break;
                }
                 
                return false;
        }
            function check_date_range_and_roles($rule,$pid)
            {
                $fromdate=$rule['from_date'];
                $todate=$rule['to_date'];
                $user_role=$rule['allow_roles'];
                $offer_name=$rule['offer_name'];
                   if($this->check_roles($user_role)!=true)
                   {
                       return false;
                   }
                    $now=date('d-m-Y');
                    $return=false;
                    if(empty($fromdate) && empty($todate))
                    {
                            $return= true;
                    }
                    elseif(empty($fromdate) && empty($todate)==false  && (strtotime($now) <= strtotime($todate)))
                    {
                            $return= true;
                    }
                    elseif(empty($fromdate)==false && (strtotime($now) >= strtotime($fromdate)) && empty($todate))
                    {
                           $return= true;
                    }
                    elseif((strtotime($now) >= strtotime($fromdate))  && (strtotime($now) <= strtotime($todate)))
                    {
                            $return= true;
                    }
                    else
                    {
                            $return= false;
                    }
                    
                    global $product;
                    if(is_product()==true && $return===true && !empty($product) && is_string($product)===false)
                    {                
                        $cpid = is_wc_version_gt_eql('2.7')?$product->get_id():$product->id;
                        $prod=wc_get_product($pid);
                        
                        ///$parent_id=is_wc_version_gt_eql('2.7')?$prod->get_parent_id():$prod->parent_id; //         
                        $parent_id=wp_get_post_parent_id( $pid);
                        
                        if($pid==$cpid  || $parent_id==$cpid)
                        {  
                            global $offers;
                            $offers['product_rules'][$rule['rule_no']]=$offer_name;
                        }
                    }
                    
                    return $return;
            }

           function get_valid_rules()
           {
               
              return parent::get_valid_rules();
           }
       

           	public function possible_solutions(&$ps)
	{           

                                $_result=array();
                                $mode=$this->mode;
                                if(empty($this->valid_rules))
                                {
                                    return $ps;
                                }
                                foreach( $this->valid_rules as $rule_no=>$rule )
                                    {  
                                            
                                        
                                       if(!isset($rule['mapping']) || empty($rule['mapping']))
                                       {
                                           continue;
                                       }
                                       $pids=$rule['mapping'];
                                        foreach($pids as $pid)
                                        {
                                                         if(!isset($this->cart_array[$pid]))
                                                         {
                                                               continue; 
                                                         }
                                                           if($this->cart_array[$pid]==0)
                                                           {
                                                                unset($this->cart_array[$pid]);  
                                                                continue;
                                                           }
                                                       $dp=0;
                                                       $val=$rule['value'];
                                                       $max_discount=$this->running_max_discount[$rule_no.":".$this->mode];
                                                       $price=$this->_price[$pid];

                                                       if($rule['discount_type']=='Percent Discount')
                                                       {
                                                               $cal_discount=(floatval($price)* $val)/100;
                                                       }
                                                       elseif($rule['discount_type']=='Flat Discount')
                                                       {
                                                               $cal_discount=floatval($val);
                                                       }
                                                       elseif($rule['discount_type']=='Fixed item Price'  || $rule['discount_type']=='Fixed Price' )
                                                       {
                                                               $cal_discount=floatval($price) - $val;
                                                       }
                                                       else
                                                       {die('error on ref:23x22334,  message: discount_type is not set for rule no:'.$rule_no); }

                                                       if($cal_discount>$max_discount && $max_discount<>0)
                                                               {
                                                                       $cal_discount=$max_discount;
                                                               }
                                                       $dp=$cal_discount;	
                                                       $dp=round($dp,wc_get_price_decimals(),PHP_ROUND_HALF_UP);
                                                       $_result[$rule_no.':'.$mode][strval($dp)]=array($dp=>$pid);
                                                       $dp=strval($dp);
                                                      if(!isset($ps[$rule_no.':'.$mode][$dp])  ||  !in_array(array($dp=>$pid),$ps[$rule_no.':'.$mode][$dp]))
                                                          $ps[$rule_no.':'.$mode][$dp]=array($dp=>$pid);
                                           
                                        }
                                    }
                                  
	}   // end function possible_sollution
	
                    
                    public function execute_rule($rule_no,&$running_max_discount, $selected_prods) 
                    {          
                               if(is_cart() )
                                {
                                echo "\n<div id='rules_info' style='display:none'>";
                                echo "mode:".$this->mode."\t\t\t\t\trule:".$rule_no." \npa=";print_r($this->cart_array);
                                
                               }
                                $mode=$this->mode;
                                $rule=$this->valid_rules[$rule_no];
                                extract($rule);
                                $pids= explode(',',$selected_prods);
                               
                               $product_id= $selected_prods;  // overwriding extractrd product id with the selected one because in this version it is array

                                if(isset($this->running_max[$rule_no.":".$this->mode][$product_id]['min'])  && $this->running_max[$rule_no.":".$this->mode][$product_id]['min']==1)   /// this is to check if the rule has executed once then no need of min qnty or price or weight check
                                {
                                $min_valid_qnty[$product_id]=1;
                                }
                                
                                if($min_valid_qnty[$product_id]>$this->cart_array[$product_id])
                                {
                                    if($this->cart_array[$product_id]>0)
                                    {
                                        $min_valid_qnty[$product_id]=1;
                                    }
                                    else
                                    {
                                        $min_valid_qnty[$product_id]=0;
                                    }
                                }
                                $settings=get_option('xa_dynamic_pricing_setting');
                                if(  isset($settings['mode']) && get_option('xa_dynamic_pricing_setting')['mode']=='strict'   )                                            //mode strict :it will not search for best discount rule  
                                {
                                    $min_valid_qnty[$product_id]=$this->cart_array[$product_id];
                                }
                                
                                $this->cart_array[$product_id]-=$min_valid_qnty[$product_id];
                                $discount_amt=0;
                                if($discount_type=='Percent Discount')
                                {	
                                        $discount_amt=floatval($value) * floatval($this->_price[$product_id]) * floatval($min_valid_qnty[$product_id])/100;
                                       
                                }
                                elseif($discount_type=='Flat Discount')
                                {
                                        $discount_amt=floatval($value);
                                }
                                elseif($discount_type=='Fixed Price' )
                                {
                                        $discount_amt=(floatval($this->_price[$product_id]) * floatval($min_valid_qnty[$product_id])) - (floatval($value) * floatval($min_valid_qnty[$product_id]));
                                }
                                else
                                {
                                        $discount_amt=0;
                                }
                                
                                if(isset($running_max_discount[$rule_no.":".$mode])  && $discount_amt>$running_max_discount[$rule_no.":".$mode] )
                                {       
                                        $discount_amt=$running_max_discount[$rule_no.":".$mode];
                                }
                                
                                if(!isset($this->running_max[$rule_no.":".$mode][$product_id][$check_on]))
                                {
                                    $this->running_max[$rule_no.":".$mode][$product_id][$check_on]=0;
                                }
                                $skip=false;
                                if(isset($settings['recuring_rule_id_array']) && in_array('product_rules:'.$rule_no,explode(',',$settings['recuring_rule_id_array'])))
                                {
                                    $skip=true;
                                }
                                
                                if($skip===false)
                                {
                                        if($check_on=="Price")
                                       {
                                            $this->running_max[$rule_no.":".$mode][$product_id][$check_on]+=($this->_price[$product_id] * $min_valid_qnty[$product_id]);
                                       }
                                       elseif($check_on=="Quantity")
                                       {
                                              $this->running_max[$rule_no.":".$mode][$product_id][$check_on]+=$min_valid_qnty[$product_id];
                                       }
                                       elseif($check_on=="Weight")
                                       {
                                              $this->running_max[$rule_no.":".$mode][$product_id][$check_on]+=($this->_weight[$product_id] *$min_valid_qnty[$product_id]);
                                       }

                                }

                                if(!empty($max_discount))
                                {
                                    $running_max_discount[$rule_no.":".$mode]-=$discount_amt;
                                }
                                global $woocommerce;
                                $cart=$woocommerce->cart;
                                if(isset($this->cart_keys[$product_id]) && !empty($this->cart_keys[$product_id]))
                                {   
                                    $count=count($this->cart_keys[$product_id]);
                                    foreach($this->cart_keys[$product_id] as $cart_key)
                                    {       
                                        if(isset($_GET) && isset($_GET['debug'])) echo "cart key =$cart_key  with dis=$discount_amt";
                                         
                                        if(isset($cart->cart_contents[$cart_key]['dynamic_discount']) && !empty($cart->cart_contents[$cart_key]['dynamic_discount']) && is_numeric($cart->cart_contents[$cart_key]['dynamic_discount']))
                                        {
                                            $cart->cart_contents[$cart_key]['dynamic_discount']+=$discount_amt/$count;
                                        }
                                        else
                                        {                                       
                                            $cart->cart_contents[$cart_key]['dynamic_discount']=$discount_amt/$count;                                    
                                        }    
                                    }
                                    //$cart_key=$this->cart_keys[$product_id];
                                
                                }

                                
                                $this->running_max[$rule_no.":".$mode][$product_id]["min"]=1;
                                
                                if($this->cart_array[$product_id]==0)
                                {
                                    unset($this->cart_array[$product_id]);
                                    
                                }
                                $this->update_product_valid_rules();
                                if(is_cart() )
                                {
                               
                                 echo "\n Apa=";print_r($this->cart_array);
                                echo "L-dis=".$discount_amt;
                                echo "</div>";
                               }
                               
                               if(isset($adjustment) && is_numeric($adjustment))
                               {
                                    global $adjusted;
                                    if(!isset($adjusted[$mode][$rule_no]) || !$adjusted[$mode][$rule_no]==true)        // One time Rule Adjustment 
                                    {
                                        $adjusted[$mode][$rule_no]=true;
                                        $discount_amt-=$adjustment;
                                    }                                  
                               }

                               
                               
                                return $discount_amt;

                    }      //end function execute_rule();
                    
                    
                    
            }
    }