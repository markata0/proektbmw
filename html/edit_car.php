<?php
session_start(); 

if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
    $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

    // Check for connection errors
    if ($mysqli->connect_error) {
        echo "Грешка при свързването с MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Check if car ID is provided via GET request
    if (isset($_GET['id'])) {
        $car_id = $mysqli->real_escape_string($_GET['id']);

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize form inputs to prevent SQL injection
            $model = $mysqli->real_escape_string($_POST['model']);
            $horse_power = $mysqli->real_escape_string($_POST['horse_power']);
            $acceleration = $mysqli->real_escape_string($_POST['acceleration']);
            $fuel_consumption = $mysqli->real_escape_string($_POST['fuel_consumption']);
            $mileage = $mysqli->real_escape_string($_POST['mileage']);
            $price = $mysqli->real_escape_string($_POST['price']);
            $fuel = isset($_POST['Fuel']) ? $mysqli->real_escape_string($_POST['Fuel']) : ''; // Check if fuel is set
            // Query to update car details
            $sql = "UPDATE cars SET Model='$model', Horse_Power='$horse_power', Acceleration='$acceleration', Fuel_consumption='$fuel_consumption', Mileage='$mileage', Price='$price', Fuel='$fuel' WHERE Id='$car_id'";

            // Execute the query
            if ($mysqli->query($sql) === TRUE) {
                echo "<p id='success-message'>Промените са запазени успешно.</p>";
                header("refresh:0.7; url=add_to_base.php");
                exit();
            } else {
                echo "Грешка при запазването на промените: " . $mysqli->error;
            }
        }

        // Query to fetch car details
        $sql = "SELECT * FROM cars WHERE Id='$car_id'";
        $result = $mysqli->query($sql);

        // Check if the car exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the car details in a form for editing
            echo '<form action="" method="POST">';
            echo '<input type="hidden" name="car_id" value="'. $row['Id'] . '">';
            echo 'Модел: <input type="text" name="model" value="' . $row['Model'] . '"><br>';
            echo 'Мощност: <input type="text" name="horse_power" value="' . $row['Horse_Power'] . '"><br>';
            echo 'Ускорение: <input type="text" name="acceleration" value="' . $row['Acceleration'] . '"><br>';
            echo 'Разход на гориво: <input type="text" name="fuel_consumption" value="' . $row['Fuel_consumption'] . '"><br>';
            echo 'Пробег: <input type="text" name="mileage" value="' . $row['Mileage'] . '"><br>';
            echo 'Цена: <input type="text" name="price" value="' . $row['Price'] . '"><br>';
            echo 'Гориво: <select name="Fuel" id="Fuel" class="">
                <option value="" selected="" disabled="">Гориво</option>
                <option value="Газ"' . ($row['Fuel'] == 'Газ' ? ' selected' : '') . '>Газ</option>
                <option value="Бензин"' . ($row['Fuel'] == 'Бензин' ? ' selected' : '') . '>Бензин</option>
                <option value="Дизел"' . ($row['Fuel'] == 'Дизел' ? ' selected' : '') . '>Дизел</option>
            </select><br>';
            echo '<button type="submit">Запази промените</button>';
            echo '</form>';
        } else {
            echo "Не може да се намери автомобил с този идентификатор.";
        }
    } else {
        echo "Не е предоставен идентификатор на автомобил.";
    }

    // Close the database connection
    $mysqli->close();
} else {
    echo "Нямате права за достъп до тази страница.";
}
?>
<style>
    form {
        width: 50%;
        margin: 0 auto;
        text-align: center;
    }

    label {
        display: inline-block;
        width: 100px;
        margin-bottom: 10px;
    }

    input[type="text"], select {
        width: 200px;
        padding: 5px;
        margin-bottom: 10px;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    #success-message {
        text-align: center;
        margin-top: 20px;
        font-size: 18px;
        color: green;
    }
</style>
