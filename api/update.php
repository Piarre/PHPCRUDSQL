<?php
global $conn;
require_once '../db.php';
require_once '../auth.php';
require_once '../manager.php';

isAuth();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $enabled = $_POST["enabled"];
    $age = $_POST["age"];

    $req = $conn->prepare('UPDATE users SET name = :name, surname = :surname, email = :email, password = :password, enabled = :enabled, age = :age WHERE id = :id');
    $req->bindParam(':id', $_POST['id']);
    $req->bindParam(':name', $name);
    $req->bindParam(':surname', $surname);
    $req->bindParam(':email', $email);
    $req->bindParam(':password', $password);
    $req->bindParam(':enabled', $enabled);
    $req->bindParam(':age', $age);

    $req->execute();
}
?>