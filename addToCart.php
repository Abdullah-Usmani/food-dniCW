<?php
include 'functions.php';
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

    
    $currentDateTime = date('Y-m-d H:i:s');
    
    if (isset($_SESSION["user_id"])) {
        // Retrieve the user ID from the session
        $userID = $_SESSION["user_id"];
        
        // Add the item to the cart (you'll need to implement this function in functions.php)
        // $result = addToCart($userID, $ItemID, $ItemName, $Price);
        // SET NEW PRICE
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
    }
                                    // else {
                                        //     // add items to session cart
                                        //     // if login, add session items to user cart    ||    cant add to cart unless logged in 
                                        //     $result = addToCart($userID, $ItemID, $ItemName, $Price);
    // }

    // Return success response
    echo "Item added to cart: ID = $itemID, Name = $itemName, Price = $price";
} 

else {
    // Return error response if item details are not received
    echo "Error: Item details not received.";
}
?>
