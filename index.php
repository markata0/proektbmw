<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $isLoggedIn = true;
    } else {
        $isLoggedIn = false;
    }
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <link rel="stylesheet" href="css/navbar_style.css">
    <link rel="stylesheet" href="css/home.css">

    <nav>
        <a href="index.php" class="logo1"><img src="images/logo.png" class="logo" width="120px"></a>

        <ul>
            <li>
                <a href="#"><img src="images/profile.png" width="25" height="25"></a>
                <ul class="dropdown">
                    <li><a href="html/Settings.php" class="drop1">Настройки</a></li>
                    <?php
                    if ($isLoggedIn) {
                        echo '<li id="logout"><a href="html/logout.php" class="drop2">Излизане</a></li>';
                    } else {
                        echo '<li id="login"><a href="html/Login.php" class="drop2">Вход</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li><a href="html/Products.php">Модели</a></li>
            <li><a href="html/display_cart.php"><img src="images/cart.png" width="25" height="25"></a></li>
            <li><a href="html/Policy.php">Политика</a></li>
            <?php
            if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
                echo '<li><a href="html/add_to_base.php">Добави продукт</a></li>';
                echo '<li><a href="html/View_acc.php">Акаунти</a></li>';
            }
            ?>
        </ul>
        <hr>
        <br>
    </nav>
    
    <div class ="banner">
        <img id="banner-image" src="images/r35.jpg">
        <div class="banner-content">
        <h1>Преоткрийте автомобилния свят</h1>
        <a href="html/Products.php" class="banner-button1">Виж моделите</a>
        <div class="banner-buttons">
            <button class="banner-button2" onclick="prevImage()">&#10094;</button>
            <button class="banner-button3" onclick="nextImage()">&#10095;</button>
        </div>
    </div>

    <h3>ОПЦИИ</h3>
    <div class="options">
        <a href="html/Products.php" class="options-con">
            <img src="images/config.png" width="130" height="75">
            <button class="options-buttons"><i style="padding:17px 82.3px;">Конфигуратор</i></button>
        </a>
    </div>
    <div class="options">
        <a href="html/TestDrive.php" class="options-con">
            <img src="images/testdrive.png" width="130" height="75">
            <button class="options-buttons"><i style="padding: 17px 65px;">Test drive записване</i></button>
        </a>
    </div>

    <link rel="stylesheet" href="css/footer_style.css">
    <footer>
        <p>Контакти</p>
        <a href=https://www.facebook.com><img src="images/facebook.png" width="63" height="70"></a>
        <a href=https://twitter.com><img src="images/twitter.png" width="63" height="70"></a>
        <a href=https://instagram.com><img src="images/instagram.png" width="63" height="70"></a>

        <p id="f2"><b>Имейл: mario3007p@abv.bg</b></p>
        <p id="f3"><b>Телефон за връзка: 0891234567</b></p>
        <p id="f1">&copy; DasAuto AG 2024</p>
    </footer>
    <script>
        let currentImageIndex = 0;

        const bannerImages = [
            "images/m4_banner.jpg",
            "images/r35.jpg",
            "images/rs8.jpg",
            "images/p911.jpg"
        ];

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + bannerImages.length) % bannerImages.length;
            updateBannerImage();
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % bannerImages.length;
            updateBannerImage();
        }

        function updateBannerImage() {
            document.getElementById('banner-image').src = bannerImages[currentImageIndex];
        }
    </script>
</body>