<?php
/*
Template Name: Thank You
*/
get_header(); ?>

<main class="thank-you-page">
    <section class="thank-you-message">
        <h1><?php _e('Спасибо за Ваше обращение!', 'my-custom-theme'); ?></h1>
        <p><?php _e('Мы свяжемся с вами в ближайшее время.', 'my-custom-theme'); ?></p>
        <a href="<?php echo home_url(); ?>" class="button">
            <?php _e('Вернуться на главную', 'my-custom-theme'); ?>
        </a>
    </section>
</main>

<?php get_footer(); ?>