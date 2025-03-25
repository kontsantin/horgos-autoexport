document.addEventListener('DOMContentLoaded', () => {
    const burgerIcon = document.getElementById('burger-icon');
    const menuContent = document.getElementById('menu-content');
    const body = document.body;

    // Открытие/закрытие меню
    if (burgerIcon && menuContent) {
        burgerIcon.addEventListener('click', () => {
            const isMenuOpen = menuContent.classList.contains('open');

            if (isMenuOpen) {
                menuContent.classList.remove('open'); // Закрываем меню
                body.classList.remove('no-scroll'); // Включаем прокрутку
            } else {
                menuContent.classList.add('open'); // Открываем меню
                body.classList.add('no-scroll'); // Отключаем прокрутку
            }
        });

        // Закрытие меню при клике вне области меню
        document.addEventListener('click', (event) => {
            if (!burgerIcon.contains(event.target) && !menuContent.contains(event.target)) {
                menuContent.classList.remove('open'); // Закрываем меню
                body.classList.remove('no-scroll'); // Включаем прокрутку
            }
        });
    }
});



// Скроллинг и хедер
const header = document.getElementById('site-header');
if (header) {
    let lastScrollTop = 0;

    window.addEventListener('scroll', () => {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            header.style.transform = 'translateY(-100%)'; // Скроллим вниз – скрываем хедер
        } else {
            header.style.transform = 'translateY(0)'; // Скроллим вверх – показываем хедер
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
}

// Обновление отступа main
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header');
    const main = document.querySelector('main');

    if (header && main) {
        function updateMainPadding() {
            main.style.paddingTop = header.offsetHeight + 'px';
        }

        // Устанавливаем начальный отступ
        updateMainPadding();

        // Обновляем отступ при изменении размера окна
        window.addEventListener('resize', updateMainPadding);
    }
});