<?php
defined('ABSPATH') || die();

class MLA {

	public $_errors = array();

	public $other_login_errors = array();

  public $auth = null;

  public $admin = null;

  /**
   * Constructor
   */
  public function __construct() {
    
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
    global $options;

    // Load languages files
		load_plugin_textdomain('mla', false, plugin_basename(dirname(__FILE__)) . '/../lang');

    //$options->sanitize_options();

    if (is_admin()) {
      $this->admin = new MLA_Admin();
    }

    if ($this->is_login_page()) {
      $this->auth = new MLA_Auth();
    }
  }

  public function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
  }

}