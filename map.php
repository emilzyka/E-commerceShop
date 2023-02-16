<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Karta</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin="">
    </script>
    <style>
    #map {
        height: 500px;
        width: 700px;
        border: 1px solid black;
        margin-bottom: 15px;
    }
    </style>
</head>

<body>
    <div class="karta">
        <div id="map"
            class="leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom">
        </div>
    </div>
    <?php
        /* om vi vill visa fler lagerplatser måste vi hämta flera värden från cordsarr 
        samt hämta datan i fetchCords med en loop */
        $cordsarr=fetchCords();
        $lat=$cordsarr[0];
        $long=$cordsarr[1];
    ?>

    <script>
    /*tar emot kordinaterna från db, sparar dem i variabler och sätter view */
    /* laddar apin samt skapar kartan och dess "layers" */
    var long = "<?php echo $long; ?>";
    var lat = "<?php echo $lat; ?>";


    var map = L.map("map").setView([lat, long], 13);
    var attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
    var tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
    var tiles = L.tileLayer(tileUrl, {
        attribution
    });
    tiles.addTo(map);

    /*funktion som agerar on click och skapar marker för användaren samt visar vår marker för lokal */
    var newMarker;
    var startMarker;

    map.on('click', function(e) {

        if (newMarker != undefined) {
            map.removeLayer(newMarker);
        }
        newMarker = L.marker(e.latlng).addTo(map).bindPopup('Du befinner dig här').openPopup();
        startMarker = L.marker([lat, long]).addTo(map).bindPopup(
            'Vår lagerlokal.<br><br> För tillfället enda <br> du kan hämta ifrån.').openPopup();

        /*tar lat och long för punkterna och displayar längden avrundat till meter för användaren */
        _point1 = e.latlng;
        _point2 = new L.latLng(lat, long);

        var length = _point1.distanceTo(_point2);
        document.getElementById("length").innerHTML = Math.round(length) / 1000 + ' km till lager';

    });
    </script>
</body>

</html>