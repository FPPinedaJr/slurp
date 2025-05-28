<?php
require_once __DIR__ . "/includes/connect_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $stmt = $pdo->prepare("INSERT INTO user (f_name, l_name, username, email, usertype, address, password, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->execute([
            $_POST['f_name'], $_POST['l_name'], $_POST['username'], $_POST['email'],
            $_POST['usertype'], $_POST['address'], $hashedPassword
        ]);
        echo "User added successfully!";
        exit;
    }

    if ($action === 'edit') {
        if (!empty($_POST['password'])) {
            $stmt = $pdo->prepare("UPDATE user SET f_name=?, l_name=?, username=?, email=?, usertype=?, address=?, password=? WHERE iduser=?");
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->execute([
                $_POST['f_name'], $_POST['l_name'], $_POST['username'], $_POST['email'],
                $_POST['usertype'], $_POST['address'], $hashedPassword, $_POST['iduser']
            ]);
        } else {
            $stmt = $pdo->prepare("UPDATE user SET f_name=?, l_name=?, username=?, email=?, usertype=?, address=? WHERE iduser=?");
            $stmt->execute([
                $_POST['f_name'], $_POST['l_name'], $_POST['username'], $_POST['email'],
                $_POST['usertype'], $_POST['address'], $_POST['iduser']
            ]);
        }
        echo "User updated successfully!";
        exit;
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM user WHERE iduser = ?");
        $stmt->execute([$_POST['id']]);
        echo "User deleted successfully!";
        exit;
    }

    if ($action === 'get_user') {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE iduser = ?");
        $stmt->execute([$_POST['id']]);
        echo json_encode($stmt->fetch());
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-white bg-black">

<div class="container max-w-6xl p-6 mx-auto">
    <h1 class="mb-6 text-4xl font-extrabold text-center text-red-600 drop-shadow-lg">User Management</h1>

    <div class="flex justify-center mb-6">
    <button id="addUserBtn" 
        class="px-6 py-3 font-bold text-red-900 transition duration-200 bg-yellow-400 rounded-lg shadow-md hover:bg-yellow-500">
            + Add User
        </button>
    </div>

    <div class="overflow-x-auto border border-red-900 rounded-lg shadow-lg">
        <table class="min-w-full text-white bg-black rounded-lg">
            <thead class="text-sm font-semibold tracking-wide text-yellow-300 bg-red-700">
            <tr>
                <th class="px-6 py-3 text-center">id</th>
                <th class="px-6 py-3 text-center">first name</th>
                <th class="px-6 py-3 text-center">last name</th>
                <th class="px-6 py-3 text-center">username</th>
                <th class="px-6 py-3 text-center">email</th>
                <th class="px-6 py-3 text-center">user type</th>
                <th class="px-6 py-3 text-center">actions</th>
            </tr>
            </thead>

                <?php
                $stmt = $pdo->query("SELECT * FROM user ORDER BY created_at ASC");
                while ($row = $stmt->fetch()) {
                    echo "<tr class='border-b border-red-900 hover:bg-red-800'>
                        <td class='px-6 py-3'>{$row['iduser']}</td>
                        <td class='px-6 py-3'>{$row['f_name']}</td>
                        <td class='px-6 py-3'>{$row['l_name']}</td>
                        <td class='px-6 py-3'>{$row['username']}</td>
                        <td class='px-6 py-3'>{$row['email']}</td>
                        <td class='px-6 py-3'>{$row['usertype']}</td>
                        <td class='px-6 py-3 text-center'>
                        <div class='flex justify-center space-x-2'>
                            <button class='px-3 py-1 font-semibold text-red-900 transition duration-200 bg-yellow-400 rounded-lg shadow editBtn hover:bg-yellow-500' data-id='{$row['iduser']}'>Edit</button>
                            <button class='px-3 py-1 font-semibold text-yellow-200 transition duration-200 bg-red-600 rounded-lg shadow deleteBtn hover:bg-red-700' data-id='{$row['iduser']}'>Delete</button>
                        </div>
                    </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-70">
  <div class="w-full max-w-lg p-8 text-white bg-black border-4 border-red-600 shadow-2xl rounded-2xl">
    <h2 class="mb-6 text-3xl font-bold text-red-500" id="modalTitle">Add User</h2>
    <form id="userForm" class="space-y-4">
      <!-- Form fields -->
      <input type="hidden" name="iduser" id="iduser">
      <input type="text" name="f_name" id="f_name" placeholder="First Name" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="text" name="l_name" id="l_name" placeholder="Last Name" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="text" name="username" id="username" placeholder="Username" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="email" name="email" id="email" placeholder="Email" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="number" name="usertype" id="usertype" placeholder="User Type (0/1)" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" min="0" max="1" required>
      <textarea name="address" id="address" placeholder="Address" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required></textarea>
      <input type="password" name="password" id="password" placeholder="Password (leave blank to keep current)" class="w-full p-3 text-white bg-black border-2 border-red-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
      <div class="flex justify-end pt-4 space-x-3">
        <button type="button" id="closeModal" class="px-6 py-2 font-bold text-black transition duration-200 bg-gray-400 rounded-lg hover:bg-gray-500">Cancel</button>
        <button type="submit" class="px-6 py-2 font-bold text-red-900 transition duration-200 bg-yellow-400 rounded-lg shadow-lg hover:bg-yellow-500">Save</button>
      </div>
    </form>
  </div>
</div>


<script>
$(document).ready(function() {
    $('#addUserBtn').click(function() {
        $('#modalTitle').text('Add User');
        $('#userForm')[0].reset();
        $('#iduser').val('');
        $('#userModal').removeClass('hidden').addClass('flex');
    });

    $('#closeModal').click(function() {
        $('#userModal').removeClass('flex').addClass('hidden');
    });

    $('.editBtn').click(function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'user_management.php',
            method: 'POST',
            data: { action: 'get_user', id: id },
            dataType: 'json',
            success: function(user) {
                $('#modalTitle').text('Edit User');
                $('#iduser').val(user.iduser);
                $('#f_name').val(user.f_name);
                $('#l_name').val(user.l_name);
                $('#username').val(user.username);
                $('#email').val(user.email);
                $('#usertype').val(user.usertype);
                $('#address').val(user.address);
                $('#password').val('');
                $('#userModal').removeClass('hidden').addClass('flex');
            },
            error: function() {
                alert('Failed to fetch user data.');
            }
        });
    });

    $('.deleteBtn').click(function() {
        if (!confirm('Are you sure you want to delete this user?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: 'user_management.php',
            method: 'POST',
            data: { action: 'delete', id: id },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function() {
                alert('Failed to delete user.');
            }
        });
    });

    $('#userForm').submit(function(e) {
        e.preventDefault();
        let action = $('#iduser').val() ? 'edit' : 'add';
        let formData = $(this).serialize() + '&action=' + action;

        $.ajax({
            url: 'user_management.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert(response);
                $('#userModal').removeClass('flex').addClass('hidden');
                location.reload();
            },
            error: function() {
                alert('Failed to save user.');
            }
        });
    });
});
</script>

</body>
</html>
