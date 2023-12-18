<?php // Start the session
include '../config.php';
session_start();

// Function to register a new Product Owner
function registerProductOwner($nom, $prenom, $email, $tel, $password, $role) {
    global $pdo;
        // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert Product Owner data into the database
            $stmt = $pdo->prepare("INSERT INTO Users (Nom, Prenom, Email, Tel, PasswordU, UserRole) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $tel, $hashedPassword, $role]);
            if ($stmt) {
            echo "Product Owner added successfully!";
            header("Location: users.php");
        } else {
            echo "Error Registration Product Owner.";
        }
  
}

// Handle Product Owner registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $nom = $_POST["signup-nom"];
    $prenom = $_POST["signup-prenom"];
    $email = $_POST["signup-email"];
    $tel = $_POST["signup-tel"];
    $password = $_POST["signup-password"];
    $role = $_POST["signup-role"];
    // Register the Product Owner
    registerProductOwner($nom, $prenom, $email, $tel, $password, $role);
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
    <title>Add User</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <!-- Product Owner Registration Form -->
        <form id="signup-form" method="post" action="">
            <img src="../img/black.png" alt="Logo" class="mx-auto mb-8 rounded-full w-32 h-20">
            <div class="mb-4">
                <label for="signup-nom" class="block text-gray-600 text-sm font-semibold mb-2">Nom</label>
                <input type="nom" id="signup-nom" name="signup-nom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Nom" required>
            </div>
            <div class="mb-4">
                <label for="signup-prenom" class="block text-gray-600 text-sm font-semibold mb-2">Prenom</label>
                <input type="prenom" id="signup-prenom" name="signup-prenom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Prenom" required>
            </div>
            <div class="mb-4">
                <label for="signup-email" class="block text-gray-600 text-sm font-semibold mb-2">Email</label>
                <input type="email" id="signup-email" name="signup-email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="john.doe@gmail.com" required>
            </div>
            <div class="mb-4">
                <label for="signup-tel" class="block text-gray-600 text-sm font-semibold mb-2">Telephone</label>
                <input type="tel" id="signup-tel" name="signup-tel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Telephone" required>
            </div>
            <div class="mb-4">
                <label for="signup-password" class="block text-gray-600 text-sm font-semibold mb-2">Password</label>
                <input type="password" id="signup-password" name="signup-password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="********" required>
            </div>
            <div class="mb-4">
                <label for="signup-role" class="block text-gray-600 text-sm font-semibold mb-2">Role</label>
                <select id="signup-role" name="signup-role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                    <option value="product_owner">Product Owner</option>
                    <option value="scrum_master">Scrum Master</option>
                    <option value="user">User</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200" name="signup">
                Add Product Owner
            </button>
        </form>
    </div>
</body>
</html>
