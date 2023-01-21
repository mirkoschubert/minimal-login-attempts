<?php
defined('ABSPATH') || die();

class MLA_Auth {

  public function __construct() {

    $this->hooks_init();
  }

  /**
   * Initialize Hooks
   * @since 0.3.0
   */
  public function hooks_init() {

    add_action('plugins_loaded', array($this, 'setup'), 100);
    add_action('login_enqueue_scripts', array($this, 'login_enqueue'));
    add_action('login_footer', array($this, 'login_gdpr_message'));
		add_action('login_footer', array($this, 'login_render_js'), 9999);
  }

  /**
   * Hook: 'plugins_loaded'
   * @since 0.3.0
   */
  public function setup() {

    add_action('wp_login_failed', array($this, 'limit_login_failed'));
		add_filter('wp_authenticate_user', array($this, 'wp_authenticate_user'), 99999, 2);

    // Add notices for XMLRPC request
		//add_filter( 'xmlrpc_login_error', array( $this, 'xmlrpc_error_messages' ) );

    //add_action( 'wp_authenticate', array( $this, 'track_credentials' ), 10, 2 );
		//add_action( 'authenticate', array( $this, 'authenticate_filter' ), 5, 3 );

    // Buddypress
    //add_action( 'authenticate', array( $this, 'authenticate_filter_errors_fix' ), 35, 3 );

    //add_action('wp_ajax_limit-login-unlock', array( $this, 'ajax_unlock' ) );
  }


  public function login_enqueue() {
    global $options;

		wp_enqueue_style('mla-login-styles', MLA_PLUGIN_URL . 'assets/css/login.css', array(), $options->plugin_version);
    wp_enqueue_script('jquery');
	}


  public function login_gdpr_message() {

	  if (isset($_REQUEST['interim-login'])) return;
	  ?>
      <div id="mla-login-gdpr">
        <div class="mla-login-gdpr-message"><?php echo do_shortcode(stripslashes(__('By proceeding you understand and give your consent that your IP address and browser information might be processed by the security plugins installed on this site.', 'mla'))); ?></div>
      </div>
    <?php
  }


  public function login_render_js() {
	  global $mla_just_lockedout;

		if ((isset($_POST['log']) || (function_exists('is_account_page') && is_account_page() && isset($_POST['username']))) && ($this->is_limit_login_ok() || $mla_just_lockedout)) :
    ?>
      <script>
        ;(function($) {
          var ajaxUrlObj = new URL('<?php echo admin_url('admin-ajax.php'); ?>');
          ajaxUrlObj.protocol = location.protocol;

          $.post(ajaxUrlObj.toString(), {
            action: 'get_remaining_attempts_message',
            sec: '<?php echo wp_create_nonce('mla-action'); ?>'
          }, function(response) {
            if(response.success && response.data) {
              $('#login_error').append("<br>" + response.data);
              $('.woocommerce-error').append("<li>(" + response.data + ")</li>");
            }
          })
          })(jQuery)
      </script>
    <?php
    endif;
  }


  /**
   * Action when login attempt failed
   */
  public function limit_login_failed($username) {
    global $db;

		if(!session_id()) {
			session_start();
		}

		$_SESSION['login_attempts_left'] = 0;
	
    // check for lockout or ban

    // else
    //$date, $ip, $username, $message
    $ip = $this->get_address();

    //$status $db->get_status($ip)

    //var_dump($ip, $username);

    $db->log('test', array(
      'date' => gmdate('Y-m-d H:i:s', strtotime('now')),
      'ip' => $ip,
      'username' => $username,
      'message' => ''
    ));
    
	}


	public function wp_authenticate_user($user, $password) {
    global $mla_error_shown;

    if (is_wp_error($user)) {
      return $user;
    }
    $user_login = '';

    if (is_a($user, 'WP_User')) {
      $user_login = $user->user_login;
    } else if (!empty($user) && !is_wp_error($user)) {
      $user_login = $user;
    }

		if (/* $this->is_ip_whitelisted($this->get_address()) || $this->is_un_whitelisted($user_login) || */ $this->is_limit_login_ok()) {
			return $user;
		}

		$error = new WP_Error();

		$mla_error_shown = true;

		/* if ( $this->is_un_banned( $user_login ) || $this->is_ip_blacklisted( $this->get_address() ) ) {
			$error->add('username_banned', "<strong>ERROR:</strong> Too many failed login attempts.");
		} else {
			// This error should be the same as in "shake it" filter below
			$error->add('too_many_retries', $this->error_msg());
		} */

		return $error;
	}


/**
	* Check if it is ok to login
	* @since 0.3.0
	*/
	public function is_limit_login_ok() {
    global $options;

		$ip = $this->get_address();

		/* Check external whitelist filter */
		/* if ($this->is_ip_whitelisted($ip)) {
			return true;
		} */

		/* lockout active? */
		$lockouts = $options->get_option('lockouts');

		return (!is_array($lockouts) || !isset($lockouts[$ip] ) || time() >= $lockouts[$ip]);
	}




	/**
	 * Get correct remote address
	 */
	public function get_address() {

		$origin = MLA_DIRECT_ADDR;
		$ip = '';

    if (isset($_SERVER[$origin]) && !empty($_SERVER[$origin])) {
      if (strpos($_SERVER[$origin], ',') !== false) {
        $origin_ips = array_map('trim', explode(',', $_SERVER[$origin]));
        if ($origin_ips) {
					foreach ($origin_ips as $check_ip) {
            if ($this->is_ip_valid($check_ip)) {
              $ip = $check_ip;
              break;
            }
          }
        }
      }
      if ($this->is_ip_valid($_SERVER[$origin])) {
				$ip = $_SERVER[$origin];
      }
		}

		return preg_replace('/^(\d+\.\d+\.\d+\.\d+):\d+$/', '\1', $ip);
	}


  /**
	 * Validate IP adress
	 */
	public function is_ip_valid($ip) {

    if (empty($ip)) return false;
    return filter_var($ip, FILTER_VALIDATE_IP);
  }


  public function is_ip_whitelisted($ip = null) {
    global $options;

		if (is_null($ip) ) {
			$ip = $this->get_address();
		}
		$whitelisted = MLA_Helpers::ip_in_range($ip, (array)$options->get_option('whitelisted'));

		return ($whitelisted === true);
	}

  
}