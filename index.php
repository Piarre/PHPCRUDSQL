<?php
require_once 'auth.php';
session_start();
if (isset($_SESSION["email"])) {
    header("Location: ./dashboard");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>PHP Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<div class="max-w-5xl mx-auto">
    <h1 class="mb-4 text-4xl font-bold text-center text-gray-900 md:text-5xl lg:text-6xl">PHP SQL
        C.R.U.D.</h1>
    <h2 class="mb-4 text-3xl font-bold text-center text-gray-900 md:text-5xl lg:text-6xl">Index</h2>

    <div class="flex gap-10">
        <div class="login w-1/2">
            <form action="api/auth/login.php" method="post">
                <div class="mb-4" id="email">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="text">Email</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="email"
                           id="email"
                           placeholder="Email">
                </div>

                <div class="mb-4" id="password">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password"
                           name="password"
                           id="password" placeholder="Password">
                </div>

                <?php if (isset($_GET["error"]) && ($_GET["error"] == "id")) { ?>
                    <span class="text-red-600 text-[16px] font-bold" id="message">Email or password incorrect</span>
                <?php } ?>
                <?php if (isset($_GET["error"]) && ($_GET["error"] == "disabled")) { ?>
                    <span class="text-red-600 text-[16px] font-bold" id="message">Account disabled</span>
                <?php } ?>
                <div class="flex items-center gap-[5px] mx-10">
                    <button class="bg-blue-500 font-bold text-lg hover:-translate-y-1 hover:scale-110 transition hover:bg-blue-700 my-2 w-full text-white p-2 rounded-md"
                            type="submit">
                        Login
                    </button>
                </div>
            </form>
        </div>

        <div class="register w-1/2">
            <form id="register-form">
                <div class="mb-4" id="name">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="name"
                           id="name"
                           placeholder="Name">
                </div>

                <div class="mb-4" id="surname">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="surname">Surname</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="surname"
                           id="surname" placeholder="Surname">
                </div>

                <div class="mb-4" id="email">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="email"
                           id="email"
                           oninput="isEmailUsed(this.value)"
                           placeholder="Email">
                    <span class="text-red-600 text-[14px] font-bold opacity-0"
                          id="email-message">Email already used</span>
                </div>

                <div class="mb-4" id="password">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password"
                           name="password"
                           id="password" placeholder="Password">
                </div>

                <div class="mb-4" id="age">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="age">Age</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="age"
                           id="age"
                           placeholder="Age">
                </div>

                <div class="mb-4 w-full" id="enabled">
                    <label class="block text-gray-700 text-sm font-bold mb-2" id="text__enabled" for="enabled">Account
                        enabled</label>
                    <div class="flex gap-10 justify-center">
                        <button id="btn__enabled"
                                class="bg-blue-500/50 hover:bg-blue-700  hover:-translate-y-1 hover:scale-110 transition duration-200 text-white font-bold py-2 px-4 rounded"
                                disabled onclick="accountActivation()">
                            Enabled
                        </button>
                        <button id="btn__disabled"
                                class="bg-red-500 hover:bg-red-700 hover:font-bold hover:-translate-y-1 hover:scale-110 transition duration-200 text-white font-bold py-2 px-4 rounded"
                                onclick="accountActivation()">
                            Disabled
                        </button>
                    </div>
                </div>

                <span class="text-red-600 text-[14px] font-bold opacity-0"
                      id="message">Please fill all fields</span>
                <div class="flex items-center gap-[5px] mx-10">
                    <button id="register-btn"
                            class="bg-blue-500 hover:-translate-y-1 hover:scale-110 transition hover:bg-blue-700 my-2 w-full text-white p-2 rounded-md">
                        Register
                    </button>
                </div>
            </form>
        </div>
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
                        document.querySelector("#register-btn").disabled = true;
                        document.querySelector("#register-btn").classList.add("opacity-50");
                    } else {
                        document.querySelector("#email-message").classList.add("opacity-0");
                        document.querySelector("#register-btn").disabled = false;
                        document.querySelector("#register-btn").classList.remove("opacity-50");
                    }
                });
        }

        document.querySelector("#register-form").addEventListener(
            "submit",
            function (event) {
                event.preventDefault();

                const name = document.querySelector("#register-form #name input").value;
                const surname = document.querySelector("#register-form #surname input").value;
                const email = document.querySelector("#register-form #email input").value;
                const password = document.querySelector("#register-form #password input").value;
                const age = document.querySelector("#register-form #age input").value;

                if (name === "") {
                    document.querySelector("#register-form #name>input").classList.remove("border-gray-300");
                    document.querySelector("#register-form #name>input").classList.add("border-red-500");
                }

                if (surname === "") {
                    document.querySelector("#register-form #surname input").classList.remove("border-gray-300");
                    document.querySelector("#register-form #surname input").classList.add("border-red-500");
                }

                if (email === "") {
                    document.querySelector("#register-form #email input").classList.remove("border-gray-300");
                    document.querySelector("#register-form #email input").classList.add("border-red-500");
                }

                if (password === "") {
                    document.querySelector("#register-form #password input").classList.remove("border-gray-300");
                    document.querySelector("#register-form #password input").classList.add("border-red-500");
                }

                if (age === "" || age === 0) {
                    document.querySelector("#register-form #age input").classList.remove("border-gray-300");
                    document.querySelector("#register-form #age input").classList.add("border-red-500");
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
                }
            },
            false,
        );
    </script>

</body>
</html