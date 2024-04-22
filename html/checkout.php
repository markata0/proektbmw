<?php
    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');   
    session_start();

    $userId = $_SESSION['user_id'];
    $name = $_POST['Name'];
    $address = $_POST['Address'];
    $city = $_POST['City'];
    $Zip = $_POST['Zip'];
    $Payment = $_POST['Payment'];

    $getCart = "SELECT * FROM cart WHERE user_id = '$userId'";
    $cart = $mysqli->query($getCart);

    $description = '';
    while ($row = $cart->fetch_assoc()) {
        $productId = $row['product_id'];
        $getProduct = "SELECT Model FROM cars WHERE id = '$productId'";
        $result = $mysqli->query($getProduct);
        $product = $result->fetch_assoc();

        $description .= $product['model'] . ' Брой: ' . $row['quantity'] . '\n';
    }

    $createOrder = "INSERT INTO orders
        (user_id, User_name, City, Address, Zip_code, Description, Payment_method)
        VALUES ('$userId', '$name', '$city', '$address', '$zip', '$description', '$payment')";
    $mysqli->query($createOrder);

    if ($payment == 'Наложен платеж') {
        include('clearcart.php');

        header('Location: ../cash.php');
        exit;
    }

    header('Location: Stripe.php');
?>