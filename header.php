<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

    <!-- Подключаем стили и скрипты -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="site-header">
    <div>
        <div class="wrapper">
            <div class="header-top flex">
                <div>
                    <p><?php echo pll__('Welcome to Horgos-autoexport.com'); ?></p>
                </div>
                <div class="header-top-right flex">
                    <div class="flex">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tel.svg" alt="">
                        <a href="tel:+8618154983097">+8618154983097</a>
                    </div>
                    <div class="flex">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mail.svg" alt="">
                        <a href="mailto:info@horgos-autoexport.com">info@horgos-autoexport.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="wrapper">
            <div class="header-bottom flex">
                <div class="burger-menu">
                    <div class="burger-icon" id="burger-icon">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/burger.svg" alt="Бургер меню">
                    </div>
                    <div class="menu-content" id="menu-content">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'container' => false,
                            'menu_class' => '',
                        ));
                        ?>
                    </div>
                </div>
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="">
                </a>
                <nav>
                    <ul class="header-bottom-nav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'container' => false,
                            'items_wrap' => '%3$s', // Убираем <ul>
                            'link_before' => '<li>',
                            'link_after' => '</li>',
                        ));
                        ?>
                    </ul>
                </nav>
                <div class="header-bottom-btn flex">
                   <div class="header-bottom-lang flex">
    <?php
    // Получаем массив языков
    $languages = pll_the_languages(array(
        'show_flags' => 0,        // Не показывать флаги
        'show_names' => 1,        // Показывать названия языков
        'hide_current' => 0,      // Показывать текущий язык
        'raw' => true             // Возвращает массив
    ));

    foreach ($languages as $language) {
        // Класс для активного языка
        $active_class = $language['current_lang'] ? 'active_lang' : '';
        echo '<button class="lang ' . $active_class . '" onclick="location.href=\'' . esc_url($language['url']) . '\'">' . esc_html($language['name']) . '</button>';
    }
    ?>
</div>
                    <a rel="noopener noreferrer" target="_blank" href="https://wa.me/8618154983097" class="header-bottom-btn-watsapp flex">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/watsapp.svg" alt="">
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
            <div class="header-mobile-contacts flex">
                <div class="flex">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/black-tel.svg" alt="">
                    <a href="tel:+8618154983097">+8618154983097</a>
                </div>
                <div class="flex">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/black-mail.svg" alt="">
                    <a href="mailto:info@horgos-autoexport.com">info@horgos-autoexport.com</a>
                </div>
            </div>
        </div>
    </div>
</header>