<?php get_header(); ?>

<main class="page-404">
    <section class="error-404">
        <h1><?php _e('Ошибка 404', 'my-custom-theme'); ?></h1>
        <p><?php _e('К сожалению, страница, которую вы ищете, не найдена.', 'my-custom-theme'); ?></p>
        <a href="<?php echo home_url(); ?>" class="button">
            <?php _e('Вернуться на главную', 'my-custom-theme'); ?>
        </a>
    </section>
</main>

<?php get_footer(); ?>