<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to anila_single_post_top action
         *
         */
        do_action('anila_single_post_top');

        /**
         * Functions hooked in to anila_single_post action
         * @see anila_post_thumbnail     - 15
         * @see anila_post_excerpt     - 20
         * @see anila_post_header        - 10
         * @see anila_post_content       - 30
         */
        do_action('anila_single_post');

        /**
         * Functions hooked in to anila_single_post_bottom action
         *
         * @see anila_post_taxonomy        - 5
         * @see anila_post_nav             - 10
         * @see anila_single_author        - 15
         * @see anila_display_comments     - 20
         */
        do_action('anila_single_post_bottom');
        ?>

    </div>

</article><!-- #post-## -->
