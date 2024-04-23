<?php
include 'functions.php';
session_start(); // Start or resume a session

if (isset($_POST['OrderItemID'])) {
    // Retrieve the values of OrderID and OrderItemID from the POST request
    $OrderItemID = $_POST['OrderItemID'];
    
    // Call the deleteOrder function with the provided OrderID and OrderItemID
    deleteOrderItem($OrderItemID);

    // Retrieve loggedIn and userID from POST data
    $loggedIn = isset($_POST['loggedIn']) ? $_POST['loggedIn'] : false;
    $userID = isset($_POST['userID']) ? $_POST['userID'] : 0;

    // Display the updated cart
    displayCart($loggedIn, $userID);
} else {
    // Error: Missing parameters
    echo "Missing parameters";
}
?>
