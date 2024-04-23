<?php
include 'functions.php';
session_start(); // Start or resume a session
$loggedIn = false;
$userID = 0;

// Initialize variables for subtotal and total amount
$subTotal = 0;
$taxRate = 0.10; // Assuming 10% tax rate
$shippingCost = 5; // Assuming a fixed shipping cost
$totalAmount = 0;

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
  <title>My Cart - HungerStation</title>
  <link rel="stylesheet" href="cart.css">
  <style>
      .remove-from-cart {
      background-color: maroon;
      border: none;
      color: white;
      padding: 8px 16px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="cart-page">
  <div class="header">
      <h1>My Cart</h1>
        <div class="header-buttons">
          <button id="view-cart-button" class="header-button" onclick="location.href='cart.php'">View Cart</button>
          <button id="main-menu-button" class="header-button" onclick="location.href='menu.php'">Main Menu</button>
          <button id="order-status-button" class="header-button" onclick="location.href='status.php'">Order Status</button>
          <?php
          if (isset($_SESSION["user_id"])) {
              $userID = $_SESSION["user_id"];
              $result = readCustomer();
              if ($result !== false && $result->num_rows > 0) {
                $loggedIn = true;
                  while ($row = $result->fetch_assoc()) {
                      if ($row["CustomerID"] == $userID) {
                        echo "<button>".$row["Username"]." ID - ".$row["CustomerID"]."</button>";
                        echo "<button onclick=\"location.href='logout.php'\">Logout</button>";
                      }
                  }
              }
              else {
                  echo "<p>User not logged in</p>";
                  echo "<button onclick=\"location.href='signup.php'\">Login</button>";
              }
            }
          else {
              echo "<button>User not logged in</button>";
              echo "<button onclick=\"location.href='signup.php'\">Login</button>";
          }
          ?>
        </div>
      </div>
    <div class="cart-items">
        <?php
        displayCart($loggedIn, $userID);
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
      <button id="pay-now-button" class="header-button">Pay now</button>
    </div>
  </div>

  <script src="cart.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const removeFromCartbuttons = document.querySelectorAll(".remove-from-cart");
      removeFromCartbuttons.forEach(button => {
        button.addEventListener("click", function(event) {
          const OrderItemID = button.dataset.orderitemid;
          const ItemName = button.dataset.itemname;
          const loggedIn = button.dataset.loggedin;
          const userID = button.dataset.userid;
          deleteOrder(OrderItemID);
          // Optionally, provide visual feedback to the user
          alert(ItemName + " removed from cart");
        });
      });

      function deleteOrder(OrderItemID) {
        // Send an AJAX request to addToCart.php to remove the item from the cart
        const xhr = new XMLHttpRequest();
        const url = "removeFromCart.php";
        const params = `OrderItemID=${OrderItemID}, loggedIn=${loggedIn}, userID=${userID}`;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Handle successful response
            console.log(xhr.responseText);
          } else {
            // Handle error response
            console.error("Error removing item from cart");
          }
        };
        xhr.onerror = function() {
          // Handle connection error
          console.error("Connection error");
        };
        xhr.send(params);
      }
    });
    </script>
</body>
</html>
