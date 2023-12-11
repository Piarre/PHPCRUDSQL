<?php
session_start();
session_destroy();
if (!(isset($_SESSION["email"]))) {
    header("Content-Type: application/json");
    echo json_encode(array("error" => "You are not logged in."));
}
exit();
?>