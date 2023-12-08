<?php

isAuth();

global $conn;
require_once '../db.php';
require_once '../auth.php';

$res = $conn->prepare("DELETE FROM users WHERE id = :id");
$res->bindParam(':id', $_GET['id']);
$res->execute();

header("Location: ../dashboard/index.php");

?>