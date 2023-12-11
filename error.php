<?php

if ($_GET['error'] != "databaseConn" || !isset($_GET['message'])) {
    header("Location: ./index.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="main.css">
    <title>Error</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-200">
<div class="bg-rose-300 p-8 rounded-lg">
    <p class="text-red-600 text-xl font-bold text-wrap">Error : Database connection</p>
    <p class="text-gray-600 text-lg text-wrap mb-4"><?php echo $_GET['message'] ?></p>
    <button class="hover:scale-110 hover:-translate-y-1 bg-red-500 w-20 text-white p-2 rounded-md transition font-bold" onclick="history.back()">Go back</button>
</div>
</body>
</html>