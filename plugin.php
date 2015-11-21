<?php
/*
  Plugin Name: Ratings for BWS Gallery
  Plugin URI: https://www.elementous.com
  Description: Adds compatibility beetween Ratings Manager and BWS Gallery plugin.
  Author: Elementous
  Author URI: https://www.elementous.com
  Version: 1.0.0
*/

define( 'ELM_RBWS_VERSION', '1.0.0' );
define( 'ELM_RBWS_PLUGIN_PATH', dirname( __FILE__ ) );
define( 'ELM_RBWS_PLUGIN_FOLDER', basename( ELM_RBWS_PLUGIN_PATH ) );
define( 'ELM_RBWS_PLUGIN_URL', plugins_url() . '/' . ELM_RBWS_PLUGIN_FOLDER );

include_once ELM_RBWS_PLUGIN_PATH . '/ratings_for_bws_gallery.class.php';

// Initiate plugin
$elm_ratings_for_bws = new Elm_Ratings_For_BWS_Gallery();

// Install
register_activation_hook( __FILE__, array( $elm_ratings_for_bws, 'install' ) );
