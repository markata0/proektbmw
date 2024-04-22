<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        if ($mysqli->connect_error) {
            die('Грешка в мрежата: ' . $mysqli->connect_error);
        }

        $user_id = $mysqli->real_escape_string($user_id);

        $sql = "DELETE FROM cart WHERE user_id = '$user_id'";

        if ($mysqli->query($sql) === TRUE) {
            $mysqli->close();
            header("Location: display_cart.php");
            exit();
        } else {
            echo "Грешка: " . $sql . "<br>" . $mysqli->error;
            $mysqli->close();
        }
    } else {
        header("Location: display_cart.php");
        exit();
    }
} else {
    header("Location: display_cart.php");
    exit();
}
?>