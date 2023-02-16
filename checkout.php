<?php
session_start(); 
require __DIR__ . '/db.php';
if(!isset($_SESSION['user_id'])){
    header('location: index.php');
    exit;
}
    $cart_id = getCartById($_SESSION['user_id'])['cart_id'];
    $totalPrice = 0;
    $product = array();
    $result = getAllcartitemsById($cart_id);
    foreach($result as $pid){
        $row = getProductById($pid);
        $totalPrice += $row['price'];
        array_push($product, $row['title']);
    }
    if(empty($product)){
        header('location: index.php');
        exit;
    }
    $allItems = implode(", ", $product); 
    $_SESSION['totalPrice'] = $totalPrice;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/checkout.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Checkout</title>

</head>

<body>
    <?php require('views/_header.php') ?>
    <div class="container">
        <h2 class="fardig">Färdigställ order</h2>
        <div class="lineSep"></div>

        <h3 class="removeOneMessage">
            <?php if(isset($_SESSION['message'])){
                echo($_SESSION['message']);}
                unset($_SESSION['message']);?>
        </h3>

        <div class="allProducts">
            <?php if(isset($_SESSION['confirmation'])){
                echo($_SESSION['confirmation']);
                unset($_SESSION['confirmation']);
                deleteCartItemsByCardId($cart_id);
            }
            else{
                ?>
            <div class="order" id="order">
                <form action="action.php" method="post" id="placeOrder" name="placeOrder">
                    <input type="hidden" name="products" value="<?=$allItems?>">
                    <div class="formInput">
                        <label for="Namn">Namn</label>
                        <input type="text" class="name" id="name" name="name" placeholder="Alex Ekström" required>
                        <label for="Email">Email</label>
                        <input type="email" class="email" id="email" name="email" placeholder="Alex@uu.se" required>
                        <label for="tele">Telefonnummer</label>
                        <input type="tel" class="phone" id="phone" name="phone" placeholder="0736781552" required>
                        <label for="Adress">Adress</label>
                        <input type="text" class="adress" id="adress" name="adress" placeholder="gatan32B" required>
                    </div>
                    <h2 class="prisout">Pris: <?=$totalPrice?> SEK</h2>
                    <div class="bek">
                        <input type="submit" name="submit" value="Bekräfta beställning">
                    </div>
                </form>
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <p class="kartmed"> Ange var du befinner dig på kartan:
    </p>
    <h4 id="length">

    </h4>

    <?php require('map.php') ?>
    <?php require('views/_footer.php') ?>

    <script>
    load_cart_num();

    function load_cart_num() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: {
                cartItems: "cartItems"
            },
            success: function(response) {
                $("#cartItems").html(response);
            }
        });
    };
    </script>
</body>

</html>