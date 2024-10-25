<?php

namespace DOWP\AiContentGenerate\Controllers;

/**
 * BlocksController class
 */
class BlocksController {

	/**
	 * Css Handler to generate dynamic ss for guten blocks
	 */
	private $version;

	/**
	 * Class Constructor
	 */
	public function __construct() {
		$this->version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : AI_CONTENT_VERSION;
		add_action( 'enqueue_block_editor_assets', [ $this, 'editor_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'editor_assets' ] );
	}

	public function is_gutenberg_page() {
		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();

			return $screen && method_exists( $screen, 'is_block_editor' ) && $screen->is_block_editor();
		}

		return false;
	}

	/**
	 * Load Editor Assets
	 *
	 * @return void
	 */
	public function editor_assets( $screen ) {
		if ( 'post.php' !== $screen ) {
			return;
		}

		$dependency = [ 'wp-components', 'wp-element', 'wp-api-fetch' ];

		// Block editor css.

		// Main compile css and js file.
		wp_enqueue_style( 'dowp-blocks-css', dowpAIC()->get_assets_uri( 'blocks/main.css' ), '', $this->version );
		wp_enqueue_script( 'dowp-blocks-js', dowpAIC()->get_assets_uri( 'blocks/main.js' ), $dependency, $this->version, true );

		wp_localize_script(
			'dowp-blocks-js',
			'dowpParams',
			[
				'editor_type'     => $this->is_gutenberg_page() ? 'gutenberg' : 'classic',
				'nonce'           => wp_create_nonce( 'dowp_nonce' ),
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'site_url'        => site_url(),
				'admin_url'       => admin_url(),
				'plugin_url'      => AI_CONTENT_PLUGIN_URL,
				'current_user_id' => get_current_user_id(),
				'avatar'          => esc_url( get_avatar_url( get_current_user_id() ) ),
			]
		);
	}
}
