<?php
session_start(); 
require __DIR__ . '/db.php';
$_SESSION['valuta'] = 'sek';
if(isset($_SESSION['category_id'])){
    unset($_SESSION['category_id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/shop.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Shop</title>

</head>

<body>
    <?php require "views/_header.php"; ?>

    <h1 class="shoptitle">Produkter</h1>

    <p class="errorMsg">
        <?php 
    if(isset($_SESSION["message"])){
    echo($_SESSION["message"]);
    unset($_SESSION["message"]);
    }
    ?>
    </p>

    <div class="background">
        <div class="lineForCat"></div>
        <div class="categories">
            <button class="category" value="1">kläder</button>
            <button class="category" value="2">böcker</button>
            <button class="category" value="3">hem</button>
            <button class="category" value="4">elektronik</button>

            <button class="btnCur" id="lastgrid" value="eur">eur</button>
            <button class="btnCur" value="nok">nok</button>
            <button class="btnCur" value="dkk">dkk</button>
            <button class="btnCur" value="sek">sek</button>
        </div>

        <div class="container">
            <?php
            $products = getAllproducts();
            foreach($products as $row){
            ?>
            <div class="card">
                <div class="loadproduct">
                    <div class="img">
                        <img class="product_img" src="img/<?= $row[4]?>">
                    </div>
                    <div class="title">
                        <h1><?= $row[1]?></h1>
                    </div>
                    <div class="price">
                        <p class="rate"><?= $row[2]?> SEK</p>
                    </div>
                </div>
                <div class="form">
                    <form action="" class="submit">
                        <input type="hidden" class="pid" value="<?= $row[0]?>">
                        <input type="hidden" class="pt" value="<?= $row[1]?>">
                        <input type="hidden" class="pp" value="<?= $row[2]?>">
                        <input type="hidden" class="pi" value="<?= $row[4]?>">
                        <button class="addItemBtn">Lägg i varukorg</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
    </div>
    </div>

    <?php require "views/_footer.php"; ?>

    <script>
    $(document).ready(function() {

        var inlogad = false;
        <?php if(isset($_SESSION['user_id'])){
            ?>
        var inlogad = true;
        <?php
        }
        ?>

        $(document).on('click', '.addItemBtn', function(e) {
            e.preventDefault();

            if (inlogad) {
                var $form = $(this).closest(".form");
                var pid = $form.find(".pid").val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {
                        pid: pid,
                    },
                    success: function(response) {
                        alert(response);
                        window.scrollTo(0, 0);
                        load_cart_num();
                    }
                });
            } else {
                alert('Du måsta logga in för att handla!');
            }
        });

        $(document).on('click', ".loadproduct", function(e) {
            e.preventDefault();
            var $form = $(this).siblings(".form");
            var pid = $form.find(".pid").val();
            var pt = $form.find(".pt").val();
            var pp = $form.find(".pp").val();
            var pi = $form.find(".pi").val();

            $.ajax({
                url: 'processComment.php',
                method: 'post',
                data: {
                    pid: pid,
                    pt: pt,
                    pp: pp,
                    pi: pi
                },
                success: function(response) {
                    window.location.href = "pcomment.php"
                }
            });
        });


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


        /* display different currency */
        $(document).on('click', ".btnCur", function(e) {
            e.preventDefault();
            var to = $(this).val();
            var from = "<?=$_SESSION['valuta']?>"

            $.ajax({
                url: 'process-Shop.php',
                method: 'post',
                data: {
                    to: to
                },
                success: function(response) {
                    $('.container').load('load_products.php');
                }
            });
        });


        /* display products by category */
        $(document).on('click', '.category', function(e) {
            e.preventDefault();
            var category = $(this).val();

            $.ajax({
                url: 'process-Shop.php',
                method: 'post',
                data: {
                    cat: category
                },
                success: function(response) {
                    $('.container').load('load_category.php');
                }
            });
        });

    });
    </script>
</body>

</html>