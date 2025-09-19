<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Anila\Elementor\Anila_Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Anila\Elementor\Anila_Base_Widgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor image gallery widget.
 *
 * Elementor widget that displays a set of images in an aligned grid.
 *
 * @since 1.0.0
 */
class Anila_Elementor_Image_Gallery extends Anila_Base_Widgets {

    /**
     * Get widget name.
     *
     * Retrieve image gallery widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'anila-image-gallery';
    }

    /**
     * Get widget title.
     *
     * Retrieve image gallery widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Anila Image Gallery', 'anila');
    }

    public function get_script_depends() {
        return [
            'isotope',
            'masonry-pkgd',
            'anila-elementor-image-gallery'
        ];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }

    public function get_categories() {
        return ['anila-addons'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve image gallery widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since  2.1.0
     * @access public
     *
     */
    public function get_keywords() {
        return ['image', 'photo', 'visual', 'gallery'];
    }

    /**
     * Register image gallery widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Image Gallery', 'anila'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'filter_title',
            [
                'label'       => esc_html__('Filter Title', 'anila'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('List Item', 'anila'),
                'default'     => esc_html__('List Item', 'anila'),
            ]
        );

        $repeater->add_control(
            'wp_gallery',
            [
                'label'      => esc_html__('Add Images', 'anila'),
                'type'       => Controls_Manager::GALLERY,
                'show_label' => false,
                'dynamic'    => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'filter',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'filter_title' => esc_html__('Gallery 1', 'anila'),
                    ],
                ],
                'title_field' => '{{{ filter_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'anila'),
                'tab'   => Controls_Manager::TAB_LAYOUT
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'        => esc_html__('Layout', 'anila'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'default',
                'options'      => [
                    'default' => esc_html__('Default', 'anila'),
                    'masonry' => esc_html__('Masonry', 'anila'),
                ],
                'prefix_class' => 'anila-image-gallery-'
            ]
        );

        $this->add_control(
            'show_filter_bar',
            [
                'label'     => esc_html__('Filter Bar', 'anila'),
                'type'      => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'anila'),
                'label_on'  => esc_html__('On', 'anila'),
            ]
        );


        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                //                'exclude'   => ['custom'],
                'separator' => 'none',
                'default'   => 'maisonco-gallery-image'
            ]
        );
        $column = range(1, 10);
        $column = array_combine($column, $column);
        $this->add_responsive_control(
            'column',
            [
                'label'              => esc_html__('Columns', 'anila'),
                'type'               => Controls_Manager::SELECT,
                'default'            => 4,
                'options'            => [
                                            '' => esc_html__('Default', 'anila'),
                                        ] + $column,
                'frontend_available' => true,
                'render_type'        => 'template',
                'prefix_class'       => 'elementor-grid%s-',
                'selectors'          => [
//                    '(widescreen){{WRAPPER}} .grid__item'   => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_widescreen.VALUE}} - 1)) / {{column_widescreen.VALUE}})',
                    '{{WRAPPER}} .grid__item'               => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column.VALUE}} - 1)) / {{column.VALUE}});',
                    '(laptop){{WRAPPER}} .grid__item'       => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_laptop.VALUE}} - 1)) / {{column_laptop.VALUE}});',
                    '(tablet_extra){{WRAPPER}} .grid__item' => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_tablet_extra.VALUE}} - 1)) / {{column_tablet_extra.VALUE}});',
                    '(tablet){{WRAPPER}} .grid__item'       => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_tablet.VALUE}} - 1)) / {{column_tablet.VALUE}});',
                    '(mobile_extra){{WRAPPER}} .grid__item' => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_mobile_extra.VALUE}} - 1)) / {{column_mobile_extra.VALUE}});',
                    '(mobile){{WRAPPER}} .grid__item'       => 'width: calc((100% - {{column_spacing.SIZE}}{{column_spacing.UNIT}}*({{column_mobile.VALUE}} - 1)) / {{column_mobile.VALUE}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'column_spacing',
            [
                'label'              => esc_html__('Column Spacing', 'anila'),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'            => [
                    'size' => 10,
                ],
                'condition'          => [
                    'column!' => '1',
                ],
                'frontend_available' => true,
                'separator'          => 'after',
                'selectors'          => [
                    '{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}; --grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

         $this->add_control(
            'image_updown',
            [
                'label'        => __('Up Down', 'anila'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    ''       => __('Default', 'anila'),
                    'custom' => __('Custom', 'anila'),
                ],
                'prefix_class' => 'gallery-updown-',
                'default'      => '',
            ]
        );

        $this->add_responsive_control(
            'image_updown_custom',
            [
                'label'      => __('Image Up Down', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'range'      => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .grid__item:nth-last-child(2n)' => 'margin-top: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .grid__item:nth-last-child(2n-1)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'image_updown' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => esc_html__('View', 'anila'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_filter',
            [
                'label'     => esc_html__('Filter Bar', 'anila'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_filter_bar' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            Anila_Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_filter',
                'selector' => '{{WRAPPER}} .elementor-galerry__filter',
            ]
        );

        $this->add_responsive_control(
            'filter_item_spacing',
            [
                'label'     => esc_html__('Space Between', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-galerry__filter:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-galerry__filter:not(:first-child)' => 'margin-left: calc({{SIZE}}{{UNIT}}/2)',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_spacing',
            [
                'label'     => esc_html__('Spacing', 'anila'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-galerry__filters' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_padding',
            [
                'label'      => esc_html__('Filter Padding', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-galerry__filter' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'filter_align',
            [
                'label'        => esc_html__('Alignment', 'anila'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'top',
                'options'      => [
                    'left'   => [
                        'title' => esc_html__('Left', 'anila'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'anila'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'anila'),
                        'icon'  => 'eicon-text-align-right',
                    ]
                ],
                'toggle'       => false,
                'prefix_class' => 'elementor-filter-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_image',
            [
                'label' => esc_html__('Image', 'anila'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label'      => esc_html__('Border Radius', 'anila'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .grid__item a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'content_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .grid__item a img',
            ]
        );

        $this->add_responsive_control(
            'img_width',
            [
                'label'      => esc_html__('Width', 'anila'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%', 'vw'],
                'selectors'  => [
                    '{{WRAPPER}} .grid__item a img' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'          => esc_html__('Height', 'anila'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units'     => ['px','%', 'vh'],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .grid__item a img'     => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_object_fit',
            [
                'label'     => esc_html__('Object Fit', 'anila'),
                'type'      => Controls_Manager::SELECT,
                'condition' => [
                    'image_height[size]!' => '',
                ],
                'options'   => [
                    ''        => esc_html__('Default', 'anila'),
                    'fill'    => esc_html__('Fill', 'anila'),
                    'cover'   => esc_html__('Cover', 'anila'),
                    'contain' => esc_html__('Contain', 'anila'),
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render image gallery widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings      = $this->get_settings_for_display();
        $image_gallery = array();
        foreach ($settings['filter'] as $index => $item) {
            if (!empty($item['wp_gallery'])):
                foreach ($item['wp_gallery'] as $items => $attachment) {
                    $attachment['thumbnail_url'] = Group_Control_Image_Size::get_attachment_image_src($attachment['id'], 'thumbnail', $settings);
                    $attachment['group']         = $index;
                    $image_gallery[]             = $attachment;
                }
            endif;
        }
        $this->add_render_attribute('wrapper', 'class', 'elementor-anila-image-gallery');
        $this->add_render_attribute('inner', 'class', 'elementor-flex');
        $this->add_render_attribute('inner', 'class', 'isotope-grid');
        if ($settings['show_filter_bar'] == 'yes') :
            $total_image = 0;
            foreach ($settings['filter'] as $key => $term) {
                $total_image += count($term['wp_gallery']);
            }
            ?>
            <ul class="elementor-galerry__filters" data-related="isotope-<?php echo esc_attr($this->get_id()); ?>">
                <li class="elementor-galerry__filter elementor-active" data-filter=".gallery_group_all"><?php echo esc_html__('Show All', 'anila'); ?>
                    <span class="count"><?php echo esc_html($total_image); ?></span>
                </li>
                <?php foreach ($settings['filter'] as $key => $term) : ?>
                    <li class="elementor-galerry__filter" data-filter=".gallery_group_<?php echo esc_attr($key); ?>"><?php echo esc_html($term['filter_title']); ?>
                        <span class="count"><?php echo count($term['wp_gallery']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div <?php $this->print_render_attribute_string('wrapper') ?>>
            <div <?php $this->print_render_attribute_string('inner') ?>>
                <?php foreach ($image_gallery as $index => $item) {
                    $image_url                = Group_Control_Image_Size::get_attachment_image_src($item['id'], 'thumbnail', $settings);
                    $image_url_full           = wp_get_attachment_image_url($item['id'], 'full');
                    $link_content_setting_key = $this->get_repeater_setting_key('wp_gallery', 'filter', $index);

                    if (Elementor\Plugin::$instance->editor->is_edit_mode()) {
                        $this->add_render_attribute($link_content_setting_key, [
                            'class' => 'elementor-clickable',
                        ]);
                    }
                    ?>
                    <div class="grid__item gallery_group_all <?php echo 'gallery_group_' . esc_attr($item['group']); ?>">
                        <a <?php $this->print_render_attribute_string($link_content_setting_key); ?> href="<?php echo esc_url($image_url_full); ?>">
                            <img class="anila-elementor-src-gallery" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(Elementor\Control_Media::get_image_alt($item)); ?>"/>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register(new Anila_Elementor_Image_Gallery());