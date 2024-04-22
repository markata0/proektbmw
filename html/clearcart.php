<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $mysqli = new mysqli('localhost', 'root', '', 'proekt');

    if ($mysqli->connect_error) {
        die('Грешка в мрежата: ' . $mysqli->connect_error);
    }

    $sql = "DELETE FROM cart WHERE id = '$id'";

    // Executing the SQL statement
    if ($mysqli->query($sql) === TRUE) {
        header("Location: display_cart.php");
        exit();
    } else {
        echo "Грешка: " . $sql . "<br>" . $mysqli->error;
    }

    $mysqli->close();

} else {
    header("Location: display_cart.php");
    exit();
}
?>
