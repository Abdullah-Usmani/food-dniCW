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
    <form class="payment-details-form" action="#" method="post">
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
        <input type="text" id="card-number" name="card-number" required>
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
      <button id="view-cart-button" class="header-button" onclick="location.href='status.php'>Pay now</button>
    </form>
  </div>
</body>
</html>