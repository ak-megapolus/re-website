<?php
/**
 * RE-Material functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RE-Material
 */

if ( ! defined( 'RE_MATERIAL_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'RE_MATERIAL_VERSION', '1.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function re_material_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'RE-Material', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
}

// Adds theme support for post formats.
if ( ! function_exists( 're_material_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return void
	 */
	function re_material_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 're_material_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 're_material_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return void
	 */
	function re_material_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 're_material_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 're_material_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return void
	 */
	function re_material_enqueue_styles() {
		wp_enqueue_style(
			're_material-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 're_material_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 're_material_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return void
	 */
	function re_material_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 're_material' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 're_material_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 're_material_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return void
	 */
	function re_material_pattern_categories() {

		register_block_pattern_category(
			're_material_page',
			array(
				'label'       => __( 'Pages', 're_material' ),
				'description' => __( 'A collection of full page layouts.', 're_material' ),
			)
		);

		register_block_pattern_category(
			're_material_post-format',
			array(
				'label'       => __( 'Post formats', 're_material' ),
				'description' => __( 'A collection of post format patterns.', 're_material' ),
			)
		);
	}
endif;
add_action( 'init', 're_material_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 're_material_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return void
	 */
	function re_material_register_block_bindings() {
		register_block_bindings_source(
			're_material/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 're_material' ),
				'get_value_callback' => 're_material_format_binding',
			)
		);
	}
endif;
add_action( 'init', 're_material_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 're_material_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since RE-Material 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function re_material_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
