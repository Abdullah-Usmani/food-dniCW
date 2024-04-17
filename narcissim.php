<?php
include 'connection.php';

function execQuery($sql) {
    global $conn;
    $result = $conn->query($sql);
    return $result;
}

$sql = "SELECT * FROM Customer";
$result = execQuery($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Customer ID: ".$row["CustomerID"]." - Username: ".$row["Username"]." - Email: ".$row["Email"]."<br>";
    }
}
else {
    echo "NO RESULTS FOUND.";
}

?>