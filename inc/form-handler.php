<?php
// Обработчик для формы вопроса
function submit_feedback_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'feedback_form';

    // Проверяем nonce для безопасности
    if (!isset($_POST['feedback_form_nonce_field']) || !wp_verify_nonce($_POST['feedback_form_nonce_field'], 'submit_feedback_form_action')) {
        echo json_encode(array('status' => 'error', 'message' => 'Ошибка проверки nonce'));
        wp_die();
    }

    // Очищаем и валидируем данные
    $name = sanitize_text_field($_POST['name']);
    $country = sanitize_text_field($_POST['country']);
    $whatsapp = sanitize_text_field($_POST['whatsapp']);
    $question = sanitize_textarea_field($_POST['question']);    
    $current_page = esc_url_raw($_POST['current_page']);

    // Добавляем запись в базу данных
    $result = $wpdb->insert(
        $table_name,
        [
            'name'         => $name,
            'country'      => $country,
            'whatsapp'     => $whatsapp,
            'question'     => $question,           
            'current_page' => $current_page,
        ],
        ['%s', '%s', '%s', '%s', '%s', '%s']
    );

    if ($result === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Ошибка при сохранении данных в базу данных'));
    } else {
        echo json_encode(array('status' => 'success'));
    }

    wp_die();
}
add_action('wp_ajax_submit_feedback_form', 'submit_feedback_form');
add_action('wp_ajax_nopriv_submit_feedback_form', 'submit_feedback_form');

// Обработчик для формы отзыва
function submit_review_form() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'reviews_form';

    // Проверяем nonce для безопасности
    if (!isset($_POST['review_form_nonce_field']) || !wp_verify_nonce($_POST['review_form_nonce_field'], 'submit_review_form_action')) {
        echo json_encode(array('status' => 'error', 'message' => 'Ошибка проверки nonce'));
        wp_die();
    }

    // Очищаем и валидируем данные
    $name = sanitize_text_field($_POST['name']);
    $rating = intval($_POST['rating']);
    $review = sanitize_textarea_field($_POST['review']);
    $email = sanitize_email($_POST['email']);
    $current_page = esc_url_raw($_POST['current_page']);

    // Добавляем запись в базу данных
    $result = $wpdb->insert(
        $table_name,
        [
            'name'         => $name,
            'rating'       => $rating,
            'review'       => $review,
            'email'        => $email,
            'current_page' => $current_page,
        ],
        ['%s', '%d', '%s', '%s', '%s']
    );

    if ($result === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Ошибка при сохранении данных в базу данных'));
    } else {
        echo json_encode(array('status' => 'success'));
    }

    wp_die();
}
add_action('wp_ajax_submit_review_form', 'submit_review_form');
add_action('wp_ajax_nopriv_submit_review_form', 'submit_review_form');




function handle_custom_form_submission() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_custom_form') {
        // Санитизация данных
        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $whatsapp = sanitize_text_field($_POST['whatsapp'] ?? '');
        $country = sanitize_text_field($_POST['country'] ?? '');
        $question = sanitize_textarea_field($_POST['question'] ?? '');
        $current_page = esc_url_raw($_POST['current_page'] ?? '');

        // Создание нового поста с данными формы
        $post_id = wp_insert_post([
            'post_type' => 'custom_form_request',  // Ваш кастомный тип записи
            'post_title' => "Заявка от $name",
            'post_content' => $question,
            'post_status' => 'publish',
        ]);

        if ($post_id) {
            // Сохранение дополнительных мета-данных
            update_post_meta($post_id, 'email', $email);
            update_post_meta($post_id, 'whatsapp', $whatsapp);
            update_post_meta($post_id, 'country', $country);
            update_post_meta($post_id, 'current_page', $current_page);
        }

        // Возврат успешного ответа в формате JSON
        echo json_encode([
            'status' => 'success',
            'message' => 'Спасибо за вашу заявку, мы с вами свяжемся!',
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ошибка при отправке формы',
        ]);
    }

    wp_die();  // Останавливает дальнейшую обработку
}
add_action('wp_ajax_submit_custom_form', 'handle_custom_form_submission');
add_action('wp_ajax_nopriv_submit_custom_form', 'handle_custom_form_submission');  // Для неавторизованных пользователей
