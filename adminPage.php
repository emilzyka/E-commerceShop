<?php
require __DIR__ . '/db.php';
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
if(!isAdminById($_SESSION['user_id'])){
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</head>

<body>

    <?php require('views/_header.php') ?>

    <div class="mbox">
        <p class="intro">Hej Admin! Som admin kan du ladda upp nya produkter i databasen genom att fylla i produktinfon
            nedan. Du kan också uppdatera lagerplatser i databasen nedan. Slutligen har du även möjligthet att ta bort
            recensioner för enskilda produkter genom att navigerar till produktens recensioner.
        </p>
    </div>

    <div class="pbox">
        <h2>Lägg till produkt i databas:</h2>
        <form class="nyprodukt">
            <input type="text" class="title" name="title" id="title" placeholder="Rubrik" required><br>
            <input type="text" class="pris" name="pris" id="pris" placeholder="Pris" required><br>
            <input type="text" class="beskrivning" name="beskrivning" id="beskrivning" placeholder="Produkt beskrivning"
                required><br>
            <label>Ladda upp bild:</label>
            <input type="file" class="file" name="file" id="file" required><br>

            <select class="cat" name="cat" id="cat" required>
                <option>kläder</option>
                <option>böcker</option>
                <option>hem</option>
                <option>elektronik</option>
            </select><br>
            <input type="submit" value="Lägg till!">
        </form>
    </div>

    <div class="lager">
        <h2>Uppdatera lagerplats i databasen</h2>
        <form class="uppdateraLagerplatser" action="process-admin.php" method="post" required>
            <label for="lat">Lat:</label>
            <input type="text" class="lat" name="lat" id="lat" placeholder="55.6" required><br>
            <label for="long">Long:</label>
            <input type="text" class="long" name="long" id="long" placeholder="25.2" required><br>
            <input type="submit" value="Lägg till!">
        </form>
    </div>

    <p class="errorMsg">
        <?php 
    if(isset($_SESSION["message"])){
    echo($_SESSION["message"]);
    unset($_SESSION["message"]);
    }
    ?>
    </p>

    <script>
    $(document).ready(function() {
        $(".nyprodukt").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'process-admin.php',
                type: 'post',
                data: formData,
                success: function(response) {
                    alert(response)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
    </script>

</body>

</html>