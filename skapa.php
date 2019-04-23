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
    <title>Skapa användare</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/animate.css">
</head>

<body>
    <div class="container">

        <header>
            <h1>Skol Reviews</h1>
            <nav>
                <a href="hem.php">Startsida</a>
                <a href="favo.php">Favorit Restauranger</a>
                <a class="aktiv" href="#">Skapa Konto</a>
                <?php include_once "./includes/loggedin.inc.php";?>
            </nav>
        </header>

        <main class="registrera">
            <form action="#" method="post">
                <input id="gmail" placeholder="Gmail" type="text" name="gmail" required require value="<?php echo isset($_POST['gmail']) ? $_POST['gmail'] : '' ?>">
                <input id="fnamn" placeholder="Förnamn" type="text" name="fnamn" required require value="<?php echo isset($_POST['fnamn']) ? $_POST['fnamn'] : '' ?>">
                <input id="enamn" placeholder="Efternamn" type="text" name="enamn" required require value="<?php echo isset($_POST['enamn']) ? $_POST['enamn'] : '' ?>">
                <input id="losen" placeholder="Lösenord" type="password" name="losen" required>
                <input id="ulosen" placeholder="Upprepa lösenord" type="password" required>
                <button>Registrera</button>
            </form>

            <?php
/* Ta emot data från form och lagra i tabellen. */
if (isset($_POST["gmail"], $_POST["fnamn"], $_POST["enamn"], $_POST["losen"])) {

    /* Skydda mot farligheter */
    $gmail = filter_input(INPUT_POST, "gmail", FILTER_SANITIZE_STRING);
    $fnamn = filter_input(INPUT_POST, "fnamn", FILTER_SANITIZE_STRING);
    $enamn = filter_input(INPUT_POST, "enamn", FILTER_SANITIZE_STRING);
    $losen = filter_input(INPUT_POST, "losen", FILTER_SANITIZE_STRING);

    /* Logga in på databasen och skapa en anslutning */
    $conn = new mysqli($hostname, $user, $password, $database);

    /* Kolla om vi har en fungerande anslutning */
    if ($conn->connect_error) {
        die("Kunde inte ansluta till databasen: " . $conn->connect_error);
    }

    /* Räkna hashet på lösenordet */
    $hash = password_hash($losen, PASSWORD_DEFAULT);

    $check = "SELECT * FROM admin WHERE gmail = '$gmail'";
    $rs = mysqli_query($conn, $check);
    $data = mysqli_fetch_array($rs, MYSQLI_NUM);
    if ($data[0] > 1) {
        echo "<p class=\"animated bluebox jackInTheBox\">Gmail finns redan!</p>";
    } else {

        /* Anslutningen fungerar. Nu skjuter vi in data i tabellen. */
        $sql = "INSERT INTO admin (gmail, fnamn, enamn, hash) VALUES ('$gmail', '$fnamn', '$enamn', '$hash')";
        $result = $conn->query($sql);

        /* Kunde sql-satsen köras */
        if (!$result) {
            die("Något blev fel sql-satsen; " . $conn->error);
        } else {
            /* Alert när man lyckats skapa ett konto */
            echo "<p class=\"animated bluebox heartBeat\">Klappat och klart!</p>";
        }
    }
}
?>

        </main>
    </div>
    <script src="./js/scripts.js"></script>
</body>

</html>