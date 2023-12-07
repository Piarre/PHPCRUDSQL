<?php

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