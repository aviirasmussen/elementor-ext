<?php
/**
 * EEPGallery class.
 *
 * @package    ElementorExt
 * @author     Avii Rasmussen (arve.rasmussen@iplink.no)
 * @copyright  2020 Avii Rasmussen
 * @license    https://github.com/aviirasmussen/elementor-ext/blob/main/LICENSE
 *
 */

namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class EEPGallery extends Widget_Base {
    const PREFIX_ID       = 'eep-gallery-';
    const DEFAULT_SVG_URL = 'data:image/svg+xml,%3Csvg aria-hidden=\'true\' focusable=\'false\' data-prefix=\'far\' data-icon=\'image\' class=\'svg-inline--fa fa-image fa-w-16\' role=\'img\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 512 512\'%3E%3Cpath fill=\'currentColor\' d=\'M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm-6 336H54a6 6 0 0 1-6-6V118a6 6 0 0 1 6-6h404a6 6 0 0 1 6 6v276a6 6 0 0 1-6 6zM128 152c-22.091 0-40 17.909-40 40s17.909 40 40 40 40-17.909 40-40-17.909-40-40-40zM96 352h320v-80l-87.515-87.515c-4.686-4.686-12.284-4.686-16.971 0L192 304l-39.515-39.515c-4.686-4.686-12.284-4.686-16.971 0L96 304v48z\'%3E%3C/path%3E%3C/svg%3E';
    
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_style( 'eep.gallery', plugins_url( '/css/eep.gallery.css', ELEMENTOR_EXTENSION ), array(), EEP_VERSION );
	}

	/**
	 * Widget name.
	 */
	public function get_name() {
		return 'EEP Gallery';
	}

	/**
	 * Widget title.
	 */
	public function get_title() {
		return __( 'Dropdown Gallery', 'elementor-gallery' );
	}

	/**
	 * Widget icon.
	 */
	public function get_icon() {
		return 'far fa-images';
	}

	public function get_categories() {
		return array( 'general' );
	}
	public function get_style_depends() {
		return array( 'eep.gallery' );
	}
	/**
	 * Register widget Elementor controls.
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'eep-gallery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
		        'eep-gallery-images',
			[
				'label' => __( 'Add Images', 'eep-gallery' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => ['name' => 'EEP Gallery'],
            ]
		);
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
				'max' => 500,
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
  transform: scale(2.0); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
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


// $(document).ready(function(){ });
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
<div class="modal fade" id="image-modal-$eep_gallery_id" tabindex="-1" role="dialog" aria-labelledby="foto carousel " aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content bg-transparent">
      <div class="modal-body">

<div id="foto-controls-$eep_gallery_id" class="carousel slide " data-ride="carousel">
  <div class="carousel-inner">
EOT;
           $active = 'active';
           $idx = 0;
           
           foreach($settings['eep-gallery-images'] as $image) {
               $image_src = (isset($image['url']))? $image['url']: $this::DEFAULT_SVG_URL;
               $idx++;
               $carousel_html .= <<<EOT
    <div class="carousel-item $active">
      <img class="d-block w-100" src="$image_src">
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
       }


       echo $carousel_html;



	   $images = '<div class="row d-flex">';
	   
	   $idx = 0;
	   $rows = 0;
	   $image_idx = 0;
       debug_log($settings['eep-gallery-images']);
	   foreach ( $settings['eep-gallery-images'] as $image ) {
           $image_src = (isset($image['url']))? $image['url']: $this::DEFAULT_SVG_URL;
		   $idx++;
	   	   $images .=  '
		   <div class="'.$col_class.' justify-content-center p-2 " style="display: inline-flex;">
		     <div class="p-0 daa-frame frame '.$use_zoom.'">
		     <span class="helper"></span>
		       <img class="'.$use_shadow.' p-0" style="margin-bottom: 0 !important;width: '.$eep_image_width.'px;" src="' . $image_src . '" onclick="viewModal(\''.$eep_gallery_id.'\', '.$image_idx.')"/>
		     </div>
		   </div>'; // add column value
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
	 * Render in Elementor  editor.
	 */
	protected function _content_template() {
	  echo '<div>Dropdown Gallery</div>';
		?>
		<# _.each( settings.eep-gallery-images, function( image ) { #>
           <!-- img src="{{ image.url }}" -->
		<# }); #>
		<?php
	}
}
?>
