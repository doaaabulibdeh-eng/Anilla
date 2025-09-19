<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<?php
	/**
	 * Functions hooked in to wp_head action
	 *
	 * @see anila_pingback_header - 1
	 */
	wp_head();

	?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action('anila_before_site'); ?>

<div id="page" class="hfeed site">
	<?php
	/**
	 * Functions hooked in to anila_before_header action
	 *
	 */
	do_action('anila_before_header');
    if (anila_is_elementor_activated() && function_exists('hfe_init') && hfe_header_enabled()) {
        do_action('hfe_header');
    } else {
        get_template_part('template-parts/header/header-1');
    }

	/**
	 * Functions hooked in to anila_before_content action
	 *
	 * @see anila_archive_blog_top          - 10
	 * 
	 */
	do_action('anila_before_content');

	$is_e = false;
	if (anila_is_elementor_activated()) {
        $page_id     = get_queried_object_id();
        $page_ins = Elementor\Plugin::instance()->documents->get( $page_id );
        if($page_ins) {
            $is_e = $page_ins->is_built_with_elementor();
        }
    }
	
	$check = $is_e && !is_single() && !is_archive();
	$col_class = ($check) ? 'col-fluid' : 'col-full';
	$content_class = ($check) ? 'site-content-fluid' : '';
	?>

	<div id="content" class="site-content <?php echo esc_attr($content_class) ?>" tabindex="-1">
		<?php
		/**
		 * Functions hooked in to anila_before_container action
		 *
		 */
		do_action('anila_before_container');
		?>
		<div class="<?php echo esc_attr($col_class) ?>">

<?php
/**
 * Functions hooked in to anila_content_top action
 *
 * @see anila_shop_messages - 10 - woo
 *
 */
do_action('anila_content_top');

