<?php

/**
 * Main File
 *
 * @package SeersCookieConsentBannerPrivacyPolicyPlugin
 */

/*
* Plugin Name: Seers Cookie Consent Banner Privacy Policy
* Plugin URI: https://seersco.com/wp-cookie-plugin
* Description: Seers cookie consent management platform is trusted by thousands of businesses. Become GDPR, CCPA, ePrivacy and LGPD compliant in three clicks.
* Version: 5.2.2
* Author: Seers
* Author URI: https://seersco.com/
* Text Domain: Seers-Cookie-Consent-Banner-Privacy-Policy
* Domain Path: /Languages
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
**/

/*
Copyright (C) 2020  Seers Group

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

defined('ABSPATH') || die('Sorry you cant access');


if (!class_exists('SCCBPP_WpCookie_Save')) {
    class SCCBPP_WpCookie_Save
    {

        public $plugin;

        public function __construct()
        {
            $this->plugin = plugin_basename(__FILE__);
        }


        public function register()
        {

            add_action('admin_menu', array($this, 'SCCBPP_page_admin_actions'), 30);
            add_filter("plugin_action_links_$this->plugin", array($this, 'seers_premium_upgrade_link'));
            add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
            add_action('wp_head', array($this, 'SCCBPP_theme_name_scripts'), 1);
            add_action('admin_notices', array($this, 'seers_author_admin_notice'));
            add_action( 'wp_enqueue_scripts', array($this,'seers_adding_styles'));

            add_action('wp_ajax_cookies_setting', array($this,'cookies_setting'));
            add_action('wp_ajax_nopriv_cookies_setting', array($this,'cookies_setting'));

            add_action('wp_ajax_cookies_policy', array($this,'cookies_policy'));
            add_action('wp_ajax_nopriv_cookies_policy', array($this,'cookies_policy'));
            wp_enqueue_script('script', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', __FILE__);

        }

        function seers_adding_styles() {
            wp_register_style('cookie-style', plugins_url('/css/cookie-style.css', __FILE__));
            wp_enqueue_style('cookie-style');
            wp_register_style('popup', plugins_url('/css/popup.css', __FILE__));
            wp_enqueue_style('popup');
        }

        function seers_author_admin_notice()
        {
            global $pagenow;
            if ($pagenow == 'plugins.php' && get_option('SCCBPP_cookie_consent_id') == '') {
                echo '<div class="notice notice-info is-dismissible" style=" padding: 15px 45px 15px 15px; display: -webkit-flex;  display: -moz-flex;  display: -ms-flex;
	display: -o-flex; display: flex; justify-content: flex-end; -ms-align-items: center;  align-items: center;  background:url(' . plugin_dir_url(dirname(__FILE__)) . 'seers-cookie-consent-banner-privacy-policy/images/icon.gif), linear-gradient( rgba(239, 250, 239, 0.4), rgba(239, 250, 239, 0.4)); background-position: left; background-repeat: no-repeat; background-position-x: 15px; background-size: contain;  border-radius: 7px;">
							<div class="inf-hol" style=" display: -webkit-flex; display: -moz-flex; display: -ms-flex; display: -o-flex;  display: flex; -ms-align-items: center;
	align-items: center; justify-content: space-between; width: 94%;">
								<p>To show the Seers cookie banner on your website, go to <b>Settings</b>.</p>
								<a href="admin.php?page=SCCBPP-cookie-consent" class="btn btn-blue-bg" style=" width: max-content;
			position: relative;
			background: #3B6EF8;
			text-decoration: none;
			color: #fff;
			display: inline-block;
			vertical-align: middle;
			-webkit-transform: translateZ(0);
			transform: translateZ(0);
			border: 1px solid transparent;
			-webkit-backface-visibility: hidden;
			backface-visibility: hidden;
			-moz-osx-font-smoothing: grayscale;
			position: relative;
			-webkit-transition-property: color;
			transition-property: color;
			-webkit-transition-duration: 0.3s;
			transition-duration: 0.3s;
			white-space: nowrap;
			font: 500 12px/1.6 \'Poppins\', sans-serif;
			padding: 7px 21px;
			border-radius: 4px;
			outline: none;
			margin: 0 0 0 15px;
			text-transform: capitalize;
			transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">Settings</a>
							</div>
						  
						</div>';
            }
        }

        public function settings_link($links)
        {
            $settings_link = array('<a href="admin.php?page=SCCBPP-cookie-consent">Settings</a>');
            return array_merge($settings_link, $links);
        }

        public function seers_premium_upgrade_link($links)
        {
            $seers_premium_upgrade_link = array('<a href="https://seersco.com/price-plan" target="_blank"><b>Upgrade Premium</b></a>');
            return array_merge($seers_premium_upgrade_link, $links);
        }

        public function SCCBPP_admin()
        {

            $cookie_consent_url = "";
            $cookie_consent_email = "";

            if (isset($_POST['SCCBPP_cookie_consent_url'])) {
                $cookie_consent_url = sanitize_text_field($_POST['SCCBPP_cookie_consent_url']);
            }
            if (isset($_POST['SCCBPP_cookie_consent_email'])) {
                $cookie_consent_email = sanitize_email($_POST['SCCBPP_cookie_consent_email']);
            }


            if (($cookie_consent_url != '') && ($cookie_consent_email != '')) {
                global $wpdb;
                $prefix = $wpdb->prefix;
                $update_cookie_consent_code = sanitize_text_field($_POST['SCCBPP_cookie_consent_id']);
                if ($update_cookie_consent_code != '') {
                    $query = $wpdb->prepare("SELECT * FROM " . $prefix . "options where option_name = 'SCCBPP_cookie_consent_id' ");
                    $result = $wpdb->get_row($query, ARRAY_A);
                    $alreadyKey = @$result['option_value'];
                    if ($alreadyKey) {
                        $query1 = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$update_cookie_consent_code' where option_name = 'SCCBPP_cookie_consent_id'");
                        $wpdb->query($query1);
                    }
                } else {
                    $postData = array(
                        'domain' => $cookie_consent_url,
                        'email' => $cookie_consent_email,
                        'secret' => '$2y$10$9ygTfodVBVM0XVCdyzEUK.0FIuLnJT0D42sIE6dIu9r/KY3XaXXyS',
                        'platform' => 'wordpress',
                        'lang' => get_locale(),
                    );
                    $request_headers = array(
                        'Content-Type' => 'application/json',
                        'Referer' => $cookie_consent_url,
                    );
                    $url = "https://seersco.com/api/save-domain-credentials";
                    $postdata = json_encode($postData);

                    $result = wp_remote_post( $url, array(
                            'method' => 'POST',
                            'redirection' => 5,
                            'httpversion' => '1.0',
                            'timeout'     => 45,
                            'sslverify' => false,
                            'headers' => $request_headers,
                            'body' => $postdata,
                            'cookies' => array()
                        )
                    );


                    $keyResponse = json_decode($result['body']);
////                    print_r($keyResponse);
//                    exit;
                    // print_r($keyResponse->key);

                    if ($result['response']['message'] != '') {
                        $message = $result['response']['message'];
                        $querymsg = $wpdb->prepare("SELECT * FROM " . $prefix . "options where option_name = 'SCCBPP_cookie_consent_msg' ");
                        $resultmsg = $wpdb->get_row($querymsg, ARRAY_A);
                        $alreadyMSG = @$resultmsg['option_value'];

                        if ($alreadyMSG != '') {
                            $query1 = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$message' where option_name = 'SCCBPP_cookie_consent_msg'");
                            $wpdb->query($query1);
                        } else {
                            $wpdb->insert($wpdb->prefix . 'options', array(
                                'option_name' => 'SCCBPP_cookie_consent_msg',
                                'option_value' => $result['response']['message'],
                            ));
                        }
                    }
                    //exit;
                    if ($keyResponse->key != '') {
                        $cookie_consent_code = $keyResponse->key;
                        $query = $wpdb->prepare("SELECT * FROM " . $prefix . "options where option_name = 'SCCBPP_cookie_consent_id' ");
                        $result = $wpdb->get_row($query, ARRAY_A);
                        $alreadyKey = @$result['option_value'];

                        if ($alreadyKey) {

                            $queryMsg = $wpdb->prepare("Update " . $prefix . "options SET option_value = '' where option_name = 'SCCBPP_cookie_consent_msg'");
                            $wpdb->query($queryMsg);

                            $query1 = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$cookie_consent_code' where option_name = 'SCCBPP_cookie_consent_id'");
                            $wpdb->query($query1);
                            $install_lang = get_locale();
                            $query2 = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$install_lang' where option_name = 'SCCBPP_cookie_consent_lang'");
                            $wpdb->query($query2);
                        } else {

                            $queryMsg = $wpdb->prepare("Update " . $prefix . "options SET option_value = '' where option_name = 'SCCBPP_cookie_consent_msg'");
                            $wpdb->query($queryMsg);

                            // $this->SCCBPP_theme_name_scripts( $cookie_consent_code);
                            $wpdb->insert($wpdb->prefix . 'options', array(
                                'option_name' => 'SCCBPP_cookie_consent_id',
                                'option_value' => $cookie_consent_code,
                            ));
                            $wpdb->insert($wpdb->prefix . 'options', array(
                                'option_name' => 'SCCBPP_cookie_consent_lang',
                                'option_value' => get_locale(),
                            ));
                        }
                    }
                }
                if ($cookie_consent_email != '') {

                    $querymsg = $wpdb->prepare("SELECT * FROM " . $prefix . "options where option_name = 'SCCBPP_cookie_consent_email' ");
                    $resultemail = $wpdb->get_row($querymsg, ARRAY_A);
                    $alreadyEmail = @$resultemail['option_value'];
                    if ($alreadyEmail) {
                        $updateEmail = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$cookie_consent_email' where option_name = 'SCCBPP_cookie_consent_email'");
                        $wpdb->query($query1);
                    } else {
                        $wpdb->insert($wpdb->prefix . 'options', array(
                            'option_name' => 'SCCBPP_cookie_consent_email',
                            'option_value' => $cookie_consent_email,
                        ));
                    }
                }
            } else {
                $cookie_consent_code = get_option('SCCBPP_cookie_consent_id');
                $cookie_consent_url = get_option('SCCBPP_cookie_consent_url');
                $cookie_consent_email = get_option('SCCBPP_cookie_consent_email');
            }

            wp_enqueue_style('style-name', plugins_url('/css/cookie-style.css', __FILE__));
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
        }

        function cookies_policy()
        {

            $cookie_consent_url = get_option('SCCBPP_cookie_consent_url');
            $cookie_consent_email = get_option('SCCBPP_cookie_consent_email');


            if (($cookie_consent_url != '') && ($cookie_consent_email != '')) {

                global $wpdb;
                $prefix = $wpdb->prefix;
                $enable_policy  =   sanitize_text_field($_POST['enable_policy']);
                // $enable_policy = $enable_policy == "on"? true: false;
                $cookies_policy =  sanitize_text_field($_POST['cookies_url']);

                
                
                $postData = array(
                    'domain' => $cookie_consent_url,
                    'email' => $cookie_consent_email,
                    'secret' => '$2y$10$9ygTfodVBVM0XVCdyzEUK.0FIuLnJT0D42sIE6dIu9r/KY3XaXXyS',
                    'platform' => 'wordpress',
                    'policy_url' => $cookies_policy,
                    'enable_policy' => $enable_policy
                );
                // echo var_dump($postData);
                // exit;

                

                $request_headers = array(
                    'Content-Type' => 'application/json',
                    'Referer' => $cookie_consent_url,
                );
//                print_r( $request_headers);
//                exit;
                $url = "https://seersco.com/api/update-policy-url";
                $postdata = json_encode($postData);
                $result = wp_remote_post( $url, array(
                        'method' => 'POST',
                        'redirection' => 5,
                        'httpversion' => '1.0',
                        'timeout'     => 45,
                        'sslverify' => false,
                        'headers' => $request_headers,
                        'body' => $postdata,
                        'cookies' => array()
                    )
                );

                $response = json_decode($result['body']);
                // echo var_dump($response);
                // exit;
                // echo var_dump($_POST['enable_policy']);
                // exit;

                if ($response->message == 'Policy URL has been updated successfully') {
                    // $queryEnablePolicy = $wpdb->prepare("SELECT * FROM " . $prefix . "options where option_name = 'SCCBPP_cookie_consent_enable_policy' ");
                    
                    // $resultEnablePolicy = $wpdb->get_row($queryEnablePolicy, ARRAY_A);
                    // $existEnablePolicy = @$resultEnablePolicy['option_value'];

                    


                    $existEnablePolicy = get_option('SCCBPP_cookie_consent_enable_policy');
                    

                    if ($existEnablePolicy != '') {
                        update_option('SCCBPP_cookie_consent_enable_policy', $enable_policy);
                        // $query2 = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$enable_policy' where option_name = 'SCCBPP_cookie_consent_enable_policy'");
                        // $wpdb->query($query2);
                    } else {
                        // echo var_dump($enable_policy);
                        // exit;
                        add_option('SCCBPP_cookie_consent_enable_policy', $enable_policy);
                        // $wpdb->insert($wpdb->prefix . 'options', array(
                        //     'option_name' => 'SCCBPP_cookie_consent_enable_policy',
                        //     'option_value' => $enable_policy,
                        // ));
                    }
                    // echo var_dump($enable_policy);
                    // exit;
                    if($enable_policy == "true" || $enable_policy == true ){

                       $existUrl = get_option('SCCBPP_cookie_consent_policy_declaration_url');
                        if ($existUrl != '') {
                            update_option('SCCBPP_cookie_consent_policy_declaration_url', $cookies_policy);
                        }else{
                            add_option('SCCBPP_cookie_consent_policy_declaration_url', $cookies_policy);
                        }

                        // $queryUrl = $wpdb->prepare("SELECT * FROM " . $prefix . "options where option_name = 'SCCBPP_cookie_consent_policy_declaration_url' ");
                    
                        // $resultUrl = $wpdb->get_row($queryUrl, ARRAY_A);
                        // $existUrl = @$resultUrl['option_value'];
    
                        // if ($existUrl != '') {
                        //     $query1 = $wpdb->prepare("Update " . $prefix . "options SET option_value = '$cookies_policy' where option_name = 'SCCBPP_cookie_consent_policy_declaration_url'");
                        //     $wpdb->query($query1);
                        // } else {
                        //     $wpdb->insert($wpdb->prefix . 'options', array(
                        //         'option_name' => 'SCCBPP_cookie_consent_policy_declaration_url',
                        //         'option_value' => $cookies_policy,
                        //     ));
                        // }
                        echo 'Cookies policy added successfully.';
                    }
                }else{
                    echo 'Some thing went wrong.';
                }
            }
            exit;

        }
        function cookies_setting()
        {


            $cookie_consent_url = get_option('SCCBPP_cookie_consent_url');
            $cookie_consent_email = get_option('SCCBPP_cookie_consent_email');

            if (($cookie_consent_url != '') && ($cookie_consent_email != '')) {
                global $wpdb;
                $prefix = $wpdb->prefix;
                $result ='';
                $postData = array(
                    'domain' => $cookie_consent_url,
                    'email' => $cookie_consent_email,
                    'secret' => '$2y$10$9ygTfodVBVM0XVCdyzEUK.0FIuLnJT0D42sIE6dIu9r/KY3XaXXyS',
                    'platform' => 'wordpress',

                    'agree_btn_color'=>sanitize_text_field($_POST['agree_btn_color']),
                    'disagree_btn_color'=>sanitize_text_field($_POST['disagree_btn_color']),
                    'preferences_btn_color'=>sanitize_text_field($_POST['agree_btn_color']),
                    'banner_bg_color'=>sanitize_text_field($_POST['banner_bg_color']),

                    'body_text_color'=>sanitize_text_field($_POST['body_color']),
                    'agree_text_color'=>sanitize_text_field($_POST['agree_text_color']),
                    'disagree_text_color'=>sanitize_text_field($_POST['disagree_text_color']),
                    'preferences_text_color'=>sanitize_text_field($_POST['preferences_text_color']),

                    'font_style'=>sanitize_text_field($_POST['seers_fonts_fm']),
                    'font_size'=>sanitize_text_field($_POST['seers_fonts_fs']),
                    'button_type'=>sanitize_text_field($_POST['selectedBtn']),

                    'is_active' => sanitize_text_field($_POST['banners']),
                    'show_badge'=>sanitize_text_field($_POST['show_badge']),
                    'cookies_expiry' => sanitize_text_field($_POST['cookies_expiry']),


                    //'logo_bg_color'=>sanitize_text_field($_POST['logo_bg_color']),
                    'lang'=>sanitize_text_field($_POST['cookies_lang']),

                    'body_text'=>sanitize_text_field($_POST['body_text']),
                    'accept_btn_text'=>sanitize_text_field($_POST['accept_btn_text']),
                    'reject_btn_text'=>sanitize_text_field($_POST['reject_btn_text']),
                    'setting_btn_text'=>sanitize_text_field($_POST['setting_btn_text']),
               );
//              print_r($postData);
//                exit;
//               echo  sanitize_text_field($_POST['setting_btn_text']);
//               exit;
                $request_headers = array(
                    'Content-Type' => 'application/json',
                    'Referer' => $cookie_consent_url,
                );


                $url = "https://seersco.com/api/update-banner-customization";
                $postdata = json_encode($postData);

                $result = wp_remote_post( $url, array(
                        'method' => 'POST',
                        'redirection' => 5,
                        'httpversion' => '1.0',
                        'timeout'     => 45,
                        'sslverify' => false,
                        'headers' => $request_headers,
                        'body' => $postdata,
                        'cookies' => array()
                    )
                );
                $response = json_decode($result['body']);
//                echo "<pre>";
//                print_r($response);
//                echo "<pre>";
//                exit;
                if($response->message=='Settings has been updated successfully'){

                    $setting_options = array(
                        'is_active' => sanitize_text_field($_POST['banners']),
                        'cookies_expiry' => sanitize_text_field($_POST['cookies_expiry']),
                        'lang'=>sanitize_text_field($_POST['cookies_lang']),
                        'show_badge'=>sanitize_text_field($_POST['show_badge']),

                        'agree_btn_color'=>sanitize_text_field($_POST['agree_btn_color']),
                        'disagree_btn_color'=>sanitize_text_field($_POST['disagree_btn_color']),
                        'preferences_btn_color'=>sanitize_text_field($_POST['agree_btn_color']),
                        'banner_bg_color'=>sanitize_text_field($_POST['banner_bg_color']),
                        'body_text_color'=>sanitize_text_field($_POST['body_text_color']),
                        'agree_text_color'=>sanitize_text_field($_POST['agree_text_color']),
                        'disagree_text_color'=>sanitize_text_field($_POST['disagree_text_color']),
                        'preferences_text_color'=>sanitize_text_field($_POST['preferences_text_color']),
                        'font_style'=>sanitize_text_field($_POST['seers_fonts_fm']),
                        'font_size'=>sanitize_text_field($_POST['seers_fonts_fs']),
                        'button_type'=>sanitize_text_field($_POST['selectedBtn']),
                        'lang'=>sanitize_text_field($_POST['lang']),
                        'body_text'=>sanitize_text_field($_POST['body_text']),
                        'accept_btn_text'=>sanitize_text_field($_POST['accept_btn_text']),
                        'reject_btn_text'=>sanitize_text_field($_POST['reject_btn_text']),
                        'setting_btn_text'=>sanitize_text_field($_POST['setting_btn_text']),
                    );

                    foreach( $setting_options as $key => $value ) {

                        if( $existing = get_option( 'SCCBPP_cookie_consent_' . $key ) ) {

                            $setting_options[$key] = $existing;
                            delete_option( 'SCCBPP_cookie_consent_' . $key );
                        }
                    }
//                    echo sanitize_text_field($_POST['setting_btn_text']);
//                    exit;
                    /*** Insert records here ******/
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_is_active',
                        'option_value' => sanitize_text_field($_POST['banners']),
                    ));

                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_cookies_expiry',
                        'option_value' => intval( sanitize_text_field($_POST['cookies_expiry'])),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_lang',
                        'option_value' => sanitize_text_field($_POST['cookies_lang']),
                    ));

                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_show_badge',
                        'option_value' => sanitize_text_field($_POST['show_badge']),
                    ));

                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_agree_btn_color',
                        'option_value' => sanitize_text_field($_POST['agree_btn_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_disagree_btn_color',
                        'option_value' => sanitize_text_field($_POST['disagree_btn_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_preferences_btn_color',
                        'option_value' => sanitize_text_field($_POST['agree_btn_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_banner_bg_color',
                        'option_value' => sanitize_text_field($_POST['banner_bg_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_body_text_color',
                        'option_value' => sanitize_text_field($_POST['body_text_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_agree_text_color',
                        'option_value' => sanitize_text_field($_POST['agree_text_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_disagree_text_color',
                        'option_value' => sanitize_text_field($_POST['disagree_text_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_preferences_text_color',
                        'option_value' => sanitize_text_field($_POST['preferences_text_color']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_body_text',
                        'option_value' => sanitize_text_field($_POST['body_text']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_accept_btn_text',
                        'option_value' => sanitize_text_field($_POST['accept_btn_text']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_reject_btn_text',
                        'option_value' => sanitize_text_field($_POST['reject_btn_text']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_setting_btn_text',
                        'option_value' => sanitize_text_field($_POST['setting_btn_text']),
                    ));
//                    $wpdb->insert($wpdb->prefix . 'options', array(
//                        'option_name' => 'SCCBPP_cookie_consent_setting_btn_text',
//                        'option_value' => sanitize_text_field($_POST['setting_btn_text']),
//                    ));

                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_font_style',
                        'option_value' => sanitize_text_field($_POST['seers_fonts_fm']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_font_size',
                        'option_value' => sanitize_text_field($_POST['seers_fonts_fs']),
                    ));
                    $wpdb->insert($wpdb->prefix . 'options', array(
                        'option_name' => 'SCCBPP_cookie_consent_button_type',
                        'option_value' => sanitize_text_field($_POST['selectedBtn']),
                    ));
                    //echo 'Settings has been updated successfully';
                    $result = array(
                                            'resp_message'=>$response->message,
                                            'accept_btn_text'=>$response->accept_btn_text,
                                            'reject_btn_text'=>$response->reject_btn_text,
                                            'setting_btn_text'=>$response->setting_btn_text,
                                            'bodyText'=>$response->body_text,
                                           );
                    echo  json_encode($result);

                }else{
                  //  echo 'Some thing went wronge.';
                    $result = array(
                        'resp_message'=>'Some thing went wronge.',
                      );
                    echo json_encode($result);
                }
                exit;
            }

        }
        public function SCCBPP_page_admin_actions()
        {
            add_menu_page('Cookie Consent', 'Cookie Consent', 'manage_options', 'SCCBPP-cookie-consent', array($this, 'SCCBPP_admin'), 'dashicons-shield', 110);
        }

        public function SCCBPP_theme_name_scripts()
        {
            $cookie_consent_code = get_option('SCCBPP_cookie_consent_id');
            $seers_Tag = '<script data-key="' . $cookie_consent_code . '" data-name="CookieXray" src="https://seersco.com/script/cb.js" type="text/javascript"></script>';
            echo wp_kses($seers_Tag, array('script' => array('data-key' => array(), 'data-name' => array(), 'src' => array(), 'type' => array(),)));
        }



    }


    load_plugin_textdomain('Seers-Cookie-Consent-Banner-Privacy-Policy', false, basename(dirname(__FILE__)) . '/languages/');

    $seersCookieConsentPlugin = new SCCBPP_WpCookie_Save();
    $seersCookieConsentPlugin->register();

    //activation

    require_once plugin_dir_path(__FILE__) . 'inc/seers-cookie-consent-plugin-activate.php';
    register_activation_hook(__FILE__, array('SeersCookieConsentPluginActivate', 'activate'));

    //deactivation

    require_once plugin_dir_path(__FILE__) . 'inc/seers-cookie-consent-plugin-deactivate.php';
    register_deactivation_hook(__FILE__, array('SeersCookieConsentPluginDeactivate','deactivate'));
    //register_deactivation_hook(__FILE__, 'deactivate');





}
