<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

		if(isset($_GET['tab']))
		{
			$active_tab=$_GET['tab'];
		}
		else
		{
			$active_tab='product_rules';
		}
                
		if(isset($_GET['submit']) && !isset($_GET['update']) )				//Submit And Not Edit Then Saving New Record
		{	
			$current_tab_loc=isset($_GET['tab']) && !empty($_GET['tab'])?  $_GET['tab'].'/': 'product_rules/';
                        if($current_tab_loc=='product_rules/' || $current_tab_loc=='settings_page/' )
                        {
                            $path=  xa_root_path.'admin/data/'.$current_tab_loc.'save-options.php';
                            if(file_exists($path)==true) include_once ( $path );
                        }
                        else {
                        echo' <div class="notice notice-error is-dismissible" style="    background: gold;"> <p>Sorry Unable to Save!!  This Feature is only available in Premium Version.</p> </div>';

                        }                
		}
		elseif(isset($_GET['edit']) && !empty($_GET['edit']) )				//Loading Edit Form Or Updating Data
		{
			$old_option=get_option('xa_dp_rules')[$active_tab];
			$_GET=array_merge($_GET,$old_option[$_GET['edit']]);
			$current_tab_loc=isset($_GET['tab']) && !empty($_GET['tab'])?  $_GET['tab'].'/': 'product_rules/';
			$path=xa_root_path.'admin/data/'.$current_tab_loc.'load-edit.php';
			include_once ( $path );

		}
		elseif(isset($_GET['update']) && !empty($_GET['update']) )
		{
			$path=isset($_GET['tab']) && !empty($_GET['tab'])?  $_GET['tab'].'/': 'product_rules/';
			
			$path=xa_root_path.'admin/data/'.$path.'update-options.php';
			
			include_once ( $path );
		}
		elseif(isset($_GET['delete']))
		{
			$path=isset($_GET['tab']) && !empty($_GET['tab'])?  $_GET['tab'].'/': 'product_rules/';
			$path=xa_root_path.'admin/data/'.$path.'delete-options.php';
			$active_tab=$_GET['tab'];
		include_once ( $path );
		}
		else
		{
			$active_tab='product_rules';
		}

		require('tabs/tabs-html-render.php');