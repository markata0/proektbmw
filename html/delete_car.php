<?php
session_start();

if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
    if (isset($_GET['id'])) {
        $car_id = $_GET['id'];

        // Establish a database connection
        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        // Check for connection errors
        if ($mysqli->connect_error) {
            die('Грешка при свързването с MySQL: ' . $mysqli->connect_error);
        }

        // Construct the delete query
        $sql = "DELETE FROM cars WHERE Id = '$car_id'";

        // Execute the query
        if ($mysqli->query($sql) === TRUE) {
            // Redirect to the previous page after deletion
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            echo "Грешка при изтриването на автомобила: " . $mysqli->error;
        }

        // Close connection
        $mysqli->close();
    } else {
        echo "Не е предоставен идентификатор на автомобил.";
    }
} else {
    echo "Нямате права за достъп до тази страница.";
}
?>