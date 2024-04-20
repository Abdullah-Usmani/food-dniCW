document.addEventListener('DOMContentLoaded', function() {
  const paymentOptions = document.getElementById('payment-options');
  const payNowButton = document.getElementById('pay-now-button');

  payNowButton.addEventListener('click', function() {
    const selectedPaymentMethod = paymentOptions.value;
    if (selectedPaymentMethod === 'credit-debit') {
      window.location.href = 'card-payment.html'; // Redirect to card payment page
    } else if (selectedPaymentMethod === 'cash') {
      window.location.href = 'order-status.html'; // Redirect to order status page
    } else {
      // Handle other payment methods
      alert('Payment method not implemented yet.');
    }
  });
});
