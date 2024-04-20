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
  </style>
</head>
<body>
  <header>
    <div class="container">
      <h1><a href="#">Desi Kitchen</a></h1>
      <nav>
        <ul>
          <li><a href="#appetizers">Appetizers</a></li>
          <!-- Add links for other categories -->
        </ul>
      </nav>
    </div>
  </header>

  <section class="category" id="appetizers">
    <div class="container">
      <h2>Appetizers</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <?php
        
        include 'connection.php';
        include 'functions.php';
    
        $result = readMenuItem();
        if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
        else {
            echo "<tr><t colspan='4'> No records found. </t></tr>";
        }
        ?>
        <!-- Add more dishes as needed -->
      </table>
    </div>
  </section>

  <!-- Add sections for other categories -->

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