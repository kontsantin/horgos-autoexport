document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper-reviews', {
        loop: true, // Зацикливание слайдов
        navigation: {
            nextEl: '.swiper-button-next', // Кнопка "вперед"
            prevEl: '.swiper-button-prev', // Кнопка "назад"
        },
        // autoplay: {
        //     delay: 3000, // Автопрокрутка каждые 3 секунды
        //     disableOnInteraction: false, // Продолжить после взаимодействия
        // },
        slidesPerView: 1, // Количество видимых слайдов
        spaceBetween: 20, // Отступы между слайдами
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const swiperTwo = new Swiper('.swiper-container', {
      // Параметры слайдера
      loop: true, // Зацикливание слайдов
      spaceBetween: 10, // Расстояние между слайдами
      slidesPerView: 1, // Количество отображаемых слайдов
  
      // Навигация (кнопки)
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },

      //плагинация

      pagination: {
        el: '.swiper-pagination', // Указываем контейнер для точек пагинации
        clickable: true, // Делаем точки кликабельными
      },
      // Автопрокрутка
      // autoplay: {
      //   delay: 3000, // Время между слайдами в миллисекундах
      //   disableOnInteraction: false, // Не отключать автопрокрутку при взаимодействии
      // },
    });
  });