console.log('Hello')
document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('universal-popup');
    const popupBody = document.getElementById('popup-body');
    const successMessage = document.getElementById('success-message');
    const successOkBtn = document.getElementById('success-ok-btn');
    const closeBtn = document.getElementById('close-btn');

    const openQuestionFormBtn = document.querySelector('.open-question-form');
    const openReviewFormBtn = document.querySelector('.open-review-form');
    const questionFormTemplate = document.getElementById('question-form-template');
    const reviewFormTemplate = document.getElementById('review-form-template');

    const openPopup = (template, carName) => {
        popupBody.innerHTML = template.innerHTML;
        if (carName) {
            let carNameModal = document.createElement('h2');
            carNameModal.textContent = carName.textContent;
            carNameModal.classList.add('car-name-modal');
            popupBody.prepend(carNameModal);
            let carNameValue = carName.textContent.trim().replace(/\s+/g, '');
            const carNameInput = popupBody.querySelector('input[name="car_name"]');
            if (carNameInput) carNameInput.value = carNameValue;
        }
        popup.style.display = 'flex';
        setupFormSubmit(popupBody.querySelector('form'));
    };

    if (openQuestionFormBtn) {
        openQuestionFormBtn.addEventListener('click', () => {
            const carName = document.querySelector('.product-info-title');
            openPopup(questionFormTemplate, carName);
        });
    }

    if (openReviewFormBtn) {
        openReviewFormBtn.addEventListener('click', () => {
            const carName = document.querySelector('.product-info-title');
            openPopup(reviewFormTemplate, carName);
        });
    }

    const closePopup = () => {
        popup.style.display = 'none';
        popupBody.innerHTML = '';
    };

    if (closeBtn) closeBtn.addEventListener('click', closePopup);

    window.addEventListener('click', (event) => {
        if (event.target === popup) closePopup();
    });

    if (successOkBtn) {
        successOkBtn.addEventListener('click', () => {
            successMessage.style.display = 'none';
            closePopup();
        });
    }

    function setupFormSubmit(form) {
        if (!form) return;
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const url = ajax_object.ajax_url;
            const formData = new FormData(form);
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                console.log('Ответ сервера:', text);
                try {
                    const data = JSON.parse(text);
                    if (data.status === 'success') {
                        form.style.display = 'none';
                        const carNameModal = popupBody.querySelector('.car-name-modal');
                        if (carNameModal) carNameModal.remove();
                        successMessage.style.display = 'block';
                    } else {
                        alert(data.message || 'Ошибка при отправке формы');
                    }
                } catch (e) {
                    console.error('Ошибка при парсинге JSON:', e);
                    console.error('Ответ сервера (текст):', text);
                }
            })
            .catch(error => console.error('Ошибка при выполнении запроса:', error));
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('custom-form');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Собираем данные формы
            const formData = new FormData(form);
            formData.append('action', 'submit_custom_form');

            fetch(ajax_object.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.data);
                    form.reset();
                } else {
                    alert(data.data || 'Ошибка при отправке формы');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при отправке формы');
            });
        });
    }
});