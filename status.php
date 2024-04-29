<?php
include 'functions.php';
session_start(); // Start the session
$loggedIn = false;
$userID = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Status</title>
  <link rel="stylesheet" href="status.css">
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
  </style>
</head>
<body>
  <!-- Header Section -->
  <header>
    <div class="container">
      <div class="header-buttons">
        <img src="images/home.png" alt="Main Menu" onclick="location.href='menu.php'">
        <img src="images/cart.png" alt="Cart" onclick="location.href='cart.php'">
        <img src="images/orderstatus.png" alt="Order Status" onclick="location.href='status.php'">
        <?php
        if (isset($_SESSION["user_id"])) {
            $userID = $_SESSION["user_id"];
            $result = readCustomer();
            if ($result !== false && $result->num_rows > 0) {
              $loggedIn = true;
                while ($row = $result->fetch_assoc()) {
                    if ($row["CustomerID"] == $userID) {
                      echo "<a href='logout.php'><img src='images/login.png' alt='".$row["Username"]." ID - ".$row["CustomerID"]."'></a>";
                    }
                }
            }
            else {
                echo "<a href='signup.php'><img src='images/login.png' alt='Login'></a>";
            }
          } else {
              echo "<a href='signup.php'><img src='images/login.png' alt='Login'></a>";
          }
        ?>
      </div>
    </div>
  </header>

<?php
  if ($loggedIn) {
    $result1 = readOrders("DESC");
    if ($result1 !== false && $result1->num_rows > 0) {
      $foundItems = false; // Flag to indicate if any items were found in the order history
      while ($row1 = $result1->fetch_assoc()) {
        if ($row1["CustomerID"] == $userID && $row1["OrderStatus"] == 1) {
          $foundItems = true; // Set flag to true
          echo '<div class="order-status">';
          echo '<h1> Order Status </h1>';
          echo '<div class="order-details">';
          echo '<p>Order ID: <b>'. $row1["OrderID"] .'</b></p>';
          echo '<p>Total Price: <b>$'. $row1["Price"] .'</b></p>';
          echo '<p>Time of Order: <b>'. $row1["OrderDateTime"] .'</b></p>';                                  
          $result2 = readOrderItem();
          while ($row2 = $result2->fetch_assoc()) {
            if ($row2["OrderID"] == $row1["OrderID"]) {
              $result3 = readMenuItem();
              if ($result3 !== false && $result3->num_rows > 0) {
                while ($row3 = $result3->fetch_assoc()) {
                  if ($row3["ItemID"] == $row2["ItemID"]) {
                    // Display item details
                    echo '<img src="food.jpg" alt="' . $row3['ItemName'] . '">';
                    echo '<h2>' . $row3['ItemName'] . '</h2>';
                    echo '<p>ItemID: ' . $row2['ItemID'] . '</p>';
                    echo '<p>OrderItemID: ' . $row2['OrderItemID'] . '</p>';
                    echo '<p>Price: $' . $row3['Price'] . '</p>';
                  }
                }
              }
            }
          }
          echo '</div>';
          echo '</div>';
        }
      }
      // If no orders were found, display appropriate message
      if (!$foundItems) {
        echo '<div class="order-status">';
        echo '<p>Your order history is empty.</p>';
        echo '</div>';
      }
    } else {
      // If no orders were found, display appropriate message
      echo '<div class="order-status">';
      echo '<p>Your order history is empty.</p>';
      echo '</div>';
    }
  } else {
    // If user is not logged in, display appropriate message
    echo '<div class="order-status">';
    echo '<p>User not logged in.</p>';
    echo '</div>';
  }
  ?>

  <script src="status.js"></script>
</body>
</html>