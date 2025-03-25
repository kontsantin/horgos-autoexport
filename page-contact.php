<?php
/* Template Name: Contact Page */
get_header(); // Подключаем шапку
?>

<main>
    <section class="contact-hero">
        <div class="wrapper">
            <h1 class="contact-hero-title"><?php the_title(); ?></h1>
        </div>
    </section>
    <section class="contacts">
        <div class="wrapper">
            <h2 class="h2"><?php echo esc_html(get_field('text_1')); ?></h2>
            <div class="contacts-grid">
                <div class="contacts-grid-item">
                    <p><?php echo esc_html(get_field('text_2')); ?></p>
                    <div>
                        <a href="tel:+8618154983097">+8618154983097</a>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/b-tel.svg" alt="">
                    </div>
                </div>
                <div class="contacts-grid-item">
                    <p><?php echo esc_html(get_field('text_3')); ?></p>
                    <div>
                        <a href="https://t.me/horgosautoexport" target="_blank">
                            https://t.me/ <br class="desktop-only"> horgosautoexport
                        </a>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/b-tg.svg" alt="">
                    </div>
                </div>
                <div class="contacts-grid-item">
                    <p><?php echo esc_html(get_field('text_4')); ?></p>
                    <div>
                        <a href="mailto:info@horgos-autoexport.com">info@horgos-autoexport.com</a>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/b-mail.svg" alt="">
                    </div>
                </div>
                <div class="contacts-grid-item">
                    <p><?php echo esc_html(get_field('text_5')); ?></p>
                    <div>
                        <a href="#"><?php echo esc_html(get_field('text_6')); ?></a>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/b-geo.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="about-form">
        <div class="wrapper">
        <h2 class="h2 form-margin-title"><?php echo esc_html(get_field('text_7')); ?></h2>
        <p class="about-form-description">
            <?php echo esc_html(get_field('text_8')); ?>
        </p>
        <div class="form-container">
           <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
    <!-- Скрытое поле для определения действия -->
    <input type="hidden" name="action" value="submit_custom_form">

    <!-- Скрытое поле для передачи текущей страницы -->
    <input type="hidden" name="current_page" value="<?php echo esc_url( get_permalink() ); ?>">

    <div class="form-grid">
        <div>
            <input type="text" id="name" name="name" placeholder="<?php echo __('Имя', 'my-custom-theme'); ?>">
        </div>
        <div>
            <input type="email" id="email" name="email" placeholder="<?php echo __('Email', 'my-custom-theme'); ?>">
        </div>
        <div>
            <input type="text" id="whatsapp" name="whatsapp" placeholder="<?php echo __('Whatsapp', 'my-custom-theme'); ?>">
        </div>
        <div>
            <input type="text" id="country" name="country" placeholder="<?php echo __('Страна', 'my-custom-theme'); ?>">
        </div>
        <div>
            <textarea id="question" name="question" placeholder="<?php echo __('Задайте вопрос по модели или комплектации.', 'my-custom-theme'); ?>"></textarea>
        </div>
    </div>
    <div>
      <button type="submit" class="btn-submit-about flex">
        <img src="/img/line-md_telegram.svg" alt="">
        <span><?php echo __('Отправить', 'my-custom-theme'); ?></span>
      </button>
    </div>
</form>
            <div class="form-right-continer">
                <h3>
                   <?php echo esc_html(get_field('text_9')); ?>
                </h3>
                <a rel="noopener noreferrer" target="_blank" href="https://wa.me/8618154983097" class="flex">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ic_baseline-whatsapp.svg" alt="">
                    <span><?php echo esc_html(get_field('text_10')); ?></span>
                </a>
            </div>
        </div>
    </div>
    </div>
    <div class="map">
        <div class="wrapper">
            <div class="map-container">
           <iframe
    src="https://www.google.com/maps?q=44.171650,80.473027&hl=en&output=embed"
    width="100%"
    height="500"
    style="border:0;"
    allowfullscreen
    loading="lazy">
</iframe>
            </div>
        </div>
    </div>
</main>

<?php
get_footer(); // Подключаем подвал
?>