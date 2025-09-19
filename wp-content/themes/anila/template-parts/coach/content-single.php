<?php
$coach_job = get_post_meta(get_the_ID(), 'coach_job', true);
$coach_phone = get_post_meta(get_the_ID(), 'coach_phone', true);
$coach_email = get_post_meta(get_the_ID(), 'coach_email', true);
$coach_award = get_post_meta(get_the_ID(), 'coach_award', true);
$coach_description = get_post_meta(get_the_ID(), 'coach_description', true);
$coach_skills_group = get_post_meta(get_the_ID(), 'coach_skills_group', true);
$coach_socials_group = get_post_meta(get_the_ID(), 'coach_socials_group', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <div class="row">
            <div class="column-12 coach-wrap-left">
                <div class="coach-left">
                    <?php anila_post_thumbnail('full') ?>
                </div>
            </div>
            <div class="column-12 coach-wrap-right">
                <div class="coach-right">
                    <div class="col-inner">
                        <div class="anila_coach_informations">
                            <div class="content-sidebar-left">
                                <div class="entry-header">
                                    <?php the_title('<h4 class="alpha entry-title">', '</h4>'); ?>
                                    <?php if(!empty($coach_job)) { ?>
                                        <div class="coach_job"><?php echo esc_html($coach_job) ?></div>
                                    <?php } ?>
                                </div>
                                <ul class="coach_contact">
                                    <?php if(!empty($coach_phone)) { ?>
                                        <li class="coach_contact_phone">
                                            <strong><?php _e('Phone:', 'anila') ?></strong>
                                            <a href="tel:<?php echo esc_attr($coach_phone) ?>"><?php echo esc_html($coach_phone) ?></a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($coach_email)) { ?>
                                        <li class="coach_contact_email">
                                            <strong><?php _e('Email:', 'anila') ?></strong>
                                            <a href="mailto:<?php echo esc_attr($coach_email) ?>"><?php echo esc_html($coach_email) ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="coach_tabs_info">
                                    <div class="coach_tabs_header">
                                        <nav class="coach_nav_tabs">
                                            <a class="coach_nav_item show" href="#" data-tab="#personal-info"><?php _e('Personal Info', 'anila') ?></a>
                                            <a class="coach_nav_item" href="#" data-tab="#award"><?php _e('Award', 'anila') ?></a>
                                            <a class="coach_nav_item" href="#" data-tab="#professional-skills"><?php _e('Professional Skills', 'anila') ?></a>
                                            <?php do_action('anila_more_nav_tabs_coach'); ?>
                                        </nav>
                                    </div>
                                    <div class="coach_tabs_content">
                                        <div id="personal-info" class="coach_item_content show">
                                            <div class="coach_inner_content">
                                                <?php
                                                the_content(
                                                    sprintf(
                                                    /* translators: %s: post title */
                                                        esc_html__('Read More', 'anila') . ' %s',
                                                        '<span class="screen-reader-text">' . get_the_title() . '</span>'
                                                    )
                                                );
                                                ?>
                                                <?php if($coach_socials_group) { ?>
                                                    <ul class="coach_socials">
                                                        <?php if(!empty($coach_socials_group[0]['coach_fb'])) { ?>
                                                            <li>
                                                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_fb']) ?>" target="_blank"><i class="anila-icon-facebook-f"></i></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($coach_socials_group[0]['coach_x'])) { ?>
                                                            <li>
                                                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_x']) ?>" target="_blank"><i class="anila-icon-twitter"></i></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($coach_socials_group[0]['coach_ig'])) { ?>
                                                            <li>
                                                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_ig']) ?>" target="_blank"><i class="anila-icon-instagram"></i></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if(!empty($coach_socials_group[0]['coach_in'])) { ?>
                                                            <li>
                                                                <a href="<?php echo esc_url($coach_socials_group[0]['coach_in']) ?>" target="_blank"><i class="anila-icon-linkedin"></i></a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php do_action('anila_coach_more_socials'); ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div id="award" class="coach_item_content">
                                            <div class="coach_inner_content">
                                                <?php 
                                                if(!empty($coach_award)) {
                                                    echo wp_kses_post( $coach_award );
                                                } 
                                                else {
                                                    echo wp_kses(apply_filters('anila_coach_no_content', __('No data!', 'anila')), ['p' => [], 'span' => []]);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div id="professional-skills" class="coach_item_content">
                                            <div class="coach_inner_content">
                                                <?php 
                                                $nodata = true;
                                                if(!empty($coach_description)) {
                                                    echo wp_kses_post( $coach_description );
                                                    $nodata = false;
                                                } 

                                                if(!empty($coach_skills_group)) {
                                                    ?>
                                                    <div class="coach_skills">
                                                        <?php 
                                                        foreach ($coach_skills_group as $i => $skill) { 
                                                            if(empty($skill['title']) || empty($skill['level'])) continue;
                                                            ?>
                                                            <div class="coach_skill_item">
                                                                <span class="coach_skill_title"><?php echo esc_html($skill['title']) ?></span>
                                                                <span class="coach_skill_level"><?php echo esc_html($skill['level']) ?>%</span>
                                                                <span class="coach_skill_line"></span>
                                                                <span class="coach_skill_line level_line" style="width: <?php echo esc_attr($skill['level']) ?>%"></span>
                                                            </div>
                                                            <?php
                                                        }
                                                        do_action('anila_coach_more_skill'); ?>
                                                    </div>
                                                    <?php 
                                                    $nodata = false;
                                                }
                                                
                                                if ($nodata) {
                                                    echo wp_kses(apply_filters('anila_coach_no_content', __('No data!', 'anila')), ['p' => [], 'span' => []]);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php do_action('anila_more_content_tabs_coach'); ?>
                                    </div>
                                </div>
                                
                                <?php do_action('anila_custom_more_coach_informations'); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</article><!-- #post-## -->
