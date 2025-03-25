<?php
/* Template Name: Catalog */
get_header(); // Подключаем шапку

if ( function_exists('pll_get_post') ) {
    $catalog_url = get_permalink(pll_get_post(get_page_by_path('catalogs')->ID));
} else {
    $catalog_url = get_permalink( get_page_by_path('catalogs') );
}
?>

    <main>
        <section class="brand-hero">
            <a href="<?= $catalog_url ?>" class="catalog-banner"></a>
            <h1>
                <?php echo esc_html(get_field('block_1')); ?>
            </h1>
        </section>
        <section class="brand-brands">
            <div class="wrapper">
                <h2 class="h2">
                    <?php echo esc_html(get_field('block_2')); ?>
                </h2>
                <div class="logo-slider">
                    <!-- Слайдер -->
                    <div class="logo-swiper">
                        <?php
                        // Получаем все термины таксономии "Бренд"
                        $terms = get_terms(array(
                            'taxonomy' => 'brands', // Укажите вашу таксономию
                            'hide_empty' => false,    // Получить все термины, даже пустые
                        ));

                        if (!empty($terms) && !is_wp_error($terms)): ?>
                            <div class="swiper swiper-wrapper">
                                <?php foreach ($terms as $term):
                                    // Получаем поле ACF 'brand_logo' для текущего термина
                                    $logo = get_field('brand_logo', 'brands_' . $term->term_id);
                                    // Получаем ссылку на страницу архива
                                    $brand_link = get_term_link($term, 'brands');
                                    if ($logo && !is_wp_error($brand_link)) : // проверяем ошибки при создании ссылки.
                                        ?>
                                        <div class="swiper-slide">
                                            <a href="<?php echo esc_url($brand_link); ?>"
                                               title="<?php echo esc_attr($term->name); ?>">
                                                <img src="<?php echo esc_url($logo['url']); ?>"
                                                     alt="<?php echo esc_attr($term->name); ?>">
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Кнопки навигации -->
                        <div class="swiper-button-next">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-right-arrow.svg"
                                 alt="">
                        </div>
                        <div class="swiper-button-prev">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/home-left-arrow.svg"
                                 alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php

        // Получаем параметры из URL

        $selected_energy = isset($_GET['energy']) ? array_filter($_GET['energy']) : [];
        $energy_all = $selected_energy ? false : true;
        $selected_brands = isset($_GET['brands']) ? sanitize_text_field($_GET['brands']) : 'all';
        $selected_model = isset($_GET['model']) ? sanitize_text_field($_GET['model']) : 'all';
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        $_price = $_GET;
        $_order = $_GET;

        $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : '';

        $az_link = 'order=asc';
        $za_link = 'order=desc';

        $price = isset($_GET['price']) ? sanitize_text_field($_GET['price']) : '';

        $az_link_price = 'price=asc';
        $za_link_price = 'price=desc';

        if ($_GET) {
            unset($_price['order'], $_order['price']);

            if ($order) {
                $az_link = http_build_query(array_merge($_order, ['order' => 'asc']));
                $za_link = http_build_query(array_merge($_order, ['order' => 'desc']));
            } else {
                $az_link = $_order ? $az_link . '&' . http_build_query($_order) : $az_link;
                $za_link = $_order ? $za_link . '&' . http_build_query($_order) : $za_link;
            }


            if ($price) {
                $az_link_price = http_build_query(array_merge($_price, ['price' => 'asc']));
                $za_link_price = http_build_query(array_merge($_price, ['price' => 'desc']));
            } else {
                $az_link_price = $_price ? $az_link_price . '&' . http_build_query($_price) : $az_link_price;
                $za_link_price = $_price ? $za_link_price . '&' . http_build_query($_price) : $za_link_price;
            }
        }
        ?>

        <?php
        /** Фильтр Модели */
        $model_options = '';
        $current_terms_array = [];

        if ($selected_brands !== 'all') {
            $sel_brand = get_term_by('slug', $selected_brands, 'brands');
            if ($sel_brand) {
                $current_model_terms = get_terms([
                    'taxonomy' => 'model',
                    'object_ids' => get_objects_in_term($sel_brand->term_id, 'brands')
                ]);

                if (!is_wp_error($current_model_terms) && !empty($current_model_terms)) {
                    $current_terms_array = array_map(fn($term) => $term->slug, $current_model_terms);
                }
            }
        }

        $model_args = [
            'taxonomy' => 'model',
            'hide_empty' => true,
        ];

        // Получаем термины таксономии
        $model_terms = get_terms($model_args);

        if (!is_wp_error($model_terms) && !empty($model_terms)) {
            // Преобразуем массив объектов терминов в простой массив
            $terms_array = array_map(function ($term) {
                return array(
                    'name' => $term->name,
                    'slug' => $term->slug,
                );
            }, $model_terms);

            // Сортировка строго по первой букве
            usort($terms_array, function ($a, $b) {
                return strcmp($a['name'], $b['name']); // Строгая алфавитная сортировка
            });

            // Выводим отсортированные термины
            foreach ($terms_array as $term) {
                $data_brand = '';
                /** Получаем пост и через него бренд */
                $args = [
                    'post_type' => 'catalog',
                    'posts_per_page' => 1,
                    'fields' => 'ids',
                    'tax_query' => [
                        [
                            'taxonomy' => 'model',
                            'field'    => 'slug',
                            'terms'    => $term['slug']
                        ]
                    ]
                ];

                $query_p = new WP_Query($args);

                if (!empty($query_p->posts)) {
                    $brand_terms = get_the_terms($query_p->posts[0], 'brands');

                    if (!is_wp_error($brand_terms) && !empty($brand_terms)) {
                        $data_brand = $brand_terms[0]->slug; // Берём первый бренд
                    }
                }

                $model_options .= '<option value="' . esc_attr($term['slug']) . '" ' . selected($selected_model, $term['slug'], false) . ' data-brand="' . $data_brand . '" ' . ( $current_terms_array && !in_array($term['slug'], $current_terms_array) ? "style='display:none'" : "" ) . '>' . esc_html($term['name']) . '</option>';
            }
        } else {
            $model_options .= '<option value="">No Models Found</option>';
        }

        /** Фильтр Бренды */
        $brands_options = '';
        $brands_terms = get_terms(array(
            'taxonomy' => 'brands',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC'
        ));

        foreach ($brands_terms as $term) {
            $brands_options .= '<option value="' . esc_attr($term->slug). '" ' . selected($selected_brands, $term->slug, false) . '>' . esc_html($term->name) . '</option>';
        }

        /** Фильтр Energy */
        $energy_options = '';
        $energy_args = [
            'taxonomy' => 'energy',
            'hide_empty' => true,
        ];

        // Получаем термины таксономии energy
        $energy_terms = get_terms($energy_args);

        foreach ($energy_terms as $term) {

            if ($selected_brands !== 'all') {
                $sel_brand = get_term_by('slug', $selected_brands, 'brands');
                $query = new WP_Query(array(
                    'post_type' => 'catalog', // Укажите ваш тип постов
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'energy', // Таксономия типа энергии
                            'field' => 'slug',
                            'terms' => $term->slug,
                            'orderby' => 'name', // Сортируем по имени
                            'order' => 'ASC'
                        ),
                        array(
                            'taxonomy' => 'brands', // Таксономия бренда
                            'field' => 'term_id',
                            'terms' => $sel_brand->term_id, // ID текущего бренда
                            'orderby' => 'name', // Сортируем по имени
                            'order' => 'ASC'
                        ),
                    ),
                    'fields' => 'ids', // Берем только ID для улучшения производительности
                    'posts_per_page' => -1,
                ));

                $adjusted_count = floor($query->post_count);
            } else {
                $adjusted_count = floor($term->count / 2);
            }

            $energy_options .= '
                <label>
                    <div>' . esc_html($term->name) . ' (' . $adjusted_count. ')</div>
                <input type="checkbox" ' .( $selected_energy && in_array(esc_attr($term->slug), $selected_energy) ? "checked" : "" ). '
                    name="energy[]" value="' . esc_attr($term->slug) . '" class="energy-filter energy-option">
            </label>';
        } ?>

        <section class="brand-models">
            <div class="wrapper">
                <h2 class="h2">
                    <?php echo esc_html(get_field('block_3')); ?>
                </h2>
                <div class="filter-block">
                    <div class="filter-price">
                        <span>Price</span>
                        <a href="<?php echo $catalog_url . '?' . $az_link_price; ?>"
                           class="filter-btn<?php echo $price == 'asc' ? ' active disabled' : ''; ?>">
                            <img src="<?= get_template_directory_uri() ?>/assets/img/arrow-down.svg" class="price-btn">
                        </a>
                        <a href="<?php echo $catalog_url . '?' . $za_link_price; ?>"
                           class="filter-btn<?php echo $price == 'desc' ? ' active disabled' : ''; ?>">
                            <img src="<?= get_template_directory_uri() ?>/assets/img/arrow-down.svg" class="price-btn-2">
                        </a>
                    </div>
                    <div class="filter-sort">
                        <a href="<?php echo $catalog_url . '?' . $az_link; ?>" class="filter-btn<?php echo $order == 'asc' ? ' active disabled' : ''; ?>">A→Z</a>
                    </div>
                    <div class="filter-sort">
                        <a href="<?php echo $catalog_url . '?' . $za_link; ?>" class="filter-btn<?php echo $order == 'desc' ? ' active disabled' : ''; ?>">Z←A</a>
                    </div>

                    <div class="mobile-only filters-mob">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/filters-mob.svg" alt="" id="open-filter">
                    </div>
                </div>
                <div class="container">
                    <!-- Попап -->
                    <div id="popup" class="popup" style="background: rgba(0, 0, 0, 0.5);">
                        <div class="popup-content">
                            <span class="close" id="close-popup"></span>
                            <!-- Мобильная версия в попапе -->
                            <form id="popup-filter-form" method="GET" action="<?= $catalog_url ?>">
                                <div class="filters2">
                                    <div class="filters-title-container">
                                        <h3><?php _e('Поиск по каталогу', 'my-custom-theme'); ?></h3>
                                    </div>
                                    <div class="filters-container">
                                        <?php
                                        echo $order ? '<input type="hidden" name="order" value="' . $order . '">' : '';
                                        echo $price ? '<input type="hidden" name="price" value="' . $price . '">' : '';
                                        ?>
                                        <!-- Тип энергии -->
                                        <div class="filters-checkboxes-container">
                                            <!-- "All Energy" чекбокс -->
                                            <label>
                                                <div>All Energy</div>
                                                <input type="checkbox" name="energy-all" <?php checked($energy_all, true); ?> id="all-energy" value="all">
                                            </label>
                                            <?= $energy_options ?>
                                        </div>

                                        <!-- Бренды -->
                                        <div class="custom-select-container">
                                            <select name="brands" class="filter-brands" id="popup-brands">
                                                <option value="all">All Brands</option>
                                                <?= $brands_options ?>
                                            </select>
                                        </div>

                                        <!-- Модели -->
                                        <div class="custom-select-container">
                                            <select name="model" class="filter-models" id="popup-models">
                                                <option value="all">All Models</option>
                                                <?= $model_options ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" id="popup-search-button">
                                        <?php echo __('Поиск', 'my-custom-theme'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="products" id="products">
                        <?php

                        // Формируем аргументы для WP_Query
                        $args = [
                            'post_type' => 'catalog',
                            'posts_per_page' => 36, // Количество записей на страницу
                            'paged' => $paged, // Устанавливаем пагинацию
                            'tax_query' => [
                                'relation' => 'AND',
                            ],
//                            'orderby' => 'title',
//                            'order' => $order ? strtoupper($order) : 'ASC',

                            'meta_key' => 'prise',
                            'orderby' => 'meta_value_num',
                            'order' => $price ? strtoupper($price) : 'ASC'
                        ];



                        if ($order) {
                            $args['orderby'] = 'title';
                            $args['order'] = strtoupper($order);
                        }

                        if ($selected_energy) {
                            $args['tax_query'][] = [
                                'taxonomy' => 'energy',
                                'field' => 'slug',
                                'terms' => $selected_energy,
                            ];
                        }

                        if ($selected_brands !== 'all') {
                            $args['tax_query'][] = [
                                'taxonomy' => 'brands',
                                'field' => 'slug',
                                'terms' => $selected_brands,
                            ];
                        }

                        if ($selected_model !== 'all') {
                            $args['tax_query'][] = [
                                'taxonomy' => 'model',
                                'field' => 'slug',
                                'terms' => $selected_model,
                            ];
                        }
                        // Выполняем запрос
                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            $energy = get_the_terms(get_the_ID(), 'energy');
                            $brands = get_the_terms(get_the_ID(), 'brands');
                            $model = get_the_terms(get_the_ID(), 'model');
                            ?>
                            <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="product-link">
                                <div class="product-card"
                                     data-energy="<?php echo esc_attr($energy[0]->slug ?? ''); ?>"
                                     data-brands="<?php echo esc_attr($brands[0]->slug ?? ''); ?>"
                                     data-model="<?php echo esc_attr($model[0]->slug ?? ''); ?>">
                                    <?php
                                    $prise = esc_html(get_field('prise', get_the_ID()));
                                    echo $prise ? '<span class="price"> ' . __('от', 'my-custom-theme') . ' ' . $prise . ' $</span>' : '';
                                    ?>
                                    <img
                                        src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>"
                                        alt="<?php the_title(); ?>">
                                    <h4><?php the_title(); ?></h4>
                                </div>
                            </a>
                        <?php endwhile; ?>

                    </div>
                    <form id="filter-form-desktop" method="GET" action="<?= $catalog_url ?>">
                        <div class="filters">
                            <div class="filters-title-container">
                                <h3><?php _e('Поиск по каталогу', 'my-custom-theme'); ?></h3>
                            </div>
                            <div class="filters-container">
                                <?php
                                echo $order ? '<input type="hidden" name="order" value="' . $order . '">' : '';
                                echo $price ? '<input type="hidden" name="price" value="' . $price . '">' : '';
                                ?>

                                <!-- Тип энергии -->
                                <div class="filters-checkboxes-container">
                                    <!-- "All Energy" чекбокс -->
                                    <label>
                                        <div>All Energy</div>
                                        <input type="checkbox" name="energy-all" <?php checked($energy_all, true); ?>
                                               id="all-energy-two" value="all" class="energy-filter">
                                    </label>
                                    <?= $energy_options ?>
                                </div>

                                <!-- Бренды -->
                                <div class="custom-select-container">
                                    <select name="brands" class="filter-brands">
                                        <option value="all">All Brands</option>
                                        <?= $brands_options ?>
                                    </select>
                                </div>

                                <!-- Модели -->
                                 <div class="custom-select-container">
                                    <select name="model" class="filter-models">
                                        <option value="all">All Models</option>
                                        <?php echo $model_options; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" id="search-button-desktop">
                                <?php echo __('Поиск', 'my-custom-theme'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php

            $big = 999999999;
            $base_url = get_pagenum_link($big);
            $base_url = remove_query_arg('paged', $base_url); // Убираем paged из URL

            // Парсим URL, чтобы корректно обрабатывать параметры
            $parsed_url = parse_url($base_url);
            $query_params = [];
            if (!empty($parsed_url['query'])) {
                parse_str($parsed_url['query'], $query_params);
            }

            // Удаляем возможные дублирующиеся параметры
            $query_params = array_diff_key($query_params, array_flip(['paged']));

            // Обновляем URL без лишних параметров
            $clean_base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];

            // Убираем дубликаты из $_GET
            $get_params = array_diff_key($_GET, array_flip(['paged']));

            // Генерируем аргументы пагинации
            $pagination_args = [
                'base'      => user_trailingslashit(str_replace($big, '%#%', esc_url_raw($clean_base_url))),
                'format'    => 'page/%#%',
                'current'   => max(1, $paged),
                'total'     => $query->max_num_pages,
                'prev_text' => '<< Назад',
                'next_text' => 'Далее >>',
                'add_args'  => array_diff_key($get_params, $query_params), // Удаляем из $_GET уже существующие параметры
            ];


            echo '<div class="pagination">';
            echo paginate_links($pagination_args);
            echo '</div>';
            else :
                echo '<p>Нет доступных элементов каталога.</p>';
            endif;

            wp_reset_postdata();

            ?>
        </section>
    </main>
    <script>
        jQuery(document).ready(function ($) {
            $('.filter-brands').on('change', function () {
                let selectedBrand = $(this).val();

                $('.filter-models option').hide(); // Скрываем все
                if (selectedBrand === 'all') {
                    $('.filter-models option').show(); // Если выбран "all", показываем все
                } else {
                    $('.filter-models option[data-brand="' + selectedBrand + '"]').show(); // Показываем нужные
                }
            });
        });

    </script>
<?php
get_footer(); // Подключаем подвал
?>