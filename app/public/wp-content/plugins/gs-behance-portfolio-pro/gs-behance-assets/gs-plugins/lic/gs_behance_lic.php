<?php

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
if( ! defined( 'GSAMDANICOM_STORE_URL' ) ) define( 'GSAMDANICOM_STORE_URL', 'https://www.gsplugins.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'GS_BEHANCE_ITEM_NAME', 'GS Behance Portfolio Plugin' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of the settings page for the license input to be displayed
define( 'GS_BEHANCE_LICENSE_PAGE', 'gs-behance-license' );
define( 'GS_BEHANCE_LICENSE_KEY', 'gs_behance_license_key' );
define( 'GS_BEHANCE_LICENSE_STATUS', 'gs_behance_license_status' );
define( 'GS_BEHANCE_LICENSE_DATA', 'gs_behance_license_data' );

if( !class_exists( 'EDD_SL_GSBEHANCE_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_GSBEHANCE_Plugin_Updater.php' );
}

function cb_gs_behance_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( GS_BEHANCE_LICENSE_KEY ) );

	// setup the updater
	$edd_updater = new EDD_SL_GSBEHANCE_Plugin_Updater( GSAMDANICOM_STORE_URL, GSBEHANCE_PLUGIN_FILE, array(
			'version' 	=> '2.0.10', 			// current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => GS_BEHANCE_ITEM_NAME, 	// name of this plugin
			'author' 	=> 'GS Plugins',  	// author of this plugin
			'beta'		=> false
		)
	);
}
add_action( 'admin_init', 'cb_gs_behance_plugin_updater', 0 );

function gs_behance_license_menu() {
	add_submenu_page( 'gsp-main', 'GS Behance Portfolio License', 'Behance License', 'manage_options', GS_BEHANCE_LICENSE_PAGE, 'gs_behance_license_page' );
}
add_action('admin_menu', 'gs_behance_license_menu');

function gs_behance_license_page() {
	$license = get_option( GS_BEHANCE_LICENSE_KEY );
	$status  = get_option( GS_BEHANCE_LICENSE_STATUS );
	?>
	<div class="wrap">
	<h2><?php _e('GS Behance Portfolio License Options'); ?></h2>
	<form method="post" action="<?php echo admin_url( 'admin.php?page=' . GS_BEHANCE_LICENSE_PAGE ) ?>">
	
		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row" valign="top">
					<?php _e('License Key'); ?>
				</th>
				<td>
					<input id="<?= GS_BEHANCE_LICENSE_KEY ?>" name="<?= GS_BEHANCE_LICENSE_KEY ?>" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
					<label class="description" for="<?= GS_BEHANCE_LICENSE_KEY ?>"><?php _e('Enter your license key'); ?></label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" valign="top">
					<?php _e('Activate License'); ?>
				</th>
				<td>
					<?php if( $status !== false && $status == 'valid' ) { ?>
						<span style="color:green;"><?php _e('active'); ?></span>
						<?php wp_nonce_field( 'edd_gsbehance_nonce', 'edd_gsbehance_nonce' ); ?>
						<input type="submit" class="button-secondary" name="gs_behance_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
					<?php } else {
						wp_nonce_field( 'edd_gsbehance_nonce', 'edd_gsbehance_nonce' ); ?>
						<input type="submit" class="button button-primary" name="gs_behance_license_activate" value="<?php _e('Activate License'); ?>"/>
					<?php } ?>
				</td>
			</tr>
			</tbody>
		</table>

	</form>
	<?php
}

function gsbehance_sanitize_license( $new ) {
	$old = get_option( GS_BEHANCE_LICENSE_KEY );
	if( $old != $new ) {
		delete_option( GS_BEHANCE_LICENSE_STATUS ); // new license has been entered, so must reactivate
		update_option( GS_BEHANCE_LICENSE_KEY, $new );
	}
	return $new;
}

function gsbehance_check_license() {
	if ( 'valid' != get_option( GS_BEHANCE_LICENSE_STATUS ) ) {
		if ( ( ! isset( $_GET['page'] ) or GS_BEHANCE_LICENSE_PAGE != $_GET['page'] ) )
			add_action( 'admin_notices', 'gsbehance_activate_notice' );
	}
}
add_action( 'admin_init', 'gsbehance_check_license' );

function gsbehance_activate_notice() {
	echo '<div class="error"><p>' .
	sprintf( __( '<b>GS Behance Portfolio</b> license needs to be activated.  %sActivate Now%s', 'gs-behance' ), '<a href="' . admin_url( 'admin.php?page=' . GS_BEHANCE_LICENSE_PAGE ) . '">', '</a>' ) .
	'</p></div>';
}

/************************************
 * this illustrates how to activate
 * a license key
 *************************************/

function gsbehance_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['gs_behance_license_activate'] ) ) {

		// run a quick security check
		if( ! check_admin_referer( 'edd_gsbehance_nonce', 'edd_gsbehance_nonce' ) )
			return; // get out if we didn't click the Activate button

		if ( ! current_user_can( 'manage_options' ) )
			return;

		if ( isset( $_POST[ GS_BEHANCE_LICENSE_KEY ] ) )
			gsbehance_sanitize_license( $_POST[ GS_BEHANCE_LICENSE_KEY ] );

		// retrieve the license from the database
		$license = trim( get_option( GS_BEHANCE_LICENSE_KEY ) );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( GS_BEHANCE_ITEM_NAME ), // the name of our product in EDD
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( GSAMDANICOM_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {

				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							__( 'Your license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'revoked' :

						$message = __( 'Your license key has been disabled.' );
						break;

					case 'missing' :

						$message = __( 'Invalid license.' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), GS_BEHANCE_ITEM_NAME );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.' );
						break;

					default :

						$message = __( 'An error occurred, please try again.' );
						break;
				}

			}

		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . GS_BEHANCE_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'gsbehance_sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		// $license_data->license will be either "valid" or "invalid"

		update_option( GS_BEHANCE_LICENSE_STATUS, $license_data->license );
		update_option( GS_BEHANCE_LICENSE_DATA, $license_data );

		wp_redirect( admin_url( 'admin.php?page=' . GS_BEHANCE_LICENSE_PAGE ) );
		exit();
	}
}
add_action('admin_init', 'gsbehance_activate_license');


function gsbehance_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['gs_behance_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'edd_gsbehance_nonce', 'edd_gsbehance_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( GS_BEHANCE_LICENSE_KEY ) );


		// data to send in our API request
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( GS_BEHANCE_ITEM_NAME ), // the name of our product in EDD
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( GSAMDANICOM_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

			$base_url = admin_url( 'admin.php?page=' . GS_BEHANCE_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'gsbehance_sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			delete_option( GS_BEHANCE_LICENSE_STATUS );
		}

		wp_redirect( admin_url( 'admin.php?page=' . GS_BEHANCE_LICENSE_PAGE ) );
		exit();
	}
}
add_action('admin_init', 'gsbehance_deactivate_license');

function gsbehance_check_license_still_valid() {

	global $wp_version;

	$check_option_key = 'gsbehance_check_option_key';

	if ( get_option( $check_option_key ) and get_option( $check_option_key ) > current_time( 'timestamp' ) )
		return;

	$license = trim( get_option( GS_BEHANCE_LICENSE_KEY ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( GS_BEHANCE_ITEM_NAME ),
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_post( GSAMDANICOM_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

	if ( is_wp_error( $response ) ) {
		update_option( $check_option_key, current_time( 'timestamp' ) + ( 60 * 60 * 2 ) );
		return;
	}

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	update_option( GS_BEHANCE_LICENSE_STATUS, $license_data->license );
	update_option( GS_BEHANCE_LICENSE_DATA, $license_data );

	update_option( $check_option_key, current_time( 'timestamp' ) + ( 60 * 60 * 24 ) );
}
add_action( 'admin_init', 'gsbehance_check_license_still_valid' );

function gsbehance_get_license_data( $key ) {
	$license_data = get_option( GS_BEHANCE_LICENSE_DATA );
	if ( is_object( $license_data ) and isset( $license_data->$key ) )
		return $license_data->$key;
	return false;
}

/**
 * This is a means of catching errors from the activation method above and displaying it to the customer
 */
function gsbehance_admin_notices() {
	if ( isset( $_GET['gsbehance_sl_activation'] ) && ! empty( $_GET['message'] ) ) {

		switch( $_GET['gsbehance_sl_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:
				// Developers can put a custom success message here for when activation is successful if they way.
				break;
		}
	}
}
add_action( 'admin_notices', 'gsbehance_admin_notices' );