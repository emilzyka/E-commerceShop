<?php
require __DIR__ . '/db.php';
session_start();

/* add new cordinates to db */
if(isset($_POST['lat']) && isset($_POST['long'])){
    if(is_numeric($_POST['lat']) && is_numeric($_POST['long'])){
        updateCordinates($_POST['lat'], $_POST['long']);
        $_SESSION["message"] = "Lagerplats tillagd i databas!";
        header('location: adminPage.php');
        exit;
    }
    else{
        $_SESSION["message"] = "Ogitligt format på 'lat' och 'long'";
    }
}

if (isset($_FILES['file'])) {
    $allowedExt = ["jpg", "png"];

    $file = $_FILES["file"];
    $name = $_FILES["file"]["name"];
    $tmp = $_FILES["file"]["tmp_name"];
    $size = $_FILES["file"]["size"];
    $error = $_FILES["file"]["error"];  
    $type = $_FILES["file"]["type"];
  
    $fileExt = explode(".", $name);
    $extName = strtolower(end($fileExt));
  
    if (in_array($extName, $allowedExt)) {
      if ($error == 0) {
        if ($size < 2500000) {
            if(isset($_POST['title']) && 
                isset($_POST['pris']) && 
                isset($_POST['beskrivning']) && 
                isset($_POST['cat'])){
                $salt = uniqid("", true);
                $newName = $salt . "product" . '.' . $extName;
                $destination = "img/" . $newName;
                move_uploaded_file($tmp, $destination);
                $cat_id = getCategoryByName($_POST['cat']);
                addProduct($_POST['title'], $_POST['pris'], $_POST['beskrivning'], $newName, $cat_id);
                echo "Produkt tillagd i databasen! ";
            }
        } else {
            echo "Filen är för stor!";
        }
      } else {
        echo "Error vid filuppladdning";
      }
    } else {
        echo "Filtypen är inte tillåten";
    }
}