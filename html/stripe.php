<?php
    include('DatabaseConnection.php');
    require_once('../stripe-php-master/init.php');

    session_start();
    $userId = $_SESSION['user_id'];

    \Stripe\Stripe::setApiKey('sk_test_51P7LbIRtIXRevFaClwwZP5rHfM7HIfq4mVoTmY82kFJIgRznFThiDyPWs7W5KpezLrRxt3QFhwGVydfNnQipFNKG00xnaitbNf');

    $fetchCartItems = "SELECT cars.model, cars.price, cart.quantity
        FROM cars, cart WHERE cart.user_id = '$userId' AND cart.product_id = cars.id";
    $cartItemsResult = $mysqli->query($fetchCartItems);

    if ($cartItemsResult) {
        while ($row = $cartItemsResult->fetch_assoc()) {
            $cartItems[] = $row;
        }

        $lineItems = [];
        foreach ($cartItems as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'bgn',
                    'product_data' => [
                        'name' => $cartItem['model'],
                    ],
                    'unit_amount' => $cartItem['price'] * 100,
                ],
                'quantity' => $cartItem['quantity'],
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'https://xn--80aswg/папка/файл',
            'cancel_url' => 'https://carshowroom.website/html/display_cart.php',
        ]);

        // Redirect user to Stripe Checkout
        header('Location: ' . $session->url);
        exit;
    }

    header('Location: ../dispay_cart.php');
?>