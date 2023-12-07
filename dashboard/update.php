<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Users list</title>
</head>

<body class="bg-gray-100 p-8">

<?php

global $conn;
require_once '../db.php';
require_once '../auth.php';
require_once '../usermanager.php';

isAuth();

$user = getUserById($_GET["id"]);

if ($user == null) {
    header("Location: index.php");
}

?>

<div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md" id="userForm">
    <form>
        <h2 class="text-2xl font-bold mb-4">Update User</h2>

        <div class="mb-4 " id="name">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="name" id="name"
                   placeholder="Name" value="<?php echo $user["name"] ?>" onkeydown="getChanges()">
        </div>

        <div class="mb-4" id="surname">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Surname</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="surname"
                   id="surname" placeholder="Surname" value="<?php echo $user["surname"] ?>" onkeydown="getChanges()">
        </div>

        <div class="mb-4" id="email">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="email" id="email"
                   placeholder="Email" value="<?php echo $user["email"] ?>" onkeydown="getChanges()">
        </div>

        <div class="mb-4" id="password">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password" name="password"
                   id="password" placeholder="Password" value="<?php echo $user["password"] ?>"
                   onkeydown="getChanges()">
        </div>

        <div class="mb-4" id="actif">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="actif">Actif</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="actif" id="actif"
                   placeholder="Actif" value="<?php echo $user["actif"] ?>" onkeydown="getChanges()">
        </div>

        <div class="mb-4" id="age">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="age">Age</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="number" name="age" id="age"
                   placeholder="Age" value="<?php echo $user["age"] ?>" onkeydown="getChanges()">
        </div>

        <span class="text-red-600 text-[14px] font-bold opacity-0" id="message">Please fill all fields</span>
        <div class="flex gap-10 px-4">
            <a type="button"
               class="hover:cursor-pointer bg-blue-500 hover:bg-blue-700 w-full text-white p-2 rounded-md transition text-center items-center""
            onclick="history.back()">Go Back</a>
            <button class="bg-blue-500 w-full text-white p-2 rounded-md opacity-50 transition" disabled type="submit">
                Update
            </button>
        </div>
    </form>
</div>

<script>
    function getChanges() {
        const name = document.querySelector("#name input").value;
        const surname = document.querySelector("#surname input").value;
        const email = document.querySelector("#email input").value;
        const password = document.querySelector("#password input").value;
        const actif = document.querySelector("#actif input").value;
        const age = document.querySelector("#age input").value;

        console.log(age)

        if ((name == "<?php echo $user["name"] ?>")
            || (surname == "<?php echo $user["surname"] ?>")
            || (email == "<?php echo $user["email"] ?>")
            || (password == "<?php echo $user["password"] ?>")
            || (actif == "<?php echo $user["actif"] ?>")
            || (age == "<?php echo $user["age"] ?>")) {
            console.log("changes")
            document.querySelector("button").classList.remove("opacity-50");
            document.querySelector("button").classList.add("hover:bg-blue-700");
            document.querySelector("button").disabled = false;
        } else {
            console.log("no changes")
            document.querySelector("button").classList.add("opacity-50");
            document.querySelector("button").classList.remove("hover:bg-blue-700");
            document.querySelector("button").disabled = true;
        }


        return null;
    }

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
                data.append("id", "<?php echo $user["id"]; ?>")
                data.append("name", name);
                data.append("surname", surname);
                data.append("email", email);
                data.append("password", password);
                data.append("actif", actif);
                data.append("age", age);

                fetch("/api/update.php", {
                    method: "POST",
                    body: data,
                })

                window.location.href = "/dashboard";
            }
        },
        false,
    );
</script>

</body>

</html>