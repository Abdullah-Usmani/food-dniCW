<?php
session_start(); // Start or resume a session

// Initialize variables for subtotal and total amount
$subTotal = 0;
$taxRate = 0.10; // Assuming 10% tax rate
$shippingCost = 5; // Assuming a fixed shipping cost
$totalAmount = 0;

// Check if the cart session variable exists
if(isset($_SESSION['cart'])) {
    // Initialize an array to store unique item IDs and their quantities
    $uniqueItems = array();
    
    // Iterate over each item in the cart
    foreach($_SESSION['cart'] as $item) {
        // Add the item to the uniqueItems array or update its quantity
        $itemID = $item['ItemID'];
        if(isset($uniqueItems[$itemID])) {
            $uniqueItems[$itemID]['Quantity']++;
        } else {
            $uniqueItems[$itemID] = array(
                'ItemName' => $item['ItemName'],
                'Price' => $item['Price'],
                'Quantity' => 1
            );
        }
        
        // Calculate the subtotal for each item (price * quantity)
        $subTotal += $item['Price'];
    }
}

// Calculate tax amount
$tax = $subTotal * $taxRate;

// Calculate total amount (subtotal + tax + shipping)
$totalAmount = $subTotal + $tax + $shippingCost;
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
    <div class="cart-items">
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
    <div class="cart-summary">
      <h2>Cart Summary</h2>
      <div class="summary-details">
        <p>Total Items: <?php echo count($_SESSION['cart'] ?? []); ?></p>
        <p>Subtotal: $<?php echo number_format($subTotal, 2); ?></p>
        <p>Tax (<?php echo ($taxRate * 100); ?>%): $<?php echo number_format($tax, 2); ?></p>
        <p>Shipping Cost: $<?php echo number_format($shippingCost, 2); ?></p>
        <div class="payment-method">
          <label for="payment-options">Payment Method:</label>
          <select id="payment-options">
            <option value="cash">Cash</option>
            <option value="credit-debit">Credit/Debit Card</option>
            <option value="tng">Touch 'n Go</option>
          </select>
        </div>
        <p>Total Amount: $<?php echo number_format($totalAmount, 2); ?></p>
      </div>
      <p class="message" style="display:none;"></p>
      <button id="pay-now-button" class="pay-button" onclick="payNow()">Pay Now</button>
    </div>
  </div>

  <script src="cart.js"></script>
  <script>
    function payNow() {
      const phone = document.getElementById("phone").value;
      const location = document.getElementById("location").value;
      
      if (!phone || !location) {
        const messageElement = document.querySelector(".message");
        messageElement.textContent = "Please fill out all fields!";
        messageElement.style.display = "block";
      } else {
        // Proceed with payment process
        // For demonstration purposes, alerting the values
        alert(`Phone Number: ${phone}\nAddress: ${location}`);
      }
    }
  </script>
</body>
</html>
