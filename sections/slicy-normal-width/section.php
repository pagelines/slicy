<?php
/*
	Section: Slicy Slider
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	Demo: http://slicy.ahansson.com
	Description: Slicy Slider is a fully responsive slider that supports up to 30 slides with your images.
	Class Name: SlicySliderNormalWidth
	Workswith: templates
	Cloning: true
	V3: true
	Filter: slider
*/

class SlicySliderNormalWidth extends PageLinesSection {

	function section_styles() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'jquery-slicebox-modernizer-custom', $this->base_url.'/js/modernizr.custom.slicy.js' );

		wp_enqueue_script( 'jquery-slicebox', $this->base_url.'/js/jquery.slicebox.js' );

	}

	function section_head( ) {

		$clone_id = $this->get_the_id();

		$prefix = ( $clone_id != '' ) ? 'clone_'.$clone_id : '';

		$orientation = ( $this->opt( 'slicy_slider_orientation'  ) ) ? $this->opt( 'slicy_slider_orientation'  ) : 'r';

		$speed = ( $this->opt( 'slicy_slider_speed'  ) ) ? $this->opt( 'slicy_slider_speed'  ) : '600';

		$between = ( $this->opt( 'slicy_slider_between'  ) ) ? $this->opt( 'slicy_slider_between'  ) : '3000';

		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){

					jQuery("#slicySlider<?php echo $prefix; ?> .slicy-img-holder").hover(function(){
						jQuery("#slicySlider<?php echo $prefix; ?> .sb-description").fadeIn("slow");
						jQuery("#slicySlider<?php echo $prefix; ?> .sb-description").show();

					},
					function(){
						jQuery("#slicySlider<?php echo $prefix; ?> .sb-description").fadeOut();
					});

					var Page = (function() {

						var navArrows = jQuery( '#nav-arrows<?php echo $prefix; ?>' ).hide(),
							slicebox = jQuery( '#slicySlider<?php echo $prefix; ?>' ).slicebox( {
								onReady : function() {

									navArrows.show();

								},
								orientation : '<?php echo $orientation; ?>',
								cuboidsRandom : true,
								<?php if ($this->opt('slicy_slider_autoplay' )==true) {
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
								navArrows.children( ':first' ).on( 'click', function() {

									slicebox.next();
									return false;

								} );

								navArrows.children( ':last' ).on( 'click', function() {

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

		//slicy_slider_slides

		// The boxes
		$slicy_array = $this->opt('slicy_array');

		$format_upgrade_mapping = array(
			'image'	=> 'slicy_slider_image_%s',
			'alt'	=> 'slicy_slider_alt_%s',
			'link'	=> 'slicy_slider_link_%s',
			'text'	=> 'slicy_slider_text_%s'
		);

		$slicy_array = $this->upgrade_to_array_format( 'slicy_array', $slicy_array, $format_upgrade_mapping, $this->opt('slicy_slider_slides'));

		// must come after upgrade
		if( !$slicy_array || $slicy_array == 'false' || !is_array($slicy_array) ){
			$slicy_array = array( array(), array(), array(), array() );
		}


		?>
			<div class="container">
				<ul id="slicySlider<?php echo $prefix; ?>" class="sb-slider">
					<?php

						$output = '';

						if( is_array($slicy_array) ){

							$slides = count( $slicy_array );

							foreach( $slicy_array as $slide ){

								if ( pl_array_get( 'image', $slide ) ) {

									$the_text = pl_array_get( 'text', $slide );

									$img_alt = pl_array_get( 'alt', $slide );

									$text = ( $the_text ) ? sprintf( '<div class="sb-description%s sb-description"><h3>%s</h3></div>', $prefix, $the_text ) : '';

									$img = ( pl_array_get( 'image', $slide ) ) ? sprintf( '<img src="%s" alt="%s" />%s', pl_array_get( 'image', $slide ), $img_alt, $text ): '';

									$link = ( pl_array_get( 'link', $slide ) ) ? sprintf( '<a href="%s">%s</a>',pl_array_get( 'link', $slide ), $img ): '';

									if ($link) {
										$content = $link;
									} else {
										$content = $img;
									}

									if ($content) {
										$output .= sprintf( '<li><div class="slicy-img-holder">%s</div></li>', $content );
									} else {
										$output .='';
									}
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

	function section_opts(){

		$options = array();

		$how_to_use = __( '
		<strong>Read the instructions below before asking for additional help:</strong>
		</br></br>
		<strong>1.</strong> In the frontend editor, drag the Slicy section to a template of your choice.
		</br></br>
		<strong>2.</strong> Edit settings for Slicy slides.
		</br></br>
		<strong>3.</strong> When you are done, hit "Publish" to see changes.
		</br></br>
		<strong>For best results all images in the slider should have the same dimensions.</strong>
		</br></br>
		<div class="row zmb">
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://forum.pagelines.com/71-products-by-aleksander-hansson/" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-ambulance"></i>          Forum</a>
				</div>
				<div class="span6 tac zmb">
					<a class="btn btn-info" href="http://betterdms.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-align-justify"></i>          Better DMS</a>
				</div>
			</div>
			<div class="row zmb" style="margin-top:4px;">
				<div class="span12 tac zmb">
					<a class="btn btn-success" href="http://shop.ahansson.com" target="_blank" style="padding:4px 0 4px;width:100%"><i class="icon-shopping-cart" ></i>          My Shop</a>
				</div>
			</div>
		', 'slicy' );

		$options[] = array(
			'key' => 'slicy_help',
			'type'     => 'template',
			'template'      => do_shortcode( $how_to_use ),
			'title' =>__( 'How to use:', 'slicy' ) ,
		);

		$options[] = array(
			'key'		=> 'slicy_settings',
	    	'type'		=> 'multi',
			'title'		=> __('Flowy Setup', 'slicy'),
			'opts'	=> array(

				array(
					'key' => 'slicy_slider_autoplay',
					'default'       => false,
					'type'           => 'select',
					'opts'     => array(
						true => array( 'name' => __( 'Yes'   , 'slicy' )),
						false => array( 'name' => __( 'No'   , 'slicy' ))
					),
					'label'  =>  __('Autoplay Slicy? (Default is "No")', 'slicy'),
				),

				array(
					'key' => 'slicy_slider_speed',
					'label' => __( 'Animation Speed (Default is "600")', 'slicy' ),
					'type'   => 'text'
				),

				array(
					'key' => 'slicy_slider_between',
					'label' => __( 'Time Between Rotation (Default is "3000")', 'slicy' ),
					'type'   => 'text'
				),

				array(
					'key' => 'slicy_slider_orientation',
					'default'       => 'r',
					'type'           => 'select',
					'selectvalues'     => array(
						'r' => array( 'name' => __( 'Random'   , 'slicy' )),
						'v' => array( 'name' => __( 'Vertical'   , 'slicy' )),
						'h' => array( 'name' => __( 'Horizontal'   , 'slicy' ))
					),
					'label'  =>  __('Animation style? (Default is "Random")', 'slicy'),
					'default' => 'r',
				),
			)
		);

		$options[] = array(
			'key'		=> 'slicy_array',
	    	'type'		=> 'accordion',
			'title'		=> __('Slicy Setup', 'slicy'),
			'post_type'	=> __('Slicy Slide', 'slicy'),
			'opts'	=> array(
				array(
					'key' => 'image',
					'label'  => __( 'Slide Image', 'slicy' ),
					'type'   => 'image_upload'
				),
				array(
					'key' => 'alt',
					'label' => __( 'Image ALT tag', 'slicy' ),
					'type'   => 'text'
				),
				array(
					'key' => 'link',
					'label' => __( 'Slide Image Link', 'slicy' ),
					'type'   => 'text'
				),
				array(
					'key' => 'text',
					'label' => __( 'Slide Image Text', 'slicy' ),
					'type'   => 'text'
				)
			)
		);

		return $options;

	}

}
