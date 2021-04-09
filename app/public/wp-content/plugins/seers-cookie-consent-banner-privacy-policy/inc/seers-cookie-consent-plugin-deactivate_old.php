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
            $banner_did_not         = @$_POST['banner_did_not'];
            $cookies_settings       = @$_POST['cookies_settings'];
            $banner_not_match_theme = @$_POST['banner_not_match_theme'];
            $broke_site             = @$_POST['broke_site'];
            $found_btter_plugin     = @$_POST['found_btter_plugin'];
            $plugin_name            = @$_POST['plugin_name'];
            $other_checkBox         = @$_POST['other'];
            $other_reason           = @$_POST['other_reason'];
            $banner_not_language    = @$_POST['banner_not_language'];
            $great_plugin           = @$_POST['great_plugin'];

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
                                <td>' . @$banner_not_match_theme . '</td>
                              </tr>';
            }
            if(@$broke_site) {
                $body .= '<tr>
                                <td width="5%"></td>
                                <td>' . @$broke_site . '</td>
                             </tr>';
            }

            if(@$found_btter_plugin) {
                $body .= '<tr>
                                <td width="10%">Plugin name:</td>
                                <td>' . @$plugin_name . '</td>
                             </tr>';
            }
            if(@$great_plugin) {
                $body .= '<tr>
                                <td width="10%">Plugin name:</td>
                                <td>' . @$great_plugin . '</td>
                             </tr>';
            }
            if(@$other_checkBox) {
                $body .= '<tr>
                                <td width="10%">Other Reason:</td>
                                <td>' . @$other_reason . '</td>
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

            ?>

            <style>
                .ext_message{
                    padding:10px;
                    border: 1px dotted #c0c0c0;
                    font-size:12px;
                    margin: 10px 0px 10px 25px;

                }
            </style>

            <link rel="stylesheet" href="<?php echo plugins_url('css/popup.css', dirname(__FILE__)); ?>">
            <div class="modalDialog">
                <div class="modal-body">

                    <h4 class="modal-title">Quick Feedback</h4>
                    <p>If you have a moment, please let us know why you are deactivating:</p>
                    <form name="feedback" id="feedback" action="#" method="post">
                        <div class="form-group">
                            <input type="checkbox" name="banner_not_language" class="askLanguage" value="The banner is not in the required language">
                            <span><?php esc_html_e("The banner is not in the required language", 'Seers'); ?></span>
                        </div>
                        <div id="language">
                            <div class="ext_message">
                                The banner picks up your website language automatically. You can always sign-in on your Seers account  <a href="https://seersco.com/" target="_blank">(seersco.com)</a> and choose the language you like. See the video <a href="https://youtu.be/sMRZF0vClQU" target="_blank">here</a>.
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="banner_did_not" value="Banner did not appear" class="bannerapper">
                            <span><?php esc_html_e("Banner did not appear", 'Seers'); ?></span>
                        </div>
                        <div id="banner_apper">
                            <div class="ext_message">Most of the times the compatibility issue can be fixed very quickly. Please contact <a href="mailto:support@seersco.com">support@seersco.com</a></div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="cookies_settings" value="Cookies are not showing in settings" class="cookies_shoing">
                            <span> <?php esc_html_e("Cookies are not showing in settings", 'Seers'); ?></span>
                        </div>
                        <div id="cookies">
                            <div class="ext_message"> We are scanning your website and it can take up to 12 hours for Cookies to appear. In a very few cases scanner miss a cookie. This <a href="https://youtu.be/M0fCVw_3Hgw" target="_blank">video</a> explains how to add cookies manually.</div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="banner_not_match_theme" value="The banner did not match website theme" class="baneer_theme">
                            <span><?php esc_html_e("The banner did not match website theme", 'Seers'); ?></span>
                        </div>
                        <div id="theme">
                            <div class="ext_message">You can fully customize the banner. Please see the video <a href="https://youtu.be/FcpG0K4B3aI" target="_blank">here</a>.</div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="broke_site" value="The plugin broke my site" class="broke_site">
                            <span> <?php esc_html_e("The plugin broke my site", 'Seers'); ?></span>
                        </div>
                        <div id="brokeSite">
                            <div class="ext_message">Most of the times the compatibility issue can be fixed very quickly. Please contact <a href="mailto:support@seersco.com">support@seersco.com</a></div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="found_btter_plugin" id="found_btter_plugin" class="askBetter"  value="I have found a better plugin">
                            <span><?php esc_html_e("I have found a better plugin", 'Seers'); ?></span>
                        </div>
                        <div  id="better">
                            <textarea class="full-width-textarea" name="plugin_name" rows="5" cols="40" placeholder="Plugin name"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="great_plugin" id="great_plugin" class="askgreate"  value="The plugin is greate, but i need specific feature that you do not support.">
                            <span><?php esc_html_e("The plugin is greate, but i need specific feature that you don't support.", 'Seers'); ?></span>
                        </div>
                        <div  id="great">
                            <textarea class="full-width-textarea" name="plugin_name" rows="5" cols="40" placeholder="Banner customisation. "></textarea>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="other" value="Other" class="askOther">
                            <span class="bottom-margin"><?php esc_html_e("Other", 'Seers'); ?></span>
                        </div>
                        <div class="other">
                            <textarea class="full-width-textarea"  name="other_reason" rows="5" cols="40" placeholder="Kindly tell us the reason so we can improve."></textarea>
                        </div>
                        <div class="btn-hol">
                            <input type="submit" value="Submit & Deactivate" name="submit" class="submit-skip">
                            <a href="<?php echo $D_URL . '/wp-admin/plugins.php?plugin_status=all&paged=1&s' ?>"  class="submit-skip">Cancel</a>


                        </div>

                        <div class="skipbtn"><input type="submit" value="Skip & Deactivate" name="not_interested" class="submit-skip"></div>
                    </form>
                </div>
            </div>
            <script src="<?php echo plugins_url('js/jquery.min.js', dirname(__FILE__)); ?>"></script>
            <script type="text/javascript">

                $(".other").hide();
                $(".askOther").click(function() {
                    if($(this).is(":checked")) {
                        $(".other").show();
                    } else {
                        $(".other").hide();
                    }
                });
                $("#better").hide();
                $(".askBetter").click(function() {
                    if($(this).is(":checked")) {
                        $("#better").show();
                    } else {
                        $("#better").hide();
                    }
                });
                $("#language").hide();
                $(".askLanguage").click(function() {
                    if($(this).is(":checked")) {
                        $("#language").show();
                    } else {
                        $("#language").hide();
                    }
                });
                $("#banner_apper").hide();
                $(".bannerapper").click(function() {
                    if($(this).is(":checked")) {
                        $("#banner_apper").show();
                    } else {
                        $("#banner_apper").hide();
                    }
                });
                $("#cookies").hide();
                $(".cookies_shoing").click(function() {
                    if($(this).is(":checked")) {
                        $("#cookies").show();
                    } else {
                        $("#cookies").hide();
                    }
                });
                $("#theme").hide();
                $(".baneer_theme").click(function() {
                    if($(this).is(":checked")) {
                        $("#theme").show();
                    } else {
                        $("#theme").hide();
                    }
                });
                $("#brokeSite").hide();
                $(".broke_site").click(function() {
                    if($(this).is(":checked")) {
                        $("#brokeSite").show();
                    } else {
                        $("#brokeSite").hide();
                    }
                });
                $("#great").hide();
                $(".askgreate").click(function() {
                    if($(this).is(":checked")) {
                        $("#great").show();
                    } else {
                        $("#great").hide();
                    }
                });



            </script>
            <?php
            exit;

        }


    }

}
