
<h2><?php esc_attr_e( 'Dynamic Pricing Main Page','eh-dynamic-pricing-discounts'); ?></h2>
<div class="wrap" style="margin: auto;">
	<?php 
            
	if(isset($_GET['tab']) && !empty($_GET['tab']))
	{
		$active_tab=$_GET['tab'];
	}
	else
	{
		$active_tab='product_rules';
	}
	?>
	<h2 class="nav-tab-wrapper">
    <a href="?page=dynamic-pricing-main-page&tab=product_rules" class="nav-tab <?php echo $active_tab == 'product_rules' ? 'nav-tab-active' : ''; ?>"><?php _e('Product Rules','eh-dynamic-pricing-discounts');?></a>
    <a href="?page=dynamic-pricing-main-page&tab=combinational_rules" class="nav-tab <?php echo $active_tab == 'combinational_rules' ? 'nav-tab-active' : ''; ?>"><?php _e('Combinational Rules','eh-dynamic-pricing-discounts');?></a>
    <a href="?page=dynamic-pricing-main-page&tab=cat_combinational_rules" class="nav-tab <?php echo $active_tab == 'cat_combinational_rules' ? 'nav-tab-active' : ''; ?>"><?php _e('Category Combinational Rules','eh-dynamic-pricing-discounts');?></a>
    <a href="?page=dynamic-pricing-main-page&tab=category_rules" class="nav-tab <?php echo $active_tab == 'category_rules' ? 'nav-tab-active' : ''; ?>"><?php _e('Category Rules','eh-dynamic-pricing-discounts');?></a>
    <a href="?page=dynamic-pricing-main-page&tab=cart_rules" class="nav-tab <?php echo $active_tab == 'cart_rules' ? 'nav-tab-active' : ''; ?>"><?php _e('Cart Rules','eh-dynamic-pricing-discounts');?></a>
     <a href="?page=dynamic-pricing-main-page&tab=buy_get_free_rules" class="nav-tab <?php echo $active_tab == 'buy_get_free_rules' ? 'nav-tab-active' : ''; ?>"><?php _e('Buy And Get Free (Offers)','eh-dynamic-pricing-discounts');?></a>
    <a href="?page=dynamic-pricing-main-page&tab=settings_page" class="nav-tab <?php echo $active_tab == 'settings_page' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings','eh-dynamic-pricing-discounts');?></a>
    <a href="?page=dynamic-pricing-main-page&tab=import_export" class="nav-tab <?php echo $active_tab == 'import_export' ? 'nav-tab-active' : ''; ?>"><?php _e('Import/Export','eh-dynamic-pricing-discounts');?></a>
	</h2>

	
	
	<div id="col-container2">
		<div class="col-wrap">
			<div class="inside">
	
				<form method="get" action="">	
				<input type="hidden" id="page" name="page" value="dynamic-pricing-main-page">
				<input type="hidden" id="tab" name="tab" value="<?php   if(isset($_GET['tab']) && !empty($_GET['tab'])) {echo $_GET['tab'];} else {echo 'product_rules';} ?>">
				
				<?php
				
				do_action('my_admin_notification');

				if(isset($_GET['tab']) && !empty($_GET['tab'])) 
				 {$active_tab=$_GET['tab'];} 
				else {$active_tab='product_rules';}

				if($active_tab == 'combinational_rules' )
				{include('market/market-com-page.php');
				require('selected-tab-content/combinational-rule-tab.php');
				}
				if($active_tab == 'cat_combinational_rules' )
				{include('market/market-cat_com-page.php');
				require('selected-tab-content/cat-combinational-rule-tab.php');
				}
				elseif($active_tab == "restore" )
				{
                                                                                        if(is_admin())
                                                                                        {
                                                                                                
                                                                                               $dummy_settings['product_rules']=array();
                                                                                               $dummy_settings['combinational_rules']=array();
                                                                                               $dummy_settings['cat_combinational_rules']=array();
                                                                                               $dummy_settings['category_rules']=array();
                                                                                               $dummy_settings['cart_rules']=array();
                                                                                               $dummy_settings['buy_get_free_rules']=array();
                                                                                           update_option('xa_dp_rules',$dummy_settings);
                                                                                        }
				
				}
				elseif($active_tab == 'category_rules' )
				{include('market/market-category-page.php');
				require('selected-tab-content/category-rule-tab.php');
				}
				elseif($active_tab == 'cart_rules' )
				{include('market/market-cart-page.php');
				 require('selected-tab-content/cart-rule-tab.php');
				}
				elseif($active_tab == 'buy_get_free_rules' )
				{include('market/market-buy-and-get-page.php');
				 require('selected-tab-content/buy_get_free_rule-tab.php');
				}
				elseif($active_tab == 'settings_page' )
				{include('market/market-settings-page.php');
				 require('selected-tab-content/settings_page-tab.php');
				}
				elseif($active_tab == 'import_export' )
				{
				 require('selected-tab-content/import_export-tab.php');
				}
				elseif($active_tab == 'product_rules')				// product rule tab
				{	
				require('selected-tab-content/product-rule-tab.php');
				}

				?>
				
				
				</form>
				
				<form name="alter_display_form" method="get" action="">			<!--Displays Table List Of Saved Rules--->
				<input type="hidden" name="page" value="dynamic-pricing-main-page">	
				<input type="hidden" id="tab" name="tab" value="<?php   if(isset($_GET['tab']) && !empty($_GET['tab'])) {echo $_GET['tab'];} else {echo 'product_rules';} ?>">
				<?php 
				if(!isset($_GET["tab"]))
                                                                                {      
                                                                                           $_GET["tab"]='product_rules'; 
                                                                                }
                                                                               if(isset($_GET["tab"]) && !empty($_GET["tab"]) )
				{   

                    if(file_exists(plugin_dir_path( __FILE__ ).'/selected-tab-content/display-saved-'.$_GET["tab"].'-table.php') ===true)
                    include('selected-tab-content/display-saved-'.$_GET["tab"].'-table.php');
				
				}
				
				?>
				
	
				</form>

			</div>
		</div>
	</div>
</div> 

