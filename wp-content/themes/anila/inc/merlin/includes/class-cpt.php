<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Anila_Handle_CPT')) :

    /**
     * The CPT Anila class
     */
    class Anila_Handle_CPT {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {

            add_action( 'init', [$this, 'anila_register_my_cpts'] );
            add_action( 'init', [$this, 'anila_register_taxes'] );

            add_action( 'widgets_init', [$this, 'anila_cpt_widgets_init'] );
            add_filter( 'anila_theme_sidebar', [$this, 'set_sidebar'], 30 );
            add_filter( 'body_class', [$this, 'body_classes'], 30 );

            // Add icon service
            add_action( "add_meta_boxes", [$this, 'ssu_add_cpt_meta_box'] );
            add_action( "save_post", [$this, "ssu_save_cpt_custom_meta_fields"], 10, 3 );
            
        }

        function anila_register_my_cpts() {

            /**
             * Post Type: Services.
             */
        
            $service_slug = anila_get_theme_option('service_slug', 'service');
            $service_label = anila_get_theme_option('service_label', __( "Services", "anila" ));
        
            $args = [
                "label" => $service_label,
                "description" => "",
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "rest_namespace" => "wp/v2",
                "has_archive" => false,
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "delete_with_user" => false,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "can_export" => true,
                "rewrite" => [ "slug" => $service_slug, "with_front" => true ],
                "query_var" => true,
                "menu_position" => 20,
                "menu_icon" => "dashicons-feedback",
                "supports" => [ "title", "editor", "thumbnail", "excerpt", "author" ],
                "show_in_graphql" => false,
            ];

            $args = apply_filters('anila_custom_args_service_pt', $args);
        
            register_post_type( "service", $args );

            /**
             * Post Type: Coach.
             */
        
            $coach_slug = anila_get_theme_option('coach_slug', 'coach');
            $coach_label = anila_get_theme_option('coach_label', __( "Coaches", "anila" ));
        
            $args = [
                "label" => $coach_label,
                "description" => "",
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "rest_namespace" => "wp/v2",
                "has_archive" => false,
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "delete_with_user" => false,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "can_export" => true,
                "rewrite" => [ "slug" => $coach_slug, "with_front" => true ],
                "query_var" => true,
                "menu_position" => 20,
                "menu_icon" => "dashicons-groups",
                "supports" => [ "title", "editor", "thumbnail", "excerpt", "author" ],
                "show_in_graphql" => false,
            ];

            $args = apply_filters('anila_custom_args_coach_pt', $args);
        
            register_post_type( "coach", $args );

            /**
             * Post Type: Event.
             */

            $event_slug = anila_get_theme_option('event_slug', 'event');
            $event_label = anila_get_theme_option('event_label', __( "Events", "anila" ));

            $args = [
                "label" => $event_label,
                "description" => "",
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "rest_namespace" => "wp/v2",
                "has_archive" => false,
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "delete_with_user" => false,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "can_export" => true,
                "rewrite" => [ "slug" => $event_slug, "with_front" => true ],
                "query_var" => true,
                "menu_position" => 20,
                "menu_icon" => "dashicons-calendar-alt",
                "supports" => [ "title", "editor", "thumbnail", "excerpt", "author" ],
                "show_in_graphql" => false,
                "taxonomies" => [ "event-category", "post_tag" ],
            ];

            $args = apply_filters('anila_custom_args_event_pt', $args);

            register_post_type( "event", $args );
        }

        function anila_register_taxes() {

            /**
             * Taxonomy: Event Category.
             */
        
            $labels = [
                "name" => esc_html__( "Categories", "anila" ),
                "singular_name" => esc_html__( "Category", "anila" ),
            ];
            $tax_slug = 'event-category';
        
            
            $args = [
                "label" => esc_html__( "Category", "anila" ),
                "labels" => $labels,
                "public" => true,
                "publicly_queryable" => false,
                "hierarchical" => true,
                "show_ui" => true,
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "query_var" => true,
                "rewrite" => [ 'slug' => $tax_slug, 'with_front' => false, ],
                "show_admin_column" => true,
                "show_in_rest" => false,
                "show_tagcloud" => false,
                "rest_base" => "event-category",
                "rest_controller_class" => "WP_REST_Terms_Controller",
                "rest_namespace" => "wp/v2",
                "show_in_quick_edit" => true,
                "sort" => false,
                "show_in_graphql" => false,
            ];
            register_taxonomy( "event-category", [ "event" ], $args );
        }

        function anila_cpt_widgets_init() {
            register_sidebar( array(
                'name'          => __( 'Sidebar Single Service', 'anila' ),
                'id'            => 'sidebar-service',
                'description'   => __( 'Display in service single page', 'anila' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<span class="gamma widget-title">',
                'after_title'   => '</span>',
            ) );
            register_sidebar( array(
                'name'          => __( 'Sidebar Single Event', 'anila' ),
                'id'            => 'sidebar-event',
                'description'   => __( 'Display in event single page', 'anila' ),
                'before_widget' => '<div id="%1$s" class="widg et %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<span class="gamma widget-title">',
                'after_title'   => '</span>',
            ) );

            require_once get_parent_theme_file_path('/inc/merlin/includes/class-wp-widget-service.php');
            require_once get_parent_theme_file_path('/inc/merlin/includes/class-wp-widget-event-details.php');
            require_once get_parent_theme_file_path('/inc/merlin/includes/class-wp-widget-event-contacts.php');
            register_widget('Anila_WP_Widget_Service');
            register_widget('Anila_WP_Widget_Event_Details');
            register_widget('Anila_WP_Widget_Event_Contacts');
        }

        function set_sidebar($name) {
            if (is_singular('service')) {
                $name = 'sidebar-service';
            }
            if (is_singular('event')) {
                $name = 'sidebar-event';
            }
            return $name;
        }

        function body_classes($classes) {
            if (is_singular('service') && is_active_sidebar('sidebar-service')) {
                $classes[] = 'anila-sidebar-service';
                $classes[] = 'anila-sidebar-left';
            }
            if (is_singular('event') && is_active_sidebar('sidebar-event')) {
                $classes[] = 'anila-sidebar-event';
                $classes[] = 'anila-sidebar-right';
            }
            return $classes;
        }

        public function ssu_add_cpt_meta_box() {
            add_meta_box("ssu-custom-meta-fields", "Service Meta", [$this, 'ssu_service_iconbox_markup'], "service", "side", "low", null);
        }

        public function ssu_service_iconbox_markup( $post ) {
            wp_nonce_field( basename(__FILE__), "ssu-service-additional-fields-nonce" );
            $icon_id = get_post_meta( $post->ID, '_service_icon_id', true );

            $icon_url = ($icon_id) ? wp_get_attachment_url($icon_id) : '';
            $btn_text = ($icon_id) ? 'Change service icon' : 'Set service icon';
            ?>
            <p class="hide-if-no-js">
                <p><label for="events_video_upload_btn"><strong>Service icon</strong></label></p>
                <a href="javascript:void(0)" style="display: block;">
                    <img id="service_icon_preview" src="<?php echo esc_html($icon_url) ?>" style="max-width: 100%; height: 100%">
                </a>
                <button id="events_video_upload_btn" class="thickbox button"><?php echo esc_html($btn_text) ?></button>
            </p>
            <input type="hidden" id="_service_icon_id" name="_service_icon_id" value="<?php echo ($icon_id) ? $icon_id : '' ?>">

            <script type = "text/javascript">

            var file_frame;
            jQuery('#events_video_upload_btn').on('click', function(podcast) {

                podcast.preventDefault();

                // If the media frame already exists, reopen it.
                if (file_frame) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: jQuery(this).data('uploader_title'),
                    button: {
                        text: jQuery(this).data('uploader_button_text'),
                    },
                    multiple: false
                });
                file_frame.on('select', function() {
                    attachment = file_frame.state().get('selection').first().toJSON();
                    //var all = JSON.stringify( attachment );      
                    var id = attachment.id;
                    var url = attachment.url;
                    if(url) {
                        jQuery('#_service_icon_id').val(id);
                        jQuery('#service_icon_preview').attr('src', url);
                        jQuery('#events_video_upload_btn').text('Change service icon');
                    }

                });

                // Finally, open the modal
                file_frame.open();
            });

            </script>

            <?php
            $service_notice = get_post_meta( $post->ID, '_service_notice', true );
            $service_notice = str_replace("<br>", PHP_EOL, $service_notice);
            ?>
            <br>
            <div>
                <p style="margin-top: 0;"><label for="service_notice"><strong>Service notice</strong></label></p>
                <textarea rows="4" style="width:100%" id="service_notice" name="service_notice"><?php printf('%s', $service_notice) ?></textarea>
            </div>
            <?php
        }
        
        function ssu_save_cpt_custom_meta_fields( $postID, $post, $update ) {
            if ( !isset($_POST["ssu-service-additional-fields-nonce"] ) 
                || !wp_verify_nonce( $_POST["ssu-service-additional-fields-nonce"], basename(__FILE__) ) ){
                    return $postID;
            }

            if( !current_user_can( "edit_post", $postID ) ){
                return $postID;
            }

            if( defined("DOING_AUTOSAVE") && DOING_AUTOSAVE ){
                return $postID;
            }

            $icon_id = '';
            if( isset( $_POST['_service_icon_id'] ) ){
                $icon_id = absint($_POST['_service_icon_id']);
            }
            update_post_meta( $postID, '_service_icon_id', $icon_id );
            
            $service_notice = '';
            if( isset( $_POST['service_notice'] ) ){
                $service_notice = sanitize_textarea_field($_POST['service_notice']);
                $service_notice = str_replace(PHP_EOL, "<br>", $service_notice);
            }
            update_post_meta( $postID, '_service_notice', $service_notice );
        }

    }

endif;

return new Anila_Handle_CPT();
