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




// Обработчик для новой формы
function handle_custom_form_submission() {
    global $wpdb;
    
    // Проверяем nonce
    if (!isset($_POST['custom_form_nonce']) || !wp_verify_nonce($_POST['custom_form_nonce'], 'custom_form_action')) {
        wp_send_json_error('Ошибка безопасности');
        return;
    }
    
    $table_name = $wpdb->prefix . 'new_form';
    
    // Проверяем существование таблицы
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // Логируем ошибку
        error_log("Table $table_name doesn't exist");
        wp_send_json_error('Системная ошибка. Пожалуйста, попробуйте позже.');
        return;
    }
    
    // Очищаем и валидируем данные
    $data = [
        'name' => sanitize_text_field($_POST['name'] ?? ''),
        'email' => sanitize_email($_POST['email'] ?? ''),
        'whatsapp' => sanitize_text_field($_POST['whatsapp'] ?? ''),
        'country' => sanitize_text_field($_POST['country'] ?? ''),
        'question' => sanitize_textarea_field($_POST['question'] ?? ''),
        'current_page' => esc_url_raw($_POST['current_page'] ?? '')
    ];
    
    // Проверка обязательных полей
    if (empty($data['name'])) {
        wp_send_json_error('Пожалуйста, укажите ваше имя');
        return;
    }
    
    // Добавляем запись в базу данных
    $result = $wpdb->insert(
        $table_name,
        $data,
        ['%s', '%s', '%s', '%s', '%s', '%s']
    );
    
    if ($result === false) {
        error_log('DB Error: ' . $wpdb->last_error);
        wp_send_json_error('Ошибка при сохранении данных');
    } else {
        wp_send_json_success('Спасибо за вашу заявку! Мы свяжемся с вами в ближайшее время.');
    }
}
add_action('wp_ajax_submit_custom_form', 'handle_custom_form_submission');
add_action('wp_ajax_nopriv_submit_custom_form', 'handle_custom_form_submission');