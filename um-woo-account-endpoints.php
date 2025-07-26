<?php
/**
 * Plugin Name:     Ultimate Member - Woo Account Endpoints
 * Description:     Extension to Ultimate Member for setting of Woo Account Endpoints to UM pages.
 * Version:         1.0.0
 * Requires PHP:    7.4
 * Author:          Miss Veronica
 * License:         GPL v2 or later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:      https://github.com/MissVeronica
 * Plugin URI:      https://github.com/MissVeronica/um-woo-account-endpoints
 * Update URI:      https://github.com/MissVeronica/um-woo-account-endpoints
 * Text Domain:     ultimate-member
 * Domain Path:     /languages
 * UM version:      2.10.5
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'UM' ) ) return;

class UM_WOO_Account_Endpoints {


    function __construct( ) {

        define( 'Plugin_Basename__WAE', plugin_basename( __FILE__ ));

        add_filter( 'woocommerce_get_endpoint_url', array( $this, 'um_woocommerce_account_endpoints' ), 10, 2 );
        add_filter( 'plugin_action_links_' . Plugin_Basename__WAE, array( $this, 'plugin_settings_link' ), 10, 1 ); 

    }

    function plugin_settings_link( $links ) {

        if ( defined( 'WC_PLUGIN_FILE' )) {
            $url = get_admin_url() . 'admin.php?page=wc-settings&tab=advanced&section';
            $links[] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings' ) . '</a>';
        }

        return $links;
    }

    function um_woocommerce_account_endpoints( $url, $endpoint ) {

        if ( substr( $endpoint, 0, 3 ) == 'um-' ) {

            switch( $endpoint ) {

                case 'um-account':      $url = um_get_core_page( 'account' ); break;
                case 'um-profile':      $url = um_get_core_page( 'user' ); break;
                case 'um-profile-edit': $url = um_get_core_page( 'user' ) . '?um_action=edit'; break;
                case 'um-password':     $url = um_get_core_page( 'password-reset' ); break;
                case 'um-logout':       $url = um_get_core_page( 'logout' ); break;
                case 'um-login':        $url = um_get_core_page( 'login' ); break;

                default:                break;
            }
        }

        return $url;
    }

}


new UM_WOO_Account_Endpoints();

