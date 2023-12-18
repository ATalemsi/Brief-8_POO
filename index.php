<?php
include ('User.php');
include ('config.php');
session_start(); 

$admin_email = "admin@example.com";
$admin_password = "adminpassword";

$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();

$users = new User($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailA = $_POST["email"];
    $passwordA = $_POST["password"];
    $authenticatedUser = $users->login($emailA, $passwordA);

    if ($authenticatedUser) {
        if ($emailA == $admin_email && $passwordA == $admin_password) {
            $_SESSION['user_email'] = $admin_email;
            $_SESSION['user_role'] = 'admin';
            $_SESSION['nom_admin'] = 'Abdellah Talemsi';
            header("Location: admin/dashboardA.php");
            exit();
        } elseif ($authenticatedUser['UserRole'] == 'user') {
            header("Location: dashboard.php");
        } elseif ($authenticatedUser['UserRole'] == 'product_owner') {
            header("Location: productowner/dashboardP.php");
        } elseif ($authenticatedUser['UserRole'] == 'scrum_master') {
            header("Location: scrummaster/dashboardS.php");
        }
        $_SESSION["user"] = $authenticatedUser;
        $_SESSION["role"] = $authenticatedUser['UserRole'];
        $_SESSION["nom"] = $authenticatedUser['Nom'] . " " . $authenticatedUser['Prenom'];
        exit();
    } else {
        echo "<p class='mt-4 text-sm text-gray-600'>Login failed. Invalid email or password.</p>";
    }
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
    <title>Login Page</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <!-- Login Form -->
        <form id="login-form" action="" method="post">
            <img src="img/black.png" alt="Logo" class="mx-auto mb-8 rounded-full w-32 h-20">
            <div class="mb-4">
                <label for="email" class="block text-gray-600 text-sm font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="john.doe@example.com" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 text-sm font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="********" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200">
                Login
            </button>
            <p class="mt-4 text-sm text-gray-600">Don't have an account? <a href="signup.php" id="show-signup" class="text-blue-700 font-bold">Sign up</a></p>
        </form>
    </div>
</body>
</html>
