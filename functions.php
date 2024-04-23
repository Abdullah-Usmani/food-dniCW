<?php

include 'connection.php';

function execPreparedStatement($sql, $params) {
    global $conn;
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }

    $result = $stmt->execute();

    if ($result) {
        // If successful, get the result set
        $result = $stmt->get_result();
    } else {
        // If unsuccessful, return false
        $result = false;
    }

    // Close the statement
    $stmt->close();

    // Return the result
    return $result;
}
function createCustomer($user, $pass, $email, $name, $number) {
    global $conn;
    $sql = "INSERT INTO Customer (Username, Password, Email, Name, PhoneNumber) VALUES (?, ?, ?, ?, ?)";
    $params = [$user, $pass, $email, $name, $number];

    return execPreparedStatement($sql, $params);
}
function readCustomer() {
    global $conn;
    $sql = "SELECT * FROM Customer";
    return execPreparedStatement($sql, []);
}
function updateCustomer($id, $user, $pass, $email, $name, $number) {
    global $conn;
    $sql = "UPDATE Customer SET Username=?, Password=?, Email=?, Name=?, PhoneNumber=? WHERE CustomerID=?";
    $params = [$user, $pass, $email, $name, $number, $id];
    
    return execPreparedStatement($sql, $params);
}
function deleteCustomer($id) {
    global $conn;
    $sql = "DELETE FROM Customer WHERE CustomerID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}

function loginCustomer($username, $password) {
    global $conn;
    $sql = "SELECT * FROM Customer WHERE Username = ? AND Password = ?";
    $params = [$username, $password];
    return execPreparedStatement($sql, $params);
}

// MENU STUFF
function createMenuItem($catid, $name, $desc, $url, $price, $status) {
    global $conn;
    $sql = "INSERT INTO MenuItem (CategoryID, ItemName, Description, ImageURL, Price, AvailabilityStatus) VALUES (?, ?, ?, ?, ?, ?)";
    $params = [$catid, $name, $desc, $url, $price, $status];

    return execPreparedStatement($sql, $params);
}
function readMenuItem() {
    global $conn;
    $sql = "SELECT * FROM MenuItem";
    return execPreparedStatement($sql, []);
}
function updateMenuItem($id, $name, $desc, $url, $price, $status) {
    global $conn;
    $sql = "UPDATE MenuItem SET ItemName=?, Description=?, ImageURL=?, Price=?, AvailabilityStatus=? WHERE ItemID=?";
    $params = [$name, $desc, $url, $price, $status];

    return execPreparedStatement($sql, $params);
}
function deleteMenuItem($id) {
    global $conn;
    $sql = "DELETE FROM MenuItem WHERE MenuItemID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}

// CATEGORIES STUFF
function readMenuCategories() {
    global $conn;
    $sql = "SELECT * FROM MenuCategory";
    return execPreparedStatement($sql, []);
}

function readMenuItemByCategories() {
    global $conn;
    // SQL query to retrieve menu items grouped by categories
    $sql = "SELECT * FROM MenuItem WHERE MenuItem";
    
    return execPreparedStatement($sql, []);
}

// ORDER/CART STUFF
function createOrders($customerid, $datetime, $price, $status) {
    global $conn;
    $sql = "INSERT INTO Orders (CustomerID, OrderDateTime, Price, OrderStatus) VALUES (?, ?, ?, ?)";
    $params = [$customerid, $datetime, $price, $status];

    return execPreparedStatement($sql, $params);
}
function readOrders() {
    global $conn;
    $sql = "SELECT * FROM Orders";
    return execPreparedStatement($sql, []);
}

// Update CART --> ORDERED, PRICE --> PRICE, DATE --> DATE
function updateOrders($id, $customerid, $datetime, $price, $status) {
    global $conn;
    $sql = "UPDATE Orders SET CustomerID=?, OrderDateTime=?, Price=?, OrderStatus=? WHERE OrderID=?";
    $params = [$customerid, $datetime, $price, $status, $id];
    
    return execPreparedStatement($sql, $params);
}
function deleteOrders($id) {
    global $conn;
    $sql = "DELETE FROM Orders WHERE OrderID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}

// ORDER/CART STUFF
function createOrderItem($orderid, $itemid) {
    global $conn;
    $sql = "INSERT INTO OrderItem (OrderID, ItemID) VALUES (?, ?)";
    $params = [$orderid, $itemid];

    return execPreparedStatement($sql, $params);
}
function readOrderItem() {
    global $conn;
    $sql = "SELECT * FROM OrderItem";
    return execPreparedStatement($sql, []);
}

// Update CART --> ORDERED, PRICE --> PRICE, DATE --> DATE
function updateOrderItem($id,$orderid, $itemid) {
    global $conn;
    $sql = "UPDATE OrderItem SET OrderID=?, ItemID=?, WHERE OrderItemID=?";
    $params = [$orderid, $itemid, $id];
    
    return execPreparedStatement($sql, $params);
}
function deleteOrderItem($id) {
    global $conn;
    $sql = "DELETE FROM OrderItem WHERE OrderItemID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}
function displayCart($loggedIn, $userID) {

    // Initialize variables for subtotal and total amount
    $subTotal = 0;
    $taxRate = 0.10; // Assuming 10% tax rate
    $shippingCost = 5; // Assuming a fixed shipping cost
    $totalAmount = 0;

    // Check if the cart session variable exists
    if(isset($_SESSION['cart'])) {
        // Initialize an array to store unique item IDs and their quantities
        $uniqueItems = array();
        
        // Iterate over each item in the cart
        foreach($_SESSION['cart'] as $item) {
            // Add the item to the uniqueItems array or update its quantity
            $itemID = $item['ItemID'];
            if(isset($uniqueItems[$itemID])) {
                $uniqueItems[$itemID]['Quantity']++;
            } else {
                $uniqueItems[$itemID] = array(
                    'ItemName' => $item['ItemName'],
                    'Price' => $item['Price'],
                    'Quantity' => 1
                );
            }
            
            // Calculate the subtotal for each item (price * quantity)
            $subTotal += $item['Price'];
        }
        // Calculate tax amount
        $tax = $subTotal * $taxRate;

        // Calculate total amount (subtotal + tax + shipping)
        $totalAmount = $subTotal + $tax + $shippingCost;
    }

    // Display cart items
    if($loggedIn) {
        $result1 = readOrders();
        if ($result1 !== false && $result1->num_rows > 0) {
            $foundItems = false; // Flag to indicate if any items were found in the cart
            while ($row1 = $result1->fetch_assoc()) {
                if ($row1["CustomerID"] == $userID) {
                    $result2 = readOrderItem();
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row2["OrderID"] == $row1["OrderID"]) {
                            $result3 = readMenuItem();
                            if ($result3 !== false && $result3->num_rows > 0) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    if ($row3["ItemID"] == $row2["ItemID"]) {
                                        // Display item details
                                        $foundItems = true; // Set flag to true
                                        echo '<div class="cart-item">';
                                        echo '<img src="food.jpg" alt="' . $row3['ItemName'] . '">';
                                        echo '<div class="item-details">';
                                        echo '<h2>' . $row3['ItemName'] . '</h2>';
                                        echo '<p>OrderID: ' . $row2['OrderID'] . '</p>';
                                        echo '<p>OrderItemID: ' . $row2['OrderItemID'] . '</p>';
                                        echo '<p>CustomerID: ' . $row1['CustomerID'] . '</p>';
                                        echo '<p>Price: $' . $row3['Price'] . '</p>';
                                        echo "<button class=\"remove-from-cart\" data-orderitemid=\"" . $row2["OrderItemID"] . "\"data-itemname=\"" . $row3["ItemName"] . "\"data-loggedin=\"" . $loggedIn . "\"data-userid=\"" . $userID . "\"data-uniqueitems=\">-</button>";
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // If no items were found in the cart, display error message
            if (!$foundItems) {
                echo '<div class="cart-item">';
                echo '<p>Your cart is empty.</p>';
                echo '</div>';
            }
            }
        }


        else {
            if(isset($_SESSION['cart'])) {
                foreach($uniqueItems as $itemID => $item) {
                    echo '<div class="cart-item">';
                    echo '<img src="food.jpg" alt="' . $item['ItemName'] . '">';
                    echo '<div class="item-details">';
                    echo '<h2>' . $item['ItemName'] . '</h2>';
                    echo '<p>Quantity: ' . $item['Quantity'] . '</p>';
                    echo '<p>Price: $' . $item['Price'] . ' each</p>';
                    echo '</div>';
                    echo '</div>';
                }
                }
            else {
                // Display message if cart is empty
                echo '<div class="cart-item">';
                echo '<p>Your cart is empty.</p>';
                echo '</div>';
            } 
        }
    }

?>