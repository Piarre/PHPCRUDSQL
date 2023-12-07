<?php

$USERNAME = "root";
$PASSWORD = "IDP34+1";

$conn = new PDO('mysql:host=localhost;dbname=lemoine', $USERNAME, $PASSWORD);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>