<?php
get_header(); ?>
    <div id="primary" class="content">
        <main id="main" class="site-main">
            <div class="error-404 not-found">
                <div class="page-content">
                    <div class="page-header">
                        <div class="text-404">
                            <div class="img-404">
                                <img src="<?php echo get_theme_file_uri('assets/images/404/404.png') ?>" alt="<?php echo esc_attr__('404 Page not found', 'anila') ?>">
                            </div>
                            <div class="text">
                                <h2 class="error-subtitle"><?php esc_html_e('Oops! That Page Can’t Be Found.', 'anila'); ?></h2>
                                <p class="error-text"><?php esc_html_e('You are here because you entered the address of a page that no longer exists or has been moved to a different address', 'anila'); ?></p>
                                <div class="error-button">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="go-back"><?php esc_html_e('back To Homepage', 'anila'); ?>
                                        <i class="anila-icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        </header><!-- .page-header -->
                    </div><!-- .page-content -->
                </div><!-- .error-404 -->
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();