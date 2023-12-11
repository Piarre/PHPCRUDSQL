<?php

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    header("Location: index.php");
    exit();
}

$USERNAME = "root";
$PASSWORD = "IDP34+1";

try {
    $conn = new PDO('mysql:host=localhost;dbname=lemoine', $USERNAME, $PASSWORD);
} catch (PDOException $e) {
    header("Location: /error.php?error=databaseConn&message=" . $e->getMessage());
    exit();
}

?>