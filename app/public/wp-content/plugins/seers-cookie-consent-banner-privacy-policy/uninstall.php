<?php

/**
* Trigger this file on Plugin uninstall
*
* @package SeersCookieConsentBannerPrivacyPolicyPlugin
*/

if ( ! defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

//clear Database stored Data



//Access the database via SQL
global $wpdb;
$prefix = $wpdb->prefix;
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_id'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_msg'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_url'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_email'"));
/*** Code added on 10-06-2012 ********/
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_policy_declaration_url'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_enable_policy'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_is_active'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_cookies_expiry'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_lang'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_show_badge'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_agree_btn_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_disagree_btn_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_preferences_btn_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_banner_bg_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_body_text_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_agree_text_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_disagree_text_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_preferences_text_color'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_body_text'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_accept_btn_text'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_reject_btn_text'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_setting_btn_text'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_font_style'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_font_size'"));
$wpdb->query($wpdb->prepare("DELETE FROM ".$prefix."options WHERE option_name = 'SCCBPP_cookie_consent_button_type'"));
