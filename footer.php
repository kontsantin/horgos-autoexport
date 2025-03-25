<footer>
    <div class="wrapper">
        <div class="footer-container">
            <div class="footer-container-left">
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer-logo.svg" alt="">
                    <div class="footer-social">
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/lucide_facebook.svg" alt="Facebook"></a>
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/basil_linkedin-outline.svg" alt="LinkedIn"></a>
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/ri_youtube-line.svg" alt="YouTube"></a>
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/line-md_telegram.svg" alt="Telegram"></a>
                        <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/gg_instagram.svg" alt="Instagram"></a>
                    </div>
                </div>
                <div class="footer-menu">
                    <h3><?php _e('Каталог', 'my-custom-theme'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'container' => false,
                        'menu_class' => 'footer-catalog-menu',
                        'items_wrap' => '<ul>%3$s</ul>',
                    ));
                    ?>
                </div>
                <div class="footer-menu">
                    <h3><?php _e('О нас', 'my-custom-theme'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu-two',
                        'container' => false,
                        'menu_class' => 'footer-about-menu',
                        'items_wrap' => '<ul>%3$s</ul>',
                    ));
                    ?>
                </div>
            </div>
            <div class="footer-container-right">
                <div class="footer-item-two">
                    <div>
                        <img class="opacity" src="<?php echo get_template_directory_uri(); ?>/assets/img/tel.svg" alt="">
                        <h3><?php _e('Контакты', 'my-custom-theme'); ?></h3>
                    </div>
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/tel.svg" alt="">
                        <a href="tel:+8618154983097"><?php _e('+8618154983097', 'my-custom-theme'); ?></a>
                    </div>
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mail.svg" alt="">
                        <a href="mailto:info@horgos-autoexport.com"><?php _e('info@horgos-autoexport.com', 'my-custom-theme'); ?></a>
                    </div>
                </div>
                <div class="footer-item-three">
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer-loc.svg" alt="" class="opacity">
                        <h3><?php _e('Адрес', 'my-custom-theme'); ?></h3>
                    </div>
                    <div>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/footer-loc.svg" alt="">
                        <a href="#"><?php _e('Intersection of Lianhuo Expressway and S213, Khorgos City, Xinjiang, China', 'my-custom-theme'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php include get_template_directory() . '/templates-parts/modal.php'; ?>

<?php wp_footer(); ?>
</body>
</html>