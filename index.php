<?php
require __DIR__ . '/db.php';
session_start();
if(isset($_SESSION['user_id'])){
    $now = time();
    if (isset($_SESSION["timeout"]) && $now > $_SESSION["timeout"]) {
        session_unset();
        session_destroy();
        header("location: index.php");
    }
    $_SESSION["timeout"] = $now + 3600;
    if(isAdminById($_SESSION['user_id'])) {
        header('location: adminPage.php');
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/hem.css" />

</head>

<body>

    <?php require "views/_header.php"; ?>


    <?php if (isset($_SESSION['user_id'])): ?>

    <?php else: ?>
    <p class="skapaKonto">
        <a href="signup.php">Skapa ett konto</a>
    </p>
    <?php endif; ?>

    <p class="errorMsg">
        <?php 
    if(isset($_SESSION["message"])){
    echo($_SESSION["message"]);
    unset($_SESSION["message"]);
    }
    ?>
    </p>

    <?php require "hem.php"; ?>

    <?php require "views/_footer.php"; ?>

</body>

</html>