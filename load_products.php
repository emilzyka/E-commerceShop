<?php
session_start();
require __DIR__ . '/db.php';
if(isset($_SESSION['valuta']) && isset($_SESSION['rate'])){
    if(isset($_SESSION['category_id'])){
        $products = getAllProdByCat($_SESSION['category_id']);
    }
    else{
        $products = getAllproducts();
    }
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
            <p class="rate" value="10"><?= round($row[2] * $_SESSION['rate'])?> <?=$_SESSION['valuta'] ?></p>
        </div>
    </div>
    <div class="form">
        <form action="" class="submit">
            <input type="hidden" class="pid" value="<?= $row[0]?>">
            <input type="hidden" class="pt" value="<?= $row[1]?>">
            <input type="hidden" class="pp" value="<?= $row[2]?>">
            <input type="hidden" class="pi" value="<?= $$row[4]?>">
            <button class="addItemBtn">Lägg i varukorg</button>
        </form>
    </div>
</div>
<?php
    }
}
?>