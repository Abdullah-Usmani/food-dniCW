<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart - Nando's</title>
  <link rel="stylesheet" href="cart.css">
</head>
<body>
  <div class="cart-page">
    <h1>My Cart</h1>
    <div class="cart-items">
      <!-- Cart items here -->
      <div class="cart-item">
        <img src="food1.jpg" alt="Food 1">
        <div class="item-details">
          <h2>Grilled Chicken</h2>
          <p>Quantity: 2</p>
          <p>Price: $10 each</p>
        </div>
      </div>
      <div class="cart-item">
        <img src="food2.jpg" alt="Food 2">
        <div class="item-details">
          <h2>Peri-Peri Fries</h2>
          <p>Quantity: 1</p>
          <p>Price: $8 each</p>
        </div>
      </div>
    </div>
    <div class="user-info">
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone">
        <label for="location">Address:</label>
        <input type="text" id="location" name="location">
      </div>
    <div class="cart-summary">
      <h2>Cart Summary</h2>
      <div class="summary-details">
        <p>Total Items: 3</p>
        <p>Subtotal: $28</p>
        <p>Shipping Method: Standard</p>
        <p>Tax: $3.50</p>
        <div class="payment-method">
          <label for="payment-options">Payment Method:</label>
          <select id="payment-options">
            <option value="cash">Cash</option>
            <option value="credit-debit">Credit/Debit Card</option>
            <option value="tng">Touch 'n Go</option>
          </select>
        </div>
        <p>Total Amount: $31.50</p>
      </div>
      <p class="message" style="display:none;"></p>
      <button id="pay-now-button" class="pay-button">Pay Now</button>
    </div>
  </div>

  <script src="cart.js"></script>
</body>
</html>
