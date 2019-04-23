<?php

session_start();

/* Logga ut session */
$_SESSION["anamn"] = null;
$_SESSION["loggedin"] = false;

header("location: hem.php");
