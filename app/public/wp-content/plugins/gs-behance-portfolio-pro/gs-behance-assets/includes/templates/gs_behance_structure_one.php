<?php
/*
 * GS Behance Portfolio - Theme One (Projects)
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

                $output .= '</div>'; // end col

             } // array
        }else{
                $output .= '<div class="col-md-'.$atts['column'].' col-sm-6 col-xs-6 beh-projects">';
                    $output .= '<a href="' . $gs_beh_single_shot[ 'url' ]. '" target="'. $gs_beh_link_tar .'">';
                        $output .= '<img src="'.$gs_beh_single_shot['thum_image'].'"/>';
                    $output .= '</a>';

                $output .= '</div>'; // end col
        }
        
        
    } // foreach
    
    $output .= '</div>'; // end row
    do_action('gs_behance_custom_css');
$output .= '</div>'; // end container

return $output;