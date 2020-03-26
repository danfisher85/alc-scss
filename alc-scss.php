<?php
/**
 * Plugin Name: Alchemists SCSS Compiler
 * Plugin URI: https://github.com/danfisher85/alc-scss
 * Description: Compiles SCSS to CSS for Alchemists WP Theme.
 * Version: 4.2.0
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
		define('DFSCSS_VERSION_NUM', '3.0.5');



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

	$sport = 'basketball';

	if ( alchemists_sp_preset('soccer') ) {
		$sport = 'soccer';
	} elseif ( alchemists_sp_preset('football') ) {
		$sport = 'football';
	} elseif ( alchemists_sp_preset('esports') ) {
		$sport = 'esports';
	}

	// Check if language is RTL
	$alchemists_dir = '';
	if ( is_rtl() ) {
		$alchemists_dir = '-rtl';
	}

	// Main styles
	wp_enqueue_style( 'df-compiled', get_template_directory_uri() . '/sass/style-skin-' . $sport . $alchemists_dir . '.scss', array( 'alchemists-style' ), DFSCSS_VERSION_NUM );

	if ( class_exists( 'woocommerce' ) ) {
		// Woocommerce styles
		wp_enqueue_style( 'df-compiled-woocommerce', get_template_directory_uri() . '/sass/woocommerce/woocommerce-skin-' . $sport . '.scss', array( 'woocommerce' ), DFSCSS_VERSION_NUM );
	}

	if ( class_exists( 'SportsPress' ) ) {
		// Sportspress styles
		wp_enqueue_style( 'df-compiled-sportspress', get_template_directory_uri() . '/sass/sportspress-skin-' . $sport . $alchemists_dir .'.scss', array( 'alchemists-sportspress' ), DFSCSS_VERSION_NUM );
	}
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


	if ( alchemists_sp_preset('football') ) {

		/*
		 * American Football
		 */

		$card_colors = array(
			'card-bg'              => '#323150',
			'card-header-bg'       => '#383759',
			'card-subheader-bg'    => '#363555',
			'card-border-color'    => '#3c3b5b'
		);

		$colors = array(
			'color_primary'        => '#f92552',
			'color_primary_darken' => '#f92552',
			'color_dark'           => '#323150',
			'color_dark_lighten'   => '#383759',
			'color_gray'           => '#9e9caa',
			'color_2'              => '#3c3b5b',
			'color_2_dark'         => '#282840',
			'color_3'              => '#9e69ee',
			'color_4'              => '#3ffeca',
			'color_4_darken'       => '#0fe3ab',
		);

		// Colors
		$vars['color-primary']        = ( isset( $alchemists_data['color-primary'] ) && !empty( $alchemists_data['color-primary'] ) ) ? $alchemists_data['color-primary'] : $colors['color_primary'];

		$vars['color-primary-darken'] = ( isset( $alchemists_data['color-primary-darken'] ) && !empty( $alchemists_data['color-primary-darken'] ) ) ? $alchemists_data['color-primary-darken'] : $colors['color_primary_darken'];

		$vars['color-dark'] = ( isset( $alchemists_data['color-dark'] ) && !empty( $alchemists_data['color-dark'] ) )  ? $alchemists_data['color-dark'] : $colors['color_dark'];

		$vars['color-dark-lighten']   = ( isset( $alchemists_data['color-dark-lighten'] ) && !empty( $alchemists_data['color-dark-lighten'] ) ) ? $alchemists_data['color-dark-lighten'] : $colors['color_dark_lighten'];

		$vars['color-gray']           = ( isset( $alchemists_data['color-gray'] ) && !empty( $alchemists_data['color-gray'] ) ) ? $alchemists_data['color-gray'] :  $colors['color_gray'];

		$vars['color-2']              = ( isset( $alchemists_data['color-2'] ) && !empty( $alchemists_data['color-2'] ) ) ? $alchemists_data['color-2'] : $colors['color_2'];

		$vars['color-dark-2']         = ( isset( $alchemists_data['color-dark-2'] ) && !empty( $alchemists_data['color-dark-2'] ) )  ? $alchemists_data['color-dark-2'] : $colors['color_dark_2'];

		$vars['color-3']              = ( isset( $alchemists_data['color-3'] ) && !empty( $alchemists_data['color-3'] ) ) ? $alchemists_data['color-3'] : $colors['color_3'];

		$vars['color-4']              = ( isset( $alchemists_data['color-4'] ) && !empty( $alchemists_data['color-4'] ) ) ? $alchemists_data['color-4'] : $colors['color_4'];

		$vars['color-4-darken']       = ( isset( $alchemists_data['color-4-darken'] ) && !empty( $alchemists_data['color-4-darken'] ) ) ? $alchemists_data['color-4-darken'] : $colors['color_4_darken'];


		// Card
		$vars['card-bg'] = ( isset( $alchemists_data['alchemists__card-bg'] ) && !empty( $alchemists_data['alchemists__card-bg'] ) ) ? $alchemists_data['alchemists__card-bg'] : $card_colors['card-bg'];
		$vars['card-header-bg'] = ( isset( $alchemists_data['alchemists__card-header-bg'] ) && !empty( $alchemists_data['alchemists__card-header-bg'] ) ) ? $alchemists_data['alchemists__card-header-bg'] : $card_colors['card-header-bg'];
		$vars['card-subheader-bg'] = ( isset( $alchemists_data['alchemists__card-subheader-bg'] ) && !empty( $alchemists_data['alchemists__card-subheader-bg'] ) ) ? $alchemists_data['alchemists__card-subheader-bg'] : $card_colors['card-subheader-bg'];
		$vars['card-border-color'] = ( isset( $alchemists_data['alchemists__card-border-color'] ) && !empty( $alchemists_data['alchemists__card-border-color'] ) ) ? $alchemists_data['alchemists__card-border-color'] : $card_colors['card-border-color'];


		// Form
		$vars['input-bg'] = isset( $alchemists_data['alchemists__form-control']['regular'] ) && !empty( $alchemists_data['alchemists__form-control']['regular'] ) ? $alchemists_data['alchemists__form-control']['regular'] : $vars['color-dark-lighten'];
		$vars['input-bg-focus'] = isset( $alchemists_data['alchemists__form-control']['active'] ) && !empty( $alchemists_data['alchemists__form-control']['active'] ) ? $alchemists_data['alchemists__form-control']['active'] : $vars['input-bg'];

		$vars['input-border'] = isset( $alchemists_data['alchemists__form-control-border']['regular'] ) && !empty( $alchemists_data['alchemists__form-control-border']['regular'] ) ? $alchemists_data['alchemists__form-control-border']['regular'] : 'rgba(255,255,255,.05)';
		$vars['input-border-focus'] = isset( $alchemists_data['alchemists__form-control-border']['active'] ) && !empty( $alchemists_data['alchemists__form-control-border']['active'] ) ? $alchemists_data['alchemists__form-control-border']['active'] : $vars['color-3'];

		$vars['input-color'] = isset( $alchemists_data['alchemists__form-control-txt']['regular'] ) && !empty( $alchemists_data['alchemists__form-control-txt']['regular'] ) ? $alchemists_data['alchemists__form-control-txt']['regular'] : $vars['color-gray'];
		$vars['input-color-focus'] = isset( $alchemists_data['alchemists__form-control-txt']['active'] ) && !empty( $alchemists_data['alchemists__form-control-txt']['active'] ) ? $alchemists_data['alchemists__form-control-txt']['active'] : $vars['input-color'];

		$vars['input-color-placeholder'] = isset( $alchemists_data['alchemists__form-control-placeholder'] ) && !empty( $alchemists_data['alchemists__form-control-placeholder'] ) ? $alchemists_data['alchemists__form-control-placeholder'] : 'rgba(127,126,140,0.6)';


		// Table
		$table_colors = array(
			'table-bg'             => 'transparent',
			'table-bg-hover'       => $vars['color-dark-lighten'],
			'table-bg-active'      => $vars['color-dark-lighten'],
			'table-border-color'   => $vars['color-2'],
			'table-thead-bg-color' => $vars['card-subheader-bg'],
			'table-thead-color'    => '#fff',
			'table-highlight'      => '#fff',
		);

		$vars['table-bg'] = isset( $alchemists_data['alchemists__table-bg'] ) && !empty( $alchemists_data['alchemists__table-bg'] ) ? $alchemists_data['alchemists__table-bg'] : $table_colors['table-bg'];
		$vars['table-bg-hover'] = isset( $alchemists_data['alchemists__table-bg-hover'] ) && !empty( $alchemists_data['alchemists__table-bg-hover'] ) ? $alchemists_data['alchemists__table-bg-hover'] : $table_colors['table-bg-hover'];
		$vars['table-bg-active'] = isset( $alchemists_data['alchemists__table-bg-active'] ) && !empty( $alchemists_data['alchemists__table-bg-active'] ) ? $alchemists_data['alchemists__table-bg-active'] : $table_colors['table-bg-active'];
		$vars['table-border-color'] = isset( $alchemists_data['alchemists__table-border-color'] ) && !empty( $alchemists_data['alchemists__table-border-color'] ) ? $alchemists_data['alchemists__table-border-color'] : $table_colors['table-border-color'];
		$vars['table-thead-bg-color'] = isset( $alchemists_data['alchemists__table-thead-bg-color'] ) && !empty( $alchemists_data['alchemists__table-thead-bg-color'] ) ? $alchemists_data['alchemists__table-thead-bg-color'] : $table_colors['table-thead-bg-color'];
		$vars['table-thead-color'] = isset( $alchemists_data['alchemists__table-thead-color'] ) && !empty( $alchemists_data['alchemists__table-thead-color'] ) ? $alchemists_data['alchemists__table-thead-color'] : $table_colors['table-thead-color'];
		$vars['table-highlight'] = isset( $alchemists_data['alchemists__table-highlight-color'] ) && !empty( $alchemists_data['alchemists__table-highlight-color'] ) ? $alchemists_data['alchemists__table-highlight-color'] : $table_colors['table-highlight'];


		// Header Primary Height
		$vars['nav-height'] = ( isset( $alchemists_data['alchemists__header-primary-height'] ) && !empty( $alchemists_data['alchemists__header-primary-height'] )) ? $alchemists_data['alchemists__header-primary-height'] . 'px' : '62px';

		// Mobile Nav Width
		$nav_mobile_fullwidth = isset( $alchemists_data['alchemists__mobile-nav-fullwidth'] ) ? $alchemists_data['alchemists__mobile-nav-fullwidth'] : 0;

		if ( $nav_mobile_fullwidth == 1 ) {
			$vars['nav-mobile-width'] = '100%';
		} else {
			$vars['nav-mobile-width'] = ( isset( $alchemists_data['alchemists__mobile-nav-width'] ) && !empty( $alchemists_data['alchemists__mobile-nav-width'] )) ? $alchemists_data['alchemists__mobile-nav-width'] . 'px' : '270px';
		}

		// Body Background
		$vars['body-bg-color'] = ( isset( $alchemists_data['alchemists__body-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__body-bg']['background-color'] )) ? $alchemists_data['alchemists__body-bg']['background-color'] : '#1e202f';

		// Links Color
		$vars['link-color'] = ( isset( $alchemists_data['alchemists__link-color']['regular'] ) && !empty( $alchemists_data['alchemists__link-color']['regular'] )) ? $alchemists_data['alchemists__link-color']['regular'] : $vars['color-4-darken'];
		$vars['link-color-hover'] = ( isset( $alchemists_data['alchemists__link-color']['hover'] ) && !empty( $alchemists_data['alchemists__link-color']['hover'] )) ? $alchemists_data['alchemists__link-color']['hover'] : $vars['color-4-darken'];

		// Outline Button Color
		$vars['btn-o-default-color'] = ( isset( $alchemists_data['alchemists__button_outline_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_txt_color']['regular'] : '#fff';
		$vars['btn-o-default-color-hover'] = ( isset( $alchemists_data['alchemists__button_outline_txt_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_txt_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_txt_color']['hover'] : '#fff';

		// Outline Button Background Color
		$vars['btn-o-default-bg'] = ( isset( $alchemists_data['alchemists__button_outline_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_bg_color']['regular'] : 'transparent';
		$vars['btn-o-default-bg-hover'] = ( isset( $alchemists_data['alchemists__button_outline_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_bg_color']['hover'] : 'transparent';

		// Outline Button Border Color
		$vars['btn-o-default-border'] = ( isset( $alchemists_data['alchemists__button_outline_border_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_border_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_border_color']['regular'] : '#7f7e8c';
		$vars['btn-o-default-border-hover'] = ( isset( $alchemists_data['alchemists__button_outline_border_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_border_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_border_color']['hover'] : $vars['color-4'];


		// Default Button Color
		$vars['btn-default-color'] = ( isset( $alchemists_data['alchemists__button_default_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_default_txt_color']['regular'] : '#fff';

		// Default Button Background Color
		$vars['btn-default-bg'] = ( isset( $alchemists_data['alchemists__button_default_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_default_bg_color']['regular'] : '#938fa4';
		$vars['btn-default-hover'] = ( isset( $alchemists_data['alchemists__button_default_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_default_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_default_bg_color']['hover'] : $vars['color-primary'];


		// Default Alt Button Color
		$vars['btn-default-alt-color'] = ( isset( $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] : '#fff';

		// Default Alt Button Background Color
		$vars['btn-default-alt-bg'] = ( isset( $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] : $vars['color-2'];
		$vars['btn-default-alt-hover'] = ( isset( $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] : '#938fa4';


		// Button Primary Color
		$vars['btn-primary-color'] = ( isset( $alchemists_data['alchemists__button_primary_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_txt_color']['regular'] : '#fff';

		// Button Primary Background Color
		$vars['btn-primary-bg'] = ( isset( $alchemists_data['alchemists__button_primary_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_bg_color']['regular'] : $vars['color-2'];
		$vars['btn-primary-hover'] = ( isset( $alchemists_data['alchemists__button_primary_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_bg_color']['hover'] : $vars['color-primary'];


		// Button Primary Inverse Color
		$vars['btn-primary-inverse-color'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] : '#fff';

		// Button Primary Inverse Background Color
		$vars['btn-primary-inverse-bg'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] : $vars['color-primary'];
		$vars['btn-primary-inverse-hover'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] : $vars['color-primary-darken'];


		// Top Bar
		$vars['header-top-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-bg'] : $vars['color-dark'];
		$vars['top-bar-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-link-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-link-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-link-color'] : '#fff';
		$vars['top-bar-highlight'] = ( isset( $alchemists_data['alchemists__header-top-bar-highlight'] ) && !empty( $alchemists_data['alchemists__header-top-bar-highlight'] ) ) ? $alchemists_data['alchemists__header-top-bar-highlight'] : $vars['color-4'];
		$vars['top-bar-text-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-text-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-text-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-text-color'] : '#7f7e8c';
		$vars['top-bar-divider-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-divider-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-divider-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-divider-color'] : $vars['top-bar-text-color'];
		$vars['top-bar-dropdown-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-dropdown-bg'] : $vars['color-dark-lighten'];
		$vars['top-bar-dropdown-border'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] : 'rgba(255,255,255,.03)';
		$vars['top-bar-dropdown-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] : $vars['color-gray'];
		$vars['top-bar-dropdown-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] : $vars['color-4'];

		// Header Secondary Background
		$vars['header-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark-2'];
		$vars['header-secondary-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark-2'];

		// Header Primary Background
		$vars['header-primary-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) )  ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark'];
		$vars['header-primary-alt-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) )  ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark'];

		// Header Primary Links Color
		$vars['nav-font-color'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['regular'] : '#fff';

		$vars['nav-font-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['hover'] : '#fff';

		// Header Primary Link Border Color
		$vars['nav-active-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-border-color'] : $vars['color-primary'];

		// Header Primary Link Border Height
		$vars['nav-active-border-height'] = ( isset( $alchemists_data['alchemists__header-primary-border-height']['height'] ) && !empty( $alchemists_data['alchemists__header-primary-border-height']['height'] ) )  ? $alchemists_data['alchemists__header-primary-border-height']['height'] : '4px';

		// Header Submenu Background Color
		$vars['nav-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-bg'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-bg'] : $vars['color-dark-lighten'];

		// Header Submenu Border Color
		$vars['nav-sub-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-border-color'] : $vars['color-2'];

		// Header Submenu Link Color
		$vars['nav-sub-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] : '#fff';
		$vars['nav-sub-hover-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] : $vars['color-4'];

		// Header Submenu Caret Color
		$vars['nav-sub-caret-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) ) ? $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] : '#fff';

		// Megamenu Text Color
		$vars['nav-sub-megamenu-txt-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) ) ? $alchemists_data['alchemists__header-primary-megamenu-txt-color'] : $vars['color-gray'];

		// Megamenu Link Color
		$vars['nav-sub-megamenu-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] : $vars['color-gray'];
		$vars['nav-sub-megamenu-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] : $vars['color-4'];

		// Megamenu Widget Meta Links Color
		$vars['nav-sub-megamenu-meta-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] : $vars['color-gray'];
		$vars['nav-sub-megamenu-meta-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] : $vars['color-gray'];

		// Megamenu Title Color
		$vars['nav-sub-megamenu-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-title-color'] : '#fff';
	
		// Megamenu Post Title Color
		$vars['nav-sub-megamenu-post-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] : '#fff';


		// Social Link Color
		$vars['header-social-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-social-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-social-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-social-link-color']['regular'] : '#fff';
		$vars['header-social-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-social-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-social-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-social-link-color']['hover'] : $colors['color_primary'];
		

		// Mobile Nav Background Color
		$vars['nav-mobile-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-nav-bg'] : $vars['color-dark'];

		// Mobile Nav Burger Menu Color
		$vars['nav-mobile-burger-icon'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] : '#fff';

		// Header Mobile Background Color
		$vars['header-mobile-bg'] = ( isset( $alchemists_data['alchemists__mobile-header-bg'] ) && !empty( $alchemists_data['alchemists__mobile-header-bg'] ) )  ? $alchemists_data['alchemists__mobile-header-bg'] : $vars['color-dark-2'];

		// Mobile Nav Links Color
		$vars['nav-mobile-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-link-color'] : '#fff';

		// Mobile Nav Links Color
		$vars['nav-mobile-border'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-border-color'] : $vars['color-dark-lighten'];

		// Mobile Nav Submenu Background Color
		$vars['nav-mobile-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-sub-bg'] : $vars['color-dark-lighten'];

		// Mobile Nav Submenu Links Color
		$vars['nav-mobile-sub-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] : $vars['color-gray'];


		// Header Info Block
		$vars['header-info-block-color'] = ( isset( $alchemists_data['alchemists__header-info-block-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-color'] ) )  ? $alchemists_data['alchemists__header-info-block-color'] : $vars['color-4'];
			
		$vars['header-info-block-cart-sum-color'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color'] : $vars['color-4'];

		$vars['header-info-block-title-color'] = ( isset( $alchemists_data['alchemists__header-info-block-title-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-title-color'] ) )  ? $alchemists_data['alchemists__header-info-block-title-color'] : '#fff';

		$vars['header-info-block-cart-sum-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] : $vars['color-4'];

		$vars['header-info-block-link-color'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['regular'] : '#7f7e8c';

		$vars['header-info-block-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['hover'] : '#fff';

		$vars['header-info-block-link-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] : '#7f7e8c';

		$vars['header-info-block-link-color-mobile-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] : '#fff';


		// Search Form

		// background color - desktop
		$vars['header-search-input-bg'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] : $vars['color-dark-2'];
		$vars['header-search-input-bg-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] : $vars['color-dark-2'];

		// border color - desktop
		$vars['header-search-input-border'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] : $vars['color-dark-2'];
		$vars['header-search-input-border-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-border']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-border']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-border']['active'] : $vars['color-dark-2'];

		// text color - desktop
		$vars['header-search-input-txt'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] : 'rgba(127,126,140,0.6)';
		$vars['header-search-input-txt-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] : '#fff';

		// submit icon color - desktop
		$vars['header-search-icon'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] : '#fff';
		$vars['header-search-icon-hover'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] : '#fff';

		// background color - mobile
		$vars['header-search-input-bg-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] : $vars['color-dark'];
		$vars['header-search-input-bg-focus-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] : $vars['color-dark-lighten'];

		// border color - mobile
		$vars['header-search-input-border-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] : $vars['color-dark'];
		$vars['header-search-input-border-focus-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-border']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-border']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-border']['active'] : $vars['color-dark-lighten'];

		// text color - mobile
		$vars['header-search-input-txt-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] : 'rgba(127,126,140,0.6)';
		$vars['header-search-input-txt-mobile-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] : '#fff';

		// submit icon color - mobile
		$vars['header-search-icon-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] : '#fff';
		$vars['header-search-icon-mobile-active'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] : '#fff';

		// submit trigger icon - color
		$vars['header-search-icon-trigger-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] : '#fff';

		// Content Filter Colors
		$vars['content-filter-color'] = ( isset( $alchemists_data['alchemists__content-content-filter']['regular'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['regular'] )) ? $alchemists_data['alchemists__content-content-filter']['regular'] : '#7f7e8c'; // done
		$vars['content-filter-color-hover'] = ( isset( $alchemists_data['alchemists__content-content-filter']['hover'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['hover'] )) ? $alchemists_data['alchemists__content-content-filter']['hover'] : '#fff'; // done
		$vars['content-filter-color-active'] = ( isset( $alchemists_data['alchemists__content-content-filter']['active'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['active'] )) ? $alchemists_data['alchemists__content-content-filter']['active'] : '#fff'; // done
		

		// Blog Categories Group 1
		$vars['post-category-1'] = ( isset( $alchemists_data['alchemists__blog-cat-group-1'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-1'] ) )  ? $alchemists_data['alchemists__blog-cat-group-1'] : $vars['color-primary'];
		// Blog Categories Group 2
		$vars['post-category-2'] = ( isset( $alchemists_data['alchemists__blog-cat-group-2'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-2'] ) )  ? $alchemists_data['alchemists__blog-cat-group-2'] : $vars['color-3'];
		// Blog Categories Group 3
		$vars['post-category-3'] = ( isset( $alchemists_data['alchemists__blog-cat-group-3'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-3'] ) )  ? $alchemists_data['alchemists__blog-cat-group-3'] : $vars['color-4-darken'];
		// Blog Categories Group 4
		$vars['post-category-4'] = ( isset( $alchemists_data['alchemists__blog-cat-group-4'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-4'] ) )  ? $alchemists_data['alchemists__blog-cat-group-4'] : $vars['color-primary'];
		// Blog Categories Group 5
		$vars['post-category-5'] = ( isset( $alchemists_data['alchemists__blog-cat-group-5'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-5'] ) )  ? $alchemists_data['alchemists__blog-cat-group-5'] : $vars['color-primary'];
		// Blog Categories Group 6
		$vars['post-category-6'] = ( isset( $alchemists_data['alchemists__blog-cat-group-6'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-6'] ) )  ? $alchemists_data['alchemists__blog-cat-group-6'] : $vars['color-primary'];
		// Blog Categories Group 7
		$vars['post-category-7'] = ( isset( $alchemists_data['alchemists__blog-cat-group-7'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-7'] ) )  ? $alchemists_data['alchemists__blog-cat-group-7'] : $vars['color-primary'];
		// Blog Categories Group 8
		$vars['post-category-8'] = ( isset( $alchemists_data['alchemists__blog-cat-group-8'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-8'] ) )  ? $alchemists_data['alchemists__blog-cat-group-8'] : $vars['color-primary'];
		// Blog Categories Group 9
		$vars['post-category-9'] = ( isset( $alchemists_data['alchemists__blog-cat-group-9'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-9'] ) )  ? $alchemists_data['alchemists__blog-cat-group-9'] : $vars['color-primary'];
		// Blog Categories Group 10
		$vars['post-category-10'] = ( isset( $alchemists_data['alchemists__blog-cat-group-10'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-10'] ) )  ? $alchemists_data['alchemists__blog-cat-group-10'] : $vars['color-primary'];
		// Blog Categories Group 11
		$vars['post-category-11'] = ( isset( $alchemists_data['alchemists__blog-cat-group-11'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-11'] ) )  ? $alchemists_data['alchemists__blog-cat-group-11'] : $vars['color-primary'];
		// Blog Categories Group 12
		$vars['post-category-12'] = ( isset( $alchemists_data['alchemists__blog-cat-group-12'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-12'] ) )  ? $alchemists_data['alchemists__blog-cat-group-12'] : $vars['color-primary'];


		// Footer Background
		if ( isset( $alchemists_data['alchemists__footer-widgets-bg'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg'] ) ) {
			if ( isset( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) || isset( $alchemists_data['alchemists__footer-widgets-bg']['background-image'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-image'] ) ) {
				$vars['footer-widgets-bg'] = 'url(' . $alchemists_data['alchemists__footer-widgets-bg']['background-image'] . ') ' . $alchemists_data['alchemists__footer-widgets-bg']['background-color'];
			} else {
				$vars['footer-widgets-bg'] = $vars['color-dark-2'];
			}
		} else {
			$vars['footer-widgets-bg'] = $vars['color-dark-2'];
		}

		if ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color'] ) ) {
			$vars['footer-widgets-overlay'] = ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] ) ) ? $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] : $vars['color-dark']; // done

			$vars['footer-widgets-overlay-opacity'] = ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] ) ) ? $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] : '0.8'; // done
		}

		$vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : $vars['color-dark-2'];
		
		$vars['footer-secondary-side-bg'] = ( isset( $alchemists_data['alchemists__footer-side-decoration-bg'] ) && !empty( $alchemists_data['alchemists__footer-side-decoration-bg'] ) ) ? $alchemists_data['alchemists__footer-side-decoration-bg'] : $vars['color-primary'];

		$vars['footer-copyright-border-color'] = ( isset( $alchemists_data['alchemists__footer-secondary-border-color'] ) && !empty( $alchemists_data['alchemists__footer-secondary-border-color'] ) ) ? $alchemists_data['alchemists__footer-secondary-border-color'] : $vars['color-2'];

		$vars['footer-widget-link-color'] = ( isset( $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] ) ) ? $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] : '#fff';

		$vars['footer-widget-link-color-hover'] = ( isset( $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] ) ) ? $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] : $vars['color-primary'];


		// Typography

		// Body
		if ( $alchemists_data['alchemists__custom_body_font'] ) {
			$vars['font-family-base'] = ( isset( $alchemists_data['alchemists__typography-body']['font-family'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-family'] ) ) ? $alchemists_data['alchemists__typography-body']['font-family'] : 'Roboto, sans-serif';

			$vars['base-font-size'] = ( isset( $alchemists_data['alchemists__typography-body']['font-size'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-size'] ) ) ? $alchemists_data['alchemists__typography-body']['font-size'] : '14px';

			$vars['base-line-height'] = ( isset( $alchemists_data['alchemists__typography-body']['line-height'] ) && !empty( $alchemists_data['alchemists__typography-body']['line-height'] ) ) ? $alchemists_data['alchemists__typography-body']['line-height'] : '26px';

			$vars['body-font-weight'] = ( isset( $alchemists_data['alchemists__typography-body']['font-weight'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-weight'] ) ) ? $alchemists_data['alchemists__typography-body']['font-weight'] : '400';

			$vars['body-font-color'] = ( isset( $alchemists_data['alchemists__typography-body']['color'] ) && !empty( $alchemists_data['alchemists__typography-body']['color'] ) ) ? $alchemists_data['alchemists__typography-body']['color'] : $vars['color-gray'];
		}


		// Heading Fonts
		if ( $alchemists_data['alchemists__custom_heading_font'] ) {
			// Font Family Accent
			$vars['font-family-accent'] = ( isset( $alchemists_data['font-family-accent']['font-family'] ) && !empty( $alchemists_data['font-family-accent']['font-family'] ) ) ? $alchemists_data['font-family-accent']['font-family'] : 'Exo 2, sans-serif';

			// Headings
			$vars['headings-font-family'] = ( isset( $alchemists_data['headings-typography']['font-family'] ) && !empty( $alchemists_data['headings-typography']['font-family'] ) ) ? $alchemists_data['headings-typography']['font-family'] : 'Exo 2, sans-serif';

			$vars['headings-color'] = ( isset( $alchemists_data['headings-typography']['color'] ) && !empty( $alchemists_data['headings-typography']['color'] ) ) ? $alchemists_data['headings-typography']['color'] : '#fff';
		}

		// Heading Links
		$vars['post-title-color'] = ( isset( $alchemists_data['alchemists__custom_heading_link_color']['regular'] ) && !empty( $alchemists_data['alchemists__custom_heading_link_color']['regular'] ) ) ? $alchemists_data['alchemists__custom_heading_link_color']['regular'] : '#fff';

		$vars['post-title-color-hover'] = ( isset( $alchemists_data['alchemists__custom_heading_link_color']['hover'] ) && !empty( $alchemists_data['alchemists__custom_heading_link_color']['hover'] ) ) ? $alchemists_data['alchemists__custom_heading_link_color']['hover'] : $vars['color-4'];

		// Navigation
		if ( $alchemists_data['alchemists__custom_nav-font'] ) {
			$vars['nav-font-family'] = ( isset( $alchemists_data['alchemists__nav-font']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font']['font-family'] : 'Exo 2, sans-serif';

			$vars['nav-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font']['text-transform'] : 'uppercase';

			$vars['nav-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font']['font-weight'] : '700';

			$vars['nav-font-style'] = ( isset( $alchemists_data['alchemists__nav-font']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font']['font-style'] : 'normal';

			$vars['nav-font-size'] = ( isset( $alchemists_data['alchemists__nav-font']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font']['font-size'] : '12px';


			$vars['nav-sub-font-family'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-family'] : 'Exo 2, sans-serif';

			$vars['nav-sub-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['text-transform'] : 'uppercase';

			$vars['nav-sub-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-weight'] : '700';

			$vars['nav-sub-font-style'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-style'] : 'normal';

			$vars['nav-sub-font-size'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-size'] : '11px';
		}


		// Preloader
		if ( $alchemists_data['alchemists__opt-custom_pageloader'] ) {

			$vars['preloader-bg'] = ( isset( $alchemists_data['alchemists__opt-preloader-bg'] ) && !empty( $alchemists_data['alchemists__opt-preloader-bg'] ) ) ? $alchemists_data['alchemists__opt-preloader-bg'] : $vars['color-dark-2'];

			$vars['preloader-size'] = ( isset( $alchemists_data['alchemists__opt-preloader-size']['width'] ) && !empty( $alchemists_data['alchemists__opt-preloader-size']['width'] ) ) ? $alchemists_data['alchemists__opt-preloader-size']['width'] : '32px';

			$vars['preloader-color'] = ( isset( $alchemists_data['alchemists__opt-preloader-color'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color'] ) ) ? $alchemists_data['alchemists__opt-preloader-color'] : $vars['color-4'];

			$vars['preloader-color-secondary'] = ( isset( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) ) ? $alchemists_data['alchemists__opt-preloader-color-secondary'] : 'rgba(255,255,255, 0.15)';

			$vars['preloader-spin-duration'] = ( isset( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) && !empty( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) ) ? $alchemists_data['alchemists__opt-preloader-spin-duration'] . 's' : '0.8s';
		}


		} elseif ( alchemists_sp_preset('esports') ) {

			/*
			 * eSport
			 */
	
			$card_colors = array(
				'card-bg'              => '#392d49',
				'card-header-bg'       => '#403351',
				'card-subheader-bg'    => '#403351',
				'card-border-color'    => '#4b3b60'
			);
	
			$colors = array(
				'color_primary'        => '#00ff5b',
				'color_primary_darken' => '#1bd75e',
				'color_dark'           => '#362b45',
				'color_dark_lighten'   => '#392d49',
				'color_gray'           => '#a59cae',
				'color_2'              => '#6a3bc0',
				'color_2_dark'         => '#403351',
				'color_3'              => '#f92552',
				'color_4'              => '#ffb400',
				'color_4_darken'       => '#ffb400',
			);
	
			// Colors
			$vars['color-primary']        = ( isset( $alchemists_data['color-primary'] ) && !empty( $alchemists_data['color-primary'] ) ) ? $alchemists_data['color-primary'] : $colors['color_primary']; // done
	
			$vars['color-primary-darken'] = ( isset( $alchemists_data['color-primary-darken'] ) && !empty( $alchemists_data['color-primary-darken'] ) ) ? $alchemists_data['color-primary-darken'] : $colors['color_primary_darken']; // done
	
			$vars['color-dark'] = ( isset( $alchemists_data['color-dark'] ) && !empty( $alchemists_data['color-dark'] ) )  ? $alchemists_data['color-dark'] : $colors['color_dark']; // done
	
			$vars['color-dark-lighten']   = ( isset( $alchemists_data['color-dark-lighten'] ) && !empty( $alchemists_data['color-dark-lighten'] ) ) ? $alchemists_data['color-dark-lighten'] : $colors['color_dark_lighten']; // done
	
			$vars['color-gray']           = ( isset( $alchemists_data['color-gray'] ) && !empty( $alchemists_data['color-gray'] ) ) ? $alchemists_data['color-gray'] :  $colors['color_gray']; // done
	
			$vars['color-2']              = ( isset( $alchemists_data['color-2'] ) && !empty( $alchemists_data['color-2'] ) ) ? $alchemists_data['color-2'] : $colors['color_2']; // done
	
			$vars['color-dark-2']         = ( isset( $alchemists_data['color-dark-2'] ) && !empty( $alchemists_data['color-dark-2'] ) )  ? $alchemists_data['color-dark-2'] : $colors['color_dark_2']; // done
	
			$vars['color-3']              = ( isset( $alchemists_data['color-3'] ) && !empty( $alchemists_data['color-3'] ) ) ? $alchemists_data['color-3'] : $colors['color_3']; // done
	
			$vars['color-4']              = ( isset( $alchemists_data['color-4'] ) && !empty( $alchemists_data['color-4'] ) ) ? $alchemists_data['color-4'] : $colors['color_4']; // done
	
			$vars['color-4-darken']       = ( isset( $alchemists_data['color-4-darken'] ) && !empty( $alchemists_data['color-4-darken'] ) ) ? $alchemists_data['color-4-darken'] : $colors['color_4_darken']; // done
	
	
			// Card
			$vars['card-bg'] = isset( $alchemists_data['alchemists__card-bg'] ) && !empty( $alchemists_data['alchemists__card-bg'] ) ? $alchemists_data['alchemists__card-bg'] : $card_colors['card-bg']; // done
			$vars['card-header-bg'] = isset( $alchemists_data['alchemists__card-header-bg'] ) && !empty( $alchemists_data['alchemists__card-header-bg'] ) ? $alchemists_data['alchemists__card-header-bg'] : $card_colors['card-header-bg']; // done
			$vars['card-subheader-bg'] = isset( $alchemists_data['alchemists__card-subheader-bg'] ) && !empty( $alchemists_data['alchemists__card-subheader-bg'] ) ? $alchemists_data['alchemists__card-subheader-bg'] : $card_colors['card-subheader-bg']; // done
			$vars['card-border-color'] = isset( $alchemists_data['alchemists__card-border-color'] ) && !empty( $alchemists_data['alchemists__card-border-color'] ) ? $alchemists_data['alchemists__card-border-color'] : $card_colors['card-border-color']; // done



			// Table (related on Card colors)
			$table_colors = array(
				'table-bg'             => 'transparent',
				'table-bg-hover'       => $vars['card-subheader-bg'],
				'table-bg-active'      => $vars['card-subheader-bg'],
				'table-border-color'   => $vars['card-border-color'],
				'table-thead-bg-color' => $vars['card-subheader-bg'],
				'table-thead-color'    => '#fff',
				'table-highlight'      => '#fff',
			);

			$vars['table-bg'] = isset( $alchemists_data['alchemists__table-bg'] ) && !empty( $alchemists_data['alchemists__table-bg'] ) ? $alchemists_data['alchemists__table-bg'] : $table_colors['table-bg'];
			$vars['table-bg-hover'] = isset( $alchemists_data['alchemists__table-bg-hover'] ) && !empty( $alchemists_data['alchemists__table-bg-hover'] ) ? $alchemists_data['alchemists__table-bg-hover'] : $table_colors['table-bg-hover'];
			$vars['table-bg-active'] = isset( $alchemists_data['alchemists__table-bg-active'] ) && !empty( $alchemists_data['alchemists__table-bg-active'] ) ? $alchemists_data['alchemists__table-bg-active'] : $table_colors['table-bg-active'];
			$vars['table-border-color'] = isset( $alchemists_data['alchemists__table-border-color'] ) && !empty( $alchemists_data['alchemists__table-border-color'] ) ? $alchemists_data['alchemists__table-border-color'] : $table_colors['table-border-color'];
			$vars['table-thead-bg-color'] = isset( $alchemists_data['alchemists__table-thead-bg-color'] ) && !empty( $alchemists_data['alchemists__table-thead-bg-color'] ) ? $alchemists_data['alchemists__table-thead-bg-color'] : $table_colors['table-thead-bg-color'];
			$vars['table-thead-color'] = isset( $alchemists_data['alchemists__table-thead-color'] ) && !empty( $alchemists_data['alchemists__table-thead-color'] ) ? $alchemists_data['alchemists__table-thead-color'] : $table_colors['table-thead-color'];
			$vars['table-highlight'] = isset( $alchemists_data['alchemists__table-highlight-color'] ) && !empty( $alchemists_data['alchemists__table-highlight-color'] ) ? $alchemists_data['alchemists__table-highlight-color'] : $table_colors['table-highlight'];


			// Form
			$vars['input-bg'] = isset( $alchemists_data['alchemists__form-control']['regular'] ) && !empty( $alchemists_data['alchemists__form-control']['regular'] ) ? $alchemists_data['alchemists__form-control']['regular'] : 'rgba(0,0,0,0.05)';
			$vars['input-bg-focus'] = isset( $alchemists_data['alchemists__form-control']['active'] ) && !empty( $alchemists_data['alchemists__form-control']['active'] ) ? $alchemists_data['alchemists__form-control']['active'] : $vars['input-bg'];

			$vars['input-border'] = isset( $alchemists_data['alchemists__form-control-border']['regular'] ) && !empty( $alchemists_data['alchemists__form-control-border']['regular'] ) ? $alchemists_data['alchemists__form-control-border']['regular'] : '#4b3b60';
			$vars['input-border-focus'] = isset( $alchemists_data['alchemists__form-control-border']['active'] ) && !empty( $alchemists_data['alchemists__form-control-border']['active'] ) ? $alchemists_data['alchemists__form-control-border']['active'] : $vars['color-2'];

			$vars['input-color'] = isset( $alchemists_data['alchemists__form-control-txt']['regular'] ) && !empty( $alchemists_data['alchemists__form-control-txt']['regular'] ) ? $alchemists_data['alchemists__form-control-txt']['regular'] : $vars['color-gray'];
			$vars['input-color-focus'] = isset( $alchemists_data['alchemists__form-control-txt']['active'] ) && !empty( $alchemists_data['alchemists__form-control-txt']['active'] ) ? $alchemists_data['alchemists__form-control-txt']['active'] : $vars['input-color'];

			$vars['input-color-placeholder'] = isset( $alchemists_data['alchemists__form-control-placeholder'] ) && !empty( $alchemists_data['alchemists__form-control-placeholder'] ) ? $alchemists_data['alchemists__form-control-placeholder'] : 'rgba(122, 114, 131, 0.6)';
			

			// Table
			$vars['table-border-color'] = isset( $alchemists_data['alchemists__card-border-color'] ) && !empty( $alchemists_data['alchemists__card-border-color'] ) ? $alchemists_data['alchemists__card-border-color'] : $card_colors['card-border-color']; // done
	
	
			// Header Primary Height
			$vars['nav-height'] = ( isset( $alchemists_data['alchemists__header-primary-height'] ) && !empty( $alchemists_data['alchemists__header-primary-height'] )) ? $alchemists_data['alchemists__header-primary-height'] . 'px' : '70px'; // done
	
			// Mobile Nav Width
			$nav_mobile_fullwidth = isset( $alchemists_data['alchemists__mobile-nav-fullwidth'] ) ? $alchemists_data['alchemists__mobile-nav-fullwidth'] : 0; // done
	
			if ( $nav_mobile_fullwidth == 1 ) {
				$vars['nav-mobile-width'] = '100%';
			} else {
				$vars['nav-mobile-width'] = ( isset( $alchemists_data['alchemists__mobile-nav-width'] ) && !empty( $alchemists_data['alchemists__mobile-nav-width'] )) ? $alchemists_data['alchemists__mobile-nav-width'] . 'px' : '270px'; // done
			}
	
			// Body Background
			$vars['body-bg-color'] = ( isset( $alchemists_data['alchemists__body-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__body-bg']['background-color'] )) ? $alchemists_data['alchemists__body-bg']['background-color'] : '#2b2236'; // done
	
			// Links Color
			$vars['link-color'] = ( isset( $alchemists_data['alchemists__link-color']['regular'] ) && !empty( $alchemists_data['alchemists__link-color']['regular'] )) ? $alchemists_data['alchemists__link-color']['regular'] : $vars['color-primary']; // done
			$vars['link-color-hover'] = ( isset( $alchemists_data['alchemists__link-color']['hover'] ) && !empty( $alchemists_data['alchemists__link-color']['hover'] )) ? $alchemists_data['alchemists__link-color']['hover'] : $vars['color-primary-darken']; // done
	
			// Outline Button Color
			$vars['btn-o-default-color'] = ( isset( $alchemists_data['alchemists__button_outline_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_txt_color']['regular'] : '#fff'; // done
			$vars['btn-o-default-color-hover'] = ( isset( $alchemists_data['alchemists__button_outline_txt_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_txt_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_txt_color']['hover'] : '#fff'; // done
	
			// Outline Button Background Color
			$vars['btn-o-default-bg'] = ( isset( $alchemists_data['alchemists__button_outline_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_bg_color']['regular'] : 'transparent'; // done
			$vars['btn-o-default-bg-hover'] = ( isset( $alchemists_data['alchemists__button_outline_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_bg_color']['hover'] : 'transparent'; // done
	
			// Outline Button Border Color
			$vars['btn-o-default-border'] = ( isset( $alchemists_data['alchemists__button_outline_border_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_border_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_border_color']['regular'] : '#7a7283'; // done
			$vars['btn-o-default-border-hover'] = ( isset( $alchemists_data['alchemists__button_outline_border_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_border_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_border_color']['hover'] : $vars['color-4']; // done


			// Default Button Color
			$vars['btn-default-color'] = ( isset( $alchemists_data['alchemists__button_default_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_default_txt_color']['regular'] : '#fff';

			// Default Button Background Color
			$vars['btn-default-bg'] = ( isset( $alchemists_data['alchemists__button_default_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_default_bg_color']['regular'] : '#8c8297';
			$vars['btn-default-hover'] = ( isset( $alchemists_data['alchemists__button_default_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_default_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_default_bg_color']['hover'] : $vars['color-primary-darken'];


			// Default Alt Button Color
			$vars['btn-default-alt-color'] = ( isset( $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] : '#fff';

			// Default Alt Button Background Color
			$vars['btn-default-alt-bg'] = ( isset( $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] : '#4b3b60';
			$vars['btn-default-alt-hover'] = ( isset( $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] : $vars['color-2'];


			// Button Primary Color
			$vars['btn-primary-color'] = ( isset( $alchemists_data['alchemists__button_primary_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_txt_color']['regular'] : '#fff';

			// Button Primary Background Color
			$vars['btn-primary-bg'] = ( isset( $alchemists_data['alchemists__button_primary_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_bg_color']['regular'] : $vars['color-2'];
			$vars['btn-primary-hover'] = ( isset( $alchemists_data['alchemists__button_primary_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_bg_color']['hover'] : '#8040f5';


			// Button Primary Inverse Color
			$vars['btn-primary-inverse-color'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] : '#fff';

			// Button Primary Inverse Background Color
			$vars['btn-primary-inverse-bg'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] : $vars['color-primary-darken'];
			$vars['btn-primary-inverse-hover'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] : $vars['color-primary'];

	
			// Top Bar
			$vars['header-top-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-bg'] : $vars['color-dark']; // done
			$vars['top-bar-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-link-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-link-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-link-color'] : '#fff'; // done
			$vars['top-bar-highlight'] = ( isset( $alchemists_data['alchemists__header-top-bar-highlight'] ) && !empty( $alchemists_data['alchemists__header-top-bar-highlight'] ) ) ? $alchemists_data['alchemists__header-top-bar-highlight'] : $vars['color-primary']; // done
			$vars['top-bar-text-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-text-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-text-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-text-color'] : '#7a7283'; // done
			$vars['top-bar-divider-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-divider-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-divider-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-divider-color'] : $vars['top-bar-text-color']; // done
			$vars['top-bar-dropdown-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-dropdown-bg'] : $vars['color-dark-lighten']; // done
			$vars['top-bar-dropdown-border'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] : '#4b3b60'; // done
			$vars['top-bar-dropdown-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] : '#fff'; // done
			$vars['top-bar-dropdown-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] : $vars['color-primary']; // done
	
			// Header Secondary Background
			$vars['header-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark-2']; // done
			$vars['header-secondary-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark-2']; // done
	
			// Header Primary Background
			$vars['header-primary-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) ) ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark-2']; // done
			$vars['header-primary-alt-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) ) ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark']; // done
	
			// Header Primary Links Color
			$vars['nav-font-color'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['regular'] : '#fff'; // done
			$vars['nav-font-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['hover'] : $vars['color-primary']; // done
	
			// Header Primary Link Border Color
			$vars['nav-active-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-border-color'] : 'transparent'; // done
	
			// Header Primary Link Border Height
			$vars['nav-active-border-height'] = ( isset( $alchemists_data['alchemists__header-primary-border-height']['height'] ) && !empty( $alchemists_data['alchemists__header-primary-border-height']['height'] ) )  ? $alchemists_data['alchemists__header-primary-border-height']['height'] : '0px'; // done
	
			// Header Submenu Background Color
			$vars['nav-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-bg'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-bg'] : $vars['color-dark-lighten']; // done
	
			// Header Submenu Border Color
			$vars['nav-sub-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-border-color'] : '#4b3b60'; // done
	
			// Header Submenu Link Color
			$vars['nav-sub-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] : '#fff'; // done
			$vars['nav-sub-hover-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] : $vars['color-primary']; // done
	
			// Header Submenu Caret Color
			$vars['nav-sub-caret-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) ) ? $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] : '#fff'; // done
	
			// Megamenu Text Color
			$vars['nav-sub-megamenu-txt-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) ) ? $alchemists_data['alchemists__header-primary-megamenu-txt-color'] : $vars['color-gray']; // done
	
			// Megamenu Link Color
			$vars['nav-sub-megamenu-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] : $vars['color-gray']; // done
			$vars['nav-sub-megamenu-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] : $vars['color-primary']; // done
	
			// Megamenu Widget Meta Links Color
			$vars['nav-sub-megamenu-meta-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] : $vars['color-gray']; // done
			$vars['nav-sub-megamenu-meta-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] : $vars['color-gray']; // done
	
			// Megamenu Title Color
			$vars['nav-sub-megamenu-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-title-color'] : '#fff'; // done
		
			// Megamenu Post Title Color
			$vars['nav-sub-megamenu-post-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] : '#fff'; // done
	
	
			// Social Link Color
			$vars['header-social-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-social-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-social-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-social-link-color']['regular'] : '#fff'; // done
			$vars['header-social-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-social-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-social-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-social-link-color']['hover'] : $vars['color-primary']; // done
			
	
			// Mobile Nav Background Color
			$vars['nav-mobile-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) ) ? $alchemists_data['alchemists__header-primary-mobile-nav-bg'] : $vars['color-dark-lighten']; // done
	
			// Mobile Nav Burger Menu Color
			$vars['nav-mobile-burger-icon'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] ) ) ? $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] : '#fff'; // done
	
			// Header Mobile Background Color
			$vars['header-mobile-bg'] = ( isset( $alchemists_data['alchemists__mobile-header-bg'] ) && !empty( $alchemists_data['alchemists__mobile-header-bg'] ) ) ? $alchemists_data['alchemists__mobile-header-bg'] : $vars['color-dark-2']; // done
	
			// Mobile Nav Links Color
			$vars['nav-mobile-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) ) ? $alchemists_data['alchemists__header-primary-mobile-link-color'] : '#fff'; // done
	
			// Mobile Nav Links Color
			$vars['nav-mobile-border'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) ) ? $alchemists_data['alchemists__header-primary-mobile-border-color'] : '#4b3b60'; // done
	
			// Mobile Nav Submenu Background Color
			$vars['nav-mobile-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) ) ? $alchemists_data['alchemists__header-primary-mobile-sub-bg'] : $vars['color-dark']; // done
	
			// Mobile Nav Submenu Links Color
			$vars['nav-mobile-sub-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) ) ? $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] : $vars['color-gray']; // done
	
	
			// Header Info Block
			$vars['header-info-block-color'] = ( isset( $alchemists_data['alchemists__header-info-block-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-color'] ) )  ? $alchemists_data['alchemists__header-info-block-color'] : $vars['color-primary']; // done
				
			$vars['header-info-block-cart-sum-color'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color'] : $vars['color-primary']; // done
	
			$vars['header-info-block-title-color'] = ( isset( $alchemists_data['alchemists__header-info-block-title-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-title-color'] ) )  ? $alchemists_data['alchemists__header-info-block-title-color'] : '#fff'; // done
	
			$vars['header-info-block-cart-sum-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] : $vars['color-primary']; // done
	
			$vars['header-info-block-link-color'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['regular'] : '#7a7283'; // done
	
			$vars['header-info-block-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['hover'] : '#fff'; // done
	
			$vars['header-info-block-link-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] : '#fff'; // done
	
			$vars['header-info-block-link-color-mobile-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] : '#fff'; // done


			// Search Form

			// background color - desktop
			$vars['header-search-input-bg'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] : $vars['color-dark'];
			$vars['header-search-input-bg-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] : $vars['color-dark'];

			// border color - desktop
			$vars['header-search-input-border'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] : $vars['color-dark'];
			$vars['header-search-input-border-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-border']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-border']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-border']['active'] : $vars['color-dark'];

			// text color - desktop
			$vars['header-search-input-txt'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] : 'rgba(122,114,131,0.6)';
			$vars['header-search-input-txt-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] : '#fff';

			// submit icon color - desktop
			$vars['header-search-icon'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] : '#fff';
			$vars['header-search-icon-hover'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] : '#fff';

			// background color - mobile
			$vars['header-search-input-bg-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] : $vars['color-dark'];
			$vars['header-search-input-bg-focus-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] : $vars['color-dark-lighten'];

			// border color - mobile
			$vars['header-search-input-border-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] : $vars['color-dark'];
			$vars['header-search-input-border-focus-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-border']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-border']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-border']['active'] : $vars['color-dark-lighten'];

			// text color - mobile
			$vars['header-search-input-txt-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] : 'rgba(122,114,131,0.6)';
			$vars['header-search-input-txt-mobile-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] : '#fff';

			// submit icon color - mobile
			$vars['header-search-icon-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] : '#fff';
			$vars['header-search-icon-mobile-active'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] : '#fff';

			// submit trigger icon - color
			$vars['header-search-icon-trigger-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] : '#fff';

			// Content Filter Colors
			$vars['content-filter-color'] = ( isset( $alchemists_data['alchemists__content-content-filter']['regular'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['regular'] )) ? $alchemists_data['alchemists__content-content-filter']['regular'] : '#7a7283'; // done
			$vars['content-filter-color-hover'] = ( isset( $alchemists_data['alchemists__content-content-filter']['hover'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['hover'] )) ? $alchemists_data['alchemists__content-content-filter']['hover'] : '#fff'; // done
			$vars['content-filter-color-active'] = ( isset( $alchemists_data['alchemists__content-content-filter']['active'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['active'] )) ? $alchemists_data['alchemists__content-content-filter']['active'] : '#fff'; // done
	
	
			// Blog Categories Group 1
			$vars['post-category-1'] = ( isset( $alchemists_data['alchemists__blog-cat-group-1'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-1'] ) )  ? $alchemists_data['alchemists__blog-cat-group-1'] : $vars['color-primary-darken']; // done
			// Blog Categories Group 2
			$vars['post-category-2'] = ( isset( $alchemists_data['alchemists__blog-cat-group-2'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-2'] ) )  ? $alchemists_data['alchemists__blog-cat-group-2'] : $vars['color-2']; // done
			// Blog Categories Group 3
			$vars['post-category-3'] = ( isset( $alchemists_data['alchemists__blog-cat-group-3'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-3'] ) )  ? $alchemists_data['alchemists__blog-cat-group-3'] : $vars['color-3']; // done
			// Blog Categories Group 4
			$vars['post-category-4'] = ( isset( $alchemists_data['alchemists__blog-cat-group-4'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-4'] ) )  ? $alchemists_data['alchemists__blog-cat-group-4'] : $vars['color-4']; // done
			// Blog Categories Group 5
			$vars['post-category-5'] = ( isset( $alchemists_data['alchemists__blog-cat-group-5'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-5'] ) )  ? $alchemists_data['alchemists__blog-cat-group-5'] : '#f1533e'; // done
			// Blog Categories Group 6
			$vars['post-category-6'] = ( isset( $alchemists_data['alchemists__blog-cat-group-6'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-6'] ) )  ? $alchemists_data['alchemists__blog-cat-group-6'] : $vars['color-2']; // done
			// Blog Categories Group 7
			$vars['post-category-7'] = ( isset( $alchemists_data['alchemists__blog-cat-group-7'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-7'] ) )  ? $alchemists_data['alchemists__blog-cat-group-7'] : $vars['color-primary-darken']; // done
			// Blog Categories Group 8
			$vars['post-category-8'] = ( isset( $alchemists_data['alchemists__blog-cat-group-8'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-8'] ) )  ? $alchemists_data['alchemists__blog-cat-group-8'] : $vars['color-primary-darken']; // done
			// Blog Categories Group 9
			$vars['post-category-9'] = ( isset( $alchemists_data['alchemists__blog-cat-group-9'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-9'] ) )  ? $alchemists_data['alchemists__blog-cat-group-9'] : $vars['color-primary-darken']; // done
			// Blog Categories Group 10
			$vars['post-category-10'] = ( isset( $alchemists_data['alchemists__blog-cat-group-10'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-10'] ) )  ? $alchemists_data['alchemists__blog-cat-group-10'] : $vars['color-primary-darken']; // done
			// Blog Categories Group 11
			$vars['post-category-11'] = ( isset( $alchemists_data['alchemists__blog-cat-group-11'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-11'] ) )  ? $alchemists_data['alchemists__blog-cat-group-11'] : $vars['color-primary-darken']; // done
			// Blog Categories Group 12
			$vars['post-category-12'] = ( isset( $alchemists_data['alchemists__blog-cat-group-12'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-12'] ) )  ? $alchemists_data['alchemists__blog-cat-group-12'] : $vars['color-primary-darken']; // done
	
	
			// Footer Background
			if ( isset( $alchemists_data['alchemists__footer-widgets-bg'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg'] ) ) {
				if ( isset( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) || isset( $alchemists_data['alchemists__footer-widgets-bg']['background-image'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-image'] ) ) {
					$vars['footer-widgets-bg'] = 'url(' . $alchemists_data['alchemists__footer-widgets-bg']['background-image'] . ') ' . $alchemists_data['alchemists__footer-widgets-bg']['background-color']; // done
				} else {
					$vars['footer-widgets-bg'] = '#3b2f4c url("' . get_template_directory_uri() . '/assets/images/esports/samples/footer-bg.jpg") no-repeat center top/cover'; // done
				}
			} else {
				$vars['footer-widgets-bg'] = '#3b2f4c url("' . get_template_directory_uri() . '/assets/images/esports/samples/footer-bg.jpg") no-repeat center top/cover'; // done
			}

			if ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color'] ) ) {
				$vars['footer-widgets-overlay'] = ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] ) ) ? $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] : $vars['color-dark']; // done

				$vars['footer-widgets-overlay-opacity'] = ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] ) ) ? $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] : '0.8'; // done
			}

			$vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : $vars['color-dark']; // done
			
			$vars['footer-secondary-side-bg'] = ( isset( $alchemists_data['alchemists__footer-side-decoration-bg'] ) && !empty( $alchemists_data['alchemists__footer-side-decoration-bg'] ) ) ? $alchemists_data['alchemists__footer-side-decoration-bg'] : $vars['color-primary']; // done
	
			$vars['footer-copyright-border-color'] = ( isset( $alchemists_data['alchemists__footer-secondary-border-color'] ) && !empty( $alchemists_data['alchemists__footer-secondary-border-color'] ) ) ? $alchemists_data['alchemists__footer-secondary-border-color'] : 'transparent'; // done

			$vars['footer-widget-link-color'] = ( isset( $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] ) ) ? $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] : $colors['color_gray']; // done

			$vars['footer-widget-link-color-hover'] = ( isset( $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] ) ) ? $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] : '#fff'; // done
	
	
			// Typography
	
			// Body
			if ( $alchemists_data['alchemists__custom_body_font'] ) {
				$vars['font-family-base'] = ( isset( $alchemists_data['alchemists__typography-body']['font-family'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-family'] ) ) ? $alchemists_data['alchemists__typography-body']['font-family'] : 'Open Sans, sans-serif'; // done
	
				$vars['base-font-size'] = ( isset( $alchemists_data['alchemists__typography-body']['font-size'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-size'] ) ) ? $alchemists_data['alchemists__typography-body']['font-size'] : '14px'; // done
	
				$vars['base-line-height'] = ( isset( $alchemists_data['alchemists__typography-body']['line-height'] ) && !empty( $alchemists_data['alchemists__typography-body']['line-height'] ) ) ? $alchemists_data['alchemists__typography-body']['line-height'] : '26px'; // done
	
				$vars['body-font-weight'] = ( isset( $alchemists_data['alchemists__typography-body']['font-weight'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-weight'] ) ) ? $alchemists_data['alchemists__typography-body']['font-weight'] : '400'; // done
	
				$vars['body-font-color'] = ( isset( $alchemists_data['alchemists__typography-body']['color'] ) && !empty( $alchemists_data['alchemists__typography-body']['color'] ) ) ? $alchemists_data['alchemists__typography-body']['color'] : $vars['color-gray']; // done
			}
	
	
			// Heading Fonts
			if ( $alchemists_data['alchemists__custom_heading_font'] ) {
				// Font Family Accent
				$vars['font-family-accent'] = ( isset( $alchemists_data['font-family-accent']['font-family'] ) && !empty( $alchemists_data['font-family-accent']['font-family'] ) ) ? $alchemists_data['font-family-accent']['font-family'] : 'Roboto Condensed, sans-serif'; // done
	
				// Headings
				$vars['headings-font-family'] = ( isset( $alchemists_data['headings-typography']['font-family'] ) && !empty( $alchemists_data['headings-typography']['font-family'] ) ) ? $alchemists_data['headings-typography']['font-family'] : 'Roboto Condensed, sans-serif'; // done
	
				$vars['headings-color'] = ( isset( $alchemists_data['headings-typography']['color'] ) && !empty( $alchemists_data['headings-typography']['color'] ) ) ? $alchemists_data['headings-typography']['color'] : '#fff'; // done
			}
	
			// Heading Links
			$vars['post-title-color'] = ( isset( $alchemists_data['alchemists__custom_heading_link_color']['regular'] ) && !empty( $alchemists_data['alchemists__custom_heading_link_color']['regular'] ) ) ? $alchemists_data['alchemists__custom_heading_link_color']['regular'] : '#fff'; // done

			$vars['post-title-color-hover'] = ( isset( $alchemists_data['alchemists__custom_heading_link_color']['hover'] ) && !empty( $alchemists_data['alchemists__custom_heading_link_color']['hover'] ) ) ? $alchemists_data['alchemists__custom_heading_link_color']['hover'] : $vars['color-primary']; // done
	
			// Navigation
			if ( $alchemists_data['alchemists__custom_nav-font'] ) {
				$vars['nav-font-family'] = ( isset( $alchemists_data['alchemists__nav-font']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font']['font-family'] : 'Roboto Condensed, sans-serif'; // done
	
				$vars['nav-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font']['text-transform'] : 'uppercase'; // done
	
				$vars['nav-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font']['font-weight'] : '700'; // done
	
				$vars['nav-font-style'] = ( isset( $alchemists_data['alchemists__nav-font']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font']['font-style'] : 'italic'; // done
	
				$vars['nav-font-size'] = ( isset( $alchemists_data['alchemists__nav-font']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font']['font-size'] : '14px'; // done
	
	
				$vars['nav-sub-font-family'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-family'] : 'Roboto Condensed, sans-serif'; // done
	
				$vars['nav-sub-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['text-transform'] : 'uppercase'; // done
	
				$vars['nav-sub-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-weight'] : '700'; // done
	
				$vars['nav-sub-font-style'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-style'] : 'italic'; // done
	
				$vars['nav-sub-font-size'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-size'] : '12px'; // done
			}
	
	
			// Preloader
			if ( $alchemists_data['alchemists__opt-custom_pageloader'] ) {
	
				$vars['preloader-bg'] = ( isset( $alchemists_data['alchemists__opt-preloader-bg'] ) && !empty( $alchemists_data['alchemists__opt-preloader-bg'] ) ) ? $alchemists_data['alchemists__opt-preloader-bg'] : $vars['color-dark-2']; // done
	
				$vars['preloader-size'] = ( isset( $alchemists_data['alchemists__opt-preloader-size']['width'] ) && !empty( $alchemists_data['alchemists__opt-preloader-size']['width'] ) ) ? $alchemists_data['alchemists__opt-preloader-size']['width'] : '32px'; // done
	
				$vars['preloader-color'] = ( isset( $alchemists_data['alchemists__opt-preloader-color'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color'] ) ) ? $alchemists_data['alchemists__opt-preloader-color'] : $vars['color-primary']; // done
	
				$vars['preloader-color-secondary'] = ( isset( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) ) ? $alchemists_data['alchemists__opt-preloader-color-secondary'] : 'rgba(255,255,255, 0.15)'; // done
	
				$vars['preloader-spin-duration'] = ( isset( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) && !empty( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) ) ? $alchemists_data['alchemists__opt-preloader-spin-duration'] . 's' : '1s'; // done
			}
	
	
		} else {
		

		/*
		 * Basketball and Soccer
		 */

		$card_colors = array(
			'card-bg'              => '#fff',
			'card-header-bg'       => '#fff',
			'card-subheader-bg'    => '#f5f7f9',
			'card-border-color'    => '#e4e7ed'
		);

		if ( alchemists_sp_preset('soccer') ) {
			// Soccer
			$colors = array(
				'color_primary'        => '#38a9ff',
				'color_primary_darken' => '#1892ed',
				'color_dark'           => '#1e2024',
				'color_dark_lighten'   => '#292c31',
				'color_gray'           => '#9a9da2',
				'color_2'              => '#31404b',
				'color_3'              => '#07e0c4',
				'color_4'              => '#c2ff1f',
				'color_4_darken'       => '#9fe900',
			);
		} else {
			// Basketball
			$colors = array(
				'color_primary'        => '#ffdc11',
				'color_primary_darken' => '#ffcc00',
				'color_dark'           => '#1e2024',
				'color_dark_lighten'   => '#292c31',
				'color_gray'           => '#9a9da2',
				'color_2'              => '#31404b',
				'color_3'              => '#ff7e1f',
				'color_4'              => '#9a66ca',
			); 
		}

		// Colors
		$vars['color-primary'] = ( isset( $alchemists_data['color-primary'] ) && !empty( $alchemists_data['color-primary'] ) ) ? $alchemists_data['color-primary'] : $colors['color_primary'];
		$vars['color-primary-darken'] = ( isset( $alchemists_data['color-primary-darken'] ) && !empty( $alchemists_data['color-primary-darken'] ) ) ? $alchemists_data['color-primary-darken'] : $colors['color_primary_darken'];
		$vars['color-dark'] = ( isset( $alchemists_data['color-dark'] ) && !empty( $alchemists_data['color-dark'] ) )  ? $alchemists_data['color-dark'] : $colors['color_dark'];
		$vars['color-dark-lighten'] = ( isset( $alchemists_data['color-dark-lighten'] ) && !empty( $alchemists_data['color-dark-lighten'] ) ) ? $alchemists_data['color-dark-lighten'] : $colors['color_dark_lighten'];
		$vars['color-gray'] = ( isset( $alchemists_data['color-gray'] ) && !empty( $alchemists_data['color-gray'] ) ) ? $alchemists_data['color-gray'] : $colors['color_gray'];
		$vars['color-2'] = ( isset( $alchemists_data['color-2'] ) && !empty( $alchemists_data['color-2'] ) ) ? $alchemists_data['color-2'] : $colors['color_2'];
		$vars['color-3'] = ( isset( $alchemists_data['color-3'] ) && !empty( $alchemists_data['color-3'] ) ) ? $alchemists_data['color-3'] : $colors['color_3'];
		$vars['color-4'] = ( isset( $alchemists_data['color-4'] ) && !empty( $alchemists_data['color-4'] ) ) ? $alchemists_data['color-4'] : $colors['color_4'];

		// Card
		$vars['card-bg'] = ( isset( $alchemists_data['alchemists__card-bg'] ) && !empty( $alchemists_data['alchemists__card-bg'] ) ) ? $alchemists_data['alchemists__card-bg'] : $card_colors['card-bg'];
		$vars['card-header-bg'] = ( isset( $alchemists_data['alchemists__card-header-bg'] ) && !empty( $alchemists_data['alchemists__card-header-bg'] ) ) ? $alchemists_data['alchemists__card-header-bg'] : $card_colors['card-header-bg'];
		$vars['card-subheader-bg'] = ( isset( $alchemists_data['alchemists__card-subheader-bg'] ) && !empty( $alchemists_data['alchemists__card-subheader-bg'] ) ) ? $alchemists_data['alchemists__card-subheader-bg'] : $card_colors['card-subheader-bg'];
		$vars['card-border-color'] = ( isset( $alchemists_data['alchemists__card-border-color'] ) && !empty( $alchemists_data['alchemists__card-border-color'] ) ) ? $alchemists_data['alchemists__card-border-color'] : $card_colors['card-border-color'];
		

		// Form
		$vars['input-bg'] = isset( $alchemists_data['alchemists__form-control']['regular'] ) && !empty( $alchemists_data['alchemists__form-control']['regular'] ) ? $alchemists_data['alchemists__form-control']['regular'] : '#fff';
		$vars['input-bg-focus'] = isset( $alchemists_data['alchemists__form-control']['active'] ) && !empty( $alchemists_data['alchemists__form-control']['active'] ) ? $alchemists_data['alchemists__form-control']['active'] : '#fff';

		$vars['input-border'] = isset( $alchemists_data['alchemists__form-control-border']['regular'] ) && !empty( $alchemists_data['alchemists__form-control-border']['regular'] ) ? $alchemists_data['alchemists__form-control-border']['regular'] : $vars['card-border-color'];
		$vars['input-border-focus'] = isset( $alchemists_data['alchemists__form-control-border']['active'] ) && !empty( $alchemists_data['alchemists__form-control-border']['active'] ) ? $alchemists_data['alchemists__form-control-border']['active'] : $vars['color-primary'];

		$vars['input-color'] = isset( $alchemists_data['alchemists__form-control-txt']['regular'] ) && !empty( $alchemists_data['alchemists__form-control-txt']['regular'] ) ? $alchemists_data['alchemists__form-control-txt']['regular'] : $vars['color-2'];
		$vars['input-color-focus'] = isset( $alchemists_data['alchemists__form-control-txt']['active'] ) && !empty( $alchemists_data['alchemists__form-control-txt']['active'] ) ? $alchemists_data['alchemists__form-control-txt']['active'] : $vars['input-color'];

		$vars['input-color-placeholder'] = isset( $alchemists_data['alchemists__form-control-placeholder'] ) && !empty( $alchemists_data['alchemists__form-control-placeholder'] ) ? $alchemists_data['alchemists__form-control-placeholder'] : 'rgba(154,157,162,0.6)';


		// Table (related on Card colors)
		$table_colors = array(
			'table-bg'             => 'transparent',
			'table-bg-hover'       => $vars['card-subheader-bg'],
			'table-bg-active'      => $vars['card-subheader-bg'],
			'table-border-color'   => $vars['card-border-color'],
			'table-thead-bg-color' => $vars['card-subheader-bg'],
			'table-thead-color'    => $vars['color-2'],
			'table-highlight'      => $vars['color-2'],
		);

		$vars['table-bg'] = isset( $alchemists_data['alchemists__table-bg'] ) && !empty( $alchemists_data['alchemists__table-bg'] ) ? $alchemists_data['alchemists__table-bg'] : $table_colors['table-bg'];
		$vars['table-bg-hover'] = isset( $alchemists_data['alchemists__table-bg-hover'] ) && !empty( $alchemists_data['alchemists__table-bg-hover'] ) ? $alchemists_data['alchemists__table-bg-hover'] : $table_colors['table-bg-hover'];
		$vars['table-bg-active'] = isset( $alchemists_data['alchemists__table-bg-active'] ) && !empty( $alchemists_data['alchemists__table-bg-active'] ) ? $alchemists_data['alchemists__table-bg-active'] : $table_colors['table-bg-active'];
		$vars['table-border-color'] = isset( $alchemists_data['alchemists__table-border-color'] ) && !empty( $alchemists_data['alchemists__table-border-color'] ) ? $alchemists_data['alchemists__table-border-color'] : $table_colors['table-border-color'];
		$vars['table-thead-bg-color'] = isset( $alchemists_data['alchemists__table-thead-bg-color'] ) && !empty( $alchemists_data['alchemists__table-thead-bg-color'] ) ? $alchemists_data['alchemists__table-thead-bg-color'] : $table_colors['table-thead-bg-color'];
		$vars['table-thead-color'] = isset( $alchemists_data['alchemists__table-thead-color'] ) && !empty( $alchemists_data['alchemists__table-thead-color'] ) ? $alchemists_data['alchemists__table-thead-color'] : $table_colors['table-thead-color'];
		$vars['table-highlight'] = isset( $alchemists_data['alchemists__table-highlight-color'] ) && !empty( $alchemists_data['alchemists__table-highlight-color'] ) ? $alchemists_data['alchemists__table-highlight-color'] : $table_colors['table-highlight'];

		if ( alchemists_sp_preset('soccer') ) {
			$vars['color-4-darken'] = ( isset( $alchemists_data['color-4-darken'] ) && !empty( $alchemists_data['color-4-darken'] ) ) ? $alchemists_data['color-4-darken'] : $colors['color_4_darken'];
		}

		// Header Primary Height
		$vars['nav-height'] = ( isset( $alchemists_data['alchemists__header-primary-height'] ) && !empty( $alchemists_data['alchemists__header-primary-height'] )) ? $alchemists_data['alchemists__header-primary-height'] . 'px' : '62px';

		// Mobile Nav Width
		$nav_mobile_fullwidth = isset( $alchemists_data['alchemists__mobile-nav-fullwidth'] ) ? $alchemists_data['alchemists__mobile-nav-fullwidth'] : 0;

		if ( $nav_mobile_fullwidth == 1 ) {
			$vars['nav-mobile-width'] = '100%';
		} else {
			$vars['nav-mobile-width'] = ( isset( $alchemists_data['alchemists__mobile-nav-width'] ) && !empty( $alchemists_data['alchemists__mobile-nav-width'] )) ? $alchemists_data['alchemists__mobile-nav-width'] . 'px' : '270px';
		}

		// Body Background
		$vars['body-bg-color'] = ( isset( $alchemists_data['alchemists__body-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__body-bg']['background-color'] )) ? $alchemists_data['alchemists__body-bg']['background-color'] : '#edeff4';

		// Links Color
		$vars['link-color'] = ( isset( $alchemists_data['alchemists__link-color']['regular'] ) && !empty( $alchemists_data['alchemists__link-color']['regular'] )) ? $alchemists_data['alchemists__link-color']['regular'] : $vars['color-primary-darken'];
		$vars['link-color-hover'] = ( isset( $alchemists_data['alchemists__link-color']['hover'] ) && !empty( $alchemists_data['alchemists__link-color']['hover'] )) ? $alchemists_data['alchemists__link-color']['hover'] : $vars['color-primary'];

		// Outline Button Color
		$vars['btn-o-default-color'] = ( isset( $alchemists_data['alchemists__button_outline_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_txt_color']['regular'] : $vars['color-gray'];
		$vars['btn-o-default-color-hover'] = ( isset( $alchemists_data['alchemists__button_outline_txt_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_txt_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_txt_color']['hover'] : '#fff';

		// Outline Button Background Color
		$vars['btn-o-default-bg'] = ( isset( $alchemists_data['alchemists__button_outline_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_bg_color']['regular'] : 'transparent';
		$vars['btn-o-default-bg-hover'] = ( isset( $alchemists_data['alchemists__button_outline_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_bg_color']['hover'] : $vars['color-gray'];

		// Outline Button Border Color
		$vars['btn-o-default-border'] = ( isset( $alchemists_data['alchemists__button_outline_border_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_outline_border_color']['regular'] )) ? $alchemists_data['alchemists__button_outline_border_color']['regular'] : '#dbdfe6';
		$vars['btn-o-default-border-hover'] = ( isset( $alchemists_data['alchemists__button_outline_border_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_outline_border_color']['hover'] )) ? $alchemists_data['alchemists__button_outline_border_color']['hover'] : $vars['color-gray'];


		// Default Button Color
		$vars['btn-default-color'] = ( isset( $alchemists_data['alchemists__button_default_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_default_txt_color']['regular'] : '#fff';

		// Default Button Background Color
		$vars['btn-default-bg'] = ( isset( $alchemists_data['alchemists__button_default_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_default_bg_color']['regular'] : $vars['color-gray'];
		$vars['btn-default-hover'] = ( isset( $alchemists_data['alchemists__button_default_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_default_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_default_bg_color']['hover'] : '#868a91';


		// Default Alt Button Color
		$vars['btn-default-alt-color'] = ( isset( $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_default_alt_txt_color']['regular'] : '#fff';

		// Default Alt Button Background Color
		$vars['btn-default-alt-bg'] = ( isset( $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_default_alt_bg_color']['regular'] : $vars['color-2'];
		$vars['btn-default-alt-hover'] = ( isset( $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_default_alt_bg_color']['hover'] : $vars['color-dark-lighten'];


		// Button Primary Color
		$vars['btn-primary-color'] = ( isset( $alchemists_data['alchemists__button_primary_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_txt_color']['regular'] : '#fff';

		// Button Primary Background Color
		$vars['btn-primary-bg'] = ( isset( $alchemists_data['alchemists__button_primary_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_bg_color']['regular'] : $vars['color-2'];
		$vars['btn-primary-hover'] = ( isset( $alchemists_data['alchemists__button_primary_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_bg_color']['hover'] : $vars['color-primary-darken'];


		// Button Primary Inverse Color
		$vars['btn-primary-inverse-color'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_txt_color']['regular'] : '#fff';

		if ( alchemists_sp_preset('soccer') ) {
			// Button Primary Inverse Background Color
			$vars['btn-primary-inverse-bg'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] : $vars['color-primary'];
			$vars['btn-primary-inverse-hover'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] : $vars['color-primary-darken'];
		} else {
			// Button Primary Inverse Background Color
			$vars['btn-primary-inverse-bg'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['regular'] : $vars['color-primary-darken'];
			$vars['btn-primary-inverse-hover'] = ( isset( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] ) && !empty( $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] )) ? $alchemists_data['alchemists__button_primary_inverse_bg_color']['hover'] : $vars['color-3'];
		}


		// Top Bar
		$vars['header-top-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-bg'] : $vars['color-dark-lighten'];
		$vars['top-bar-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-link-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-link-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-link-color'] : '#fff';
		$vars['top-bar-highlight'] = ( isset( $alchemists_data['alchemists__header-top-bar-highlight'] ) && !empty( $alchemists_data['alchemists__header-top-bar-highlight'] ) ) ? $alchemists_data['alchemists__header-top-bar-highlight'] : $vars['color-primary'];
		$vars['top-bar-text-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-text-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-text-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-text-color'] : '#6b6d70';
		$vars['top-bar-divider-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-divider-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-divider-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-divider-color'] : $vars['top-bar-text-color'];
		$vars['top-bar-dropdown-bg'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-bg'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-bg'] ) ) ? $alchemists_data['alchemists__header-top-bar-dropdown-bg'] : '#fff';
		$vars['top-bar-dropdown-border'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] ) ) ? $alchemists_data['alchemists__header-top-bar-dropdown-border-color'] : 'rgba(255,255,255,.03)';


		if ( alchemists_sp_preset('soccer') ) {
			$vars['top-bar-dropdown-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] : $vars['color-2'];
			$vars['top-bar-dropdown-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] : $vars['color-primary'];
		} else {
			$vars['top-bar-dropdown-link-color'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['regular'] : $vars['color-gray'];
			$vars['top-bar-dropdown-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-top-bar-dropdown-link-color']['hover'] : $vars['color-2'];
		}

		// Header Secondary Background
		$vars['header-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark'];
		$vars['header-secondary-bg'] = ( isset( $alchemists_data['alchemists__header-secondary-bg'] ) && !empty( $alchemists_data['alchemists__header-secondary-bg'] ) ) ? $alchemists_data['alchemists__header-secondary-bg'] : $vars['color-dark'];

		// Header Primary Background
		$vars['header-primary-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) )  ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark-lighten'];
		$vars['header-primary-alt-bg'] = ( isset( $alchemists_data['alchemists__header-primary-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-bg'] ) )  ? $alchemists_data['alchemists__header-primary-bg'] : $vars['color-dark-lighten'];

		// Header Primary Links Color
		$vars['nav-font-color'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['regular'] : '#fff';

		if ( alchemists_sp_preset('soccer') ) {
			$vars['nav-font-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['hover'] : '#fff';
		} else {
			$vars['nav-font-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-font-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-font-color']['hover'] : $vars['color-primary'];
		}

		// Header Primary Link Border Color
		$vars['nav-active-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-border-color'] : $vars['color-primary'];


		if ( alchemists_sp_preset('soccer')) {
			// Header Primary Link Border Height
			$vars['nav-active-border-height'] = ( isset( $alchemists_data['alchemists__header-primary-border-height']['height'] ) && !empty( $alchemists_data['alchemists__header-primary-border-height']['height'] ) )  ? $alchemists_data['alchemists__header-primary-border-height']['height'] : '100%';

			// Header Submenu Background Color
			$vars['nav-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-bg'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-bg'] : $vars['color-dark'];

			// Header Submenu Border Color
			$vars['nav-sub-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-border-color'] : '#292c31';

			// Header Submenu Link Color
			$vars['nav-sub-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] : '#fff';
			$vars['nav-sub-hover-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] : $vars['color-4'];

			// Header Submenu Caret Color
			$vars['nav-sub-caret-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) ) ? $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] : '#fff';

			// Megamenu Text Color
			$vars['nav-sub-megamenu-txt-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) ) ? $alchemists_data['alchemists__header-primary-megamenu-txt-color'] : $vars['color-gray'];

			// Megamenu Link Color
			$vars['nav-sub-megamenu-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] : '#78797C';
			$vars['nav-sub-megamenu-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] : '#fff';

			// Megamenu Widget Meta Links Color
			$vars['nav-sub-megamenu-meta-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] : $vars['color-gray'];
			$vars['nav-sub-megamenu-meta-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] : $vars['color-gray'];

			// Megamenu Title Color
			$vars['nav-sub-megamenu-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-title-color'] : '#fff';
		
			// Megamenu Post Title Color
			$vars['nav-sub-megamenu-post-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] : '#fff';

		} else {

			// Header Primary Link Border Height
			$vars['nav-active-border-height'] = ( isset( $alchemists_data['alchemists__header-primary-border-height']['height'] ) && !empty( $alchemists_data['alchemists__header-primary-border-height']['height'] ) )  ? $alchemists_data['alchemists__header-primary-border-height']['height'] : '2px';

			// Header Submenu Background Color
			$vars['nav-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-bg'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-bg'] : '#fff';

			// Header Submenu Border Color
			$vars['nav-sub-border-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-border-color'] : '#e4e7ed';

			// Header Submenu Link Color
			$vars['nav-sub-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['regular'] : $vars['color-2'];
			$vars['nav-sub-hover-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-submenu-link-color']['hover'] : $vars['color-2'];

			// Header Submenu Caret Color
			$vars['nav-sub-caret-color'] = ( isset( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) && !empty( $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] ) ) ? $alchemists_data['alchemists__header-primary-submenu-dropdown-caret-color'] : $vars['color-2'];

			// Megamenu Text Color
			$vars['nav-sub-megamenu-txt-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-txt-color'] ) ) ? $alchemists_data['alchemists__header-primary-megamenu-txt-color'] : $vars['color-gray'];

			// Megamenu Link Color
			$vars['nav-sub-megamenu-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['regular'] : '#adb3b7';
			$vars['nav-sub-megamenu-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-link-color']['hover'] : $vars['color-2'];

			// Megamenu Widget Meta Links Color
			$vars['nav-sub-megamenu-meta-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['regular'] : $vars['color-gray'];
			$vars['nav-sub-megamenu-meta-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-widget-meta-color']['hover'] : $vars['color-gray'];

			// Megamenu Title Color
			$vars['nav-sub-megamenu-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-title-color'] : $vars['color-2'];
			
			// Megamenu Post Title Color
			$vars['nav-sub-megamenu-post-title-color'] = ( isset( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) && !empty( $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] ) )  ? $alchemists_data['alchemists__header-primary-megamenu-post-title-color'] : $vars['color-2'];
		}

		// Mobile Nav Background Color
		$vars['nav-mobile-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-nav-bg'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-nav-bg'] : $vars['color-dark'];

		// Mobile Nav Burger Menu Color
		$vars['nav-mobile-burger-icon'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-burger-icon-color'] : '#fff';

		// Header Mobile Background Color
		$vars['header-mobile-bg'] = ( isset( $alchemists_data['alchemists__mobile-header-bg'] ) && !empty( $alchemists_data['alchemists__mobile-header-bg'] ) ) ? $alchemists_data['alchemists__mobile-header-bg'] : $vars['color-dark'];

		// Mobile Nav Links Color
		$vars['nav-mobile-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-link-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-link-color'] : '#fff';

		// Mobile Nav Links Color
		$vars['nav-mobile-border'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-border-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-border-color'] : $vars['color-dark-lighten'];

		// Mobile Nav Submenu Background Color
		$vars['nav-mobile-sub-bg'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-bg'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-sub-bg'] : $vars['color-dark-lighten'];

		// Mobile Nav Submenu Links Color
		$vars['nav-mobile-sub-color'] = ( isset( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) && !empty( $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] ) )  ? $alchemists_data['alchemists__header-primary-mobile-sub-link-color'] : $vars['color-gray'];


		// Social Link Color
		$vars['header-social-link-color'] = ( isset( $alchemists_data['alchemists__header-primary-social-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-primary-social-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-primary-social-link-color']['regular'] : '#fff';
		$vars['header-social-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-primary-social-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-primary-social-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-primary-social-link-color']['hover'] : $colors['color_primary'];


		// Header Info Block
		if ( alchemists_sp_preset('soccer')) {
			$vars['header-info-block-color'] = ( isset( $alchemists_data['alchemists__header-info-block-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-color'] ) )  ? $alchemists_data['alchemists__header-info-block-color'] : $vars['color-4'];
			
			$vars['header-info-block-cart-sum-color'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color'] : $vars['color-4'];
		} else {
			$vars['header-info-block-color'] = ( isset( $alchemists_data['alchemists__header-info-block-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-color'] ) )  ? $alchemists_data['alchemists__header-info-block-color'] : $vars['color-primary'];

			$vars['header-info-block-cart-sum-color'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color'] : $vars['color-primary'];
		}

		$vars['header-info-block-title-color'] = ( isset( $alchemists_data['alchemists__header-info-block-title-color'] ) && !empty( $alchemists_data['alchemists__header-info-block-title-color'] ) )  ? $alchemists_data['alchemists__header-info-block-title-color'] : '#fff';

		$vars['header-info-block-cart-sum-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) && !empty( $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] ) )  ? $alchemists_data['alchemists__header-info-block-cart-sum-color-mobile'] : $vars['color-primary'];

		$vars['header-info-block-link-color'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['regular'] : '#6b6d70';

		$vars['header-info-block-link-color-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color']['hover'] : '#fff';

		$vars['header-info-block-link-color-mobile'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['regular'] : '#6b6d70';
		$vars['header-info-block-link-color-mobile-hover'] = ( isset( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) && !empty( $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] ) )  ? $alchemists_data['alchemists__header-info-link-color-mobile']['hover'] : '#fff';


		// Search Form

		// background color - desktop
		$vars['header-search-input-bg'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-bg']['regular'] : $vars['color-dark-lighten'];
		$vars['header-search-input-bg-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-bg']['active'] : $vars['color-dark-lighten'];

		// border color - desktop
		$vars['header-search-input-border'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-border']['regular'] : $vars['color-dark-lighten'];
		$vars['header-search-input-border-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-border']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-border']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-border']['active'] : $vars['color-dark-lighten'];

		// text color - desktop
		$vars['header-search-input-txt'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-txt']['regular'] : 'rgba(154, 157, 162, 0.6)';
		$vars['header-search-input-txt-focus'] = ( isset( $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-desktop-txt']['active'] : '#fff';

		if ( alchemists_sp_preset('soccer')) {
			// submit icon color - desktop
			$vars['header-search-icon'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] : '#fff';
			$vars['header-search-icon-hover'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] : '#fff';
		} else {
			// submit icon color - desktop
			$vars['header-search-icon'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['regular'] : $vars['color-primary'];
			$vars['header-search-icon-hover'] = ( isset( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) && !empty( $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] ) ) ? $alchemists_data['alchemists__header-search-form-submit-icon-color']['hover'] : $vars['color-primary'];
		}

		// background color - mobile
		$vars['header-search-input-bg-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-bg']['regular'] : $vars['color-dark-lighten'];
		$vars['header-search-input-bg-focus-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-bg']['active'] : $vars['color-dark-lighten'];

		// border color - mobile
		$vars['header-search-input-border-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-border']['regular'] : $vars['color-dark-lighten'];
		$vars['header-search-input-border-focus-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-border']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-border']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-border']['active'] : $vars['color-dark-lighten'];

		// text color - mobile
		$vars['header-search-input-txt-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-txt']['regular'] : 'rgba(154, 157, 162, 0.6)';
		$vars['header-search-input-txt-mobile-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-txt']['active'] : '#fff';

		// submit icon color - mobile

		if ( alchemists_sp_preset('soccer')) {
			$vars['header-search-icon-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] : '#fff';
			$vars['header-search-icon-mobile-active'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] : '#fff';
		} else {
			$vars['header-search-icon-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['regular'] : $vars['color-primary'];
			$vars['header-search-icon-mobile-active'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-icon-color']['active'] : $vars['color-primary'];
		}

		// submit trigger icon - color
		$vars['header-search-icon-trigger-mobile'] = ( isset( $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] ) && !empty( $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] ) ) ? $alchemists_data['alchemists__header-search-form-mobile-submit-trigger-icon-color'] : '#fff';

		// Content Filter Colors
		$vars['content-filter-color'] = ( isset( $alchemists_data['alchemists__content-content-filter']['regular'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['regular'] )) ? $alchemists_data['alchemists__content-content-filter']['regular'] : $vars['color-gray']; // done
		$vars['content-filter-color-hover'] = ( isset( $alchemists_data['alchemists__content-content-filter']['hover'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['hover'] )) ? $alchemists_data['alchemists__content-content-filter']['hover'] : $vars['color-2']; // done
		$vars['content-filter-color-active'] = ( isset( $alchemists_data['alchemists__content-content-filter']['active'] ) && !empty( $alchemists_data['alchemists__content-content-filter']['active'] )) ? $alchemists_data['alchemists__content-content-filter']['active'] : $vars['color-2']; // done


		// Blog Categories Group 1
		$vars['post-category-1'] = ( isset( $alchemists_data['alchemists__blog-cat-group-1'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-1'] ) ) ? $alchemists_data['alchemists__blog-cat-group-1'] : $vars['color-primary-darken'];
		// Blog Categories Group 2
		$vars['post-category-2'] = ( isset( $alchemists_data['alchemists__blog-cat-group-2'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-2'] ) ) ? $alchemists_data['alchemists__blog-cat-group-2'] : $vars['color-4'];
		// Blog Categories Group 3
		$vars['post-category-3'] = ( isset( $alchemists_data['alchemists__blog-cat-group-3'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-3'] ) ) ? $alchemists_data['alchemists__blog-cat-group-3'] : $vars['color-3'];
		// Blog Categories Group 4
		$vars['post-category-4'] = ( isset( $alchemists_data['alchemists__blog-cat-group-4'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-4'] ) ) ? $alchemists_data['alchemists__blog-cat-group-4'] : $vars['color-primary-darken'];
		// Blog Categories Group 5
		$vars['post-category-5'] = ( isset( $alchemists_data['alchemists__blog-cat-group-5'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-5'] ) ) ? $alchemists_data['alchemists__blog-cat-group-5'] : $vars['color-primary-darken'];
		// Blog Categories Group 6
		$vars['post-category-6'] = ( isset( $alchemists_data['alchemists__blog-cat-group-6'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-6'] ) )  ? $alchemists_data['alchemists__blog-cat-group-6'] : $vars['color-primary-darken'];
		// Blog Categories Group 7
		$vars['post-category-7'] = ( isset( $alchemists_data['alchemists__blog-cat-group-7'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-7'] ) )  ? $alchemists_data['alchemists__blog-cat-group-7'] : $vars['color-primary-darken'];
		// Blog Categories Group 8
		$vars['post-category-8'] = ( isset( $alchemists_data['alchemists__blog-cat-group-8'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-8'] ) )  ? $alchemists_data['alchemists__blog-cat-group-8'] : $vars['color-primary-darken'];
		// Blog Categories Group 9
		$vars['post-category-9'] = ( isset( $alchemists_data['alchemists__blog-cat-group-9'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-9'] ) )  ? $alchemists_data['alchemists__blog-cat-group-9'] : $vars['color-primary-darken'];
		// Blog Categories Group 10
		$vars['post-category-10'] = ( isset( $alchemists_data['alchemists__blog-cat-group-10'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-10'] ) )  ? $alchemists_data['alchemists__blog-cat-group-10'] : $vars['color-primary-darken'];
		// Blog Categories Group 11
		$vars['post-category-11'] = ( isset( $alchemists_data['alchemists__blog-cat-group-11'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-11'] ) )  ? $alchemists_data['alchemists__blog-cat-group-11'] : $vars['color-primary-darken'];
		// Blog Categories Group 12
		$vars['post-category-12'] = ( isset( $alchemists_data['alchemists__blog-cat-group-12'] ) && !empty( $alchemists_data['alchemists__blog-cat-group-12'] ) )  ? $alchemists_data['alchemists__blog-cat-group-12'] : $vars['color-primary-darken'];

		// Footer Background
		if ( isset( $alchemists_data['alchemists__footer-widgets-bg'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg'] ) ) {
			if ( isset( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-color'] ) || isset( $alchemists_data['alchemists__footer-widgets-bg']['background-image'] ) && !empty( $alchemists_data['alchemists__footer-widgets-bg']['background-image'] ) ) {
				$vars['footer-widgets-bg'] = 'url(' . $alchemists_data['alchemists__footer-widgets-bg']['background-image'] . ') ' . $alchemists_data['alchemists__footer-widgets-bg']['background-color'];
			} else {
				$vars['footer-widgets-bg'] = $vars['color-dark'];
			}
		} else {
			$vars['footer-widgets-bg'] = $vars['color-dark'];
		}

		if ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color'] ) ) {
			$vars['footer-widgets-overlay'] = ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] ) ) ? $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['color'] : $vars['color-dark']; // done

			$vars['footer-widgets-overlay-opacity'] = ( isset( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] ) && !empty( $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] ) ) ? $alchemists_data['alchemists__footer-widgets--overlay-color-customize']['alpha'] : '0.8'; // done
		}

		if ( alchemists_sp_preset('soccer') ) {
			$vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : '#16171a';
		} else {
			$vars['footer-secondary-bg'] = ( isset( $alchemists_data['alchemists__footer-secondary-bg'] ) && !empty( $alchemists_data['alchemists__footer-secondary-bg'] ) ) ? $alchemists_data['alchemists__footer-secondary-bg'] : $vars['color-dark'];
		}
		
		$vars['footer-secondary-side-bg'] = ( isset( $alchemists_data['alchemists__footer-side-decoration-bg'] ) && !empty( $alchemists_data['alchemists__footer-side-decoration-bg'] ) ) ? $alchemists_data['alchemists__footer-side-decoration-bg'] : $vars['color-primary'];

		$vars['footer-copyright-border-color'] = ( isset( $alchemists_data['alchemists__footer-secondary-border-color'] ) && !empty( $alchemists_data['alchemists__footer-secondary-border-color'] ) ) ? $alchemists_data['alchemists__footer-secondary-border-color'] : 'transparent';

		$vars['footer-widget-link-color'] = ( isset( $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] ) && !empty( $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] ) ) ? $alchemists_data['alchemists__footer-widgets-list-link-color']['regular'] : '#6b6d70';

		$vars['footer-widget-link-color-hover'] = ( isset( $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] ) && !empty( $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] ) ) ? $alchemists_data['alchemists__footer-widgets-list-link-color']['hover'] : $vars['color-primary'];


		// Typography

		// Body
		if ( $alchemists_data['alchemists__custom_body_font'] ) {
			$vars['font-family-base'] = ( isset( $alchemists_data['alchemists__typography-body']['font-family'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-family'] ) ) ? $alchemists_data['alchemists__typography-body']['font-family'] : 'Source Sans Pro, sans-serif';
			$vars['base-font-size'] = ( isset( $alchemists_data['alchemists__typography-body']['font-size'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-size'] ) ) ? $alchemists_data['alchemists__typography-body']['font-size'] : '15px';
			$vars['base-line-height'] = ( isset( $alchemists_data['alchemists__typography-body']['line-height'] ) && !empty( $alchemists_data['alchemists__typography-body']['line-height'] ) ) ? $alchemists_data['alchemists__typography-body']['line-height'] : '26px';
			$vars['body-font-weight'] = ( isset( $alchemists_data['alchemists__typography-body']['font-weight'] ) && !empty( $alchemists_data['alchemists__typography-body']['font-weight'] ) ) ? $alchemists_data['alchemists__typography-body']['font-weight'] : '400';
			$vars['body-font-color'] = ( isset( $alchemists_data['alchemists__typography-body']['color'] ) && !empty( $alchemists_data['alchemists__typography-body']['color'] ) ) ? $alchemists_data['alchemists__typography-body']['color'] : '#9a9da2';
		}


		if ( $alchemists_data['alchemists__custom_heading_font'] ) {

			// Font Family Accent
			$vars['font-family-accent'] = ( isset( $alchemists_data['font-family-accent']['font-family'] ) && !empty( $alchemists_data['font-family-accent']['font-family'] ) ) ? $alchemists_data['font-family-accent']['font-family'] : 'Montserrat';

			// Headings
			$vars['headings-font-family'] = ( isset( $alchemists_data['headings-typography']['font-family'] ) && !empty( $alchemists_data['headings-typography']['font-family'] ) ) ? $alchemists_data['headings-typography']['font-family'] : 'Montserrat';
			$vars['headings-color'] = ( isset( $alchemists_data['headings-typography']['color'] ) && !empty( $alchemists_data['headings-typography']['color'] ) ) ? $alchemists_data['headings-typography']['color'] : '#31404b';
		}

		// Heading Links
		$vars['post-title-color'] = ( isset( $alchemists_data['alchemists__custom_heading_link_color']['regular'] ) && !empty( $alchemists_data['alchemists__custom_heading_link_color']['regular'] ) ) ? $alchemists_data['alchemists__custom_heading_link_color']['regular'] : $vars['color-2'];

		$vars['post-title-color-hover'] = ( isset( $alchemists_data['alchemists__custom_heading_link_color']['hover'] ) && !empty( $alchemists_data['alchemists__custom_heading_link_color']['hover'] ) ) ? $alchemists_data['alchemists__custom_heading_link_color']['hover'] : '#4f6779';

		// Navigation
		if ( $alchemists_data['alchemists__custom_nav-font'] ) {
			$vars['nav-font-family'] = ( isset( $alchemists_data['alchemists__nav-font']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font']['font-family'] : 'Montserrat, sans-serif';
			$vars['nav-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font']['text-transform'] : 'uppercase';
			$vars['nav-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font']['font-weight'] : '700';
			$vars['nav-font-style'] = ( isset( $alchemists_data['alchemists__nav-font']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font']['font-style'] : 'normal';
			$vars['nav-font-size'] = ( isset( $alchemists_data['alchemists__nav-font']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font']['font-size'] : '12px';

			$vars['nav-sub-font-family'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-family'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-family'] : 'Montserrat, sans-serif';
			$vars['nav-sub-text-transform'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['text-transform'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['text-transform'] : 'uppercase';
			$vars['nav-sub-font-weight'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-weight'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-weight'] : '700';
			$vars['nav-sub-font-style'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-style'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-style'] : 'normal';
			$vars['nav-sub-font-size'] = ( isset( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) && !empty( $alchemists_data['alchemists__nav-font-sub']['font-size'] ) ) ? $alchemists_data['alchemists__nav-font-sub']['font-size'] : '11px';
		}

		// Preloader
		if ( $alchemists_data['alchemists__opt-custom_pageloader'] ) {

			$vars['preloader-bg'] = ( isset( $alchemists_data['alchemists__opt-preloader-bg'] ) && !empty( $alchemists_data['alchemists__opt-preloader-bg'] ) ) ? $alchemists_data['alchemists__opt-preloader-bg'] : $vars['color-dark'];
			$vars['preloader-size'] = ( isset( $alchemists_data['alchemists__opt-preloader-size']['width'] ) && !empty( $alchemists_data['alchemists__opt-preloader-size']['width'] ) ) ? $alchemists_data['alchemists__opt-preloader-size']['width'] : '32px';
			$vars['preloader-color'] = ( isset( $alchemists_data['alchemists__opt-preloader-color'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color'] ) ) ? $alchemists_data['alchemists__opt-preloader-color'] : $vars['color-primary'];
			$vars['preloader-color-secondary'] = ( isset( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) && !empty( $alchemists_data['alchemists__opt-preloader-color-secondary'] ) ) ? $alchemists_data['alchemists__opt-preloader-color-secondary'] : 'rgba(255,255,255, 0.15)';
			$vars['preloader-spin-duration'] = ( isset( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) && !empty( $alchemists_data['alchemists__opt-preloader-spin-duration'] ) ) ? $alchemists_data['alchemists__opt-preloader-spin-duration'] . 's' : '0.8s';
		}
	}

	return $vars;
}
