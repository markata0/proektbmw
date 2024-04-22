<?php
session_start();

    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    $editType = $_POST['editType'];
    $quantity = $_POST['Quantity'];
    $id = $_POST['id'];

    if ($editType == 'add') {
        $quantity += 1;
    } else {
        $quantity -= 1;
    }

    if ($quantity <= 0) {
        $removeFromCart = "DELETE FROM cart WHERE id = $id";
        $mysqli->query($removeFromCart);
    }

    $editQuantity = "UPDATE cart SET Quantity = '$quantity'
        WHERE id = '$id'";
    $mysqli->query($editQuantity);
    
    header("Location: display_cart.php");
    exit();
?>