<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Retrieve form data
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $comment = $_POST['comment'];

        // Validate form data (you can add more validation)
        if (!empty($product_id) && !empty($comment)) {
            // Perform database operations (assuming you have a database connection)
            $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');
            if ($mysqli->connect_error) {
                die('Грешката при свързването с базата: ' . $mysqli->connect_error);
            }

            // Escape variables for security
            $product_id = $mysqli->real_escape_string($product_id);
            $comment = $mysqli->real_escape_string($comment);

            // Insert the comment into the database
            $sql = "INSERT INTO Comments (user_id, product_id, comment) VALUES ('$user_id', '$product_id', '$comment')";
            if ($mysqli->query($sql) === TRUE) {
                echo "Коментарът е добавен успешно.";
            } else {
                echo "Грешка: " . $sql . "<br>" . $mysqli->error;
            }

            // Close database connection
            $mysqli->close();
        }
    }
} else {
    echo "Невалидна заявка.";
}
?>