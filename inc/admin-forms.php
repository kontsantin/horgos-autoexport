<?php
// Создаем таблицы при активации темы
// Создаем таблицы при активации темы
function create_feedback_tables() {
    global $wpdb;
    $table_name_feedback = $wpdb->prefix . 'feedback_form';
    $table_name_reviews = $wpdb->prefix . 'reviews_form';
    $table_name_new_form = $wpdb->prefix . 'new_form';
    // Добавляем столбец для времени создания, если он не существует
    $wpdb->query("ALTER TABLE $table_name_feedback ADD COLUMN IF NOT EXISTS created_at datetime DEFAULT CURRENT_TIMESTAMP;");
    $wpdb->query("ALTER TABLE $table_name_reviews ADD COLUMN IF NOT EXISTS created_at datetime DEFAULT CURRENT_TIMESTAMP;");

    $charset_collate = $wpdb->get_charset_collate();

    // Создание таблицы для заявок
    $sql_feedback = "CREATE TABLE $table_name_feedback (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        country varchar(255) NOT NULL,
        whatsapp varchar(255) NOT NULL,
        question text NOT NULL,       
        current_page varchar(255) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Создание таблицы для отзывов
    $sql_reviews = "CREATE TABLE $table_name_reviews (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        rating int(11) NOT NULL,
        review text NOT NULL,
        email varchar(255) NOT NULL,
        current_page varchar(255) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    )
     $charset_collate;";
        // Создание таблицы для новой формы
        $sql_new_form = "CREATE TABLE $table_name_new_form (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            message text NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_feedback);
    dbDelta($sql_reviews);
    dbDelta($sql_new_form);  // Создание таблицы для новой формы
}
// Создаем таблицы при активации темы
add_action('after_switch_theme', 'create_feedback_tables');



// Добавляем страницу настроек в админку
function add_feedback_settings_page() {
    add_menu_page(
        'Настройки заявок',
        'Настройки заявок',
        'manage_options',
        'feedback-settings',
        'feedback_settings_page',
        'dashicons-email',
        20
    );
    add_submenu_page(
        'feedback-settings',
        'Заявки',
        'Заявки',
        'manage_options',
        'feedback-requests',
        'feedback_requests_page'
    );
    add_submenu_page(
        'feedback-settings',
        'Отзывы',
        'Отзывы',
        'manage_options',
        'feedback-reviews',
        'feedback_reviews_page'
    );
    // Добавляем новый пункт меню для новой формы
    add_submenu_page(
        'feedback-settings',
        'Новая форма',
        'Новая форма',
        'manage_options',
        'feedback-new-form',
        'feedback_new_form_page' // Функция для отображения данных новой формы
    );
}
add_action('admin_menu', 'add_feedback_settings_page');
add_action('admin_menu', 'add_feedback_settings_page');

// Страница настроек
function feedback_settings_page() {
    ?>
    <div class="wrap">
        <h1>Настройки почты для заявок</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('feedback_settings_group');
            do_settings_sections('feedback-settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="feedback_form_email">Email получателя для заявок</label></th>
                    <td><input type="email" name="feedback_form_email" id="feedback_form_email" value="<?php echo esc_attr(get_option('feedback_form_email')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="review_form_email">Email получателя для отзывов</label></th>
                    <td><input type="email" name="review_form_email" id="review_form_email" value="<?php echo esc_attr(get_option('review_form_email')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Регистрация настроек
function register_feedback_settings() {
    register_setting('feedback_settings_group', 'feedback_form_email');
    register_setting('feedback_settings_group', 'review_form_email');
}
add_action('admin_init', 'register_feedback_settings');

// Страница заявок
function feedback_requests_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'feedback_form';

    // Фильтрация по языку и датам
    $language_filter = isset($_GET['language']) ? sanitize_text_field($_GET['language']) : '';
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    $query = "SELECT * FROM $table_name WHERE 1=1";
    if ($language_filter) {
        $query .= $language_filter === 'eng' ? " AND current_page LIKE '%/en%'" : " AND current_page NOT LIKE '%/en%'";
    }
    if ($start_date) {
        $query .= " AND created_at >= '$start_date'";
    }
    if ($end_date) {
        $query .= " AND created_at <= '$end_date'";
    }
    $results = $wpdb->get_results($query);

    ?>
    <div class="wrap">
        <h1>Заявки</h1>
        <form method="get">
            <input type="hidden" name="page" value="feedback-requests">
            <select name="language" onchange="this.form.submit()">
                <option value="">Все языки</option>
                <option value="eng" <?php selected($language_filter, 'eng'); ?>>Английский</option>
                <option value="rus" <?php selected($language_filter, 'rus'); ?>>Русский</option>
            </select>
            <input type="date" name="start_date" value="<?php echo esc_attr($start_date); ?>" onchange="this.form.submit()">
            <input type="date" name="end_date" value="<?php echo esc_attr($end_date); ?>" onchange="this.form.submit()">
        </form>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Страна</th>
                    <th>Whatsapp</th>
                    <th>Вопрос</th>
                    <th>Страница</th>                
                    <th>Язык</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo $row->id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->country; ?></td>
                        <td><?php echo $row->whatsapp; ?></td>
                        <td><?php echo $row->question; ?></td>
                        <td><?php echo $row->current_page; ?></td>                       
                        <td><?php echo strpos($row->current_page, '/en') !== false ? 'eng' : 'rus'; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                        <td>
                            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                                <input type="hidden" name="action" value="delete_feedback_request">
                                <input type="hidden" name="request_id" value="<?php echo $row->id; ?>">
                                <?php submit_button('Удалить', 'delete', 'submit', false); ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="clear_feedback_requests">
            <?php submit_button('Очистить все заявки'); ?>
        </form>
    </div>
    <?php
}

// Обработчик удаления заявки
function delete_feedback_request() {
    if (isset($_POST['action']) && $_POST['action'] === 'delete_feedback_request' && isset($_POST['request_id'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_form';
        $request_id = intval($_POST['request_id']);
        $wpdb->delete($table_name, ['id' => $request_id], ['%d']);
        wp_redirect(admin_url('admin.php?page=feedback-requests'));
        exit;
    }
}
add_action('admin_post_delete_feedback_request', 'delete_feedback_request');

// Обработчик очистки заявок
function clear_feedback_requests() {
    if (isset($_POST['action']) && $_POST['action'] === 'clear_feedback_requests') {
        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_form';
        $wpdb->query("TRUNCATE TABLE $table_name");
        wp_redirect(admin_url('admin.php?page=feedback-requests'));
        exit;
    }
}
add_action('admin_post_clear_feedback_requests', 'clear_feedback_requests');

// Страница отзывов
function feedback_reviews_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'reviews_form';

    // Фильтрация по языку и датам
    $language_filter = isset($_GET['language']) ? sanitize_text_field($_GET['language']) : '';
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    $query = "SELECT * FROM $table_name WHERE 1=1";
    if ($language_filter) {
        $query .= $language_filter === 'eng' ? " AND current_page LIKE '%/en%'" : " AND current_page NOT LIKE '%/en%'";
    }
    if ($start_date) {
        $query .= " AND created_at >= '$start_date'";
    }
    if ($end_date) {
        $query .= " AND created_at <= '$end_date'";
    }
    $results = $wpdb->get_results($query);

    ?>
    <div class="wrap">
        <h1>Отзывы</h1>
        <form method="get">
            <input type="hidden" name="page" value="feedback-reviews">
            <select name="language" onchange="this.form.submit()">
                <option value="">Все языки</option>
                <option value="eng" <?php selected($language_filter, 'eng'); ?>>Английский</option>
                <option value="rus" <?php selected($language_filter, 'rus'); ?>>Русский</option>
            </select>
            <input type="date" name="start_date" value="<?php echo esc_attr($start_date); ?>" onchange="this.form.submit()">
            <input type="date" name="end_date" value="<?php echo esc_attr($end_date); ?>" onchange="this.form.submit()">
        </form>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Рейтинг</th>
                    <th>Отзыв</th>
                    <th>Email</th>
                    <th>Страница</th>
                    <th>Язык</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo $row->id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->rating; ?></td>
                        <td><?php echo $row->review; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->current_page; ?></td>
                        <td><?php echo strpos($row->current_page, '/en') !== false ? 'eng' : 'rus'; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                        <td>
                            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                                <input type="hidden" name="action" value="delete_feedback_review">
                                <input type="hidden" name="review_id" value="<?php echo $row->id; ?>">
                                <?php submit_button('Удалить', 'delete', 'submit', false); ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="clear_feedback_reviews">
            <?php submit_button('Очистить все отзывы'); ?>
        </form>
    </div>
    <?php
}

// Обработчик удаления отзыва
function delete_feedback_review() {
    if (isset($_POST['action']) && $_POST['action'] === 'delete_feedback_review' && isset($_POST['review_id'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'reviews_form';
        $review_id = intval($_POST['review_id']);
        $wpdb->delete($table_name, ['id' => $review_id], ['%d']);
        wp_redirect(admin_url('admin.php?page=feedback-reviews'));
        exit;
    }
}
add_action('admin_post_delete_feedback_review', 'delete_feedback_review');

// Обработчик очистки отзывов
function clear_feedback_reviews() {
    if (isset($_POST['action']) && $_POST['action'] === 'clear_feedback_reviews') {
        global $wpdb;
        $table_name = $wpdb->prefix . 'reviews_form';
        $wpdb->query("TRUNCATE TABLE $table_name");
        wp_redirect(admin_url('admin.php?page=feedback-reviews'));
        exit;
    }
}
add_action('admin_post_clear_feedback_reviews', 'clear_feedback_reviews');

// Страница новой формы
function feedback_new_form_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'new_form';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    ?>
    <div class="wrap">
        <h1>Новая форма</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Сообщение</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo $row->id; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->message; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

