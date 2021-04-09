<?php
/*
 * GS Behance Portfolio - Theme Three (Hover)
 * @author GS Plugins <hello@gsplugins.com>
 * 
 */

// $output .= '<div class="container">';
$output .= '<div class="row beh_slider">';

foreach ( $gs_behance_shots as $gs_beh_single_shot ) {
	$bfields = unserialize( $gs_beh_single_shot['bfields'] );
	if ( ! empty( $atts['field'] ) ) {
		if ( in_array( $atts['field'],  array_column($bfields,'name') ) ) {
			$output .= '<div class="beh-sin-project">';

			$output .= '<div class="beh-img-tit-cat">';
			$output .= '<img src="' . $gs_beh_single_shot['thum_image'] . '"/>';

			$output .= '<div class="beh-tit-cat">';
			$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
			$output .= '<ul class="beh-cat"><i class="fa fa-tags"></i>';
			foreach ( $bfields as $bcats ) {

				$output .= '<li>' . $bcats['name'] . '</li>';

			}
			$output .= '</ul>';

			$output .= '<ul class="beh-stat">';
			$output .= '<li class="beh-app"><i class="fa fa-thumbs-o-up"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['blike'] ) . '</span></li>';
			$output .= '<li class="beh-views"><i class="fa fa-eye"></i><span class="number ">' . number_format_i18n( $gs_beh_single_shot['bview'] ) . '</span></li>';
			$output .= '<li class="beh-comments"><i class="fa fa-comment-o"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bcomment'] ) . '</span></li>';
			$output .= '</ul>';

			$output .= '<a class="beh_hover" href="' . $gs_beh_single_shot['url'] . '" target="' . $gs_beh_link_tar . '">';
			$output .= '<i class="fa fa-paper-plane-o"></i>';
			$output .= '</a>';
			$output .= '</div>'; // end beh-tit-cat

			$output .= '</div>'; // end beh-img-tit-cat
			$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
			$output .= '</div>'; // end col


		} // array
	} else {
		$output .= '<div class="beh-sin-project">';

		$output .= '<div class="beh-img-tit-cat">';
		$output .= '<img src="' . $gs_beh_single_shot['thum_image'] . '"/>';

		$output .= '<div class="beh-tit-cat">';
		$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
		$output .= '<ul class="beh-cat"><i class="fa fa-tags"></i>';
		foreach ( $bfields as $bcats ) {

			if(isset($bcats['name'])){

				$output .= '<li>' . $bcats['name'] . '</li>';
			}

		}
		$output .= '</ul>';

		$output .= '<ul class="beh-stat">';
		$output .= '<li class="beh-app"><i class="fa fa-thumbs-o-up"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['blike'] ) . '</span></li>';
		$output .= '<li class="beh-views"><i class="fa fa-eye"></i><span class="number ">' . number_format_i18n( $gs_beh_single_shot['bview'] ) . '</span></li>';
		$output .= '<li class="beh-comments"><i class="fa fa-comment-o"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bcomment'] ) . '</span></li>';
		$output .= '</ul>';

		$output .= '<a class="beh_hover" href="' . $gs_beh_single_shot['url'] . '" target="' . $gs_beh_link_tar . '">';
		$output .= '<i class="fa fa-paper-plane-o"></i>';
		$output .= '</a>';
		$output .= '</div>'; // end beh-tit-cat

		$output .= '</div>'; // end beh-img-tit-cat
		$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
		$output .= '</div>';
	}
} // foreach

$output .= '</div>'; // end row
do_action( 'gs_behance_custom_css' );

// $output .= '</div>'; // end container

return $output;