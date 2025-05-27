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
<body class="bg-black text-white font-sans">

<div class="container mx-auto p-6 max-w-6xl">
    <h1 class="text-4xl font-extrabold mb-6 text-center text-red-600 drop-shadow-lg">User Management</h1>

    <div class="flex justify-center mb-6">
    <button id="addUserBtn" 
        class="bg-yellow-400 hover:bg-yellow-500 text-red-900 font-bold px-6 py-3 rounded-lg shadow-md transition duration-200">
            + Add User
        </button>
    </div>

    <div class="overflow-x-auto rounded-lg shadow-lg border border-red-900">
        <table class="min-w-full bg-black rounded-lg text-white">
            <thead class="bg-red-700 text-yellow-300 text-sm font-semibold tracking-wide">
            <tr>
                <th class="py-3 px-6 text-center">id</th>
                <th class="py-3 px-6 text-center">first name</th>
                <th class="py-3 px-6 text-center">last name</th>
                <th class="py-3 px-6 text-center">username</th>
                <th class="py-3 px-6 text-center">email</th>
                <th class="py-3 px-6 text-center">user type</th>
                <th class="py-3 px-6 text-center">actions</th>
            </tr>
            </thead>

                <?php
                $stmt = $pdo->query("SELECT * FROM user ORDER BY created_at ASC");
                while ($row = $stmt->fetch()) {
                    echo "<tr class='border-b border-red-900 hover:bg-red-800'>
                        <td class='py-3 px-6'>{$row['iduser']}</td>
                        <td class='py-3 px-6'>{$row['f_name']}</td>
                        <td class='py-3 px-6'>{$row['l_name']}</td>
                        <td class='py-3 px-6'>{$row['username']}</td>
                        <td class='py-3 px-6'>{$row['email']}</td>
                        <td class='py-3 px-6'>{$row['usertype']}</td>
                        <td class='py-3 px-6 text-center'>
                        <div class='flex justify-center space-x-2'>
                            <button class='editBtn bg-yellow-400 hover:bg-yellow-500 text-red-900 px-3 py-1 rounded-lg shadow font-semibold transition duration-200' data-id='{$row['iduser']}'>Edit</button>
                            <button class='deleteBtn bg-red-600 hover:bg-red-700 text-yellow-200 px-3 py-1 rounded-lg shadow font-semibold transition duration-200' data-id='{$row['iduser']}'>Delete</button>
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
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex items-center justify-center">
  <div class="bg-black text-white p-8 rounded-2xl shadow-2xl w-full max-w-lg border-4 border-red-600">
    <h2 class="text-3xl font-bold mb-6 text-red-500" id="modalTitle">Add User</h2>
    <form id="userForm" class="space-y-4">
      <!-- Form fields -->
      <input type="hidden" name="iduser" id="iduser">
      <input type="text" name="f_name" id="f_name" placeholder="First Name" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="text" name="l_name" id="l_name" placeholder="Last Name" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="text" name="username" id="username" placeholder="Username" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="email" name="email" id="email" placeholder="Email" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
      <input type="number" name="usertype" id="usertype" placeholder="User Type (0/1)" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400" min="0" max="1" required>
      <textarea name="address" id="address" placeholder="Address" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400" required></textarea>
      <input type="password" name="password" id="password" placeholder="Password (leave blank to keep current)" class="bg-black text-white border-2 border-red-500 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-yellow-400">
      <div class="flex justify-end space-x-3 pt-4">
        <button type="button" id="closeModal" class="bg-gray-400 hover:bg-gray-500 text-black font-bold px-6 py-2 rounded-lg transition duration-200">Cancel</button>
        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-red-900 font-bold px-6 py-2 rounded-lg shadow-lg transition duration-200">Save</button>
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
