<?php
/* Template Name: News Page */
get_header(); // Подключаем шапку
?>

<main>
    <!-- Hero Section -->
    <section class="faq-hero">
        <div class="wrapper">
            <h1>News&info</h1>
            <h3><?php echo esc_html(get_field('text_1')); ?></h3>
        </div>
    </section>

    <!-- Important News Section -->
    <section class="important-news">
        <div class="wrapper">
            <div class="important-news-container">
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/news-img.jpg" alt="">
                </div>
                <div class="important-news-right">
                    <div>
                        <h2><?php echo esc_html(get_field('text_2')); ?></h2>
                        <h3><?php echo esc_html(get_field('text_3')); ?></h3>
                    </div>
                    <ul>
                        <li>- <?php echo esc_html(get_field('text_4')); ?></li>
                        <li>- <?php echo esc_html(get_field('text_5')); ?></li>
                        <li>- <?php echo esc_html(get_field('text_6')); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- News Slider Section -->
    <section class="news-slider">
        <div class="wrapper">
            <div class="wrapper-slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php
                        // Выводим последние 5 новостей
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 5,
                            'category_name'  => 'useful-info',
                        );
                        $slider_query = new WP_Query($args);

                        if ($slider_query->have_posts()) :
                            while ($slider_query->have_posts()) : $slider_query->the_post();
                        ?>
                                <div class="swiper-slide">
                                    <a class="home-news-grid-item-link" href="<?php the_permalink(); ?>">
                                        <div class="img-cont">
                                            <img class="news-slider-img" src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                                        </div>
                                        <div class="cont-two">
                                            <h4><?php the_title(); ?></h4>

                                        </div>
                                    </a>
                                </div>
                        <?php
                            endwhile;
                        else :
                            echo '<p>Новостей пока нет.</p>';
                        endif;

                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <div class="swiper-button-container">
                    <div class="swiper-prev">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-left-arrow.svg" alt="">
                    </div>
                    <div class="swiper-next">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-right-arrow.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News List Section -->
    <div class="block-news">
        <div class="news-bg">
            <div class="wrapper">
                <h2 class="h2"><?php echo esc_html(get_field('text_7')); ?></h2>
            </div>
        </div>
    </div>
    <section class="news-list">
        <div class="wrapper">
            <div class="container">
                <div class="news" id="news">
                    <?php
                    // Выводим все новости с кастомной пагинацией
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 6,
                        'paged' => $paged,
                        'category_name'  => 'auto-news', // Только авто новости
                    );
                    $news_query = new WP_Query($args);

                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post();
                    ?>
                            <div class="news-item">
                                <a class="home-news-grid-item-link" href="<?php the_permalink(); ?>">
                                    <div class="img-cont">
                                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                                    </div>
                                    <div class="news-item-right">
                                        <div class="news-item-right-top">
                                            <h3><?php the_title(); ?></h3>
                                            <p><?php echo get_the_date(); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        endwhile;
                    else :
                        echo '<p>Новостей пока нет.</p>';
                    endif;

                    // Ваша кастомная пагинация
                    ?>


                    <?php
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="pagination" id="pagination">
                    <?php
                    echo paginate_links(array(
                        'total' => $news_query->max_num_pages,
                        'prev_text' => __('<< Назад', 'my-custom-theme'),
                        'next_text' => __('Далее >>', 'my-custom-theme'),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer(); // Подключаем подвал
?>