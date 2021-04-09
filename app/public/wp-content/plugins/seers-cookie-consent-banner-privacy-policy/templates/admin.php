<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"> -->
<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
if (isset($_SERVER['REQUEST_URI'])) {
    $S_URI = sanitize_text_field($_SERVER['REQUEST_URI']);
    if(get_option('SCCBPP_cookie_consent_url')!=''){
        $D_URL = get_option('SCCBPP_cookie_consent_url');
    }else{
        $D_URL = get_site_url();
    }
    if(get_option('SCCBPP_cookie_consent_email')!=''){
        $admin_Email = get_option('SCCBPP_cookie_consent_email');
    }else{
        $admin_Email = get_option('admin_email');
    }
}
?>
<!--tabs-->
<style>
    .seers-flex-container{
        display:flex;
        flex-direction:row;
        align-items:center;
        justify-content:space-between;
        padding: 5px 0px 15px 0px;
    }
    .seers-flex-item-1{
        flex-grow: 1;
    }
    .seers-flex-item-2{
        flex-grow: 2;
    }
    .seers-checkbox-terms{
        display:flex;
        flex-direction:column;
    }
    .seers-activate-button{
        display:flex;
        flex-direction:column;
    }
    .seers-select-btn.active{
        background-color:#6CC04A;
        border:0px solid !important;
        color:white !important;
    }
    #setting_message_success{
        color:green !important;
        margin-top: 0px;
        /*font-size:18px;*/
    }
    #setting_message_error{
        color:red !important;
        margin-top: 0px;
        /*font-size:18px;*/
    }
    #policy_message_success{
        color:green !important;
        /*font-size:18px;*/
    }
    #policy_message_error{
        color:red !important;
        /*font-size:18px;*/
    }
</style>

<div class="seers-wordpress-main">

    <div class="pc-tab">
        <input checked="checked" id="tab1" type="radio" name="pct" />
        <input id="tab2" type="radio" name="pct" />
        <input id="tab3" type="radio" name="pct" />
        <input id="tab4" type="radio" name="pct" />
        <nav>
            <ul class="tab-ul">
                <li class="tab1">
                    <label for="tab1">Activation</label>
                </li>
                <?php if (get_option('SCCBPP_cookie_consent_id') !='') {?>
                    <li class="tab2">
                        <label for="tab2">Settings</label>
                    </li>
                    <li class="tab3">
                        <label for="tab3">Policy</label>
                    </li>
                <?php } ?>
                <li class="tab4">
                    <label for="tab4">User Guide</label>
                </li>

            </ul>
        </nav>
        <section>
            <div class="tab1">
                <div class="seers-wordpress-plugin-hol">
                    <div class="seers-plugin-main-cont">
                        <div class="seers-content-col tile-style">
                            <form method="post" id="wp_plugin" action="<?php echo esc_url(str_replace('%7E', '~', $S_URI)); ?>">
                                <fieldset>
                                    <?php if (get_option('SCCBPP_cookie_consent_id') !='') {?>
                                        <div style="color:#0C9A9A;  font-family: Arial; font-size: 12px;"><?php __('Your Seers Cookie Consent banner is activated.','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?><?php esc_html_e('Your Seers Cookie Consent banner is activated.'); ?></div>
                                    <?php }else{?>
                                        <div style="color:#f00; font-family: Arial; font-size: 12px;"><?php __('Your Seers Cookie Consent Banner is NOT activated because','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?>  <?php if(get_option('SCCBPP_cookie_consent_msg')){
                                                esc_html_e(get_option('SCCBPP_cookie_consent_msg'));
                                            }?> </div>
                                    <?php } ?>
                                    <h1>Seers Cookie Consent Solution</h1>
                                    <label for="SCCBPP_cookie_consent_url"><span>URL</span>
                                        <input type="text" id="SCCBPP_cookie_consent_url" name="SCCBPP_cookie_consent_url" class="input-field"  value="<?php esc_html_e($D_URL);  ?>" readonly>
                                    </label>
                                    <label for="SCCBPP_cookie_consent_email"><span><?php echo __('Email','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?></span>
                                        <input type="text" id="SCCBPP_cookie_consent_email" name="SCCBPP_cookie_consent_email" class="input-field" value="<?php esc_html_e($admin_Email); ?>">
                                    </label>
                                    <div class="seers-flex-container">
                                    <?php if (get_option('SCCBPP_cookie_consent_id') !='') {?>
                                        <div class="seers-checkbox-terms">                                        
                                            <div class="seers-checkbox">
                                                <input type="checkbox" name="seers_term_condition"  id="seers_term_condition" value="terms" class="number" checked> <?php esc_html_e('I agree Seers','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?> <a href="https://seersco.com/terms-and-conditions.html"><?php echo __('Terms & Condition','Seers-Cookie-Consent-Banner-Privacy-Policy');?> </a> <?php echo __('and','Seers-Cookie-Consent-Banner-Privacy-Policy');?> <a href="https://seersco.com/privacy-policy.html"><?php echo __('Privacy Policy','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?></a>,
                                            </div>
                                            <div class="seers-checkbox">
                                                <input type="checkbox" name="seers_term_condition_url" id="seers_term_condition_url" value="sterms" class="number" checked> <?php esc_html_e('I agree Seers to use my email and url to create an account and power the cookie banner.','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?>
                                            </div>
                                        </div>
                                    <?php }else{?>
                                    <div class="seers-checkbox-terms"> 
                                        <div class="seers-checkbox">
                                            <input type="checkbox" name="seers_term_condition"  id="seers_term_condition" value="terms" class="number"> <?php esc_html_e('I agree Seers','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?> <a href="https://seersco.com/terms-and-conditions.html"><?php esc_html_e('Terms & Condition','Seers-Cookie-Consent-Banner-Privacy-Policy');?> </a> <?php esc_html_e('and','Seers-Cookie-Consent-Banner-Privacy-Policy');?> <a href="https://seersco.com/privacy-policy.html"><?php esc_html_e('Privacy Policy','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?></a>,
                                        </div>
                                        <div class="seers-checkbox">
                                            <input type="checkbox" name="seers_term_condition_url" id="seers_term_condition_url" value="sterms" class="number"> <?php esc_html_e('I agree Seers to use my email and url to create an account and power the cookie banner.','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="seers-activate-button"><input type="submit" name="SCCBPP_cookieid" id="SCCBPP_cookieid" disabled value="<?php esc_html_e('Activate','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?>" style="clear: both;" ></div>
                                    </div>
                                    <label for="SCCBPP_cookie_consent_id"> <span>Cookie ID</span>&nbsp; (<?php echo __('To get your Cookie ID click on Activate','Seers-Cookie-Consent-Banner-Privacy-Policy'); ?>)
                                        <input type="text" id="SCCBPP_cookie_consent_id" name="SCCBPP_cookie_consent_id" class="input-field"  value="<?php esc_html_e(get_option('SCCBPP_cookie_consent_id')); ?>" readonly>
                                    </label>
                                    <input name="SCCBPP_update_setting" type="hidden" value="<?php esc_html_e(wp_create_nonce('SCCBPP-cookie-consent')); ?>" />


                                </fieldset>
                            </form>
                        </div>
                        <div class="seers-content-col tile-style"> <h3 class="title-two">
                                Powering all your <br>
                                Privacy &amp; Data Security needs </h3>
                            <p>Gain access to an extensive range of GDPR, PECR, CCPA &amp; ePrivacy compliance tools, all
                                <br class="br-none"> designed to take the hassle out of complying with the new data protection regulations.</p>
                            <div class="seers-policies-hol">
                                <ul>
                                    <li>Policies Pack</li>
                                    <li>Templates Pack</li>
                                    <li>GDPR Staff eTraining</li>
                                    <li>Cookie Consent Management</li>
                                </ul>
                                <ul>
                                    <li>DPIA</li>
                                    <li>GDPR Audit</li>
                                    <li>Cyber Secure</li>
                                    <li>Subject Request Management</li>
                                </ul>
                            </div> <a href="https://seersco.com" target="_blank" class="btn btn-white-bg">START FREE</a> </div>
                    </div>
                    <div class="seers-plugin-sidebar-cont">
                        <div class="seers-content-col tile-style"> <h3 class="title-two">
                                Data Privacy &amp;
                                Compliance. Solved</h3>
                            <p>Trust worlds leading privacy and consent management platform to help companies comply with GDPR, PECR, CCPA and ePrivacy</p> <a href="https://seersco.com/price-plan" class="btn btn-green-bg">START PREMIUM TODAY</a> </div>
                        <div class="seers-content-col tile-style">
                            <h3 class="title-two">Seers Premium Plan</h3>
                            <ul class="branding">
                                <li class="text-white">Branding</li>
                                <li class="text-white">Multi Lingual</li>
                                <li class="text-white">Consent Log</li>
                                <li class="text-white">Cookie Policy</li>
                                <li class="text-white">Prior Consent</li>
                                <li class="text-white">6+ Design Layouts</li>
                                <li class="text-white">Customer Support</li>
                                <li class="text-white">Banner Customisation</li>
                                <li class="text-white">Cookie Declaration Table</li>
                            </ul> <a href="https://seersco.com/price-plan" class="btn btn-green-bg">START PREMIUM TODAY</a> </div>
                    </div>
                </div>
            </div>
            <!--Banner Setting tab-->
            <div class="tab2">

                <div class="seers-wordpress-plugin-hol seers-tabs-content seers-banner-setting">


                    <form name="banner_setting" id="banner_setting" method="post">
                        <!-- BannerSettings-->
                        <h1>Banner Settings</h1>
                        <div class="section-setting">
                            <!------------------------------------------------------->
                            <!--Banner:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Banner:</label></div>
                                <div class="seers-pr">
                                    <label class="toggle">
                                        <?php if(get_option('SCCBPP_cookie_consent_is_active')=='true' || get_option('SCCBPP_cookie_consent_is_active')==''){?>
                                            <input class="toggle-checkbox" type="checkbox" name="banner_check" id="banner_check" checked>
                                        <?php }else{ ?>
                                            <input class="toggle-checkbox" type="checkbox" name="banner_check" id="banner_check">
                                        <?php } ?>
                                        <div class="toggle-switch"></div>
                                    </label>
                                </div>
                            </div>
                            <!--Banner End-->
                            <!------------------------------------------------------->
                            <!--Cookies Expiry:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Cookies Expiry:</label></div>
                                <div class="seers-pr">
                                    <input  style="width: 24%;" class="seers-input" min="1" type="number" name="cookies_expiry" id="cookies_expiry" value="<?php if(get_option('SCCBPP_cookie_consent_cookies_expiry')!='') { esc_html_e(get_option('SCCBPP_cookie_consent_cookies_expiry')); }else{ esc_html_e("30"); } ?>">

                                </div>
                            </div>
                            <!--Cookies Expiry End-->
                            <!------------------------------------------------------->
                            <!--Language:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Language:</label></div>
                                <div class="seers-pr">
                                    <select style="width: 24%;" class="seers-input" id="cookies_lang" name="cookies_lang">
                                        <option value="en" lang="en" <?php if((get_option('SCCBPP_cookie_consent_lang')=='' || get_option('SCCBPP_cookie_consent_lang')=='en')){ echo "selected"; } ?> data-continue="Continue" data-installed="1">English (United States)</option>
                                        <option value="ar" lang="ar" <?php if(get_option('SCCBPP_cookie_consent_lang')=='ar'){ echo "selected"; } ?> data-continue="المتابعة">العربية</option>
                                        <option value="ary" lang="ar" <?php if(get_option('SCCBPP_cookie_consent_lang')=='ary'){ echo "selected"; } ?> data-continue="المتابعة">العربية المغربية</option>
                                        <option value="bg_BG" lang="bg" <?php if(get_option('SCCBPP_cookie_consent_lang')=='bg_BG'){ echo "selected"; } ?> data-continue="Напред">Български</option>
                                        <option value="cs_CZ" lang="cs" <?php if(get_option('SCCBPP_cookie_consent_lang')=='cs_CZ'){ echo "selected"; } ?> data-continue="Pokračovat">Čeština</option>
                                        <option value="da_DK" lang="da" <?php if(get_option('SCCBPP_cookie_consent_lang')=='da_DK'){ echo "selected"; } ?> data-continue="Fortsæt">Dansk</option>
                                        <option value="de_DE_formal" lang="de" <?php if(get_option('SCCBPP_cookie_consent_lang')=='de_DE_formal'){ echo "selected"; } ?> data-continue="Weiter">Deutsch (Sie)</option>
                                        <option value="de_CH" lang="de" <?php if(get_option('SCCBPP_cookie_consent_lang')=='de_CH'){ echo "selected"; } ?> data-continue="Weiter">Deutsch (Schweiz)</option>
                                        <option value="de_CH_informal" lang="de" <?php if(get_option('SCCBPP_cookie_consent_lang')=='de_CH_informal'){ echo "selected"; } ?> data-continue="Weiter">Deutsch (Schweiz, Du)</option>
                                        <option value="de_DE" lang="de" <?php if(get_option('SCCBPP_cookie_consent_lang')=='de_DE'){ echo "selected"; } ?> data-continue="Weiter">Deutsch</option>
                                        <option value="de_AT" lang="de" <?php if(get_option('SCCBPP_cookie_consent_lang')=='de_AT'){ echo "selected"; } ?> data-continue="Weiter">Deutsch (Österreich)</option>
                                        <option value="el" lang="el" <?php if(get_option('SCCBPP_cookie_consent_lang')=='el'){ echo "selected"; } ?> data-continue="Συνέχεια">Ελληνικά</option>
                                        <option value="en_CA" lang="en" <?php if(get_option('SCCBPP_cookie_consent_lang')=='en_CA'){ echo "selected"; } ?> data-continue="Continue">English (Canada)</option>
                                        <option value="en_ZA" lang="en" <?php if(get_option('SCCBPP_cookie_consent_lang')=='en_ZA'){ echo "selected"; } ?> data-continue="Continue">English (South Africa)</option>
                                        <option value="en_AU" lang="en" <?php if(get_option('SCCBPP_cookie_consent_lang')=='en_AU'){ echo "selected"; } ?> data-continue="Continue">English (Australia)</option>
                                        <option value="en_NZ" lang="en" <?php if(get_option('SCCBPP_cookie_consent_lang')=='en_NZ'){ echo "selected"; } ?> data-continue="Continue">English (New Zealand)</option>
                                        <option value="en_GB" lang="en" <?php if(get_option('SCCBPP_cookie_consent_lang')=='en_GB'){ echo "selected"; } ?> data-continue="Continue">English (UK)</option>
                                        <option value="es_PE" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_PE'){ echo "selected"; } ?> data-continue="Continuar">Español de Perú</option>
                                        <option value="es_ES" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_ES'){ echo "selected"; } ?> data-continue="Continuar">Español</option>
                                        <option value="es_MX" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_MX'){ echo "selected"; } ?> data-continue="Continuar">Español de México</option>
                                        <option value="es_CL" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_CL'){ echo "selected"; } ?> data-continue="Continuar">Español de Chile</option>
                                        <option value="es_CO" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_CO'){ echo "selected"; } ?> data-continue="Continuar">Español de Colombia</option>
                                        <option value="es_PR" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_PR'){ echo "selected"; } ?> data-continue="Continuar">Español de Puerto Rico</option>
                                        <option value="es_UY" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_UY'){ echo "selected"; } ?> data-continue="Continuar">Español de Uruguay</option>
                                        <option value="es_GT" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_GT'){ echo "selected"; } ?> data-continue="Continuar">Español de Guatemala</option>
                                        <option value="es_AR" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_AR'){ echo "selected"; } ?> data-continue="Continuar">Español de Argentina</option>
                                        <option value="es_VE" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_VE'){ echo "selected"; } ?> data-continue="Continuar">Español de Venezuela</option>
                                        <option value="es_CR" lang="es" <?php if(get_option('SCCBPP_cookie_consent_lang')=='es_CR'){ echo "selected"; } ?> data-continue="Continuar">Español de Costa Rica</option>
                                        <option value="et" lang="et" <?php if(get_option('SCCBPP_cookie_consent_lang')=='et'){ echo "selected"; } ?> data-continue="Jätka">Eesti</option>
                                        <option value="eu" lang="eu" <?php if(get_option('SCCBPP_cookie_consent_lang')=='eu'){ echo "selected"; } ?> data-continue="Jarraitu">Euskara</option>
                                        <option value="ga"  lang="ga" <?php if(get_option('SCCBPP_cookie_consent_lang')=='ga'){ echo "selected"; } ?> data-continue="Jarraitu">Irish</option>
                                        <option value="fr_BE" lang="fr" <?php if(get_option('SCCBPP_cookie_consent_lang')=='fr_BE'){ echo "selected"; } ?> data-continue="Continuer">Français de Belgique</option>
                                        <option value="fr_CA" lang="fr" <?php if(get_option('SCCBPP_cookie_consent_lang')=='fr_CA'){ echo "selected"; } ?> data-continue="Continuer">Français du Canada</option>
                                        <option value="fr_FR" lang="fr" <?php if(get_option('SCCBPP_cookie_consent_lang')=='fr_FR'){ echo "selected"; } ?> data-continue="Continuer">Français</option>
                                        <option value="gd" lang="gd" <?php if(get_option('SCCBPP_cookie_consent_lang')=='gd'){ echo "selected"; } ?> data-continue="Lean air adhart">Gàidhlig</option>
                                        <option value="hr" lang="hr" <?php if(get_option('SCCBPP_cookie_consent_lang')=='hr'){ echo "selected"; } ?> data-continue="Nastavi">Hrvatski</option>
                                        <option value="hu_HU" lang="hu" <?php if(get_option('SCCBPP_cookie_consent_lang')=='hu_HU'){ echo "selected"; } ?> data-continue="Folytatás">Magyar</option>
                                        <option value="it_IT" lang="it" <?php if(get_option('SCCBPP_cookie_consent_lang')=='it_IT'){ echo "selected"; } ?> data-continue="Continua">Italiano</option>
                                        <option value="lt_LT" lang="lt" <?php if(get_option('SCCBPP_cookie_consent_lang')=='lt_LT'){ echo "selected"; } ?> data-continue="Tęsti">Lietuvių kalba</option>
                                        <option value="lv" lang="lv" <?php if(get_option('SCCBPP_cookie_consent_lang')=='lv'){ echo "selected"; } ?> data-continue="Turpināt">Latviešu valoda</option>
                                        <option value="pl_PL" lang="pl" <?php if(get_option('SCCBPP_cookie_consent_lang')=='pl_PL'){ echo "selected"; } ?> data-continue="Kontynuuj">Polski</option>
                                        <option value="pt_AO" lang="pt" <?php if(get_option('SCCBPP_cookie_consent_lang')=='pt_AO'){ echo "selected"; } ?> data-continue="Continuar">Português de Angola</option>
                                        <option value="pt_BR" lang="pt" <?php if(get_option('SCCBPP_cookie_consent_lang')=='pt_BR'){ echo "selected"; } ?> data-continue="Continuar">Português do Brasil</option>
                                        <option value="pt_PT" lang="pt" <?php if(get_option('SCCBPP_cookie_consent_lang')=='pt_PT'){ echo "selected"; } ?> data-continue="Continuar">Português</option>
                                        <option value="pt_PT_ao90" lang="pt" <?php if(get_option('SCCBPP_cookie_consent_lang')=='pt_PT_ao90'){ echo "selected"; } ?> data-continue="Continuar">Português (AO90)</option>
                                        <option value="ro_RO" lang="ro" <?php if(get_option('SCCBPP_cookie_consent_lang')=='ro_RO'){ echo "selected"; } ?> data-continue="Continuă">Română</option>
                                        <option value="sk_SK" lang="sk" <?php if(get_option('SCCBPP_cookie_consent_lang')=='sk_SK'){ echo "selected"; } ?> data-continue="Pokračovať">Slovenčina</option>
                                        <option value="sl_SI" lang="sl" <?php if(get_option('SCCBPP_cookie_consent_lang')=='sl_SI'){ echo "selected"; } ?> data-continue="Nadaljuj">Slovenščina</option>
                                        <option value="sq" lang="sq" <?php if(get_option('SCCBPP_cookie_consent_lang')=='sq'){ echo "selected"; } ?> data-continue="Vazhdo">Shqip</option>
                                        <option value="sv_SE" lang="sv" <?php if(get_option('SCCBPP_cookie_consent_lang')=='sv_SE'){ echo "selected"; } ?> data-continue="Fortsätt">Svenska</option>
                                        <option value="tr_TR" lang="tr" <?php if(get_option('SCCBPP_cookie_consent_lang')=='tr_TR'){ echo "selected"; } ?> data-continue="Devam">Türkçe</option>
                                        <option value="uk" lang="uk" <?php if(get_option('SCCBPP_cookie_consent_lang')=='uk'){ echo "selected"; } ?> data-continue="Продовжити">Українська</option>
                                        <option value="zh_CN" lang="zh" <?php if(get_option('SCCBPP_cookie_consent_lang')=='zh_CN'){ echo "selected"; } ?> data-continue="继续">简体中文</option>
                                        <option value="zh_TW" lang="zh" <?php if(get_option('SCCBPP_cookie_consent_lang')=='zh_TW'){ echo "selected"; } ?> data-continue="繼續">繁體中文</option>
                                        <option value="zh_HK" lang="zh" <?php if(get_option('SCCBPP_cookie_consent_lang')=='zh_HK'){ echo "selected"; } ?> data-continue="繼續">香港中文版 </option>
                                    </select>
                                </div>
                            </div>
                            <!--Language: End-->
                            <!------------------------------------------------------->
                            <!--Show Badge-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Show Badge:</label></div>
                                <div class="seers-pr">
                                    <label class="toggle">
                                        <?php if(get_option('SCCBPP_cookie_consent_show_badge')=='true' || get_option('SCCBPP_cookie_consent_show_badge')==''){?>
                                            <input class="toggle-checkbox" type="checkbox" name="show_badge" id="show_badge" checked>
                                        <?php }else{ ?>
                                            <input class="toggle-checkbox" type="checkbox" name="show_badge" id="show_badge">
                                        <?php } ?>

                                        <div class="toggle-switch"></div>
                                    </label>
                                </div>
                            </div>
                            <!--Show Badge End-->
                        </div>
                        <!-- Banner Settings End-->

                        <!-- Visual Settings-->
                        <h1>Visual Settings</h1>
                        <div class="section-setting">
                            <!------------------------------------------------------->
                            <!--Title-->
<!--                            <div class="seers-panel seers-mb-30">-->
<!--                                <div class="seers-pl"><label class="seers-label">Title:</label></div>-->
<!--                                <div class="seers-color-width">-->
<!--                                    <div class="color-pick-hol">-->
<!--                                        <label class="seers-color-label">Title Colour:</label>-->
<!--                                        <input type="color" name="title_color" id="title_color" value="--><?php //if(get_option('SCCBPP_cookie_consent_title_text_color')!=''){ echo esc_html(__(get_option('SCCBPP_cookie_consent_title_text_color'))); }else{ echo "#3B6EF8"; }?><!--" class="seers-banner-custom-color">-->
<!--                                      <span class="seers-bg-icon"><img src="/images/color-icon.png"></span>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="seers-pr">-->
<!--                                    <input class="seers-input" type="text" name="title_text" id="title_text"  value="--><?php // if(get_option('SCCBPP_cookie_consent_title_text')!=''){ echo esc_html(__(get_option('SCCBPP_cookie_consent_title_text'))); }else{ echo "We use Cookies"; } ?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
                            <!--Title End-->
                            <!------------------------------------------------------->
                            <!--Body:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Banner Text:</label></div>
                                <div class="seers-color-width">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Colour:</label>
                                        <input type="color" name="body_color" id="body_color" value="<?php if(get_option('SCCBPP_cookie_consent_body_text_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_body_text_color')); }else{ esc_html_e("#000000"); }?>" class="seers-banner-custom-color">
                                    </div>
                                </div>
                                <div class="seers-pr">
                                    <textarea class="seers-textarea" rows="4" cols="50" name="body_text" id="body_text"><?php if(get_option('SCCBPP_cookie_consent_body_text')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_body_text')); }else{ esc_html_e( "We use cookies to ensure you get the best experience");} ?></textarea>
                                </div>
                            </div>
                                          <!------------------------------------------------------->
                            <!--Logo color:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Banner Background</label></div>
                                <div class="seers-color-width">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Colour:</label>
                                        <input type="color" name="banner_bg_color" id="banner_bg_color" value="<?php if(get_option('SCCBPP_cookie_consent_banner_bg_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_banner_bg_color')); }else{ echo esc_html_e("#FFFFFF"); }?>" class="seers-banner-custom-color">
                                    </div>
                                </div>
                            </div>
                            <!--logo color end:-->
                            <!------------------------------------------------------->
                            <!--Accept Button:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Accept Button:</label></div>
                                <div class="seers-color-width">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Text Colour:</label>
                                        <input type="color" name="agree_text_color" id="agree_text_color" value="<?php if(get_option('SCCBPP_cookie_consent_agree_text_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_agree_text_color')); }else{ echo esc_html_e("#FFFFFF"); }?>" class="seers-banner-custom-color">
                                    </div>
                                </div>
                                <div class="seers-pr">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Button Colour:</label>
                                        <input type="color" name="agree_btn_color" id="agree_btn_color" value="<?php if(get_option('SCCBPP_cookie_consent_agree_btn_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_agree_btn_color')); }else{ echo "#808080"; }?>" class="seers-banner-custom-color">
                                            <input class="seers-input btn-input" type="text" name="accept_btn_text" id="accept_btn_text" placeholder="Allow All" value="<?php if(get_option('SCCBPP_cookie_consent_accept_btn_text')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_accept_btn_text')); }else{ echo "Allow All"; }?>">
                                    </div>
                                    <button class="seers-btn" type="button" id="accept_all">Allow All</button>
                                </div>
                            </div>
                            <!--Accept Button:-->
                            <!------------------------------------------------------->
                            <!--Reject Button::-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Reject Button:</label></div>
                                <div class="seers-color-width">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Text Colour:</label>
                                        <input type="color" name="disagree_text_color" id="disagree_text_color" value="<?php if(get_option('SCCBPP_cookie_consent_disagree_text_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_disagree_text_color')); }else{ esc_html_e("#FFFFFF"); }?>" class="seers-banner-custom-color">
                                    </div>
                                </div>
                                <div class="seers-pr">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Button Colour:</label>
                                        <input type="color" name="disagree_btn_color" id="disagree_btn_color" value="<?php if(get_option('SCCBPP_cookie_consent_disagree_btn_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_disagree_btn_color')); }else{ echo "#808080"; }?>" class="seers-banner-custom-color">
                                        <input class="seers-input btn-input" type="text" name="reject_btn_text" id="reject_btn_text" placeholder="Disable All" value="<?php if(get_option('SCCBPP_cookie_consent_reject_btn_text')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_reject_btn_text')); }else{ echo "Disable All"; }?>">
                                    </div>
                                    <button class="seers-btn" type="button" id="reject_all">Disable All</button>
                                </div>
                            </div>
                            <!--Reject Button::-->
                            <!------------------------------------------------------->
                            <!--banner Settings Button:-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Setting Button:</label></div>
                                <div class="seers-color-width">
                                    <div class="color-pick-hol">
                                        <label class="seers-color-label">Text Colour:</label>
                                        <input type="color" name="preferences_text_color" id="preferences_text_color" value="<?php if(get_option('SCCBPP_cookie_consent_preferences_text_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_preferences_text_color')); }else{ esc_html_e("#000000"); }?>" class="seers-banner-custom-color">
                                    </div>
                                </div>
                                <div class="seers-pr">
                                    <div class="color-pick-hol">
<!--                                     <label class="seers-color-label">Button Colour:</label>-->
<!--                                     <input type="color" name="preferences_btn_color" id="preferences_btn_color" value="--><?php //if(get_option('SCCBPP_cookie_consent_preferences_btn_color')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_preferences_btn_color')); }else{ echo "#3B6EF8"; }?><!--" class="seers-banner-custom-color">-->
                                        <div class="seers-empty"></div>
                                     <input class="seers-input btn-input" type="text" name="setting_btn_text" id="setting_btn_text" placeholder="Setting" value="<?php if(get_option('SCCBPP_cookie_consent_setting_btn_text')!=''){ esc_html_e(get_option('SCCBPP_cookie_consent_setting_btn_text')); }else{ echo "Setting"; }?>" >
                                    </div>
                                    <button class="seers-btn seers-setting-btn" type="button" id="reject_all">Setting</button>
                                </div>
                            </div>
                            <!--banner Settings End-->
                            <!------------------------------------------------------->
                            <!--Fonts-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Fonts:</label></div>
                                <div class="seers-pr">
                                    <select class="seers-input fm" id="seers_fonts_fm" name="seers_fonts_fm">
                                        <option value="arial" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='arial' || get_option('SCCBPP_cookie_consent_font_style')==''){ echo "selected"; } ?>>Arial</option>
                                        <option value="cursive" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='cursive'){ echo "selected"; } ?>>Cursive</option>
                                        <option value="fantasy" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='fantasy'){ echo "selected"; } ?>>Fantasy</option>
                                        <option value="monospace" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='monospace'){ echo "selected"; } ?>>Monospace</option>
                                        <option value="sans-serif" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='sans-serif'){ echo "selected"; } ?>>Sans Serif</option>
                                        <option value="serif" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='serif'){ echo "selected"; } ?>>Serif</option>
                                        <option value="none" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='none'){ echo "selected"; } ?>>None</option>
                                        <option value="inherit" <?php if(get_option('SCCBPP_cookie_consent_font_style')=='inherit'){ echo "selected"; } ?>>Default</option>
                                    </select>
                                    <select class="seers-input fs" id="seers_fonts_fs" name="seers_fonts_fs">
                                        <option value="8" <?php if(get_option('SCCBPP_cookie_consent_font_size')=='8'){ echo "selected"; } ?>>8</option>
                                        <option value="10" <?php if(get_option('SCCBPP_cookie_consent_font_size')=='10'){ echo "selected"; } ?>>10</option>
                                        <option value="12" <?php if(get_option('SCCBPP_cookie_consent_font_size')=='12' || get_option('SCCBPP_cookie_consent_font_size')==''){ echo "selected"; } ?>>12</option>
                                        <option value="14" <?php if(get_option('SCCBPP_cookie_consent_font_size')=='14'){ echo "selected"; } ?>>14</option>
                                        <option value="16" <?php if(get_option('SCCBPP_cookie_consent_font_size')=='16'){ echo "selected"; } ?>>16</option>
                                    </select>
                                </div>
                            </div>
                            <!--Fonts End-->
                            <!------------------------------------------------------->
                            <!--Select Button-->
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Select Button:</label></div>
                                <div class="seers-pr btn-group" role="group">
                                    <button class="seers-select-btn btn-default <?php if(get_option('SCCBPP_cookie_consent_button_type')=='cbtn_default'){ echo "active"; }?>" type="button" id="cbtn_default">Default</button>
                                    <button class="seers-select-btn btn-flat <?php if(get_option('SCCBPP_cookie_consent_button_type')=='cbtn_flat'){ echo "active"; }?>" type="button" id="cbtn_flat">Flat</button>
                                    <button class="seers-select-btn btn-round <?php if(get_option('SCCBPP_cookie_consent_button_type')=='cbtn_rounded'){ echo "active"; }?>" type="button" id="cbtn_rounded">Rounded</button>
                                    <button class="seers-select-btn btn-stroke <?php if(get_option('SCCBPP_cookie_consent_button_type')=='cbtn_stroke'){ echo "active"; }?>" type="button" id="cbtn_stroke">Stroke</button>

                                </div>
                            </div>
                            <!--Select Button End-->
                            <!------------------------------------------------------->
                            <!--Preview buttons-->

                            <div class="seers-panel seers-mb-30">

                                <div class="seers-pl"></div>
                                <div class="seers-pr ">
                                    <p id="setting_message_success"></p>
                                    <p id="setting_message_error"></p>
                                    <div id="loader"></div>
                                    <div class="seers_btn_div">
                                        <a href="<?php echo $D_URL;  ?>" target="_blank" class="seers-btn-preview  s-save">PREVIEW</a>
                                        <button class="seers-btn-preview" type="button" id="setting_save">SAVE</button>
                                    </div>


                                </div>
                            </div>
                            <!--Preview buttons End-->
                        </div>
                        <!-- Visual Settings End-->
                    </form>
                </div>
            </div>
            <!--Banner Setting tab End-->

            <!--Policy -->
            <div class="tab3">
                <form name="policy" id="policy" method="post">
                    <div class="seers-wordpress-plugin-hol seers-tabs-content seers-banner-setting">
                        <div class="section-setting policysetting">
                            <p class="seers-notification">Please create cookies policy page and enter URL below.</p>
                            <p id="policy_message_success"></p>
                            <p id="policy_message_error"></p>
                            <div class="seers-panel seers-mb-30">
                                <div class="seers-pl"><label class="seers-label">Enable Policy:</label></div>
                                <div class="seers-pr">
                                    <label class="toggle">
                                        <?php if(get_option('SCCBPP_cookie_consent_enable_policy')=='true' ||  get_option('SCCBPP_cookie_consent_enable_policy')== true){?>
                                            <input class="toggle-checkbox" type="checkbox" name="enable_policy" id="enable_policy" checked>
                                        <?php }else{ ?>
                                            <input class="toggle-checkbox" type="checkbox" name="enable_policy" id="enable_policy">
                                        <?php } ?>

                                        <div class="toggle-switch"></div>
                                    </label>
                                </div>
                            </div>
                            <div class="seers-panel seers-mb-30" id="show-cookie-policy-url">
                                <div class="seers-pp"><label style="margin-top:0px !important;" class="seers-label">Cookie Policy and declaration URL:</label></div>
                                <div class="seers-pr">
                                    <input style="width:40% !important" class="seers-input" type="text" name="cookies_url" id="cookies_url" placeholder="Policy URL" value="<?php esc_html_e(get_option('SCCBPP_cookie_consent_policy_declaration_url')); ?>" >
                                </div>
                            </div>
                             <div class="seers-panel seers-mb-30" id="show-save-button">
                                <div class="seers-pp"><label class="seers-label"></label></div>
                                <div class="seers-pr">
                                    <button class="seers-btn-preview" id="cookie_policy" type="button">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Policy End-->

            <!--User Guide -->
            <div class="tab4">
                <div class="seers-wordpress-plugin-hol seers-tabs-content seers-banner-setting">
                    <div class="video-main-hol">
                        <div class="videobox">
                            <iframe width="100%" height="271" src="https://youtube.com/embed/_IDgrcHu3jc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <h3>How to <span class="colorblue">activate plugin</span></h3>
                        </div>
                        <div class="videobox">
                            <iframe width="100%" height="271" src="https://www.youtube.com/embed/9yvyAZtHf34" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <h3>How to <span class="colorblue">upgrade your package</h3>
                        </div>
			<div class="videobox">
                            <iframe width="100%" height="271" src="https://youtube.com/embed/c2NpWIVYEhE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <h3>How to <span class="colorblue">change banner settings</h3>
                        </div>

				
                    </div>
                    <div class="documentation">
                        <p>For more resources you can visit</p>
                        <button style="width: auto !important;" class="seers-btn-preview" type="button"> DOCUMENTATION </button>
                    </div>
                </div>
            </div>
            <!--User Guide End-->
        </section>
    </div>
</div>
<!--tabs end-->

<script type="text/javascript">
    $(document).ready(function(){
        
        if($("#enable_policy").prop('checked') == false){
            $("#show-cookie-policy-url").hide();
            // $("#show-save-button").hide();
        }

        $( ".number" ).on( "click", function() {
            if($( ".number:checked" ).length > 1)
            {
                $('#SCCBPP_cookieid').prop('disabled', false);
            }
            else
            {
                $('#SCCBPP_cookieid').prop('disabled', true);
            }
        });
        
        $('#enable_policy').change(function() {
            if($("#enable_policy").prop('checked') == true) {
                $("#show-cookie-policy-url").show();
                $( "#enable_policy").prop('checked', true);
                // cookies_url = $("#cookies_url").val();
                // $("#show-save-button").show();
            }
            else{
                $("#show-cookie-policy-url").hide();
                $( "#enable_policy").prop('checked', false);
                    // cookies_url = null;
                // $("#show-save-button").hide();
                //$('#enable_policy').val(!this.checked);
            }
        });

    $("#cookie_policy").click(function(e) {
        e.preventDefault();
        var enable_policy = $("#enable_policy").val();
        var cookies_url = $("#cookies_url").val();

        if ($("#enable_policy").is(':checked')) {
            enable_policy='true';
        } else {
            enable_policy='false';
        }
        console.log(enable_policy);
        console.log(cookies_url);      
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'cookies_policy',
                enable_policy:enable_policy,
                cookies_url: cookies_url
            },
            success: function(data) {
                $('#policy_message_success').html(data);
            },
            error: function(data) {
                $('#policy_message_error').html(data);
            }

        });
    });


    });
    
    /********** Tabs3 Ajax Response ***************/



    /*********** Tabs2 Post Ajax response. **************/
    $('#loader').hide();
    $("#setting_save").click(function(e) {
        e.preventDefault();
        //alert('we are here');
        //var selectedBtn = $('.active').attr('id');toggle_check
        var bannerVal = '';
        var show_badge ='';
        if ($("#banner_check").is(':checked')) {
            bannerVal='true';
        } else {
            bannerVal='false';
        }
        if ($("#show_badge").is(':checked')) {
            show_badge='true';
        } else {
            show_badge='false';
        }
        //alert($('#cookies_lang').val());
        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: 'JSON',
            data: {
                action: 'cookies_setting',
                banners: bannerVal,
                cookies_expiry:$('#cookies_expiry').val(),
                cookies_lang:$('#cookies_lang').val(),
                show_badge: show_badge,
                logo_bg_color:$('#logo_bg_color').val(),
                banner_bg_color:$('#banner_bg_color').val(),
                //title_color:$('#title_color').val(),
                //title_text:$('#title_text').val(),
                body_color:$('#body_color').val(),
                body_text: $('#body_text').val(),

                agree_btn_color:$('#agree_btn_color').val(),
                agree_text_color: $('#agree_text_color').val(),
                accept_btn_text: $('#accept_btn_text').val(),

                disagree_text_color: $('#disagree_text_color').val(),
                disagree_btn_color:$('#disagree_btn_color').val(),
                reject_btn_text:$('#reject_btn_text').val(),


                preferences_text_color:$('#preferences_text_color').val(),
                // preferences_btn_color:$('#preferences_btn_color').val(),
                setting_btn_text:$('#setting_btn_text').val(),

                seers_fonts_fm:$('#seers_fonts_fm').val(),
                seers_fonts_fs:$('#seers_fonts_fs').val(),
                selectedBtn:$('.active').attr('id'),


            },
            beforeSend: function(){
                $('#loader').show();
                $('#setting_save').prop('disabled', true);
               // $('#setting_save').prop('disabled', false);
            },
            complete: function(){
                $('#loader').hide();
                $('#setting_save').prop('disabled', false);
            },
            success: function(data) {
                $('#setting_message_success').html(data.resp_message);
                //alert(data.bodyText);
                $('#accept_btn_text').val(data.accept_btn_text);
                $('#reject_btn_text').val(data.reject_btn_text);
                $('#setting_btn_text').val(data.setting_btn_text);
                $('#body_text').html(data.bodyText);
                $('#setting_save').prop('disabled', false);

            },
            error: function(data) {
                $('#setting_message_error').html(data.resp_message);

            }
        });
    });


    /*** Accept Button actions Start ***/
    $("#accept_btn_color").change(function(){
        $("#accept_all").css('background', $(this).val());
    });

    $("#accept_btn_text_color").change(function(){
        $("#accept_all").css('color', $(this).val());
    });
    /*** Accept Button actions End ***/

    /*** Reject Button actions Start ***/
    $("#reject_btn_color").change(function(){
        $("#reject_all").css('background', $(this).val());
    });

    $("#reject_btn_text_color").change(function(){
        $("#reject_all").css('color', $(this).val());
    });
    /*** Accept Button actions End ***/
    /*** Prefrence Button actions Start ***/
    $("#setting_btn_color").change(function(){
        $("#preference").css('background', $(this).val());
    });

    $("#setting_btn_text_color").change(function(){
        $("#preference").css('color', $(this).val());
    });

    /*** Prefrence Button actions End ***/
    $('.btn-group button').on('click', function(){
        $(this).siblings().removeClass('active')
        $(this).addClass('active');
    })

</script>

<?php
if (isset($_POST['SCCBPP_cookieid'])) {
    if (!isset($_POST['SCCBPP_update_setting']) || !wp_verify_nonce(sanitize_text_field($_POST['SCCBPP_update_setting']), 'SCCBPP-cookie-consent')) {
        echo 'Sorry, your nonce did not verify.';
        return;
    }
//        if (isset($_POST['SCCBPP_cookie_consent_id'])) {
//            $cookieid = sanitize_text_field($_POST['SCCBPP_cookie_consent_id']);
//            update_option('SCCBPP_cookie_consent_id', $cookieid);
//        }
    if (isset($_POST['SCCBPP_cookie_consent_email'])) {
        $cookieEmail = sanitize_text_field($_POST['SCCBPP_cookie_consent_email']);
        update_option('SCCBPP_cookie_consent_email', $cookieEmail);
    }
    if (isset($_POST['SCCBPP_cookie_consent_url'])) {
        $cookieurl = sanitize_text_field($_POST['SCCBPP_cookie_consent_url']);
        update_option('SCCBPP_cookie_consent_url', $cookieurl);
    }
    return;
}