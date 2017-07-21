<?php  
        if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
if(isset($_GET['delete']) )
{
	if(isset($_GET['confirm']) && (!empty($_GET['delete']) || $_GET['delete']==0) )
	{
		
		$prev_data=get_option('xa_dp_rules');
		unset($prev_data[$active_tab][$_GET['delete']]);
		update_option('xa_dp_rules',$prev_data);
		function notify_delete_success()
		{
			echo '<div class="notice notice-warning inline is-dismissible"><p></br><lable>Deleted Successfully !!</p></div>';
		}
		
		add_action('my_admin_notification','notify_delete_success');
	}
	else
	{
		function notify_delete_confirm()
		{
			echo '<form name="confirm_delete" method="GET" action=""><input type="hidden" name="delete" value="'.$_GET['delete'].'" /><input type="hidden" name="confirm" value="true" /><div class="notice notice-warning inline is-dismissible"><p></br><lable>Are You Sure To Delete this Rule</label><button name="confirm" class="" style="margin-left:10px;">Confirm Delete</button></p></div></form>';
		}
		
		add_action('my_admin_notification','notify_delete_confirm');
		
	}
}