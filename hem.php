<?php

session_start();

if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = false;
}
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Startsida</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">

        <header>
            <h1>Skol Reviews</h1>
            <nav>
                <a class="aktiv" href="#">Startsida</a>
                <a href="favo.php">Favorit Restauranger</a>
                <a href="skapa.php">Skapa Konto</a>
                <?php include_once "./includes/loggedin.inc.php";?>
            </nav>
        </header>

        <main class="hem">
            <section class="col3">
                <img src="./bilder/karta.png" alt="">
            </section>
            <section class="col3">
                <img src="./bilder/rev.png" alt="">
            </section>
            <section class="drop">
                <div class="dropdown">
                    <button class="dropbtn">Restauranger</button>
                    <div class="dropdown-content">
                        <a href="#">Mamma Mia</a>
                        <a href="#">La Grande</a>
                        <a href="#">Subway</a>
                        <a href="#">Hemköp</a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>