<?php
/**
 * An Elementor Extension Plugin
 *
 * @package ElementorExt
 *
 * Plugin Name: Elementor Extension
 * Description: 
 * Plugin URI:  https://github.com/aviirasmussen/elementor-ext
 * Version:     1.0.0
 * Author:      Avii Rasmussen
 * Author URI:  https://github.com/aviirasmussen
 * Text Domain: elementor-ext
 */

define( 'ELEMENTOR_EXTENSION', __FILE__ );
define( 'EEP_DEBUG', true );
define( 'EEP_DEBUG_FILE', 'debug.log'); // Look for the logfile in the ELEMENTOR_EXTENSION directory
define( 'EEP_DEBUG_MAX_FILE_SIZE', 10000000); // After logfile reach this size in bytes - the logfile gets truncated
define( 'EEP_VERSION', '1.0.0' );

/**
 * Include the Elementor Extension class.
 */
require plugin_dir_path( ELEMENTOR_EXTENSION ) . 'class/ElementorExt.php';
require_once('utility.php');
