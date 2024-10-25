<?php

namespace DOWP\AiContentGenerate\Admin;

/**
 * AdminHooks class
 */
class AdminHooks {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', [ __CLASS__, 'register_menu' ] );
		add_action( 'in_admin_header', [ __CLASS__, 'remove_all_notices' ], 9999 );
		add_action( 'edit_form_after_title', [ __CLASS__, 'chatgpt_add_button' ] );
	}

	public static function chatgpt_add_button() {
		//echo '<button id="dowp-ai-content-generate-btn" class="button button-primary" style="margin-top: 10px;">ChatGPT</button>';
        ?>
            <div class="edit-post-header__toolbar"></div>
            <?php
	}

	/**
	 * Register Menu
	 *
	 * @return void
	 */
	public static function register_menu() {
		add_menu_page(
			esc_html__( 'AI Content Generate', 'ai-content-generate' ),
			esc_html__( 'AI Content Generate', 'ai-content-generate' ),
			'manage_options',
			'ai-content-generate-settings',
			[ __CLASS__, 'ai_content_settings' ],
			AI_CONTENT_PLUGIN_URL . '/assets/img/icon.svg',
			100
		);
	}

	/**
	 * Ai content settings page CBF
	 *
	 * @return void
	 */
	public static function ai_content_settings() {
		?>
        <div class="wrap ai-content-generate-wrap">
            <div id="ai-content-generate-app"></div>
        </div>
		<?php
	}

	/**
	 * Remove all notice from AI content settings page
	 *
	 * @return void
	 */
	public static function remove_all_notices() {
		$screen = get_current_screen();
		if ( isset( $screen->base ) && ( 'toplevel_page_ai-content-generate-settings' == $screen->base ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}
}