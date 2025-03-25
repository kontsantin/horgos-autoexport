<?php
/* Template Name: About Page */
get_header(); // Подключаем шапку
?>

<main>
    <section class="about-hero">
        <div class="wrapper">
            <h1><?php echo esc_html(get_field('text_1')); ?></h1>
        </div>
    </section>
    <section class="export">
        <div class="wrapper">
            <div class="export_container">
                <div>
                    <h5><?php echo esc_html(get_field('text_2')); ?></h5>
                    <h2 class="h2"><?php echo esc_html(get_field('text_40')); ?></h2>
                    <p class="margin-about">
                        <?php echo esc_html(get_field('text_3')); ?>
                    </p>
                    <p>
                        <?php echo esc_html(get_field('text_4')); ?>
                    </p>
                </div>
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/about-1.jpg" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="about-services">
        <div class="wrapper">
            <div>
                <h2 class="h2">
                    <?php echo esc_html(get_field('text_5')); ?> <span class="h2-span"><?php echo esc_html(get_field('text_6')); ?></span>
                </h2>
                <div class="about-services-container">
                    <div class="about-services-item-border about-services-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mdi_car-search-outline.svg" alt="">
                        <p><?php echo esc_html(get_field('text_7')); ?></p>
                        <p><?php echo esc_html(get_field('text_8')); ?></p>
                        <p>
                            <?php echo esc_html(get_field('text_9')); ?>
                        </p>
                    </div>
                    <div class="about-services-item-border about-services-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bi_cash-coin.svg" alt="">
                        <p><?php echo esc_html(get_field('text_10')); ?></p>
                        <p><?php echo esc_html(get_field('text_11')); ?></p>
                        <p>
                            <?php echo esc_html(get_field('text_12')); ?>
                        </p>
                    </div>
                    <div class="about-services-item">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mingcute_truck-line.svg" alt="">
                        <p> <?php echo esc_html(get_field('text_13')); ?></p>
                        <p>
                            <?php echo esc_html(get_field('text_14')); ?>
                        </p>
                        <p>
                            <?php echo esc_html(get_field('text_15')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="advantages">
        <div class="wrapper">
            <h2 class="h2">
                <?php echo esc_html(get_field('text_16')); ?> <span class="h2-span"><?php echo esc_html(get_field('text_17')); ?></span>
            </h2>
            <div class="advantages-item">
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/advantages-bg-1.jpg" alt="">
                </div>
                <div class="advantages-item-right">
                    <h3><?php echo esc_html(get_field('text_18')); ?></h3>
                    <h4>
                        <?php echo esc_html(get_field('text_19')); ?>
                    </h4>
                    <p>
                        <?php echo esc_html(get_field('text_20')); ?>
                    </p>
                </div>
            </div>
            <div class="advantages-item">
                <div class="advantages-item-right">
                    <h3><?php echo esc_html(get_field('text_21')); ?></h3>
                    <p>
                        <?php echo esc_html(get_field('text_22')); ?>
                    </p>
                </div>
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/advantages-bg-2.jpg" alt="">
                </div>
            </div>
            <div class="advantages-item">
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/advantages-bg-3.jpg" alt="">
                </div>
                <div class="advantages-item-right">
                    <h3><?php echo esc_html(get_field('text_23')); ?></h3>
                    <p>
                        <?php echo esc_html(get_field('text_24')); ?>
                    </p>
                </div>
            </div>
            <div class="advantages-item">
                <div class="advantages-item-right">
                    <h3><?php echo esc_html(get_field('text_25')); ?></h3>
                    <h4>
                        <?php echo esc_html(get_field('text_26')); ?>
                    </h4>
                </div>
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/advantages-bg-4.jpg" alt="">
                </div>
            </div>
            <div class="advantages-item margin-advantages">
                <div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/advantages-bg-5.jpg" alt="">
                </div>
                <div class="advantages-item-right">
                    <h3><?php echo esc_html(get_field('text_27')); ?></h3>
                    <h4>
                        <?php echo esc_html(get_field('text_28')); ?>
                    </h4>
                    <p>
                        <?php echo esc_html(get_field('text_29')); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
   
<div class="about-form">
    <div class="wrapper">
        <h2 class="h2 form-margin-title"><?php echo esc_html(get_field('text_30')); ?></h2>
        <p class="about-form-description">
            <?php echo esc_html(get_field('text_31')); ?>
        </p>
        <div class="form-container">
            <form id="custom-form">
                <!-- Скрытое поле для определения действия -->
                <input type="hidden" name="action" value="submit_custom_form">

                <!-- Скрытое поле для передачи текущей страницы -->
                <input type="hidden" name="current_page" value="<?php echo esc_url(get_permalink()); ?>">

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
                    <?php echo esc_html(get_field('text_38')); ?>
                </h3>
                <a rel="noopener noreferrer" target="_blank" href="https://wa.me/8618154983097" class="flex">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ic_baseline-whatsapp.svg" alt="">
                    <span><?php echo esc_html(get_field('text_39')); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>

</main>

<?php
get_footer(); // Подключаем подвал
?>