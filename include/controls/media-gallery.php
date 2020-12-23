<?php
namespace EEPControls;


use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {exit;}

/**
 *\Elementor\Control_Media
 */
class MediaGallery extends \Elementor\Control_Media {

	/**
	 * Get media gallery control type.
	 *
	 * Retrieve the control type, in this case `media-gallery`.
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		//return 'media-gallery';
        return 'media-gallery';
	}
	// add css and javascript files to control
	public function enqueue() {
        debug_log('enqueue control style and JS');
        wp_enqueue_media();        
        wp_register_script( 'eep-control-media-gallery',plugins_url( '/js/ctrl-media-gallery.js', ELEMENTOR_EXTENSION ), array('jquery'), EEP_VERSION, true ); // jquery here, or use jQuery in ctrl..js
	    wp_enqueue_script( 'eep-control-media-gallery' );//
    }
    	/**
	 * Render control output in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		?>
        <style>
        .eep-border{
            border-style: dashed;
            border-width: thin;
            border-color: white;
            
        }
        .eep-control-media-content {
            position: relative;
            overflow: hidden;
            border: 1px solid #64666a;
            border-radius: 3px;
            background-color: #404349;
            transition: all .2s ease-in-out;
        }
        .eep-control-media-content:not(:hover) .eep-control-gallery-edit {
            opacity: 0;
        }
        .eep-control-gallery-edit {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(109, 120, 130, 0.3);
            padding: 10px;
            font-size: 11px;
            -webkit-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
            pointer-events: none;
            cursor: pointer;
            opacity: 1;
        }
        .eep-control-gallery-edit span {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 21px;
            height: 21px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #a4afb7;
            -webkit-box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.2);
            box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 3px;
            border-radius: 3px;
        }
        .eep-control-gallery-edit span i {
            font-size: 11px;
            padding: 5px;
        }

        .eep-control-gallery-add {
            width: 48px;
            height: 48px;
            color: #fff;
            background-color: #d5dadf;
            font-size: 14px;
            -webkit-border-radius: 0;
            border-radius: 0;
        }
        .eep-control-gallery-add:hover {
            background-color: #c2cbd2;
        }
        .eep-control-gallery-add i {
            margin: 0;
            color: #a4afb7;
        }

        .eep-control-gallery-all-thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(48px,1fr));
            grid-gap: 10px;
            cursor: pointer;
            padding: 10px;
        }
        .eep-gallery-empty .eep-control-gallery-clear,
        .eep-gallery-empty .eep-control-gallery-all-thumbnails,
        .eep-gallery-empty .eep-control-gallery-edit {
            display: none;
        }
        .eep-gallery-has-images .eep-control-gallery-add {
            display: none;
        }
        
        .eep-control-gallery-status{
            font-size: 12px;
            padding: 10px;
            border-bottom: 1px solid #64666a;
            display: flex;
        }
        .eep-control-gallery-status-title{
            flex-grow: 1;
        }
        .eep-control-gallery-thumbnail {
            width: 48px;
            height: 48px;
            -webkit-background-size: cover;
            background-size: cover;
            background-position: 50% 50%;
        }
        .eep-control-gallery-content {
            position: relative;
            overflow: hidden;
            padding: 10px;
            //background-color: #2C2C2C;
        }
        .eep-control-gallery-thumbnail i {
            top: 50%;
            left: 50%;
            position: absolute;
            margin-left: -25px;
            margin-top: -30px;
        }
        </style>
		<div class="elementor-control-field">
			<div class="elementor-control-title">{{{ data.label }}}</div>
			<div class="elementor-control-input-wrapper">
				<# if ( data.description ) { #>
				<div class="elementor-control-field-description">{{{ data.description }}}</div>
				<# } #>
				<div class="eep-control-media-content elementor-control-tag-area">
					<div class="eep-control-gallery-status elementor-control-dynamic-switcher-wrapper">
						<span class="eep-control-gallery-status-title"></span>
						<span class="eep-control-gallery-clear"><i class="eicon-trash-o" aria-hidden="true"></i></span>
					</div>
					<div class="eep-control-gallery-content">
						<div class="eep-control-gallery-all-thumbnails"></div>
						<div class="eep-control-gallery-edit"><span><i class="eicon-pencil" aria-hidden="true"></i></span></div>
						<button class="elementor-button eep-control-gallery-add" aria-label="<?php echo __( 'Add Images', 'elementor' ); ?>"><i class="eicon-plus-circle" aria-hidden="true"></i></button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
    	/**
	 * Get default settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'separator' => 'none',
			'dynamic' => [
				'categories' => [ TagsModule::GALLERY_CATEGORY ],
				'returnType' => 'object',
			],
		];
	}
	public function get_default_value() {
		return [];
	}
}
