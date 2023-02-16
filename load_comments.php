<?php
session_start();
require __DIR__ . "/db.php";
$pid= $_SESSION["cid"];
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
</div>
<?php
}?>