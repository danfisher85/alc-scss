<?php
/**
 * Plugin Name: Alchemists SCSS Compiler
 * Plugin URI: https://github.com/danfisher85/alc-scss
 * Description: Compiles SCSS to CSS for Alchemists WP Theme.
 * Version: 1.0.2
 * Author: Dan Fisher
 * Author URI: https://themeforest.net/user/dan_fisher
 */


/*
 * 1. PLUGIN GLOBAL VARIABLES
 */

// Plugin Paths
if (!defined('DFSCSS_THEME_DIR'))
    define('DFSCSS_THEME_DIR', get_stylesheet_directory());

if (!defined('DFSCSS_PLUGIN_NAME'))
    define('DFSCSS_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('DFSCSS_PLUGIN_DIR'))
    define('DFSCSS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . DFSCSS_PLUGIN_NAME);

if (!defined('DFSCSS_PLUGIN_URL'))
    define('DFSCSS_PLUGIN_URL', WP_PLUGIN_URL . '/' . DFSCSS_PLUGIN_NAME);

// Plugin Version
if (!defined('DFSCSS_VERSION_KEY'))
    define('DFSCSS_VERSION_KEY', 'dfscss_version');

if (!defined('DFSCSS_VERSION_NUM'))
    define('DFSCSS_VERSION_NUM', '1.0.0');



/*
 * 2. REQUIRE DEPENDENCIES
 *
 *    scssphp - scss compiler
 */

include_once DFSCSS_PLUGIN_DIR . '/compiler/WP_SCSS_Compiler.php'; // SCSS Compiler (vendor)



/**
 * 3. ENQUEUE STYLES
 */
add_action( 'wp_enqueue_scripts', 'df_enqueue_styles', 20 );
function df_enqueue_styles() {

  // Main styles
	wp_enqueue_style( 'df-compiled', get_template_directory_uri() . '/sass/style-skin.scss', array( 'alchemists-style' ), DFSCSS_VERSION_NUM );

  // Woocommerce styles
  wp_enqueue_style( 'df-compiled-woocommerce', get_template_directory_uri() . '/sass/woocommerce/woocommerce-skin.scss', array( 'woocommerce' ), DFSCSS_VERSION_NUM );

  // Sportspress styles
  wp_enqueue_style( 'df-compiled-sportspress', get_template_directory_uri() . '/sass/sportspress-skin.scss', array( 'alchemists-sportspress' ), DFSCSS_VERSION_NUM );
}



/**
 * 4. PASS VARIABLES INTO COMPILER
 */
add_filter( 'wp_scss_variables', 'df_scss_vars', 10, 2 );
function df_scss_vars( $vars, $handle ) {

  $alchemists_data = get_option('alchemists_data');

	if ( ! is_array( $vars ) ) {
		$vars = array();
	}

	// Colors
	$vars['color-primary'] = isset( $alchemists_data['color-primary'] ) ? $alchemists_data['color-primary'] : '#ffdc11';
	$vars['color-primary-darken'] = isset( $alchemists_data['color-primary-darken'] ) ? $alchemists_data['color-primary-darken'] : '#ffcc00';
  $vars['color-dark'] = isset( $alchemists_data['color-dark'] ) ? $alchemists_data['color-dark'] : '#1e2024';
  $vars['color-dark-lighten'] = isset( $alchemists_data['color-dark-lighten'] ) ? $alchemists_data['color-dark-lighten'] : '#292c31';
  $vars['color-gray'] = isset( $alchemists_data['color-gray'] ) ? $alchemists_data['color-gray'] : '#9a9da2';
  $vars['color-2'] = isset( $alchemists_data['color-2'] ) ? $alchemists_data['color-2'] : '#31404b';
  $vars['color-3'] = isset( $alchemists_data['color-3'] ) ? $alchemists_data['color-3'] : '#ff7e1f';
  $vars['color-4'] = isset( $alchemists_data['color-4'] ) ? $alchemists_data['color-4'] : '#9a66ca';

  // Body Background
  $vars['body-bg-color'] = ( isset( $alchemists_data['alchemists__body-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__body-bg']['background-color'] )) ? $alchemists_data['alchemists__body-bg']['background-color'] : '#edeff4';

  // Header Background
  $vars['header-top-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-bg'] : $vars['color-dark-lighten'];
  $vars['header-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark'];
  $vars['header-secondary-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark'];
  $vars['header-primary-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) )  ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark-lighten'];

  // Footer Background
  $vars['footer-widgets-bg'] = ( isset( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] )) ? $alchemists_data['alchemists__footer-widgets-bg']['background-color'] : $vars['color-dark'];
  $vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : $vars['color-dark'];
  $vars['footer-secondary-side-bg'] = ( isset( $alchemists_data['alchemists__footer-side-decoration-bg'] ) && !empty( $alchemists_data['alchemists__footer-side-decoration-bg'] ) ) ? $alchemists_data['alchemists__footer-side-decoration-bg'] : $vars['color-primary'];


  // Typography

  // Body
  if ( $alchemists_data['alchemists__custom_body_font'] ) {
    $vars['font-family-base'] = isset( $alchemists_data['alchemists__typography-body']['font-family'] ) ? $alchemists_data['alchemists__typography-body']['font-family'] : 'Source Sans Pro, sans-serif';
    $vars['base-font-size'] = isset( $alchemists_data['alchemists__typography-body']['font-size'] ) ? $alchemists_data['alchemists__typography-body']['font-size'] : '15px';
    $vars['base-line-height'] = isset( $alchemists_data['alchemists__typography-body']['line-height'] ) ? $alchemists_data['alchemists__typography-body']['line-height'] : '26px';
    $vars['body-font-weight'] = isset( $alchemists_data['alchemists__typography-body']['font-weight'] ) ? $alchemists_data['alchemists__typography-body']['font-weight'] : '400';
    $vars['body-font-color'] = isset( $alchemists_data['alchemists__typography-body']['color'] ) ? $alchemists_data['alchemists__typography-body']['color'] : '#9a9da2';
  }


  if ( $alchemists_data['alchemists__custom_heading_font'] ) {

    // Font Family Accent
    $vars['font-family-accent'] = isset( $alchemists_data['font-family-accent']['font-family'] ) ? $alchemists_data['font-family-accent']['font-family'] : 'Montserrat';

    // Headings
    $vars['headings-font-family'] = isset( $alchemists_data['headings-typography']['font-family'] ) ? $alchemists_data['headings-typography']['font-family'] : 'Montserrat';
    $vars['headings-color'] = isset( $alchemists_data['headings-typography']['color'] ) ? $alchemists_data['headings-typography']['color'] : '#31404b';
  }


  // Preloader
  if ( $alchemists_data['alchemists__opt-custom_pageloader'] ) {

    $vars['preloader-bg'] = isset( $alchemists_data['alchemists__opt-preloader-bg'] ) ? $alchemists_data['alchemists__opt-preloader-bg'] : $vars['color-dark'];
    $vars['preloader-size'] = isset( $alchemists_data['alchemists__opt-preloader-size']['width'] ) ? $alchemists_data['alchemists__opt-preloader-size']['width'] : '32px';
    $vars['preloader-color'] = isset( $alchemists_data['alchemists__opt-preloader-color'] ) ? $alchemists_data['alchemists__opt-preloader-color'] : $vars['color-primary'];
    $vars['preloader-color-secondary'] = isset( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) ? $alchemists_data['alchemists__opt-preloader-color-secondary'] : 'rgba(255,255,255, 0.15)';
    $vars['preloader-spin-duration'] = isset( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) ? $alchemists_data['alchemists__opt-preloader-spin-duration'] . 's' : '0.8s';
  }

	return $vars;
}
