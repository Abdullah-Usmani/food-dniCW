

<?php

function createCustomer($user, $pass, $email, $name, $number) {
    $sql = "INSERT INTO Customer (Username, Password, Email, Name, PhoneNumber) VALUES (?, ?, ?, ?, ?)";
    $params = [$user, $pass, $email, $name, $number];

    $result = execPreparedStatement($sql, $params);

    echo "<br>";

    if ($result) {
        echo "<br>";
        echo "Customer added successfully";
    }
    else {
        echo "Failed to add customer.";
    }
}
function readCustomer() {
    $sql = "SELECT * FROM Customer";
    return execPreparedStatement($sql, []);
}
function updateCustomer($id, $user, $pass, $email, $name, $number) {
    $sql = "UPDATE Customer SET Username=?, Password=?, Email=?, Name=?, PhoneNumber=? WHERE CustomerID=?";
    $params = [$user, $pass, $email, $name, $number, $id];
    
    $result = execPreparedStatement($sql, $params);
    
    echo "<br>";
    
    if ($result) {
        echo "<br>";
        echo "Customer UPDATED successfully";
    }
    else {
        echo "Failed to UPDATE customer.";
    }
}
function deleteCustomer($id) {
    $sql = "DELETE FROM Customer WHERE CustomerID=?";
    $params = [$id];
    return execPreparedStatement($sql, $params);
}


?>