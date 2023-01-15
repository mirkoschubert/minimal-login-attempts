<?php
defined('ABSPATH') || die();

class MLA_Options {

  public $default_options = array(
    'client_type'         => MLA_DIRECT_ADDR,
		'allowed_retries'     => 5,
		'lockout_duration'    => 1200, // 20 minutes
		'allowed_lockouts'    => 3,
    'db_version'          => 0
  );

	public $options_page_slug = 'minimal-login-attempts';

  public $plugin_version = '';

  public $plugin_name = '';

  /**
   * Constructor
   */
  public function __construct() {
    
    add_action('plugins_loaded', array($this, 'set_plugin_metadata'), 100);
  }

  public function set_plugin_metadata() {
    if (!function_exists('get_plugin_data'))
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');

    $plugin_data = get_plugin_data(MLA_PLUGIN_DIR . '/minimal-login-attempts.php');
    $this->plugin_version = $plugin_data['Version'];
    $this->plugin_name = $plugin_data['Name'];
  }


  public function get_option($option_name) {

		$option = 'mla_' . $option_name;
		$value = get_option($option, null);

		if (is_null($value) && isset($this->default_options[$option_name]))
			$value = $this->default_options[$option_name];

		return $value;
  }


  public function update_option($option_name, $value) {

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
    $simple_int_options = array( 'allowed_retries', 'lockout_duration', 'allowed_lockouts', 'db_version');
		foreach ($simple_int_options as $option) {
			$val = $this->get_option($option);
			if ((int)$val != $val || (int)$val <= 0)
				$this->update_option($option, 1);
		}

		$ctype = $this->get_option('client_type');
		if ($ctype != MLA_DIRECT_ADDR && $ctype != MLA_PROXY_ADDR)
			$this->update_option('client_type', MLA_DIRECT_ADDR);
  }


}