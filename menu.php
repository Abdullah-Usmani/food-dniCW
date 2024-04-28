<?php
include 'functions.php';
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Desi Kitchen</title>
  <link rel="stylesheet" href="menu.css"> <!-- Link to external CSS file -->
</head>
<body>
  <!-- Header Section -->
  <header>
    <div class="container">
      <h1><a href="#">Desi Kitchen</a></h1>
    </div>
    <div class="header-buttons">
      <button onclick="location.href='menu.php'">Main Menu</button>
      <button onclick="location.href='cart.php'">Cart</button>
      <button onclick="location.href='status.php'">Order Status</button>
      <!-- Display USER INFO -->
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
  </header>

  <?php
  // Fetch all menu categories
  $categories = readMenuCategories();

  // Check if categories exist
  if ($categories !== false && $categories->num_rows > 0) {
      // Loop through each category
      while ($category = $categories->fetch_assoc()) {
          echo "<section class='category' id='" . $category['CategoryName'] . "'>";
          echo "<div class='container'>";
          echo "<h2>" . $category['CategoryName'] . "</h2>";

          // Fetch items for the current category
          $result = readMenuItem();
          if ($result !== false && $result->num_rows > 0) {
              echo "<div class='product-container'>";
              $itemCount = 0;
              while ($row = $result->fetch_assoc()) {
                  if ($row["CategoryID"] == $category["CategoryID"]) {
                    echo "<div class='menu-item'>";
                    echo "<img src='" . $row["ImageURL"] . "' alt='" . $row["ItemName"] . "' width='300' height='200' />";
                    echo "<h3><span class='item-name'>" . $row["ItemName"] . "</span></h3>"; // Wrap item name in a span element
                    echo "<p>" . $row["Description"] . "</p>";
                    echo "<p><span class='item-price'>$" . $row["Price"] . "</span></p>"; // Wrap price in a span element
                    echo "<button class=\"add-to-cart\" data-itemid=\"" . $row["ItemID"] . "\" data-itemname=\"" . $row["ItemName"] . "\" data-price=\"" . $row["Price"] . "\" data-imageurl=\"" . $row["ImageURL"] . "\">+</button>";
                    echo "</div>";
                    $itemCount++;
                    if ($itemCount % 2 == 0) {
                      echo "</div><div class='product-container'>"; // Start new row after every 2 items
                    }
                  }
              }
              echo "</div>"; // Close product container
          }
          else {
              echo "<p>No records found.</p>";
          }
          echo "</div>"; // Close container
          echo "</section>";
      }
  } else {
      // If no categories found
      echo "<section class='category'>";
      echo "<div class='container'>";
      echo "<h2>No categories found.</h2>";
      echo "</div>";
      echo "</section>";
  }
  ?>

  <footer>
    <div class="container">
      <p>© 2024 Desi Kitchen. All rights reserved.</p>
    </div>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const addToCartButtons = document.querySelectorAll(".add-to-cart");
      addToCartButtons.forEach(button => {
        button.addEventListener("click", function(event) {
          const ItemID = button.dataset.itemid;
          const ItemName = button.dataset.itemname;
          const Price = button.dataset.price;
          const ImageURL = button.dataset.imageurl;
          addToCart(ItemID, ItemName, Price, ImageURL);
          // Optionally, provide visual feedback to the user
          alert(ItemName + " added to cart");
        });
      });

      function addToCart(ItemID, ItemName, Price, ImageURL) {
        // Send an AJAX request to addToCart.php to add the item to the cart
        const xhr = new XMLHttpRequest();
        const url = "addToCart.php";
        const params = `ItemID=${ItemID}&ItemName=${ItemName}&Price=${Price}&ImageURL=${ImageURL}`;
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Handle successful response
            console.log(xhr.responseText);
          } else {
            // Handle error response
            console.error("Error adding item to cart");
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