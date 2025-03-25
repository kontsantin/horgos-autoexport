<?php





// // Подключаем файл feedback-modal.php
require_once get_template_directory() . '/inc/admin-forms.php';
require_once get_template_directory() . '/inc/form-handler.php';


function my_theme_setup() {
    add_theme_support('post-thumbnails'); // Включает поддержку миниатюр
}
add_action('after_setup_theme', 'my_theme_setup');

add_image_size('gallery_thumb', 100, 0, false);
//add_image_size('product_thumb', 800, 0, false);


function my_custom_theme_enqueue_scripts() {
    // Общие стили и скрипты
    wp_enqueue_style('global-style', get_template_directory_uri() . '/assets/css/all/style.css', array(), filemtime(get_template_directory() . '/assets/css/all/style.css'));
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/header/style.css', array(), filemtime(get_template_directory() . '/assets/css/header/style.css'));
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/assets/css/footer/style.css', array(), filemtime(get_template_directory() . '/assets/css/footer/style.css'));
    wp_enqueue_script('app-script', get_template_directory_uri() . '/assets/js/app.js', array(), filemtime(get_template_directory() . '/assets/js/app.js'), true);   

    // Подключаем Swiper для всех страниц
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), null);
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), null, true);

    // Подключение дополнительных стилей и скриптов для разных страниц
    if (is_front_page()) {
        wp_enqueue_style('home-style', get_template_directory_uri() . '/assets/css/home/style.css', array(), filemtime(get_template_directory() . '/assets/css/home/style.css'));
        wp_enqueue_script('home-script', get_template_directory_uri() . '/assets/js/script.js', array('swiper-js'), filemtime(get_template_directory() . '/assets/js/script.js'), true);
    }

    if (is_page(array('catalogs', 'catalogs-en')) || is_tax('brands')) {
        wp_enqueue_style('catalog-style', get_template_directory_uri() . '/assets/css/brand/style.css', array(), filemtime(get_template_directory() . '/assets/css/brand/style.css'));
        wp_enqueue_script('brand-script', get_template_directory_uri() . '/assets/js/brand.js', array('swiper-js'), filemtime(get_template_directory() . '/assets/js/brand.js'), true);
        if (is_tax('brands')) {
            error_log('tax brand is true!');
        }
    } else {
        error_log('tax brand is false!');
    }

    if (is_singular('catalog')) {
        // Подключаем стили и скрипты для страницы 'catalog'
        wp_enqueue_style('catalog-style', get_template_directory_uri() . '/assets/css/product-card/style.css', array(), filemtime(get_template_directory() . '/assets/css/product-card/style.css'));
        wp_enqueue_script('catalog-script', get_template_directory_uri() . '/assets/js/card.js', array('swiper-js'), filemtime(get_template_directory() . '/assets/js/card.js'), true);

        // Подключаем Lightbox2 CSS и JS
        wp_enqueue_style('lightbox2-style', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css', array(), '2.11.3');
        wp_enqueue_script('lightbox2-script', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array(), '2.11.3', true);
    }

    if (is_page(array('contacts', 'contacts-en'))) {
        wp_enqueue_style('contact-style', get_template_directory_uri() . '/assets/css/contact/style.css', array(), filemtime(get_template_directory() . '/assets/css/contact/style.css'));
    }

    if (is_page(array('about', 'about-en'))) {
        wp_enqueue_style('about-style', get_template_directory_uri() . '/assets/css/about/style.css', array(), filemtime(get_template_directory() . '/assets/css/about/style.css'));
    }

    if (is_singular('post')) { // Замените 'post' на 'catalog' или другой тип записи, если нужно
        wp_enqueue_style('news-style', get_template_directory_uri() . '/assets/css/news-item/style.css', array(), filemtime(get_template_directory() . '/assets/css/news-item/style.css'));
    }

    if (is_page(array('news', 'news-en'))) {
        wp_enqueue_style('news-style', get_template_directory_uri() . '/assets/css/info/style.css', array(), filemtime(get_template_directory() . '/assets/css/info/style.css'));
        wp_enqueue_script('news-script', get_template_directory_uri() . '/assets/js/news.js', array(), filemtime(get_template_directory() . '/assets/js/news.js'), true);
    }

    if (is_page(array('faq', 'faq-en'))) {
        wp_enqueue_style('faq-style', get_template_directory_uri() . '/assets/css/faq/style.css', array(), filemtime(get_template_directory() . '/assets/css/faq/style.css'));
        wp_enqueue_script('faq-script', get_template_directory_uri() . '/assets/js/faq.js', array(), filemtime(get_template_directory() . '/assets/js/faq.js'), true);
    }

    if (is_page(array('privacy-policy', 'privacy-policy-en', 'conditions', 'conditions-en'))) {
        wp_enqueue_style('page-privacy-policy-style', get_template_directory_uri() . '/assets/css/page-privacy-policy/page-privacy-policy.css', array(), filemtime(get_template_directory() . '/assets/css/page-privacy-policy/page-privacy-policy.css'));
    }
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_scripts');


   
// В functions.php добавьте подключение скрипта для AJAX
function theme_enqueue_scripts() {
    wp_enqueue_script('popup-scripts', get_template_directory_uri() . '/assets/js/popup.js', array('jquery'), null, true);
    wp_localize_script('popup-scripts', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php') ));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// Регистрация меню
function my_custom_theme_register_menus() {
    register_nav_menus(array(
        'header-menu' => 'Header Menu',
        'footer-menu' => 'Footer Menu',
        'footer-menu-two' => 'Footer two Menu',
    ));
}
add_action('after_setup_theme', 'my_custom_theme_register_menus');












function ajax_load_news() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    if ($paged < 1) {
        wp_send_json_error('Некорректный номер страницы', 400);
    }

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 9,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="news-item">
                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                <div class="news-item-right">
                    <div class="news-item-right-top">
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo get_the_date(); ?></p>
                    </div>
                    <div class="news-slider-btn">
                        <a href="<?php the_permalink(); ?>">Подробнее</a>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/arrow-news.svg" alt="">
                    </div>
                </div>
            </div>
            <?php
        endwhile;
    else :
        echo '<p>Новостей больше нет.</p>';
    endif;

    wp_die(); // Завершение обработки запроса
}



function create_catalog_post_type() {
    register_post_type('catalog', array(
        'labels' => array(
            'name' => 'Каталог',
            'singular_name' => 'Элемент каталога',
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-archive',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'catalog'),
    ));
}
add_action('init', 'create_catalog_post_type');


function register_catalog_taxonomies() {
    // Тип энергии
    register_taxonomy('energy', 'catalog', array(
        'labels' => array(
            'name' => pll__('Тип энергии'),  // Используем pll__() для перевода метки
            'singular_name' => pll__('Тип энергии'),
            'search_items' => pll__('Поиск типов энергии'),
            'all_items' => pll__('Все типы энергии'),
            'edit_item' => pll__('Редактировать тип энергии'),
            'update_item' => pll__('Обновить тип энергии'),
            'add_new_item' => pll__('Добавить новый тип энергии'),
            'new_item_name' => pll__('Название нового типа энергии'),
            'menu_name' => pll__('Тип энергии'),
        ),
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array('slug' => 'energy'),
    ));

    // Бренды
    register_taxonomy('brands', 'catalog', array(
        'labels' => array(
            'name' => pll__('Бренды'),  // Используем pll__() для перевода метки
            'singular_name' => pll__('Бренд'),
            'search_items' => pll__('Поиск брендов'),
            'all_items' => pll__('Все бренды'),
            'edit_item' => pll__('Редактировать бренд'),
            'update_item' => pll__('Обновить бренд'),
            'add_new_item' => pll__('Добавить новый бренд'),
            'new_item_name' => pll__('Название нового бренда'),
            'menu_name' => pll__('Бренды'),
        ),
        'hierarchical' => false,
        'public' => true,
        'rewrite' => array('slug' => 'brands'),
    ));

    // Модели
    register_taxonomy('model', 'catalog', array(
        'labels' => array(
            'name' => pll__('Модели'),  // Используем pll__() для перевода метки
            'singular_name' => pll__('Модель'),
            'search_items' => pll__('Поиск моделей'),
            'all_items' => pll__('Все модели'),
            'edit_item' => pll__('Редактировать модель'),
            'update_item' => pll__('Обновить модель'),
            'add_new_item' => pll__('Добавить новую модель'),
            'new_item_name' => pll__('Название новой модели'),
            'menu_name' => pll__('Модели'),
        ),
        'hierarchical' => false,
        'public' => true,
        'rewrite' => array('slug' => 'model'),
    ));
}
add_action('init', 'register_catalog_taxonomies');












function pass_ajax_url_to_js() {
    echo '<script type="text/javascript">const ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}
add_action('wp_head', 'pass_ajax_url_to_js');



function register_catalog_for_polylang($post_types) {
    $post_types['catalog'] = 'catalog'; // Замените 'catalog' на ваш пользовательский тип записи
    return $post_types;
}
add_filter('pll_get_post_types', 'register_catalog_for_polylang', 10, 2);







//!!!!!!
// Подключение AJAX-скрипта для фильтрации
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'ajax-filter', // Уникальное имя скрипта
        get_template_directory_uri() . '/assets/js/ajax-filter.js', // Путь к файлу
        array('jquery'), // Зависимости
        null, // Версия (можно оставить null)
        true // Подключить в футере
    );

    // Передача AJAX URL в скрипт
    wp_localize_script('ajax-filter', 'ajaxfilter', array(
        'ajax_url' => admin_url('admin-ajax.php'), // AJAX обработчик
    ));
});



//!!!!!!

// Регистрация AJAX-обработчика
add_action('wp_ajax_filter_catalog', 'ajax_filter_catalog');
add_action('wp_ajax_nopriv_filter_catalog', 'ajax_filter_catalog');

function ajax_filter_catalog() {
    parse_str($_POST['form_data'], $filter_data); // Разбираем данные из формы

    $brand = sanitize_text_field($filter_data['brand']);
    $model = sanitize_text_field($filter_data['model']);
    $energy = isset($filter_data['energy']) ? array_map('sanitize_text_field', $filter_data['energy']) : array();

    // Формируем tax_query
    $tax_query = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'brands',
            'field'    => 'slug',
            'terms'    => $brand,
        )
    );

    if (!empty($model)) {
        $tax_query[] = array(
            'taxonomy' => 'model',
            'field'    => 'slug',
            'terms'    => $model,
        );
    }

    if (!empty($energy)) {
        $tax_query[] = array(
            'taxonomy' => 'energy',
            'field'    => 'slug',
            'terms'    => $energy,
        );
    }

    // Запрос записей
    $query = new WP_Query(array(
        'post_type' => 'catalog',
        'tax_query' => $tax_query,
        'posts_per_page' => -1,
    ));

    // Формируем HTML ответа
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Получаем миниатюру
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            if (!$image_url) {
                $image_url = '/img/default-placeholder.png'; // Путь к изображению-заглушке
            }

            // Получаем данные таксономий
            $energy_terms = get_the_terms(get_the_ID(), 'energy');
            $brand_terms = get_the_terms(get_the_ID(), 'brands');
            $model_terms = get_the_terms(get_the_ID(), 'model');

            $energy_name = $energy_terms ? $energy_terms[0]->name : '';
            $brand_name = $brand_terms ? $brand_terms[0]->name : '';
            $model_name = $model_terms ? $model_terms[0]->name : '';

            ?>
             <a href="<?php echo esc_url(get_permalink()); ?>" class="product-link">
                <div class="product-card" data-energy="<?php echo esc_attr($energy); ?>" data-brand="<?php echo esc_attr($brand); ?>" data-model="<?php echo esc_attr($model); ?>">
                    <?php
                    $prise = esc_html(get_field('prise', get_the_ID()));
                    echo $prise ? '<span class="price"> ' . __('от', 'my-custom-theme') . ' ' . $prise . ' $</span>' : '';
                    ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <h4><?php the_title(); ?></h4>
                </div>
            </a>
            <?php
        }
    } else {
        echo '<p>Нет записей по выбранным критериям.</p>';
    }

    wp_die(); // Завершаем выполнение
}
























?>