<?php
session_start();
require __DIR__ . '/db.php';

/* https://github.com/fawazahmed0/currency-api#readme */
if(isset($_POST['to'])){
    $t = $_POST['to'];
    $f = "sek";
    $path = 
    "https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/$f/$t.min.json";
    $data = file_get_contents($path);
    $d = json_decode($data, true);
    $_SESSION['valuta'] = strtoupper($t);
    $_SESSION['rate'] = $d[$t];
}


if(isset($_POST['cat'])){
   $_SESSION['category_id'] = $_POST['cat'];
}
?>