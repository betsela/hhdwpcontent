<?php
/**Static Class runs and clear rules when Plugin is activated
 *
 * @package @package SeersCookieConsentBannerPrivacyPolicyPlugin
 * Plugin Name: Seers Cookie Consent Banner Privacy Policy GDPR CCPA
 * Description: Seers cookie consent management platform is trusted by thousands of businesses. Become GDPR, CCPA, ePrivacy and LGPD compliant in three clicks.
 * Version: 5.2.2
 */

class SeersCookieConsentPluginDeactivate {


    public  function deactivate()
    {
        $D_URL = get_site_url();
        if(isset($_POST["submit"])) {
            $body ='';
            $banner_did_not         = sanitize_text_field($_POST['banner_did_not']);
            $cookies_settings       = sanitize_text_field($_POST['cookies_settings']);
            $banner_not_match_theme = sanitize_text_field($_POST['banner_not_match_theme']);
            $broke_site             = sanitize_text_field($_POST['broke_site']);
            $found_btter_plugin     = sanitize_text_field($_POST['found_btter_plugin']);
            $plugin_name            = sanitize_text_field($_POST['plugin_name']);
            $other_checkBox         = sanitize_text_field($_POST['other']);
            $other_reason           = sanitize_text_field($_POST['other_reason']);
            $banner_not_language    = sanitize_text_field($_POST['banner_not_language']);
            $great_plugin           = sanitize_text_field($_POST['great_plugin']);

            $current_user = wp_get_current_user();
            $username     = $current_user->display_name;
            $useremail    = $current_user->user_email;
            $body .= '<table>';
            $body .=  '<tr>
                        <td colspan="2">Issues:</td>
                         </tr>';
                if($banner_not_language){
                    $body .=  '<tr>
                                    <td width="5%"></td>
                                   <td>'.$banner_not_language.'</td>
                                   </tr>';
                }
                if($banner_did_not){
                    $body .=  '<tr>
                                <td width="5%"></td>
                               <td>'.$banner_did_not.'</td>
                               </tr>';
                }
                if($cookies_settings){
                    $body .=  '<tr>
                                <td width="5%"></td>
                                 <td>'.$cookies_settings.'</td>
                               </tr>';
                }
        
               
                if(@$banner_not_match_theme) {
                    $body .= '<tr>
                                <td width="5%"></td>
                                <td>' . $banner_not_match_theme . '</td>
                              </tr>';
                }
                if(@$broke_site) {
                    $body .= '<tr>
                                <td width="5%"></td>
                                <td>' . $broke_site . '</td>
                             </tr>';
                }

                if(@$found_btter_plugin) {
                    $body .= '<tr>
                                <td width="10%">Plugin name:</td>
                                <td>' . $plugin_name . '</td>
                             </tr>';
                }
            if(@$great_plugin) {
                $body .= '<tr>
                                <td width="10%">Plugin name:</td>
                                <td>' . $great_plugin . '</td>
                             </tr>';
            }
            if(@$other_checkBox) {
                $body .= '<tr>
                                <td width="10%">Other Reason:</td>
                                <td>' . $other_reason . '</td>
                             </tr>';
            }



            $body .= '</table>';

             $message = $body;

            $to ="plugins.support@seersco.com";
            $subject = "Feedback from seersco plugin";
            $headers = 'From: '. $useremail . "\r\n" .
                'Reply-To: ' . $useremail . "\r\n";
            wp_mail($to, $subject, strip_tags($message), $headers);





            flush_rewrite_rules(false);
            deactivate_plugins( plugin_basename( __FILE__ ), true );
            flush_rewrite_rules();
            $url = admin_url( 'plugins.php?deactivate=true' );
            header( "Location: $url" );
            //die();

        }elseif(isset($_POST["not_interested"])) {

            $current_user = wp_get_current_user();
            $username     = $current_user->display_name;
            $useremail    = $current_user->user_email;
            $message = "not Interested";
            $to ="plugins.support@seersco.com";
            $subject = "Feedback from seersco plugin";
            $headers = 'From: '. $useremail . "\r\n" .
                'Reply-To: ' . $useremail . "\r\n";
            wp_mail($to, $subject, strip_tags($message), $headers);

            flush_rewrite_rules(false);
            deactivate_plugins( plugin_basename( __FILE__ ), true );
            flush_rewrite_rules();
            $url = admin_url( 'plugins.php?deactivate=true' );
            header( "Location: $url" );
        }else{
                echo '<style>

    .seers_ext_message{
        padding:10px;
        border: 1px dotted #c0c0c0;
        font-size:12px;
        margin: 10px 0px 10px 25px;

    }
    .seers_modalDialog {
        position: fixed;
        font-family: Arial, Helvetica, sans-serif;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 99999;
        opacity: 1;
        -webkit-transition: opacity 400ms ease-in;
        -moz-transition: opacity 400ms ease-in;
        transition: opacity 400ms ease-in;
        pointer-events: auto;
    }
    .seers_modalDialog:target {
        opacity: 0;
        pointer-events: none;
    }
    .seers_modalDialog .seers_modal-body {
        width: 500px !important;
        position: relative;
        margin: 3% auto;
        padding: 5px 20px 13px 20px;
        background: #fff;
        border-radius: 4px;
        -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        -moz-box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
    }
    .seers_modalDialog .seers_modal-body .close {
        background: #007cba;
        color: #FFFFFF;
        line-height: 25px;
        position: absolute;
        right: -10px;
        text-align: center;
        top: -10px;
        width: 30px;
        height: 30px;
        text-decoration: none;
        font-weight: bold;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 12px;
        -moz-box-shadow: 1px 1px 3px #000;
        -webkit-box-shadow: 1px 1px 3px #000;
        box-shadow: 1px 1px 3px #000;
        border-radius: 100%;
        font-size: 25px;
        font-weight: normal;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: -moz-box;
        display: -moz-flex;
        display: flex;
        -webkit-box-align: center;
        -moz-box-align: center;
        -webkit-box-pack: center;
        -moz-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        -moz-justify-content: center;
        -ms-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        -moz-flex-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .seers_modal-body p{
        border-bottom:1px solid #c0c0c0;
        padding-bottom: 10px;
        font-size: 14px;
        font-weight: 600;

    }
    .close:hover {
        background: #00d9ff;
    }
    .seers_modal-body form input[type="radio"]{
        margin: 0 0 15px 0;
    }

    .seers_modal-body form .btn-hol{

        display: flex;
        justify-content: center;
        align-items: center;
        margin:0 -7.5px;
    }
    .seers_modal-body form input.submit-skip{
        background: #306bf9;
        border-radius: 4px;
        color: #fff;
        font-size: 13px;
        padding: 10px;
        white-space: nowrap;
        flex-basis: 20%;
        margin: 7.5px;
        font-weight: 500;
        display: block;
        text-align: center;
        text-decoration: none;
        transition: all .3s ease;
        border: 0 !important;
        cursor:pointer;
    }
    .seers_modal-body form a.submit-skip{
        background: #ccc;
        border-radius: 4px;
        color: #000;
        font-size: 13px;
        padding: 10px;
        white-space: nowrap;
        flex-basis: 20%;
        margin: 7.5px;
        font-weight: 500;
        display: block;
        text-align: center;
        text-decoration: none;
        transition: all .3s ease;
        border: 0 !important;

    }
    .seers_modal-body form input.submit-skip:focus {
        outline: 0 !important;
        box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -webkit-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -moz-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -ms-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -o-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
    }
    .seers_modal-body form a.submit-skip:focus {
        outline: 0 !important;
        box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -webkit-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -moz-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -ms-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
        -o-box-shadow: 0 0 0 1px #fff, 0 0 0 3px #007cba;
    }

    .seers_modal-title{
        margin-bottom:0px !important;
    }

    .seers_form-group{
        font-size:12px;

    }

    .seers_form-group span{
        position: relative;
        display: inline-block;
        top: -2px;
    }
    .seers-full-width-textarea{
        width: 95%;
        margin-left: 5%;
    }

    .seers-bottom-margin{
        margin-bottom: 10px;
    }
    .seers_skipbtn input {
        background: #fff !important;
        color: #306bf9 !important;
        justify-content: end;
        display: block;
        float: right !important;
        position: relative;
        top: -7px;
        padding: 0px !important;
        font-size: 11px;
    }

</style>';
            ?>




            <div class="seers_modalDialog">

                <div class="seers_modal-body">
                    <h4 class="seers_modal-title">Quick Feedback</h4>
                    <p>If you have a moment, please let us know why you are deactivating:</p>
                    <form name="feedback" id="feedback" action="#" method="post">
                        <div class="seers_form-group">
                            <input type="checkbox" name="banner_not_language" id="banner_not_language" onclick="bannerLanguage()" class="askLanguage" value="The banner is not in the required language">
                            <span><?php esc_html_e("The banner is not in the required language", 'Seers'); ?></span>
                        </div>
                        <div id="language" style="display: none">
                            <div class="seers_ext_message">
                                The banner picks up your website language automatically. You can always sign-in on your Seers account  <a href="https://seersco.com/" target="_blank">(seersco.com)</a> and choose the language you like. See the video <a href="https://youtu.be/sMRZF0vClQU" target="_blank">here</a>.
                             </div>
                        </div>
                        <div class="seers_form-group">
                            <input type="checkbox" name="banner_did_not" id="banner_did_not" onclick="bannerDidNotApper()" value="Banner did not appear" class="bannerapper">
                            <span><?php esc_html_e("Banner did not appear", 'Seers'); ?></span>
                        </div>
                        <div id="banner_apper" style="display: none">
                            <div class="seers_ext_message">Most of the times the compatibility issue can be fixed very quickly. Please contact <a href="mailto:support@seersco.com">support@seersco.com</a></div>
                        </div>
                        <div class="seers_form-group">
                            <input type="checkbox" name="cookies_settings" id="cookies_settings" onclick="cookiesSettings()" value="Cookies are not showing in settings" class="cookies_shoing">
                            <span> <?php esc_html_e("Cookies are not showing in settings", 'Seers'); ?></span>
                        </div>
                        <div id="cookies" style="display: none">
                            <div class="seers_ext_message"> We are scanning your website and it can take up to 12 hours for Cookies to appear. In a very few cases scanner miss a cookie. This <a href="https://youtu.be/M0fCVw_3Hgw" target="_blank">video</a> explains how to add cookies manually.</div>
                        </div>
                        <div class="seers_form-group">
                            <input type="checkbox" name="banner_not_match_theme" id="banner_not_match_theme" onclick="bannerNotMatch()" value="The banner did not match website theme" class="baneer_theme">
                            <span><?php esc_html_e("The banner did not match website theme", 'Seers'); ?></span>
                        </div>
                        <div id="theme" style="display: none">
                            <div class="seers_ext_message">You can fully customize the banner. Please see the video <a href="https://youtu.be/FcpG0K4B3aI" target="_blank">here</a>.</div>
                        </div>
                        <div class="seers_form-group">
                            <input type="checkbox" name="broke_site" id="broke_site_check" onclick="brokeSite()" value="The plugin broke my site" class="broke_site">
                            <span> <?php esc_html_e("The plugin broke my site", 'Seers'); ?></span>
                        </div>
                        <div id="brokeSite" style="display: none">
                            <div class="seers_ext_message">Most of the times the compatibility issue can be fixed very quickly. Please contact <a href="mailto:support@seersco.com">support@seersco.com</a></div>
                        </div>
                        <div class="seers_form-group">
                            <input type="checkbox" name="found_btter_plugin" id="found_btter_plugin" class="askBetter" onclick="betterPlugin()"  value="I have found a better plugin">
                            <span><?php esc_html_e("I have found a better plugin", 'Seers'); ?></span>
                        </div>
                        <div  id="better" style="display: none">
                            <textarea class="seers-full-width-textarea" name="plugin_name" rows="5" cols="40" placeholder="Plugin name"></textarea>
                        </div>
                        <div class="seers_form-group">
                            <input type="checkbox" name="great_plugin" id="great_plugin" class="askgreate" onclick="pluginName()"  value="The plugin is great, but i need specific feature that you do not support.">
                            <span><?php esc_html_e("The plugin is great, but i need specific feature that you don't support.", 'Seers'); ?></span>
                        </div>
                        <div  id="great" style="display: none">
                            <textarea class="seers-full-width-textarea" name="plugin_great" id="plugin_great" rows="5" cols="40" placeholder="Banner customisation. "></textarea>
                        </div>

                        <div class="seers_form-group">
                            <input type="checkbox" name="other" id="othercheck" value="Other" class="askOther" onclick="showother();">
                            <span class="seers-bottom-margin"><?php esc_html_e("Other", 'Seers'); ?></span>
                        </div>
                        <div id="other" style="display: none">
                            <textarea class="seers-full-width-textarea"  name="other_reason" rows="5" cols="40" placeholder="Kindly tell us the reason so we can improve."></textarea>
                        </div>
                        <div class="btn-hol">
                            <input type="submit" value="Submit & Deactivate" name="submit" class="submit-skip">
                            <a href="<?php echo $D_URL . '/wp-admin/plugins.php?plugin_status=all&paged=1&s' ?>"  class="submit-skip">Cancel</a>


                        </div>

                        <div class="seers_skipbtn"><input type="submit" value="Skip & Deactivate" name="not_interested" class="submit-skip"></div>
                    </form>
                </div>
            </div>

            <script type="text/javascript">
                function showother()
                {
                    var checkBox = document.getElementById('othercheck');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('other').style.display='block';
                    }else{
                        document.getElementById('other').style.display='none';
                    }

                }
                function pluginName()
                {
                    var checkBox = document.getElementById('great_plugin');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('great').style.display='block';
                    }else{
                        document.getElementById('great').style.display='none';
                    }
                }

                function betterPlugin()
                {
                    var checkBox = document.getElementById('found_btter_plugin');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('better').style.display='block';
                    }else{
                        document.getElementById('better').style.display='none';
                    }
                }
                function brokeSite()
                {
                    var checkBox = document.getElementById('broke_site_check');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('brokeSite').style.display='block';
                    }else{
                        document.getElementById('brokeSite').style.display='none';
                    }
                }

                function bannerNotMatch()
                {
                    var checkBox = document.getElementById('banner_not_match_theme');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('theme').style.display='block';
                    }else{
                        document.getElementById('theme').style.display='none';
                    }
                }

                function cookiesSettings()
                {
                    var checkBox = document.getElementById('cookies_settings');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('cookies').style.display='block';
                    }else{
                        document.getElementById('cookies').style.display='none';
                    }
                }
                function bannerDidNotApper()
                {
                    var checkBox = document.getElementById('banner_did_not');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('banner_apper').style.display='block';
                    }else{
                        document.getElementById('banner_apper').style.display='none';
                    }
                }
                function bannerLanguage()
                {
                    var checkBox = document.getElementById('banner_not_language');
                    if(checkBox.checked == true)
                    {
                        document.getElementById('language').style.display='block';
                    }else{
                        document.getElementById('language').style.display='none';
                    }
                }

            </script>
            <?php
            exit;

        }


    }

}
