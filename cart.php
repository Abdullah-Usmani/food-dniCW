<?php
include 'functions.php';
session_start(); // Start or resume a session
$loggedIn = false;
$foundItems = false;
$userID = 0;
$OrderID = 0;

// Initialize variables for subtotal and total amount
$subTotal = 0;
$taxRate = 0.10; // Assuming 10% tax rate
$shippingCost = 5; // Assuming a fixed shipping cost
$totalAmount = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart</title>
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
      <button class="header-button" onclick="location.href='menu.php'">
        <img src="images/home.png" alt="Main Menu">
    </button>
    <button class="header-button" onclick="location.href='cart.php'">
        <img src="images/cart.png" alt="View Cart">
    </button>
    
    <button class="header-button" onclick="location.href='status.php'">
        <img src="images/orderstatus.png" alt="Order Status">
    </button>
    <?php
if (isset($_SESSION["user_id"])) {
    $userID = $_SESSION["user_id"];
    $result = readCustomer();
    if ($result !== false && $result->num_rows > 0) {
      $loggedIn = true;
      while ($row = $result->fetch_assoc()) {
          if ($row["CustomerID"] == $userID) {
              echo "<button class='header-button' onclick=\"location.href='logout.php'\"><img src='images/login.png' alt='Logout'></button>";
              echo "<p>" . $row["Username"] . " ID - " . $row["CustomerID"] . "</p>";
          }
      }
  } else {
    echo "<button class='header-button' onclick=\"location.href='signup.php'\"><img src='images/login.png' alt='Logout'></button>";
    echo "<p>User not logged in</p>";
  }
} else {
  echo "<button class='header-button' onclick=\"location.href='signup.php'\"><img src='images/login.png' alt='Logout'></button>";
  echo "<p>User not logged in</p>";
}
?>
</div>
      </div>
      <div class="cart-items">
        <?php
      // Display cart items
      if($loggedIn) {
        $result1 = readOrders("DESC");
        if ($result1 !== false && $result1->num_rows > 0) {
            $foundItems = false; // Flag to indicate if any items were found in the cart
            while ($row1 = $result1->fetch_assoc()) {
                if ($row1["CustomerID"] == $userID) {
                    $result2 = readOrderItem();
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row2["OrderID"] == $row1["OrderID"] && $row1["OrderStatus"] == 0) {
                            $OrderID = $row1["OrderID"];
                            $result3 = readMenuItem();
                            if ($result3 !== false && $result3->num_rows > 0) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    if ($row3["ItemID"] == $row2["ItemID"]) {
                                        // Display item details
                                        $foundItems = true; // Set flag to true
                                        echo '<div class="cart-item">';
                                        echo '<img src="'. $row3["ImageURL"] . '" alt="' . $row3['ItemName'] . '">';
                                        echo '<div class="item-details">';
                                        echo '<h2>' . $row3['ItemName'] . '</h2>';
                                        echo '<p>OrderID: ' . $row2['OrderID'] . '</p>';
                                        echo '<p>OrderItemID: ' . $row2['OrderItemID'] . '</p>';
                                        echo '<p>Price: $' . $row3['Price'] . '</p>';
                                        $subTotal += $row3['Price'];
                                        echo "<button class=\"remove-from-cart\" data-orderitemid=\"" . $row2["OrderItemID"] . "\"data-itemname=\"" . $row3["ItemName"] . "\">-</button>";
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // If no items were found in the cart, display error message
            if (!$foundItems) {
                echo '<div class="cart-item">';
                echo '<p>Your cart is empty.</p>';
                echo '</div>';
            }
          }
      }


      else {
        // Check if the cart session variable exists
        if(isset($_SESSION['cart'])) {
          // Initialize an array to store unique item IDs and their quantities
          $uniqueItems = array();
          
          // Iterate over each item in the cart
          foreach($_SESSION['cart'] as $item) {
              // Add the item to the uniqueItems array or update its quantity
              $itemID = $item['ItemID'];
              $uniqueItems[$itemID] = array(
              'ItemName' => $item['ItemName'],
              'Price' => $item['Price'],  
              'ImageURL' => $item['ImageURL'],
              );
          
              // Calculate the subtotal for each item (price * quantity)
              $subTotal += $item['Price'];
          }

            foreach($uniqueItems as $itemID => $item) {
                echo '<div class="cart-item">';
                echo '<img src="' . $item['ImageURL'] . '" alt="' . $item['ItemName'] . '">';
                echo '<div class="item-details">';
                echo '<h2>' . $item['ItemName'] . '</h2>';
                echo '<p>Price: $' . $item['Price'] . '</p>';
                echo '</div>';
                echo '</div>';
              }
          }

        else {
          // Display message if cart is empty
          echo '<div class="cart-item">';
          echo '<p>Your cart is empty.</p>';
          echo '</div>';
        }
      }
      // Calculate tax amount
      $tax = $subTotal * $taxRate;

      // Calculate total amount (subtotal + tax + shipping)
      $totalAmount = $subTotal + $tax + $shippingCost;
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
        <p>Subtotal: $<?php echo number_format($subTotal, 2); ?></p>
        <p>Tax (<?php echo ($taxRate * 100); ?>%): $<?php echo number_format($tax, 2); ?></p>
        <p>Shipping Cost: $<?php echo number_format($shippingCost, 2); ?></p>
        <div class="payment-method">
          <label for="payment-options">Payment Method:</label>
          <select id="payment-options">
            <option value="cash">Cash</option>
            <option value="credit-debit">Credit/Debit Card</option>
            <!-- <option value="tng">Touch 'n Go</option> -->
          </select>
        </div>
        <p>Total Amount: $<?php echo number_format($totalAmount, 2); ?></p>
      </div>
    <p class="message" style="display:none;"></p>
    <button id="pay-now-button" class="pay-button">Pay now</button>
    </div>
  </div>

  <script>
    
    document.addEventListener("DOMContentLoaded", function() {
      const removeFromCartbuttons = document.querySelectorAll(".remove-from-cart");
      removeFromCartbuttons.forEach(button => {
        button.addEventListener("click", function(event) {
          const OrderItemID = button.dataset.orderitemid;
          const ItemName = button.dataset.itemname;
          deleteOrder(OrderItemID);
          // Optionally, provide visual feedback to the user
          alert(ItemName + " removed from cart");
        });
      });
      
      function deleteOrder(OrderItemID) {
        // Send an AJAX request to addToCart.php to remove the item from the cart
        const xhr = new XMLHttpRequest();
        const url = "removeFromCart.php";
        const params = `OrderItemID=${OrderItemID}`;
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

    // Get the payment options select element
    // Event listener for pay now button
    document.getElementById("pay-now-button").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default form submission

        const phone = document.getElementById("phone").value;
        const location = document.getElementById("location").value;
        const paymentMethod = document.getElementById("payment-options").value;

        console.log("phone:", phone);
        console.log("location:", location);
        console.log("paymentMethod:", paymentMethod);

        const loggedIn = "<?php echo $loggedIn; ?>";
        const foundItems = "<?php echo $foundItems; ?>";
        console.log("loggedIn:", loggedIn);
        console.log("foundItems:", foundItems);

        if (loggedIn !== "1" || foundItems !== "1") {
            // If the user is not logged in or no items found in the cart, display an error message
            alert("Please log in or add items to your cart before proceeding with payment.");
        } 
        else {
            // Check if the user is logged in and items are found in the cart
            if (!phone || !location) {
            // If phone or location is not filled out, display an error message
            const messageElement = document.querySelector(".message");
            messageElement.textContent = "Please fill out all fields!";
            messageElement.style.display = "block";

            } 
            else {
                // Proceed with payment process based on payment method
                if (paymentMethod === "credit-debit") {
                    // Redirect to payment.php for Credit/Debit Card payment
                    <?php $_SESSION['order_id'] = $OrderID; ?>
                    const orderID = "<?php echo $OrderID ?>";
                    console.log("orderID:", orderID);
                    window.location.href = 'payment.php';
                } else if (paymentMethod === "cash") {
                    // Call the updateOrders function using AJAX
                    const orderID = "<?php echo $OrderID; ?>";
                    console.log("orderID:", orderID);
                    updateOrders(orderID);
                } else {
                    // For other methods, just alert the values
                    alert('Phone Number: ${phone}\nAddress: ${location}\nPayment Method: ${paymentMethod}');
                }
            }
        }
    });


      function updateOrders(OrderID) {
        // Send an AJAX request to updateOrders.php with the OrderID
        const xhr = new XMLHttpRequest();
        const url = "updateOrders.php"; // Change this to the appropriate PHP script
        const params = `OrderID=${OrderID}`;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Handle successful response
                console.log(xhr.responseText);
                // Redirect to status.php
                window.location.href = 'status.php';
            } else {
                // Handle error response
                console.error("Error updating orders");
            }
        };
        xhr.onerror = function() {
            // Handle connection error
            console.error("Connection error");
        };
        xhr.send(params);
    }


    </script>
</body>
</html>