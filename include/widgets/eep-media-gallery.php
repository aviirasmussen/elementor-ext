<?php
/**
 * EEPMediaGallery class.
 *
 * @package    ElementorExt
 * @author     Avii Rasmussen (arve.rasmussen@iplink.no)
 * @copyright  2020 Avii Rasmussen
 * @license    https://github.com/aviirasmussen/elementor-ext/blob/main/LICENSE
 *
 */

namespace EEPWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class EEPMediaGallery extends Widget_Base {
    const PREFIX_ID       = 'eep-media-gallery-';
    const DEFAULT_SVG_URL = 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 576 512\'%3E%3Cpath d=\'M336.2 64H47.8C21.4 64 0 85.4 0 111.8v288.4C0 426.6 21.4 448 47.8 448h288.4c26.4 0 47.8-21.4 47.8-47.8V111.8c0-26.4-21.4-47.8-47.8-47.8zm189.4 37.7L416 177.3v157.4l109.6 75.5c21.2 14.6 50.4-.3 50.4-25.8V127.5c0-25.4-29.1-40.4-50.4-25.8z\'/%3E%3C/svg%3E';
    
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_style( 'eep.media.gallery', plugins_url( '/css/eep.media.gallery.css', ELEMENTOR_EXTENSION ), array(), EEP_VERSION );
        wp_enqueue_script( 'eep.media.gallery' );
	}

	/**
	 * Widget name.
	 */
	public function get_name() {
		return 'eep_media_gallery';
	}

	/**
	 * Widget title.
	 */
	public function get_title() {
		return __( 'Dropdown Media Gallery', 'elementor-media-gallery' );
	}

	/**
	 * Widget icon.
	 */
	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return array( 'media', 'basic' );
	}
	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'video', 'player', 'embed', 'youtube' ];
	}
	public function get_style_depends() {
		return array( 'eep.media.gallery' );
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'eep-gallery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'eep-gallery-media',
			[
				'label' => __( 'Add Images', 'eep-gallery' ),
				'type'	=> 'media-gallery',
			]
		);
        /**
		$this->add_control(
		        'eep-gallery-images',
			[
				'label' => __( 'Add Images', 'eep-gallery' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => ['name' => 'EEP Gallery'],
            ]
		);
        **/
		$this->add_control(
			'eep-gallery-name',
			[
				'label' => __( 'Dropdown Text', 'eep-gallery' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Show More', 'eep-gallery' ),
				'placeholder' => __( 'Type your gallery name here', 'eep-gallery' ),
			]
		);
		$this->add_control(
			'eep-image-width',
			[
				'label' => __( 'Image Width', 'eep-gallery' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 600,
				'step' => 5,
				'default' => 200,
			]
		);
		$this->add_control(
			'eep-grid-columns',
			[
				'label' => __( 'Grid Columns', 'eep-gallery' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'three',
				'options' => [
					'one'  => __( 'One', 'eep-gallery' ),
					'three' => __( 'Three', 'eep-gallery' ),
					'four' => __( 'Four', 'eep-gallery' ),
					'six' => __( 'Six', 'eep-gallery' ),
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'eep-gallery' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
			'eep-gallery-id',
			[
				'label' => __( 'ID', 'eep-gallery' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( $this::PREFIX_ID.uniqid(), 'eep-gallery' ),
				'placeholder' => __( 'Type your gallery ID here', 'eep-gallery' ),
			]
		);
		$this->add_control(
			'show_shadow',
			[
				'label' => __( 'Show Shadow', 'eep-gallery' ),
				'Type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eep-gallery' ),
				'label_off' => __( 'Hide', 'eep-gallery' ),
				'return_value' => true,
				'default' => false,
			]
		);
		$this->add_control(
			'zoom_image',
			[
				'label' => __( 'Zoom image', 'eep-gallery' ),
				'Type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eep-gallery' ),
				'label_off' => __( 'Hide', 'eep-gallery' ),
				'return_value' => true,
				'default' => false,
			]
		);
		$this->add_control(
			'modal_carousel',
			[
				'label' => __( 'Use Image Carousel', 'eep-gallery' ),
				'Type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eep-gallery' ),
				'label_off' => __( 'Hide', 'eep-gallery' ),
				'return_value' => true,
				'default' => false,
			]
		);
		$this->end_controls_section();
	}




    
	/**
	 * Register Elementor_File_Link_Widget widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function x_register_controls() {

		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings', 'file-select-control-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'wp_gallery',
			[
				'label' => __( 'Add Images', 'eep-gallery' ),
				'type'	=> 'media-gallery',
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'separator' => 'none',
			]
		);

		$gallery_columns = range( 1, 10 );
		$gallery_columns = array_combine( $gallery_columns, $gallery_columns );

		$this->add_control(
			'gallery_columns',
			[
				'label' => __( 'Columns', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 4,
				'options' => $gallery_columns,
			]
		);

		$this->add_control(
			'gallery_link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'options' => [
					'file' => __( 'Media File', 'elementor' ),
					'attachment' => __( 'Attachment Page', 'elementor' ),
					'none' => __( 'None', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => __( 'Lightbox', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'yes' => __( 'Yes', 'elementor' ),
					'no' => __( 'No', 'elementor' ),
				],
				'condition' => [
					'gallery_link' => 'file',
				],
			]
		);

		$this->add_control(
			'gallery_rand',
			[
				'label' => __( 'Order By', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'elementor' ),
					'rand' => __( 'Random', 'elementor' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_gallery_images',
			[
				'label' => __( 'Images', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'elementor' ),
					'custom' => __( 'Custom', 'elementor' ),
				],
				'prefix_class' => 'gallery-spacing-',
				'default' => '',
			]
		);

		$columns_margin = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
		$columns_padding = is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => __( 'Image Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'show_label' => false,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item' => 'padding:' . $columns_padding,
					'{{WRAPPER}} .gallery' => 'margin: ' . $columns_margin,
				],
				'condition' => [
					'image_spacing' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .gallery-item img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_caption',
			[
				'label' => __( 'Caption', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'gallery_display_caption',
			[
				'label' => __( 'Display', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Show', 'elementor' ),
					'none' => __( 'Hide', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'color: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .gallery-item .gallery-caption',
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);

		$this->end_controls_section();

	}
	protected function render() {
	   $settings         = $this->get_settings_for_display();
	   $eep_gallery_id   = $settings['eep-gallery-id'];
	   $eep_gallery_name = $settings['eep-gallery-name'];
	   $eep_image_width  = $settings['eep-image-width'];
       //
	   $use_shadow   = null;
	   $use_zoom     = false;
	   $use_carousel = false;
	   $col_class    = 'col-sm-4';
	   $columns      = 3;
	   $show_rows    = 2;
       // Set columns
       $type = $settings['eep-grid-columns'];
       if(strcmp($type, 'one') == 0){ // match  
           $col_class = 'col-sm-12';
	   	   $columns   = 1;
       }else if(strcmp($type, 'three') == 0){ // match  
           $col_class = 'col-sm-4';
	   	   $columns = 3;
       }else if(strcmp($type, 'four') == 0){ // match  
           $col_class = 'col-sm-3';
	   	   $columns = 4;
       }else if(strcmp($type, 'six') == 0){ // match  
           $col_class = 'col-sm-2';
		   $columns = 6;
       }
	   // Gallery settings
 	   if(isset($settings['show_shadow'])){
	     $use_shadow = ($settings['show_shadow'] == 'true')? 'shadow p-0 mb-5 bg-white rounded' : 'shadow-none';
	   }
 	   if(isset($settings['zoom_image'])){
	     $use_zoom = ($settings['zoom_image'] == 'true')? 'eep-zoom' : '';
	   }
 	   if(isset($settings['modal_carousel'])){
	      $use_carousel = ($settings['modal_carousel'] == 'true')? true: false;
	   }

       echo <<<EOT
<style>
.collapsing {
    transition: all 0.3s;    
    transform-origin: top center;
    transform: scale(1,0);
}




.frame {
  white-space: nowrap;
}

.helper {
 display: inline-block;
 height: 100%;
 vertical-align: middle;
}
.eep-zoom {
  transition: transform .2s; /* Animation */
}
.eep-zoom:hover {
  transform: scale(1.1); /* (110% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
  z-index: 1000;
  cursor: pointer;
}
.modal-backdrop, 
.modal-backdrop.fade.in{
  opacity:0.9 !important;
}
.carousel-control-prev-icon, 
.carousel-control-next-icon {
    width: 40px;
    height: 40px;
}
.carousel-control-next {
    right: -15%;
}
.carousel-control-prev {
    left: -15%;
}
</style>
<script>

//var $ = jQuery.noConflict();

//$(document).ready(function(){});


//});

//   $('#modal-view').click(function() {  });

function viewModal(id_postfix, index){
  var $        = jQuery.noConflict();
  var modal_id = '#image-modal-'+id_postfix;
  var caro_id  = '#foto-controls-'+id_postfix;
  $(caro_id).carousel(index);
  $(modal_id).modal("show");   
}


</script>
EOT;

       
       $carousel_html = '';
       if($use_carousel){
           $carousel_html = <<<EOT
<script>
 jQuery(document).bind('keyup', function(e) {
   var $ = jQuery.noConflict();
   if(e.target.id.startsWith('image-modal-eep-gallery')){
     if (e.keyCode==39) {
       $("a.carousel-control-next").trigger("click");
     }   
     if(e.keyCode==37){
       $("a.carousel-control-prev").trigger("click");
     }
   }
});
</script>
<style>
.carousel {
  position: relative;
}

.carousel.pointer-event {
  touch-action: pan-y;
}

.carousel-inner {
  position: relative;
  width: 100%;
  overflow: hidden;
  @include clearfix();
}

.carousel-item {
  position: relative;
  display: none;
  float: left;
  width: 100%;
  margin-right: -100%;
  backface-visibility: hidden;
}

.carousel-item.active,
.carousel-item-next,
.carousel-item-prev {
  display: remove-position-top;
}
</style>
<div class="modal fade" id="image-modal-$eep_gallery_id" tabindex="-1" role="dialog" aria-labelledby="foto carousel " aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content bg-transparent">
      <div class="modal-body">

<div id="foto-controls-$eep_gallery_id" class="carousel slide " data-ride="carousel">
  <div class="carousel-inner">
EOT;
           $active = 'active';
           $idx = 0;
           
           foreach($settings['eep-gallery-media'] as $image) {
               $image_src = (isset($image['url']))? $image['url']: $this::DEFAULT_SVG_URL;
               $idx++;
               $carousel_html .= <<<EOT
    <div class="carousel-item $active">
      <img src="$image_src">
    </div>
EOT;
               if($active){$active = null;}
           }

           
           $carousel_html .= <<<EOT
  </div>
  <a class="carousel-control-prev" href="#foto-controls-$eep_gallery_id" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#foto-controls-$eep_gallery_id" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
      </div>
    </div>
  </div>
</div>
EOT;







           $xcarousel_html = <<<EOT
<script>
 jQuery(document).bind('keyup', function(e) {
   var $ = jQuery.noConflict();
   if(e.target.id.startsWith('image-modal-eep-gallery')){
     if (e.keyCode==39) {
       $("a.carousel-control-next").trigger("click");
     }   
     if(e.keyCode==37){
       $("a.carousel-control-prev").trigger("click");
     }
   }
});
</script>
<style>
.carousel {
  position: relative;
}

.carousel.pointer-event {
  touch-action: pan-y;
}

.carousel-inner {
  position: relative;
  width: 100%;
  overflow: hidden;
  @include clearfix();
}

.carousel-item {
  position: relative;
  display: none;
  float: left;
  width: 100%;
  margin-right: -100%;
  backface-visibility: hidden;
}

.carousel-item.active,
.carousel-item-next,
.carousel-item-prev {
  display: yalla;
}
</style>
<div class="modal fade" id="image-modal-$eep_gallery_id" tabindex="-1" role="dialog" aria-labelledby="foto carousel " aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content bg-transparent">
      <div class="modal-body">




<div id="foto-controls-$eep_gallery_id" class="carousel slide" data-ride="carousel">
 <div class="carousel-inner daa-border" style="background-color: white;">
    <div class="carousel-item active">
     <div class="row">
      <div class="col-sm-12">
       <img class="" src="https://staging.darkartsalliance.no/wp-content/uploads/2020/12/Karina-Askeland-Tanaia-Kim-Tanaia-2014-4-scaled.jpg">
      </div>
     </div>
    </div>
    <div class="carousel-item">
     <div class="row">
      <div class="col-sm-12">
       <img class="" src="https://staging.darkartsalliance.no/wp-content/uploads/2020/12/KvO01-scaled.jpg">
      </div>
     </div>
    </div>
 </div>
 <a class="carousel-control-prev" href="#foto-controls-$eep_gallery_id" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
 <a class="carousel-control-next" href="#foto-controls-$eep_gallery_id" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

      </div>
    </div>
  </div>
</div>
EOT;





















       }


       echo $carousel_html;



	   $images = '<div class="row d-flex">';
	   
	   $idx = 0;
	   $rows = 0;
	   $image_idx = 0;
       debug_log($settings['eep-gallery-media']);
	   foreach ( $settings['eep-gallery-media'] as $image ) {
           $image_src = (isset($image['url']))? $image['url']: $this::DEFAULT_SVG_URL;
           
		   $idx++;
           debug_log('IMAGE');
           debug_log($image);

           if(isset($image['youtube_url'])){
               $images .=  '
		   <div class="'.$col_class.' justify-content-center p-2 " style="display: inline-flex;">
		     <div class="p-0 daa-frame frame '.$use_zoom.'" style="min-width: 560px;">
		     <span class="helper"></span>
<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$image['youtube_id'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>		     </div>
		   </div>'; // add column value
           }else{
           
	   	   $images .=  '
		   <div class="'.$col_class.' justify-content-center p-2 " style="display: inline-flex;">
		     <div class="p-0 daa-frame frame '.$use_zoom.'">
		     <span class="helper"></span>
		       <img class="'.$use_shadow.' p-0" style="margin-bottom: 0 !important;width: '.$eep_image_width.'px;" src="' . $image_src . '" onclick="viewModal(\''.$eep_gallery_id.'\', '.$image_idx.')"/>
		     </div>
		   </div>'; // add column value

           }

           
           $image_idx++;
		   if($idx == $columns){
		      $rows++;
		      $images .= '</div>'; // end row
		      if($rows == 2){ // start collapse
		         $images .= '<div class="collapse" id="dd_'.$eep_gallery_id.'">';
		      }
		      $images .= '<div class="row d-flex">'; // start new row
		      $idx = 0;
		   }
		   

	   }

	   // fille empty rest column values
       for($i = $idx; $i < $columns; $i++){
	      $images .= '<div class="col-sm-4 ">&nbsp;</div>';
	   }
	   $images .= '</div>'; // end last row

	   if($rows >= 2){
	     $images .= '</div>'; // end collaps
	   }

	   echo <<<EOT
<div class="container text-center p-0">
$images
<div class="container-fluid" style="width: 100vw;position: relative;left: calc(-50vw + 50%);">
 <div class="row justify-content-center daa-dropdown">
  <button class="btn shadow-none daa-dropdown" type="button" data-toggle="collapse" data-target="#dd_$eep_gallery_id" aria-expanded="false" aria-controls="dd_$eep_gallery_id">$eep_gallery_name</button>
 </div>
</div>
</div>
EOT;
	}








    
	/**
	 * Render image gallery widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function xrender() {
		$settings = $this->get_settings_for_display();
        
		if ( ! $settings['wp_gallery'] ) {
			return;
		}

		$ids = wp_list_pluck( $settings['wp_gallery'], 'id' );

		$this->add_render_attribute( 'shortcode', 'ids', implode( ',', $ids ) );
		$this->add_render_attribute( 'shortcode', 'size', $settings['thumbnail_size'] );

		if ( $settings['gallery_columns'] ) {
			$this->add_render_attribute( 'shortcode', 'columns', $settings['gallery_columns'] );
		}

		if ( $settings['gallery_link'] ) {
			$this->add_render_attribute( 'shortcode', 'link', $settings['gallery_link'] );
		}

		if ( ! empty( $settings['gallery_rand'] ) ) {
			$this->add_render_attribute( 'shortcode', 'orderby', $settings['gallery_rand'] );
		}
		?>
		<div class="eep-image-gallery">
			<?php
			add_filter( 'wp_get_attachment_link', [ $this, 'add_lightbox_data_to_image_link' ], 10, 2 );

			echo do_shortcode( '[gallery ' . $this->get_render_attribute_string( 'shortcode' ) . ']' );

			remove_filter( 'wp_get_attachment_link', [ $this, 'add_lightbox_data_to_image_link' ] );
			?>
		</div>
		<?php
	}
}
