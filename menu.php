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
  <link rel="stylesheet" href="menu.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
    .add-to-cart {
      background-color: #4CAF50;
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
    .header-buttons button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      margin: 0 5px;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <header>
    <div class="container">
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
                while ($row = $result->fetch_assoc()) {
                    if ($row["CustomerID"] == $userID) {
                      echo "<button>Welcome back, Mr. ". $row["Username"] . " UserID - "  . $row["CustomerID"] ." </button>";
                    }
                }
            }
            else {
                echo "<button>User not logged in.</button>";
            }
            // Now you can use $userID to fetch user-specific data or perform any other operations
        }
        ?>
      </div>
    </div>
    <div class="container">
      <h1><a href="#">Desi Kitchen</a></h1>
    </div>
  </header>

  <?php
  // Fetch all menu categories
  $categories = readMenuCategories();

  // if $row['CategoryID'] == $category['CategoryID'];
  // Check if categories exist
  if ($categories !== false && $categories->num_rows > 0) {
      // Loop through each category
      while ($category = $categories->fetch_assoc()) {
          echo "<section class='category' id='" . $category['CategoryName'] . "'>";
          echo "<div class='container'>";
          echo "<h2>" . $category['CategoryName'] . "</h2>";
          echo "<table>";
          echo "<tr>";
          echo "<th>Item</th>";
          echo "<th>Price</th>";
          echo "<th>Action</th>";
          echo "</tr>";

          // Fetch items for the current category
          $result = readMenuItem();
          if ($result !== false && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  if ($row["CategoryID"] == $category["CategoryID"]) {
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>" . $row["ItemID"] ."</td>";
                    echo "<td>" . $row["ItemName"] ."</td>";
                    echo "<td>" . $row["Description"] ."</td>";
                    echo "<td>" . $row["Price"] ."</td>";
                    echo "<td><button class=\"add-to-cart\" data-ItemID=\"" . $row["ItemID"] . "\" data-ItemName=\"" . $row["ItemName"] . "\" data-Price=\"" . $row["Price"] . "\">+</button></td>";
                    echo "</table>";
                  }
              }
          }
          else {
              echo "<tr><t colspan='4'> No records found. </t></tr>";
          }

          // // Check if items exist
          // if ($items !== false && $items->num_rows > 0) {
          //     // Loop through each item
          //     while ($item = $items->fetch_assoc()) {
          //         echo "<tr>";
          //         echo "<td>" . $item["ItemName"] . "</td>";
          //         echo "<td>" . $item["Price"] . "</td>";
          //         echo "<td><button class=\"add-to-cart\" data-ItemID=\"" . $item["ItemID"] . "\" data-ItemName=\"" . $item["ItemName"] . "\" data-Price=\"" . $item["Price"] . "\">+</button></td>";
          //         echo "</tr>";
          //     }
          // } else {
          //     // If no items found for the category
          //     echo "<tr><td colspan='3'>No items found.</td></tr>";
          // }

          echo "</table>";
          echo "</div>";
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
          addToCart(ItemID, ItemName, Price);
          // Optionally, provide visual feedback to the user
          alert("Item added to cart: " + ItemName + Price + ItemID);
        });
      });

      function addToCart(ItemID, ItemName, Price) {
        // Send an AJAX request to addToCart.php to add the item to the cart
        const xhr = new XMLHttpRequest();
        const url = "addToCart.php";
        const params = `ItemID=${ItemID}&ItemName=${ItemName}&Price=${Price}`;
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
