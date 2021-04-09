<?php
/*
 * GS Behance Portfolio - Theme Six
 * @author GS Plugins <hello@gsplugins.com>
 * 
 */
$output .= '<div class="container">';
$output .= '<div class="row">';

$gsbeh_user_url = "https://www.behance.net/" .$atts['userid'] . "/projects" ;


$gs_behance_user = behance_projects_scrapper($gsbeh_user_url,1);

//pri_dump($gs_behance_user);


if (is_array( $gs_behance_user )) {

	$gs_behance_user = $gs_behance_user['profile']['owner'];
	$beh_user = $gs_behance_user['first_name'];
	$beh_stats = $gs_behance_user['stats'];
	$beh_fields = $gs_behance_user['fields'];
	$beh_s_links = $gs_behance_user['social_links'];
	$beh_secs = $gs_behance_user['sections'];
	$beh_links = $gs_behance_user['links'];
	$beh_user_image = $gs_behance_user['images'][138];

	$output .= '<div class="gs-beh-profile">';
	$output .= '<div class="col-md-6">';
	$output .= '<h1>'. $beh_user .'</h1>';
	$output .= '<img class="profile-pic" src="'. $beh_user_image.'"/>';
	$output .= '<div class="profile-details">';
	$output .= '<div><i class="fa fa-user"></i>'. $gs_behance_user['username'] .'</div>';
	$beh_city = !empty($gs_behance_user['city']) ? $gs_behance_user['city'] : '';
	if(!empty( $beh_city )) :
		$output .= '<div><i class="fa fa-map-marker"></i>'. $beh_city .'</div>';
	endif;

	$beh_country = !empty($gs_behance_user['country']) ? $gs_behance_user['country'] : '';
	if(!empty( $beh_country )) :
		$output .= '<div><i class="fa fa-flag"></i>'. $beh_country .'</div>';
	endif;

	$beh_occup = !empty($gs_behance_user['occupation']) ? $gs_behance_user['occupation'] : '';
	if(!empty( $beh_occup )) :
		$output .= '<div><i class="fa fa-folder-open"></i>'. $beh_occup .'</div>';
	endif;

	$beh_web = !empty($gs_behance_user['website']) ? $gs_behance_user['website'] : '';
	if(!empty( $beh_web )) :
		$output .= '<div><i class="fa fa-link"></i>'. $beh_web .'</div>';
	endif;

	$output .= '</div>';

	$output .= '<ul class="profile-stats">';
	$output .= '<li><i class="fa fa-eye"></i> Project Views : '. $beh_stats['views'] .'</li>';
	$output .= '<li><i class="fa fa-thumbs-o-up"></i> Project Appreciations : '. $beh_stats['appreciations'] .'</li>';
	$output .= '<li><i class="fa fa-hand-o-left"></i>Project Followers : '. $beh_stats['followers'] .'</li>';
	$output .= '<li><i class="fa fa-hand-o-right"></i>Project Following : '. $beh_stats['following'] .'</li>';
	$output .= '</ul>';
	$output .= '</div>'; // end col-md-6

	$output .= '<div class="col-md-6">';
	$output .= '<ul class="beh-focus"><div>Focus</div>';
	$output .= '<li>'. $beh_fields[0]['name'] .'</li>';
	$output .= '<li>'. $beh_fields[1]['name'] .'</li>';
	$output .= '<li>'. $beh_fields[2]['name'] .'</li>';
	$output .= '</ul>';

	$beh_ref = !empty($beh_links[0]['url']) ? $beh_links[0]['url'] : '';
	if(!empty( $beh_ref )) :
		$output .= '<ul class="beh-ref"><div>Web References :</div>';
		$output .= '<li><a href="'.$beh_links[0]['url'].'" target="_blank">'. $beh_links[0]['title'] .'</a></li>';
		if(array_key_exists(1,$beh_links)){

			$output .= '<li><a href="'.$beh_links[1]['url'].'" target="_blank">'. $beh_links[1]['title'] .'</a></li>';
		}
		$output .= '</ul>';
	endif;

	if(!empty( $web_url_0 )) :
		$output .= '<ul class="beh-url"><div>On the Web : </div>';
		$web_url_0 = !empty($beh_s_links[0]['url']) ? $beh_s_links[0]['url'] : '';
		$web_url_0ser = !empty($beh_s_links[0]['service_name']) ? $beh_s_links[0]['service_name'] : '';
		$web_url_1 = !empty($beh_s_links[1]['url']) ? $beh_s_links[1]['url'] : '';
		$web_url_1ser = !empty($beh_s_links[1]['service_name']) ? $beh_s_links[1]['service_name'] : '';
		$web_url_2 = !empty($beh_s_links[2]['url']) ? $beh_s_links[2]['url'] : '';
		$web_url_2ser = !empty($beh_s_links[2]['service_name']) ? $beh_s_links[2]['service_name'] : '';
		$web_url_3 = !empty($beh_s_links[3]['url']) ? $beh_s_links[3]['url'] : '';
		$web_url_3ser = !empty($beh_s_links[3]['service_name']) ? $beh_s_links[3]['service_name'] : '';
		$web_url_4 = !empty($beh_s_links[4]['url']) ? $beh_s_links[4]['url'] : '';
		$web_url_4ser = !empty($beh_s_links[4]['service_name']) ? $beh_s_links[4]['service_name'] : '';
		if(!empty( $web_url_0 )) :
			$output .= '<li><a href="'. $web_url_0 .'" target="_blank">'. $web_url_0ser .'</a></li>';
		endif;
		if(!empty( $web_url_1 )) :
			$output .= '<li><a href="'. $web_url_1 .'" target="_blank">'. $web_url_1ser .'</a></li>';
		endif;
		if(!empty( $web_url_2 )) :
			$output .= '<li><a href="'. $web_url_2 .'" target="_blank">'. $web_url_2ser .'</a></li>';
		endif;
		if(!empty( $web_url_3 )) :
			$output .= '<li><a href="'. $web_url_3 .'" target="_blank">'. $web_url_3ser .'</a></li>';
		endif;
		if(!empty( $web_url_4 )) :
			$output .= '<li><a href="'. $web_url_4 .'" target="_blank">'. $web_url_4ser .'</a></li>';
		endif;
		$output .= '</ul>';
	endif;


	$beh_abt = !empty($beh_secs['About']) ? $beh_secs['About'] : '';
	if(!empty( $beh_abt )) :
		$output .= '<div class="pro-info">About :</div>';
		$output .= '<p>'. $beh_abt .'</p>';
	endif;

	$beh_abt_me = !empty($beh_secs['About Me']) ? $beh_secs['About Me'] : '';
	if(!empty( $beh_abt_me )) :
		$output .= '<div class="pro-info">About Me :</div>';
		$output .= '<p>'. $beh_abt_me .'</p>';
	endif;

	$beh_get_con = !empty($beh_secs['Get Contact ']) ? $beh_secs['Get Contact '] : '';
	if(!empty( $beh_get_con )) :
		$output .= '<div class="pro-info">Get Contact :</div>';
		$output .= '<p>'. $beh_get_con .'</p>';
	endif;

	$beh_work = !empty($beh_secs['My work']) ? $beh_secs['My work'] : '';
	if(!empty( $beh_work )) :
		$output .= '<div class="pro-info">My work :</div>';
		$output .= '<p>'. $beh_work .'</p>';
	endif;
	$output .= '</div>'; //end col-md-6
	$output .= '</div>'; // end gs-beh-profile

} // end array




$output .= '<div class="container">';
$output .= '<div class="row">';
foreach ( $gs_behance_shots as $gs_beh_single_shot ) {
	$bfields = unserialize( $gs_beh_single_shot['bfields'] );
	if ( ! empty( $atts['field'] ) ) {
		if ( in_array( $atts['field'],  array_column($bfields,'name') ) ) {
			$output .= '<div class="col-md-' . $atts['column'] . ' col-sm-6 col-xs-6 beh-projects">';

			$output .= '<div class="beh-img-tit-cat">';
			$output .= '<img src="' . $gs_beh_single_shot['thum_image'] . '"/>';

			$output .= '<div class="beh-tit-cat">';
			$output .= '<span class="beh-proj-tit">' . $gs_beh_single_shot['name'] . '</span>';
			$output .= '<ul class="beh-cat"><i class="fa fa-tags"></i>';
			foreach ( $bfields as $bcats ) {
					$output .= '<li>' . $bcats['name'] . '</li>';

			}
			$output .= '</ul>';

			$output .= '<a class="beh_hover" href="' . $gs_beh_single_shot['url'] . '" target="' . $gs_beh_link_tar . '">';
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


		} // array
	} else {
		$output .= '<div class="col-md-' . $atts['column'] . ' col-sm-6 col-xs-6 beh-projects">';

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

		$output .= '<a class="beh_hover" href="' . $gs_beh_single_shot['url'] . '" target="' . $gs_beh_link_tar . '">';
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
	}
} // foreach

$output .= '</div>'; // end row
do_action( 'gs_behance_custom_css' );
$output .= '</div>'; // end container

return $output;