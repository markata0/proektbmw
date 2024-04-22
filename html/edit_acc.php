<?php
session_start(); // Start the session

// Establish a database connection
$mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Грешка при свързването с MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_GET['id'])) {
    // Retrieve the user ID from the URL parameter
    $user_id = $_GET['id'];

    // Fetch user details based on the user ID
    $sql = "SELECT * FROM profiles WHERE Id = $user_id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();
        // Display the form to edit user details
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit account</title>
    <link rel="stylesheet" href="../css/edit_accounts.css">
</head>
<body>
    <button onclick="window.location.href='View_acc.php'" class="back-btn">
        <img id="backicon" src="../images/back.png" alt="Back Icon">
        Акаунти
    </button>
    <h2>Редактиране на акаунт</h2>
    <form action="edit.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label>Имейл:</label>
        <input type="text" name="email" value="<?php echo $row['Email']; ?>"><br>
        <label>Псевдоним:</label>
        <input type="text" name="username" value="<?php echo $row['Username']; ?>"><br>
        <label>Парола:</label>
        <input type="password" name="password" value="<?php echo $row['Password']; ?>"><br>
        <input type="submit" value="Запази промените">
    </form>
</body>
</html>
<?php
    } else {
        echo "Потребителят не е намерен.";
    }
} else {
    echo "Не е предоставенo потребителскo ID.";
}

// Close the database connection
$mysqli->close();
?>
