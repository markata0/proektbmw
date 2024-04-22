<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['Admin']) || $_SESSION['Admin'] != 1) {
    echo "Нямате права за достъп до тази страница.";
    exit();
}

// Check if user ID is provided via GET request
if (!isset($_GET['id'])) {
    echo "Не е предоставен идентификатор на акаунта.";
    exit();
}

// Establish a database connection
$mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Неуспешно свързване с MySQL: " . $mysqli->connect_error;
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs to prevent SQL injection
    $email = $mysqli->real_escape_string($_POST['email']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // Update user account details in the database
    $sql = "UPDATE profiles SET Email='$email', Username='$username', Password='$password' WHERE Id={$_GET['id']}";

    // Execute the query
    if ($mysqli->query($sql) === TRUE) {
        echo "<p style=text-align:center;color:green;>Данните на акаунта са успешно обновени.</p>";
        header("refresh:0.5; url=View_acc.php");
    } else {
        echo "Грешка при обновяването на данните на акаунта: " . $mysqli->error;
    }
}

// Fetch user account details based on the provided ID
$sql = "SELECT Id, Email, Username, Password FROM profiles WHERE Id={$_GET['id']}";
$result = $mysqli->query($sql);

// Check if the user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
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
    <form action="" method="POST">
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
    echo "Не може да се намери акаунт с този идентификатор.";
}

// Close the database connection
$mysqli->close();
?>
