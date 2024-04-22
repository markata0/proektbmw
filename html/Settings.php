<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles Page</title>
</head>
<body>
<link rel="stylesheet" href="../css/view_acc.css">
    <button onclick="goBack()" class="back-btn">
        <img id="backicon" src="../images/back.png" alt="Back Icon">
        Назад
    </button>

    <script>
        function goBack() {
        window.history.back();
        }
    </script>
<?php

// Establish a database connection
$mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Define your SQL query
    $sql = "SELECT Id, Email, Username, Password FROM profiles WHERE Id = $user_id";

    // Execute the query
    $result = $mysqli->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<h2>Настойки на акаунта:</h2>";
        echo "<form method='POST' action='edit.php'>";

        // Fetch associative array
        while ($row = $result->fetch_assoc()) {
            echo "<div class='form-container'>";
            echo "<table>";
            echo "<tr><td><label for='email'>Имейл:</label></td><td><input type='text' name='email' id='email' value='" . $row['Email'] . "'></td></tr>";
            echo "<tr><td><label for='username'>Псевдоним:</label></td><td><input type='text' name='username' id='username' value='" . $row['Username'] . "'></td></tr>";
            echo "<tr><td><label for='password'>Парола:</label></td><td><input type='password' name='password' id='password' value='" . $row['Password'] . "'></td></tr>";
            echo "</table>";
            echo "<a href='edit.php?id=" . $row['Id'] . "'><button id='editBtn'>Запази промените</button></a>";
            echo "</div>";
        }
        echo "</table>";
    } else {
        echo "Няма намерен акаунт.";
    }
} else {
    echo '<p style=color:red;margin-top:300px;font-size:21;><b>Не сте влезли в акаунт.<b></p>';
}

// Close the database connection
$mysqli->close();
?>

</body>
<style>
    p{
        text-align:center;
    }
    #editBtn{
        border-radius:15px;
        padding:10px;
    }
    .form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    }
    td{
        padding:15px;
    }
    input{
        border:1px solid black;
        border-radius:10px;
        padding:10px;
    }
</style>
</html>