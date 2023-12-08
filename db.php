<?php

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
    header("Location: index.php");
    exit();
}

$USERNAME = "root";
$PASSWORD = "password";

try {
    $conn = new PDO('mysql:host=dlocalhost;dbname=lemoine', $USERNAME, $PASSWORD);
} catch (PDOException $e) {
    header("Location: /error.php?error=databaseConn&message=" . $e->getMessage());
    exit();
}

?>