<?php
session_start();
$login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['Email']) || empty($_POST['Username']) || empty($_POST['Password']) || empty($_POST['Confirm_password'])) {
        $login_err = "Моля, попълнете всички полета!";
    }
    else{
        $Email = $_POST['Email'];
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
        $Confirm_password = $_POST['Confirm_password'];

    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    if ($mysqli->connect_error) {
        echo "Failed to connect to database: " . $mysqli->connect_error;
    }

    if ($Password == $Confirm_password) {
        $Admin = 0;

        $sql = "INSERT INTO profiles (Email, Username, Password, Admin) VALUES ('$Email', '$Username', '$Password', '$Admin')";

        $mysqli -> query($sql);

        header("Location: Login.php");
        exit;
    }
    else {
        echo "Паролите не съвпадат.";
    }
    $mysqli->close();
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="container">
        <h2>Регистрация</h2>
        <?php if (isset($login_err)) { ?>
            <div class="error"><?php echo $login_err; ?></div>
        <?php } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="Email">Имейл:</label>
                <input type="email" id="Email" name="Email">
            </div>
            <div class="form-group">
                <label for="Username">Псевдоним:</label>
                <input type="text" id="Username" name="Username">
            </div>
            <div class="form-group">
                <label for="Password">Парола:</label>
                <input type="password" id="Password" name="Password">
            </div>
            <div class="form-group">
                <label for="Confirm_password">Потвърдете паролата:</label>
                <input type="password" id="Confirm_password" name="Confirm_password">
            </div>
            <div class="form-group">
                <input type="submit" value="Регистиране">
            </div>
        </form>
        <a href="./index.php">Разглеждане като гост</a>
        <p>Имате акаунт? <a id="log" href="Login.php">Вход</a></p>
        <div class="infocheck">
            <input type="checkbox" id="check">
            <label>
                <span id="policy">Съгласявам се с политиката за <a href="Policy.php">Защита на личните данни.</a>* </span>
            </label>
        </div>
    </div>

    <script>
    function validateForm() {
        var checkbox = document.getElementById('check');

        if (!checkbox.checked) {
            alert('Моля, отбележете съгласие с политиката за защита на личните данни.');
            return false;
        }

        return true;
    }
    </script>
</body>
</html>
