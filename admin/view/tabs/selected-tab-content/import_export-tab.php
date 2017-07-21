<?php
            if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }
    ?>

	<div class="wrap">

		<div class="metabox-holder">
                                        <div class="postbox" id="pb1" name="pb1" hidden><form method="post" enctype="multipart/form-data"></form></div>
		<div class="postbox" id="pb2" name="pb2">                                            
                                                <h3><span style="margin:10px;"><?php _e( 'Export Settings' ); ?></span></h3>
                                                <div class="inside">
                                                        <p><?php _e( 'Export the plugin settings to a csv file' ); ?></p>
                                                        <form method="post" enctype="multipart/form-data">
                                                                <p>
                                                                        <Select name="tab" id="tab">
                                                                            <option value="product_rules">Product Rules</option> 
                                                                            <option value="combinational_rules">Combinational Rules</option> 
                                                                            <option value="cat_combinational_rules">Category Combinational Rules</option> 
                                                                            <option value="category_rules">Category Rules</option> 
                                                                            <option value="cart_rules">Cart Rules</option> 
                                                                            <option value="buy_get_free_rules">Buy And Get Free (Offers)</option> 
                                                                        </Select>
                                                                        <?php wp_nonce_field( 'eha_export_nonce', 'eha_export_nonce' ); ?>
                                                                        <?php submit_button( __( 'Export' ), 'secondary', 'eha-export', false ); ?>
                                                                </p>
                                                        </form>
                                                </div> 
                                        </div>
		</div><!-- .metabox-holder -->
                                        <div class="postbox" id="pb3" name="pb3">
                                                <h3><span style="margin:10px;"><?php _e( 'Import Settings' ); ?></span></h3>
                                                <div class="inside">
                                                        <p><?php _e( 'Import the plugin settings from a .csv file.' ); ?></p>
                                                        <form method="post" enctype="multipart/form-data" id="importfrm" name="importfrm">
                                                                <p>
                                                                        <Select name="import_tab" id="tab">
                                                                            <option value="product_rules">Product Rules</option> 
                                                                            <option value="combinational_rules">Combinational Rules</option> 
                                                                            <option value="cat_combinational_rules">Category Combinational Rules</option> 
                                                                            <option value="category_rules">Category Rules</option> 
                                                                            <option value="cart_rules">Cart Rules</option> 
                                                                            <option value="buy_get_free_rules">Buy And Get Free (Offers)</option> 
                                                                        </Select>
                                                                        <input type="file" name="import_file"/>
                                                                </p>
                                                                <p>
                                                                        <input type="hidden" name="pwsix_action" value="import_settings" />

                                                                        <?php wp_nonce_field( 'eha_import_export_nonce', 'eha_import_export_nonce' ); ?>
                                                                        <?php submit_button( __( 'Import' ), 'secondary', 'eha-import', false ); ?>
                                                                </p>
                                                        </form>
                                                </div><!-- .inside -->
                                        </div><!-- .postbox -->
                                        
                                        <div class="postbox" id="pb3" name="pb3">
                                        <h3><span style="margin:10px;"><?php _e( 'Restore Tabs' ); ?></span></h3>
                                        <div class="inside">
                                        <a href="admin.php?page=dynamic-pricing-main-page&tab=restore" >Click Here to Delete All Rules from All Tabs</a>
                                        </div>
                                        </div><!-- .postbox -->
	</div><!--end .wrap-->



