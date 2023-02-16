<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <script type="text/javascript" src="js/validateSignup.js"></script>
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>
    <h1>Skapa konto</h1>
    <div class="errormessage">
        <strong>
            <?php
            if(isset($_SESSION["message"])){
                echo($_SESSION["message"]);
                unset($_SESSION["message"]);
            }
            
            ?>
        </strong>
    </div>
    <div>
        <form name="newaccount" id="newaccount" method="post" action="process-signup.php" onsubmit="validateform()">
            <fieldset>
                <div class="input">
                    <label>University email:</label>
                    <input type="text" class="textbox" name="email" id="email" placeholder="john@uu.se" required><br>
                </div>
                <div class="input">
                    <label>Användarnamn:</label>
                    <input type="text" class="textbox" name="username" id="username" placeholder="Användarnamn"
                        required><br>
                </div>
                <div class="input">
                    <label>Lösenord:</label>
                    <input type="password" class="textbox" id="password" name="password" placeholder="Lösenord"
                        required><br>
                </div>
                <div class="input">
                    <label>Återupprepa lösenord:</label>
                    <input type="password" class="textbox" id="password2" name="password2"
                        placeholder="Ange lösenord igen" required><br>
                    <div class="container">
                        <button class="btn" onclick=newaccount.submit();>
                            <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                                <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                                <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                            </svg>
                            <span>Skapa konto</span>
                        </button>

                    </div>

                </div>
            </fieldset>
        </form>
        <div class="btm">
            <br>
            <br>
            <h5>Har du redan ett konto?</h5>
            <div class="center">
                <button onclick="location.href='login.php'" class="btn" ;>
                    <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                        <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                        <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                    </svg>
                    <span>Gå til login</span>
                </button>
            </div>
        </div>
    </div>
    </div>
    <div class="bottomImg">
        <img src="img/logot.png" ;>

    </div>
</body>

</html>