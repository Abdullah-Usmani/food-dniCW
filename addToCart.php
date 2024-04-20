<?php
session_start(); // Start or resume a session

// Check if item details are received
if(isset($_POST['ItemID'], $_POST['ItemName'], $_POST['Price'])) {
    // Extract item details from the POST request
    $itemID = $_POST['ItemID'];
    $itemName = $_POST['ItemName'];
    $price = $_POST['Price'];

    // Create a new item array
    $item = array(
        'ItemID' => $itemID,
        'ItemName' => $itemName,
        'Price' => $price
    );

    // Check if the cart session variable exists
    if(!isset($_SESSION['cart'])) {
        // If cart session variable doesn't exist, create an empty array
        $_SESSION['cart'] = array();
    }

    // Add the item to the cart session variable
    $_SESSION['cart'][] = $item;

    // Return success response
    echo "Item added to cart: ID = $itemID, Name = $itemName, Price = $price";
} else {
    // Return error response if item details are not received
    echo "Error: Item details not received.";
}
?>
