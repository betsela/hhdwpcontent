<?php

// -- Getting values from setting panel
function gs_behance_getoption( $option, $section, $default = '' ) {
	$options = get_option( $section );
	if ( isset( $options[ $option ] ) ) {
		return $options[ $option ];
	}

	return $default;
}

function gs_behance_updateOption($option,$section,$value){
	$options = get_option( $section );
	if(is_array($options) && array_key_exists($option,$options)){
	    $options[$option] = $value;
	    update_option($section,$options);
	    return true;
    }
    return false;
}



// -- Shortcode [gs_behance]

add_shortcode( 'gs_behance', 'gs_behance_shortcode' );

function gs_behance_shortcode( $atts ) {

	$gs_beh_user         = gs_behance_getoption( 'gs_beh_user', 'gs_behance_settings', ' ' );
	$gs_beh_acc_token    = gs_behance_getoption( 'gs_beh_acc_token', 'gs_behance_settings', '' );
	$gs_beh_tot_projects = gs_behance_getoption( 'gs_beh_tot_projects', 'gs_behance_settings', '' );
	$gs_beh_cols         = gs_behance_getoption( 'gs_beh_cols', 'gs_behance_settings', 3 );
	$gs_beh_theme        = gs_behance_getoption( 'gs_beh_theme', 'gs_behance_settings', 'gs_beh_theme1' );
	$gs_beh_link_tar     = gs_behance_getoption( 'gs_beh_link_tar', 'gs_behance_settings', '_blank' );


	//Check for missing information
	if ( empty( $gs_beh_user ) ) {
		return '<div class="gs_beh_error">Enter a userid with shortcode or in <b><i>GS PLugins > GS Behance Settings > Behance User</i></b></div>';
	}


	$atts = shortcode_atts(
		array(
			'userid'     => '',
			'count'      => $gs_beh_tot_projects,
			'column'     => $gs_beh_cols,
			'theme'      => $gs_beh_theme,
			'field'      => '',
			'moodboards' => '',
			'property'   => '',
		),
		$atts );


	//
	global $wpdb;
	$table_name    = $wpdb->prefix . 'gsbehance';
	$gs_beh_user   = $atts['userid'];
	$gs_moodboards = $atts['moodboards'];
	$gs_property   = $atts['property'];
	$property      = [];
	if ( ! empty( $gs_property ) ) {
		$gs_property = explode( '&', $gs_property );
		if ( count( $gs_property ) > 0 ) {
			foreach ( $gs_property as $property_value ) {
				$property_value = explode( '=', $property_value );
				if ( count( $property_value ) == 2 ) {
					$property_key              = str_replace( 'amp;', '', $property_value[0] );
					$property[ $property_key ] = $property_value[1];
				}
			}
		}
	}
	save_moodboard_data( false );
	if ( ! empty( $gs_beh_user ) && ! $gs_moodboards ) {
		$gs_behance_shots = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE beusername='{$gs_beh_user}' ORDER BY id ASC LIMIT {$atts['count']} ",
			ARRAY_A );
		if ( empty( $gs_behance_shots ) ) {
			gs_behance_updateOption('gs_beh_user', 'gs_behance_settings', $gs_beh_user);
			return "data is being fetched...";
		}

	} elseif ( $gs_moodboards ) {
		$gs_behance_shots = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE beusername='{$gs_moodboards}' ORDER BY id ASC LIMIT {$atts['count']} ",
			ARRAY_A );
		//fetch data when empty
		if ( empty( $gs_behance_shots ) ) {
			save_moodboard_data( true,$gs_moodboards, $property );
			return "data is being fetched";
		}
	} else {
		$gs_behance_shots = $wpdb->get_results( "SELECT * FROM {$table_name} ORDER BY id DESC LIMIT {$atts['count']} ",
			ARRAY_A );

	}


	$output = '';
	$output .= '<div class="gs_beh_area ' . $atts['theme'] . '">';


	if ( $atts['theme'] == 'gs_beh_theme1' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_one.php';
	}

	if ( $atts['theme'] == 'gs_beh_theme2' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_two.php';
	}

	if ( $atts['theme'] == 'gs_beh_theme3' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_three_hover.php';
	}

	if ( $atts['theme'] == 'gs_beh_theme4' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_four_pop.php';
	}

	if ( $atts['theme'] == 'gs_beh_theme5' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_five_slider.php';
	}

	if ( $atts['theme'] == 'gs_beh_theme6' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_six_profile.php';
	}
	if ( $atts['theme'] == 'gs_beh_theme7' ) {
		include GSBEH_FILES_DIR . '/includes/templates/gs_behance_structure_seven_filter.php';
	}

	$output .= '</div>'; // end gs_drib_area

	return $output;
} // end function

function save_moodboard_data( $status = true, $moodboard = null, $property = null ) {

	$data              = [];
	$data['status']    = $status;
	$data['moodboard'] = $moodboard;
	$data['property']  = $property;
	update_option( 'behance_moodboard', $data );
}

// -- Magnific Popup
if ( ! function_exists( 'gs_hehance_magnific_popup' ) ) {

	function gs_hehance_magnific_popup() { ?>
        <script type="text/javascript">
            jQuery.noConflict();
            jQuery(document).ready(function () {
                jQuery('.beh-projects-pop').magnificPopup({
                    type: 'inline',
                    midClick: true,
                    gallery: {
                        enabled: true
                    },
                    delegate: 'a.gs_beh_pop',
                    removalDelay: 500, //delay removal by X to allow out-animation
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = this.st.el.attr('data-effect');
                        }
                    },
                    closeOnContentClick: true,
                });
            });
        </script>
		<?php
	}

	add_action( 'wp_footer', 'gs_hehance_magnific_popup' );
}

// -- OWL Carousel 
if ( ! function_exists( 'gs_behance_slider_trigger' ) ) {

	function gs_behance_slider_trigger() { ?>
        <script type="text/javascript">
            jQuery.noConflict();
            jQuery(document).ready(function ($) {

                jQuery('.beh_slider').owlCarousel({
                    autoplay: true,
                    autoplayHoverPause: true,
                    loop: true,
                    margin: 10,
                    autoplaySpeed: 800,
                    autoplayTimeout: 2500,
                    navSpeed: 1000,
                    dots: true,
                    // dotsEach: true,
                    responsiveClass: true,
                    lazyLoad: true,
                    responsive: {
                        0: {
                            items: 1,
                            nav: false
                        },
                        533: {
                            items: 2,
                            nav: false
                        },
                        768: {
                            items: 2,
                            nav: false
                        },
                        1000: {
                            items: 3,
                            nav: true
                        }
                    }
                }) // end of owlCarousel latest product


            });

            jQuery(window).load(function ($) {
                // init Isotope
                var grid = jQuery('.grid').isotope({
                    itemSelector: '.beh-projects',
                    layoutMode: 'fitRows'
                });

                // bind filter button click
                jQuery('.filters-button-group').on('click', 'button', function () {
                    var filterValue = jQuery(this).attr('data-filter');
                    // use filterFn if matches value
                    filterValue = filterValue;
                    grid.isotope({filter: filterValue});
                });
                // change is-checked class on buttons
                jQuery('.button-group').each(function (i, buttonGroup) {
                    var $buttonGroup = jQuery(buttonGroup);
                    $buttonGroup.on('click', 'button', function () {
                        $buttonGroup.find('.is-checked').removeClass('is-checked');
                        jQuery(this).addClass('is-checked');
                    });
                });
            });
        </script>
		<?php
	}

	add_action( 'wp_head', 'gs_behance_slider_trigger' );
}


// -- Shortcode [gs_behance_widget] for widget
add_shortcode( 'gs_behance_widget', 'gs_behance_shortcode_widget' );

function gs_behance_shortcode_widget( $atts ) {

	$gs_beh_user         = gs_behance_getoption( 'gs_beh_user', 'gs_behance_settings', '' );
	$gs_beh_tot_projects = gs_behance_getoption( 'gs_beh_tot_projects', 'gs_behance_settings', '' );
	$gs_beh_link_tar     = gs_behance_getoption( 'gs_beh_link_tar', 'gs_behance_settings', '_blank' );

	$atts = shortcode_atts(
		array(
			'userid' => $gs_beh_user,
			'count'  => $gs_beh_tot_projects,
		),
		$atts );

	global $wpdb;
	$table_name       = $wpdb->prefix . 'gsbehance';
	$gs_behance_shots = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE beusername='{$atts['userid']}' ORDER BY id ASC LIMIT {$atts['count']} ",
		ARRAY_A );

	$output = '';
	$output .= '<div class="beh-widget-area">';


	if ( is_array( $gs_behance_shots ) ) {

		foreach ( $gs_behance_shots as $gs_beh_single_shot ) {

			$output .= '<div class="beh-widget-projects">';

			$output .= '<div class="beh-img-tit-cat">';
			$output .= '<img src="' . $gs_beh_single_shot['thum_image'] . '"/>';

			$output .= '<div class="beh-tit-cat">';
			$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
			$output .= '<a class="beh_hover" href="' . $gs_beh_single_shot['url'] . '" target="' . $gs_beh_link_tar . '">';
			$output .= '<i class="fa fa-paper-plane-o"></i>';
			$output .= '</a>';
			$output .= '</div>'; // end beh-tit-cat
			$output .= '</div>'; // end beh-img-tit-cat

			$output .= '<ul class="beh-stat">';
			$output .= '<li class="beh-app"><i class="fa fa-thumbs-o-up"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bview'] ) . '</span></li>';
			$output .= '<li class="beh-views"><i class="fa fa-eye"></i><span class="number ">' . number_format_i18n( $gs_beh_single_shot['blike'] ) . '</span></li>';
			$output .= '<li class="beh-comments"><i class="fa fa-comment-o"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bcomment'] ) . '</span></li>';
			$output .= '</ul>';

			$output .= '</div>'; // end beh-widget-projects

		} // foreach
	} // array


	do_action( 'gs_behance_custom_css' );

	$output .= '</div>'; // end beh-widget-area

	return $output;

} // end function for widget shortcode


// -- OWL Carousel for widget
if ( ! function_exists( 'gs_behance_widget_slider' ) ) {

	function gs_behance_widget_slider() { ?>
        <script type="text/javascript">
            jQuery.noConflict();
            jQuery(document).ready(function () {
                jQuery('.beh-widget-area').owlCarousel({
                    loop: true,
                    autoplay: true,
                    items: 1,
                    nav: true,
                    dots: false,
                    autoplayHoverPause: true,
                    animateOut: 'slideOutUp',
                    animateIn: 'slideInUp'
                });
            });
        </script>
		<?php
	}

	add_action( 'wp_head', 'gs_behance_widget_slider' );
}




