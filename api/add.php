<?php
global $conn;
require_once '../db.php';

session_start();
$_SESSION['email'] = "mail";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = "mail";
    $password = $_POST["password"];
    $actif = $_POST["actif"];
    $age = $_POST["age"];
    $createdBy = $_POST["createdBy"];

    $req = $conn->prepare('INSERT INTO users (name, surname, email, password, actif, age, createdBy) VALUES (:name, :surname, :email, :password, :actif, :age, :createdBy)');
    $req->bindParam(':name', $name);
    $req->bindParam(':surname', $surname);
    $req->bindParam(':email', $email);
    $req->bindParam(':password', $password);
    $req->bindParam(':actif', $actif);
    $req->bindParam(':age', $age);
    $req->bindParam(':createdBy', $createdBy);

    $req->execute();
}
?>