<?php
include 'functions.php';
session_start(); // Start the session
$userID = 0;
$OrderID = $_GET['OrderID'];
$price = 0.0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enter Payment Details</title>
  <link rel="stylesheet" href="payment_details.css">
</head>
<body>
  <?php 
  if(isset($_SESSION['user_id'])) {
      $userID = $_SESSION['user_id'];
      // Now you can use $userID in your code
  } 
  
  else {
    echo 'User not signed in';
      // Handle the case when the user is not logged in or userID is not set in the session
  }
  ?>
  <div class="payment-details-page">
    <h1>Payment Details</h1>
    <form name="payment" class="payment-details-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="input-group">
        <label for="phone-number">Phone Number</label>
        <input type="tel" id="phone-number" name="phone-number" required>
      </div>
      <div class="input-group">
        <label for="amount">Amount to Pay</label>
        <input type="text" id="amount" name="amount" required>
      </div>
      <div class="input-group">
        <label for="card-number">Card Number</label>
        <input type="text" id="card-number" name="card-number" maxlength="16" required>
      </div>
      <div class="input-group">
        <label for="card-holder">Card Holder Name</label>
        <input type="text" id="card-holder" name="card-holder" required>
      </div>
      <div class="input-group">
        <label for="expiry-date">Expiry Date</label>
        <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" required>
      </div>
      <div class="input-group">
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" maxlength="3" required>
      </div>
      <button id="view-cart-button" class="header-button" type='submit'>Pay now</button>
    </form>
  </div>

  <?php
  
  // if loggedin USER ID != OrderID USERID - payment failed, incorrect used
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["payment"])) {
    $phoneNumber = $_POST["phoneNumber"];
    $amount = $_POST["amount"];
    $cardNumber = $_POST["card-number"];
    $cardHolder = $_POST["card-holder"];
    $expiryDate = $_POST["expiry-date"];
    $cvv = $_POST["cvv"];

    // Query the database to check for matching record
    $result = readCustomer();
    $row = $result->fetch_assoc();
    if($result3 = readOrders()) {
      $row3 = $result3->fetch_assoc();
      $price = $row3['Price'];
    }

    if ($row["CustomerID"] = $_SESSION["user_id"]) {
        // Fetch the user ID and store it in a session variable
        sendOrders($OrderID, 1);
        $result2 = createCardPayment($OrderID, $userID, $price, $cardNumber, $expiryDate, $cvv);
        if ($result1 && $result2) {
          echo "Payment Successful";
        }
        else {
          echo "Payment Failed";
        }
      } 
      else {
        // Set error message as a session variable
        echo "Invalid user logged in - payment failed echoing";
        $_SESSION["error"] = "Invalid user logged in - payment failed";
    }
}
  
  ?>
  <!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to the payment form
    document.querySelector(".payment-details-form").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent the default form submission
      
      // Validate form inputs
      const phoneNumber = document.getElementById("phone-number").value;
      const amount = document.getElementById("amount").value;
      const cardNumber = document.getElementById("card-number").value;
      const cardHolder = document.getElementById("card-holder").value;
      const expiryDate = document.getElementById("expiry-date").value;
      const cvv = document.getElementById("cvv").value;
      
      // Perform form validation (you can customize this according to your requirements)
      if (!phoneNumber || !amount || !cardNumber || !cardHolder || !expiryDate || !cvv) {
        alert("Please fill out all fields.");
        return;
      }
      
      // Assuming form validation passed, you can now proceed with payment processing
      // You can use AJAX to send payment details to the server and update the order status
      
      // Example AJAX request (replace it with your actual implementation)
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "process_payment.php", true); // Replace "process_payment.php" with your actual PHP file for processing payments
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Payment processing successful, you can update order status and redirect
          const orderID = "<?php echo $OrderID; ?>"; // Assuming $OrderID is available in PHP
          updateOrders(orderID); // Call the updateOrders function
        } else {
          // Handle errors if any
          alert("Payment processing failed. Please try again.");
        }
      };
      xhr.onerror = function() {
        // Handle connection errors
        alert("Connection error. Please try again later.");
      };
      
      // Prepare payment data to be sent to the server (you can adjust this based on your server-side requirements)
      const params = `phoneNumber=${phoneNumber}&amount=${amount}&cardNumber=${cardNumber}&cardHolder=${cardHolder}&expiryDate=${expiryDate}&cvv=${cvv}`;
      
      // Send the AJAX request
      xhr.send(params);
    });
  });

  // Function to update order status
  function updateOrders(orderID) {
    // Send an AJAX request to updateOrders.php with the OrderID
    const xhr = new XMLHttpRequest();
    const url = "updateOrders.php"; // Change this to the appropriate PHP script
    const params = `OrderID=${orderID}`;
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
</script> -->

      

</body>
</html>