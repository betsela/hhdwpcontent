<?php
/*
 * GS Behance Portfolio - Theme Three (Hover)
 * @author GS Plugins <hello@gsplugins.com>
 * 
 */

$output .= '<div class="container">';
$output .= '<div class="row">';

foreach ( $gs_behance_shots as $gs_beh_single_shot ) {
	$bfields = unserialize( $gs_beh_single_shot['bfields'] );
	if ( ! empty( $atts['field'] ) ) {
		if ( in_array( $atts['field'],  array_column($bfields,'name') ) ) {

			$output .= '<div class="col-md-' . $atts['column'] . ' col-sm-6 col-xs-6 beh-projects-pop">';

			$gs_beh_id = rand( 10, 1000 );

			$output .= '<div class="gs_beh_external">';
			$output .= '<a class="gs_beh_pop open-popup-link" data-mfp-src="#gs-beh-pop-' . $gs_beh_id . '" href="javascript:void(0);" target="' . $gs_beh_link_tar . '">';
			$output .= '<img src="' . $gs_beh_single_shot['thum_image'] . '"/>';
			$output .= '<div class="gs_beh_overlay"><i class="fa fa-external-link"></i></div>';
			$output .= '</a>';
			$output .= '</div>'; // end gs_beh_external

			// start popup
			$output .= '<div id="gs-beh-pop-' . $gs_beh_id . '" class="white-popup mfp-hide mfp-with-anim gs_beh_popup">';
			$output .= '<div class="gs-beh-pop-img">';
			$output .= '<img src="' . $gs_beh_single_shot['big_img'] . '"/>';
			$output .= '</div>'; // gs-beh-pop-img

			$output .= '<div class="gs-beh-pop-info">';
			$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
			$output .= '<ul class="beh-cat"><i class="fa fa-tags"></i>';
			foreach ( $bfields as $bcat ) {
				$output .= '<li>' . $bcat['name'] . '</li>';
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

			$output .= '</div>'; // end gs-beh-pop-info
			$output .= '</div>'; // end popup

			$output .= '</div>'; // end col


		}
	} else {

		$output .= '<div class="col-md-' . $atts['column'] . ' col-sm-6 col-xs-6 beh-projects-pop">';

		$gs_beh_id = rand( 10, 1000 );

		$output .= '<div class="gs_beh_external">';
		$output .= '<a class="gs_beh_pop open-popup-link" data-mfp-src="#gs-beh-pop-' . $gs_beh_id . '" href="javascript:void(0);" target="' . $gs_beh_link_tar . '">';
		$output .= '<img src="' . $gs_beh_single_shot['thum_image'] . '"/>';
		$output .= '<div class="gs_beh_overlay"><i class="fa fa-external-link"></i></div>';
		$output .= '</a>';
		$output .= '</div>'; // end gs_beh_external

		// start popup
		$output .= '<div id="gs-beh-pop-' . $gs_beh_id . '" class="white-popup mfp-hide mfp-with-anim gs_beh_popup">';
		$output .= '<div class="gs-beh-pop-img">';
		$output .= '<img src="' . $gs_beh_single_shot['big_img'] . '"/>';
		$output .= '</div>'; // gs-beh-pop-img

		$output .= '<div class="gs-beh-pop-info">';
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

		$output .= '</div>'; // end gs-beh-pop-info
		$output .= '</div>'; // end popup

		$output .= '</div>'; // end col
	}// array
} // foreach

$output .= '</div>'; // end row
do_action( 'gs_behance_custom_css' );
$output .= '</div>'; // end container

return $output;