<?php

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    header("Location: index.php");
    exit();
}

function isAuth()
{
    session_start();

    if (!(isset($_SESSION["email"]))) {
        header("Location: index.php");
    }
}

function isDisconnected()
{
    session_start();

    if (isset($_SESSION["email"])) {
        header("Location: dashboard/index.php");
    }
}

?>