<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logga in</title>
    <link rel="stylesheet" href="css/login.css" />
</head>


<body>
    <h1>Logga in</h1>
    <div class="errormessage">
        <strong>
            <?php
            if(isset($_SESSION["message"])){
                echo($_SESSION["message"]);
                unset($_SESSION["message"]);
            }
                ?>
        </strong>
        </strong>
    </div>
    <form name="loginForm" id="loginForm" method="post" action="process-login.php">
        <fieldset>

            <div class="input">
                <label>Universitets email:</label>
                <input type="text" class="textbox" name="email" id="email" placeholder="john@uu.se" required><br>
            </div>
            <div class="input">
                <label>Lösenord:</label>
                <input type="password" class="textbox" name="password" id="email" placeholder="Enter your password..."
                    required><br>
            </div>
            <div class="center">
                <button class="btn" onclick=loginForm.submit();>
                    <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                        <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                        <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                    </svg>
                    <span>Login</span>
                </button>
            </div>
            </div>
            <div>
                <input type="submit" class="btn" value="Login"> <br>
            </div>
        </fieldset>
    </form>
    <div>
        <h5>Har du inget konto?</h5>
        <div class="center">
            <button class="btn" onclick="location.href='signup.php'" ;>
                <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                    <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                    <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                </svg>
                <span>Skapa nytt konto</span>
            </button>
        </div>
</body>

</html>