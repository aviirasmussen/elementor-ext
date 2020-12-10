<?php
/**
 * WidgetsExt class.
 *
 * @package    ElementorExt
 * @author     Avii Rasmussen (arve.rasmussen@iplink.no)
 * @copyright  2020 Avii Rasmussen
 * @license    https://github.com/aviirasmussen/elementor-ext/blob/main/LICENSE
 *
 */

defined( 'ABSPATH' ) || die();

class WidgetsExt {

	private static $instance = null;
	/**
	 * Ensures one static instance of this class
	 */
	public static function instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Register Widgets
	 */
	public function register_eep_widgets() {
		require_once 'Widgets/EEPGallery.php';
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Widgets\EEPGallery() );
	}
	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_eep_widgets' ) );
	}
}
WidgetsExt::instance();
