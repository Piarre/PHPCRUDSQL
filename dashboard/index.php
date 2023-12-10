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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <title>Users list</title>
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-6xl mx-auto">
    <div class="flex justify-center items-center gap-10 pb-4">
        <a class="flex items-center gap-[5px] bg-violet-500 transition hover:bg-violet-800 my-2 hover:-translate-y-1 font-bold hover:scale-110 text-xl text-white p-3 rounded-md" href="/api/auth/logout.php">
            <ion-icon name="log-out"></ion-icon>
            Logout
        </a>
        <h1 class="mb-4 text-4xl font-bold text-center text-gray-900 md:text-5xl lg:text-6xl">PHP SQL C.R.U.D.</h1>
        <a class="flex items-center gap-[5px] bg-pink-500 transition hover:bg-pink-800 my-2 hover:-translate-y-1 font-bold hover:scale-110 text-xl text-white p-3 rounded-md" href="/dashboard/add.php">
            <ion-icon name="person-add"></ion-icon>
            Add user
        </a>
    </div>

    <table id="users" class="order-column min-w-full bg-white border border-gray-300 rounded-md overflow-hidden">
        <thead class="bg-gray-200">
        <tr>
            <th class="py-2 px-4">ID</th>
            <th class="py-2 px-4">Name</th>
            <th class="py-2 px-4">Surname</th>
            <th class="py-2 px-4">Email</th>
            <th class="py-2 px-4">Age</th>
            <th class="py-2 px-4">enabled</th>
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
                    <?php if ($user['enabled'] == 1) {
                        echo "Enabled";
                    } else {
                        echo "Disabled";
                    } ?>
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
                                class="flex items-center gap-[5px] bg-blue-600 hover:bg-blue-700 transition duration-200 text-white text-lg font-bold p-3 rounded">
                            <ion-icon name="at-circle"></ion-icon>
                            Update
                        </button>
                    </form>
                    <form action="../api/delete.php">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <button type="submit"
                                class="flex items-center gap-[5px] bg-rose-600 hover:bg-red-700 transition duration-200 text-white text-lg font-bold p-3 rounded">
                            <ion-icon name="trash-bin"></ion-icon>
                            Delete
                        </button>
                    </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        var groupColumn = 5;
        const usersApi = new DataTable('#users', {
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.context[0].aoColumns[column.index()].sTitle;

                        if (title !== 'Actions') {
                            let input = document.createElement('input');
                            input.placeholder = title;
                            input.classList.add('p-2', 'w-[100px]', 'rounded-md', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-violet-600', 'focus:border-transparent', 'transition');
                            $(input).appendTo($(column.header()).empty())
                                .on('keyup change clear', function () {
                                    if (column.search() !== this.value) {
                                        column
                                            .search(this.value)
                                            .draw();
                                    }
                                });
                        }
                    });
            },
            columnDefs: [{visible: false, targets: groupColumn}],
            order: [[groupColumn, 'asc']],
            displayLength: 25,
            drawCallback: function () {
                let api = this.api();
                let rows = api.rows({page: 'current'}).nodes();
                let last = null;

                api.column(groupColumn, {page: 'current'}).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group bg-gray-200"><td colspan="10">' + group + '</td></tr>'
                        );
                        last = group;
                    }
                });
            }
        });

        $('#users tbody').on('click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                table.order([groupColumn, 'desc']).draw();
            } else {
                table.order([groupColumn, 'asc']).draw();
            }
        });

        const notyf = new Notyf();

        <?php if (isset($_GET['message'])): ?>
        notyf.success('<?php echo $_GET['message']; ?>');
        history.pushState('', document.title, window.location.pathname);
        <?php endif; ?>
    </script>
</div>
</body>

</html>