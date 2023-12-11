<?php

global $conn;
require_once '../functions/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email = $_GET["email"];

    $req = $conn->prepare('SELECT * FROM users WHERE email = :email');
    $req->bindParam(':email', $email);
    $req->execute();

    $user = $req->fetch();

    if ($user) {
        echo "true";
    } else {
        echo "false";
    }

}