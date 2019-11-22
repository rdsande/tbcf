<?php
/**
 * Setup Elementor widgets.
 *
 * @package The7
 */

use \Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

/**
 * Class The7_Elementor_Widgets
 */
class The7_Elementor_Widgets {

	public function bootstrap() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_preview_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		add_action( 'wp_ajax_the7_elements_get_widget_taxonomies', [ $this, 'ajax_return_taxonomies' ] );
		add_action(
			'elementor/editor/after_save',
			function ( $post_id, $editor_data ) {
				The7_Elements_Widget::delete_widgets_css_cache( $post_id );
				$this->generate_and_save_widget_css( $post_id, $editor_data );
			},
			10,
			2
		);
		add_action( 'elementor/init', [ $this, 'elementor_add_custom_category' ] );

		presscore_template_manager()->add_path( 'elementor', array( 'template-parts/elementor' ) );
	}

	/**
	 * Register widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		$widgets_manager->register_widget_type( new The7_Elements_Widget() );
	}

	public function elementor_add_custom_category() {
		require_once dirname( __FILE__ ) . '/class-the7-elements-widget.php';

		Plugin::$instance->elements_manager->add_category(
			'the7-elements',
			[
				'title' => esc_html__( 'The7 elements', 'the7mk2' ),
				'icon'  => 'fa fa-header',
			]
		);
	}

	public function generate_and_save_widget_css( $post_id, $editor_data ) {
		foreach ( $editor_data as $element ) {
			if ( isset( $element['widgetType'] ) && $element['widgetType'] === 'the7_elements' ) {
				$widget = new The7_Elements_Widget( $element, [] );
				$widget->save_css( $post_id );
			}

			if ( ! empty( $element['elements'] ) ) {
				$this->generate_and_save_widget_css( $post_id, $element['elements'] );
			}
		}
	}

	public function register_preview_scripts() {
		wp_register_script(
			'the7-elements-widget-preview',
			PRESSCORE_ADMIN_URI . '/assets/js/elementor/elements-widget-preview.js',
			[],
			false,
			true
		);

		if ( Plugin::$instance->preview->is_preview_mode() ) {
			the7_register_style( 'the7-elementor-editor', PRESSCORE_ADMIN_URI . '/assets/css/elementor-editor' );
			wp_enqueue_style( 'the7-elementor-editor' );
		}
	}

	public function enqueue_editor_scripts() {
		wp_enqueue_script(
			'the7-elements-widget-settings',
			PRESSCORE_ADMIN_URI . '/assets/js/elementor/elements-widget-settings.js'
		);
		wp_localize_script(
			'the7-elements-widget-settings',
			'the7ElementsWidget',
			[
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'_wpnonce' => wp_create_nonce( 'the7-elements-ajax' ),
			]
		);
	}

	public function ajax_return_taxonomies() {
		check_admin_referer( 'the7-elements-ajax' );

		$post_types = array_keys( The7_Elements_Widget::get_supported_post_types() );
		$taxonomies = [];
		$terms = [];
		foreach ( $post_types as $post_type ) {
			$tax_objects = get_object_taxonomies( $post_type, 'objects' );
			$taxonomies[ $post_type ] = [];
			foreach ( $tax_objects as $tax ) {
				if ( $tax->name === 'post_format' ) {
					continue;
				}

				$taxonomies[ $post_type ][] = [
					'value' => $tax->name,
					'label' => $tax->label,
				];

				$terms_objects = get_terms(
					[
						'taxonomy'   => $tax->name,
						'hide_empty' => false,
					]
				);
				$terms[ $tax->name ] = [];
				foreach ( $terms_objects as $term ) {
					$terms[ $tax->name ][] = [
						'value' => (string) $term->term_id,
						'label' => $term->name,
					];
				}
			}
		}

		wp_send_json( compact( 'taxonomies', 'terms' ) );
	}
}