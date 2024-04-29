<?php
include 'functions.php';
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&family=The+Nautigal:wght@400;700&display=swap" rel="stylesheet">
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
      <a href="menu.php"><img src="images/home.png" alt="Menu" class="black-icon" id="menu-icon"></a> <!-- Menu Icon -->
      <a href="cart.php"><img src="images/cart.png" alt="Cart" class="black-icon" id="cart-icon"></a> <!-- Cart Icon -->
      <a href="status.php"><img src="images/orderstatus.png" alt="Order Status" class="black-icon" id="status-icon"></a> <!-- Order Status Icon -->
      <!-- Login / Logout Icon -->
      <?php
      // Display USERID & Logout button if logged in, else display USER NOT LOGGED IN & Login button
      if (isset($_SESSION["user_id"])) {
          $userID = $_SESSION["user_id"];
          $result = readCustomer();
          if ($result !== false && $result->num_rows > 0) {
            $loggedIn = true;
              while ($row = $result->fetch_assoc()) {
                  if ($row["CustomerID"] == $userID) {
                    echo "<a href='logout.php'><img src='images/login.png' alt='Logout' class='black-icon' id='logout-icon'></a>";
                    echo "<p>". $row["Username"]." ID - ".$row["CustomerID"] . "</p>";
                  }
                }
          }
          else {
            echo "<a href='signup.php'><img src='images/login.png' alt='Login' class='black-icon' id='login-icon'></a>";
            echo "<p>User Not Logged In</p>";
          }
        }
        else {
          echo "<a href='signup.php'><img src='images/login.png' alt='Login' class='black-icon' id='login-icon'></a>";
          echo "<p>User Not Logged In</p>";
      }
      ?>

    </div>
  </header>

  <hr>

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
            $itemCount = 0;
            echo "<div class='product-container carousel-container'>"; // Open the carousel-container here
            echo "<div class='carousel'>"; // Open the carousel here

            while ($row = $result->fetch_assoc()) {
                if ($row["CategoryID"] == $category["CategoryID"]) {
                    echo "<div class='menu-item'>";
                    echo "<img src='" . $row["ImageURL"] . "' alt='" . $row["ItemName"] . "' width='300' height='200' />";
                    echo "<h3><span class='item-name'>" . $row["ItemName"] . "</span></h3>";
                    echo "<p>" . $row["Description"] . "</p>";
                    echo "<p><span class='item-price'>$" . $row["Price"] . "</span></p>";
                    echo "<div class='add-to-cart-container'>"; // Add this line
                    echo "<button class=\"add-to-cart\" data-itemid=\"" . $row["ItemID"] . "\" data-itemname=\"" . $row["ItemName"] . "\" data-price=\"" . $row["Price"] . "\" data-imageurl=\"" . $row["ImageURL"] . "\">+</button>";
                    echo "</div>"; // Add this line
                    echo "</div>";
                    $itemCount++;
                }
            }

          echo "</div>"; // Close carousel
          echo "</div>"; // Close product-container
          // Add previous and next buttons with images for each category
          echo "<div class='button-container'>";
          echo "<button class='prev'><img src='images/previous.png' alt='Previous'></button>";
          echo "<button class='next'><img src='images/next.png' alt='Next'></button>";
          echo "</div>"; // Close button-container
        } else {
          echo "<p>No records found.</p>";
      }

      echo "</div>"; // Close the container
      echo "</section>";

      if ($category !== end($category)) {
          echo "<hr>"; // Add hr break after each category except the last one
      }
    }
  }
    else {
      // If no categories found
      echo "<section class='category'>";
      echo "<div class='container'>";
      echo "<h2>No categories found.</h2>";
      echo "</div>";
      echo "</section>";
  }
  ?>

  <footer>
    <div class="footer-container">
      <p>© 2024 Desi Kitchen. All rights reserved.</p>
    </div>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Select all carousel containers
      var carousels = document.querySelectorAll('.carousel-container');

      // Loop through each carousel
      carousels.forEach(function(carousel) {
        // Select carousel and items
        var carouselEl = carousel.querySelector('.carousel');
        var items = carousel.querySelectorAll('.menu-item');
        
        // Set initial index and item width
        var currentIndex = 0;
        var itemWidth = items[0].offsetWidth + parseInt(window.getComputedStyle(items[0]).marginRight);

        // Set width of carousel based on number of items
        carouselEl.style.width = itemWidth * items.length + 'px';

        // Function to handle moving carousel
        function moveCarousel(index) {
          // Calculate translateX value to move carousel
          var translateX = -index * itemWidth;
          carouselEl.style.transform = 'translateX(' + translateX + 'px)';
          currentIndex = index;
          console.log('Current index:', currentIndex); // Log current index
        }

        // Move carousel to display the leftmost item first
        moveCarousel(-1.5);

        // Add event listeners for previous and next buttons within the carousel's parent
        var prevButton = carousel.parentElement.querySelector('.prev'); // Get the previous button within the parent element
        var nextButton = carousel.parentElement.querySelector('.next'); // Get the next button within the parent element

        prevButton.addEventListener('click', function() {
          console.log('Previous button clicked');
          if (currentIndex > -1.5) {
            moveCarousel(currentIndex - 1);
          }
    });
    nextButton.addEventListener('click', function() {
      console.log('Next button clicked');
      if (currentIndex < items.length - 3) { // Change condition to prevent going beyond the last item
        moveCarousel(currentIndex + 1);
      }
    });
  });
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