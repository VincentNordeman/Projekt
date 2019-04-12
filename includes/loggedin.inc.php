<?php

if ($_SESSION['loggedin']) {
    echo "<a href='logga-ut.php'>Logga ut</a>";
} else {
    echo "<a href='logga-in.php'>Logga in</a>";
}
