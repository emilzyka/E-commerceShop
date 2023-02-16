<?php 
require __DIR__ . '/db.php';
session_start();
if(!isset($_SESSION['user_id'])){
    $_SESSION['message'] = "Du vara måste vara inloggad för att handla och kommentera!";
    header('location: shop.php');
}
$pid = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/checkout.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Recensioner</title>

</head>

<body>
    <?php require('views/_header.php') ?>
    <div class="productContainer">
        <?php 
        if(isset($_SESSION['cid'])){
            $px = getProductById($_SESSION['cid']);
            $pid = $px['prod_id'];
            /* display selected product  */ ?>
        <div class="card">
            <div class="img">
                <img class="product_img" src="img/<?= $px['image']?>">
            </div>
            <div class="title">
                <h1><?= $px['title']?></h1>
            </div>
            <div class="price">
                <p class="price"><?= $px['price']?> SEK</p>
            </div>
            <div class="description">
                <p><?= $px['description']?></p>
            </div>
        </div>
        <?php    
        }
        ?>
    </div>
    <div class="lineSep"></div>
    <div class="commentBox" id="commentBox" name="commentBox">
        <form class="commentForm">
            <textarea class="comment" id="comment" name="comment" maxlength="500" placeholder="Skriv en recension..."
                minlength="3" required></textarea><br>
            <input class="submitComment" type="submit" value="spara">
        </form>
    </div>


    <div class="dynamicLoad">
        <?php
            $commentsData = getCommentsByProdId($pid);
            foreach($commentsData as $commentsData){
            ?>
        <div class="commentContainer">
            <p class="postedBy">Skriven av: <?= getUserById($commentsData[3])['name']?> </p>
            <p class="commentCont"><?= $commentsData[2]?></p>
            <input type="hidden" class="c_id" value="<?= $commentsData[0]?>">
            <?php 
            if(isAdminById($_SESSION['user_id'])) { ?>
            <button id="deleteBtn">Ta bort kommentar</button>
            <?php
            } 
        ?>
            <div class="commentSep"></div>
        </div><?php
        }?>
    </div>


    <script>
    $(document).ready(function() {
        $(".commentForm").on('submit', function(e) {
            e.preventDefault();
            var pid = `&pid=${<?=$pid?>}`;
            var user_id = `&user_id=${"<?=$_SESSION['user_id']?>"}`;
            $.ajax({
                url: 'processComment.php',
                method: 'post',
                data: $('form').serialize() + "&action=comment" + pid + user_id,
                success: function(response) {
                    alert(response);
                    $(".dynamicLoad").load("load_comments.php")
                }
            });
        });


        $(document).on('click', '#deleteBtn', function(e) {
            var clicked = $(this);
            var cmt_id = clicked.closest('.commentContainer').find('.c_id').val()
            $.ajax({
                url: 'processComment.php',
                method: 'post',
                data: {
                    cmt_id: cmt_id,
                    action: 'deleteComment'
                },
                success: function(response) {
                    alert(response);
                    $(".dynamicLoad").load("load_comments.php")
                }
            });
        });
    });
    </script>
</body>

</html>