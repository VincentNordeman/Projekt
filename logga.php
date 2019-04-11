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
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logga In</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">

        <header>
            <h1>Skol Reviews</h1>
            <nav>
                <a href="hem.php">Startsida</a>
                <a href="favo.php">Favorit Restauranger</a>
                <a href="skapa.php">Skapa Konto</a>
                <a class="aktiv" href="#">Logga in</a>
            </nav>
        </header>

        <main class="loggaIn">
            <form action="#" method="post">
                <input id="gmail" placeholder="Gmail" type="text" name="gmail">
                <input id="losen" placeholder="Lösenord" type="password" name="losen">
                <button>Logga in</button>
            </form>
            <?php
/* Ta emot data från form och lagra i tabellen. */
if (isset($_POST["gmail"]) && isset($_POST["losen"])) {
    /* Skydda mot farligheter */
    $gmail = filter_input(INPUT_POST, "gmail", FILTER_SANITIZE_STRING);
    $losen = filter_input(INPUT_POST, "losen", FILTER_SANITIZE_STRING);

    /* Logga in på databasen och skapa en anslutning */
    $conn = new mysqli($hostname, $user, $password, $database);

    /* Kolla om vi har en fungerande anslutning */
    if ($conn->connect_error) {
        die("Kunde inte ansluta till databasen: " . $conn->connect_error);
    }

    /* Anslutningen fungerar. Nu söker vi efter användaren i tabellen */
    $sql = "SELECT * FROM admin WHERE gmail = '$gmail'";
    $result = $conn->query($sql);

    /* Kunde sql-satsen köras */
    if (!$result) {
        die("Något blev fel sql-satsen; " . $conn->error);
    } else {
        /* Hämta endast en träff */
        $user = $result->fetch_assoc();

        echo $user["fnamn"] . " " . $user["hash"];

        /* Nu ska vi jämföra lösenordet med hashen */
        if (password_verify($losen, $user["hash"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["anamn"] = $user["$gmail"];
        } else {
            /* Alert när man lyckats skapa ett konto */
            echo "<script>alert(Fel lösenord! Försök igen!')</script>";
        }
    }
}
?>

        </main>
    </div>
</body>

</html>