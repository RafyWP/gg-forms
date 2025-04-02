<?php

namespace RafyCo\GGForms;

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin class.
 */
class Plugin {

	public function run() {
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_frontend_assets' ] );
	}

	public function init() {
		$this->register_static_blocks();
		$this->register_dynamic_blocks();
		add_filter( 'query_vars', [ $this, 'add_query_vars' ] );
		add_action( 'init', [ $this, 'register_rewrite_rule' ] );
		add_action( 'template_redirect', [ $this, 'render_landing_page' ] );
	}	

	public function enqueue_frontend_assets() {
		if ( is_admin() ) {
			return;
		}

		wp_enqueue_style(
			'swiper-styles',
			plugins_url( 'public/swiper-bundle.min.css', __DIR__ ),
			[],
			'11.2.6'
		);

		wp_enqueue_style(
			'ggf-styles',
			plugins_url( 'public/gg-forms-styles.css', __DIR__ ),
			[],
			filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/gg-forms-styles.css' ),
		);
	
		wp_enqueue_script(
			'swiper-scripts',
			plugins_url( 'public/swiper-bundle.min.js', __DIR__ ),
			[],
			'11.2.6',
			true
		);

		wp_enqueue_script(
			'ggf-scripts',
			plugins_url( 'public/gg-forms-scripts.js', __DIR__ ),
			[],
			filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'public/gg-forms-scripts.js' ),
			true
		);
	}

	private function register_static_blocks() {
		$build_path        = plugin_dir_path( __DIR__ ) . 'build';
		$manifest_filepath = $build_path . '/blocks-manifest.php';

		if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
			wp_register_block_types_from_metadata_collection( $build_path, $manifest_filepath );
			return;
		}

		if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
			wp_register_block_metadata_collection( $build_path, $manifest_filepath );
		}

		$manifest_data = require $manifest_filepath;
		foreach ( array_keys( $manifest_data ) as $block_type ) {
			register_block_type( $build_path . "/{$block_type}" );
		}
	}

	private function register_dynamic_blocks() {
		register_block_type(
			plugin_dir_path( __DIR__ ) . 'build/gg-story',
			[
				'render_callback' => [ $this, 'render_gg_story_block' ],
			]
		);
	}

	public function render_gg_story_block( $attributes, $content ) {
		ob_start();
		include plugin_dir_path( __DIR__ ) . 'render.php';
		return ob_get_clean();
	}

	public function add_query_vars( $vars ) {
		$vars[] = 'gg_forms_affiliate';
		return $vars;
	}	

	public function register_rewrite_rule() {
		add_rewrite_tag( '%gg_forms_affiliate%', '1' );
		add_rewrite_rule( '^gg-forms/?$', 'index.php?gg_forms_affiliate=1', 'top' );
	}	

	public function render_landing_page() {
		if ( get_query_var( 'gg_forms_affiliate' ) ) {
			$html_path = plugin_dir_path( __DIR__ ) . 'public/gg-forms-affiliate.php';
			if ( file_exists( $html_path ) ) {
				header( 'Content-Type: text/html; charset=utf-8' );
				include $html_path;
				exit;
			} else {
				wp_die(
					esc_html__( 'Landing page not found.', 'gg-forms' ),
					esc_html__( 'Error', 'gg-forms' ),
					[ 'response' => 404 ]
				);
			}
		}
	}		

	public function register_admin_menu() {
		add_menu_page(
			__( 'GG Forms', 'gg-forms' ),
			__( 'GG Forms', 'gg-forms' ),
			'manage_options',
			'gg-forms-settings',
			[ $this, 'render_settings_page' ],
			'dashicons-feedback',
			30
		);

		add_submenu_page(
			'gg-forms-settings',
			__( 'Affiliate', 'gg-forms' ),
			__( 'Affiliate', 'gg-forms' ),
			'manage_options',
			'gg-forms-affiliate',
			[ $this, 'render_affiliate_link_page' ]
		);

		add_submenu_page(
			'gg-forms-settings',
			__( 'Stats', 'gg-forms' ),
			__( 'Stats', 'gg-forms' ),
			'manage_options',
			'gg-forms-stats',
			[ $this, 'render_stats_page' ]
		);

		add_settings_section(
			'gg_forms_affiliate_section',
			__( 'Review Settings', 'gg-forms' ),
			'__return_false',
			'gg_forms_affiliate'
		);
		
		register_setting( 'gg_forms_affiliate', 'review_author_type' );
		register_setting( 'gg_forms_affiliate', 'review_author_name' );
		register_setting( 'gg_forms_affiliate', 'review_datePublished' );
		register_setting( 'gg_forms_affiliate', 'reviewRating' );
		register_setting( 'gg_forms_affiliate', 'reviewBody' );
		register_setting( 'gg_forms_affiliate', 'gg_forms_affiliate_link' );
		
		add_settings_field(
			'review_author_type',
			__( 'Author Type', 'gg-forms' ),
			function () {
				$value = get_option( 'review_author_type', 'Person' );
				?>
				<select name="review_author_type">
					<option value="Person" <?php selected( $value, 'Person' ); ?>>Person</option>
					<option value="Organization" <?php selected( $value, 'Organization' ); ?>>Organization</option>
				</select>
				<?php
			},
			'gg_forms_affiliate',
			'gg_forms_affiliate_section'
		);
		
		add_settings_field(
			'review_author_name',
			__( 'Author Name', 'gg-forms' ),
			function () {
				$value = esc_attr( get_option( 'review_author_name', '' ) );
				echo "<input type='text' name='review_author_name' value='$value' />";
			},
			'gg_forms_affiliate',
			'gg_forms_affiliate_section'
		);
		
		add_settings_field(
			'review_datePublished',
			__( 'Date Published', 'gg-forms' ),
			function () {
				$value = esc_attr( get_option( 'review_datePublished', date('Y-m-d') ) );
				echo "<input type='hidden' name='review_datePublished' value='$value' />";
				echo "<span>$value</span>";
			},
			'gg_forms_affiliate',
			'gg_forms_affiliate_section'
		);
		
		add_settings_field(
			'reviewRating',
			__( 'Review Rating (0–5)', 'gg-forms' ),
			function () {
				$value = esc_attr( get_option( 'reviewRating', '5' ) );
				echo "<input type='number' min='0' max='5' step='0.1' name='reviewRating' value='$value' />";
			},
			'gg_forms_affiliate',
			'gg_forms_affiliate_section'
		);
		
		add_settings_field(
			'reviewBody',
			__( 'Review Text', 'gg-forms' ),
			function () {
				$value = esc_textarea( get_option( 'reviewBody', '' ) );
				echo "<textarea name='reviewBody' rows='4' cols='50'>$value</textarea>";
			},
			'gg_forms_affiliate',
			'gg_forms_affiliate_section'
		);

		add_settings_field(
			'gg_forms_affiliate_link',
			__( 'Affiliate Link', 'gg-forms' ),
			function () {
				$value = esc_attr( get_option( 'gg_forms_affiliate_link', '' ) );
				echo "<input type='url' name='gg_forms_affiliate_link' value='$value' />";
			},
			'gg_forms_affiliate',
			'gg_forms_affiliate_section'
		);
	}

	public function render_settings_page() {
		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'GG Forms Settings', 'gg-forms' ) . '</h1>';
		echo '<p>' . esc_html__( 'Future configuration options will appear here.', 'gg-forms' ) . '</p>';
		echo '</div>';
	}

	public function render_affiliate_link_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'GG Forms Affiliate Program', 'gg-forms' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'gg_forms_affiliate' );
				do_settings_sections( 'gg_forms_affiliate' );
				submit_button();
				echo '<p><a href="' . esc_url( home_url( '/gg-forms' ) ) . '" target="_blank" class="button">' . esc_html__( 'View Landing Page', 'gg-forms' ) . '</a></p>';
				?>
			</form>
		</div>
		<?php
	}	

	public function render_stats_page() {
		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'GG Forms Stats', 'gg-forms' ) . '</h1>';
		echo '<p>' . esc_html__( 'Soon: insights and form performance data.', 'gg-forms' ) . '</p>';
		echo '</div>';
	}
}
