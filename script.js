// script.js — логіка для сайту Vivenza

const form = document.getElementById('subscribeForm');
const buttons = form.querySelectorAll('button[type="button"]');
const paymentStatus = document.getElementById('paymentStatus');
const tgNickInput = document.getElementById('tgNick');

buttons.forEach(btn => {
  btn.addEventListener('click', () => {
    const nick = tgNickInput.value.trim();
    if (!nick || !/^@?[a-zA-Z0-9_]{5,32}$/.test(nick)) {
      alert('Будь ласка, введіть коректний Telegram нікнейм.');
      tgNickInput.focus();
      return;
    }
    // Імітація оплати
    const service = btn.getAttribute('data-service');
    const price = btn.getAttribute('data-price');
    const label = btn.getAttribute('data-label');

    paymentStatus.style.display = 'block';
    paymentStatus.textContent = `Оплата успішна! Ви обрали: ${label}. Вас додадуть до ${service === 'channel' ? 'Telegram-каналу' : 'бота'} протягом 5-20 хвилин у робочий час.`;

    // Тут можна підключити реальний платіж через Mono/LiqPay, передаючи tgNick, суму та послугу

    form.reset();
  });
});
