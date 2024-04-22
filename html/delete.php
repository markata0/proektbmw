<?php
// Check if the ID parameter is set and is a valid integer
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Establish a database connection
    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Грешка при свъзрването с MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Prepare a DELETE query to delete the account
    $id = $_GET['id'];
    $sql = "DELETE FROM profiles WHERE Id = $id";

    // Execute the query
    if ($mysqli->query($sql) === TRUE) {
        echo "Акаунтът е изтрит успешно.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Грешка при изтриването на акаунта: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
} else {
    echo "Невалидно ID.";
}
?>
