<?php
if (isset($_POST["koordinater"]) && isset($_POST["beskrivningar"])) {

    $koordinater = filter_input(INPUT_POST, "koordinater", FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
    $beskrivningar = filter_input(INPUT_POST, "beskrivningar", FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);

    /* Spara i databasen */
    /* Logga in på databasen och skapa en anslutning */
    $conn = new mysqli($hostname, $user, $password, $database);

    /* Kolla om vi har en fungerande anslutning */
    if ($conn->connect_error) {
        die("Kunde inte ansluta till databasen: " . $conn->connect_error);
    }

    foreach ($koordinater as $key => $koordinat) {
        fwrite($handtag, "$koordinat:beskrivningar[$key]" . PHP_EOL);
    }
    /* Anslutningen fungerar. Nu skjuter vi in data i tabellen. */
    $sql = "INSERT INTO sparaderestauranger (rnamn, latitude, longitude) VALUES ('$rnamn', '$lat', '$long')";
    $result = $conn->query($sql);

    /* Kunde sql-satsen köras */
    if (!$result) {
        die("Något blev fel sql-satsen; " . $conn->error);
    } else {
        /* Alert när man lyckats */
        echo "<p class=\"animated bluebox heartBeat\">Klappat och klart!</p>";
    }
    echo "Klart";
} else {
    echo "Inte klart";
}
