<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/header.css">
</head>

<body>
    <div class="topnav">
        <img class="logoImg" src="img/logot.png">
        <a class="shop" href="shop.php">Shop</a>
        <a class="hem" href="index.php">Hem</a>
        <a class="cart" href="cart.php"><img class="cartImg" src="img/cartNoback.png" href="cart.php"></a>
        <p class="number"> <span id="cartItems">0</span></p>

        <?php if (isset($_SESSION['user_id'])): ?>
        <a class="logout" href="/views/logout.php">Logga ut</a>
        <?php else: ?>
        <a class="logout" href="login.php">Logga in</a>
        <?php endif; ?>

    </div>

    <script>

    </script>

</body>

</html>