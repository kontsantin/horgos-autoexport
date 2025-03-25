document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper-container', {        
        slidesPerView: 2, // Количество слайдов на экране по умолчанию
        spaceBetween: 10, // Расстояние между слайдами
        navigation: {
            nextEl: '.swiper-next', // Кнопка "Вперёд"
            prevEl: '.swiper-prev', // Кнопка "Назад"
        },
        // autoplay: {
        //     delay: 3000, // Автопрокрутка каждые 3 секунды
        //     disableOnInteraction: false, // Продолжать прокрутку после взаимодействия
        // },
        // Брейкпоинты для разных устройств
        breakpoints: {
            // Экран <= 1024px
            1024: {
                slidesPerView: 3, // Показывать 2 слайда
                spaceBetween: 10,
            },
            // Экран <= 480px (мобильные устройства)
            480: {
                slidesPerView: 2, // Показывать 1 слайд
                spaceBetween: 5,
            },
            320: {
              slidesPerView: 1, // Показывать 1 слайд
              spaceBetween: 5,
          },
        },
    });
});




document.addEventListener('DOMContentLoaded', () => {
  const productsContainer = document.getElementById('news');
  const paginationContainer = document.getElementById('pagination');
  let totalPages = 1;

  // Функция загрузки страницы через AJAX
  async function loadPage(page) {
    try {
      const formData = new FormData();
      formData.append('action', 'load_news'); // Действие (обязательно)
      formData.append('page', page); // Номер страницы (обязательно)

      const response = await fetch(ajaxurl, {
        method: 'POST',
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`Ошибка ${response.status}: ${response.statusText}`);
      }

      const result = await response.text();
      const parser = new DOMParser();
      const doc = parser.parseFromString(result, 'text/html');

      // Обновляем содержимое новостей
      productsContainer.innerHTML = doc.body.innerHTML;

      // Обновляем количество страниц
      const totalPagesElement = doc.querySelector('#total-pages');
      if (totalPagesElement) {
        totalPages = parseInt(totalPagesElement.textContent, 10);
      }

      updatePagination(page);
    } catch (error) {
      console.error('Ошибка AJAX:', error.message);
    }
  }

  // Функция обновления пагинации
  function updatePagination(currentPage) {
    paginationContainer.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
      const button = document.createElement('div');
      button.textContent = i;
      button.classList.add('page-item');
      if (i === currentPage) button.classList.add('active');
      button.addEventListener('click', () => loadPage(i));
      paginationContainer.appendChild(button);
    }
  }

  // Инициализация
  loadPage(1);
});