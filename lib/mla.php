<?php

class MLA {

  public $default_options = array(
    'gdpr_message'        => '',
    'client_type'         => MLA_DIRECT_ADDR,
		'allowed_retries'     => 5,
		'lockout_duration'    => 1200, // 20 minutes
		'allowed_lockouts'    => 3,
		'cookies'             => true,
    'whitelist'           => array(),
		'whitelist_usernames' => array(),
		'blacklist'           => array(),
		'blacklist_usernames' => array(),
    'logged'              => array(),
    'retries_valid'       => array(),
    'retries'             => array(),
    'lockouts'            => array()
  );

  public $plugin_version = '';

  public $plugin_name = '';

	private $_options_page_slug = 'minimal-login-attempts';

	public $_errors = array();

	public $other_login_errors = array();

	private $use_local_options = null;

	public $app = null;

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

    add_action('plugins_loaded', array($this, 'setup'), 9999);
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));

    add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);

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

    add_action('admin_menu', array($this, 'admin_menu'));
  }

  /**
   * Load admin scripts and stylesheets
   */
  public function admin_enqueue() {
    wp_enqueue_style('mla-admin', MLA_PLUGIN_URL . 'assets/css/admin.css', array(), $this->plugin_version);

    if (!empty($_REQUEST['page']) && $_REQUEST['page'] === $this->_options_page_slug) {
      // Only for options page
    }
  }


  /**
   * Register admin menu page in Options
   */
  public function admin_menu() {
    $plugin_hook  = add_options_page($this->plugin_name, __('Login Attempts', 'mla'), 'manage_options', $this->_options_page_slug, array($this, 'options_page'));

    if ($plugin_hook)
      add_action('load-' . $plugin_hook, array($this, 'contextual_help'));
  }

  /**
   * Options Page
   */
  public function options_page() {
    $mla_version = $this->plugin_version;

    include_once(MLA_PLUGIN_DIR . '/lib/views/options-page.php');
  }

  public function contextual_help() {
    $current_screen = get_current_screen();

    $about = '<p><strong>' . $this->plugin_name . '</strong> ' . __('is a simple, clean and secure contact form.', 'mla') . '</p><p>' . __('This plugin was developed with usability in mind and uses data that already exists. It provides security features to prevent the receipt of spam without passing on data to third parties. In addition, it automatically inserts a corresponding notice to comply with the requirements of the GDPR.', 'mla') . '</p>';

    $current_screen->add_help_tab(array(
      'id' => 'mla-about-help-tab',
      'title' => __('About', 'mla'),
      'content' => $about
    ));
  }

  /**
   * Sets a link to the settings page in the plugin list
   */
  function action_links($links, $file) {
        
    if ($file == MLA_PLUGIN_BASENAME) array_unshift($links, '<a href="'. get_admin_url() .'options-general.php?page='. $this->_options_page_slug .'">'. esc_html__('Settings', 'mcf') .'</a>');
    return $links;
  }
  

  public function get_option($option_name) {

		$option = 'mla_'.$option_name;
		$value = get_option( $option, null );

		if (is_null($value) && isset($this->default_options[$option_name]))
			$value = $this->default_options[ $option_name ];

		return $value;
  }

  public function update_option($option_name) {

		$option = 'mla_'.$option_name;
		return update_option($option, $value);
  }

  public function add_option($option_name, $value) {

		$option = 'mla_'.$option_name;
		return add_option($option, $value, '', 'no');
  }

  public function delete_option($option_name) {

    $option = 'mla_'.$option_name;
		return delete_option($option);
  }

  public function sanitize_options() {

  }

}