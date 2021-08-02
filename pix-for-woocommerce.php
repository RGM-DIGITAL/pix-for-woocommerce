<?php

/**
 * Plugin Name:Pix for WooCommerce
 * Plugin URI: https://github.com/rafaelmatostj/pix-for-woocommerce
 * Description: Receba pagamentos com o  Pix.
 * Author: Rafael Matos
 * Author URI: https://github.com/rafaelmatostj
 * Version: 0.0.0
 * License: GNU General Public License v3.0*
 *
 */
defined('ABSPATH') or exit;

define('WC_PIX_VERSION', '1.3.2');
define('WC_PIX_PLUGIN_FILE', __FILE__);
define('WC_PIX_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WC_PIX_PLUGIN_PATH', plugin_dir_path(__FILE__));

if (!class_exists('WC_Pix')) {
	include_once dirname(__FILE__) . '/includes/class-wc-pix.php';
	add_action('plugins_loaded', array('WC_Pix', 'init'));
}



