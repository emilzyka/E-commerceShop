<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/test.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- https://www.countryflagsapi.com/#howToUse -->
</head>

<body>
    <div class="exhangeCard">
        <header>Convert currency</header>
        <form action="#">
            <div class="dropList">
                <div class="from">
                    <p>From</p>
                    <div class="select">
                        <img src="https://countryflagsapi.com/png/us">
                        <select>
                            <option value="usd">USD</option>
                            <option value="eur">EUR</option>
                            <option value="sek">SEK</option>
                        </select>
                    </div>
                </div>
                <div class="to">
                    <p>To</p>
                    <div class="select">
                        <img src="https://countryflagsapi.com/png/us">
                        <select>
                            <option value="usd">USD</option>
                            <option value="eur">EUR</option>
                            <option value="sek">SEK</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="echange">1EUR = 11.05 SEK</div>
            <button>Get exchange rate</button>
        </form>
    </div>

    <script src="test.js"></script>

</body>

</html>