<?php
session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $isLoggedIn = true; 
    } else {
        $isLoggedIn = false;
    }
    if (!$isLoggedIn) {
        $errorMessage = "<span style='color: red;'>Моля, влезте в акаунт, за да закупите продукти!</span>";
    }

    $added_to_cart = isset($_GET['added']) && $_GET['added'] === 'true';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <link rel="stylesheet" href="../css/navbar_style.css">
    <link rel="stylesheet" href="../css/cart.css">

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
            Модели
        </button>
        <h2>Количка:</h2>
    <ul>
        <?php
            // Connect to your database
            $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

            // Check connection
            if ($mysqli->connect_error) {
                die("Грешка при свързването: " . $mysqli->connect_error);
            }
            if ($isLoggedIn) {
                $sql = "SELECT * FROM cart WHERE user_id=$user_id";
                $result = $mysqli->query($sql);
            }


            $counter = 1;


            if ($isLoggedIn && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="allproducts">';
                    echo '<div class="products">';
                    echo '<div class="product-details">';
                    echo '<p><b>Продукт ' . $counter++ . ':</b></p>';
                    echo '<img id="p_img" src="../images/' . $row['Image_Direction'] . '">';
                    echo "<h1><p class='models'>{$row['Model']} - </p>";
                    echo "<form method='POST' action='edit_quantity.php'>";
                    echo "<input type='hidden' name='editType' value='remove'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<input type='hidden' name='Quantity' value='" . $row["Quantity"] . "'>";
                    echo "<button class='quantity_but' type='submit' name='remove'>-</button>";
                    echo "</form>";
                    echo "{$row['Quantity']} бр.";
                    echo '<form method="POST" action="edit_quantity.php">';
                    echo '<input type="hidden" name="editType" value="add">';
                    echo '<input type="hidden" name="id" value=" '. $row["id"] . '">';        
                    echo '<input type="hidden" name="Quantity" value="' . $row["Quantity"] . '">';
                    echo '<button class="quantity_but" type="submit" name="add">+</button>';
                    echo '</form>';
                    echo '</h1>';                 
                    echo "<div class='product-specs'>";
                    echo "<p>Мощност: {$row['Horse_Power']} кс.</p>";
                    echo "<p>Време от 0-100 км/ч: {$row['Acceleration']} сек.</p>";
                    echo "<p>Разход на гориво: {$row['Fuel_consumption']} л/100 км.</p>";
                    echo "<p>Километраж: {$row['Mileage']} км.</p>";
                    echo "<p class='p_specs'>Гориво: {$row['Fuel']}</p>";
                    echo '<p class="p_specs">' . number_format($row['Price'], 0, ',', ' ') . " лв." . '</p>';
                    echo '<form method="POST" action="clearcart.php">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<button id="delete" type="submit">Премахни от количката</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo "<div class=box1>";
                echo "<form method='POST' action='empty_cart.php'>";
                echo "<button id='empty' type='submit' name='remove'>Изпразване на количката</button>";
                echo "</form>";
                echo "<form method='POST' action='checkoutform.php'>";
                echo "<button id='checkout' type='submit' name='check'>Преминете към плащане</button>";
                echo "</form>";
                echo "</div>";
            } else {
                echo '<p style=text-align:center;>0 резултата</p>';
                echo "<style>";
                echo "footer {
                        bottom: 0;
                      }";
                echo "</style>";
            }

            $mysqli->close();
        ?>
    </ul>

<link rel="stylesheet" href="../css/footer_style.css">
    <footer>
        <div class="foot">
            <p>Контакти</p>
            <a href=https://www.facebook.com><img src="../images/facebook.png" width="63" height="70"></a>
            <a href=https://twitter.com><img src="../images/twitter.png" width="63" height="70"></a>
            <a href=https://instagram.com><img src="../images/instagram.png" width="63" height="70"></a>
            
            <p id="f2"><b>Имейл: mario3007p@abv.bg</b></p>
            <p id="f3"><b>Телефон за връзка: 0891234567</b></p>
            <p id="f1">&copy; DasAuto AG 2024</p>
        </div>
    </footer>
</body>
