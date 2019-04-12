<?php
/*
 * PHP version 7
 * @category   Skol reviews
 * @author     Vincent Nordeman <vincentnordeman@gmail.com>
 * @license    PHP CC
 */

/* error_reporting(E_ALL);
ini_set("isplay_errors", 1); */

include_once "{$_SERVER["DOCUMENT_ROOT"]}/../config/config-db.inc.php";

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
    <title>Favorit</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">

        <header>
            <h1>Skol Reviews</h1>
            <nav>
                <a href="hem.php">Startsida</a>
                <a class="aktiv" href="#">Favorit Restauranger</a>
                <a href="skapa.php">Skapa Konto</a>
                <?php include_once "./includes/loggedin.inc.php";?>
            </nav>
        </header>

        <main class="favoMain">
            <section class="karta">
                <img src="./bilder/karta.png" alt="">
            </section>
            <section class="favoLista">
                <ul>
                    <li>Grande</li>
                    <li>Mamma Mia</li>
                    <li>Subway</li>
                </ul>
            </section>

            <form action="#" method="post">
                <input id="rnamn" placeholder="Restaurang" type="text" name="rnamn" required>
                <input id="lat" placeholder="Latitude" type="text" name="lat" required>
                <input id="long" placeholder="Longitude" type="text" name="long" required>
                <button>Registrera Restaurang</button>
            </form>

            <?php
/* Ta emot data från form och lagra i tabellen. */
if (isset($_POST["rnamn"]) && isset($_POST["lat"]) && isset($_POST["long"])) {

    /* Skydda mot farligheter */
    $rnamn = filter_input(INPUT_POST, "rnamn", FILTER_SANITIZE_STRING);
    $lat = filter_input(INPUT_POST, "lat", FILTER_SANITIZE_STRING);
    $long = filter_input(INPUT_POST, "long", FILTER_SANITIZE_STRING);

    /* Logga in på databasen och skapa en anslutning */
    $conn = new mysqli($hostname, $user, $password, $database);

    /* Kolla om vi har en fungerande anslutning */
    if ($conn->connect_error) {
        die("Kunde inte ansluta till databasen: " . $conn->connect_error);
    }

    /* Anslutningen fungerar. Nu skjuter vi in data i tabellen. */
    $sql = "INSERT INTO sparaderestauranger (rnamn, latitude, longitude) VALUES ('$rnamn', '$lat', '$long')";
    $result = $conn->query($sql);

    /* Kunde sql-satsen köras */
    if (!$result) {
        die("Något blev fel sql-satsen; " . $conn->error);
    } else {
        /* Alert när man lyckats skapa ett konto */
        echo "<script>alert('Klappat & klart!')</script>";
    }
}
?>
        </main>
    </div>
</body>

</html>