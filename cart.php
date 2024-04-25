<?php
session_start(); // Start or resume a session

// Sample data for cart items
$cartItems = [
  ['name' => 'Grilled Chicken', 'quantity' => 2, 'price' => 10],
  ['name' => 'Peri-Peri Fries', 'quantity' => 1, 'price' => 8]
];

// Function to calculate total amount
function calculateTotal($items) {
  $totalItems = 0;
  $subtotal = 0;
  $taxRate = 0.10; // 10% tax rate
  $shippingCost = 5; // Fixed shipping cost

  foreach ($items as $item) {
    $totalItems += $item['quantity'];
    $subtotal += $item['quantity'] * $item['price'];
  }

  $tax = $subtotal * $taxRate;
  $totalAmount = $subtotal + $tax + $shippingCost;

  return [
    'totalItems' => $totalItems,
    'subtotal' => $subtotal,
    'tax' => $tax,
    'shippingCost' => $shippingCost,
    'totalAmount' => $totalAmount
  ];
}

// Get cart items total
$cartTotals = calculateTotal($cartItems);
?>

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
    <div class="header">
      <h1>My Cart</h1>
      <div class="header-buttons">
        <button id="view-cart-button" class="header-button" onclick="location.href='cart.php'">View Cart</button>
        <button id="main-menu-button" class="header-button" onclick="location.href='menu.php'">Main Menu</button>
        <button id="order-status-button" class="header-button" onclick="location.href='status.php'">Order Status</button>
      </div>
    </div>
    <div class="cart-items" id="cart-items">
      <?php
      // Display cart items
      if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
          echo '<div class="cart-item">';
          echo '<img src="food.jpg" alt="' . $item['name'] . '">';
          echo '<div class="item-details">';
          echo '<h2>' . $item['name'] . '</h2>';
          echo '<p>Quantity: ' . $item['quantity'] . '</p>';
          echo '<p>Price: $' . $item['price'] . ' each</p>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        // Display message if cart is empty
        echo '<div class="cart-item">';
        echo '<p>Your cart is empty.</p>';
        echo '</div>';
      }
      ?>
    </div>
    <div class="user-info">
      <label for="phone">Phone Number:</label>
      <input type="text" id="phone" name="phone">
      <label for="location">Address:</label>
      <input type="text" id="location" name="location">
    </div>

    <!-- Summary -->
    <div class="cart-summary" id="cart-summary">
      <?php
      // Display cart summary
      if (!empty($cartItems)) {
        echo '<h2>Cart Summary</h2>';
        echo '<div class="summary-details">';
        echo '<p>Total Items: ' . $cartTotals['totalItems'] . '</p>';
        echo '<p>Subtotal: $' . number_format($cartTotals['subtotal'], 2) . '</p>';
        echo '<p>Tax (' . ($taxRate * 100) . '%): $' . number_format($cartTotals['tax'], 2) . '</p>';
        echo '<p>Shipping Cost: $' . number_format($cartTotals['shippingCost'], 2) . '</p>';
        echo '<div class="payment-method">';
        echo '<label for="payment-options">Payment Method:</label>';
        echo '<select id="payment-options">';
        echo '<option value="cash">Cash</option>';
        echo '<option value="credit-debit">Credit/Debit Card</option>';
        echo '<option value="tng">Touch \'n Go</option>';
        echo '</select>';
        echo '</div>';
        echo '<p>Total Amount: $' . number_format($cartTotals['totalAmount'], 2) . '</p>';
        echo '</div>';
      }
      ?>
      <p class="message" style="display:none;"></p>
      <button id="pay-now-button" class="pay-button">Pay Now</button>
    </div>
  </div>

  <script src="cart.js"></script>
</body>
</html>
      