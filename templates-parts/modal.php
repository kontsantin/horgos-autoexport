
<!-- Универсальный попап -->
<div id="universal-popup" class="popup">
    <div class="popup-content">
        <!-- Контент будет подставляться сюда -->
        <div id="popup-body"></div>

        <!-- Сообщение об успехе -->
        <div id="success-message" style="display: none; margin-top: 20px;">
            <p>Ваш запрос принят!</p>
            <button id="success-ok-btn">OK</button>
        </div>
    </div>
    <span class="close" id="close-btn">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/close.svg" alt="Закрыть">
    </span>
</div>

<!-- Форма вопроса (скрытая, для подстановки в попап) -->
<div id="question-form-template" style="display: none;">
    <form id="question-form" method="POST">
        <input type="hidden" name="car_name" value="">
        <input type="hidden" name="action" value="submit_feedback_form">
        <input type="hidden" name="current_page" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

        <input type="text" name="name" placeholder="<?php echo __('Ваше имя', 'my-custom-theme'); ?>" required pattern="^[А-Яа-яЁёA-Za-z ]+$" title="<?php echo __('Имя должно содержать только буквы', 'my-custom-theme'); ?>" />
        <input type="text" name="country" placeholder="<?php echo __('Страна/Город', 'my-custom-theme'); ?>" required pattern="^[А-Яа-яЁёA-Za-z ]+$" title="<?php echo __('Название города или страны должно содержать только буквы', 'my-custom-theme'); ?>" />
        <input type="tel" name="whatsapp" placeholder="<?php echo __('Номер Whatsapp', 'my-custom-theme'); ?>" required />
        <textarea name="question" placeholder="<?php echo __('Ваш вопрос', 'my-custom-theme'); ?>"></textarea>
        <?php wp_nonce_field('submit_feedback_form_action', 'feedback_form_nonce_field'); ?>
        <button type="submit"><?php echo __('Задать вопрос', 'my-custom-theme'); ?></button>
    </form>
</div>

<!-- Форма отзыва (скрытая, для подстановки в попап) -->
<div id="review-form-template" style="display: none;">
    <form id="review-form" method="POST">
        <input type="hidden" name="action" value="submit_review_form">
        <input type="hidden" name="current_page" value="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

        <input type="text" name="name" placeholder="<?php echo __('Ваше имя', 'my-custom-theme'); ?>" required pattern="^[А-Яа-яЁёA-Za-z ]+$" title="<?php echo __('Имя должно содержать только буквы', 'my-custom-theme'); ?>" />
        <input type="number" name="rating" placeholder="<?php echo __('Оценка (1-5)', 'my-custom-theme'); ?>" min="1" max="5" required title="<?php echo __('Оценка должна быть от 1 до 5', 'my-custom-theme'); ?>" />
        <textarea name="review" placeholder="<?php echo __('Ваш отзыв', 'my-custom-theme'); ?>" required rows="4"></textarea>
        <input type="email" name="email" placeholder="<?php echo __('Ваш Email', 'my-custom-theme'); ?>" required title="<?php echo __('Введите корректный Email', 'my-custom-theme'); ?>" />
        <?php wp_nonce_field('submit_review_form_action', 'review_form_nonce_field'); ?>
        <button type="submit"><?php echo __('Отправить отзыв', 'my-custom-theme'); ?></button>
    </form>
</div>