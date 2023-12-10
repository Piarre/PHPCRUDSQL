<?php

global $conn;
require_once '../db.php';
require_once '../auth.php';
require_once '../manager.php';

isAuth();

$user = getUserById($_GET["id"]);

if ($user == null) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Updating <?php echo $user["name"] ?></title>
</head>

<body class="bg-gray-100 p-8">
<div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md" id="userForm">
    <form>
        <h2 class="text-2xl font-bold mb-4">Update User</h2>

        <div class="mb-4 " id="name">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="name" id="name"
                   placeholder="Name" value="<?php echo $user["name"] ?>" oninput="getChanges()">
        </div>

        <div class="mb-4" id="surname">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Surname</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="surname"
                   id="surname" placeholder="Surname" value="<?php echo $user["surname"] ?>" oninput="getChanges()">
        </div>

        <div class="mb-4" id="email">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="email" id="email"
                   placeholder="Email" value="<?php echo $user["email"] ?>" oninput="getChanges()">
        </div>

        <div class="mb-4" id="password">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password" name="password"
                   id="password" placeholder="Password" value="<?php echo $user["password"] ?>"
                   onkeydown="getChanges()">
        </div>

        <div class="mb-4" id="age">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="age">Age</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="number" name="age" id="age"
                   placeholder="Age" value="<?php echo $user["age"] ?>" oninput="getChanges()">
        </div>

        <div class="mb-4 w-full" id="enabled">
            <label class="block text-gray-700 text-sm font-bold mb-2" id="text__enabled" for="enabled">Account
                enabled</label>
            <div class="flex gap-10 justify-center">
                <button id="btn__enabled"
                        class="bg-blue-500/50 hover:font-bold hover:-translate-y-1 hover:scale-110 transition duration-200 text-white font-bold py-2 px-4 rounded"
                        type="button"
                        disabled onclick="accountActivation()">
                    Enabled
                </button>
                <button id="btn__disabled"
                        class="bg-red-500 hover:-translate-y-1 hover:scale-110 hover:bg-red-700 transition duration-200 text-white font-bold py-2 px-4 rounded"
                        type="button"
                        onclick="accountActivation()">
                    Disabled
                </button>
            </div>
        </div>

        <span class="text-red-600 text-[14px] font-bold opacity-0" id="message">Please fill all fields</span>
        <div class="flex gap-10 px-4">
            <a type="button"
               id="button_back"
               class="hover:cursor-pointer hover:-translate-y-1 font-bold hover:scale-110 bg-blue-500 hover:bg-blue-700 w-full text-white p-2 rounded-md transition text-center items-center"
               onclick="history.back()">Go Back</a>
            <button id="updateButton"
                    class="font-bold bg-blue-500 w-full text-white p-2 rounded-md opacity-50 transition" disabled
                    type="submit">
                Update
            </button>
        </div>
    </form>
</div>

<script>
    let accountEnabled = <?php echo $user["enabled"] ?>;

    function accountActivation() {
        const enabled = document.querySelector("#btn__enabled");
        const disabled = document.querySelector("#btn__disabled");
        const text = document.querySelector("#text__enabled");

        const updateButton = document.querySelector("#updateButton");
        updateButton.classList.remove("opacity-50");
        updateButton.classList.add("hover:bg-blue-700", "hover:-translate-y-1", "hover:scale-110");
        updateButton.disabled = false;

        if (enabled.classList.contains("bg-blue-500/50")) {
            enabled.classList.remove("bg-blue-500/50");
            enabled.classList.add("bg-blue-500");
            enabled.classList.add("hover:bg-blue-700");

            disabled.classList.remove("bg-red-500");
            disabled.classList.remove("hover:bg-red-700");
            disabled.classList.add("bg-red-500/50");

            disabled.disabled = true
            enabled.disabled = false
            disabled.value = 0;
            enabled.value = 1;

            text.innerHTML = "Account disabled"
            accountEnabled = false;
        } else {
            enabled.classList.remove("bg-blue-500");
            enabled.classList.remove("hover:bg-blue-700");
            enabled.classList.add("bg-blue-500/50");

            disabled.classList.remove("bg-red-500/50");
            disabled.classList.add("bg-red-500");
            disabled.classList.add("hover:bg-red-700");

            disabled.disabled = false
            enabled.disabled = true
            disabled.value = 1;
            enabled.value = 0;

            text.innerHTML = "Account enabled"
            accountEnabled = true;
        }
    }

    let initialValues = {
        name: "",
        surname: "",
        email: "",
        password: "",
        age: ""
    };

    document.addEventListener("DOMContentLoaded", function () {
        initialValues = {
            name: document.querySelector("#name input").value,
            surname: document.querySelector("#surname input").value,
            email: document.querySelector("#email input").value,
            password: document.querySelector("#password input").value,
            age: document.querySelector("#age input").value
        };
    });

    function getChanges() {
        const currentValues = {
            name: document.querySelector("#name input").value,
            surname: document.querySelector("#surname input").value,
            email: document.querySelector("#email input").value,
            password: document.querySelector("#password input").value,
            age: document.querySelector("#age input").value
        };

        const hasChanges =
            currentValues.name !== initialValues.name ||
            currentValues.surname !== initialValues.surname ||
            currentValues.email !== initialValues.email ||
            currentValues.password !== initialValues.password ||
            currentValues.age !== initialValues.age;

        const updateButton = document.querySelector("#updateButton");
        document.querySelector(accountEnabled ? "#btn__enabled" : "#btn__disabled").click();
        if (hasChanges) {
            updateButton.classList.remove("opacity-50");
            updateButton.classList.add("hover:bg-blue-700", "hover:-translate-y-1", "hover:scale-110");
            updateButton.disabled = false;
        } else {
            updateButton.classList.add("opacity-50");
            updateButton.classList.remove("hover:bg-blue-700", "hover:-translate-y-1", "hover:scale-110");
            updateButton.disabled = true;
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

            if (age === "" || age === 0) {
                document.querySelector("#age input").classList.remove("border-gray-300");
                document.querySelector("#age input").classList.add("border-red-500");
            }

            if (name === "" || surname === "" || email === "" || password === "" || (age === "" || age === 0)) {
                document.querySelector("#message").classList.remove("opacity-0");

            } else {
                document.querySelector("#message").classList.add("opacity-0");
                const data = new FormData();
                data.append("id", "<?php echo $user["id"]; ?>")
                data.append("name", name);
                data.append("surname", surname);
                data.append("email", email);
                data.append("password", password);
                data.append("enabled", accountEnabled ? 1 : 0);
                data.append("age", age);

                fetch("/api/update.php", {
                    method: "POST",
                    body: data,
                })

                window.location.href = "/dashboard?message=Updated user <?php echo $user["name"]; ?>."
            }
        },
        false,
    );
</script>

</body>

</html>