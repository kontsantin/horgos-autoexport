// jQuery(document).ready(function($) {
//     $('#filter-form').on('submit', function(e) {
//         e.preventDefault(); // Отменяем стандартное действие формы

//         // Собираем данные формы
//         let formData = $(this).serialize();

//         // Отправляем AJAX-запрос
//         $.ajax({
//             url: ajaxfilter.ajax_url, // URL обработчика (admin-ajax.php)
//             type: 'POST',
//             data: {
//                 action: 'filter_catalog', // Имя AJAX действия
//                 form_data: formData // Передаем данные формы
//             },
//             success: function(response) {
//                 $('#catalog-list').html(response); // Обновляем список записей
//             },
//             error: function() {
//                 alert('Произошла ошибка при фильтрации. Попробуйте еще раз.');
//             }
//         });
//     });
// });







jQuery(document).ready(function($) {
    // Обработчик для всех форм фильтров
    $('#filter-form, #filter-form-popup').on('submit', function(e) {
        e.preventDefault(); // Отменяем стандартное действие формы

        // Собираем данные формы
        let formData = $(this).serialize();

        // Отправляем AJAX-запрос
        $.ajax({
            url: ajaxfilter.ajax_url, // URL обработчика (admin-ajax.php)
            type: 'POST',
            data: {
                action: 'filter_catalog', // Имя AJAX действия
                form_data: formData // Передаем данные формы
            },
            success: function(response) {
                $('#catalog-list').html(response); // Обновляем список записей
                $('#custom-popup').hide(); // Закрываем попап после фильтрации (по желанию)
            },
            error: function() {
                alert('Произошла ошибка при фильтрации. Попробуйте еще раз.');
            }
        });
    });
});