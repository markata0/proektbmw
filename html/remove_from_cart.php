<?php
session_start();

// Check if the product_id is provided and is valid
if(isset($_GET['product_id']) && !empty($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Check if the product exists in the cart
    if (($key = array_search($product_id, $_SESSION['cart'])) !== false) {
        // Remove the product from the cart
        unset($_SESSION['cart'][$key]);
        // Optionally, you can redirect the user back to the cart page or any other page
        header("Location: display_cart.php");
        exit();
    }
}

// If product_id is not provided or not found in the cart, redirect to cart page
header("Location: display_cart.php");
exit();
?>
