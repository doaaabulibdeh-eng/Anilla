<?php
namespace Anila\Elementor;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use Elementor\Core\Settings\Page\Manager as PageManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor typography control.
 *
 * A base control for creating typography control. Displays input fields to define
 * the content typography including font size, font family, font weight, text
 * transform, font style, line height and letter spacing.
 *
 * @since 1.0.0
 */
class Anila_Group_Control_Typography extends Group_Control_Base {

	/**
	 * Fields.
	 *
	 * Holds all the typography control fields.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array Typography control fields.
	 */
	protected static $fields;

	/**
	 * Scheme fields keys.
	 *
	 * Holds all the typography control scheme fields keys.
	 * Default is an array containing `font_family` and `font_weight`.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array Typography control scheme fields keys.
	 */
	private static $_scheme_fields_keys = [ 'font_family', 'font_weight' ];

	/**
	 * Get scheme fields keys.
	 *
	 * Retrieve all the available typography control scheme fields keys.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array Scheme fields keys.
	 */
	public static function get_scheme_fields_keys() {
		return self::$_scheme_fields_keys;
	}

	/**
	 * Get typography control type.
	 *
	 * Retrieve the control type, in this case `typography`.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type() {
		return 'anila_typography';
	}

	/**
	 * Init fields.
	 *
	 * Initialize typography control fields.
	 *
	 * @since 1.2.2
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function init_fields() {
		$fields = [];

		$kit = Plugin::$instance->kits_manager->get_active_kit_for_frontend();

		/**
		 * Retrieve the settings directly from DB, because of an open issue when a controls group is being initialized
		 * from within another group
		 */
		$kit_settings = $kit->get_meta( PageManager::META_KEY );

		$default_fonts = isset( $kit_settings['default_generic_fonts'] ) ? $kit_settings['default_generic_fonts'] : 'Sans-serif';

		if ( $default_fonts ) {
			$default_fonts = ', ' . $default_fonts;
		}

		$fields['font_family'] = [
			'label' => esc_html_x( 'Family', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::FONT,
			'default' => '',
			'selector_value' => 'font-family: "{{VALUE}}"' . $default_fonts . ';',
		];

		$fields['font_size'] = [
			'label' => esc_html_x( 'Size', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', 'vw', 'custom' ],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 200,
				],
				'em' => [
					'max' => 20,
				],
				'rem' => [
					'max' => 20,
				],
				'vw' => [
					'min' => 0.1,
					'max' => 10,
					'step' => 0.1,
				],
			],
			'responsive' => true,
			'selector_value' => 'font-size: {{SIZE}}{{UNIT}}',
		];

		$fields['line'] = [
			'label' => esc_html_x( 'Line Text', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::NUMBER,
			'selector_value' => 'display:-webkit-box;-webkit-box-orient:vertical;overflow:hidden;-webkit-line-clamp:{{VALUE}};',
		];

		$fields['font_weight'] = [
			'label' => esc_html_x( 'Weight', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'100' => '100 ' . esc_html_x( '(Thin)', 'Typography Control', 'anila' ),
				'200' => '200 ' . esc_html_x( '(Extra Light)', 'Typography Control', 'anila' ),
				'300' => '300 ' . esc_html_x( '(Light)', 'Typography Control', 'anila' ),
				'400' => '400 ' . esc_html_x( '(Normal)', 'Typography Control', 'anila' ),
				'500' => '500 ' . esc_html_x( '(Medium)', 'Typography Control', 'anila' ),
				'600' => '600 ' . esc_html_x( '(Semi Bold)', 'Typography Control', 'anila' ),
				'700' => '700 ' . esc_html_x( '(Bold)', 'Typography Control', 'anila' ),
				'800' => '800 ' . esc_html_x( '(Extra Bold)', 'Typography Control', 'anila' ),
				'900' => '900 ' . esc_html_x( '(Black)', 'Typography Control', 'anila' ),
				'' => esc_html__( 'Default', 'anila' ),
				'normal' => esc_html__( 'Normal', 'anila' ),
				'bold' => esc_html__( 'Bold', 'anila' ),
			],
		];

		$fields['text_transform'] = [
			'label' => esc_html_x( 'Transform', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => esc_html__( 'Default', 'anila' ),
				'uppercase' => esc_html_x( 'Uppercase', 'Typography Control', 'anila' ),
				'lowercase' => esc_html_x( 'Lowercase', 'Typography Control', 'anila' ),
				'capitalize' => esc_html_x( 'Capitalize', 'Typography Control', 'anila' ),
				'none' => esc_html__( 'Normal', 'anila' ),
			],
		];

		$fields['font_style'] = [
			'label' => esc_html_x( 'Style', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => esc_html__( 'Default', 'anila' ),
				'normal' => esc_html__( 'Normal', 'anila' ),
				'italic' => esc_html_x( 'Italic', 'Typography Control', 'anila' ),
				'oblique' => esc_html_x( 'Oblique', 'Typography Control', 'anila' ),
			],
		];

		$fields['text_decoration'] = [
			'label' => esc_html_x( 'Decoration', 'Typography Control', 'anila' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => esc_html__( 'Default', 'anila' ),
				'underline' => esc_html_x( 'Underline', 'Typography Control', 'anila' ),
				'overline' => esc_html_x( 'Overline', 'Typography Control', 'anila' ),
				'line-through' => esc_html_x( 'Line Through', 'Typography Control', 'anila' ),
				'none' => esc_html__( 'None', 'anila' ),
			],
		];

		$fields['line_height'] = [
			'label' => esc_html__( 'Line Height', 'anila' ),
			'type' => Controls_Manager::SLIDER,
			'desktop_default' => [
				'unit' => 'em',
			],
			'tablet_default' => [
				'unit' => 'em',
			],
			'mobile_default' => [
				'unit' => 'em',
			],
			'range' => [
				'px' => [
					'min' => 1,
				],
			],
			'responsive' => true,
			'size_units' => [ 'px', 'em', 'rem', 'custom' ],
			'selector_value' => 'line-height: {{SIZE}}{{UNIT}}',
		];

		$fields['letter_spacing'] = [
			'label' => esc_html__( 'Letter Spacing', 'anila' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', 'custom' ],
			'range' => [
				'px' => [
					'min' => -5,
					'max' => 10,
					'step' => 0.1,
				],
				'em' => [
					'min' => 0,
					'max' => 1,
					'step' => 0.01,
				],
				'rem' => [
					'min' => 0,
					'max' => 1,
					'step' => 0.01,
				],
			],
			'responsive' => true,
			'selector_value' => 'letter-spacing: {{SIZE}}{{UNIT}}',
		];

		$fields['word_spacing'] = [
			'label' => esc_html__( 'Word Spacing', 'anila' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', 'custom' ],
			'range' => [
				'px' => [
					'max' => 50,
				],
				'em' => [
					'min' => 0,
					'max' => 5,
				],
				'rem' => [
					'min' => 0,
					'max' => 5,
				],
			],
			'desktop_default' => [
				'unit' => 'em',
			],
			'tablet_default' => [
				'unit' => 'em',
			],
			'mobile_default' => [
				'unit' => 'em',
			],
			'responsive' => true,
			'selector_value' => 'word-spacing: {{SIZE}}{{UNIT}}',
		];

		return $fields;
	}

	/**
	 * Prepare fields.
	 *
	 * Process typography control fields before adding them to `add_control()`.
	 *
	 * @since 1.2.3
	 * @access protected
	 *
	 * @param array $fields Typography control fields.
	 *
	 * @return array Processed fields.
	 */
	protected function prepare_fields( $fields ) {
		array_walk(
			$fields, function( &$field, $field_name ) {

				if ( in_array( $field_name, [ 'typography', 'popover_toggle' ] ) ) {
					return;
				}

				$selector_value = ! empty( $field['selector_value'] ) ? $field['selector_value'] : str_replace( '_', '-', $field_name ) . ': {{VALUE}};';

				$field['selectors'] = [
					'{{SELECTOR}}' => $selector_value,
				];
			}
		);

		return parent::prepare_fields( $fields );
	}

	/**
	 * Add group arguments to field.
	 *
	 * Register field arguments to typography control.
	 *
	 * @since 1.2.2
	 * @access protected
	 *
	 * @param string $control_id Typography control id.
	 * @param array  $field_args Typography control field arguments.
	 *
	 * @return array Field arguments.
	 */
	protected function add_group_args_to_field( $control_id, $field_args ) {
		$field_args = parent::add_group_args_to_field( $control_id, $field_args );

		$field_args['groupPrefix'] = $this->get_controls_prefix();
		$field_args['groupType'] = 'typography';

		$args = $this->get_args();

		if ( in_array( $control_id, self::get_scheme_fields_keys() ) && ! empty( $args['scheme'] ) ) {
			$field_args['scheme'] = [
				'type' => self::get_type(),
				'value' => $args['scheme'],
				'key' => $control_id,
			];
		}

		return $field_args;
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the typography control. Used to return the
	 * default options while initializing the typography control.
	 *
	 * @since 1.9.0
	 * @access protected
	 *
	 * @return array Default typography control options.
	 */
	protected function get_default_options() {
		return [
			'popover' => [
				'starter_name' => 'typography',
				'starter_title' => esc_html__( 'Typography', 'anila' ),
				'settings' => [
					'render_type' => 'ui',
					'groupType' => 'typography',
					'global' => [
						'active' => true,
					],
				],
			],
		];
	}
}
