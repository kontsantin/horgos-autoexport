<?php
/* Template Name: FAQ Page */
get_header(); // Подключаем шапку
?>

<main>
    <section class="faq-hero" style="background: url('<?php echo get_template_directory_uri(); ?>/assets/img/faq-hero.jpg') no-repeat center center; background-size: cover;">
        <div class="wrapper">
            <h1><?php the_title(); ?></h1>
            <h3><?php echo esc_html(get_field('block_1')); ?></h3>
        </div>
    </section>
    <section class="faq">
        <div class="wrapper">
            <div class="faq_container">
                <div class="accordion">
                    <?php
                    // Проверяем, есть ли повторяющиеся поля FAQ
                    if (function_exists('have_rows') && have_rows('faq_items')) : 
                        while (have_rows('faq_items')) : the_row();
                            $question = get_sub_field('question'); // Вопрос
                            $answer = get_sub_field('answer'); // Ответ
                    ?>
                        <div class="accordion-item">
                            <button class="accordion-header">
                                <span><?php echo esc_html($question); ?></span>
                                <span class="icon">+</span>
                            </button>
                            <div class="accordion-content">
                                <!--<p><?php /*echo esc_html($answer); */?></p>-->
                                <div><?php echo apply_filters('the_content', $answer); ?></div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    else :
                        echo '<p>Вопросы пока не добавлены.</p>';
                    endif;
                    ?>
                </div>
                <div class="right-bar">
                    <div>
                        <h3><?php echo esc_html(get_field('block_2')); ?></h3>
                    </div>
                    <button class="open-question-form" id="popup-btn"><?php echo esc_html(get_field('block_3')); ?></button>
                </div>
            </div>
        </div>
    </section>
     <!-- Всплывающее окно -->
     <div id="popup" class="popup">
        <div class="popup-content">
        
          <form id="popup-form">
    <!-- Поле для имени -->
    <input
        type="text"
        id="name"
        placeholder="<?php echo __('Ваше имя', 'my-custom-theme'); ?>"
        required
        pattern="^[А-Яа-яЁёA-Za-z ]+$"
        title="<?php echo __('Имя должно содержать только буквы', 'my-custom-theme'); ?>"
    />
    
    <!-- Поле для страны/города -->
    <input
        type="text"
        id="city"
        placeholder="<?php echo __('Страна/Город', 'my-custom-theme'); ?>"
        required
        pattern="^[А-Яа-яЁёA-Za-z ]+$"
        title="<?php echo __('Название города или страны должно содержать только буквы', 'my-custom-theme'); ?>"
    />
    
    <!-- Поле для телефона -->
    <input
        type="tel"
        id="phone"
        placeholder="<?php echo __('Номер Whatsapp', 'my-custom-theme'); ?>"
        required
    />
    
    <!-- Поле для вопроса -->
  <textarea placeholder="<?php echo __('Ваш вопрос', 'my-custom-theme'); ?>"></textarea>
    
    <!-- Кнопка отправки -->
    <button type="submit"><?php echo __('Запросить цену', 'my-custom-theme'); ?></button>
</form>
            <!-- Сообщение об успешной отправке -->
            <div id="success-message" style="display: none; margin-top: 20px;">
                <p>Ваш запрос принят!</p>
                <button id="success-ok-btn">OK</button>
            </div>
        </div>
        <span class="close" id="close-btn">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/close.svg" alt="">
        </span>
    </div>
</main>

<?php
get_footer(); // Подключаем подвал
?>