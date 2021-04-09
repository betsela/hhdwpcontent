<?php
/*
 * GS Behance Portfolio - Theme Three (Hover)
 * @author GS Plugins <hello@gsplugins.com>
 * 
 */

 if ( !function_exists('gs_behance_category')) {  
    function gs_behance_category($id){
        global $wpdb;
        $table_name = $wpdb->prefix . 'gsbehance';
        $gs_behance_fields = $wpdb->get_results( "SELECT bfields FROM {$table_name} WHERE beid={$id}",ARRAY_A);
        foreach( $gs_behance_fields as $gs_beh_single_shot ) {

            $bfields=unserialize($gs_beh_single_shot['bfields']);
              
            foreach ( $bfields  as  $bcat) {
                $bcat_termname[] = $bcat['name'];
            }  
            $gs_behance_cats_link = str_replace(' ', '-', $bcat_termname);
            $gs_behance_cats_link = str_replace('/', '-', $gs_behance_cats_link);
            $gs_be_cats = join( " ", $gs_behance_cats_link );
            $gs_be_cats = strtolower($gs_be_cats);
        }
        return  $gs_be_cats;  
}}

$output .= '<div class="container">';
	$output .= '<div class="row">';


    global $wpdb;
    $table_name = $wpdb->prefix . 'gsbehance';
    if(!empty( $atts['userid'] )){
        $gs_behance_fields = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE beusername='{$atts['userid']}' ORDER BY time ASC LIMIT {$atts['count']} ",ARRAY_A);
    }else{
        $gs_behance_fields = $wpdb->get_results( "SELECT * FROM {$table_name} ORDER BY id DESC LIMIT {$atts['count']} ",ARRAY_A);
    }
    //$gs_behance_fields = $wpdb->get_results( "SELECT bfields FROM {$table_name}",ARRAY_A);
        $output .= '<div class="filter">';
            $output .='<div class="button-group filters-button-group">
                                  <button class="button is-checked" data-filter="*">show all</button>';

                foreach( $gs_behance_fields as $gs_beh_single_shot ) {

                    $bfields=unserialize($gs_beh_single_shot['bfields']);

                      foreach ( $bfields  as  $bcat) {
                        $bcat_termname[] = $bcat['name'];
                    }  
                }

                $tm_fields_list = array_unique($bcat_termname);

                foreach($tm_fields_list as $field):
                    if(!empty($field)):
                        $be_field_string = str_replace(' ', '-', $field);
                        $be_field_string = str_replace('/', '-', $be_field_string);
                        $be_field_string = strtolower($be_field_string); 
                         $output .='<button class="button" data-filter=".'.$be_field_string.'">'.$field.'</button>';
                   endif;
                endforeach;  
            $output .='</div>';
        $output .='</div>';
        $output .='<div class="grid">';

        	foreach( $gs_behance_shots as $gs_beh_single_shot ) {

                $bfields=unserialize($gs_beh_single_shot['bfields']);
                    
                $output .= '<div class="col-md-'.$atts['column'].' col-sm-6 col-xs-6 '.gs_behance_category($gs_beh_single_shot['beid']).' beh-projects  "data-category="'.gs_behance_category($gs_beh_single_shot['beid']).'">';

                    $output .= '<div class="beh-img-tit-cat">';
                        $output .= '<img src="'.$gs_beh_single_shot['thum_image'].'"/>';

                        $output .= '<div class="beh-tit-cat">';
                            $output .= '<span class="beh-proj-tit">'.$gs_beh_single_shot['name'].'</span>';
                            $output .= '<ul class="beh-cat"><i class="fa fa-tags"></i>';
                            foreach ( $bfields  as  $bcat) {
                                $output .= '<li>' . $bcat['name'] . '</li>';
                            }
                            $output .= '</ul>';

                            $output .= '<a class="beh_hover" href="' .$gs_beh_single_shot[ 'url' ]. '" target="'. $gs_beh_link_tar .'">';
                                $output .= '<i class="fa fa-paper-plane-o"></i>';
                            $output .= '</a>';
                        $output .= '</div>'; // end beh-tit-cat

                    $output .= '</div>'; // end beh-img-tit-cat

                    $output .= '<ul class="beh-stat">';
                    $output .= '<li class="beh-app"><i class="fa fa-thumbs-o-up"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['blike'] ) . '</span></li>';
                    $output .= '<li class="beh-views"><i class="fa fa-eye"></i><span class="number ">' . number_format_i18n( $gs_beh_single_shot['bview'] ) . '</span></li>';
                    $output .= '<li class="beh-comments"><i class="fa fa-comment-o"></i><span class="number">' . number_format_i18n( $gs_beh_single_shot['bcomment'] ) . '</span></li>';
                    $output .= '</ul>';
                $output .= '</div>'; // end col
            } // foreach
    
        $output .= '</div>'; // end grid
    $output .= '</div>'; // end row
    do_action('gs_behance_custom_css');
$output .= '</div>'; // end container

return $output;