<?php

class MLA {

  public $plugin_name = '';

  public $plugin_version = '';

	public $_errors = array();

	public $other_login_errors = array();

	public $app = null;

  public $options = null;

  /**
   * Constructor
   */
  public function __construct() {

    $this->default_options['gdpr_message'] = __( 'By proceeding you understand and give your consent that your IP address and browser information might be processed by the security plugins installed on this site.', 'mla' );
    
    $this->hooks_init();
    //$this->app_init();
  }

  /**
   * Register hooks and filters
   */
  public function hooks_init() {

    add_action('plugins_loaded', array($this, 'setup'), 50);

    register_activation_hook(MLA_PLUGIN_FILE, array($this, 'plugin_activation'));
    register_deactivation_hook(MLA_PLUGIN_FILE, array($this, 'plugin_deactivation'));
    register_uninstall_hook(MLA_PLUGIN_FILE, 'plugin_uninstall');
  }


  public function app_init() {

  }


  /**
   * Hook: Activation
   */
  public function plugin_activation() {

  }

  /**
   * Hook: Deactivation
   */
  public function plugin_deactivation() {

  }

  /**
   * Hook: Uninstall
   */
  static function plugin_uninstall() {

  }

  /**
   * Hook: 'plugins_loaded'
   */
  public function setup() {

    if (!function_exists('get_plugin_data'))
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');

    $plugin_data = get_plugin_data(MLA_PLUGIN_DIR . '/minimal-login-attempts.php');
    $this->plugin_version = $plugin_data['Version'];
    $this->plugin_name = $plugin_data['Name'];

    // Load languages files
		load_plugin_textdomain('mla', false, plugin_basename(dirname(__FILE__)) . '/../lang');


    $this->options = new MLA_Options($this->plugin_name, $this->plugin_version);
  }

}