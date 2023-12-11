<?php
global $conn;
require_once '../functions/db.php';
require_once '../functions/auth.php';

isAuth();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!(isset($_POST["name"])) || !(isset($_POST["surname"])) || !(isset($_POST["email"])) || !(isset($_POST["password"])) || !(isset($_POST["enabled"])) || !(isset($_POST["age"]))) {
        header("Content-Type: application/json");
        echo json_encode(array("error" => "Missing name, surname, email, password, enabled or age."));
        exit();
    }
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $enabled = $_POST["enabled"];
    $age = $_POST["age"];
    if (isset($_SESSION["email"])) {
        $createdBy = $_SESSION["email"];
    } else {
        $createdBy = "SYSTEM | REGISTERED USER";
    }

    $req = $conn->prepare('INSERT INTO users (name, surname, email, password, enabled, age, createdBy) VALUES (:name, :surname, :email, :password, :enabled, :age, :createdBy)');
    $req->bindParam(':name', $name);
    $req->bindParam(':surname', $surname);
    $req->bindParam(':email', $email);
    $req->bindParam(':password', $password);
    $req->bindParam(':enabled', $enabled);
    $req->bindParam(':age', $age);
    $req->bindParam(':createdBy', $createdBy);

    $req->execute();
}