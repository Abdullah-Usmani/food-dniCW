// Event listener for pay now button
document.getElementById("pay-now-button").addEventListener("click", () => {
  const phone = document.getElementById("phone").value;
  const location = document.getElementById("location").value;
  const paymentMethod = document.getElementById("payment-options").value;

  if (!phone || !location) {
    const messageElement = document.querySelector(".message");
    messageElement.textContent = "Please fill out all fields!";
    messageElement.style.display = "block";
  } 
  else {
    // Proceed with payment process based on payment method
    if (paymentMethod === "credit-debit") {
      // Redirect to payment.php for Credit/Debit Card payment
      location.href = 'payment.php';
    } 
    else if (paymentMethod === "cash") {
      // Redirect to status.php for Cash payment
      location.href = 'status.php';
    } 
    else {
      // For other methods, just alert the values
      alert(`Phone Number: ${phone}\nAddress: ${location}\nPayment Method: ${paymentMethod}`);
    }
  }
});
