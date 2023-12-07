<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: /index.php");
}

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

<div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md" id="userForm">
    <form>
        <h2 class="text-2xl font-bold mb-4">Add User</h2>

        <div class="mb-4 " id="name">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="name" id="name"
                   placeholder="Name">
        </div>

        <div class="mb-4" id="surname">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Surname</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="surname" id="surname"
                   placeholder="Surname">
        </div>

        <div class="mb-4" id="email">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="email" id="email"
                   placeholder="Email">
        </div>

        <div class="mb-4" id="password">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password" name="password"
                   id="password"
                   placeholder="Password">
        </div>

        <div class="mb-4" id="actif">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="actif">Actif</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="actif" id="actif"
                   placeholder="Actif">
        </div>

        <div class="mb-4" id="age">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="age">Age</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="number" name="age" id="age"
                   placeholder="Age">
        </div>

        <span class="text-red-600 text-[14px] font-bold opacity-0" id="message">Please fill all fields</span>
        <button class="bg-blue-500 w-full text-white p-2 rounded-md" type="submit">Add</button>
    </form>
</div>

<script>
    document.querySelector("#userForm").addEventListener(
        "submit",
        function (event) {
            event.preventDefault();

            const name = document.querySelector("#name input").value;
            const surname = document.querySelector("#surname input").value;
            const email = document.querySelector("#email input").value;
            const password = document.querySelector("#password input").value;
            const actif = document.querySelector("#actif input").value;
            const age = document.querySelector("#age input").value;

            if (name === "") {
                document.querySelector("#name input").classList.remove("border-gray-300");
                document.querySelector("#name input").classList.add("border-red-500");
            }

            if (surname === "") {
                document.querySelector("#surname input").classList.remove("border-gray-300");
                document.querySelector("#surname input").classList.add("border-red-500");
            }

            if (email === "") {
                document.querySelector("#email input").classList.remove("border-gray-300");
                document.querySelector("#email input").classList.add("border-red-500");
            }

            if (password === "") {
                document.querySelector("#password input").classList.remove("border-gray-300");
                document.querySelector("#password input").classList.add("border-red-500");
            }

            if (actif === "") {
                document.querySelector("#actif input").classList.remove("border-gray-300");
                document.querySelector("#actif input").classList.add("border-red-500");
            }

            if (age === "" || age === 0) {
                document.querySelector("#age input").classList.remove("border-gray-300");
                document.querySelector("#age input").classList.add("border-red-500");
            }

            if (name === "" || surname === "" || email === "" || password === "" || actif === "" || (age === "" || age === 0)) {
                document.querySelector("#message").classList.remove("opacity-0");
                return;
            } else {
                document.querySelector("#message").classList.add("opacity-0");
                var data = new FormData();
                data.append("name", name);
                data.append("surname", surname);
                data.append("email", email);
                data.append("password", password);
                data.append("actif", actif);
                data.append("age", age);

                fetch("/api/add.php", {
                    method: "POST",
                    body: data,
                })
            }
        },
        false,
    );
</script>

</body>
</html>
