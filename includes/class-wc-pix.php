<?php

class WC_Pix {

	
	public static function init() {
		if ( class_exists( 'WC_Payment_Gateway' ) ) {
			self::includes();

			add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'add_gateway' ) );
			add_filter( 'woocommerce_available_payment_gateways', array( __CLASS__, 'hides_when_is_outside_brazil' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( WC_PIX_PLUGIN_FILE ), array( __CLASS__, 'plugin_action_links' ) );
		} else {
			add_action( 'admin_notices', array( __CLASS__, 'woocommerce_missing_notice' ) );
		}
	}


	public static function plugin_action_links( $links ) {
		$plugin_links   = array();
		$plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=checkout&section=pix_gateway' ) ) . '">Configuração</a>';

		return array_merge( $plugin_links, $links );
	}

	/** Includes.*/
	 
	private static function includes() {
		include_once dirname( __FILE__ ) . '/class-wc-pix-gateway.php';
		include_once dirname( __FILE__ ) . '/class-qrcode.php';
		include_once dirname( __FILE__ ) . '/services/class-emv.php';
		include_once dirname( __FILE__ ) . '/services/class-crc16.php';
		include_once dirname( __FILE__ ) . '/helpers/jetpack.php';
	}
	public static function add_gateway( $methods ) {
		$methods[] = 'WC_Pix_Gateway';

		return $methods;
	}
	public static function hides_when_is_outside_brazil( $available_gateways ) {
		if ( isset( $_REQUEST['country'] ) && 'BR' !== $_REQUEST['country'] ) { // WPCS: input var ok, CSRF ok.
			unset( $available_gateways['pix'] );
		}

		return $available_gateways;
	}
	public static function woocommerce_missing_notice() {
		include dirname( __FILE__ ) . '/admin/views/html-notice-missing-woocommerce.php';
	}
}
