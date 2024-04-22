<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Establish a database connection
    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Грешка при свързването с MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Check if form data is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize form inputs to prevent SQL injection
        $email = $mysqli->real_escape_string($_POST['email']);
        $username = $mysqli->real_escape_string($_POST['username']);
        $password = $mysqli->real_escape_string($_POST['password']);

        // Retrieve user ID from session
        $user_id = $_SESSION['user_id'];

        // Define your SQL query to update the user profile
        $sql = "UPDATE profiles SET Email='$email', Username='$username', Password='$password' WHERE Id='$user_id'";

        // Execute the query
        if ($mysqli->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Профилът е обновен успешно.";
            header("refresh:0.5; url=../html/Settings.php");
            exit();
        } else {
            echo "Грешка при обновяването на профила: " . $mysqli->error;
        }
    } else {
        echo "Няма предоставени данни.";
    }

    // Close the database connection
    $mysqli->close();
} else {
    echo "Не сте влезли в акаунт.";
}
?>
