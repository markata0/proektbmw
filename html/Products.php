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
    $added_to_cart = isset($_GET['added']) && $_GET['added'] === 'true';

    $minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : 67800;
    $maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : 340259;

    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'Model';

    $searchModel = isset($_GET['Model']) ? $_GET['Model'] : '';
    $searchModel = trim($searchModel); // Remove leading/trailing spaces
    $searchModel = htmlspecialchars($searchModel);
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <link rel="stylesheet" href="../css/navbar_style.css">
    <link rel="stylesheet" href="../css/products.css">

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

    <link rel="stylesheet" href="../css/filters.css">
    <form id="searchForm">
        <label for="Model"><b>Търсене на модел:</b></label>
        <input type="text" name="Model" id="Model" value="<?php echo $searchModel; ?>">
        <label for="priceRange"><b>Филтър по цена:</b></label>
        <label for="minPrice">Мин. цена:</label>
        <input type="number" name="minPrice" id="minPrice" value="<?php echo $minPrice; ?>">
        <label for="maxPrice">Макс. цена:</label>
        <input type="number" name="maxPrice" id="maxPrice" value="<?php echo $maxPrice; ?>">
        <label for="sortBy"><b>Сортиране по:</b></label>
        <select name="sortBy" id="sortBy">
            <option value="Model" <?php if($sortBy == 'Model') echo 'selected'; ?>>Модел</option>
            <option value="Price" <?php if($sortBy == 'Price') echo 'selected'; ?>>Цена</option>
        </select>
        <button type="submit">Търсене</button>
        <button id="clearFiltersButton">Премахни филтрите</button>
    </form>

    <?php
        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        if ($mysqli->connect_error) {
            die('Грешка при свързването: ' . $mysqli->connect_error);
        }

        $sql = "SELECT Id, Model, Horse_Power, Acceleration, Fuel_consumption, Mileage, Price, Image_Direction, Fuel FROM cars WHERE Price BETWEEN $minPrice AND $maxPrice";

        if (!empty($searchModel)) {
            $sql .= " AND Model LIKE '%$searchModel%'";
        }

        $sql .= " ORDER BY $sortBy";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a href="product_details.php?Model=' . $row['Model'] . '" class="product-link">';
                echo '<div class="product">';
                echo '<img src="../images/' . $row['Image_Direction'] . '">';
                echo '<h3>' . $row['Model'] . '</h3>';
                echo '<p>' . number_format($row['Price'], 0, ',', ' ') . " лв." . '</p>';
                echo '<p>' . $row['Fuel'] . '</p>';
                echo '</a>';
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
                } else {
                    echo '<form>';
                    echo '<button type="button" class="buy-button" onclick="showErrorMessage(\'' . $row['Model'] . '\')">Добавяне към количката</button>';
                    echo '<p id="error-message-' . $row['Model'] . '" class="errormes" style="display: none; color: red;">Моля, влезне в акаунт.</p>';
                    echo '</form>';
                }
                echo '</div>';
            }
        } else {
            echo '<p id="noproducts">Няма продукти, които съвпадат на търсенето.<p>';
        }

        $mysqli->close();
    ?>
    <script>
        document.getElementById('clearFiltersButton').addEventListener('click', function() {
            document.getElementById('Model').value = '';
            document.getElementById('minPrice').value = '67800';
            document.getElementById('maxPrice').value = '340259';
            document.getElementById('sortBy').value = 'Model';
            document.getElementById('searchForm').submit();
        });
        function showErrorMessage(model) {
            var errorMessageId = 'error-message-' + model;
            document.getElementById(errorMessageId).style.display = "block";
        }
    </script>
    
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