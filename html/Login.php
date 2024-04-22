<?php
session_start();
$login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['Email']) || empty($_POST['Password'])) {
        $login_err = "Моля, попълнете всички полета!";
    } else {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    if ($mysqli->connect_error) {
        die("Грешка при свързване с базата данни: " . $mysqli->connect_error);
    }

    $sql = "SELECT Id, Email, Password, Admin FROM profiles WHERE Email = '$Email'";
    $result = $mysqli->query($sql);

    if ($result) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row['Id'];
            $hashed_password = $row['Password'];

            if ($Password == $hashed_password) {
                $_SESSION["loggedin"] = true;
                $_SESSION["email"] = $Email;
                $_SESSION["user_id"] = $user_id;
                $_SESSION["Admin"] = $row['Admin'];

                header("Location: ./index.php");
                exit;
            } else {
                $login_err = "Невалидна парола!";
            }
        } else {
            $login_err = "Потребителят не е намерен!";
        }
    } else {
        echo "Упс! Нещо се обърка. Моля, опитайте отново по-късно.";
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
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <h2>Вписване</h2>
        <?php if (isset($login_err)) { ?>
            <div class="error"><?php echo $login_err; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="Email">Имейл:</label>
                <input type="email" id="Email" name="Email">
            </div>
            <div class="form-group">
                <label for="Password">Парола:</label>
                <input type="password" id="Password" name="Password">
            </div>
            <input type="submit" value="Влизане"><br>
        </form>
        <p>Нямате акаунт? <a href="register.php">Регистриране</a></p>
        <a id="nologin" href="./index.php">Разглеждане като гост</a>
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