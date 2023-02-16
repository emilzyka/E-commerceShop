<?php
require __DIR__ . '/db.php';
session_start();
$cart_id = getCartById($_SESSION['user_id'])['cart_id'];

if(isset($_POST['pid'])){
    $pid = $_POST['pid'];

    /* if true item is already in cart else insert into cart */
    if(isItemInCart($cart_id, $pid)){
        echo "Produkt finns redan i varukorg!";
    }
    else{
        addCartItem($cart_id, $pid);
        echo "Produkt tillagd i varukorgen";
    }
}

if (isset($_GET['cartItems'])){
    $n = getNumerItems($cart_id);
    echo $n;
}

if(isset($_GET['remove'])){
    $pid = $_GET['remove'];
    if(deleteCartById($cart_id, $pid)){
        $_SESSION['message'] = 'Produkt borttagen från varukorg!';
        header('location: cart.php');
        exit;
    }
}

if(isset($_GET['clear'])){
    $_SESSION['message'] = 'Varukorg tömd!';
    deleteCartItemsByCardId($cart_id);
    header('location: cart.php');
    exit;
}

/* add an order to order-table */

if(isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['adress'])){ 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];

    $products = $_POST['products'];
    $totalPrice = $_SESSION['totalPrice'];

    $error="";
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || empty($_POST["email"])){
        $error .= "Ogiltig email ";
    }
    if(!is_numeric($phone) || empty($_POST["phone"])){
        $error .= "Ogiltigt telefonnummer ";
    }
    if(empty($_POST["adress"])){
        $error .= "Ogiltigt adress ";
    }
    if($error != ""){
        $_SESSION['message'] = $error;
        header('location: checkout.php');    
    }
    else{
        addOrder($name, $email, $phone, $adress, $totalPrice, $cart_id);
        $data = "";
        $data .= '<div class="conMes">
        <h1>Tack för din order!</h1>
        <h2>Order:</h2>
        <h3>Produkter : '.$products.'</h3>
        <h4>Namn : '.$name.'</h4>
        <h4>Email : '.$email.'</h4>
        <h4>Telefon : '.$phone.'</h4>
        <h4>Pris : '.$totalPrice.'</h4>
        </div>';
        $_SESSION['confirmation'] = $data;
        header('location: checkout.php');   
    }
}