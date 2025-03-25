
document.querySelectorAll('.accordion-header').forEach(button => {
    button.addEventListener('click', () => {
      const content = button.nextElementSibling;
      const icon = button.querySelector('.icon');
      
      button.classList.toggle('active');
      
      if (content.style.maxHeight) {
        content.style.maxHeight = null;
        icon.textContent = '+'; // Меняем на плюс
      } else {
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.textContent = '-'; // Меняем на минус
      }
    });
  });