<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = $_POST['Id'];

    // Checking for user information in the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Initializing the database connection
        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        // Checking for database connection
        if ($mysqli->connect_error) {
            die('Грешка в мрежата: ' . $mysqli->connect_error);
        }

        // Checking if the product already exists in the cart
        $sql_check = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result_check = $mysqli->query($sql_check);

        if ($result_check->num_rows > 0) {
            // If the product already exists in the cart, redirect back to the previous page
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            // If the product doesn't exist in the cart, proceed to add it
            $image_direction = $_POST['Image_Direction'];
            $model = $_POST['Model'];
            $hp = $_POST['Horse_Power'];
            $acceleration = $_POST['Acceleration'];
            $fuel_consumption = $_POST['Fuel_consumption'];
            $mileage = $_POST['Mileage'];
            $fuel = $_POST['Fuel'];
            $price = $_POST['Price'];
            $quantity = 1;

            // Constructing the SQL statement to add the product to the "cart" table
            $sql_insert = "INSERT INTO cart (user_id, product_id, Image_Direction, Model, Horse_Power, Acceleration, Fuel_consumption, Mileage, Fuel, Price, Quantity) 
                VALUES ('$user_id', '$product_id', '$image_direction', '$model', '$hp', '$acceleration', '$fuel_consumption', '$mileage', '$fuel', '$price', '$quantity')";

            // Executing the SQL statement
            if ($mysqli->query($sql_insert) === TRUE) {
                // Redirecting back to the previous page after successful addition
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                echo "Грешка: " . $sql_insert . "<br>" . $mysqli->error;
            }
        }

        // Closing the database connection
        $mysqli->close();
    } else {
        // Redirecting to an error page in case of missing user information in the session
        header("Location: error.php");
        exit();
    }
} else {
    // Handling invalid requests
    header("Location: error.php");
    exit();
}
?>