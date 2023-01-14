<?php


class MLA_Options {

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

	private $_options_page_slug = 'minimal-login-attempts';

  public $plugin_version = '';

  public $plugin_name = '';

  /**
   * Constructor
   */
  public function __construct(string $name = '', string $version = '') {
    $this->plugin_name = $name;
    $this->plugin_version = $version;

    $this->default_options['gdpr_message'] = __( 'By proceeding you understand and give your consent that your IP address and browser information might be processed by the security plugins installed on this site.', 'mla' );
    
    $this->hooks_init();
  }

  /**
   * Initialize Hooks
   * @since 0.2.0
   */
  public function hooks_init() {
    add_action('plugins_loaded', array($this, 'setup'), 100);
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
    add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);
  }


  /**
   * Hook: 'plugins_loaded'
   * @since 0.2.0
   */
  public function setup() {

    add_action('admin_menu', array($this, 'admin_menu'));
  }


  /**
   * Load admin scripts and stylesheets
   * @since 0.2.0
   */
  public function admin_enqueue() {
    
    if (!empty($_REQUEST['page']) && $_REQUEST['page'] === $this->_options_page_slug) {
      // Only for options page
      wp_enqueue_style('mla-admin', MLA_PLUGIN_URL . 'assets/css/admin.css', array(), $this->plugin_version);
    }
  }


  /**
   * Register admin menu page in Options
   * @since 0.2.0
   */
  public function admin_menu() {
    $plugin_hook  = add_options_page($this->plugin_name, __('Login Attempts', 'mla'), 'manage_options', $this->_options_page_slug, array($this, 'options_page'));

    if ($plugin_hook)
      add_action('load-' . $plugin_hook, array($this, 'contextual_help'));
  }


  /**
   * Options Page
   * @since 0.2.0
   */
  public function options_page() {
    $mla_version = $this->plugin_version;

    include_once(MLA_PLUGIN_DIR . '/lib/views/options-page.php');
  }


  /**
   * Contextual Help
   * @since 0.2.0
   */
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
   * @since 0.2.0
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