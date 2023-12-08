<?php

global $conn;
require_once '../db.php';
require_once '../auth.php';

isAuth();

$res = $conn->prepare("SELECT * FROM users");
$res->execute();
$users = $res->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Users list</title>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-6xl mx-auto">
        <h1 class="mb-4 text-4xl font-bold text-center text-gray-900 md:text-5xl lg:text-6xl">PHP SQL C.R.U.D.</h1>
        <div class="flex justify-center gap-4">
            <a class="bg-violet-500 transition hover:bg-violet-800 my-2  text-white p-2 rounded-md" href="/api/auth/logout.php">
                Logout
            </a>
            <a class="bg-violet-500 transition hover:bg-violet-800 my-2 text-white p-2 rounded-md" href="/dashboard/add.php">
                Add user
            </a>
        </div>
        <table class="min-w-full bg-white border border-gray-300 rounded-md overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Name</th>
                    <th class="py-2 px-4">Surname</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Age</th>
                    <th class="py-2 px-4">Actif</th>
                    <th class="py-2 px-4">Created by</th>
                    <th class="py-2 px-4 w-full">Created at</th>
                    <th class="py-2 w-full">Updated at</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-300 transition">
                        <td class="py-2 px-4">
                            <?php echo $user['id']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['name']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['surname']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['email']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['age']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['actif']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['createdBy']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['createdAt']; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php echo $user['updatedAt']; ?>
                        </td>
                        <td class="py-2 px-4 flex gap-4">
                            <form action="../dashboard/update.php">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 transition duration-200 text-white font-bold py-2 px-4 rounded">
                                    Update
                                </button>
                            </form>
                            <form action="../api/delete.php">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit"
                                        class="bg-rose-600 hover:bg-red-700 transition duration-200 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>

</html>