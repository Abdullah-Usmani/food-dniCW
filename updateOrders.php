<?php
include 'functions.php';
session_start(); // Start or resume a session

// Check if item details are received
if(isset($_POST['OrderID'])) {
    $OrderID = $_POST['OrderID'];
    sendOrders($OrderID, 1);
    echo "Item added to cart: ID = $itemID, Name = $itemName, Price = $price";
} 

else {
    // Return error response if item details are not received
    echo "Error: Item details not received.";
}
?>
