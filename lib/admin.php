<?php
defined('ABSPATH') || die();

class MLA_Admin {

  public function __construct() {

    $this->hooks_init();
  }


  /**
   * Initialize Hooks
   * @since 0.3.0
   */
  public function hooks_init() {
    add_action('plugins_loaded', array($this, 'setup'), 100);
    add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
    add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);
  }


  /**
   * Hook: 'plugins_loaded'
   * @since 0.3.0
   */
  public function setup() {

    add_action('admin_menu', array($this, 'admin_menu'));
  }


  /**
   * Load admin scripts and stylesheets
   * @since 0.3.0
   */
  public function admin_enqueue() {
    global $options;

    if (!empty($_REQUEST['page']) && $_REQUEST['page'] === $options->options_page_slug) {
      // Only for settings page
      wp_enqueue_style('mla-admin', MLA_PLUGIN_URL . 'assets/css/admin.css', array(), $options->plugin_version);
    }
  }


  /**
   * Register admin menu page in Options
   * @since 0.3.0
   */
  public function admin_menu() {
    global $options;

    $plugin_hook  = add_options_page($options->plugin_name, __('Login Attempts', 'mla'), 'manage_options', $options->options_page_slug, array($this, 'settings_page'));

    if ($plugin_hook)
      add_action('load-' . $plugin_hook, array($this, 'contextual_help'));
  }


  /**
   * Settings Page
   * @since 0.3.0
   */
  public function settings_page() {
    global $options;

    include_once(MLA_PLUGIN_DIR . '/lib/views/settings-page.php');
  }


  /**
   * Contextual Help
   * @since 0.3.0
   */
  public function contextual_help() {
    global $options;

    $current_screen = get_current_screen();

    $about = '<p><strong>' . $options->plugin_name . '</strong> ' . __('is a simple, clean and secure contact form.', 'mla') . '</p><p>' . __('This plugin was developed with usability in mind and uses data that already exists. It provides security features to prevent the receipt of spam without passing on data to third parties. In addition, it automatically inserts a corresponding notice to comply with the requirements of the GDPR.', 'mla') . '</p>';

    $current_screen->add_help_tab(array(
      'id' => 'mla-about-help-tab',
      'title' => __('About', 'mla'),
      'content' => $about
    ));
  }


  /**
   * Sets a link to the settings page in the plugin list
   * @since 0.3.0
   */
  function action_links($links, $file) {
    global $options;
        
    if ($file == MLA_PLUGIN_BASENAME) array_unshift($links, '<a href="'. get_admin_url() .'options-general.php?page='. $options->options_page_slug .'">'. esc_html__('Settings', 'mcf') .'</a>');
    return $links;
  }

}