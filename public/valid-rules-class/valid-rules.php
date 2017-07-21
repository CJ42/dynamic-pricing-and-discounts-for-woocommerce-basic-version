<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
    if(!class_exists('xa_valid_rules'))
    {
    class xa_valid_rules {
        
                protected $cart_array=array();
                protected $rules_array=array();
                protected $running_max_discount=array();
                protected $running_max=array();
                protected $_price=array();
                protected $_weight=array();
                protected $mode="";
                public       $valid_rules=array();
                public       $active_rules=array();
               function __construct($cart_array,$rules_array,$running_max_discount,$running_max,$price,$weight,$mode) 
                {
                     $this->cart_array=$cart_array;
                     $this->rules_array=$rules_array;
                     $this->running_max_discount=$running_max_discount;
                     $this->running_max=$running_max;
                     $this->_price=$price;
                     $this->_weight=$weight;
                     $this->mode=$mode;
                }

                function get_valid_rules()
                {
                    return $this->valid_rules;
                }
                   
                
        }
    }