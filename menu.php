<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Desi Kitchen</title>
  <link rel="stylesheet" href="menu.css">
</head>
<body>
  <header>
    <h1>Menu</h1>
  </header>
  <table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Pass</th>
        <th>Name</th>
    </tr>
    <?php
        
    include 'connection.php';
    include 'functions.php';

    $result = readCustomer();
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["CustomerID"] ."</td>";
            echo "<td> <a>Update</a> </td>";
            echo "<td> <a onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a> </td>";
            echo "<td>" . $row["Username"] ."</td>";
            echo "<td>" . $row["Password"] ."</td>";
            echo "<td>" . $row["Name"] ."</td>";
            echo "</tr>";
        }
    }
    else {
        echo "<tr><t colspan='4'> No records found. </t></tr>";
    }
    ?>
    </table>
  <section class="category" id="appetizers">
    <h2>Appetizers</h2>
    <div class="dish">
        <img src="appetizer1.jpg" alt="Appetizer 1">
        <h3>Appetizer 1</h3>
        <p>$5.99</p>
    </div>
    <div class="dish">
        <img src="appetizer2.jpg" alt="Appetizer 2">
        <h3>Appetizer 2</h3>
        <p>$6.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>
  
  <section class="category" id="our_special">
    <h2>Our Special</h2>
    <div class="dish">
        <img src="special1.jpg" alt="Special 1">
        <h3>Special 1</h3>
        <p>$12.99</p>
    </div>
    <div class="dish">
        <img src="special2.jpg" alt="Special 2">
        <h3>Special 2</h3>
        <p>$14.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>
  
  <section class="category" id="grills">
    <h2>Grills</h2>
    <div class="dish">
        <img src="grill1.jpg" alt="Grill 1">
        <h3>Grill 1</h3>
        <p>$10.99</p>
    </div>
    <div class="dish">
        <img src="grill2.jpg" alt="Grill 2">
        <h3>Grill 2</h3>
        <p>$11.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>
  
  <section class="category" id="handis">
    <h2>Handis</h2>
    <div class="dish">
        <img src="handi1.jpg" alt="Handi 1">
        <h3>Handi 1</h3>
        <p>$9.99</p>
    </div>
    <div class="dish">
        <img src="handi2.jpg" alt="Handi 2">
        <h3>Handi 2</h3>
        <p>$10.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>
  
  <section class="category" id="rice">
    <h2>Rice</h2>
    <div class="dish">
        <img src="rice1.jpg" alt="Rice 1">
        <h3>Rice 1</h3>
        <p>$4.99</p>
    </div>
    <div class="dish">
        <img src="rice2.jpg" alt="Rice 2">
        <h3>Rice 2</h3>
        <p>$5.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>
  
  <section class="category" id="sweets">
    <h2>Sweets</h2>
    <div class="dish">
        <img src="sweet1.jpg" alt="Sweet 1">
        <h3>Sweet 1</h3>
        <p>$3.99</p>
    </div>
    <div class="dish">
        <img src="sweet2.jpg" alt="Sweet 2">
        <h3>Sweet 2</h3>
        <p>$4.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>
  
  <section class="category" id="drinks">
    <h2>Drinks</h2>
    <div class="dish">
        <img src="drink1.jpg" alt="Drink 1">
        <h3>Drink 1</h3>
        <p>$1.99</p>
    </div>
    <div class="dish">
        <img src="drink2.jpg" alt="Drink 2">
        <h3>Drink 2</h3>
        <p>$2.99</p>
    </div>
    <!-- Add more dishes as needed -->
  </section>

  <footer>
    <p>© 2024 Desi Kitchen. All rights reserved.</p>
  </footer>
</body>
</html>
