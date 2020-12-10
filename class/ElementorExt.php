<?php
/**
 * Elementor Extension Class
 *
 * @package    ElementorExt
 * @author     Avii Rasmussen (arve.rasmussen@iplink.no)
 * @copyright  2020 Avii Rasmussen
 * @license    https://github.com/aviirasmussen/elementor-ext/blob/main/LICENSE
 *
 */

if ( ! defined( 'ABSPATH' ) ) {exit;}

class ElementorExt {
	/**
	 * EEP PHP Version
     * PHP version required to run the plugin.
	 */
	const EEP_PHP_VERSION = '7.3';
	/**
	 * EEP Elementor Version
     * Elementor version required to run the plugin.
	 */
	const EEP_ELEMENTOR_VERSION = '3.0.14 ';
	/**
	 * EEP Bootstrap CSS
     * CSS needed for this plugin to work with modal and carousel
	 */
	const EEP_BOOTSTRAP = 'bootstrap.css';

	public function __construct() {
		// Init plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	public function init() {
		// Check PHP.
		if ( version_compare( PHP_VERSION, self::EEP_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_eep_php_version' ) );
			return false;
		}
		// Check Elementor.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
			return false;
		}
		// Check Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::EEP_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_eep_elementor_version' ) );
			return false;
		}
        // Check CSS when frontend (not wp plugins page) script and styles is enqueued
        add_action( 'wp_enqueue_scripts', function(){
            global $wp_styles;
            foreach( $wp_styles->queue as $style ) :
                $css_src = $wp_styles->registered[$style]->src;
                if (preg_match('/'.$this::EEP_BOOTSTRAP.'$/', $css_src, $matches)) {
                    return true;
                }
            endforeach; // no bootstrap
            wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'); // enqueue here if missing as admin notices is dismissed after activation
            return false;
        });
        // Include widget(s)
		require_once 'WidgetsExt.php';
	}
	/**
	 * Notice an error if it's not the minimum PHP version
	 */
	public function admin_notice_eep_php_version() {
        echo '<div class="notice notice-error is-dismissible"><p>Elementor Extension requires PHP version '.self::EEP_PHP_VERSION.' or higher</p></div>';
		deactivate_plugins( plugin_basename( ELEMENTOR_EXTENSION ) );
        return true;
	}
	/**
     * Notice an error if Elementor plugin not loaded
	 */
	public function admin_notice_missing_elementor() {
        echo '<div class="notice notice-error is-dismissible"><p>Elementor Extension requires Elementor plugin installed and active</p></div>';
		deactivate_plugins( plugin_basename( ELEMENTOR_EXTENSION ) );
        return true;

	}
	/**
	 * Notice an error if it's not the minimum Elementor version.
	 */
	public function admin_notice_eep_elementor_version() {
        echo '<div class="notice notice-error is-dismissible"><p>Elementor Extension requires Elementor plugin version '.self::EEP_ELEMENTOR_VERSION.' or higher</p></div>';
		deactivate_plugins( plugin_basename( ELEMENTOR_EXTENSION ) );
        return true;
	}
	/**
     * Notice a warn if bootstrap is needed to be enqueued with CDN here.
     * TODO: How to admin_notice when $this::init completes before css callback check..? 
	 */
    public function admin_notice_eep_missing_bootstrap(){
        echo '<div class="notice notice-warning is-dismissible"><p>Bootstrap CDN enabled for Elementor Extension plugin</p></div>';
		deactivate_plugins( plugin_basename( ELEMENTOR_EXTENSION ) );
        return true;
    }
    public function register_widgets() {
      \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \ElementorExt() );

    }
}
new ElementorExt();
