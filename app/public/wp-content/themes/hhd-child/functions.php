<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

add_filter( 'avf_google_heading_font', 'avia_add_heading_font');
function avia_add_heading_font($fonts)
{
$fonts['Open Sans'] = 'Open Sans:300,400,600,700,800,300italic,400italic,600italic';
return $fonts;
}

add_filter( 'avf_google_content_font', 'avia_add_content_font');
function avia_add_content_font($fonts)
{

$fonts['Open Sans'] = 'Open Sans:300,400,600,700,800,300italic,400italic,600italic';
return $fonts;
}

function modify_jquery() {
if (!is_admin()) {
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://code.jquery.com/jquery-1.11.3.min.js');
	wp_enqueue_script('jquery');
}
}
add_action('init', 'modify_jquery');