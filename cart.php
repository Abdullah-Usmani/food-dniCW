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
      if(isset($_SESSION['cart'])) {
          foreach($uniqueItems as $itemID => $item) {
              echo '<div class="cart-item">';
              echo '<img src="food.jpg" alt="' . $item['ItemName'] . '">';
              echo '<div class="item-details">';
              echo '<h2>' . $item['ItemName'] . '</h2>';
              echo '<p>Quantity: ' . $item['Quantity'] . '</p>';
              echo '<p>Price: $' . $item['Price'] . ' each</p>';
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
        if(isset($_SESSION['cart'])) {
            echo '<h2>Cart Summary</h2>';
            echo '<div class="summary-details">';
            echo '<p>Total Items: ' . count($_SESSION['cart']) . '</p>';
            echo '<p>Subtotal: $' . number_format($subTotal, 2) . '</p>';
            echo '<p>Tax (' . ($taxRate * 100) . '%): $' . number_format($tax, 2) . '</p>';
            echo '<p>Shipping Cost: $' . number_format($shippingCost, 2) . '</p>';
            echo '<div class="payment-method">';
            echo '<label for="payment-options">Payment Method:</label>';
            echo '<select id="payment-options">';
            echo '<option value="cash">Cash</option>';
            echo '<option value="credit-debit">Credit/Debit Card</option>';
            echo '<option value="tng">Touch \'n Go</option>';
            echo '</select>';
            echo '</div>';
            echo '<p>Total Amount: $' . number_format($totalAmount, 2) . '</p>';
            echo '</div>';
        } else {
            // Display message if cart is empty
            echo '<div class="cart-item">';
            echo '<p>Your cart is empty.</p>';
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
