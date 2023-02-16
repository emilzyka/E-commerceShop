<?php

session_start();
require __DIR__ . '/db.php';
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

/*servervalidation of email, username, password and 2ndpw, gives a header based on  */
/*first found error, if no errors tries to post to db by calling method, if it can */
/*post redirects user to login, else email is already in use error */
if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || empty($_POST["email"])){
    $_SESSION["message"]="Felaktig email: Det måste vara en giltig universitetsmail";
    header("location: signup.php");
    exit;
    return false;
}
if(strlen($_POST["username"])<2){
    $_SESSION["message"]="Felaktigt användarnamn: Det måste vara minst 3 tecken långt";
    header("location: signup.php");
    exit;
    return false;
}
if(strlen($_POST["password"])<8){
    $_SESSION["message"]="Felaktigt lösenord: Det måste vara minst 8 tecken långt";
    header("location: signup.php");
    exit;
    return false;
}
if(strcmp($_POST["password"], $_POST["password2"])){
    $_SESSION["message"]="Felaktigt lösenord: Lösenorden måste vara identiska";
    header("location: signup.php"); 
    exit;
    return false;
}
else{
    if(createUser($_POST["email"],$_POST["username"],$password_hash)){
        header("location: login.php");
        exit;
    }
    else{
        $_SESSION["message"]="Det finns redan ett konto kopplad till denna mailadress";
        header("location: signup.php");
        exit;
    }
}

?>