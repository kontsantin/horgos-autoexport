<?php
/* Template Name: Home Page */
get_header(); // Подключаем шапку
?>

<main>
    <section class="home-hero">
        <div class="swiper-container">
            <?php if (have_rows('hero_slider')): ?>
                <div class="swiper-wrapper">
                    <?php
                    $slide_index = 1; // Счетчик для классов
                    while (have_rows('hero_slider')): the_row(); ?>
                        <div class="swiper-slide slide<?php echo $slide_index; ?>">
                            <?php $image = get_sub_field('hero_image'); ?>
                            <img class="hero__slider-image" src="<?php echo esc_html($image); ?>" alt="<?php the_sub_field('hero_title'); ?>" class="lazyload" />
                            <div class="hero__slide-content">
                                <div class="hero__slide-content-top">
                                    <h2><?php the_sub_field('hero_title'); ?></h2>
                                    <h3><?php the_sub_field('hero_sub-title'); ?></h3>
                                </div>
                                <div class="hero__slide-content-bottom">
                                    <h4><?php if (get_field('check_bottom_sub-title') == true): ?>
                                            <h4><?php the_field('hero_sub-title_bottom'); ?></h4>
                                        <?php endif; ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    <?php
                        $slide_index++; // Увеличиваем счетчик
                    endwhile; ?>
                </div>
            <?php endif; ?>
            <div class="hero-nav-buttons-container">
                <div class="swiper-button-next swiper-button-next-baner-next">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-right-arrow.svg" alt="">
                </div>
                <div class="swiper-button-prev swiper-button-next-baner-prev">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-left-arrow.svg" alt="">
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <section class="home-services">
        <div class="wrapper">
            <h2 class="h2">
                <?php echo esc_html(get_field('block_2_h2_1')); ?> <span class="h2-span"><?php echo esc_html(get_field('block_2_h2_2')); ?></span>?
            </h2>
            <div class="home-services-flex">
                <div class="services-item">
                    <h3><?php echo esc_html(get_field('block_2_h3_1')); ?></h3>
                    <div class="item-12">
                        <?php if (have_rows('block_2_list_1')): // Проверяем, есть ли данные в повторителе 
                        ?>
                            <?php while (have_rows('block_2_list_1')): the_row(); // Перебираем строки повторителя 
                            ?>
                                <div>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gal.svg" alt="">
                                    <p>
                                        <?php echo esc_html(get_sub_field('block_2_text_1')); // Вывод текста из вложенного поля 
                                        ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Данные не найдены</p> <!-- Если повторитель пуст -->
                        <?php endif; ?>
                    </div>
                </div>
                <div class="services-item">
                    <h3><?php echo esc_html(get_field('block_2_h3_2')); ?></h3>
                    <div class="item-12">
                        <?php if (have_rows('block_2_list_2')): // Проверяем, есть ли данные в повторителе 
                        ?>
                            <?php while (have_rows('block_2_list_2')): the_row(); // Перебираем строки повторителя 
                            ?>
                                <div>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gal.svg" alt="">
                                    <p>
                                        <?php echo esc_html(get_sub_field('block_2_text_2')); // Вывод текста из вложенного поля 
                                        ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Данные не найдены</p> <!-- Если повторитель пуст -->
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-brands">
        <div class="wrapper">
            <h2 class="h2">
                <?php echo esc_html(get_field('block_3_h2_1')); ?> <span class="h2-span"><?php echo esc_html(get_field('block_3_h2_2')); ?></span>
            </h2>
            <div class="home-brands-grid">
                <?php
                $brands = get_field('block_brands');
                if ($brands) {
                    foreach ($brands as $brand) {
                        // Получаем поле ACF 'brand_logo' для текущего термина
                        $logo = get_field('brand_logo', 'brands_' . $brand->term_id);
                        if ($logo) {
                            echo '<div>';
                            echo '<img loading="lazy" src="' . esc_url($logo['url']) . '" alt="' . esc_attr($brand->name) . '">';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p>Логотипы не найдены.</p>'; // Если термины отсутствуют
                }
                ?>
            </div>
        </div>
    </section>
    <section class="home-for_clients">
        <div class="wrapper">
            <div class="home-for_clients-grid">
                <div class="home-for_clients-grid-item home-for_clients-one">
                    <h2 class="h2">
                        <?php echo esc_html(get_field('block_4_h2_1')); ?> <span class="h2-span"><?php echo esc_html(get_field('block_4_h2_2')); ?></span> <?php echo esc_html(get_field('block_4_h2_3')); ?>
                    </h2>
                </div>
                <div class="home-for_clients-grid-item home-for_clients-two">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/akar-icons_location.svg" alt="">
                    <p>
                        <?php echo esc_html(get_field('block_4_text_1')); ?>
                    </p>
                </div>
                <div class="home-for_clients-grid-item home-for_clients-three">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mdi_sale-box-outline.svg" alt="">
                    <p>
                        <?php echo esc_html(get_field('block_4_text_2')); ?>
                    </p>
                </div>
                <div class="home-for_clients-grid-item home-for_clients-four">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mi_document.svg" alt="">
                    <p>
                        <?php echo esc_html(get_field('block_4_text_3')); ?>
                    </p>
                </div>
                <div class="home-for_clients-grid-item home-for_clients-five">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-park-outline_transporter.svg" alt="">
                    <p>
                        <?php echo esc_html(get_field('block_4_text_4')); ?>
                    </p>
                </div>
                <div class="home-for_clients-grid-item home-for_clients-six">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ion_people-outline.svg" alt="">
                    <p>
                        <?php echo esc_html(get_field('block_4_text_5')); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="popular-models">
        <div class="wrapper">
            <div>
                <h2 class="h2">
                    <?php echo esc_html(get_field('block_5_h2_1')); ?> <span class="h2-span"> <?php echo esc_html(get_field('block_5_h2_2')); ?></span>
                </h2>
                <div class="popular-models-grid">
                    <?php
                    // Настройка параметров WP_Query для вывода последних записей каталога
                    $models = get_field('block_popular');

                    $args = [
                        'post_type'      => 'catalog', // Тип записи
                        'posts_per_page' => 8,         // Количество записей
                        'orderby'        => 'post__in', // Сортировка по переданному массиву ID
                        'post__in'       => $models,
                    ];

                    $query = new WP_Query($args);

                    // Проверяем, есть ли записи
                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL миниатюры записи
                    ?>
                            <a href="<?php the_permalink(); ?>" class="popular-models-grid-item-link">
                                <div
                                    class="popular-models-grid-item"
                                    style="background: url('<?php echo esc_url($thumbnail_url); ?>') no-repeat; 
                           background-size: contain; 
                           background-position: left bottom;">
                                    <p><?php the_title(); // Вывод заголовка записи 
                                        ?></p>
                                </div>
                            </a>
                        <?php endwhile;
                        wp_reset_postdata(); // Сбрасываем глобальные переменные
                    else : ?>
                        <p>Записи не найдены.</p>
                    <?php endif; ?>

                    <!-- Последняя ячейка -->
                    <a href="<?php echo esc_html(get_field('link')); ?>">
                        <p><?php echo esc_html(get_field('catalog')); ?></p>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow.svg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="reviews">
        <div class="wrapper">
            <h2 class="h2">
                <span class="h2-span"><?php echo esc_html(get_field('block_6_h2_1')); ?></span> <?php echo esc_html(get_field('block_6_h2_2')); ?>
            </h2>
            <div class="swiper-reviews">
                <div class="swiper-wrapper">
                    <?php if (have_rows('rev')): // Проверяем, есть ли данные в поле повторителя 
                    ?>
                        <?php while (have_rows('rev')): the_row(); // Перебираем строки повторителя 
                        ?>
                            <div class="swiper-slide">
                                <div class="swiper-slide-wrapper">
                                    <div>
                                        <?php
                                        // Получаем изображение из поля повторителя img_1
                                        $img = get_sub_field('img_1');
                                        if (!empty($img)): // Проверка, если изображение загружено
                                        ?>
                                            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                                        <?php else: ?>
                                            <!-- Фallback изображение -->
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-rev-1.jpg" alt="Фото отзыва">
                                        <?php endif; ?>
                                    </div>
                                    <div class="rev-item">
                                        <p class="rev-text">
                                            <?php echo esc_html(get_sub_field('review')); // Вывод текста отзыва 
                                            ?>
                                        </p>
                                        <div>
                                            <p class="rev-name">
                                                <?php echo esc_html(get_sub_field('data')); // Вывод имени автора отзыва 
                                                ?>
                                            </p>
                                            <p class="rev-name">
                                                <?php echo esc_html(get_sub_field('name')); // Вывод имени автора отзыва 
                                                ?>
                                            </p>
                                            <div class="rev-stars flex">
                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/star.svg" alt="Звезда">
                                                <?php endfor; ?>
                                            </div>
                                            <div class="rev-bottom">
                                                <p>
                                                    <?php echo esc_html(get_sub_field('mark')); // Вывод марки автомобиля 
                                                    ?>
                                                </p>
                                                <button class="open-review-form" id="popup-rev">
                                                    <?php echo esc_html(get_field('button_rev')); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Отзывов пока нет.</p> <!-- Если отзывы отсутствуют -->
                    <?php endif; ?>
                </div>
            </div>
            <div class="swiper-button-next">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-right-arrow.svg" alt="">
            </div>
            <div class="swiper-button-prev">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-left-arrow.svg" alt="">
            </div>
        </div>
    </section>
    <section class="home-news">
        <div class="wrapper">
            <?php
            // Получаем текущий язык сайта
            $current_language = pll_current_language();

            if ($current_language === 'en') {
                // Для английского языка
            ?>
                <a class="home-news-title" href="/en/news-en/">
                    <h2 class="h2">
                        <?php echo esc_html(get_field('block_7_h2_1')); ?>
                        <span class="h2-span"><?php echo esc_html(get_field('block_7_h2_2')); ?> </span>
                    </h2>
                </a>

            <?php
            } else {
                // Для всех остальных языков (например, русского)
            ?>
                <a class="home-news-title" href="/news">
                    <h2 class="h2">
                        <?php echo esc_html(get_field('block_7_h2_1')); ?>
                        <span class="h2-span"> <?php echo esc_html(get_field('block_7_h2_2')); ?> </span>
                    </h2>
                </a>
            <?php
            }
            ?>

            <div class="home-news-grid">
                <?php
                $args = array(
                    'post_type' => 'post', // Тип записи - новость (стандартный пост)
                    'posts_per_page' => 3, // Вывести 3 последних новости
                    'orderby' => 'date',  // Сортировать по дате
                    'order' => 'DESC',    // В обратном порядке (от новых к старым)
                    'category_name'  => 'useful-info',
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();
                ?> <a class="home-news-grid-item-link" href="<?php the_permalink(); ?>">
                            <div class="home-news-grid-item">

                                <div>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/default-thumbnail.jpg" alt="Default Image">
                                    <?php endif; ?>
                                </div>
                                <div class="cont-three">
                                    <div>
                                        <p class="home-news-grid-item-title">
                                            <?php echo wp_trim_words(get_the_title(), 10, '...'); ?>
                                        </p>
                                        <p class="home-news-grid-item-date">
                                            <?php echo get_the_date(); ?>
                                        </p>
                                    </div>
                                    <!-- <div class="home-news-grid-item-bottom">
                                  
                                        <p><?php _e('подробнее', 'my-custom-theme'); ?></p>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow-news.svg" alt="">
                                  
                                </div> -->
                                </div>
                            </div>
                        </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('Записей не найдено', 'my-custom-theme') . '</p>'; // Если нет записей
                endif;
                ?>
            </div>
        </div>
    </section>
    <section class="home-questions">
        <div class="wrapper">
            <div class="home-questions-container">
                <div>
                    <h2 class="h2">
                        <?php echo esc_html(get_field('block_8_h2_1')); ?> <span class="h2-span"><?php echo esc_html(get_field('block_8_h2_2')); ?></span> <?php echo esc_html(get_field('block_8_h2_3')); ?>
                    </h2>
                    <h3>
                        <?php echo esc_html(get_field('block_8_text')); ?>
                    </h3>
                </div>
                <div>
                    <button class="open-question-form" id="popup-btn"> <?php echo esc_html(get_field('block_8_quer')); ?></button>
                </div>
            </div>
        </div>
    </section>




</main>

<?php
get_footer(); // Подключаем подвал
?>