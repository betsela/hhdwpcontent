<?php
/*
 * GS Behance Portfolio - Theme Two (Projects Stat)
 * @author GS Plugins <hello@gsplugins.com>
 * 
 */

$output .= '<div class="container">';
	$output .= '<div class="row">';

	foreach( $gs_behance_shots as $gs_beh_single_shot ) {
        
        $bfields=unserialize($gs_beh_single_shot['bfields']);
        if( !empty($atts['field'])){
            if ( in_array($atts['field'],  array_column($bfields,'name')) ) {

                $output .= '<div class="col-md-'.$atts['column'].' col-sm-6 col-xs-6 beh-projects">';
                    $output .= '<a href="' . $gs_beh_single_shot[ 'url' ]. '" target="'. $gs_beh_link_tar .'">';
                    	$output .= '<img src="'.$gs_beh_single_shot['thum_image'].'"/>';
                    $output .= '</a>';
                    
                    $output .= '<ul class="beh-stat">';
                    $output .= '<li class="beh-app"><i class="fa fa-thumbs-o-up"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['blike'] ) . '</span></li>';
                    $output .= '<li class="beh-views"><i class="fa fa-eye"></i><span class="number ">' . number_format_i18n( $gs_beh_single_shot['bview'] ) . '</span></li>';
                    $output .= '<li class="beh-comments"><i class="fa fa-comment-o"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bcomment'] ) . '</span></li>';
                    $output .= '</ul>';

                $output .= '</div>'; // end col
               
            } // array
        }else{
                $output .= '<div class="col-md-'.$atts['column'].' col-sm-6 col-xs-6 beh-projects">';
                    $output .= '<a href="' . $gs_beh_single_shot[ 'url' ]. '" target="'. $gs_beh_link_tar .'">';
                        $output .= '<img src="'.$gs_beh_single_shot['thum_image'].'"/>';
                    $output .= '</a>';
                    
                    $output .= '<ul class="beh-stat">';
                    $output .= '<li class="beh-app"><i class="fa fa-thumbs-o-up"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['blike'] ) . '</span></li>';
                    $output .= '<li class="beh-views"><i class="fa fa-eye"></i><span class="number ">' . number_format_i18n( $gs_beh_single_shot['bview'] ) . '</span></li>';
                    $output .= '<li class="beh-comments"><i class="fa fa-comment-o"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bcomment'] ) . '</span></li>';
                    $output .= '</ul>';

                $output .= '</div>'; // end col
        }
    } // foreach
    
    $output .= '</div>'; // end row
    do_action('gs_behance_custom_css');
$output .= '</div>'; // end container

return $output;