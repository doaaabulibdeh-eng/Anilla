<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Counter;

add_action( 'elementor/element/counter/section_counter/before_section_end', function ($element, $args ) {

    $element->add_responsive_control(
        'position',
        [
            'label'        => __('Alignment', 'anila'),
            'type'         => Controls_Manager::CHOOSE,
            'options'      => [
                'left' => [
                    'title' => __('Left', 'anila'),
                    'icon'  => 'eicon-text-align-left',
                ],
                'center'     => [
                    'title' => __('Center', 'anila'),
                    'icon'  => 'eicon-text-align-center',
                ],
                'right'   => [
                    'title' => __('Right', 'anila'),
                    'icon'  => 'eicon-text-align-right',
                ]
            ],
            'toggle'       => false,
            'prefix_class' => 'elementor-position-',
            'default'      => 'center',
            'selectors'    => [
                '{{WRAPPER}} .elementor-counter' => 'text-align: {{VALUE}}',
                '{{WRAPPER}} .elementor-counter .elementor-counter-title' => 'text-align: {{VALUE}}',
            ],
        ]
    );

    $element->add_control(
        'counter_style',
        [
            'label' => esc_html__( 'Counter Style', 'anila' ),
            'type' => Controls_Manager::SELECT,
            'default' => '1',
            'options' => [
                '1' => esc_html__( 'Style 1', 'anila' ),
                '2' => esc_html__( 'Style 2', 'anila' ),
            ],
            'render_type' => 'template'
        ]
    );

}, 10, 2 );

add_action( 'elementor/element/counter/section_number/before_section_end', function ($element, $args ) {

    $element->add_responsive_control(
        'height_number',
        [
            'label' => __('Height', 'anila'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-counter-number-wrapper' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );


}, 10, 2 );

// Widget_Counter
class Anila_Elementor_Counter extends Widget_Counter {
    /**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'jquery-numerator', 'odometer'];
	}
    
    /**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() : array {
		return ['odometer'];
	}

    /**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# view.addRenderAttribute( 'counter-title', {
			'class': 'elementor-counter-title'
		} );

        var classCounter = 'elementor-counter-number';
		if ( settings.counter_style == '2' ) {
			classCounter = 'elementor-counter-number-style-2 odometer odometer-auto-theme';
		}

		view.addInlineEditingAttributes( 'counter-title' );
		#>
		<div class="elementor-counter">
			<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix">{{{ settings.prefix }}}</span>
				<span class="{{ classCounter }}" data-duration="{{ settings.duration }}" data-to-value="{{ settings.ending_number }}" data-delimiter="{{ settings.thousand_separator ? settings.thousand_separator_char || ',' : '' }}">{{{ settings.starting_number }}}</span>
				<span class="elementor-counter-number-suffix">{{{ settings.suffix }}}</span>
			</div>
			<# if ( settings.title ) {
				#><div {{{ view.getRenderAttributeString( 'counter-title' ) }}}>{{{ settings.title }}}</div><#
			} #>
		</div>
		<?php
	}

	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

        $class = (!empty($settings['counter_style'] && $settings['counter_style'] == '2')) ? 'elementor-counter-number-style-2 odometer odometer-auto-theme' : 'elementor-counter-number';
		$this->add_render_attribute( 'counter', [
			'class' => $class,
			'data-duration' => $settings['duration'],
			'data-to-value' => $settings['ending_number'],
			'data-from-value' => $settings['starting_number'],
		] );

		if ( ! empty( $settings['thousand_separator'] ) ) {
			$delimiter = empty( $settings['thousand_separator_char'] ) ? ',' : $settings['thousand_separator_char'];
			$this->add_render_attribute( 'counter', 'data-delimiter', $delimiter );
		}

		$this->add_render_attribute( 'counter-title', 'class', 'elementor-counter-title' );

		$this->add_inline_editing_attributes( 'counter-title' );
		?>
		<div class="elementor-counter">
			<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix"><?php $this->print_unescaped_setting( 'prefix' ); ?></span>
				<span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php $this->print_unescaped_setting( 'starting_number' ); ?></span>
				<span class="elementor-counter-number-suffix"><?php $this->print_unescaped_setting( 'suffix' ); ?></span>
			</div>
			<?php if ( $settings['title'] ) : ?>
				<div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php $this->print_unescaped_setting( 'title' ); ?></div>
			<?php endif; ?>
		</div>
		<?php
		if(!empty($settings['counter_style'] && $settings['counter_style'] == '2')) {
			?><span class="elementor-counter-number" style="display: none !important;"></span><?php
		}
	}
}
$widgets_manager->register(new Anila_Elementor_Counter());