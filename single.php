<?php get_header(); ?>

<main>
    <section class="news-item">
        <div class="wrapper">
        <div class="breadcrumbs">
    <?php
    $current_language = pll_current_language();
    ?>
    <a href="<?php echo home_url(); ?>">
        <?php echo ($current_language === 'en') ? 'Home' : 'Главная'; ?>
    </a>
    <span class="chevron-icon">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow-bread.svg" alt="">
    </span>
    <?php
    $post_type = get_post_type();

    if (!is_singular('page')) {
        if ($post_type === 'post') {
            // Захардкодили название архива для постов
            $archive_url = ($current_language === 'en') ? site_url('/en/news-en/') : site_url('/news/');
            $archive_name = ($current_language === 'en') ? 'News & Info' : 'Полезная информация';
        } else {
            $archive_url = get_post_type_archive_link($post_type);
            $archive_name = ($current_language === 'en') ? 'Custom Archive' : 'Кастомный архив'; // Можно менять под свой тип
        }

        if ($archive_url) {
            echo '<a href="' . esc_url($archive_url) . '">' . esc_html($archive_name) . '</a>';
            echo '<span class="chevron-icon">
                    <img src="' . get_template_directory_uri() . '/assets/img/arrow-bread.svg" alt="">
                  </span>';
        }
    }
    ?>
    <span><?php the_title(); ?></span>
</div>

            <div class="news-item-content">
                <h2 class="h2">
                    <?php the_title(); ?>
                </h2>
                <h5>
                    <?php echo get_the_date(); ?>
                </h5>
            </div>
        </div>
    </section>
    <section class="content-block">
        <div class="wrapper">
            <div class="content-block-grid">
                <div class="content-block-grid-item-one">
                    <p>
                        <?php the_content(); ?>
                    </p>
                </div>
                <div class="content-block-grid-item-two">
                    <p class="content-block-grid-item-two-p"><?php _e('Рекомендации', 'my-custom-theme'); ?></p>
                    <div class="news-container">
                        <?php
                        // Получаем рекомендованные записи
                        $related_posts = get_posts(array(
                            'post_type' => 'post',
                            'posts_per_page' => 2,
                            'post__not_in' => array(get_the_ID()),
                            'orderby' => 'rand',
                        ));

                        if ($related_posts) :
                            foreach ($related_posts as $post) :
                                setup_postdata($post);
                        ?>
                                <div class="news-item-card">
                                    <div>
                                        <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'medium'); ?>" alt="<?php echo get_the_title($post->ID); ?>">
                                    </div>
                                    <div>
                                        <p class="news-item-card-p-one">
                                            <?php echo wp_trim_words(get_the_title($post->ID), 10, '...'); ?>
                                        </p>
                                        <p class="data">
                                            <?php echo get_the_date('', $post->ID); ?>
                                        </p>
                                        <div class="news-item-card-btn">
                                            <a href="<?php echo get_permalink($post->ID); ?>">

                                                <?php _e('READ MORE', 'my-custom-theme'); ?>
                                            </a>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow-news.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    <div class="news-contacts">
                        <h4><?php _e('contact us', 'my-custom-theme'); ?></h4>
                        <div>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tel2.svg" alt="">
                            <a href="tel:+8618154983097">
                                +8618154983097
                            </a>
                        </div>
                        <div>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tg2.svg" alt="">
                            <a href="https://t.me/horgosautoexport">
                                https://t.me/ <br class="mobile-only"> horgosautoexport
                            </a>
                        </div>
                        <div>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mail2.svg" alt="">
                            <a href="mailto:info@horgos-autoexport.com">
                                info@horgos-autoexport.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>