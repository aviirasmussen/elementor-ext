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

/**
 *
 * @since 1.0.1
 */

final class ElementorExt {
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
    
	private static $instance = null;
        
	public function __construct() {
		// Init plugin
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
        add_filter('attachment_fields_to_edit', [ $this, 'youtube_checkbox_to_edit'], 10, 2); 
        add_filter('attachment_fields_to_save', [ $this, 'youtube_checkbox_to_save'], 10, 2);
        add_filter('attachment_fields_to_edit', [ $this, 'youtube_url_to_edit'], 10, 2); 
        add_filter('attachment_fields_to_save', [ $this, 'youtube_url_to_save'], 10, 2);
	}

	/**
	 * @access public
	 */
	public function i18n() {load_plugin_textdomain( EEP_TEXT_DOMAIN );}
	/**
	 * Ensures one static instance of this class
	 */
	public static function instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
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
        // init widgets and controls in callbacks
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );        
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
    public function init_widgets() {
        require_once 'widgets/eep-media-gallery.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \EEPWidgets\EEPMediaGallery() );
    }
    public function init_controls() {
		require_once 'controls/media-gallery.php';
        $controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'media-gallery', new \EEPControls\MediaGallery() ); 
    }
    // Extend media gallery
    // Add custom text/textarea attachment field
    public function youtube_url_to_edit( $form_fields, $post ) {
        $text_field = get_post_meta($post->ID, 'text_field', true);
        $form_fields['text_field'] = array(
            'label' => 'Link/URL:',
            'input' => 'text', // you may alos use 'textarea' field
            'value' => $text_field,
            'show_in_edit' => true,
            'show_in_modal' => true,
            'helps' => 'Insert a valid youtube link/url'
        );
        return $form_fields;
    }
 
// Save custom text/textarea attachment field
    public function youtube_url_to_save($post, $attachment) {  
    if( isset($attachment['text_field']) ){  
        update_post_meta($post['ID'], 'text_field', sanitize_text_field( $attachment['text_field'] ) );  
    }else{
         delete_post_meta($post['ID'], 'text_field' );
    }
    return $post;  
}
 
 
// Add custom checkbox attachment field
public function youtube_checkbox_to_edit( $form_fields, $post ) {
    $checkbox_field = (bool) get_post_meta($post->ID, 'checkbox_field', true);
    $form_fields['checkbox_field'] = array(
        'label' => 'Use YouTube',
        'input' => 'html',
        'html' => '<input type="checkbox" id="attachments-'.$post->ID.'-checkbox_field" name="attachments['.$post->ID.'][checkbox_field]" value="1"'.($checkbox_field ? ' checked="checked"' : '').' /> ',
        'value' => $checkbox_field,
        'helps' => ''
    );
    return $form_fields;
}
 
// Save custom checkbox attachment field
function youtube_checkbox_to_save($post, $attachment) {  
    if( isset($attachment['checkbox_field']) ){  
        update_post_meta($post['ID'], 'checkbox_field', sanitize_text_field( $attachment['checkbox_field'] ) );  
    }else{
         delete_post_meta($post['ID'], 'checkbox_field' );
    }
    return $post;  
}    
}
Elementorext::instance();
