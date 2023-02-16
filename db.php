<?php
/*This file contain php-functions that operates on our database*/

/*function to get product by id */
function getProductById($pid){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM product WHERE prod_id = '%s'", $pid);
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db ->close();
    return $row;
}

/* function to get all products */
function getAllproducts(){
    $db = new SQLite3("./db/projekt.db");
    $data = array();
    $sql = "SELECT * FROM product";
    $res = $db->query($sql);
    while ($row = $res->fetchArray()){
        array_push($data, $row);
    }
    $db ->close();
    return $data;
}

function getAllProdByCat($cat_id){
    $db = new SQLite3("./db/projekt.db");
    $data = array();
    $sql = sprintf("SELECT * FROM product WHERE cat_id = '%s'", $db->escapeString($cat_id));
    $res = $db->query($sql);
    while ($row = $res->fetchArray()){
        array_push($data, $row);
    }
    $db ->close();
    return $data;
}


/* function to count rows in cart to get number of items  */
function getNumerItems($cart_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT COUNT (cart_id) FROM cart_item where cart_id = '%s'", $cart_id);
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db ->close();
    return $row[0];
}

/* function to get all products in cart by cart_id */
function getAllcartitemsById($card_id){
    $db = new SQLite3("./db/projekt.db");
    $data = array();
    $sql = sprintf("SELECT * FROM cart_item WHERE cart_id = '%s'", $db->escapeString($card_id));
    $res = $db->query($sql);
    while ($row = $res->fetchArray()){
        array_push($data, $row['prod_id']);
    }
    $db ->close();
    return $data;
}

/* function to delete one item from cart by id */
function deleteCartById($cart_id, $pid){
    $db = new SQLite3("./db/projekt.db");
    $sql = "DELETE FROM cart_item WHERE cart_id = :cart_id AND prod_id = :prod_id";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':cart_id', $cart_id, SQLITE3_INTEGER);
    $stmt ->bindParam(':prod_id', $pid, SQLITE3_INTEGER);    
    if($stmt->execute()){
        $db ->close();
        return true;
    }
    else{
        $db ->close();
        return false;
    }
}

function isItemInCart($cart_id, $pid){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM cart_item WHERE cart_id = '%s' AND prod_id = '%u'", $cart_id, $pid);
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db ->close();
    if($row){
        return true;
    }
    else{
        return false;
    }
}

/* function to remova all items from cart */
function deleteCartItemsByCardId($cart_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = "DELETE FROM cart_item where cart_id = :cart_id";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':cart_id', $cart_id, SQLITE3_INTEGER);
    $stmt->execute();
    $db ->close();
}

function addOrder($name, $email, $phone, $adress, $totalPrice, $cart_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = "INSERT into 'order' ('order_name', 'order_email', 'order_phone', 'order_adress', 'totalprice', 'cart_id') 
    VALUES (:order_name, :order_email, :order_phone, :order_adress, :totalprice, :cart_id)";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':order_name', $name, SQLITE3_TEXT);
    $stmt ->bindParam(':order_email', $email, SQLITE3_TEXT);
    $stmt ->bindParam(':order_phone', $phone, SQLITE3_TEXT);
    $stmt ->bindParam(':order_adress', $adress, SQLITE3_TEXT);
    $stmt ->bindParam(':totalprice', $totalPrice, SQLITE3_INTEGER);
    $stmt ->bindParam(':cart_id', $cart_id, SQLITE3_INTEGER);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}


function getCommentsByProdId($id){
    $db = new SQLite3("./db/projekt.db");
    $data = array();
    $sql = sprintf("SELECT * FROM comment WHERE prod_id = '%s'", $id);
    $res = $db->query($sql);
    while ($row = $res->fetchArray()){
        array_push($data, $row);
    }
    $db ->close();
    return $data;
}


function addComment($pid, $comment, $user_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = "INSERT into 'comment' ('prod_id', 'comment', 'user_id') 
    VALUES (:prod_id, :comment, :user_id)";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':prod_id', $pid, SQLITE3_INTEGER);
    $stmt ->bindParam(':comment', $comment, SQLITE3_TEXT);
    $stmt ->bindParam(':user_id',  $user_id, SQLITE3_INTEGER);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}   

/*funktion som postar användare i databasen*/ 
function createUser($email,$username,$password_hash){
    $db = new SQLite3("./db/projekt.db");
    $default = 'user';
    $sql = "INSERT into 'user' ('name','email', 'password', 'usercat') 
    VALUES (:name, :email, :password, :usercat)";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':name', $username, SQLITE3_TEXT);
    $stmt ->bindParam(':email', $email, SQLITE3_TEXT);
    $stmt ->bindParam(':password', $password_hash, SQLITE3_TEXT);
    $stmt ->bindParam(':usercat', $default, SQLITE3_TEXT);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}

function fetchUser($email,$password){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $db->escapeString($email));
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db->close();
    
    /*&& password_verify($email, $row["password_hash"])*/
    if($row && password_verify($password, $row["password"])){
        $data = array();
        array_push($data, $row['user_id']);
        array_push($data, $row['name']);
        return $data;
    }
    else{
        return false;
    }
}

function isAdminById($id){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM user WHERE user_id = '%s'", $id);
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $status = $row['usercat'];
    if($status == "admin"){
        return true;
        $db->close();   
    }
    else{
        return false;
        $db->close();   
    }  
}

function deleteCommentById($id){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("DELETE FROM comment WHERE id = '%s'", $id);
    $db->query($sql);
    $db->close();
}

function fetchCords(){
    $db = new SQLite3("./db/projekt.db");
    $sql = "SELECT * FROM cordinate";
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $data = array();
    array_push($data, $row['lat']);
    array_push($data, $row['long']);
    return $data;
    $db->close();
}

function deleteCordinate(){
    $db = new SQLite3("./db/projekt.db");
    $sql = "DELETE FROM cordinate";
    $db->query($sql);
    $db->close();
}

function updateCordinates($lat, $long){
    $db = new SQLite3("./db/projekt.db");
    deleteCordinate();
    $sql = "INSERT into 'cordinate' ('lat', 'long') 
    VALUES (:lat, :long)";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':lat', $lat, SQLITE3_INTEGER);
    $stmt ->bindParam(':long', $long, SQLITE3_INTEGER);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}   

function addProduct($title, $price, $description, $img, $cat){
    $db = new SQLite3("./db/projekt.db");
    $sql = "INSERT into 'product' ('title','price', 'description', 'image', 'cat_id') 
    VALUES (:title, :price, :description, :image, :cat_id)";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':title', $title, SQLITE3_TEXT);
    $stmt ->bindParam(':price',$price, SQLITE3_INTEGER);
    $stmt ->bindParam(':description', $description, SQLITE3_TEXT);
    $stmt ->bindParam(':image', $img, SQLITE3_TEXT);
    $stmt ->bindParam(':cat_id', $cat, SQLITE3_INTEGER);

    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}

function getUserById($id){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM user WHERE user_id = '%s'", $db->escapeString($id));
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db->close();
    return $row;
}

/* creates cart on user login if cart does not exist */
function createCart($user_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM cart WHERE user_id = '%s'", $db->escapeString($user_id)); 
    $res = $db->query($sql);
    $row = $res->fetchArray();
    if(!$row){
        $sql = "INSERT into 'cart' ('user_id') 
        VALUES (:user_id)";
        $stmt = $db ->prepare($sql);
        $stmt ->bindParam(':user_id', $user_id, SQLITE3_INTEGER);
        $stmt->execute();
        $db->close();
    }
    
}

function getCartById($user_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT cart_id FROM cart WHERE user_id = '%s'", $db->escapeString($user_id));
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db->close();
    return $row;
}

function addCartItem($cart_id, $prod_id){
    $db = new SQLite3("./db/projekt.db");
    $sql = "INSERT into 'cart_item' ('cart_id', 'prod_id') 
    VALUES (:cart_id, :prod_id)";
    $stmt = $db ->prepare($sql);
    $stmt ->bindParam(':cart_id', $cart_id, SQLITE3_INTEGER);
    $stmt ->bindParam(':prod_id', $prod_id,  SQLITE3_INTEGER);
    if($stmt->execute()){
        $db->close();
        return true;
    }
    else{
        $db->close();
        return false;
    }
}   

function getCategoryByName($name){
    $db = new SQLite3("./db/projekt.db");
    $sql = sprintf("SELECT * FROM category WHERE cat_name = '%s'", $db->escapeString($name));
    $res = $db->query($sql);
    $row = $res->fetchArray();
    $db->close();
    return $row['cat_id'];
}

?>