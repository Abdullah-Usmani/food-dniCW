document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.getElementById('payment-options');
    const payNowButton = document.getElementById('pay-now-button');
    
    payNowButton.addEventListener('click', function() {
      const selectedOption = paymentOptions.value;
      if (selectedOption === 'credit-debit') {
        window.location.href = 'card-payment.html';
      } else if (selectedOption === 'cash') {
        const phoneNumber = document.getElementById('phone').value;
        const location = document.getElementById('location').value;
        const message = document.querySelector('.message');
        message.style.display = 'block';
        message.textContent = `Your order is being prepared. We will contact you at ${phoneNumber} for delivery to ${location}.`;
      } else {
        // Handle other payment options
      }
    });
  });
  