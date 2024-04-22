<main>
    <link rel="stylesheet" href="../css/add_item.css">
    <button onclick="window.location.href='./index.php'" class="back-btn">
        <img id="backicon" src="../images/back.png" alt="Back Icon">
        Начало
    </button>
    <div class="form">
        <form action="../html/add.php" method="POST" onsubmit="return validateForm()">
            <a href="TestDrive.php"><img src="../images/logo.png" width="200"></a>
            <fieldset>
                <div class="section section-alone">
                    <h1>Добави продукт</h1>
                </div>

                <div class="section">
                    <input type="text" name="Model" placeholder="Модел">
                    <input type="text" name="Image_Direction" placeholder="Име на снимка с разширение">
                    <input type="text" name="Horse_Power" placeholder="Мощност(конски сили)">
                    <input type="text" name="Acceleration" placeholder="Ускорение от 0-100км">
                    <input type="text" name="Fuel_consumption" placeholder="Разход на гориво">
                    <input type="text" name="Mileage" placeholder="Пробег">
                    <input type="text" name="Price" placeholder="Цена(лв.)">
                    <select name="Fuel" id="Fuel" class="">
                        <option value="" selected="" disabled="">Гориво</option>
                        <option value="Газ">Газ</option>
                        <option value="Бензин">Бензин</option>
                        <option value="Дизел">Дизел</option>
                    </select>   
                </div>

                <div class="section section-alone">
                    <button type="submit" class="buy-button">Добавяне на продукт</button>
                    <button type="reset" class="btn-reset">Изчисти формуляра</button>
                </div>
            </fieldset>
        </form>
    </div>
    <?php
    session_start();
    if(isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        // Check connection
        if ($mysqli->connect_error) {
            die('Грешка при свързването: ' . $mysqli->connect_error);
        }

        $sql = "SELECT * FROM cars";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Снимка</th><th>Модел</th><th>Мощност</th><th>Ускорение</th><th>Разход на гориво</th><th>Пробег</th><th>Цена</th><th>Гориво</th><th>Действия</th></tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['Image_Direction'] . '</td>';
                echo '<td>' . $row['Model'] . '</td>';
                echo '<td>' . $row['Horse_Power'] . ' кс.</td>';
                echo '<td>' . $row['Acceleration'] . ' сек.</td>';
                echo '<td>' . $row['Fuel_consumption'] . ' л/100 км.</td>';
                echo '<td>' . number_format($row['Mileage'], 0, ',', ' ') . ' км.</td>';
                echo '<td>' . number_format($row['Price'], 0, ',', ' ') . ' лв.</td>';
                echo '<td>' . $row['Fuel'] . '</td>';
                echo '<td>';
                echo '<a href="edit_car.php?id=' . $row['Id'] . '">Редакция</a>';
                echo ' | ';
                echo '<a href="delete_car.php?id=' . $row['Id'] . '">Изтриване</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Няма намерени автомобили в базата данни.</p>';
        }
        
        $mysqli->close();
    } else {
        echo '<p>Нямате права за достъп до тази страница.</p>';
    }
?>

    <script>
    function validateForm() {
        var acceleration = document.getElementsByName('Acceleration')[0].value.trim();
        var fuel_consumption = document.getElementsByName('Fuel_consumption')[0].value.trim();
        var price = document.getElementsByName('Price')[0].value.trim();
        var horse_power = document.getElementsByName('Horse_Power')[0].value.trim();
        var mileage = document.getElementsByName('Mileage')[0].value.trim();
        var model = document.getElementsByName('Model')[0].value;
        var image_direction = document.getElementsByName('Image_Direction')[0].value.trim();
        var fuel = document.getElementsByName('Fuel')[0].value;

        var numberRegex = /^[0-9]+$/;

        if (model === '') {
            alert('Моля, въведете модел.');
            return false;
        }

        if (image_direction === '') {
            alert('Моля, въведете име на снимка с разширение.');
            return false;
        }

        if (!image_direction.includes('.')) {
            alert('Моля, въведете точка преди разширението.');
            return false;
        }

        if (horse_power === '') {
            alert('Моля, въведете мощност(кс.).');
            return false;
        }

        if (!numberRegex.test(horse_power)) {
            alert('Мощността трябва да съдържа само числа.');
            return false;
        }

        if (acceleration === '') {
            alert('Моля, въведете ускорение в секунди.');
            return false;
        }

        if (acceleration.includes(',')) {
            alert('Ускорението трябва да бъде въведено без десетична запетая');
            return false;
        }

        if (fuel_consumption === '') {
            alert('Моля, въведете разход на гориво(0л./100км.).');
            return false;
        }

        if (fuel_consumption.includes(',')) {
            alert('Разходът на гориво трябва да бъде въведен без десетична запетая');
            return false;
        }

        if (mileage === '') {
            alert('Моля, въведете пробег(сек).');
            return false;
        }
        
        if (!numberRegex.test(mileage)) {
            alert('Пробегът трябва да съдържа само числа.');
            return false;
        }

        if (price === '') {
            alert('Моля, въведете цена(лв.).');
            return false;
        }

        if (!numberRegex.test(price)) {
            alert('Цената трябва да съдържа само числа.');
            return false;
        }

        if (fuel === '') {
            alert('Моля, изберете гориво.');
            return false;
        }

        return true;
    }
    </script>
</main>