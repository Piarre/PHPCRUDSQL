<?php

session_start();

global $conn;
require_once '../db.php';

//if (!isset($_SESSION["email"])) {
//    header("Location: ../api/auth/logout.php");
//    exit();
//}

$res = $conn->prepare("DELETE FROM users WHERE id = :id");
$res->bindParam(':id', $_GET['id']);
$res->execute();

header("Location: ../dashboard/index.php");

?>


