<?php
include ('User.php');
include ('config.php');

$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $nom = $_POST["signup-nom"];
    $prenom = $_POST["signup-prenom"];
    $email = $_POST["signup-email"];
    $tel = $_POST["signup-tel"];
    $password = $_POST["signup-password"];
    $role = 'user';
$UserRegistration = new User($pdo);
$UserRegistration->signUp($nom,$prenom,$email,$tel,$password,$role);
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
    <title>Sign up Page</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-8 rounded shadow-md w-96">
<form id="signup-form"  method="post" action="" enctype="multipart/form-data">
        <img src="img/black.png" alt="Logo" class="mx-auto mb-8 rounded-full w-32 h-20">
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
            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200" name="signup">
                Sign Up
            </button>
            <p class="mt-4 text-sm text-gray-600">Already have an account? <a href="Login.php" id="show-login" class="text-blue-700 font-bold">Login</a></p>
        </form>
    </div>
</body>
</html>