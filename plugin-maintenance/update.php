<?php

class _ssArk_update {
	
	// custom updates/upgrades
	public $plugin_file = "survival-stats-ark-edition.php";
	public $plugin_folder = "";
	public $update_check = "http://www.knowyourenemy.co.uk/repo/survival-stats-ark-edition.chk";

	public function _ssArk_update() {
		$this->add_update_actions();
		$this->add_update_filters();

		$this->plugin_folder = basename(dirname(dirname(__FILE__)));
	}

	private function add_update_actions() {
		add_action('admin_init', array($this, 'anm_check_update'));
	}

	private function add_update_filters() {
		add_filter( 'http_request_args', array($this, 'anm_updates_exclude'), 5, 2 );
	}


	function anm_check_update() {
		global $wp_version;
	    
		if ( defined( 'WP_INSTALLING' ) ) {
			return false;
		}

		$response = wp_remote_get( $this->update_check );
		
		// If it hasn't failed to get the file
		if( !isset($response->errors) ) {
		    
		    // Get version and URL
		    list($version, $url) = explode('|', $response['body']);
		    
			// Check our current version and new version, if same, quit!
		    if( $this->anm_plugin_get("Version") == $version ) {
		    	return false;
		    }
			
			// Not quite sure just yet
		    $plugin_transient = get_site_transient('update_plugins');
			
		    // Ideally, would like to add 'sections'' to the below so upgrade info is available...
		    $array = array(
				'slug' => $this->plugin_folder,
				'new_version' => $version,
				'url' => $this->anm_plugin_get("AuthorURI"),
				'package' => $url
			);

			$object = (object) $array;
			$plugin_transient->response[$this->plugin_folder.'/'.$this->plugin_file] = $object;
			set_site_transient('update_plugins', $plugin_transient);
		}
	}


	// Exclude from WP updates
	function anm_updates_exclude( $r, $url ) {
		if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) ) {
			return $r; // Not a plugin update request. Bail immediately.
		}

		$plugins = unserialize( $r['body']['plugins'] );

		unset( $plugins->plugins[ "survival-stats-ark-edition/survival-stats-ark-edition.php" ] );
		unset( $plugins->active[ array_search( plugin_basename( $this->plugin_file ), $plugins->active ) ] );
		$r['body']['plugins'] = serialize( $plugins );
		
		return $r;
	}


	// Returns current plugin info.
	private function anm_plugin_get($i) {

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once( "survival-stats-ark-edition/survival-stats-ark-edition.php" );
		}

		$plugins = get_plugins( '/' . plugin_basename( dirname( $this->plugin_file ) ) );

		return $plugins[$this->plugin_folder."/".$this->plugin_file][$i];
	}
}