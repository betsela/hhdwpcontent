<?php
/**Static Class runs and clear rules when Plugin is activated
*
* @package SeersCookieConsentBannerPrivacyPolicyPlugin
* Plugin Name: Seers Cookie Consent Banner Privacy Policy GDPR CCPA
* Description: Seers cookie consent management platform is trusted by thousands of businesses. Become GDPR, CCPA, ePrivacy and LGPD compliant in three clicks.
* Version: 5.2.2
**/

class SeersCookieConsentPluginActivate {
	public static function activate() {
		flush_rewrite_rules();
	}
}
