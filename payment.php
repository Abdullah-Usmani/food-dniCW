<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Status</title>
  <link rel="stylesheet" href="order-status.css">
  <style>
    /* Your existing CSS styles */
    header {
      background-color: #f2f2f2;
      padding: 10px 0;
    }
    .container {
      width: 90%;
      margin: 0 auto;
    }
    .header-buttons {
      text-align: right;
    }
    .header-buttons button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      margin: 0 5px;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <header>
    <div class="container">
      <div class="header-buttons">
        <button onclick="location.href='menu.php'">Main Menu</button>
        <button onclick="location.href='cart.php'">Cart</button>
        <button onclick="location.href='payment.php'">Order Status</button>
        <button onclick="location.href='signup.php'">Log in</button> <!-- New Button -->
      </div>
    </div>
  </header>

  <div class="order-status">
    <h1>Order Status</h1>
    <div class="order-details">
      <p><label for="order-id">Order ID:</label> <span id="order-id"></span></p>
      <p><label for="total-price">Total Price:</label> <span id="total-price"></span></p>
      <p><label for="items-ordered">Items Ordered:</label> <span id="items-ordered"></span></p>
      <p><label for="time-of-order">Time of Order:</label> <span id="time-of-order"></span></p>
      <p><label for="estimated-delivery-time">Estimated Delivery Time:</label> <span id="estimated-delivery-time"></span></p>
      <p><label for="payment-method">Payment Method:</label> <span id="payment-method"></span></p>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
      <button onclick="trackOrder()">Track Order</button>
      <button onclick="cancelOrder()">Cancel Order</button>
      <button onclick="contactSupport()">Contact Support</button>
      <button onclick="returnToMenu()">Return to Menu</button>
    </div>
  </div>

  <script src="order-status.js"></script>
</body>
</html>
