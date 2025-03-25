<?php get_header(); ?>

<main>
    <section class="product-info">
        <div class="wrapper">
            <div class="product-info-container">
                <div class="product-info-slider-container">
                    <div class="slider-wrapper">
                        <!-- Основной слайдер -->
                        <div class="swiper gallery-top">
                            <div class="swiper-wrapper">
                                <?php
                                $gallery = get_field('gallery'); // Получаем галерею из ACF

                                if ($gallery) {
                                    foreach ($gallery as $image) {
                                        echo '<div class="swiper-slide">';
                                        // Добавление ссылки <a> с оригиналом изображения
                                        echo '<a href="' . esc_url($image['url']) . '" data-lightbox="gallery" data-title="' . esc_attr($image['caption']) . '">';
                                        //									echo '<img src="' . esc_url(wp_get_attachment_image_url($image['ID'], 'product_thumb')) . '" alt="' . esc_attr($image['alt']) . '">';
                                        echo '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';

                                        echo '</a>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Галерея отсутствует</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Слайдер миниатюр -->
                        <div class="swiper gallery-thumbs">
                            <div class="swiper-wrapper">
                                <?php
                                if ($gallery) {
                                    foreach ($gallery as $image) {
                                        echo '<div class="swiper-slide">';
                                        echo '<img src="' . esc_url(wp_get_attachment_image_url($image['ID'], 'gallery_thumb')) . '" alt="' . esc_attr($image['alt']) . '">';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>
                <div class="product-info-right">
                    <div>
                        <h2 class="product-info-title">
                            <?php the_title(); ?> <!-- Заголовок записи -->
                        </h2>
                        <div>
                            <div class="product-info-item">
                                <p><?php _e('Двигатель:', 'my-custom-theme'); ?></p>
                                <p><?php the_field('engine'); ?></p>
                            </div>
                            <div class="product-info-item">
                                <p><?php _e('Мощность:', 'my-custom-theme'); ?></p>
                                <p><?php the_field('power'); ?></p>
                            </div>
                            <div class="product-info-item">
                                <p><?php _e('Расход топлива:', 'my-custom-theme'); ?></p>
                                <p><?php the_field('fuel_consumption'); ?></p>
                            </div>
                            <div class="product-info-item">
                                <p><?php _e('Привод:', 'my-custom-theme'); ?></p>
                                <p><?php the_field('drive'); ?></p>
                            </div>
                            <div class="product-info-item">
                                <p><?php _e('Размеры (Длина/Ширина/Высота):', 'my-custom-theme'); ?></p>
                                <p><?php the_field('dimensions'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-info-gal-grid">
                            <?php
                            if (have_rows('преимущества')) { // Проверяем, есть ли данные в повторителе
                                while (have_rows('преимущества')) {
                                    the_row(); // Перебираем каждую запись
                                    $advantage_text = get_sub_field('advantage'); // Получаем текст из подполя

                                    // Статичный путь к иконке
                                    $static_icon_url = get_template_directory_uri() . '/assets/img/gal.svg'; // Замените путь на реальную иконку
                            ?>
                                    <div class="product-info-gal-container">
                                        <img src="<?php echo esc_url($static_icon_url); ?>" alt="Иконка преимущества">
                                        <p>
                                            <?php echo esc_html($advantage_text); ?> <!-- Вывод текста -->
                                        </p>
                                    </div>
                            <?php
                                }
                            } else {
                                echo '<p>Нет преимуществ</p>'; // Если нет данных
                            }
                            ?>
                        </div>
                        <h2 class="product-info-price">
                            <?php _e('от', 'my-custom-theme'); ?>
                            <span><?php the_field('prise'); ?>$</span>
                        </h2>
                        <button class="product-info-btn open-question-form" id="popup-btn">
                            <?php _e('Запросить цену', 'my-custom-theme'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="other-models">
        <div class="wrapper">
            <h2 class="h2">
                <?php _e('другие модели', 'my-custom-theme'); ?>
                <span class="h2-span">
                    <?php
                    $current_brand_terms = get_the_terms(get_the_ID(), 'brands'); // Получаем термины бренда
                    if ($current_brand_terms && !is_wp_error($current_brand_terms)) {
                        echo esc_html($current_brand_terms[0]->name); // Выводим название первого бренда
                    }
                    ?>
                </span>
            </h2>
            <div class="other-models-swiper_container">
                <div class="swiper-wrapper">
                    <?php
                    // Получаем бренд текущей карточки
                    $current_brand_terms = get_the_terms(get_the_ID(), 'brands'); // Таксономия 'brands'

                    if ($current_brand_terms && !is_wp_error($current_brand_terms)) {
                        $current_brand = $current_brand_terms[0]->slug; // Берём slug первого бренда

                        // Запрашиваем записи того же бренда
                        $related_posts = get_posts(array(
                            'post_type' => 'catalog', // Тип записи
                            'posts_per_page' => -1,   // Все записи бренда
                            'post__not_in' => array(get_the_ID()), // Исключаем текущую запись
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'brands', // Фильтр по таксономии 'brands'
                                    'field'    => 'slug',
                                    'terms'    => $current_brand, // Используем slug текущего бренда
                                ),
                            ),
                        ));

                        if ($related_posts) {
                            foreach ($related_posts as $post) {
                                setup_postdata($post);

                                // Получаем миниатюру записи
                                $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full'); // Используем 'full' для полного размера

                                // Если миниатюра отсутствует, задаём заглушку
                                if (!$thumbnail_url) {
                                    $thumbnail_url = get_template_directory_uri() . '/assets/img/default-thumbnail.jpg'; // Путь к заглушке
                                }

                                echo '<a href="' . esc_url(get_permalink($post->ID)) . '" class="swiper-slide">';


                                $price = esc_html(get_field('prise', $post->ID));
                                echo $price ? '<span class="price"> ' . __('от', 'my-custom-theme') . ' ' . $price . ' $</span>' : '';

                                echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title($post->ID)) . '">';
                                echo '<p>' . esc_html(get_the_title($post->ID)) . '</p>';
                                echo '</a>';
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<p>Нет записей в этом бренде</p>';
                        }
                    } else {
                        echo '<p>Бренд не найден</p>';
                    }
                    ?>
                </div>
                <div class="swiper-button-next">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-right-arrow.svg" alt="">
                </div>
                <div class="swiper-button-prev">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-left-arrow.svg" alt="">
                </div>
            </div>
        </div>
    </section>


</main>

<?php get_footer(); ?>