<?php
session_start();
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $isLoggedIn = true;
    } else {
        $isLoggedIn = false;
    }
    if (!$isLoggedIn) {
        $errorMessage = "<span style='color: red;'>Моля, влезте в акаунт за да добавяте продукти.</span>";
    }
?>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height:1.8;
        }
        .container {
            margin:-35px auto;
            max-width: 800px;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
        }
        .back-btn {
            display: flex;
            align-items: center; /* Align items vertically in the center */
            justify-content: center; /* Center items horizontally */
            font-size: 18px;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-weight: 600;
            padding: 7px 10px;
            color: white;
            margin-top: 20px;
            margin-left:100px;
            background-color: transparent;
            border: 4px solid rgb(75, 93, 250);
            background-color:rgba(169, 117, 253, 0.5);
            border-radius: 20px;
            cursor: pointer;
        }

        #backicon {
            width: 24px;
            height: 24px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <link rel="stylesheet" href="../css/navbar_style.css">

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

        <button onclick="goBack()" class="back-btn">
            <img id="backicon" src="../images/back.png" alt="Back Icon">
            Назад
        </button>

        <script>
            function goBack() {
            window.history.back();
            }
        </script>
    <div class="container" style="border: 1px solid rgb(102, 102, 255); border-radius: 5px; margin-bottom:20px;">
        <h1>ПОЛИТИКА ЗА ЗАЩИТА НА ЛИЧНИТЕ ДАННИ</h1>

        <h2>Въведение</h2>
        <p>Политиката за защита на личните данни описва начина, по който нашата организация събира, използва, разкрива и защитава личните данни на нашите потребители и клиенти. Ние вземаме сериозно защитата на вашата лична информация и сме ангажирани със защитата на вашата поверителност.</p>

        <h2>Какви лични данни събираме?</h2>
        <p>При събирането на лични данни, ние можем да получим информация като имена, адреси, електронни пощи, телефонни номера и друга информация, която е необходима за предоставянето на нашите услуги.</p>

        <h2>Как използваме личните данни?</h2>
        <p>Личните данни, които събираме, се използват за целите на предоставянето на нашите услуги, за обработка на поръчки, за комуникация с клиентите и за подобряване на нашите услуги и продукти.</p>

        <h2>Разкриване на лични данни на трети страни</h2>
        <p>Ние не продаваме, разменяме или разкриваме лични данни на трети страни, освен ако това не е необходимо за предоставянето на услуги или ако законът изисква такова разкриване.</p>

        <h2>Сигурност на данните</h2>
        <p>Прилагаме подходящи технически и организационни мерки за защита на вашите лични данни от неразрешен достъп, унищожаване, загуба, промяна или разкриване.</p>

        <h2>Промени в Политиката за Защита на Личните Данни</h2>
        <p>Ние запазваме правото си да променяме или актуализираме нашата Политика за Защита на Личните Данни по всяко време. Всяка промяна на нашата политика ще бъде публикувана на тази страница.</p>

        <h2>Контакти</h2>
        <p>Ако имате въпроси относно нашата Политика за Защита на Личните Данни, моля, свържете се с нас чрез електронната поща или телефонните ни контакти.</p>
        <p>Дата на влизане в сила: 06.03.2024г. </p>
    </div>
    
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
</html>