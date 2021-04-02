<?php
/**
 * Register Theme Extension Options Page Tabs
 * 
 * @sinc 4.8
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly

global $avia_config, $avia_pages, $avia_elements;


$avia_pages[] = array(
			'slug'		=> 'avia_ext', 		
			'parent'	=> 'avia_ext', 
			'icon'		=> 'new/spanner-screwdriver-7@3x.png', 	
			'title'		=>  __( 'Theme Extensions', 'avia_framework' )
	);


