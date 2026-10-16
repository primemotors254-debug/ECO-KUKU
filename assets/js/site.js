(function () {
  'use strict';
  var config = window.ECO_KUKU_CONFIG || {};
  var menuButton = document.querySelector('.menu-toggle');
  var nav = document.querySelector('.site-nav');
  if (menuButton && nav) {
    menuButton.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      menuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        nav.classList.remove('is-open');
        menuButton.setAttribute('aria-expanded', 'false');
      });
    });
  }
  var number = String(config.whatsappNumber || '').replace(/[^0-9]/g, '');
  document.querySelectorAll('.wa-link').forEach(function (link) {
    var message = link.getAttribute('data-message') || 'Hello Eco Kuku, I have an enquiry.';
    if (number) {
      link.href = 'https://wa.me/' + number + '?text=' + encodeURIComponent(message);
      link.target = '_blank';
      link.rel = 'noopener noreferrer';
    } else {
      link.href = 'contact.html#whatsapp-setup';
      link.addEventListener('click', function (event) {
        event.preventDefault();
        window.location.href = new URL('contact.html#whatsapp-setup', window.location.href).href;
      });
    }
  });
  var year = document.getElementById('year');
  if (year) year.textContent = new Date().getFullYear();
  var phone = document.querySelectorAll('[data-contact="phone"]');
  phone.forEach(function (el) { if (config.displayPhone) { el.textContent = config.displayPhone; el.href = 'tel:' + config.displayPhone.replace(/[^+0-9]/g, ''); } });
  var email = document.querySelectorAll('[data-contact="email"]');
  email.forEach(function (el) { if (config.email) { el.textContent = config.email; el.href = 'mailto:' + config.email; } });
  var location = document.querySelectorAll('[data-contact="location"]');
  location.forEach(function (el) { if (config.location) el.textContent = config.location; });
}());
