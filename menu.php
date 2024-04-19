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
          <li><a href="#our_special">Our Special</a></li>
          <li><a href="#grills">Grills</a></li>
          <li><a href="#handis">Handis</a></li>
          <li><a href="#rice">Rice</a></li>
          <li><a href="#sweets">Sweets</a></li>
          <li><a href="#drinks">Drinks</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="category" id="appetizers">
    <div class="container">
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
            echo "<td><button class=\"add-to-cart\">+</button></td>";            echo "</tr>";
            echo "</table>";
        }
    }
    else {
        echo "<tr><t colspan='4'> No records found. </t></tr>";
    }
    ?>
      <h2>Appetizers</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Appetizer 1</td>
          <td>$5.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Appetizer 2</td>
          <td>$6.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <!-- Add more dishes as needed -->
      </table>
    </div>
  </section>

  <section class="category" id="our_special">
    <div class="container">
      <h2>Our Special</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Special 1</td>
          <td>$12.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Special 2</td>
          <td>$14.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <!-- Add more dishes as needed -->
      </table>
    </div>
  </section>

  <!-- Add sections for other categories -->
  
  <!-- <section class="category" id="grills">
    <div class="container">
      <h2>Grills</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Grill 1</td>
          <td>$10.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Grill 2</td>
          <td>$11.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
      </table>
    </div>
  </section>

  <section class="category" id="handis">
    <div class="container">
      <h2>Handis</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Handi 1</td>
          <td>$9.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Handi 2</td>
          <td>$10.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
      </table>
    </div>
  </section>

  <section class="category" id="rice">
    <div class="container">
      <h2>Rice</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Rice 1</td>
          <td>$4.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Rice 2</td>
          <td>$5.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
      </table>
    </div>
  </section>

  <section class="category" id="sweets">
    <div class="container">
      <h2>Sweets</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Sweet 1</td>
          <td>$3.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Sweet 2</td>
          <td>$4.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
      </table>
    </div>
  </section>

  <section class="category" id="drinks">
    <div class="container">
      <h2>Drinks</h2>
      <table>
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>Drink 1</td>
          <td>$1.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
        <tr>
          <td>Drink 2</td>
          <td>$2.99</td>
          <td><button class="add-to-cart">+</button></td>
        </tr>
      </table>
    </div>
  </section> -->

  <footer>
    <div class="container">
      <p>© 2024 Desi Kitchen. All rights reserved.</p>
    </div>
  </footer>

  <div id="menu-popup">
    <ul>
      <li><a href="#appetizers">Appetizers</a></li>
      <li><a href="#our_special">Our Special</a></li>
      <li><a href="#grills">Grills</a></li>
      <li><a href="#handis">Handis</a></li>
      <li><a href="#rice">Rice</a></li>
      <li><a href="#sweets">Sweets</a></li>
      <li><a href="#drinks">Drinks</a></li>
    </ul>
  </div>

  <script>
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("menu-popup").classList.add("show-popup");
      } else {
        document.getElementById("menu-popup").classList.remove("show-popup");
      }
    }
  </script>
</body>
</html>
