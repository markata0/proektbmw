<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles Page</title>
</head>
<body>
<link rel="stylesheet" href="../css/view_acc.css">
<?php
    // Establish a database connection
    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Неуспешно свързване с MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Define your SQL query
    $sql = "SELECT Id, Email, Username, Password, Admin FROM profiles";

    // Execute the query
    $result = $mysqli->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo '<button onclick="window.location.href=\'./index.php\'" class="back-btn">
        <img id="backicon" src="../images/back.png" alt="Back Icon">
        Начало
        </button>';
        echo "<h2>Акаунти:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Id</th><th>Имейл</th><th>Псевдоним</th><th>Парола</th><th>Админ(1-админ, 0-не е админ)</th><th>Действия</th></tr>";
        
        // Fetch associative array
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Id'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['Password'] . "</td>";
            echo "<td>" . $row['Admin'] . "</td>";
            echo "<td><a href='edit_accounts.php?id=" . $row['Id'] . "'><button id='editBtn'>Редактиране</button></a> <a href='delete.php?id=" . $row['Id'] . "'><button id='deleteBtn'>Изтриване</button></a>
                </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Няма намерени акаунти.";
    }

    // Close the database connection
    $mysqli->close();
?>
</body>
</html>

