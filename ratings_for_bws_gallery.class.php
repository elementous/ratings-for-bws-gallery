<?php

class Elm_Ratings_For_BWS_Gallery {
	
	public function __construct() {
		
		add_action( 'admin_init', array( $this, 'dependencies' ) );
		
		// Unhook BWS Gallery template redirect
		remove_action( 'template_redirect', 'gllr_template_redirect' );
		
		// Add template redirect and include new templates
		add_action( 'template_redirect', array( $this, 'gllr_template_redirect' ), 100 );
		
	}
	
	public function dependencies() {
		
		if ( !defined( 'ELM_UR_VERSION' ) ) {
			add_action( 'admin_notices', array( $this, 'missing_rating_manager_warning' ) );
			
			return false;
		} else if ( ! function_exists( 'gllr_init' ) ) {
			add_action( 'admin_notices', array( $this, 'missing_bws_gallery_warning' ) );
			
			return false;
		}
		
	}
	
	/*
	 * Includes new template files with images rating from plugin or theme if exists.
	 *
	 * @global object $wp_query
	 *
	*/
	public function gllr_template_redirect() {	
	
		global $wp_query;
		
		$post_type = get_post_type();
		$file_exists_flag = false;
		
		$rb_plugin_path = ELM_RBWS_PLUGIN_PATH  . '/templates';
		$rb_theme_path = STYLESHEETPATH . '/elm-templates';
		
		if ( 'gallery' == $post_type && "" == $wp_query->query_vars["s"] && ( ! isset( $wp_query->query_vars["gallery_categories"] ) ) ) {
			
			if ( file_exists( $rb_theme_path . '/gallery-single-template.php' ) ) {
				$full_path = $rb_theme_path . '/gallery-single-template.php';
			} else {
				$full_path = $rb_plugin_path . '/gallery-single-template.php';
			}
			
			$include_flag = true;
			
		} elseif ( 'gallery' == $post_type && isset( $wp_query->query_vars["gallery_categories"] ) || basename( get_page_template() ) == 'gallery-template.php' ) {

			if ( file_exists( $rb_theme_path . '/gallery-template.php' ) ) {
				$full_path = $rb_theme_path . '/gallery-template.php';
			} else {
				$full_path = $rb_plugin_path . '/gallery-template.php';
			}
			
			$include_flag = true;
			
		}

		if ( $include_flag ) {		
			include( $full_path );
			exit();
		}
		
	}
	
	/*
	 * Missing Gallery by BestWebSoft plugin notification.
	 *
	*/
	public function missing_bws_gallery_warning() {
	?>
		<div class="message error"><p><?php printf(__( 'Ratings for BWS Gallery is enabled but not effective. It requires <a href="%s" target="_blank">%s</a> in order to work.', 'woocommerce-multilingual'), 'https://wordpress.org/plugins/gallery-plugin/', 'Gallery by BestWebSoft' ); ?></p></div>
	<?php
	}
	
	/*
	 * Missing Rating Manager plugin notification.
	 *
	*/
	public function missing_rating_manager_warning() {
	?>
		<div class="message error"><p><?php printf(__( 'Ratings for BWS Gallery is enabled but not effective. It requires <a href="%s" target="_blank">%s</a> in order to work.', 'woocommerce-multilingual'), 'https://www.elementous.com/product/premium-wordpress-plugins/rating-manager/', 'Rating Manager' ); ?></p></div>
	<?php
	}
	
	/*
	 * Install the plugin.
	 *
	*/
	public function install() {
		
		if ( get_option( 'elm_ratings_bws' ) != 'installed' ) {
			update_option( 'elm_ratings_bws', 'installed' );
			update_option( 'elm_ratings_bws_version', ELM_RBWS_VERSION );
		}
		
	}
	
}