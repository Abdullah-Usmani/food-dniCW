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

// CUSTOMERS CRUD
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

// Function for deleting account
function deleteCustomer($id) {
    global $conn;
    $sql = "DELETE FROM Customer WHERE CustomerID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}

// Used during login, returns true if the inputted user & pass are correct
function loginCustomer($username, $password) {
    global $conn;
    $sql = "SELECT * FROM Customer WHERE Username = ? AND Password = ?";
    $params = [$username, $password];
    return execPreparedStatement($sql, $params);
}

// MENU INDIVIDUAL ITEMS CRUD
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

// CATEGORIES CRUD
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

// ORDER/CART CRUD
function createOrders($customerid, $datetime, $price, $status) {
    global $conn;
    $sql = "INSERT INTO Orders (CustomerID, OrderDateTime, Price, OrderStatus) VALUES (?, ?, ?, ?)";
    $params = [$customerid, $datetime, $price, $status];

    return execPreparedStatement($sql, $params);
}
function readOrders($direction = "ASC") {
    global $conn;
    $sql = "SELECT * FROM Orders ORDER BY OrderID $direction";
    return execPreparedStatement($sql, []);
}

function updateOrders($id, $customerid, $datetime, $price, $status) {
    global $conn;
    $sql = "UPDATE Orders SET CustomerID=?, OrderDateTime=?, Price=?, OrderStatus=? WHERE OrderID=?";
    $params = [$customerid, $datetime, $price, $status, $id];
    
    return execPreparedStatement($sql, $params);
}

// WHEN STATUS SET TO 1 - CHANGES FROM ACTING AS A CART INTO A ORDER RECEIPT
function sendOrders($id, $status) {
    global $conn;
    $sql = "UPDATE Orders SET OrderStatus=? WHERE OrderID=?";
    $params = [$status, $id];
    
    return execPreparedStatement($sql, $params);
}
function deleteOrders($id) {
    global $conn;
    $sql = "DELETE FROM Orders WHERE OrderID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}

// ORDER INDIVIDUAL ITEMS CRUD
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
// PAYMENT CRUD
function createCardPayment($orderid, $customerid, $price, $method, $cardNumber, $expiryDate, $cvv) {
    global $conn;
    $sql = "INSERT INTO Payment (OrderID, CustomerID, Price, PaymentMethod, CardNumber, ExpiryDate, CVV) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = [$orderid, $customerid, $price, $method, $cardNumber, $expiryDate, $cvv];
    unset($_SESSION['order_id']); // Remove OrderID from session
    header('Location: status.php'); // Redirect to success page
    return execPreparedStatement($sql, $params);
}

// SPECIAL FUNCTION FOR IF A USER LOGS IN, AND THERE ARE ITEMS IN THE SESSION CART, ADD THEM TO USER'S CART AFTER LOGIN
function tempToCart($userID, $itemID, $itemName, $price) {
    global $conn;
    
    $currentDateTime = date('Y-m-d H:i:s');
    
    $statusZeroFound1 = false;
    $foundOrderID = 0;
    $result = readOrders("DESC");
    if ($result !== false && $result->num_rows > 0) {
        while (($row = $result->fetch_assoc()) && !$statusZeroFound1) {
            if ($row["CustomerID"] == $userID && $row["OrderStatus"] == 0) {
                $foundOrderID = $row["OrderID"];
                $statusZeroFound1 = true;
            }
        }
        if ($statusZeroFound1) {
            updateOrders($foundOrderID, $userID, $currentDateTime, $price, 0);
            createOrderItem($foundOrderID, $itemID);
        }
        else {
            createOrders($userID, $currentDateTime, $price, 0);
            $temp = readOrders("DESC");
            if ($temp !== false && $temp->num_rows > 0) {
                while (($temprow = $temp->fetch_assoc())) {
                    if ($temprow["CustomerID"] == $userID && $temprow["OrderStatus"] == 0) {
                        createOrderItem($temprow["OrderID"], $itemID);
                    }
                } 
            }
        }
    }
        
    // if no ORDER exists at all
    else {
        createOrders($userID, $currentDateTime, $price, 0);
        $temp = readOrders("DESC");
        if ($temp !== false && $temp->num_rows > 0) {
                while ($temprow = $temp->fetch_assoc()) {
                        if ($temprow["CustomerID"] == $userID && $temprow["OrderStatus"] == 0) {
                                createOrderItem($temprow["OrderID"], $itemID);
                        }
                }
        }
    }
echo "Item added to cart: ID = $itemID, Name = $itemName, Price = $price";
}
?>