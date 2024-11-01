<?php 
    include plugin_dir_path(__FILE__) . '../admin-functions/functions.php';

    //Normal page display
    $token = get_option('ssark_token');
    $secret = get_option('ssark_secret');
    $public = get_option('ssark_public');

    $server_identifyer = get_option('ssark_server_identifyer');
    $server_ip = get_option('ssark_server_ip');
    $server_port = get_option('ssark_server_port');

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

?>
<div class="wrap">
    <div id="navigation" style="float: right;padding:8px 25px 8px;">
        <strong style="display:inline-block; padding:8px; text-transform: uppercase;">Navigation</strong>
        <a style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="admin.php?page=ss-ark-settings">Server Settings</a>
        <a style="display:inline-block; text-decoration: none; background:#23282d; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="admin.php?page=ss-ark-rcon">SS:RCON</a>
    </div>
    <div id="selected-server" style="float: right;padding:8px 25px 8px;" data-apikey="<?php echo $token;?>">
        <strong style="display:inline-block; padding:8px; text-transform: uppercase;">Server Selection</strong>
        <?php if(is_array( $server_ip ) && is_array($server_port)): $i=0;?>
            <?php foreach($server_ip as $arrayID => $serverInfo ): ?>
                <a class="<?php echo ($i == 0)?'selected':'';?>" data-serverip="<?php echo $serverInfo; ?>" data-serverport="<?php echo $server_port[$arrayID]; ?>" style="display:inline-block; text-decoration: none; background:<?php echo ($i == 0)?'#23282d':'#cc3f2b';?>; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="#"><?php echo $serverInfo; ?> : <?php echo $server_port[$arrayID]; ?></a>
            <?php $i++; endforeach;?>
        <?php else:?>
            <p><strong>Opps, looks like you need to verify your <a href="admin.php?page=ss-ark-settings">server settings</a>, or you may need to <a target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">upgrade your API key</a></strong></p>
        <?php endif; ?>
    </div>
    <?php    echo "<h1>" . __( 'Survival Stats: Ark Edition Rcon', 'ssark_trdom' ) . "</h1>"; ?>
    <?php    echo "<h2>" . __( 'VERSION: 3.0', 'ssark_trdom' ) . "</h2>"; ?>

     <form name="ssark_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">    
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">

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
                                    <span style="font-weight:400;"><span class="dashicons dashicons-admin-users"></span> Players</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <?php if( $is_advanced ): ?>
                                    <div id="playerlists" class="clearfix">
                                        <div id="currentplayers" style="float: left; width: 50%;">
                                            <h3>Live Player List</h3>
                                            <div class="list" style=" height: 200px; max-height: 200px; overflow:auto;">
                                                <ul>
                                                    <li class="clearfix"><div style="width:50%; float:left;"><strong>PLAYER NAME</strong></div><div style="width:50%; float:left;"><strong>STEAMID</strong></div></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="allplayers" style="float: left; width: 50%;">
                                            <h3>All time Player List</h3>
                                            <div class="list" style=" height: 200px; max-height: 200px; overflow:auto;">
                                                <ul>
                                                    <li class="clearfix"><div style="width:50%; float:left;"><strong>PLAYER NAME</strong></div><div style="width:50%; float:left;"><strong>STEAMID</strong></div></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p><strong>Opps, looks like you need to verify your <a href="admin.php?page=ss-ark-settings">server settings</a>, or you may need to <a target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">upgrade your API key</a></strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-admin-post"></span> Server Tasks</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <?php if( $is_advanced ): ?>
                                    <div id="messages" class="clearfix">
                                        <div id="messgaeoftheday" style="float: left; width: 48%; padding: 1%;">
                                            <h3>Message of the day</h3>
                                            <div class="list" style=" height: 200px; margin-bottom: 20px;">
                                                <textarea id="motd" name="motd" style="width:100%; border:1px solid #cc3f2b;height: 200px;"></textarea>
                                            </div>
                                            <a id="setmessageoftheday" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="#">Set MOTD</a>
                                            <a id="broadcastmessageoftheday" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="#">Show MOTD on Server</a>
                                        </div>
                                        <div id="broadcast" style="float: left; width: 48%; padding: 1%;">
                                            <h3>Broadcast Message</h3>
                                            <div class="list" style=" height: 200px; margin-bottom: 20px;">
                                                <textarea id="messagebroadcast" name="broadcast" style="width:100%; border:1px solid #cc3f2b;height: 200px;"></textarea>
                                            </div>
                                            <a id="broadcastmessage" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; float: right; margin-left: 15px;" class="wpd_pro_btn" href="#">Broadcast</a>
                                        </div>
                                    </div>
                                    <div id="timeofday" class="clearfix">
                                        <div style="float: left; width: 48%; padding: 1%;">
                                            <h3>Set time of day</h3>
                                            <div class="list">
                                                <select id="timeofday" name="time" style="padding:8px 25px 8px; height: 50px;border:1px solid #cc3f2b;">
                                                  <?php
                                                    for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
                                                        for($mins=0; $mins<60; $mins+=10) // the interval for mins is '30'
                                                            echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                                           .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
                                                    ?>
                                                </select>
                                                <a id="settimeofday" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; margin-left: 15px;" class="wpd_pro_btn" href="#">Set</a>
                                            </div>
                                        </div>
                                        <div style="float: left; width: 48%; padding: 1%;">
                                            <h3>One-Click-Controls</h3>
                                            <a id="saveworld" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; margin-left: 15px;" class="wpd_pro_btn" href="#">Save World</a>
                                            <a id="doexit" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; margin-left: 15px;" class="wpd_pro_btn" href="#">Exit Game</a>
                                            <a id="destroywilddinos" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; margin-left: 15px;" class="wpd_pro_btn" href="#">Destroy All Wild Dinos</a>
                                            <a id="destroystructures" style="display:inline-block; text-decoration: none; background:#cc3f2b; padding:8px 25px 8px; border-radius:3px; color:white; margin-left: 15px;" class="wpd_pro_btn" href="#">Destroy Structures</a>
                                            <p>WARNING: Some of these commands are none reversable and may even cause your server to crash.</p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p><strong>Opps, looks like you need to verify your <a href="admin.php?page=ss-ark-settings">server settings</a>, or you may need to <a target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">upgrade your API key</a></strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-admin-generic"></span> Schedules</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <?php if( $is_advanced ): ?>
                                    <p>THIS FEATURE WILL BE COMING IN THE NEXT UPDATE</p>
                                <?php else: ?>
                                    <p><strong>Opps, looks like you need to verify your <a href="admin.php?page=ss-ark-settings">server settings</a>, or you may need to <a target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">upgrade your API key</a></strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-admin-comments"></span> Chat</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <?php if( $is_advanced ): ?>
                                    <div id="rconchat">
                                        <p>Initialising Chat...</p>
                                    </div>
                                    <div id="rconchat_command">
                                        <input class="rconchat_command" type="text" name="rconchat_command" style="width:90%;" value="" placeholder="Type to chat">
                                        <a id="send_chat_command" href="#" style="display:inline-block; padding: 5px 10px; margin-right: <?php echo $padit;?>; text-decoration: none; background:#cc3f2b; float: right; border-radius:3px; color:white;" class="wpd_pro_btn">Chat</a>
                                    </div>
                                <?php else: ?>
                                    <p><strong>Opps, looks like you need to verify your <a href="admin.php?page=ss-ark-settings">server settings</a>, or you may need to <a target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">upgrade your API key</a></strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox ">
                            <h2 class="hndle ui-sortable-handle">
                                <span>
                                    <span style="font-weight:400;"><span class="dashicons dashicons-admin-settings"></span> Console</span> 
                                    <?php if($is_advanced):?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-unlock"></span> Pro version</span>
                                        </a>
                                    <?php else: ?>
                                        <a target="_blank" class="wpd_free_pro" title="Unlock more features with Survival Stats PRO!" href="http://www.knowyourenemy.co.uk/game-server-api-access"><span style="color:#cc3f2b;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span></a>
                                    <?php endif;?>
                                </span>
                            </h2>
                            <div class="inside">
                                <?php if( $is_advanced ): ?>
                                    <div class="consolelog" style=" height: 200px; max-height: 200px; overflow:auto;">
                                        <ul >
                                            <li>Console log initialised... </li>
                                        </ul>
                                    </div>
                                    <div id="console_command">
                                        <input class="console_command" type="text" name="console_command" style="width:90%;" value="" placeholder="Type a console command">
                                        <a id="send_console_command" href="#" style="display:inline-block; padding: 5px 10px; margin-right: <?php echo $padit;?>; text-decoration: none; background:#cc3f2b; float: right; border-radius:3px; color:white;" class="wpd_pro_btn">EXICUTE</a>
                                    </div>
                                <?php else: ?>
                                    <p><strong>Opps, looks like you need to verify your <a href="admin.php?page=ss-ark-settings">server settings</a>, or you may need to <a target="_blank" href="http://www.knowyourenemy.co.uk/packages/advanced-api-key">upgrade your API key</a></strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>
</div>