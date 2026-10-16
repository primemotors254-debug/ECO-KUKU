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

  // Lightweight cart for the static product catalogue. Orders are submitted through WhatsApp.
  var cart = [];
  var cartItems = document.getElementById('cart-items');
  var cartCount = document.getElementById('cart-count');
  var cartTotal = document.getElementById('cart-total');
  var checkoutButton = document.getElementById('checkout-whatsapp');
  function money(value) { return 'KSh ' + Number(value).toLocaleString('en-KE'); }
  function renderCart() {
    if (!cartItems) return;
    var count = cart.reduce(function (sum, item) { return sum + item.qty; }, 0);
    var total = cart.reduce(function (sum, item) { return sum + item.price * item.qty; }, 0);
    cartCount.textContent = '(' + count + (count === 1 ? ' item' : ' items') + ')';
    cartTotal.textContent = money(total);
    checkoutButton.disabled = cart.length === 0;
    if (!cart.length) {
      cartItems.innerHTML = '<p class="cart-empty">Your cart is empty. Add products below to get started.</p>';
      return;
    }
    cartItems.innerHTML = cart.map(function (item, index) {
      return '<div class="cart-row"><div class="cart-product"><strong>' + item.name + '</strong><small>' + money(item.price) + ' each</small></div><div class="cart-controls"><button type="button" data-cart-action="minus" data-index="' + index + '" aria-label="Decrease quantity">−</button><span>' + item.qty + '</span><button type="button" data-cart-action="plus" data-index="' + index + '" aria-label="Increase quantity">+</button><button type="button" class="cart-remove" data-cart-action="remove" data-index="' + index + '">Remove</button></div><strong class="cart-line-total">' + money(item.price * item.qty) + '</strong></div>';
    }).join('');
  }
  document.querySelectorAll('.add-to-cart').forEach(function (button) {
    button.addEventListener('click', function () {
      var name = button.getAttribute('data-product');
      var price = Number(button.getAttribute('data-price'));
      var existing = cart.find(function (item) { return item.name === name; });
      if (existing) existing.qty += 1;
      else cart.push({ name: name, price: price, qty: 1 });
      renderCart();
      var original = button.textContent;
      button.textContent = 'Added ✓';
      window.setTimeout(function () { button.textContent = original; }, 900);
    });
  });
  if (cartItems) cartItems.addEventListener('click', function (event) {
    var control = event.target.closest('[data-cart-action]');
    if (!control) return;
    var index = Number(control.getAttribute('data-index'));
    if (!cart[index]) return;
    var action = control.getAttribute('data-cart-action');
    if (action === 'plus') cart[index].qty += 1;
    if (action === 'minus') cart[index].qty -= 1;
    if (action === 'remove' || cart[index].qty <= 0) cart.splice(index, 1);
    renderCart();
  });
  var clearCart = document.getElementById('cart-clear');
  if (clearCart) clearCart.addEventListener('click', function () { cart = []; renderCart(); });
  if (checkoutButton) checkoutButton.addEventListener('click', function () {
    if (!cart.length || !number) return;
    var lines = cart.map(function (item) { return item.qty + ' × ' + item.name + ' — ' + money(item.price * item.qty); });
    var total = cart.reduce(function (sum, item) { return sum + item.price * item.qty; }, 0);
    var message = 'Hello Eco Kuku, I would like to place this order:\n' + lines.join('\n') + '\nTotal: ' + money(total) + '\nPlease confirm availability and delivery or collection options.';
    window.open('https://wa.me/' + number + '?text=' + encodeURIComponent(message), '_blank', 'noopener');
  });
  renderCart();

  var year = document.getElementById('year');
  if (year) year.textContent = new Date().getFullYear();
  var phone = document.querySelectorAll('[data-contact="phone"]');
  phone.forEach(function (el) { if (config.displayPhone) { el.textContent = config.displayPhone; el.href = 'tel:' + config.displayPhone.replace(/[^+0-9]/g, ''); } });
  var email = document.querySelectorAll('[data-contact="email"]');
  email.forEach(function (el) { if (config.email) { el.textContent = config.email; el.href = 'mailto:' + config.email; } });
  var location = document.querySelectorAll('[data-contact="location"]');
  location.forEach(function (el) { if (config.location) el.textContent = config.location; });
}());
