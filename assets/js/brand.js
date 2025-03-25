//слайдер

document.addEventListener('DOMContentLoaded', () => {
    const logoSwiper = new Swiper('.logo-swiper', {
        slidesPerView: 8,
        grid: {
            rows: 2,
            fill: 'row',
        },
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            1000: {
                slidesPerView: 8,
                grid: {
                    rows: 2,
                },
                spaceBetween: 15,
            },
            600: {
                slidesPerView: 5,
                grid: {
                    rows: 2,
                },
                spaceBetween: 15,
            },
            0: {
                slidesPerView: 3,
                grid: {
                    rows: 3,
                },
                spaceBetween: 10,
            },
        },
    });

    console.log('Swiper initialized successfully!');
});


document.addEventListener('DOMContentLoaded', () => {
    const logoSwiper = new Swiper('.logo-swiper-two', {
        slidesPerView: 8,
        grid: {
            rows: 2,
            fill: 'row',
        },
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1000: {
                slidesPerView: 8,
                grid: {
                    rows: 2,
                },
                spaceBetween: 15,
            },
            600: {
                slidesPerView: 5,
                grid: {
                    rows: 2,
                },
                spaceBetween: 15,
            },
            0: {
                slidesPerView: 3,
                grid: {
                    rows: 3,
                },
                spaceBetween: 10,
            },
        },
    });

    console.log('Swiper initialized successfully!');
});



document.addEventListener('DOMContentLoaded', function () {
    // Находим элементы
    const openFilterButton = document.getElementById('open-filter');
    const popup = document.getElementById('popup');

    // Проверяем, есть ли элементы на странице
    if (openFilterButton && popup) {
        // Открываем popup
        openFilterButton.addEventListener('click', function () {
            popup.style.display = 'block';
        });

        // Закрываем popup при клике вне окна
        document.addEventListener('click', function (event) {
            if (!popup.contains(event.target) && event.target !== openFilterButton) {
                popup.style.display = 'none';
            }
        });

        // Закрываем popup при нажатии клавиши Escape
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                popup.style.display = 'none';
            }
        });
    }
    // Если элементов нет, ничего не делаем
});










// Открытие попапа
const openPopupButton = document.getElementById('open-popup-two');
if (openPopupButton) {
    openPopupButton.addEventListener('click', function () {
        const customPopup = document.getElementById('custom-popup');
        if (customPopup) {
            customPopup.style.display = 'flex';
        }
    });
}

// Закрытие попапа
const closePopupButton = document.getElementById('close-custom-popup');
if (closePopupButton) {
    closePopupButton.addEventListener('click', function () {
        const customPopup = document.getElementById('custom-popup');
        if (customPopup) {
            customPopup.style.display = 'none';
        }
    });
}

// Закрытие при клике вне области попапа
const customPopup = document.getElementById('custom-popup');
if (customPopup) {
    customPopup.addEventListener('click', function (e) {
        if (e.target === customPopup) {
            customPopup.style.display = 'none';
        }
    });
}







document.addEventListener('DOMContentLoaded', () => {
    function setupEnergyFilter(mainCheckboxId, optionCheckboxesClass) {
        const allEnergyCheckbox = document.getElementById(mainCheckboxId);
        
        // Проверка: если главный чекбокс не найден — завершаем функцию
        if (!allEnergyCheckbox) return;

        const energyOptions = document.querySelectorAll(`.${optionCheckboxesClass}`);

        // Снимает все остальные чекбоксы
        function uncheckAllOtherOptions() {
            energyOptions.forEach(option => option.checked = false);
        }

        // Если нет выбранных чекбоксов, активировать главный чекбокс
        function checkIfAllDeselected() {
            const anyChecked = Array.from(energyOptions).some(option => option.checked);
            if (!anyChecked) allEnergyCheckbox.checked = true;
        }

        // Обработчик для главного чекбокса
        allEnergyCheckbox.addEventListener('change', () => {
            if (allEnergyCheckbox.checked) uncheckAllOtherOptions();
        });

        // Обработчик для остальных чекбоксов
        energyOptions.forEach(option => {
            option.addEventListener('change', () => {
                if (option.checked) allEnergyCheckbox.checked = false;
                checkIfAllDeselected();
            });
        });
    }

    // Вызов функции для нескольких групп чекбоксов
    setupEnergyFilter('all-energy', 'energy-option');
    setupEnergyFilter('all-energy-two', 'energy-option');
    setupEnergyFilter('all-energy-three', 'energy-option');
    setupEnergyFilter('all-energy-four', 'energy-option');
});