document.addEventListener('DOMContentLoaded', () => {
    // Слайдер миниатюр
    const galleryThumbs = new Swiper('.gallery-thumbs', {
      direction: 'vertical', // Миниатюры располагаются вертикально
      spaceBetween: 10, // Отступы между миниатюрами
//       slidesPerView: 5, // Видно ровно 5 миниатюр
      freeMode: true, // Свободный режим прокрутки
      mousewheel: true, // Добавляем прокрутку колёсиком мыши
      watchSlidesVisibility: true, // Следим за видимостью
      watchSlidesProgress: true, // Следим за прогрессом
      loop: false, // Следим за прогрессом
      slidesPerView: 'auto'
    });
  
    // Основной слайдер
    const galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10, // Отступы между слайдами
      thumbs: {
        swiper: galleryThumbs, // Привязываем миниатюры
      },
    });
  });




  //новый свипер слайдер
let swiperTwo; // Объявляем переменную для Swiper

function initSwiper() {
  // Проверяем ширину экрана
  if (window.innerWidth > 768 ) {
    if (!swiperTwo) { // Если Swiper ещё не инициализирован
      swiperTwo = new Swiper('.other-models-swiper_container', {
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        slidesPerView: 4,
        spaceBetween: 20,
        breakpoints: {
          1024: {
            slidesPerView: 3,
            spaceBetween: 15,
          },
        },
      });
    }
  } else {
    if (swiperTwo) { // Если Swiper уже инициализирован, уничтожаем его
      swiperTwo.destroy(true, true);
      swiperTwo = null; // Обнуляем переменную
    }
  }
}

// Запускаем проверку при загрузке и изменении размера окна
window.addEventListener('load', initSwiper);
window.addEventListener('resize', initSwiper);


  document.addEventListener('DOMContentLoaded', () => {
    const galleryTop = document.querySelector('.gallery-top');
    const galleryThumbs = document.querySelector('.gallery-thumbs');
  
    function updateThumbsHeight() {
      if (galleryTop && galleryThumbs) {
        const galleryTopHeight = galleryTop.offsetHeight; // Получаем текущую высоту .gallery-top
        galleryThumbs.style.maxHeight = `${galleryTopHeight}px`; // Устанавливаем ту же высоту для .gallery-thumbs
        galleryThumbs.style.maxHeight = `${galleryTopHeight}px`; // Устанавливаем ту же высоту для .gallery-thumbs
      }
    }
  
    // Первоначальная установка
    updateThumbsHeight();
  
    // Обновляем при изменении размера окна
    window.addEventListener('resize', updateThumbsHeight);
  });


document.addEventListener("DOMContentLoaded", function () {
  let startX;
  let isSwiping = false; // Флаг, чтобы предотвратить несколько свайпов подряд

  // Функция для обработки свайпов
  function addSwipeSupport() {
    const lbContainer = document.querySelector(".lb-container");

    if (!lbContainer) {
      console.error(".lb-container not found!");
      return;
    }

    lbContainer.addEventListener("touchstart", function (e) {
      startX = e.touches[0].clientX; // Сохраняем начальную позицию касания
    });

    lbContainer.addEventListener("touchend", function (e) {
      if (isSwiping) return; // Если свайп уже был, игнорируем последующие

      const endX = e.changedTouches[0].clientX; // Сохраняем конечную позицию касания
      isSwiping = true; // Блокируем свайпы на время

      // Если свайп влево (слева направо), кликаем на .lb-next
      if (startX - endX > 50) {
        console.error("startX - endX > 50");
        document.querySelector(".lb-next")?.click(); // Переключаем на следующее изображение
      }
      // Если свайп вправо (справа налево), кликаем на .lb-prev
      else if (endX - startX > 50) {
        console.error("endX - startX > 50");
        document.querySelector(".lb-prev")?.click(); // Переключаем на предыдущее изображение
      }

      // Устанавливаем задержку, чтобы предотвратить повторный свайп сразу
      setTimeout(function () {
        isSwiping = false; // Разрешаем следующий свайп после задержки
      }, 300); // Задержка в 300ms, можно настроить по необходимости
    });
  }

  // Наблюдатель для открытия Lightbox
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (document.getElementById('lightbox') && document.getElementById('lightbox').offsetParent !== null) {
        setTimeout(addSwipeSupport, 100); // Запуск при открытии Lightbox
      }
    });
  });

  observer.observe(document.body, { childList: true, subtree: true });
});
