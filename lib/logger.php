<?php
defined('ABSPATH') || die();

class MLA_Logger {

  const DBTABLE = 'mla_logs';
	const DBTABLE_CONTEXTS = 'mla_contexts';

	public static $dbtable;

	public static $dbtable_contexts;
  
  public function __construct() {
    global $wpdb;

    $this->db_table = $wpdb->prefix . DBTABLE;
		$this->db_table_contexts = $wpdb->prefix . DBTABLE_CONTEXTS;
  }

}