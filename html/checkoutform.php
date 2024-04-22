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
$mysqli = new mysqli('localhost', 'carshowr', 'v5zF!!bA5rAB', 'carshowr_db');


$added_to_cart = isset($_GET['added']) && $_GET['added'] === 'true';
// Fetch cart items for the logged-in user from the database
    $sql = "SELECT * FROM cart WHERE user_id=$user_id";
    $result = $mysqli->query($sql);

    // Calculate total price
    $total_price = 0;
    while ($row = $result->fetch_assoc()) {
        $total_price += $row['Price'] * $row['Quantity'];
    }
    $total_price_formatted = number_format($total_price, 0, ',', ' ');

    // Close database connection
    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/navbar_style.css">
    <link rel="stylesheet" href="../css/checkoutform.css"> <!-- Create a CSS file for styling checkout page -->
</head>
<body>
    <nav>
        <!-- Your navigation menu -->
    </nav>
        <button onclick="window.location.href='display_cart.php'" class="back-btn">
            <img id="backicon" src="../images/back.png" alt="Back Icon">
            Количка
        </button>

    <div class="checkout-container">
        <div class="product_info">
            <h2>Информация за продуктите</h2>
            <ul class="checkout-items">
                <?php
                    // Display cart items
                    $result->data_seek(0); // Reset result pointer
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>{$row['Model']} - {$row['Quantity']} x " . number_format($row['Price'], 0, ',', ' ') . " лв.</li>";
                    }
                ?>
            </ul>
            <hr>
            <p id="totalprice"><b>Цена за всички продукти: <?php echo $total_price_formatted; ?> лв.</b></p>
        </div>

        <h2>Информация за плащане</h2>
        <form action="checkout.php" method="POST" onsubmit="return validateForm()">
            <label for="Name">Име:</label>
            <input type="text" id="Name" name="Name"><br>

            <label for="Email">Имейл:</label>
            <input type="text" id="Email" name="Email"><br>

            <label for="Address">Град на доставка:</label>
            <input type="text" id="City" name="City"><br>

            <label for="Address">Адрес на доставка:</label>
            <input type="text" id="Address" name="Address"><br>

            <label for="Zip_code">Zip код:</label>
            <input type="text" id="Zip_code" name="Zip_code"><br>

            <label for="Phone_num">Телефонен номер:</label>
            <input type="text" id="Phone_num" name="Phone_num"><br>

            <label for="Description">Описание:</label>
            <input type="text" id="Description" name="Description"><br>

            <label for="Payment_method">Моля, изберете метод за плащане:</label>
            <select id="Payment_method" name="payment_method">
                <option value="stripe">Stripe</option>
                <option value="cash">Наложен платеж</option>
            </select><br>   

            <button type="submit">Потвърдете данните за плащане</button>
        </form>
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
    <script>
    function validateForm() {
        var Name = document.getElementById('Name').value;
        var Address = document.getElementById('Address').value;
        var Email = document.getElementById('Email').value;
        var Phone_num = document.getElementById('Phone_num').value;

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

        if (Address.trim() === '') {
            alert('Моля, въведете адрес.');
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

        return true;
    }
    </script>
</body>
</html>
