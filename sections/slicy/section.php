<?php
/*
	Section: Slicy Slider
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://slicy.ahansson.com
	Description: Slicy Slider is a fully responsive slider that supports up to 30 slides with your images.
	Class Name: SlicySlider
	Workswith: templates
	Cloning: true
	V3: true
	Filter: full-width, slider
*/

class SlicySlider extends PageLinesSection {

	var $default_limit = 2;

	function section_styles() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'jquery-slicebox-modernizer-custom', $this->base_url.'/js/modernizr.custom.slicy.js' );

		wp_enqueue_script( 'jquery-slicebox', $this->base_url.'/js/jquery.slicebox.js' );

	}

	function section_head( ) {

		$clone_id = $this->get_the_id();

		$prefix = ( $clone_id != '' ) ? 'clone_'.$clone_id : '';

		$orientation = ( $this->opt( 'slicy_slider_orientation', $this->oset ) ) ? $this->opt( 'slicy_slider_orientation', $this->oset ) : 'r';

		$speed = ( $this->opt( 'slicy_slider_speed', $this->oset ) ) ? $this->opt( 'slicy_slider_speed', $this->oset ) : '600';

		$between = ( $this->opt( 'slicy_slider_between', $this->oset ) ) ? $this->opt( 'slicy_slider_between', $this->oset ) : '3000';

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){

					$("#slicySlider<?php echo $prefix; ?> .slicy-img-holder").hover(function(){
						$("#slicySlider<?php echo $prefix; ?> .sb-description").fadeIn("slow");
						$("#slicySlider<?php echo $prefix; ?> .sb-description").show();

					},
					function(){
						$("#slicySlider<?php echo $prefix; ?> .sb-description").fadeOut();
					});

					var Page = (function() {

						var $navArrows = $( '#nav-arrows<?php echo $prefix; ?>' ).hide(),
							slicebox = $( '#slicySlider<?php echo $prefix; ?>' ).slicebox( {
								onReady : function() {

									$navArrows.show();

								},
								orientation : '<?php echo $orientation; ?>',
								cuboidsRandom : true,
								<?php if ($this->opt('slicy_slider_autoplay', $this->oset)==true) {
									echo 'autoplay : true,';
								} ?>
								interval: '<?php echo $between; ?>',
								disperseFactor : 30
							} ),

							init = function() {

								initEvents();

							},
							initEvents = function() {

								// add navigation events
								$navArrows.children( ':first' ).on( 'click', function() {

									slicebox.next();
									return false;

								} );

								$navArrows.children( ':last' ).on( 'click', function() {

									slicebox.previous();
									return false;

								} );

							};

							return { init : init };

					})();

					Page.init();

				});
			</script>
		<?php

	}

	function section_template() {

		$clone_id = $this->get_the_id();

		$prefix = ( $clone_id != '' ) ? 'clone_'.$clone_id : '';

		?>
			<div class="container">
				<ul id="slicySlider<?php echo $prefix; ?>" class="sb-slider">
					<?php

						$slides = ( $this->opt( 'slicy_slider_slides', $this->oset ) ) ? $this->opt( 'slicy_slider_slides', $this->oset ) : $this->default_limit;

						$output = '';
						for ( $i = 1; $i <= $slides; $i++ ) {

							if ( $this->opt( 'slicy_slider_image_'.$i, $this->oset ) || $this->opt( 'slicy_slider_content_'.$i, $this->oset ) ) {

								$the_text = $this->opt( 'slicy_slider_text_'.$i, $this->tset );

								$img_alt = $this->opt( 'slicy_slider_alt_'.$i, $this->tset );

								$text = ( $the_text ) ? sprintf( '<div data-sync="slicy_slider_text_%s" class="sb-description%s sb-description"><h3>%s</h3></div>', $i, $prefix, $the_text ) : '';

								if ( $this->opt( 'slicy_slider_image_'.$i, $this->oset ) ) {
									$img = sprintf( '<img data-sync="slicy_slider_image_%s" src="%s" alt="%s" />%s', $i, $this->opt( 'slicy_slider_image_'.$i, $this->oset ), $img_alt, $text );
								} else {
									$img = '';
								}

								if ( $this->opt( 'slicy_slider_link_'.$i, $this->tset ) ) {
									$link = sprintf( '<a href="%s"><img data-sync="slicy_slider_image_%s" src="%s" alt="%s" /></a>%s', $this->opt( 'slicy_slider_link_'.$i, $i, $this->tset ), $this->opt( 'slicy_slider_image_'.$i, $this->tset ), $img_alt, $text );
								} else {
									$link = '';
								}

								if ($link) {
									$content = $link;
								} elseif ($img) {
									$content = $img;
								} else {
									$content = '';
								}

								if ($content) {
									$output .= sprintf( '<li><div class="slicy-img-holder">%s</div></li>', $content );
								} else {
									$output .='';
								}
							}
						}

						if ( $output == '' ) {
							$this->do_defaults();
						} else {
							echo $output;
						}

					?>
				</ul>

				<div id="nav-arrows<?php echo $prefix; ?>" class="nav-arrows">
					<a href="#">Next</a>
					<a href="#">Previous</a>
				</div>
			</div>

		<?php

	}

	function do_defaults() {

		printf( '<li><div class="slicy-img-holder"><img alt="%s" src="%s"/><div class="sb-description"><h3>%s</h3></div></div></li>',
			'Slide One',
			$this->base_url.'/img/1.png',
			'Image One'
		);
		printf( '<li><div class="slicy-img-holder"><img alt="%s" src="%s"/><div class="sb-description"><h3>%s</h3></div></div></li>',
			'Slide Two',
			$this->base_url.'/img/2.png',
			'Image Two'
		);
		printf( '<li><div class="slicy-img-holder"><img alt="%s" src="%s"/><div class="sb-description"><h3>%s</h3></div></div></li>',
			'Slide Three',
			$this->base_url.'/img/3.png',
			'Image Three'
		);
		printf( '<li><div class="slicy-img-holder"><img alt="%s" src="%s"/><div class="sb-description"><h3>%s</h3></div></div></li>',
			'Slide Four',
			$this->base_url.'/img/4.png',
			'Image Four'
		);

	}

	function section_optionator( $settings ) {
		$settings = wp_parse_args( $settings, $this->optionator_default );

		$array = array();

		$array['slicy_slider_settings'] = array(
			'type'    => 'multi_option',
			'title'   => __( 'Settings', 'SlicySlider' ),
			'selectvalues' => array(

				'slicy_slider_slides' => array(
					'type'    => 'count_select',
					'count_start' => 2,
					'count_number'  => 30,
					'default'  => '2',
					'inputlabel'  => __( 'Number of Images to Configure', 'SlicySlider' ),
					'title'   => __( 'Number of images', 'SlicySlider' ),
					'exp'    => __( "This number will be used to generate slides and option setup. For best results, please use images with the same dimensions!", 'SlicySlider' ),
				),

				'slicy_slider_autoplay'  => array(
					'default'       => false,
					'type'           => 'select',
					'selectvalues'     => array(
						true => array( 'name' => __( 'Yes'   , 'SlicySlider' )),
						false => array( 'name' => __( 'No'   , 'SlicySlider' ))
					),
					'inputlabel'  =>  __('Autoplay Slicy? (Default is "No")', 'SlicySlider'),
				),

				'slicy_slider_speed'  => array(
					'inputlabel' => __( 'Animation Speed (Default is "600")', 'SlicySlider' ),
					'type'   => 'text'
				),

				'slicy_slider_between'  => array(
					'inputlabel' => __( 'Time Between Rotation (Default is "3000")', 'SlicySlider' ),
					'type'   => 'text'
				),

				'slicy_slider_orientation'  => array(
					'default'       => 'r',
					'type'           => 'select',
					'selectvalues'     => array(
						'r' => array( 'name' => __( 'Random'   , 'SlicySlider' )),
						'v' => array( 'name' => __( 'Vertical'   , 'SlicySlider' )),
						'h' => array( 'name' => __( 'Horizontal'   , 'SlicySlider' ))
					),
					'inputlabel'  =>  __('Animation style? (Default is "Random")', 'SlicySlider'),
				),
			),
		);


		global $post_ID;

		$oset = array( 'post_id' => $post_ID, 'clone_id' => $settings['clone_id'], 'type' => $settings['type'] );

		$slides = ( $this->opt( 'slicy_slider_slides', $oset ) ) ? $this->opt( 'slicy_slider_slides', $oset ) : $this->default_limit;

		for ( $i = 1; $i <= $slides; $i++ ) {


			$array['slicy_slider_slide_'.$i] = array(
				'type'    => 'multi_option',
				'selectvalues' => array(

					'slicy_slider_image_'.$i  => array(
						'inputlabel'  => __( 'Slide Image', 'SlicySlider' ),
						'type'   => 'image_upload'
					),
					'slicy_slider_alt_'.$i  => array(
						'inputlabel' => __( 'Image ALT tag', 'SlicySlider' ),
						'type'   => 'text'
					),
					'slicy_slider_link_'.$i  => array(
						'inputlabel' => __( 'Slide Image Link', 'SlicySlider' ),
						'type'   => 'text'
					),
					'slicy_slider_text_'.$i  => array(
						'inputlabel' => __( 'Slide Image Text', 'SlicySlider' ),
						'type'   => 'text'
					)
				),
				'title'   => __( 'Slicy Slide ', 'SlicySlider' ) . $i,
				'shortexp'   => __( 'Setup options for slide number ', 'SlicySlider' ) . $i,
				'exp'   => __( 'For best results all images in the slider should have the same dimensions.', 'SlicySlider' )
			);

		}

		$metatab_settings = array(
			'id'   => 'slicy_slider_options',
			'name'   => __( 'Slicy Slider', 'SlicySlider' ),
			'icon'   => $this->icon,
			'clone_id' => $settings['clone_id'],
			'active' => $settings['active']
		);

		register_metatab( $metatab_settings, $array );

	}

}
