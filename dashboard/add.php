<?php
require_once '../auth.php';
isAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Adding new user</title>
</head>

<body class="bg-gray-200 p-8 pb-[150px] flex w-full h-screen w-full flex items-center justify-center">
<div class="max-w-lg mx-auto bg-white p-6 rounded-md">
    <form id="userForm">
        <h2 class="text-2xl font-bold mb-4">Add User</h2>
        <div class="flex gap-10">
            <div class="mb-4" id="name" style="width: 50%;">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                <input class="border-2 w-full border border-gray-300 p-2 rounded-md transition"
                       type="text" name="name" id="name" placeholder="Name">
            </div>

            <div class="mb-4" id="surname" style="width: 50%;">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Surname</label>
                <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="surname"
                       id="surname" placeholder="Surname">
            </div>
        </div>

        <div class="mb-4" id="email">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="email" id="email"
                   oninput="isEmailUsed(this.value)"
                   placeholder="Email">
            <span class="text-red-600 text-[14px] font-bold opacity-0" id="email-message">Email already used</span>
        </div>

        <div class="mb-4" id="password">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password" name="password"
                   id="password" placeholder="Password">
        </div>

        <div class="mb-4" id="age">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="age">Age</label>
            <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="number" name="age" id="age"
                   placeholder="Age">
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
               class="hover:cursor-pointer hover:-translate-y-1 hover:scale-110 bg-blue-500 w-full text-white p-2 rounded-md transition text-center items-center""
            onclick="history.back()">Go Back</a>
            <button class="bg-blue-500 hover:-translate-y-1 hover:scale-110 w-full text-white p-2 rounded-md transition"
                    type="submit" id="submit-btn">
                Add
            </button>
        </div>
    </form>
</div>
<script>
    let accountEnabled = true;

    function accountActivation() {
        const enabled = document.querySelector("#btn__enabled");
        const disabled = document.querySelector("#btn__disabled");
        const text = document.querySelector("#text__enabled");

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

    function isEmailUsed(email) {
        fetch("/api/checkemail.php?email=" + email)
            .then((response) => response.json())
            .then((data) => {
                if (data) {
                    document.querySelector("#email-message").classList.remove("opacity-0");
                    document.querySelector("#submit-btn").disabled = true;
                    document.querySelector("#submit-btn").classList.add("opacity-50");
                } else {
                    document.querySelector("#email-message").classList.add("opacity-0");
                    document.querySelector("#submit-btn").disabled = false;
                    document.querySelector("#submit-btn").classList.remove("opacity-50");
                }
            });
    }

    document.querySelector("#userForm").addEventListener(
        "submit",
        function (event) {
            event.preventDefault();

            const name = document.querySelector("#name input").value;
            const surname = document.querySelector("#surname input").value;
            const email = document.querySelector("#email input").value;
            const password = document.querySelector("#password input").value
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
                return;
            } else {
                document.querySelector("#message").classList.add("opacity-0");
                var data = new FormData();
                data.append("name", name);
                data.append("surname", surname);
                data.append("email", email);
                data.append("password", password);
                data.append("enabled", accountEnabled);
                data.append("age", age);

                fetch("/api/add.php", {
                    method: "POST",
                    body: data,
                })

                window.location.href = `/dashboard?message=Added user ${name}.`
            }
        },
        false,
    );
</script>
</body>
</html>