<?php

global $conn;
require_once '../../db.php';
require_once '../../auth.php';

isDisconnected();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $req = $conn->prepare('SELECT * FROM users WHERE email = :email and password = :password');
    $req->bindParam(':email', $email);
    $req->bindParam(':password', $password);

    $req->execute();
    $user = $req->fetch();

    if ($user) {
        if ($user["enabled"] == 0) {
            header("Location: ../../index.php?error=disabled");
            return;
        }
        $_SESSION["email"] = $email;
        $_SESSION["id"] = $user["id"];
        header("Location: /dashboard/index.php");
    } else {
        header("Location: ../../index.php?error=id");
    }

}