<?php

class MinimalLoginAttempts {

  public $default_options = array();

	private $_options_page_slug = 'minimal-login-attempts';

	public $_errors = array();

	public $other_login_errors = array();

	private $use_local_options = null;

	public $app = null;

  /**
   * Constructor
   */
  public function __construct() {

  }

  /**
   * Register hooks and filters
   */
  public function hooks_init() {

  }

  /**
   * Activation
   */
  public function activation() {

  }

  /**
   * Hook: 'plugins_loaded'
   */
  public function setup() {

  }

  /**
   * GDPR message for login page
   */
  public function login_page_gdpr_message() {

  }

  /** 
   * Render JS on login page
   */
  public function login_page_render_js() {

  }

  public function app_init() {

  }

  /**
   * Load admin scripts
   */
  public function load_admin_scripts() {

  }

  /**
   * Load frontend scripts and stylesheets
   */
  public function enqueue() {

  }

  /**
   * Load loging page scripts
   */
  public function login_page_enqueue() {

  }

  /**
   * Register admin menu page in Options
   */
  public function options_admin_menu() {

  }

  public function get_option( $option_name, $local = null ) {

  }

  public function add_option( $option_name, $value, $local=null ) {

  }

  public function delete_option( $option_name, $local=null ) {

  }

  public function sanitize_options() {
    
  }

}