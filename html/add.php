<?php
    $Model = isset($_POST['Model']) ? $_POST['Model'] : '';
    $Horse_Power = isset($_POST['Horse_Power']) ? $_POST['Horse_Power'] : '';
    $Acceleration = isset($_POST['Acceleration']) ? $_POST['Acceleration'] : '';
    $Fuel_consumption = isset($_POST['Fuel_consumption']) ? $_POST['Fuel_consumption'] : '';
    $Mileage = isset($_POST['Mileage']) ? $_POST['Mileage'] : '';
    $Price = isset($_POST['Price']) ? $_POST['Price'] : '';
    $Image_Direction = isset($_POST['Image_Direction']) ? $_POST['Image_Direction'] : '';
    $Fuel = isset($_POST['Fuel']) ? $_POST['Fuel'] : '';

        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        if($mysqli -> connect_error){
                echo "Грешка при свързването с базата данни: " . $mysqli -> connect_error;
        }

        $sql = "INSERT INTO cars (Model, Horse_Power, Acceleration, Fuel_consumption, Mileage, Price, Image_Direction, Fuel)
                VALUES ('$Model', '$Horse_Power', '$Acceleration', '$Fuel_consumption', '$Mileage', '$Price', '$Image_Direction', '$Fuel')";

        if ($mysqli->query($sql) === TRUE) {
                echo "Новият продукт е добавен";
        } else {
                echo "Грешка: " . $sql . "<br>" . $mysqli->error;
        }

        header("Location: Products.php");
        $mysqli -> close();
?>