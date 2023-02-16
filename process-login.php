<?php
session_start();
require __DIR__ . '/db.php';

if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $userArr = fetchUser($email,$password);
    if($userArr == false){
        $_SESSION["message"]="Fel email eller lösenord";
        header("location: login.php");
        exit;
    }
    else{
        session_regenerate_id();
        $_SESSION["message"] = "Du är inloggad";
        $_SESSION["user_id"] = $userArr[0];
        $_SESSION["user_name"] = $userArr[1];
        createCart($userArr[0]);
        header("location: index.php");
        exit;
    }
}
?>