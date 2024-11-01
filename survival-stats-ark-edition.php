<?php
/*
	Plugin Name: Survival Stats: Ark Edition
	Version: 3.01
	
	Author: KYE Creations
	Author URI: http://www.knowyourenemy.co.uk
	
	Description: Display details about your gaming server with the KYE Server API, the Survival Stats Ark: Survival Evolved edition  plugin for wordpress is powered by our API and will display all sorts of cool data about your server and the players. 
	
	Network: True
	
	License: GPLv3
	
	Copyright (C) 2016 KYE Creations

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.	
*/

include("plugin-maintenance/update.php");

	class SSArkModule {
		function __construct($param) {
			$this->base = $param;
		}
	}

	class ssArk {
		public function __construct() {

			$this->update = new _ssArk_update($this);
			$this->init();
		}

		/**
		* Action the plugin features
		*/
		function init(){
			add_action('wp_footer', array($this,'_load_api_script'));
			add_action( 'wp_enqueue_scripts', array($this,'_load_google_charts') );
			add_action('admin_enqueue_scripts', array($this,'_load_admin_js') );
			add_action('admin_menu', array($this,'_ssArk_admin_actions'));

			add_action( 'wp_ajax_verification_callback', array($this,'verification_callback'));
			add_action( 'wp_ajax_nopriv_verification_callback',  array($this,'verification_callback') );

			add_filter('script_loader_tag',array($this,'_setup_script'),10,2);

			add_shortcode( 'ssark', array($this,'ssark_shortcode'));
		}

		function _load_api_script(){
	        $identifyers 		= '';
			$token 				= get_option('ssark_token');
	        $secret 			= get_option('ssark_secret'); //PRO VERSION
	        $public 			= get_option('ssark_public'); //PRO VERSION
	        $server_identifyer 	= get_option('ssark_server_identifyer');
	        $server_ip 			= get_option('ssark_server_ip');
	        $server_port 		= get_option('ssark_server_port');

	        if(is_array( $server_ip ) && is_array($server_port)){
	        	$identifyers = '&identifyers=' . base64_encode(json_encode($server_identifyer));
		        $initialIP = base64_encode(json_encode($server_ip));
		        $initialPORT = base64_encode(json_encode($server_port));
		    }else{
		        $initialIP = $server_ip;
		        $initialPORT = $server_port;
		    }
			?>
			<!-- KYE Server Widget Start -->
			<script type='text/javascript' src='http://api.knowyourenemy.co.uk/server_widget.v3.wp.js?serverip=<?php echo $initialIP;?>&serverport=<?php echo $initialPORT;?>&key=<?php echo $token;?><?php echo $identifyers?>' data-hash="c116bc168da6fb93b0a38839640619c0"></script>
			<!-- KYE Server Widget End -->
			<?php
		}

		function _load_google_charts(){
			wp_enqueue_script( 'google-jsapi', 'https://www.google.com/jsapi');
		}

		function _load_admin_js(){
			$identifyers 		= '';
			$token 				= get_option('ssark_token');
	        $secret 			= get_option('ssark_secret'); //PRO VERSION
	        $public 			= get_option('ssark_public'); //PRO VERSION
	        $server_identifyer 	= get_option('ssark_server_identifyer');
	        $server_ip 			= get_option('ssark_server_ip');
	        $server_port 		= get_option('ssark_server_port');

	        if(is_array( $server_ip ) && is_array($server_port)){
	        	$identifyers = '&identifyers=' . base64_encode(json_encode($server_identifyer));
		        $initialIP = base64_encode(json_encode($server_ip));
		        $initialPORT = base64_encode(json_encode($server_port));
		    }else{
		        $initialIP = $server_ip ;
		        $initialPORT = $server_port;
		    }

			wp_enqueue_script( 'google-jsapi', 'https://www.google.com/jsapi');
			wp_enqueue_script( 'ssark-admin-js', plugins_url( 'survival-stats-ark-edition/libraries/js/ssark-admin.js' , dirname(__FILE__) ));
			wp_enqueue_script( 'ssark-admin', 'http://api.knowyourenemy.co.uk/server_widget.v3.wp.js?serverip=' . $initialIP . '&serverport=' . $initialPORT . '&key=' . $token . $identifyers ,TRUE, '3.01' );

			wp_localize_script( 'ssark-admin-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}

		function _setup_script($tag, $handle){
            if ( 'ssark-admin' !== $handle )
        		return $tag;
    		return str_replace( ' src', ' data-hash="c116bc168da6fb93b0a38839640619c0" src', $tag );
		}

		function _ssArk_admin(){
			include('SSArk_Admin/ssark-admin.php');
		}

		function _ssArk_rcon(){
			include('SSArk_Admin/ssark-admin-rcon.php');
		}

		function _ssArk_admin_actions(){
			add_menu_page( "SS: Ark Edition", "SS: Ark Edition", "read", "ss-ark-rcon", array($this,'_ssArk_rcon'),"dashicons-editor-kitchensink" );
			add_submenu_page('ss-ark-rcon', __('SS: Ark Rcon'), __('SS: Ark Rcon'), 'read', 'ss-ark-rcon', array($this,'_ssArk_rcon'));
			add_submenu_page('ss-ark-rcon', __('SS: Ark Settings'), __('SS: Ark Settings'), 'read', 'ss-ark-settings', array($this,'_ssArk_admin'));
		}

		function ssark_shortcode( $atts ) {
		    extract( 
		        shortcode_atts(array('id' => 'kye_ark_server_api'), $atts)
		    );

		    $token = get_option('ssark_token');
	        $secret = get_option('ssark_secret'); //PRO VERSION
	        $public = get_option('ssark_public'); //PRO VERSION

	        $server_identifyer = get_option('ssark_server_identifyer');
	        $server_ip = get_option('ssark_server_ip');
	        $server_port = get_option('ssark_server_port');

	        if(  $token != '' && $server_ip != ''&& $server_port != ''){
		    	if(is_array( $server_ip ) && is_array($server_port)){
		    		$server = array_search( $atts['id'], $server_identifyer );
	        		return '<div id="' . $atts['id'] . '" class="survival-stats" data-server="' . $server_ip[$server] . '" data-port="' . $server_port[$server] . '" data-token="' . $token . '"></div>';
	        	}else{
	        		return '<div id="kye_ark_server_api" class="survival-stats" data-server="' . $server_ip . '" data-port="' . $server_port . '" data-token="' . $token . '"></div>';
	        	}
	        }else{
	        	return '<p><strong>Survival Stats: Ark Edition</strong> Make sure to update your settings as we can not display your widget as there is an issue with your settings.</p>';
	        }
		}

		function verification_callback(){
			global $wpdb;
				print_r($_POST);
			wp_die();
		}

	}

	$ssArk = new ssArk();