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
function createMenuItem($name, $desc, $url, $price, $status) {
    global $conn;
    $sql = "UPDATE MenuItem SET Username=?, Password=?, Email=?, Name=?, PhoneNumber=? WHERE MenuItemID=?";
    $params = [$name, $desc, $url, $price, $status];

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
    $sql = "SELECT mc.CategoryName, mi.ItemName, mi.Description, mi.Price
            FROM MenuCategory mc
            INNER JOIN MenuItem mi ON mc.CategoryID = mi.CategoryID
            ORDER BY mc.CategoryName";

    return execPreparedStatement($sql, []);
}
?>