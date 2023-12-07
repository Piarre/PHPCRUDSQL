<!DOCTYPE html>
<html lang="fr">

<head>
    <title>PHP Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
require_once 'auth.php';
isDisconnected();
?>

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
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password" name="password"
                           id="password" placeholder="Password">
                </div>

                <?php if (isset($_GET["error"])) { ?>
                    <span class="text-red-600 text-[16px] font-bold" id="message">Email or password incorrect</span>
                <?php } ?>
                <div class="mx-10">
                    <button class="bg-blue-500 transition hover:bg-blue-700 my-2 w-full text-white p-2 rounded-md"
                            type="submit">Login
                    </button>
                </div>
        </div>
        </form>

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
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="password" name="password"
                           id="password" placeholder="Password">
                </div>

                <div class="mb-4" id="actif">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="actif">Actif</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="actif"
                           id="actif"
                           placeholder="Actif">
                </div>

                <div class="mb-4" id="age">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="age">Age</label>
                    <input class="border-2 w-full border border-gray-300 p-2 rounded-md" type="text" name="age" id="age"
                           placeholder="Age">
                </div>
                <div class="mx-10">
                    <span class="text-red-600 text-[14px] font-bold opacity-0" id="message">Please fill all fields</span>
                    <button id="register-btn"
                            class="bg-blue-500 transition hover:bg-blue-700 my-2 w-full text-white p-2 rounded-md">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
            const actif = document.querySelector("#register-form #actif input").value;
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

            if (actif === "") {
                document.querySelector("#register-form #actif input").classList.remove("border-gray-300");
                document.querySelector("#register-form #actif input").classList.add("border-red-500");
            }

            if (age === "" || age === 0) {
                document.querySelector("#register-form #age input").classList.remove("border-gray-300");
                document.querySelector("#register-form #age input").classList.add("border-red-500");
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
</html