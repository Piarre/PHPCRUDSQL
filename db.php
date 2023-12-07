<?php

$USERNAME = "root";
$PASSWORD = "";

$conn = new PDO('mysql:host=localhost;dbname=users', $USERNAME, $PASSWORD);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>