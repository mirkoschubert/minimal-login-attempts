<?php
defined('ABSPATH') || die();

class MLA_DB {

  private static $instance;

  const DBTABLE = 'login_attempts';

	public static $dbtable;

  public function __construct() {
    
    $this->init();
  }
  
  public function init() {
    
    $this->setup_variables();

    add_action('after_setup_theme', array($this, 'check_for_upgrade'), 5);
  }

  public function setup_variables() {
		global $wpdb;

		$this::$dbtable = $wpdb->prefix . self::DBTABLE;
	}

  /**
   * Initialized or updates the DB
   * @since 0.3.0
   */
  public function check_for_upgrade() {
    global $options, $wpdb;

    $db_version = $options->get_option('db_version');
    $table_name = $wpdb->prefix . self::DBTABLE;
    
    // first install
    if (false === $db_version || intval($db_version) == 0) {

      $sql = "
        CREATE TABLE IF NOT EXISTS {$table_name} (
          id bigint(20) NOT NULL AUTO_INCREMENT,
          date datetime NOT NULL,
          ip varchar(15) DEFAULT NULL,
          username varchar(255) DEFAULT NULL,
          password varchar(255) DEFAULT NULL,
          status varchar(20) DEFAULT NULL,
          message varchar(255) DEFAULT NULL,
          PRIMARY KEY (id),
          KEY date (date)
        ) CHARSET=utf8;
      ";

      $wpdb->query($sql);

      $db_version = 1;
      $options->update_option('db_version', $db_version);
    }
  }


  /**
   * Check if the database has data/rows
   * @since 0.3.0
   */
	public function db_has_data() {
		global $wpdb;

		$tableprefix = $wpdb->prefix;
		$simple_history_table = self::DBTABLE;

		$sql_data_exists = "SELECT id AS id_exists FROM {$tableprefix}{$simple_history_table} LIMIT 1";
		$data_exists = (bool) $wpdb->get_var($sql_data_exists, 0);

		return $data_exists;
	}

	/**
	 * Removes all items from the log
	 */
	public function clear_log() {}

	/**
	 * Removes old entries from the db
	 */
	public function purge_db() {}


  /**
   * Writes a log entry to the database
   * @since 0.4.0
   */
  public function log($status, $data = array()) {
    global $wpdb;

    $table_name = $wpdb->prefix . self::DBTABLE;

    $data['status'] = $status;

    $result = $wpdb->insert($table_name, $data);

    return $result;
  }

  public function get_logs_by_ip($ip) {

    if (empty($ip)) return false;

  }

  public function get_status($ip) {
    
    $history = $this->get_logs_by_ip($ip);

    // if last_entry === 'banned' return 'banned'
    // if last_enrty === 'lockout' { compare lockouts, decide for ban }
    // if last_entry === 'retry' { compare retries, decide for lockout } 

    $allowed_retries = $options->get_option('allowed_retries');

  }

}