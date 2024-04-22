<?php
$mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

if($mysqli -> connect_error){
    echo "Грешка при свързването с базата данни: ".$mysqli -> connect_error;
}

$account_id = $_POST["account_id"];

$sql = "DELETE FROM accounts WHERE id = $account_id AND admin = 'no'";

if ($mysqli->query($sql) === TRUE) {
    header("Location: Settings.php");
} else {
    echo "Failed to remove the registered account: ".$mysqli -> error;
}

$mysqli -> close();
?>