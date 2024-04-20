document.addEventListener('DOMContentLoaded', function() {
  const orderId = generateOrderId();
  const totalPrice = calculateTotalPrice();
  const itemsOrdered = "Grilled Chicken, Peri-Peri Fries"; // Example items
  const timeOfOrder = getCurrentTime();
  const estimatedDeliveryTime = generateEstimatedDeliveryTime();
  const paymentMethod = "Credit/Debit Card"; // Example payment method

  document.getElementById('order-id').textContent = orderId;
  document.getElementById('total-price').textContent = totalPrice;
  document.getElementById('items-ordered').textContent = itemsOrdered;
  document.getElementById('time-of-order').textContent = timeOfOrder;
  document.getElementById('estimated-delivery-time').textContent = estimatedDeliveryTime;
  document.getElementById('payment-method').textContent = paymentMethod;
});

function generateOrderId() {
  return Math.random().toString(36).substr(2, 9).toUpperCase();
}

function calculateTotalPrice() {
  // Perform calculation based on the items ordered
  return "$31.50"; // Example total price
}

function getCurrentTime() {
  return new Date().toLocaleString();
}

function generateEstimatedDeliveryTime() {
  const minMinutes = 20;
  const maxMinutes = 60;
  const deliveryTime = Math.floor(Math.random() * (maxMinutes - minMinutes + 1) + minMinutes);
  return `${deliveryTime} minutes to ${deliveryTime + 20} minutes`;
}

function trackOrder() {
  // Placeholder alert for demonstration
  alert("Tracking Order...");
  // You can add actual tracking code here
}

function cancelOrder() {
  // Placeholder alert for demonstration
  alert("Cancelling Order...");
  // You can add actual cancellation code here
}

function contactSupport() {
  // Placeholder alert for demonstration
  alert("Contacting Support...");
  // You can add actual contact support code here
}

function returnToMenu() {
  // Redirect to website.html
  window.location.href = 'Main Menu.html';
}
