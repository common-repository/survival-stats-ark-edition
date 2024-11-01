<?php 
    include plugin_dir_path(__FILE__) . '../admin-functions/functions.php';

    //Normal page display
    $token = get_option('ssark_token');
    $secret = get_option('ssark_secret');
    $public = get_option('ssark_public');

    $server_identifyer = get_option('ssark_server_identifyer');
    $server_ip = get_option('ssark_server_ip');
    $server_port = get_option('ssark_server_port');
    $server_rcon_port = get_option('ssark_server_rcon_port');
    $server_verification = get_option('ssark_server_verification');

    if(is_array( $server_ip ) && is_array($server_port)){
        $multiServer = TRUE;
        $initialIP = $server_ip[0];
        $initialPORT = $server_port[0];
    }else{
        $multiServer = FALSE;
        $initialIP = $server_ip ;
        $initialPORT = $server_port;
    }

    $is_advanced = licenceCheck($public, $secret, $initialIP, $initialPORT );

    //Form data sent
    if($_POST['ssark_hidden'] == 'Y') {
        $token = $_POST['ssark_token'];
        update_option('ssark_token', $token);
         
        $secret = $_POST['ssark_secret'];
        update_option('ssark_secret', $secret);
         
        $public = $_POST['ssark_public'];
        update_option('ssark_public', $public);
         
        $server_identifyer = $_POST['ssark_server_identifyer'];
        update_option('ssark_server_identifyer', $server_identifyer);
         
        $server_ip = $_POST['ssark_server_ip'];
        update_option('ssark_server_ip', $server_ip);
 
        $server_port = $_POST['ssark_server_port'];
        update_option('ssark_server_port', $server_port); 

        $server_rcon_port = $_POST['ssark_server_rcon_port'];
        update_option('ssark_server_rcon_port', $server_rcon_port);
        ?>
        <div class="updated">
            <p><strong><?php _e('SS: Ark Settings saved.' ); ?></strong></p>
        </div>
        <?php
    }
?>
<div class="wrap">
    <div id="navigation" style="float: right;padding:8px 25px 8px;">
        <strong style="display:inline-block; padding:8px; text-transform: uppercase;">Navigation</strong>
        <a style="display:inline-block; text-decoration: none; background:#23282d; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="admin.php?page=ss-ark-settings">Server Settings</a>
        <a style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="admin.php?page=ss-ark-rcon">SS:RCON</a>
    </div>
    <?php    echo "<h1>" . __( 'Survival Stats: Ark Edition Settings', 'ssark_trdom' ) . "</h1>"; ?>
    <?php    echo "<h2>" . __( 'VERSION: 3.0', 'ssark_trdom' ) . "</h2>"; ?>
     <form name="ssark_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">    
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">
                        <div class="postbox" style="display: block;">
                            <button type="button" class="handlediv button-link" aria-expanded="true">
                                <span class="screen-reader-text">Toggle panel: <span style="font-weight:400;">Settings</span></span>
                                <span class="toggle-indicator" aria-hidden="true"></span>
                            </button>
                            <h2 class="hndle ui-sortable-handle">
                                <span><span style="font-weight:400;"><span class="dashicons dashicons-admin-generic"></span> Save Settings</span></span>
                            </h2>
                            <div class="inside">
                                <p class="submit" style="text-align: center;">
                                    <input style="width: 100%; cursor: pointer; display:inline-block; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; border: none;" type="submit" name="Submit" value="<?php _e('Save Settings', 'ssark_trdom' ) ?>" />
                                </p>
                            </div>
                        </div>
                        <div class="postbox" style="display: block;">
                            <button type="button" class="handlediv button-link" aria-expanded="true">
                                <span class="screen-reader-text">Toggle panel: <span style="font-weight:400;">RCON</span></span>
                                <span class="toggle-indicator" aria-hidden="true"></span>
                            </button>
                            <h2 class="hndle ui-sortable-handle">
                                <span><span style="font-weight:400;"><span class="dashicons dashicons-networking"></span> Enable Rcon Features</span></span>
                            </h2>
                            <div class="inside">
                                <p><strong>RCON FEATURES:</strong> In version 3+ of the KYE Server API the system makes Rcon requests to your server to generate detailed information about players on your server and also gives you the abbility to use your WP ADMIN area as a RCON client for your servers, create scheduald commands, ban and unban players view detailed information about your players including VAC bans and when they where last banned.</p>
                                <p><strong>ENABLE RCON FEATURES:</strong> To enable these features you will need to enter the Rcon Port and the Rcon password for each server you would like to enable RCON FEATURES, you are then required to "Verify" the details to see if our system can access your server.</p>
                                <p style="color: red;">
                                <strong>IMPORTANT NOTICE:</strong> 
                                RCON Passwords are not stored in your WordPress database, this is for your servers security.
                                </p>

                            </div>
                        </div>
                        <div class="postbox" style="display: block;">
                            <button type="button" class="handlediv button-link" aria-expanded="true">
                                <span class="screen-reader-text">Toggle panel: <span style="font-weight:400;">API Key</span></span>
                                <span class="toggle-indicator" aria-hidden="true"></span>
                            </button>
                            <h2 class="hndle ui-sortable-handle">
                                <span><span style="font-weight:400;"><span class="dashicons dashicons-admin-network"></span> Get API Key</span></span>
                            </h2>
                            <div class="inside">
                                <p>Register your free API access:</p>
                                <ul>
                                    <li><span class="dashicons dashicons-dashboard"></span> Server Status</li>
                                    <li><span class="dashicons dashicons-hammer"></span> Version Check</li>
                                    <li><span class="dashicons dashicons-universal-access"></span> Current Player Count</li>
                                    <li><span class="dashicons dashicons-shield-alt"></span> Free Updates</li>
                                </ul>

                                <div style="text-align: center;">
                                    <a style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white;" target="_blank" href="http://www.knowyourenemy.co.uk/packages/basic-api-key">Get Basic API Key</a>
                                </div>
                            </div>
                        </div>
                        <div class="postbox" style="display: block;">
                            <button type="button" class="handlediv button-link" aria-expanded="true">
                                <span class="screen-reader-text">Toggle panel: <span style="font-weight:400;">Upgrade</span></span>
                                <span class="toggle-indicator" aria-hidden="true"></span>
                            </button>
                            <h2 class="hndle ui-sortable-handle">
                                <span><span style="font-weight:400;"><span class="dashicons dashicons-unlock"></span> Upgrade</span></span>
                            </h2>
                            <div class="inside">
                                <div>
                                    <h3><span style="font-weight:400; color:#cc3f2b;">Want to add multiple game servers?</span></h3>
                                    <p><span class="dashicons dashicons-flag"></span> You can add up to 5 additional game servers,  with the pro version of the Survival Stats plugin.</p>
                                </div>
                                <div>
                                    <h3><span style="font-weight:400; color:#cc3f2b;">Server Activity Chart</span></h3>
                                    <p><span class="dashicons dashicons-flag"></span> Display a daily wave chart of your server population.</p>
                                </div>
                                <div>
                                    <h3><span style="font-weight:400; color:#cc3f2b;">Rcon Support</span></h3>
                                    <p><span class="dashicons dashicons-flag"></span> Run console commands directly from your website.</p>
                                </div>
                                <div>
                                    <h3><span style="font-weight:400; color:#cc3f2b;">JSON API Access</span></h3>
                                    <p><span class="dashicons dashicons-flag"></span> Access Javascript object notation files with details about your server to use.</p>
                                </div>
                                <div style="text-align: center;">
                                    <a style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white;" class="wpd_pro_btn" target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">See all PRO features</a>
                                </div>
                            </div>
                        </div>
                        <div class="postbox" style="display: block;">
                            <button type="button" class="handlediv button-link" aria-expanded="true">
                                <span class="screen-reader-text">Toggle panel: <span style="font-weight:400;">Coming Soon</span></span>
                                <span class="toggle-indicator" aria-hidden="true"></span>
                            </button>
                            <h2 class="hndle ui-sortable-handle">
                                <span><span style="font-weight:400;"><span class="dashicons dashicons-lightbulb"></span> Coming Soon</span></span>
                            </h2>
                            <div class="inside">
                                <div>
                                    <h3><span style="font-weight:400; color:#cc3f2b;">Player Star Players</span></h3>
                                    <p>Displays a star next to players with most amount of hours recorded on the server</p>
                                </div>
                                <div>
                                    <h3><span style="font-weight:400; color:#cc3f2b;">Full Rcon support</span></h3>
                                    <p>We have not determined how much we are going to enable from the rcon support, but its gonna be cool.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="postbox-container-2" class="postbox-container">
                
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-analytics"></span> API Settings</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <input type="hidden" name="ssark_hidden" value="Y">
                                <p>
                                    <?php _e("API Token Key: " ); ?>
                                    <input type="text" id="ssark_token" name="ssark_token" value="<?php echo $token; ?>" size="80">
                                </p>
                                <p>
                                    <?php _e("API Public Key: " ); ?>
                                    <input type="text" id="ssark_public" name="ssark_public" value="<?php echo $public; ?>" size="80"> <?php _e("*Required for PRO version" ); ?>
                                </p>
                                <p>
                                    <?php _e("API Secret Key: " ); ?>
                                    <input type="text" id="ssark_secret" name="ssark_secret" value="<?php echo $secret; ?>" size="80"> <?php _e("*Required for PRO version" ); ?>
                                </p>

                                <p><strong>PLEASE NOTE:</strong> You are not required to generate multiple API Keys in order to use multiple servers, simply purchase one advanced key to unlock the pro version of this plugin, in order to display advance data for each server you will be required to purchase an advanced licence for each server otherwise basic licences are automatically assigned.</p>
                            </div>
                        </div>
                    </div>

                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-chart-area"></span> Server Settings</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <div id="server-details" >
                                    <?php if(is_array( $server_ip ) && is_array($server_port)): $i=0;?>
                                        <?php foreach($server_ip as $arrayID => $serverInfo ): ?>
                                            <p id="server-<?php echo $server_identifyer[$arrayID];?>">
                                                <?php _e("ID: "); ?> #<input class="ssark_server_identifyer" type="text" name="ssark_server_identifyer[<?php echo $arrayID; ?>]" value="<?php echo $server_identifyer[$arrayID];?>" size="10">
                                                <?php _e("Server Connection Details: " ); ?>
                                                <input class="ssark_server_ip" type="text" name="ssark_server_ip[<?php echo $arrayID; ?>]" value="<?php echo $serverInfo; ?>" size="20"> : 
                                                <input class="ssark_server_port" type="text" name="ssark_server_port[<?php echo $arrayID; ?>]" value="<?php echo $server_port[$arrayID]; ?>" size="10">
                                                <?php _e("Rcon Port: "); ?> <input class="ssark_server_rcon_port" type="text" name="ssark_server_rcon_port[<?php echo $arrayID; ?>]" value="<?php echo $server_rcon_port[$arrayID]; ?>" size="10"> 
                                                <?php _e("Rcon Password: "); ?> <input class="ssark_server_rcon" type="password" name="ssark_server_rcon[<?php echo $arrayID; ?>]" value="<?php echo $server_rcon[$arrayID]; ?>" size="10"> 
                                                <?php _e("SHORTCODE: "); ?> <input class="ssark_server_identifyer" type="text" name="ssark_server_identifyer[<?php echo $arrayID; ?>]" value='[ssark id="<?php echo $server_identifyer[$arrayID];?>"]' size="20" disabled>
                                                <input class="server_verification" type="hidden" name="server_verification[<?php echo $arrayID; ?>]" value="<?php echo $server_verification[$arrayID];?>">
                                                <?php if($i != 0):?>
                                                <a href="#" data-server="<?php echo $server_identifyer[$arrayID];?>" style="display:inline-block; padding: 5px; text-decoration: none; background:#cc3f2b; float: right; border-radius:3px; color:white;" class="wpd_pro_btn deleteserver"><span class="dashicons dashicons-dismiss"></span></a>
                                                <?php endif; ?>
                                                <?php 
                                                if($i == 0){
                                                    $padit = '40px';
                                                } else {
                                                    $padit = '10px';
                                                }
                                                ?>
                                                <a href="#" data-server="<?php echo $server_identifyer[$arrayID];?>" style="display:inline-block; padding: 5px 10px; margin-right: <?php echo $padit;?>; text-decoration: none; background:#cc3f2b; float: right; border-radius:3px; color:white;" class="wpd_pro_btn verifyserver"><span class="dashicons dashicons-flag"></span> Verify</a>
                                            </p>
                                        <?php $i++; endforeach;?>
                                    <?php else:?>
                                        <p id="initialServer">
                                        <?php _e("ID: "); ?> #<input class="ssark_server_identifyer" type="text" name="ssark_server_identifyer[]" value="<?php echo $server_identifyer; ?>" size="10">
                                        <?php _e("Server Connection Details: " ); ?>
                                        <input class="ssark_server_ip" type="text" name="ssark_server_ip[]" value="<?php echo $server_ip; ?>" size="40"> : <input class="ssark_server_port" type="text" name="ssark_server_port[]" value="<?php echo $server_port; ?>" size="10"> 
                                        <?php _e("Rcon Port: "); ?> <input class="ssark_server_rcon_port" type="text" name="ssark_server_rcon_port[]" value="<?php echo $server_rcon_port; ?>" size="10">
                                        <?php _e("Rcon Password: "); ?> <input class="ssark_server_rcon" type="password" name="ssark_server_rcon[]" value="" size="10"> 
                                        <?php _e("SHORTCODE: "); ?> <input class="ssark_server_identifyer" type="text" name="ssark_server_identifyer[<?php echo $arrayID; ?>]" value="<?php echo ($is_advanced)?'[ssark id="' . $server_identifyer . '"]':'[ssark]';?>" size="20" disabled>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <?php if( $is_advanced ): ?>
                                <div style="text-align: right;">
                                    If the servers do not display correctly in the live preview, refreash the page to reinstate the API display.
                                    <a id="addserver" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white;" class="wpd_pro_btn" href="#">Add Server</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-desktop"></span> Live Example</span> 
                                </span>
                            </h2>
                            <div class="inside">
                            <?php if(is_array( $server_ip ) && is_array($server_port)):?>
                                    <?php foreach($server_ip as $arrayID => $serverInfo ): ?>
                                        <div id="<?php echo $server_identifyer[$arrayID];?>" class="survival-stats" data-server="<?php echo $serverInfo; ?>" data-port="<?php echo $server_port[$arrayID]; ?>" data-token="<?php echo $token;?>"></div>
                                    <?php endforeach;?>
                            <?php else:?>
                                <div id="kye_ark_server_api" class="survival-stats" data-server="<?php echo $server_ip;?>" data-port="<?php echo $server_port;?>" data-token="<?php echo $token;?>"></div>
                            <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>