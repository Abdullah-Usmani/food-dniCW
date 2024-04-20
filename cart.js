// Sample data for cart items
const cartItems = [
  { name: "Grilled Chicken", quantity: 2, price: 10 },
  { name: "Peri-Peri Fries", quantity: 1, price: 8 }
];

// Function to calculate total amount
function calculateTotal() {
  let totalItems = 0;
  let subtotal = 0;
  let tax = 0.1; // 10% tax rate

  cartItems.forEach(item => {
    totalItems += item.quantity;
    subtotal += item.quantity * item.price;
  });

  let totalAmount = subtotal + (subtotal * tax);
  return {
    totalItems,
    subtotal,
    tax: subtotal * tax,
    totalAmount
  };
}

// Function to render cart items
function renderCartItems() {
  const cartItemsContainer = document.getElementById("cart-items");
  cartItemsContainer.innerHTML = "";

  cartItems.forEach(item => {
    const cartItemElement = document.createElement("div");
    cartItemElement.classList.add("cart-item");

    cartItemElement.innerHTML = `
      <img src="food1.jpg" alt="${item.name}">
      <div class="item-details">
        <h2>${item.name}</h2>
        <p>Quantity: ${item.quantity}</p>
        <p>Price: $${item.price} each</p>
      </div>
    `;

    cartItemsContainer.appendChild(cartItemElement);
  });
}

// Function to render cart summary
function renderCartSummary() {
  const cartSummaryContainer = document.getElementById("cart-summary");
  const { totalItems, subtotal, tax, totalAmount } = calculateTotal();

  cartSummaryContainer.innerHTML = `
    <h2>Cart Summary</h2>
    <div class="summary-details">
      <p>Total Items: ${totalItems}</p>
      <p>Subtotal: $${subtotal.toFixed(2)}</p>
      <p>Tax: $${tax.toFixed(2)}</p>
      <p>Total Amount: $${totalAmount.toFixed(2)}</p>
      <div class="payment-method">
        <label for="payment-options">Payment Method:</label>
        <select id="payment-options">
          <option value="cash">Cash</option>
          <option value="credit-debit">Credit/Debit Card</option>
          <option value="tng">Touch 'n Go</option>
        </select>
      </div>
    </div>
    <p class="message" style="display:none;"></p>
    <button id="pay-now-button" class="pay-button">Pay Now</button>
  `;
}

// Event listener for pay now button
document.getElementById("pay-now-button").addEventListener("click", () => {
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
});

// Initial rendering of cart items and summary
renderCartItems();
renderCartSummary();
