<?php

session_start();

global $conn;
require_once '../db.php';
require_once '../auth.php';

isAuth();

$res = $conn->prepare("DELETE FROM users WHERE id = :id");
$res->bindParam(':id', $_GET['id']);
$res->execute();

header("Location: ../dashboard/index.php");

?>