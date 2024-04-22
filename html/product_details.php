<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $isLoggedIn = true;
    } else {
        $isLoggedIn = false;
    }
    if (!$isLoggedIn) {
        $errorMessage = "<span style='color: red;'>Моля, влезте в акаунт, за да пазарувате.</span>";
    }
    $errorMessage2 = "<span style='color: red;'>Моля, влезте в акаунт, за да коментирате.</span>";

    $errorMessage3 = "<span style='color: red;display:none;'>Трябва да въведете коментар!</span>";

    $added_to_cart = isset($_GET['added']) && $_GET['added'] === 'true';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
<link rel="stylesheet" href="../css/navbar_style.css">
<link rel="stylesheet" href="../css/p_details.css">

    <nav>
        <a href="./index.php" class="logo1"><img src="../images/logo.png" class="logo" width="120px"></a>

        <ul>
            <li><a href="./index.php">Начало</a></li>
            <li>
                <a href="#"><img src="../images/profile.png" width="25" height="25"></a>
                <ul class="dropdown">
                    <li><a href="Settings.php" class="drop1">Настройки</a></li>
                    <?php
                    if ($isLoggedIn) {
                        echo '<li id="logout"><a href="logout.php" class="drop2">Излизане</a></li>';
                    } else {
                        echo '<li id="login"><a href="Login.php" class="drop2">Вход</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li><a href="Products.php">Модели</a></li>
            <li><a href="display_cart.php"><img src="../images/cart.png" width="25" height="25"></a></li>
            <li><a href="Policy.php">Политика</a></li>
            <?php
            if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
                echo '<li><a href="add_to_base.php">Добави продукт</a></li>';
                echo '<li><a href="View_acc.php">Акаунти</a></li>';
            }
            ?>
        </ul>
        <hr>
        <br>
    </nav>
    <button onclick="window.location.href='Products.php'" class="back-btn">
            <img id="backicon" src="../images/back.png" alt="Back Icon">
            Назад
    </button>
    <?php
    // Check if the model parameter exists in the URL
    if(isset($_GET['Model'])) {
        // Retrieve the model parameter from the URL
        $model = $_GET['Model'];

        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        if ($mysqli->connect_error) {
            die('Connect Error: ' . $mysqli->connect_error);
        }

        $sql = "SELECT Id, Model, Horse_Power, Acceleration, Fuel_consumption, Mileage, Price, Image_Direction, Fuel FROM cars WHERE Model = '$model'";

        // Execute the SQL statement
        $result = $mysqli->query($sql);

        // Check if a product with the provided model exists
        if ($result->num_rows > 0) {
            // Fetch the row
            $row = $result->fetch_assoc();

            echo '<div class="product-details">';
            echo '<img src="../images/' . $row['Image_Direction'] . '">';
            echo "<h1>{$row['Model']}</h1>";
            echo "<p>Мощност: {$row['Horse_Power']} кс.</p>";
            echo "<p>Време от 0-100 км/ч: {$row['Acceleration']} сек.</p>";
            echo "<p>Разход на гориво: {$row['Fuel_consumption']} л/100 км.</p>";
            echo "<p>Километраж: {$row['Mileage']} км.</p>";
            echo "<p>Гориво: {$row['Fuel']}</p>";
            echo '<p>' . number_format($row['Price'], 0, ',', ' ') . " лв." . '</p>';
            if ($isLoggedIn) {
                echo '<form action="add_to_cart.php" method="POST">';
                echo '<input type="hidden" name="Id" value="' . $row['Id'] . '">';
                echo '<input type="hidden" name="Image_Direction" value="' . $row['Image_Direction'] . '">';
                echo '<input type="hidden" name="Model" value="' . $row['Model'] . '">';
                echo '<input type="hidden" name="Horse_Power" value="' . $row['Horse_Power'] . '">';
                echo '<input type="hidden" name="Acceleration" value="' . $row['Acceleration'] . '">';
                echo '<input type="hidden" name="Fuel_consumption" value="' . $row['Fuel_consumption'] . '">';
                echo '<input type="hidden" name="Mileage" value="' . $row['Mileage'] . '">';
                echo '<input type="hidden" name="Fuel" value="' . $row['Fuel'] . '">';
                echo '<input type="hidden" name="Price" value="' . $row['Price'] . '">';
                echo '<button type="submit" class="buy-button">Добавяне към количката</button>';
                echo '</form>';
                echo '<form action="comment.php" method="POST" onsubmit="return validateForm()">';
                echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
                echo '<input type="hidden" name="product_id" value="' . $row['Id'] . '">';
                echo '<h2>Добави коментар:</h2>';
                echo '<textarea id="comment" name="comment" rows="10" cols="150"></textarea>';
                echo '<button id="kom1">Добави коментар</button>';
                echo '</form>';

            } else {
                echo '<form>';
                echo '<button type="button" class="buy-button" onclick="showErrorMessage()">Добавяне към количката</button>';
                echo '<p id="error-message" style="display: none;">' . $errorMessage . '</p>';
                echo '</form>';
                echo '<h2 id="add_com">Добави коментар:</h2>';
                echo '<textarea id="comment" name="comment" rows="10" cols="150"></textarea>';
                echo '<button id="kom1" onclick="showErrorMessage2()">Добави коментар</button>';
                echo '<p id="error-message2" style="display: none;">' . $errorMessage2 . '</p>';
            }
            echo '</div>';

            $sql_comments = "SELECT * FROM comments WHERE product_id = " . $row['Id'];
            $result_comments = $mysqli->query($sql_comments);

            echo '<div class="comments-box">';
            echo '<h2>Коментари:</h2>';
            echo '<div class="comments">';
            if ($result_comments->num_rows > 0) {
                while ($row_comment = $result_comments->fetch_assoc()) {
                    echo '<div class="comment">';
                    $sql_profiles = "SELECT * FROM profiles WHERE Id = " . $row_comment['user_id'];
                    $result_profiles = $mysqli->query($sql_profiles);

                    if ($result_profiles->num_rows > 0) {
                        $row_profile = $result_profiles->fetch_assoc();
                        $username = $row_profile['Username'];
                    } else {
                        $username = "Анонимен";
                    }
                    echo '<div class="user_pic">';
                    echo '<a id="user_img"><img src="../images/profile.png" width="25" height="25"></a>';
                    echo '<p>' . $username . '</p>';
                    echo '</div>';
                    echo '<div class="comment-textarea">';
                    echo '<textarea readonly rows="8" cols="130">' . $row_comment['comment'] . '</textarea>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div style="text-align: center; color:red; margin-bottom:40px;">';
                echo '<p><b>Все още няма коментари за продукта.</b></p>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';

        } else {
            echo "Продуктът не е намерен!";
        }

        $mysqli->close();
    } else {
        echo "Нещо се обърка при намиране на модела!";
    }
    ?>
    <script>
        function validateForm() {
            var comment = document.getElementById('comment').value;

            if (comment.trim() === '') {
                alert('Трябва да въведете коментар!');
                return false;
            }

            return true;
        }
        function showErrorMessage() {
            document.getElementById("error-message").style.display = "block";
        }
        function showErrorMessage2() {
            document.getElementById("error-message2").style.display = "block";
        }
    </script>
</body>
</html>