<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to anila_page action
	 *
	 * @see anila_page_header          - 10
	 * @see anila_page_content         - 20
	 *
	 */
	do_action( 'anila_page' );
	?>
</article><!-- #post-## -->
