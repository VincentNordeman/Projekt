<?php
/*
 * PHP version 7
 * @category   Skol reviews
 * @author     Vincent Nordeman <vincentnordeman@gmail.com>
 * @license    PHP CC
 */

error_reporting(E_ALL);
ini_set("isplay_errors", 1);

include_once "./config-db.php";
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skapa användare</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">

        <header>
            <h1>Skol Reviews</h1>
            <nav>
                <a href="hem.php">Startsida</a>
                <a href="favo.php">Favorit Restauranger</a>
                <a class="aktiv" href="#">Skapa Konto</a>
                <a href="logga.php">Logga in</a>
            </nav>
        </header>

        <main class="registrera">
            <form action="#" method="post">
                <input placeholder="Gmail" type="text" name="gmail">
                <input placeholder="Förnamn" type="text" name="fnamn">
                <input placeholder="Efternamn" type="text" name="enamn">
                <input placeholder="Lösenord" type="password" name="losen">
                <button>Registrera</button>
            </form>
            <?php
/* Ta emot data från form och lagra i tabellen. */
if (isset($_POST["gmail"]) && isset($_POST["fnamn"]) && isset($_POST["enamn"]) && isset($_POST["losen"])) {
    /* Skydda mot farligheter */
    $gmail = filter_input(INPUT_POST, "gmail", FILTER_SANITIZE_STRING);
    $fnamn = filter_input(INPUT_POST, "fnamn", FILTER_SANITIZE_STRING);
    $enamn = filter_input(INPUT_POST, "enamn", FILTER_SANITIZE_STRING);
    $losen = filter_input(INPUT_POST, "losen", FILTER_SANITIZE_STRING);

    /* Logga in på databasen och skapa en anslutning */

    $conn = new mysqli($hostname, $user, $password, $database);

    /* Kolla om vi har en fungerane anslutning */
    if ($conn->connect_error) {
        die("Kunde inte ansluta till databasen: " . $conn->connect_error);
    }

    /* Räkna hashet på lösenordet */
    $hash = password_hash($losen, PASSWORD_DEFAULT);

    /* Anslutningen fungerar. Nu skjuter vi in data i tabellen. */
    $sql = "INSERT INTO admin (gmail, fnamn, enamn, hash) VALUES ('$gmail', '$fnamn', '$enamn', '$hash')";
    $result = $conn->query($sql);

    /* Kunde sql-satsen köras */
    if (!$result) {
        die("Något blev fel sql-satsen; " . $conn->connect_error);
    }
}
?>
        </main>
    </div>
</body>

</html>