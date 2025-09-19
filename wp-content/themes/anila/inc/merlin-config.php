<?php

class Anila_Merlin_Config {

    private $wizard;

    public function __construct() {
        add_action( 'after_setup_theme', function() {
            $this->init();
        } );
        add_filter('merlin_import_files', [$this, 'import_files']);
        add_action('merlin_after_all_import', [$this, 'after_import_setup'], 10, 1);
        add_filter('merlin_generate_child_functions_php', [$this, 'render_child_functions_php']);
        add_action('import_start', function () {
            add_filter('wxr_importer.pre_process.post_meta', [$this, 'fiximport_elementor'], 10, 1);
        });

        add_action('import_end', function () {
            update_option('elementor_experiment-container', 'active');
            update_option('elementor_experiment-nested-elements', 'active');
        });

        if (class_exists('Woo_Variation_Swatches_Deactivate_Feedback')) {
            remove_action( 'admin_footer', array( Woo_Variation_Swatches_Deactivate_Feedback::instance(), 'dialog' ) );
        }
    }

    public function fiximport_elementor($post_meta) {
        if ('_elementor_data' === $post_meta['key']) {
            $post_meta['value'] = wp_slash($post_meta['value']);
        }

        return $post_meta;
    }

    public function import_files(){
            return array(
            array(
                'import_file_name'           => 'home 1',
                'home'                       => 'home-1',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-1.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/anila/dummy_data/revsliders/home-1/slider-1.zip',
                'import_more_revslider_file_url' => [],
                'import_lookbook_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-1.jpg'),
                'preview_url'                => 'https://demo2.themelexus.com/anila/home-1',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#145954"},{"_id":"secondary","title":"Secondary(Heading)","color":"#1A1C1B"},{"_id":"text","title":"Text","color":"#4C4F4E"},{"_id":"accent","title":"Accent","color":"#F3BF5B"},{"_id":"lighter","title":"Lighter","color":"#8A8E8C"},{"_id":"dark","title":"Dark","color":"#000000"},{"_id":"border","title":"Border","color":"#E5EAE8"},{"_id":"background-field","title":"Background Field","color":"#F5F5F5"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"700"},{"_id":"special","title":"Special","typography_typography":"custom"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Anila","site_description":"Outdoor & Sport Store WordPress Theme ","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1290,"sizes":[]},"space_between_widgets":{"column":"0","row":"0","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#FAF9F7","container_padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}}',
                'themeoptions'               => '{}',
            ),
            
            array(
                'import_file_name'           => 'home 2',
                'home'                       => 'home-2',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-2.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/anila/dummy_data/revsliders/home-2/slider-2.zip',
                'import_more_revslider_file_url' => [],
                'import_lookbook_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-2.jpg'),
                'preview_url'                => 'https://demo2.themelexus.com/anila/home-2',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#145954"},{"_id":"secondary","title":"Secondary(Heading)","color":"#1A1C1B"},{"_id":"text","title":"Text","color":"#4C4F4E"},{"_id":"accent","title":"Accent","color":"#F3BF5B"},{"_id":"lighter","title":"Lighter","color":"#8A8E8C"},{"_id":"dark","title":"Dark","color":"#000000"},{"_id":"border","title":"Border","color":"#E5EAE8"},{"_id":"background-field","title":"Background Field","color":"#F5F5F5"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"700"},{"_id":"special","title":"Special","typography_typography":"custom"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Anila","site_description":"Outdoor & Sport Store WordPress Theme ","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1290,"sizes":[]},"space_between_widgets":{"column":"0","row":"0","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#FAF9F7","container_padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}}',
                'themeoptions'               => '{}',
            ),
            
            array(
                'import_file_name'           => 'home 3',
                'home'                       => 'home-3',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-3.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/anila/dummy_data/revsliders/home-3/slider-3.zip',
                'import_more_revslider_file_url' => [],
                'import_lookbook_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-3.jpg'),
                'preview_url'                => 'https://demo2.themelexus.com/anila/home-3',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#145954"},{"_id":"secondary","title":"Secondary(Heading)","color":"#1A1C1B"},{"_id":"text","title":"Text","color":"#4C4F4E"},{"_id":"accent","title":"Accent","color":"#F3BF5B"},{"_id":"lighter","title":"Lighter","color":"#8A8E8C"},{"_id":"dark","title":"Dark","color":"#000000"},{"_id":"border","title":"Border","color":"#E5EAE8"},{"_id":"background-field","title":"Background Field","color":"#F5F5F5"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"700"},{"_id":"special","title":"Special","typography_typography":"custom"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Anila","site_description":"Outdoor & Sport Store WordPress Theme ","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1290,"sizes":[]},"space_between_widgets":{"column":"0","row":"0","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#FAF9F7","container_padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}}',
                'themeoptions'               => '{}',
            ),
            
            array(
                'import_file_name'           => 'home 4',
                'home'                       => 'home-4',
                'local_import_file'          => get_theme_file_path('/dummy-data/content.xml'),
                'homepage'                   => get_theme_file_path('/dummy-data/homepage/home-4.xml'),
                'local_import_widget_file'   => get_theme_file_path('/dummy-data/widgets.json'),
                'import_rev_slider_file_url' => 'http://source.wpopal.com/anila/dummy_data/revsliders/home-4/slider-4.zip',
                'import_more_revslider_file_url' => [],
                'import_lookbook_revslider_file_url' => [],
                'import_preview_image_url'   => get_theme_file_uri('/assets/images/oneclick/home-4.jpg'),
                'preview_url'                => 'https://demo2.themelexus.com/anila/home-4',
                'elementor'                  => '{"system_colors":[{"_id":"primary","title":"Primary","color":"#145954"},{"_id":"secondary","title":"Secondary(Heading)","color":"#1A1C1B"},{"_id":"text","title":"Text","color":"#4C4F4E"},{"_id":"accent","title":"Accent","color":"#F3BF5B"},{"_id":"lighter","title":"Lighter","color":"#8A8E8C"},{"_id":"dark","title":"Dark","color":"#000000"},{"_id":"border","title":"Border","color":"#E5EAE8"},{"_id":"background-field","title":"Background Field","color":"#F5F5F5"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"700"},{"_id":"special","title":"Special","typography_typography":"custom"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Anila","site_description":"Outdoor & Sport Store WordPress Theme ","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1290,"sizes":[]},"space_between_widgets":{"column":"0","row":"0","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#FAF9F7","container_padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}}',
                'themeoptions'               => '{}',
            ),
                        );           
        }

    public function after_import_setup($selected_import) {
        $selected_import = ($this->import_files())[$selected_import];
        $check_oneclick  = get_option('anila_check_oneclick', []);

        // setup Home page
        $home = get_page_by_path($selected_import['home']);
        if ($home->ID) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home->ID);
        }

        $this->set_demo_menus();

        // Setup Options
        $options = $this->get_all_options();
        $theme_options = $options['options'];
        foreach ($theme_options as $key => $option) {
            update_option($key, $option);
        }

        $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
        update_post_meta($active_kit_id, '_elementor_page_settings', json_decode($selected_import['elementor'], true));
        set_theme_mod('custom_logo', $this->get_attachment('_logo'));

        // Header Footer Builder
        $this->reset_header_footer();
        $this->set_hf($selected_import['home']);

        // Update Breadcrumb
        $this->update_breadcrumb($selected_import['home']);

        update_option('woocommerce_single_image_width', 1000);
        update_option('woocommerce_thumbnail_image_width', 600);

        \Elementor\Plugin::instance()->files_manager->clear_cache();

        $this->update_nav_menu_item();
        $this->remove_quick_table_enable();
        $this->update_product();
        if (class_exists('Woo_Variation_Swatches')) {
            $this->update_color_attribute();
        }

        $mailchimp = $this->get_mailchimp_id();
        if ($mailchimp) {
            update_option('mc4wp_default_form_id', $mailchimp);
        }
    }

    private function update_product() {
        $limit = -1;
 
        // getting all products
        $products_ids = get_posts( array(
            'post_type'        => 'product', // or ['product','product_variation'],
            'numberposts'      => $limit,
            'post_status'      => 'publish',
            'fields'           => 'ids',
            'meta_query'       => array( array(
                'key'     => '_sync_updated',
                'compare' => 'NOT EXISTS',
            ) )
        ) );

        foreach ( $products_ids as $product_id ) {
            $product = wc_get_product($product_id);
            // Mark product as updated
            $product->update_meta_data( '_sync_updated', true );
            $product->save();
        }

    }

    private function update_color_attribute() {
        $attribute_slug = 'color'; // Replace with your attribute slug
        $attribute_id = wc_attribute_taxonomy_id_by_name( $attribute_slug );

        if ($attribute_id) {
        	wc_update_attribute( $attribute_id, ['type' => 'color'] );
        }

        $taxonomy = wc_attribute_taxonomy_name( $attribute_slug );
        $terms = get_terms([
        	'taxonomy' => $taxonomy,
        	'hide_empty' => false
        ]);

        if ($terms && !empty($terms)) {
        	foreach ($terms as $term) {
        		$color = ! empty( $term->description ) ? sanitize_hex_color( $term->description ) : '';
        		update_term_meta( $term->term_id, 'product_attribute_color', $color );
        	}
        }
    }
 
    //remove quick_table_enable
    private function remove_quick_table_enable() {
        $qte = get_option('woosc_settings');
        if ($qte['quick_table_enable'] == 'yes') {
            $qte['quick_table_enable'] = 'no';
            update_option('woosc_settings', $qte);
        }
    }

    private function update_nav_menu_item() {
        $params = array(
            'posts_per_page' => -1,
            'post_type'      => [
                'nav_menu_item',
            ],
        );
        $query  = new WP_Query($params);
        while ($query->have_posts()): $query->the_post();
            wp_update_post(array(
                // Update the `nav_menu_item` Post Title
                'ID'         => get_the_ID(),
                'post_title' => get_the_title()
            ));
        endwhile;

    }

    private function get_mailchimp_id() {
        $params = array(
            'post_type'      => 'mc4wp-form',
            'posts_per_page' => 1,
        );
        $post   = get_posts($params);

        return isset($post[0]) ? $post[0]->ID : 0;
    }

    private function get_attachment($key) {
        $params = array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'posts_per_page' => 1,
            'meta_key'       => $key,
        );
        $post   = get_posts($params);
        if ($post) {
            return $post[0]->ID;
        }

        return 0;
    }

    private function init() {
        $this->wizard = new Merlin(
            $config = array(
                // Location / directory where Merlin WP is placed in your theme.
                'merlin_url'         => 'merlin',
                // The wp-admin page slug where Merlin WP loads.
                'parent_slug'        => 'themes.php',
                // The wp-admin parent page slug for the admin menu item.
                'capability'         => 'manage_options',
                // The capability required for this menu to be displayed to the user.
                'dev_mode'           => true,
                // Enable development mode for testing.
                'license_step'       => false,
                // EDD license activation step.
                'license_required'   => false,
                // Require the license activation step.
                'license_help_url'   => '',
                'directory'          => '/inc/merlin',
                // URL for the 'license-tooltip'.
                'edd_remote_api_url' => '',
                // EDD_Theme_Updater_Admin remote_api_url.
                'edd_item_name'      => '',
                // EDD_Theme_Updater_Admin item_name.
                'edd_theme_slug'     => '',
                // EDD_Theme_Updater_Admin item_slug.
            ),
            $strings = array(
                'admin-menu'          => esc_html__('Theme Setup', 'anila'),

                /* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
                'title%s%s%s%s'       => esc_html__('%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'anila'),
                'return-to-dashboard' => esc_html__('Return to the dashboard', 'anila'),
                'ignore'              => esc_html__('Disable this wizard', 'anila'),

                'btn-skip'                 => esc_html__('Skip', 'anila'),
                'btn-next'                 => esc_html__('Next', 'anila'),
                'btn-start'                => esc_html__('Start', 'anila'),
                'btn-no'                   => esc_html__('Cancel', 'anila'),
                'btn-plugins-install'      => esc_html__('Install', 'anila'),
                'btn-child-install'        => esc_html__('Install', 'anila'),
                'btn-content-install'      => esc_html__('Install', 'anila'),
                'btn-import'               => esc_html__('Import', 'anila'),
                'btn-license-activate'     => esc_html__('Activate', 'anila'),
                'btn-license-skip'         => esc_html__('Later', 'anila'),

                /* translators: Theme Name */
                'license-header%s'         => esc_html__('Activate %s', 'anila'),
                /* translators: Theme Name */
                'license-header-success%s' => esc_html__('%s is Activated', 'anila'),
                /* translators: Theme Name */
                'license%s'                => esc_html__('Enter your license key to enable remote updates and theme support.', 'anila'),
                'license-label'            => esc_html__('License key', 'anila'),
                'license-success%s'        => esc_html__('The theme is already registered, so you can go to the next step!', 'anila'),
                'license-json-success%s'   => esc_html__('Your theme is activated! Remote updates and theme support are enabled.', 'anila'),
                'license-tooltip'          => esc_html__('Need help?', 'anila'),

                /* translators: Theme Name */
                'welcome-header%s'         => esc_html__('Welcome to %s', 'anila'),
                'welcome-header-success%s' => esc_html__('Hi. Welcome back', 'anila'),
                'welcome%s'                => esc_html__('This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'anila'),
                'welcome-success%s'        => esc_html__('You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'anila'),

                'child-header'         => esc_html__('Install Child Theme', 'anila'),
                'child-header-success' => esc_html__('You\'re good to go!', 'anila'),
                'child'                => esc_html__('Let\'s build & activate a child theme so you may easily make theme changes.', 'anila'),
                'child-success%s'      => esc_html__('Your child theme has already been installed and is now activated, if it wasn\'t already.', 'anila'),
                'child-action-link'    => esc_html__('Learn about child themes', 'anila'),
                'child-json-success%s' => esc_html__('Awesome. Your child theme has already been installed and is now activated.', 'anila'),
                'child-json-already%s' => esc_html__('Awesome. Your child theme has been created and is now activated.', 'anila'),

                'plugins-header'         => esc_html__('Install Plugins', 'anila'),
                'plugins-header-success' => esc_html__('You\'re up to speed!', 'anila'),
                'plugins'                => esc_html__('Let\'s install some essential WordPress plugins to get your site up to speed.', 'anila'),
                'plugins-success%s'      => esc_html__('The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'anila'),
                'plugins-action-link'    => esc_html__('Advanced', 'anila'),

                'import-header'      => esc_html__('Import Content', 'anila'),
                'import'             => esc_html__('Let\'s import content to your website, to help you get familiar with the theme.', 'anila'),
                'import-action-link' => esc_html__('Advanced', 'anila'),

                'ready-header'      => esc_html__('All done. Have fun!', 'anila'),

                /* translators: Theme Author */
                'ready%s'           => esc_html__('Your theme has been all set up. Enjoy your new theme by %s.', 'anila'),
                'ready-action-link' => esc_html__('Extras', 'anila'),
                'ready-big-button'  => esc_html__('View your website', 'anila'),
                'ready-link-1'      => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__('Explore WordPress', 'anila')),
                'ready-link-2'      => sprintf('<a href="%1$s" target="_blank">%2$s</a>', 'https://themebeans.com/contact/', esc_html__('Get Theme Support', 'anila')),
                'ready-link-3'      => sprintf('<a href="%1$s">%2$s</a>', admin_url('customize.php'), esc_html__('Start Customizing', 'anila')),
            )
        );
        if (anila_is_elementor_activated()) {
            add_action('widgets_init', [$this, 'widgets_init']);
        }
        if (class_exists('Monster_Widget')) {
            add_action('widgets_init', [$this, 'widget_monster']);
        }
    }

    public function widget_monster() {
        unregister_widget('Monster_Widget');
        require_once get_parent_theme_file_path('/inc/merlin/includes/monster-widget.php');
        register_widget('Anila_Monster_Widget');
    }

    public function widgets_init() {
        require_once get_parent_theme_file_path('/inc/merlin/includes/recent-post.php');
        register_widget('Anila_WP_Widget_Recent_Posts');
        if (anila_is_woocommerce_activated()) {
            require_once get_parent_theme_file_path('/inc/merlin/includes/class-wc-widget-layered-nav.php');
            register_widget('Anila_Widget_Layered_Nav');
        }
    }

    private function get_all_header_footer() {
        $id_home1 = (anila_get_page_by_slug('home-1')) ? 'post-'.anila_get_page_by_slug('home-1')->ID : 'post-14';
        $id_home2 = (anila_get_page_by_slug('home-2')) ? 'post-'.anila_get_page_by_slug('home-2')->ID : 'post-16';
        $id_home3 = (anila_get_page_by_slug('home-3')) ? 'post-'.anila_get_page_by_slug('home-3')->ID : 'post-18';
        $id_home4 = (anila_get_page_by_slug('home-4')) ? 'post-'.anila_get_page_by_slug('home-4')->ID : 'post-20';
        return [
            'home-1' => [
                'header' => [
                    [
                        'slug'                         => 'header-2',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home1]],
                    ],
                    [
                        'slug'                         => 'header-1',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home1]],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-1',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home1]],
                    ],
                    [
                        'slug'                         => 'footer-4',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home1]],
                    ]
                ]
            ],
            'home-2' => [
                'header' => [
                    [
                        'slug'                         => 'header-1',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-2',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home2]],
                    ],
                    [
                        'slug'                         => 'footer-4',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home2]],
                    ]
                ]
            ],
            'home-3' => [
                'header' => [
                    [
                        'slug'                         => 'header-3',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home3]],
                    ],
                    [
                        'slug'                         => 'header-1',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home3]],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-3',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home3]],
                    ],
                    [
                        'slug'                         => 'footer-4',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home3]],
                    ]
                ]
            ],
            'home-4' => [
                'header' => [
                    [
                        'slug'                         => 'header-4',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home4]],
                    ],
                    [
                        'slug'                         => 'header-1',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home4]],
                    ]
                ],
                'footer' => [
                    [
                        'slug'                         => 'footer-1',
                        'ehf_target_include_locations' => ['rule' => ['specifics'], 'specific' => [$id_home4]],
                    ],
                    [
                        'slug'                         => 'footer-4',
                        'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                        'ehf_target_exclude_locations' => ['rule' => ['specifics'], 'specific' => [$id_home4]],
                    ]
                ]
            ]
        ];
    }

    private function get_update_breadcrumbs($home) {
        $our_services_id = (anila_get_page_by_slug('our-services')) ? 'post-'.anila_get_page_by_slug('our-services')->ID : 'post-62';
        $id_home = (anila_get_page_by_slug($home)) ? 'post-'.anila_get_page_by_slug($home)->ID : 'post-14';
        
        $bc_args = [
            'breadcrumb-default' => [
                'ehf_target_include_locations' => ['rule' => ['basic-global'], 'specific' => []],
                'ehf_target_exclude_locations' => [
                    'rule' => ['service|all', 'specifics'], 
                    'specific' => [$our_services_id, $id_home]
                ],
            ]
        ];

        return $bc_args;
    }

    private function update_breadcrumb($home) {
        $update_bcs = $this->get_update_breadcrumbs($home);

        if (!empty($update_bcs)) {
            foreach ($update_bcs as $slug => $bc) {
                $bc_obj = get_page_by_path($slug, OBJECT, 'anila-breadcrumb');
                if ($bc_obj) {
                    if (isset($bc['ehf_target_include_locations'])) {
                        update_post_meta($bc_obj->ID, 'ehf_target_include_locations', $bc['ehf_target_include_locations']);
                    }
                    if (isset($bc['ehf_target_exclude_locations'])) {
                        update_post_meta($bc_obj->ID, 'ehf_target_exclude_locations', $bc['ehf_target_exclude_locations']);
                    }
                }
            }
        }
    }

    private function reset_header_footer() {
        $footer_args = array(
            'post_type'      => 'elementor-hf',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'ehf_template_type',
                    'compare' => 'IN',
                    'value'   => ['type_footer', 'type_header']
                ),
            )
        );
        $footer      = new WP_Query($footer_args);
        while ($footer->have_posts()) : $footer->the_post();
            update_post_meta(get_the_ID(), 'ehf_target_include_locations', []);
            update_post_meta(get_the_ID(), 'ehf_target_exclude_locations', []);
        endwhile;
        wp_reset_postdata();
    }

    public function set_demo_menus() {
        $main_menu = get_term_by('name', 'Main Menu', 'nav_menu');

        set_theme_mod(
            'nav_menu_locations',
            array(
                'primary'  => $main_menu->term_id,
                'handheld' => $main_menu->term_id,
            )
        );
    }

    private function set_hf($home) {
        $all_hf = $this->get_all_header_footer();
        $datas  = $all_hf[$home];
        foreach ($datas as $item) {
            foreach ($item as $object) {
                $hf = get_page_by_path($object['slug'], OBJECT, 'elementor-hf');
                if ($hf) {
                    update_post_meta($hf->ID, 'ehf_target_include_locations', $object['ehf_target_include_locations']);
                    if (isset($object['ehf_target_exclude_locations'])) {
                        update_post_meta($hf->ID, 'ehf_target_exclude_locations', $object['ehf_target_exclude_locations']);
                    }
                }
            }
        }
    }

    public function render_child_functions_php() {
        $output
            = "<?php
/**
 * Theme functions and definitions.
 */
		 ";

        return $output;
    }

    public function get_all_options(){
        $options = [];
        $options['options']   = json_decode('{"anila_options_blog_single_sidebar":"right","anila_options_blog_single_style":"2","anila_options_wocommerce_single_style":"1","anila_options_single_product_tab_layout":"default","woocommerce_catalog_columns":"3","anila_options_wocommerce_row_laptop":"2","anila_options_wocommerce_row_tablet":"1","anila_options_wocommerce_column_list_view":"1","anila_options_woocommerce_product_hover":"left-to-right","anila_options_single_product_content_meta":"<p>[hfe_template id=\'1382\']</p>","anila_options_coach_bottom_template":"coach-template"}', true);
        $options['elementor']   = json_decode('{"system_colors":[{"_id":"primary","title":"Primary","color":"#145954"},{"_id":"secondary","title":"Secondary(Heading)","color":"#1A1C1B"},{"_id":"text","title":"Text","color":"#4C4F4E"},{"_id":"accent","title":"Accent","color":"#F3BF5B"},{"_id":"lighter","title":"Lighter","color":"#8A8E8C"},{"_id":"dark","title":"Dark","color":"#000000"},{"_id":"border","title":"Border","color":"#E5EAE8"},{"_id":"background-field","title":"Background Field","color":"#F5F5F5"}],"custom_colors":[],"system_typography":[{"_id":"primary","title":"Primary","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"secondary","title":"Secondary(Heading)","typography_typography":"custom","typography_font_family":"Fahkwang","typography_font_weight":"400"},{"_id":"text","title":"Text","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"400"},{"_id":"accent","title":"Accent","typography_typography":"custom","typography_font_family":"Manrope","typography_font_weight":"700"},{"_id":"special","title":"Special","typography_typography":"custom"}],"custom_typography":[],"default_generic_fonts":"Sans-serif","site_name":"Anila","site_description":"Outdoor & Sport Store WordPress Theme ","page_title_selector":"h1.entry-title","activeItemIndex":1,"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_md":768,"viewport_lg":1025,"container_width":{"unit":"px","size":1290,"sizes":[]},"space_between_widgets":{"column":"0","row":"0","isLinked":true,"unit":"px","size":0,"sizes":[]},"body_background_background":"classic","body_background_color":"#FAF9F7","container_padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}}', true);
        return $options;
    } // end get_all_options
}

return new Anila_Merlin_Config();
