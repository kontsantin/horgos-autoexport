<?php
/* 
 * Template Name: Политика конфиденциальности
 * Description: Шаблон для страницы политики конфиденциальности, редактируемой через редактор Gutenberg.
 */

get_header(); ?>

<main id="site-content" role="main">
    <section class="privacy-policy-section">
        <div class="wrapper">
            <div class="privacy-policy-container">
                <?php
                // Основной контент страницы
                while (have_posts()) :
                    the_post();
                    ?>
                    <h1 class="privacy-policy-title"><?php the_title(); ?></h1>
                    <div class="privacy-policy-content">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>