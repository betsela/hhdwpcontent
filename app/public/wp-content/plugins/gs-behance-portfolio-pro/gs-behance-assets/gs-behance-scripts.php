<?php

// -- Include js files
if ( ! function_exists('gs_enqueue_dribbble_scripts') ) {
	function gs_enqueue_dribbble_scripts() {
		if (!is_admin()) {

			//chick if jquery easing is already registred or not
			if( !wp_script_is('gsbeh-mfp-js', 'registered') ) {
			wp_register_script('gsbeh-mfp-js', GSBEH_FILES_URI . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), GSBEH_VERSION, true);
			}
			// chick if jquery easing is already enqueued or not
			if(!wp_script_is('gsbeh-mfp-js', 'enqueued' )) {
				wp_enqueue_script('gsbeh-mfp-js');
			}

			wp_register_script('gsbeh-owl-caro-js', GSBEH_FILES_URI . '/assets/js/owl.carousel.min.js', array('jquery'), GSBEH_VERSION, true);
			wp_enqueue_script('gsbeh-owl-caro-js');

			wp_register_script('isotope-js', GSBEH_FILES_URI . '/assets/js/isotope.pkgd.min.js', array('jquery'), GSBEH_VERSION, true);
			wp_enqueue_script('isotope-js');
		}	
	}
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_dribbble_scripts' ); 
}

// -- Include css files
if ( ! function_exists('gs_enqueue_behance_styles') ) {
	function gs_enqueue_behance_styles() {
		if (!is_admin()) {
			$media = 'all';

			if(!wp_style_is('gsbeh-fa-icons','registered')){
				wp_register_style('gsbeh-fa-icons', GSBEH_FILES_URI . '/assets/fa-icons/css/font-awesome.min.css','', GSBEH_VERSION, $media);
			}
			if(!wp_style_is('gsbeh-fa-icons','enqueued')){
				wp_enqueue_style('gsbeh-fa-icons');
			}

			if(!wp_style_is('gsbeh-mfp-css','registered')){
				wp_register_style('gsbeh-mfp-css', GSBEH_FILES_URI . '/assets/css/magnific-popup.css', '', GSBEH_VERSION, $media);
			}
			if(!wp_style_is('gsbeh-mfp-css','enqueued')){
				wp_enqueue_style('gsbeh-mfp-css');
			}

			wp_register_style('gs-beh-custom-bootstrap', GSBEH_FILES_URI . '/assets/css/gs-beh-custom-bootstrap.css','', GSBEH_VERSION, $media);
			wp_enqueue_style('gs-beh-custom-bootstrap');

			wp_register_style('gsbeh-owl-def-style', GSBEH_FILES_URI . '/assets/css/owl.theme.default.css','', GSBEH_VERSION, $media);
			wp_enqueue_style('gsbeh-owl-def-style');

			wp_register_style('gsbeh-owl-caro-style', GSBEH_FILES_URI . '/assets/css/owl.carousel.css','', GSBEH_VERSION, $media);
			wp_enqueue_style('gsbeh-owl-caro-style');

			// // Plugin main stylesheet
			wp_register_style('gs_behance_custom_css', GSBEH_FILES_URI . '/assets/css/gs-beh-custom.css','', GSBEH_VERSION, $media);
			wp_enqueue_style('gs_behance_custom_css');			
		}
	}
	add_action( 'init', 'gs_enqueue_behance_styles' );
}

// -- Behance Custom CSS
if ( !function_exists('gs_behance_custom_style')) {
	function gs_behance_custom_style() {

		$gs_beh_custom_css = gs_behance_getoption('gs_beh_custom_css', 'gs_behance_settings', '');

		if( isset($gs_beh_custom_css) && !empty($gs_beh_custom_css) ){
			?>
				<style type="text/css">
					<?php echo $gs_beh_custom_css;?>
				</style>
			<?php
		}
	}
	add_action( 'gs_behance_custom_css','gs_behance_custom_style' );
}

// -- Admin css
function gsbeh_enque_admin_style() {
    $media = 'all';

    wp_register_style( 'gsdrib-admin-style', GSBEH_FILES_URI . '/admin/css/gsbeh_admin_style.css', '', GSBEH_VERSION, $media );
    wp_enqueue_style( 'gsdrib-admin-style' );
}
add_action( 'admin_enqueue_scripts', 'gsbeh_enque_admin_style' );