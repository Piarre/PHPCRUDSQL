<!DOCTYPE html>
<html lang="fr">
<head>
    <title>PHP Test</title>
</head>
<body>
<form action="api/auth/login.php" method="post">

    <h2>LOGIN</h2>

    <?php

    session_start();

    if (isset($_SESSION["email"])) {
        header("Location: dashboard/index.php");
    }
    ?>

    <label>User Name</label>

    <input type="text" name="email" placeholder="User Name"><br>

    <label>Password</label>

    <input type="password" name="password" placeholder="Password"><br>

    <button type="submit">Login</button>
</body>
</html