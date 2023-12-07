<?php

function getCreatorEmail($id)
{
    global $conn;
    $req = $conn->prepare('SELECT email FROM users WHERE id = :id');
    $req->bindParam(':id', $id);
    $req->execute();
    $user = $req->fetch();
    return $user["email"];
}

function getUserById($id)
{
    global $conn;
    $req = $conn->prepare('SELECT * FROM users WHERE id = :id');
    $req->bindParam(':id', $id);
    $req->execute();
    $user = $req->fetch();
    return $user;
}

?>