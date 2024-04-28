<?php
include 'functions.php';
session_start(); // Start the session

$UserID = $_SESSION['user_id'] ?? 0;
$OrderID = $_SESSION['order_id'] ?? 0; // Default to 0 if OrderID is not present in the session
$price = 2.5;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["payment"])) {
  $phoneNumber = $_POST["phone-number"];
  $amount = $_POST["amount"];
  $cardNumber = $_POST["card-number"];
  $cardHolder = $_POST["card-holder"];
  $expiryDate = $_POST["expiry-date"];
  $cvv = $_POST["cvv"];

  // Validate and process payment
  // Check if the user is logged in and OrderID is valid
  if ($_SESSION['user_id'] != $UserID || $OrderID == 0) {
      // If the logged-in user ID does not match the order's user ID or OrderID is invalid, display an error
      echo "Invalid user or order - payment failed";
  } 
  
  else {
      // Process the payment
      sendOrders($OrderID, 1); // Assuming this function sends the order
      createCardPayment($OrderID, $UserID, $price, 'Card', $cardNumber, $expiryDate, $cvv);
      exit();
  }
}
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
  <div class="payment-details-page">
    <h1>Payment Details</h1>
    <form name="payment" class="payment-details-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="input-group">
        <?php 
        echo '<h2>Order ID = '. $OrderID .'</h2>';
        echo '<h2>User ID = '. $UserID .'</h2>';
        ?>
        <label for="card-holder">Card Holder Name</label>
        <input type="text" id="card-holder" name="card-holder" required>
      </div>
      <div class="input-group">
        <label for="phone-number">Phone Number</label>
        <input type="tel" id="phone-number" name="phone-number" required>
      </div>
      <div class="input-group">
        <label for="amount">Amount to Pay</label>
        <input type="number" id="amount" name="amount" required>
      </div>
      <div class="input-group">
        <label for="card-number">Card Number</label>
        <input type="number" id="card-number" name="card-number" maxlength="16" required>
      </div>
      <div class="input-group">
        <label for="expiry-date">Expiry Date</label>
        <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" required>
      </div>
      <div class="input-group">
        <label for="cvv">CVV</label>
        <input type="number" id="cvv" name="cvv" maxlength="3" required>
      </div>
      <button id="view-cart-button" class="header-button" type='submit' name="payment">Pay now</button>
    </form>
  </div>
