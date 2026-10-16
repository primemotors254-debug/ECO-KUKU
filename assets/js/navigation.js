document.addEventListener('DOMContentLoaded', function () {
  const button = document.querySelector('.mobile-toggle');
  const nav = document.querySelector('.main-navigation');
  if (!button || !nav) return;
  button.addEventListener('click', function () {
    const isOpen = nav.classList.toggle('is-open');
    button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });
});
