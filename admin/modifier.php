<?php
session_start(); 
include '../config.php';


function updateProductOwner($id, $nom, $prenom, $email, $tel, $password, $role) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE users SET Nom = ?, Prenom = ?, Email = ?, Tel = ?, PasswordU = ?, UserRole = ? WHERE ID_User = ?");
    $stmt->execute([$nom, $prenom, $email, $tel, $hashedPassword, $role, $id]);

    if ($stmt) {
        echo "Product Owner updated successfully!";
        header("Location: users.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE ID_User = ?");
    $stmt->execute([$id]);

    if ($stmt) {
        $member = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Error executing query: " ;
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["updateId"];
    $nom = $_POST["modifier-nom"];
    $prenom = $_POST["modifier-prenom"];
    $email = $_POST["modifier-email"];
    $tel = $_POST["modifier-tel"];
    $password = $_POST["modifier-password"];
    $role = $_POST["modifier-role"];
    updateProductOwner($id, $nom, $prenom, $email, $tel, $password, $role);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            @apply bg-cover bg-center bg-fixed;
            background-image: linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73)),
                url('img/data-warehousen.jpg');
        }
    </style>
    <title>Modifier Role</title>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <!-- Product Owner Update Form -->
        <form id="modifier-form" method="post" action="modifier.php">
            <img src="../img/black.png" alt="Logo" class="mx-auto mb-8 rounded-full w-32 h-20">
            <input type="hidden" name="updateId" value="<?= $id ?>" class="hidden">
            <div class="mb-4">
                <label for="modifier-nom" class="block text-gray-600 text-sm font-semibold mb-2">Nom</label>
                <input type="text" id="modifier-nom" name="modifier-nom" value="<?= $member['Nom'] ?? 'not found' ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="modifier-prenom" class="block text-gray-600 text-sm font-semibold mb-2">Prenom</label>
                <input type="text" id="modifier-prenom" name="modifier-prenom" value="<?= $member['Prenom'] ?? 'not found' ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="modifier-email" class="block text-gray-600 text-sm font-semibold mb-2">Email</label>
                <input type="email" id="modifier-email" name="modifier-email" value="<?= $member['Email'] ?? 'not found' ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="modifier-tel" class="block text-gray-600 text-sm font-semibold mb-2">Telephone</label>
                <input type="tel" id="modifier-tel" name="modifier-tel" value="<?= $member['Tel'] ?? 'not found' ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="modifier-role" class="block text-gray-600 text-sm font-semibold mb-2">Role</label>
                <select id="modifier-role" name="modifier-role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                    <option value="product_owner" <?= isset($member['UserRole']) && $member['UserRole'] === 'product_owner' ? 'selected' : 'not found' ?>>Product Owner</option>
                    <option value="scrum_master" <?= isset($member['UserRole']) && $member['UserRole'] === 'scrum_master' ? 'selected' : 'not found' ?>>Scrum Master</option>
                    <option value="user" <?= isset($member['UserRole']) && $member['UserRole'] === 'user' ? 'selected' : 'not found' ?>>User</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200" name="update">
                Update Role
            </button>
        </form>
    </div>
</body>

</html>
