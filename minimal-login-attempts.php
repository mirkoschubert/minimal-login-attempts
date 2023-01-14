<?php
/*
Plugin Name:  Minimal Login Attempts
Plugin URI:   https://github.com/mirkoschubert/minimal-login-attempts
Description:  A WordPress Plugin for a simple, clean and secure brute force solution.
Version:      0.1.0
Author:       Mirko Schubert
Author URI:   https://mirkoschubert.de/
License:      GPL 3.0
License URI:  https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
Text Domain:  mla
Domain Path:  /lang
*/

// Disable direct access
if (!defined('ABSPATH')) exit();

define('MLA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MLA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MLA_PLUGIN_FILE', __FILE__);
define('MLA_PLUGIN_BASENAME', plugin_basename(__FILE__ ));

define('MLA_DIRECT_ADDR', 'REMOTE_ADDR');
define('MLA_PROXY_ADDR', 'HTTP_X_FORWARDED_FOR');

require_once(MLA_PLUGIN_DIR . '/lib/mla.php' );

$mla = new MLA();