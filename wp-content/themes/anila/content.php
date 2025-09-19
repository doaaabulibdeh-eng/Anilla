<article id="post-<?php the_ID(); ?>" <?php post_class('article-default'); ?>>
    <div class="post-inner">
        <?php anila_post_thumbnail('post-thumbnail', true); ?>
        <div class="post-content">
            <?php
            /**
             * Functions hooked in to anila_loop_post action.
             *
             * @see anila_post_header          - 15
             * @see anila_post_content         - 30
             */
            do_action('anila_loop_post');
            ?>
        </div>
    </div>
</article><!-- #post-## -->