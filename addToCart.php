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

        if (isset($_SESSION["user_id"])) {
        // Retrieve the user ID from the session
        $userID = $_SESSION["user_id"];

        // Add the item to the cart (you'll need to implement this function in functions.php)
        $result = addToCart($userID, $ItemID, $ItemName, $Price);
        // if order exists under this CustomerID that hasnt been ordered {
            // updateOrders(
        // else order doesnt exist under this CustomerID that has not been ordered,{
            // createOrders()  
        }
        else {
            $result = addToCart($userID, $ItemID, $ItemName, $Price);
        }

    // Return success response
    echo "Item added to cart: ID = $itemID, Name = $itemName, Price = $price";
} else {
    // Return error response if item details are not received
    echo "Error: Item details not received.";
}
?>
