<?php


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Anila_Elementor')) :

    /**
     * The Anila Elementor Integration class
     */
    class Anila_Elementor {
        private $suffix = '';

        public function __construct() {
            $this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'register_auto_scripts_frontend']);
            add_action('elementor/init', array($this, 'add_category'));
            add_action('wp_enqueue_scripts', [$this, 'add_scripts'], 15);
            add_action('elementor/widgets/register', array($this, 'include_widgets'));
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'add_js']);
            add_action('elementor/controls/register', array($this, 'include_controls'));

            // Custom Animation Scroll
            add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

            // Elementor Fix Noitice WooCommerce
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'woocommerce_fix_notice'));

            // Backend
            add_action('elementor/editor/after_enqueue_styles', [$this, 'add_style_editor'], 99);

            // Add Icon Custom
            add_action('elementor/icons_manager/native', [$this, 'add_icons_native']);
            add_action('elementor/controls/register', [$this, 'add_icons']);


            // Add Breakpoints
            add_action('wp_enqueue_scripts', 'anila_elementor_breakpoints', 9999);

            if (!anila_is_elementor_pro_activated()) {
                require trailingslashit(get_template_directory()) . 'inc/elementor/class-custom-css.php';
                require trailingslashit(get_template_directory()) . 'inc/elementor/class-section-sticky.php';
                if (is_admin()) {
                    add_action('manage_elementor_library_posts_columns', [$this, 'admin_columns_headers']);
                    add_action('manage_elementor_library_posts_custom_column', [$this, 'admin_columns_content'], 10, 2);
                }
            }

            add_filter('elementor/fonts/additional_fonts', [$this, 'additional_fonts']);

            if ( version_compare( ELEMENTOR_VERSION, '3.26.0', '>=' ) ) {
                add_action('wp_enqueue_scripts', function() {
                    wp_enqueue_style('e-swiper');
                }, -1);
            }

        }

        public function include_controls( $manager ) {
            require get_theme_file_path('inc/elementor/elementor-control/class-custom-typography.php');
            $manager->add_group_control( Anila\Elementor\Anila_Group_Control_Typography::get_type(), new Anila\Elementor\Anila_Group_Control_Typography() );
        }

        public function additional_fonts($fonts) {
            $fonts["Outfit"] = 'googlefonts';
            return $fonts;
        }

        public function admin_columns_headers($defaults) {
            $defaults['shortcode'] = esc_html__('Shortcode', 'anila');

            return $defaults;
        }

        public function admin_columns_content($column_name, $post_id) {
            if ('shortcode' === $column_name) {
                ob_start();
                ?>
                <input class="elementor-shortcode-input" type="text" readonly onfocus="this.select()" value="[hfe_template id='<?php echo esc_attr($post_id); ?>']"/>
                <?php
                ob_get_contents();
            }
        }

        public function add_js() {
            global $anila_version;
            wp_enqueue_script('anila-elementor-frontend', get_theme_file_uri('/assets/js/elementor-frontend.js'), [], $anila_version);
        }

        public function add_style_editor() {
            global $anila_version;
            wp_enqueue_style('anila-elementor-editor-icon', get_theme_file_uri('/assets/css/admin/elementor/icons.css'), [], $anila_version);
        }

        public function add_scripts() {
            global $anila_version;
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_enqueue_style('anila-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', $anila_version);
            wp_style_add_data('anila-elementor', 'rtl', 'replace');

            // Add Scripts
            wp_register_script('tweenmax', get_theme_file_uri('/assets/js/libs/TweenMax.min.js'), array('jquery'), '1.11.1');
            wp_enqueue_script('tweenmax');

            // Odometer Counter
            wp_register_script('odometer', get_theme_file_uri('/assets/js/libs/odometer.min.js'), array('jquery'), '');
            wp_register_style('odometer', get_template_directory_uri() . '/assets/css/libs/odometer.css', '', '');

            if (anila_elementor_check_type('animated-bg-parallax')) {
                wp_enqueue_script('jquery-panr', get_theme_file_uri('/assets/js/libs/jquery-panr' . $suffix . '.js'), array('jquery'), '0.0.1');
            }
        }

        public function register_auto_scripts_frontend() {
            global $anila_version;
            wp_register_script('anila-elementor-banner-carousel', get_theme_file_uri('/assets/js/elementor/banner-carousel.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-brand', get_theme_file_uri('/assets/js/elementor/brand.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-coach', get_theme_file_uri('/assets/js/elementor/coach.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-countdown', get_theme_file_uri('/assets/js/elementor/countdown.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-event', get_theme_file_uri('/assets/js/elementor/event.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-image-before-after', get_theme_file_uri('/assets/js/elementor/image-before-after.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-image-carousel', get_theme_file_uri('/assets/js/elementor/image-carousel.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-image-gallery', get_theme_file_uri('/assets/js/elementor/image-gallery.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-image-hotspots', get_theme_file_uri('/assets/js/elementor/image-hotspots.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-link-showcase', get_theme_file_uri('/assets/js/elementor/link-showcase.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-process', get_theme_file_uri('/assets/js/elementor/process.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-product-categories', get_theme_file_uri('/assets/js/elementor/product-categories.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-products', get_theme_file_uri('/assets/js/elementor/products.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-service', get_theme_file_uri('/assets/js/elementor/service.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-slide-scrolling', get_theme_file_uri('/assets/js/elementor/slide-scrolling.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-tabs-target', get_theme_file_uri('/assets/js/elementor/tabs-target.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-text-carousel', get_theme_file_uri('/assets/js/elementor/text-carousel.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-text-scrolling', get_theme_file_uri('/assets/js/elementor/text-scrolling.js'), array('jquery','elementor-frontend'), $anila_version, true);
            wp_register_script('anila-elementor-video', get_theme_file_uri('/assets/js/elementor/video.js'), array('jquery','elementor-frontend'), $anila_version, true);
           
        }

        public function add_category() {
            Elementor\Plugin::instance()->elements_manager->add_category(
                'anila-addons',
                array(
                    'title' => esc_html__('Anila Addons', 'anila'),
                    'icon'  => 'fa fa-plug',
                ), 1);
        }

        public function add_animations_scroll($animations) {
            $animations['Anila Animation'] = [
                'opal-move-up'    => 'Move Up',
                'opal-move-down'  => 'Move Down',
                'opal-move-left'  => 'Move Left',
                'opal-move-right' => 'Move Right',
                'opal-flip'       => 'Flip',
                'opal-helix'      => 'Helix',
                'opal-scale-up'   => 'Scale',
                'opal-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets($widgets_manager) {
            require get_theme_file_path('inc/elementor/base_widgets.php');

            $files_custom = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
            foreach ($files_custom as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }

            $files = glob(get_theme_file_path('/inc/elementor/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        public function woocommerce_fix_notice() {
            if (anila_is_woocommerce_activated()) {
                remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
                remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
            }
        }

        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"anila-icon-a-left":"a-left","anila-icon-a-right":"a-right","anila-icon-ask":"ask","anila-icon-breadcrumb":"breadcrumb","anila-icon-bullet-list-line":"bullet-list-line","anila-icon-calendar":"calendar","anila-icon-cardio-exercises":"cardio-exercises","anila-icon-check-mark":"check-mark","anila-icon-clock":"clock","anila-icon-competive":"competive","anila-icon-consultation":"consultation","anila-icon-custom-brand":"custom-brand","anila-icon-double-left":"double-left","anila-icon-double-right":"double-right","anila-icon-filters":"filters","anila-icon-guide1":"guide1","anila-icon-information1":"information1","anila-icon-instagram-o":"instagram-o","anila-icon-large-o":"large-o","anila-icon-linkedin-in":"linkedin-in","anila-icon-list-ul":"list-ul","anila-icon-movies":"movies","anila-icon-nutrition":"nutrition","anila-icon-phone-call":"phone-call","anila-icon-pilates":"pilates","anila-icon-plan":"plan","anila-icon-play-fill":"play-fill","anila-icon-play":"play","anila-icon-plus-m":"plus-m","anila-icon-post-on":"post-on","anila-icon-quote1":"quote1","anila-icon-quote2":"quote2","anila-icon-reply-line":"reply-line","anila-icon-report":"report","anila-icon-setting":"setting","anila-icon-share-all":"share-all","anila-icon-shopping-bag":"shopping-bag","anila-icon-shoppingcart-o":"shoppingcart-o","anila-icon-sliders-v":"sliders-v","anila-icon-square-o":"square-o","anila-icon-support":"support","anila-icon-tags":"tags","anila-icon-th-large-o":"th-large-o","anila-icon-two-line":"two-line","anila-icon-user1":"user1","anila-icon-360":"360","anila-icon-arrow-down":"arrow-down","anila-icon-arrow-left":"arrow-left","anila-icon-arrow-right":"arrow-right","anila-icon-arrow-up":"arrow-up","anila-icon-bars":"bars","anila-icon-bullet-list-line2":"bullet-list-line2","anila-icon-caret-down":"caret-down","anila-icon-caret-left":"caret-left","anila-icon-caret-right":"caret-right","anila-icon-caret-up":"caret-up","anila-icon-cart-1":"cart-1","anila-icon-cart-empty":"cart-empty","anila-icon-cart":"cart","anila-icon-Check-mark":"Check-mark","anila-icon-check-square":"check-square","anila-icon-chevron-down":"chevron-down","anila-icon-chevron-left":"chevron-left","anila-icon-chevron-right":"chevron-right","anila-icon-chevron-up":"chevron-up","anila-icon-circle":"circle","anila-icon-Clip-path-group":"Clip-path-group","anila-icon-cloud-download-alt":"cloud-download-alt","anila-icon-comment":"comment","anila-icon-comments":"comments","anila-icon-compare":"compare","anila-icon-credit-card":"credit-card","anila-icon-delivery-truck":"delivery-truck","anila-icon-dot-circle":"dot-circle","anila-icon-edit":"edit","anila-icon-envelope":"envelope","anila-icon-expand-alt":"expand-alt","anila-icon-external-link-alt":"external-link-alt","anila-icon-file-alt":"file-alt","anila-icon-file-archive":"file-archive","anila-icon-filter":"filter","anila-icon-fire1":"fire1","anila-icon-folder-open":"folder-open","anila-icon-folder":"folder","anila-icon-frown":"frown","anila-icon-gift":"gift","anila-icon-grid-view-line":"grid-view-line","anila-icon-grip-horizontal":"grip-horizontal","anila-icon-heart-fill":"heart-fill","anila-icon-heart":"heart","anila-icon-history":"history","anila-icon-home":"home","anila-icon-info-circle":"info-circle","anila-icon-instagram":"instagram","anila-icon-level-up-alt":"level-up-alt","anila-icon-list":"list","anila-icon-Mail":"Mail","anila-icon-map-marker-check":"map-marker-check","anila-icon-meh":"meh","anila-icon-minus-circle":"minus-circle","anila-icon-minus":"minus","anila-icon-mobile-android-alt":"mobile-android-alt","anila-icon-money-bill":"money-bill","anila-icon-money":"money","anila-icon-Online_Support":"Online_Support","anila-icon-paper-plane":"paper-plane","anila-icon-pencil-alt":"pencil-alt","anila-icon-plus-circle":"plus-circle","anila-icon-plus":"plus","anila-icon-quickview":"quickview","anila-icon-random":"random","anila-icon-rating-stroke":"rating-stroke","anila-icon-rating":"rating","anila-icon-repeat":"repeat","anila-icon-reply-all":"reply-all","anila-icon-reply":"reply","anila-icon-search-plus":"search-plus","anila-icon-search":"search","anila-icon-shield-check":"shield-check","anila-icon-shopping-basket":"shopping-basket","anila-icon-shopping-cart":"shopping-cart","anila-icon-sign-out-alt":"sign-out-alt","anila-icon-smile":"smile","anila-icon-spinner":"spinner","anila-icon-square":"square","anila-icon-star":"star","anila-icon-store":"store","anila-icon-sync_alt":"sync_alt","anila-icon-sync":"sync","anila-icon-tachometer-alt":"tachometer-alt","anila-icon-th-large":"th-large","anila-icon-th-list":"th-list","anila-icon-thumbtack":"thumbtack","anila-icon-ticket":"ticket","anila-icon-times-circle":"times-circle","anila-icon-times":"times","anila-icon-trophy-alt":"trophy-alt","anila-icon-truck1":"truck1","anila-icon-user-headset":"user-headset","anila-icon-user-shield":"user-shield","anila-icon-user":"user","anila-icon-video":"video","anila-icon-wishlist-empty":"wishlist-empty","anila-icon-wishlist":"wishlist","anila-icon-adobe":"adobe","anila-icon-amazon":"amazon","anila-icon-android":"android","anila-icon-angular":"angular","anila-icon-apper":"apper","anila-icon-apple":"apple","anila-icon-atlassian":"atlassian","anila-icon-behance":"behance","anila-icon-bitbucket":"bitbucket","anila-icon-bitcoin":"bitcoin","anila-icon-bity":"bity","anila-icon-bluetooth":"bluetooth","anila-icon-btc":"btc","anila-icon-centos":"centos","anila-icon-chrome":"chrome","anila-icon-codepen":"codepen","anila-icon-cpanel":"cpanel","anila-icon-discord":"discord","anila-icon-dochub":"dochub","anila-icon-docker":"docker","anila-icon-dribbble":"dribbble","anila-icon-dropbox":"dropbox","anila-icon-drupal":"drupal","anila-icon-ebay":"ebay","anila-icon-facebook-f":"facebook-f","anila-icon-facebook-o":"facebook-o","anila-icon-facebook":"facebook","anila-icon-figma":"figma","anila-icon-firefox":"firefox","anila-icon-google-plus":"google-plus","anila-icon-google":"google","anila-icon-grunt":"grunt","anila-icon-gulp":"gulp","anila-icon-html5":"html5","anila-icon-joomla":"joomla","anila-icon-link-brand":"link-brand","anila-icon-linkedin":"linkedin","anila-icon-mailchimp":"mailchimp","anila-icon-opencart":"opencart","anila-icon-paypal":"paypal","anila-icon-pinterest-p":"pinterest-p","anila-icon-reddit":"reddit","anila-icon-skype":"skype","anila-icon-slack":"slack","anila-icon-snapchat":"snapchat","anila-icon-spotify":"spotify","anila-icon-trello":"trello","anila-icon-twitter":"twitter","anila-icon-vimeo":"vimeo","anila-icon-whatsapp":"whatsapp","anila-icon-wordpress":"wordpress","anila-icon-yoast":"yoast","anila-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native($tabs) {
            global $anila_version;
            $tabs['opal-custom'] = [
                'name'          => 'anila-icon',
                'label'         => esc_html__('Anila Icon', 'anila'),
                'prefix'        => 'anila-icon-',
                'displayPrefix' => 'anila-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => $anila_version,
                'fetchJson'     => get_theme_file_uri('/inc/elementor/icons.json'),
                'native'        => true,
            ];

            return $tabs;
        }
    }

endif;

return new Anila_Elementor();
