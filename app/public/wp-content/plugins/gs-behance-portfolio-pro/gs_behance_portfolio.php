<?php
/**
 *
 * @package   GS_Behance_Portfolio
 * @author    GS Plugins <hello@gsplugins.com>
 * @license   GPL-2.0+
 * @link      https://www.gsplugins.com
 * @copyright 2016 GS Plugins
 *
 * @wordpress-plugin
 * Plugin Name:		GS Behance Portfolio PRO
 * Plugin URI:		https://www.gsplugins.com/wordpress-plugins
 * Description:     Behance plugin for WordPress to showcase Behance projects. Display anywhere at your site using shortcode like [gs_behance theme="gs_beh_theme1"] & widgets. Check more shortcode examples and documentation at <a href="http://behance.gsplugins.com">GS Behance Porfolio PRO Demos & Docs</a>.
 * Version:			2.0.10
 * Author:			GS Plugins
 * Author URI:		https://www.gsplugins.com
 * Text Domain:		gs-behance
 * License:			GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'GSBEH_HACK_MSG' ) ) {
	define( 'GSBEH_HACK_MSG', __( 'Sorry cowboy! This is not your place', 'gs-behance' ) );
}

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( GSBEH_HACK_MSG );
}

/**
 * Defining constants
 */
if ( ! defined( 'GSBEH_VERSION' ) ) {
	define( 'GSBEH_VERSION', '2.0.10' );
}
if ( ! defined( 'GSBEH_MENU_POSITION' ) ) {
	define( 'GSBEH_MENU_POSITION', 31 );
}
if ( ! defined( 'GSBEH_PLUGIN_DIR' ) ) {
	define( 'GSBEH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'GSBEH_FILES_DIR' ) ) {
	define( 'GSBEH_FILES_DIR', GSBEH_PLUGIN_DIR . 'gs-behance-assets' );
}
if ( ! defined( 'GSBEH_PLUGIN_URI' ) ) {
	define( 'GSBEH_PLUGIN_URI', plugins_url( '', __FILE__ ) );
}
if ( ! defined( 'GSBEH_FILES_URI' ) ) {
	define( 'GSBEH_FILES_URI', GSBEH_PLUGIN_URI . '/gs-behance-assets' );
}

define( 'GSBEHANCE_PLUGIN_FILE', __FILE__ );
$status = get_option( 'GS_BEHANCE_LICENSE_STATUS' );


register_activation_hook( __FILE__, 'bl_activate' );

function bl_activate() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'gsbehance';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE " . $table_name . " (
        id int(9) NOT NULL AUTO_INCREMENT,
        beid int(20) NOT NULL UNIQUE ,
        beusername tinytext,
        name tinytext NOT NULL,
        url varchar(100) DEFAULT '' NOT NULL,
        big_img varchar(255) DEFAULT '',
        thum_image varchar(255) DEFAULT '',
        blike int(9),
        bview int(9),
        bcomment int(9),
        bfields longtext,
        time datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

require_once GSBEH_FILES_DIR . '/gs-plugins/gs-plugins.php';
if ( $status !== false && $status == 'valid' ) {
	require_once GSBEH_FILES_DIR . '/includes/gs-behance-shortcode.php';
	require_once GSBEH_FILES_DIR . '/includes/gs-behance-widgets.php';
	require_once GSBEH_FILES_DIR . '/admin/class.settings-api.php';
	require_once GSBEH_FILES_DIR . '/admin/gs_behance_options_config.php';
	require_once GSBEH_FILES_DIR . '/gs-behance-scripts.php';
}
require_once GSBEH_FILES_DIR . '/gs-plugins/lic/gs_behance_lic.php';

// MCE button
add_action( 'init', 'GSBEH_buttons' );
function GSBEH_buttons() {
	add_filter( "mce_external_plugins", "GSBEH_add_buttons" );
	add_filter( 'mce_buttons', 'GSBEH_register_buttons' );
	//gs_task_hook_unschdule();
}


function GSBEH_add_buttons( $plugin_array ) {
	$plugin_array['GSBEH_mce_button'] = GSBEH_FILES_URI . '/assets/js/gsbeh-mce.js';

	return $plugin_array;
}

function GSBEH_register_buttons( $buttons ) {
	array_push( $buttons, 'GSBEH_mce_button' );

	return $buttons;
}


function my_cron_schedules( $schedules ) {
	if ( ! isset( $schedules["5min"] ) ) {
		$schedules["5min"] = array(
			'interval' =>2*60,// 5 * 60,
			'display'  => __( 'Once every 5 minutes' ),
		);
	}

	return $schedules;
}

add_filter( 'cron_schedules', 'my_cron_schedules' );

function gs_task_hook_unschdule() {
	$timestamp = wp_next_scheduled( 'gs_task_hook' );
	wp_unschedule_event( $timestamp, 'gs_task_hook' );
}

//error_log( print_r( 'next schedule', 1 ) );
//error_log( print_r( date( 'm-d-Y H:i:s', wp_next_scheduled( 'gs_task_hook' ) ), 1 ) );
//error_log( print_r( 'current time', 1 ) );
//error_log( print_r( date( 'm-d-Y H:i:s', time() ), 1 ) );

if ( ! wp_next_scheduled( 'gs_task_hook' ) ) {
	wp_schedule_event( time(), '5min', 'gs_task_hook' );
}




function behance_projects_scrapper( $scrap_url ) {
//	error_log( print_r( $scrap_url, 1 ) );
	$gsbeh_response = wp_remote_get( $scrap_url,
		array(
			'sslverify' => false,
			'timeout'   => 60,
			'headers'   => [
				'X-Requested-With' => 'XMLHttpRequest',
			],
		) );
	$gsbeh_xml      = wp_remote_retrieve_body( $gsbeh_response );
	$gsbeh_json     = json_decode( $gsbeh_xml, true );

	return $gsbeh_json;

}

add_action( 'gs_task_hook', 'my_task_function' );
//add_action( 'init', 'my_task_function' );
function my_task_function( ) {

	
	$gs_beh_user = gs_behance_getoption( 'gs_beh_user', 'gs_behance_settings', 'lazutina' );
	
	//Check for missing information
//	if ( empty( $gs_beh_user ) ) {
//		return '<div class="gs_beh_error">Enter a userid with shortcode or in <b><i>GS PLugins > GS Behance Settings > Behance User</i></b></div>';
//	}
//https://www.behance.net/search/moodboards?search=dairy&offset=2


	$behance_url   = "https://www.behance.net/";
	$be_option_key = 'be_meta';
	$page          = 1;
	$project_count = 12;
	$offset        = 0;
	
	$be_meta       = get_option( $be_option_key, true );
	$be_meta       = is_array( $be_meta ) ? $be_meta : [];

	if ( $be_meta && array_key_exists( $gs_beh_user, $be_meta ) ) {
		$page   = $be_meta[ $gs_beh_user ];
		$offset = ( ( $page - 1 ) * $project_count ) + 1;
	}

	$gsbeh_url     = $behance_url . $gs_beh_user . "/projects?offset=$offset";
	$moodboards_data = get_option('behance_moodboard',1);
	$is_moodboard = is_array($moodboards_data)?$moodboards_data['status']:false;

//	error_log( print_r( $moodboards_data, 1 ) );
//	error_log( print_r( $is_moodboard, 1 ) );
	if ( $is_moodboard ) {
		$moodboards_intact  = $moodboards_data['moodboard'];
		$moodboards         = explode( '/',$moodboards_intact );
		$moodboards_id      = $moodboards[0];
		$moodboards         = $moodboards[1];
		$moodboard_key      = 'moodboard' . $moodboards_id;
		$offset             = (int) get_option( $moodboard_key );
		$gsbeh_url          = $behance_url . 'search/moodboards';
		$property['search'] = $moodboards;
		if ( $offset > 0 ) {
			$property['ordinal'] = $offset * 48;
		}
		$gsbeh_url = $gsbeh_url . "?" . http_build_query( $property );
		//error_log( print_r( $gsbeh_url, 1 ) );
//		error_log( print_r( $offset, 1 ) );
	}

	$render         = false;
	$selected_shots = [];

	$gs_behance_shots = behance_projects_scrapper( $gsbeh_url );
//	error_log( print_r( $gs_behance_shots, 1 ) );

	if ( is_array( $gs_behance_shots ) && isset( $gs_behance_shots['search']['content']['collections'] ) && $moodboards ) {

		$gs_behance_shots = $gs_behance_shots['search']['content']['collections'];


		if ( is_array( $gs_behance_shots ) && count( $gs_behance_shots ) > 0 ) {
			$gs_behance_shots_id = array_column( $gs_behance_shots, 'id' );
			//error_log( print_r( 'logic execute', 1 ) );
			//error_log( print_r( $gs_behance_shots_id, 1 ) );
			if ( is_array($gs_behance_shots_id) && in_array($moodboards_id,$gs_behance_shots_id)  ) {
				$moodboard_array_key = array_keys($gs_behance_shots_id,$moodboards_id);
				$moodboard_array_key = $moodboard_array_key[0];
				$selected_shots = $gs_behance_shots[ $moodboard_array_key ]['latest_projects'];
			}else{
//				error_log( print_r( 'else logic', 1 ) );
//				error_log( print_r( $moodboard_key , 1 ) );
//				error_log( print_r( $offset, 1 ) );
				$offset = $offset+1;
				update_option( 'check', '0' );
				update_option( $moodboard_key, $offset++ );
				//my_task_function( null, $moodboards_intact );
			}

		}
		if ( ! empty( $selected_shots ) ) {
			$gs_behance_shots = $selected_shots;
			$render           = true;
			$gs_beh_user      = $moodboards_intact;
		}
	}


	if ( array_key_exists( 'section_content', (array) $gs_behance_shots ) ) {
		$gs_behance_shots = $gs_behance_shots['section_content'];
		$render           = true;
	}

	if ( array_key_exists( 'profile', (array) $gs_behance_shots ) && array_key_exists( 'activeSection',
			$gs_behance_shots['profile'] )
	     && array_key_exists( 'work',
			$gs_behance_shots['profile']['activeSection'] ) && array_key_exists( 'projects',
			$gs_behance_shots['profile']['activeSection']['work'] ) ) {
		$gs_behance_shots = $gs_behance_shots['profile']['activeSection']['work']['projects'];
		$render           = true;
	}


	if ( $render && $gs_behance_shots ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'gsbehance';

		if ( is_array( $gs_behance_shots ) && count( $gs_behance_shots ) > 0 ):
			foreach ( $gs_behance_shots as $gs_beh_single_shot ) {
				$beid     = $gs_beh_single_shot['id'];
				$b_name   = $gs_beh_single_shot['name'];
				$b_fields = serialize( $gs_beh_single_shot['fields'] );
				$b_url    = $gs_beh_single_shot['url'];
				$blike    = $gs_beh_single_shot['stats']['appreciations'];
				$bview    = $gs_beh_single_shot['stats']['views'];
				$bcomment = $gs_beh_single_shot['stats']['comments'];
				$username = $gs_beh_single_shot['owners'][0]['username'];

				if ( isset( $gs_beh_single_shot['covers'][404] ) ) {
					$thum_image = $gs_beh_single_shot['covers'][404];
				} else {
					$thum_image = $gs_beh_single_shot['covers']['max_808'];
				}

				if ( isset( $gs_beh_single_shot['covers']['original'] ) ) {

					$big_img = $gs_beh_single_shot['covers']['original'];
				}
				$result = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT beid FROM " . $table_name . "
                        WHERE beid = %d LIMIT 1",
						$beid
					)
				);


				if ( $wpdb->num_rows < 1 ) {
					$wpdb->insert(
						$table_name,
						array(

							'beid'       => $beid,
							'beusername' => $gs_beh_user,
							'name'       => $b_name,
							'url'        => $b_url,
							'bview'      => $bview,
							'blike'      => $blike,
							'bcomment'   => $bcomment,
							'bfields'    => $b_fields,
							'big_img'    => $big_img,
							'thum_image' => $thum_image,
							'time'       => current_time( 'mysql' ),

						)
					);
				}

			}
		endif;


		if ( count( $gs_behance_shots ) <= $project_count ) {
			$page                    = $page + 1;
			$be_meta[ $gs_beh_user ] = $page;
			update_option( $be_option_key, $be_meta );
			my_task_function();
		}
	}


}


register_deactivation_hook( __FILE__, 'bl_deactivate' );

function bl_deactivate() {
	$timestamp = wp_next_scheduled( 'gs_task_hook' );
	wp_unschedule_event( $timestamp, 'gs_task_hook' );
}


// Create gs_behance element for Visual Composer
add_action( 'vc_before_init', 'gsbehance_integrateWithVC' );
function gsbehance_integrateWithVC() {
	vc_map( array(
		'name'                    => __( 'GS Behance Portfolio ', 'gs-behance' ),
		'base'                    => 'gs_behance',
		'show_settings_on_create' => true,
		'icon'                    => GSBEH_FILES_URI . '/img/icon-128x128.png',
		'category'                => __( 'Content', 'gs-behance' ),
		'description'             => __( 'Best Responsive Behance plugin .', 'gs-behance' ),
		'params'                  => array(

			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Column', "gs-behance" ),
				'param_name' => 'column',
				'value'      => array(
					__( '3 Columns', 'gs-behance' ) => '3',
					__( '4 Columns', 'gs-behance' ) => '4',

				),
				//"description" => __( "For slider Only.", "gs-behance" ),
				"std"        => '3',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Theme', "gs-behance" ),
				'param_name' => 'theme',
				'value'      => array(
					__( 'Theme 1 (Projects)', 'gs-behance' )      => 'gs_beh_theme1',
					__( 'Theme 2 (Projects Stat)', 'gs-behance' ) => 'gs_beh_theme2',
					__( 'Theme 3 (Hover)', 'gs-behance' )         => 'gs_beh_theme3',
					__( 'Theme 4 (Popup)', 'gs-behance' )         => 'gs_beh_theme4',
					__( 'Theme 5 (Slider)', 'gs-behance' )        => 'gs_beh_theme5',
					__( 'Theme 6 (Profile)', 'gs-behance' )       => 'gs_beh_theme6',
					__( 'Theme 7 (Filter)', 'gs-behance' )        => 'gs_beh_theme7',

				),
				// "description" => __( "Enter description.", "gs-behance" ),
				"std"        => "gs_beh_theme1",
			),
			array(
				"type"       => "textfield",
				"class"      => "",
				"heading"    => __( "Total projects to display", "gs-behance" ),
				"param_name" => "count",
				"value"      => __( '7', "gs-behance" ),
				//"description" => __( "Enter description.", "gs-behance" )
			),
			array(
				"type"       => "textfield",
				"class"      => "",
				"heading"    => __( "Field", "gs-behance" ),
				"param_name" => "field",
				"value"      => __( '', "gs-behance" ),
				//"description" => __( "Enter description.", "gs-behance" )
			),
		),
	) );
}

//add_action( 'init',
//	function () {
//		$gs_beh_user      = gs_behance_getoption( 'gs_beh_user', 'gs_behance_settings', 'lazutina' );
//		$gs_beh_acc_token = gs_behance_getoption( 'gs_beh_acc_token', 'gs_behance_settings', '' );
//		//$gsbeh_url = "https://www.behance.net/v2/users/".$gs_beh_user."/projects?api_key=".$gs_beh_acc_token."&per_page=100";
//		$gsbeh_url = "https://www.behance.net/" . $gs_beh_user . "/projects?offset=40";
//		$projects  = behance_projects_scrapper( $gsbeh_url );
//		pri_dump( count( $projects ) );
//		pri_dump( $projects );
//		die();
//	} );


function pri_dump( $data ) {
	echo '<pre>';
	if ( is_object( $data ) || is_array( $data ) ) {
		print_r( $data );
	} else {
		var_dump( $data );
	}
	echo '</pre>';
}

class ElementorGsBehanceElement {
	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function init() {
		add_action( 'elementor/init', array( $this, 'gsbehance_widgets_registered' ) );
	}

	public function gsbehance_widgets_registered() {
		// We check if the Elementor plugin has been installed / activated.
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			// We look for any theme overrides for this custom Elementor element.
			// If no theme overrides are found we use the default one in this plugin.
			$widget_file   = GSBEH_FILES_DIR . '/includes/gs-behance-elementor-widget.php';
			$template_file = locate_template( $widget_file );
			if ( ! $template_file || ! is_readable( $template_file ) ) {
				$template_file = GSBEH_FILES_DIR . '/includes/gs-behance-elementor-widget.php';
			}
			if ( $template_file && is_readable( $template_file ) ) {
				require_once $template_file;
			}
		}

	}
}

ElementorGsBehanceElement::get_instance()->init();