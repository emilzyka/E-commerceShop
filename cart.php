<?php 
require __DIR__ . '/db.php';
session_start();
if(!isset($_SESSION['user_id'])){
    $_SESSION["message"] = "Du måste vara inloggad för att gå till varukorg!";
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/checkout.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Cart</title>

</head>

<body>

    <?php require('views/_header.php') ?>
    <div class="title">
        <h1>Din varukorg</h1>
    </div>

    <div class="lineForTitle"></div>

    <div class="container">
        <a href="action.php?clear=all" class="removeAll"
            onclick="return confirm('Är du säker på att du vill ta bort produkt från varukorg?')">
            Töm varukorg</a>
        <div class="table">
            <table class="ptable">
                <thead>
                </thead>
                <tbody>
                    <?php 
                        $total = 0;
                        $result = getAllcartitemsById(getCartById($_SESSION['user_id'])['cart_id']);
                        foreach($result as $pid){
                            $row = getProductById($pid);
                            ?>
                    <tr class="products">
                        <td class="imgtd"><img src="img/<?=$row['image']?>"></td>
                        <td class="titleCard"><?=$row['title']?></td>
                        <td class="priceTag"><?=$row['price']?> :-</td>
                        <td class="btnROne"><a href="action.php?remove=<?=$row['prod_id']?>" class="removeOne"
                                onclick="return confirm('Är du säker på att du vill ta bort alla produkter från varukorgen?')">
                                Ta bort</a></td>
                    </tr>
                    <?php 
                                $total += $row['price']?>
                    <?php
                        }
                        ?>
                    <tr class="last">
                        <td>
                            <a class="continueShopping" href="shop.php">Tillbaka</a>
                        </td>
                        <td>
                            <b>Totalt pris</b>
                        </td>
                        <td><?= $total?> SEK</td>
                        <td>
                            <?php if($total > 1){
                                   ?>
                            <a class="checkoutBtn" href="checkout.php">Till kassan</a>
                            <?php
                                }?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2 class="removeOneMessage">
                <?php if(isset($_SESSION['message'])){
                echo($_SESSION['message']);}
                unset($_SESSION['message']);?>
            </h2>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $(".addItemBtn").click(function(e) {
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
            }
        });
    });
    </script>
</body>

</html>