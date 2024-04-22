<?php
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $isLoggedIn = true;
    } else {
        $isLoggedIn = false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Phone_num = $_POST['Phone_num'];
        $City = $_POST['City'];
        $Car_model = $_POST['Car_model'];
        
        $mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $sql = "INSERT INTO testdrive (Name, Email, Phone_num, City, Car_model)
                VALUES ('$Name', '$Email', '$Phone_num', '$City', '$Car_model')";

        if ($mysqli->query($sql) === TRUE) {
            echo "<p style= 'color:white; margin-left: 853px; margin-top:30px; margin-bottom:-20px'>Записахте се успешно</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

        $mysqli->close();
    }
    ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <link rel="stylesheet" href="../css/testdrive.css">
    <div class="conteiner">
        <button onclick="window.location.href='./index.php'" class="back-btn">
            <img id="backicon" src="../images/back.png" alt="Back Icon">
            Назад
        </button>
        <?php
        if ($isLoggedIn) {
        echo '<section>
            <div id="form-conteiner">
                <a href="TestDrive.php"><img src="../images/logo.png" width="200"></a>
                <h1> Записване за тест драйв</h1>
                <form method="post" onsubmit="return validateForm()">
                    <input type="text" name="Name" id="Name" placeholder="име и фамилия">
                    <input type="text" name="Email" id="Email" placeholder="имейл">
                    <input type="text" name="Phone_num" id="Phone_num" placeholder="телефон за връзка">
                    <br>
                    <div class="select-container">
                        <select name="City" id="City" class="">
                            <option value="" selected="" disabled="">Предпочитан град за тест драйв</option>
                            <option value="Sofia" name="Sofia">София</option>
                            <option value="Plovdiv" name="Plovdiv">Пловдив</option>
                            <option value="Varna" name="Varna">Варна</option>
                            <option value="Burgas" name="Burgas">Бургас</option>
                            <option value="Stara_Zagora" name="StaraZagora">Стара Загора</option>
                        </select>
                    </div>
                    <div class="select-container">
                        <select name="Car_model" id="Car_model" class="">
                            <option value="" selected="" disabled="">Модел кола за тест драйв</option>
                            <option value="Audi RS6">Audi RS6</option>
                            <option value="Audi RS7">Audi RS7</option>
                            <option value="A5 Sportback">Audi A5 Sportback</option>
                            <option value="M3">BMW M3</option>
                            <option value="M3C">BMW M3 Competition</option>
                            <option value="M4">BMW M4</option>
						    <option value="M4C">BMW M4 Competition</option>
                            <option value="M5">BMW M5</option>
						    <option value="M5C">BMW M5 Competition</option>
                            <option value="M5CS">BMW M5 CS</option>
                            <option value="EvoIV">Mitsubishi Lancer Evo IV</option>
                            <option value="EvoVI">Mitsubishi Lancer Evo VI</option>
                            <option value="EvoX">Mitsubishi Lancer Evo X</option>
                            <option value="R35">Nissan R35</option>
                        </select>
                    </div>
                    <div class="infocheck">
                        <input type="checkbox" id="check">
                        <label>
                            <span style="color:white">Съгласявам се с политиката за <a href="Policy.php">Защита на личните данни.</a>* </span>
                        </label>
                    </div>
                    <br>
                    <input type="submit" value="Записване" class="btn-submit"> 
                    <input type="reset" value="Изчистване"class="btn-reset">
                </form>
            </div>
        </section>
    </div>';
    } else{
        echo '<p style=color:red;margin-top:300px;font-size:21;><b>Не сте влезли в акаунт.<b></p>';
    }
    ?>
    <script>
    function validateForm() {
        var Name = document.getElementById('Name').value;
        var Phone_num = document.getElementById('Phone_num').value;
        var Email = document.getElementById('Email').value;
        var City = document.getElementById('City').value;
        var Car_model = document.getElementById('Car_model').value;
        var checkbox = document.getElementById('check');

        var letterRegex = /^[А-Яа-я]+$/;

        if (Name.trim() === '') {
            alert('Моля, въведете име.');
            return false;
        }

        if (!letterRegex.test(Name)) {
            alert('Моля, въведете името само с букви и на български.');
            return false;
        }

        if (Email.trim() === '') {
            alert('Моля, въведете имейл.');
            return false;
        }

        if (!Email.includes('@') || !Email.includes('.')) {
            alert('Моля, въведете валиден имейл адрес, който съдържа @ и .');
            return false;
        }

        if (Phone_num.trim() === '') {
            alert('Моля, въведете телефонен номер.');
            return false;
        }

        var numberRegex = /^[0-9]+$/;

        if (!numberRegex.test(Phone_num)) {
            alert('Телефонният номер трябва да съдържа само числа.');
            return false;
        }

        if(!(Phone_num.length === 10))
        {
            alert('Телефонният номер трябва да съдържа 10 числа.')
            return false;
        }

        if (City.trim() === '') {
            alert('Моля, изберете град за тест драйв.');
            return false;
        }

        if (Car_model.trim() === '') {
            alert('Моля, изберете кола за тест драйв.');
            return false;
        }

        if (!checkbox.checked) {
            alert('Моля, отбележете съгласие с политиката за защита на личните данни.');
            return false;
        }

        return true;
    }
    </script>
</body>