<?php
include '../config.php'; 
include '../ProductOwner.php'; 
session_start();

$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter-p"])) {
    $projectName = $_POST["project-name"];
    $productOwnerID = $_POST["product-owner"];

    $AddProject = new Productowner($pdo);
    $AddProject->addProject($projectName,$productOwnerID);
}

$authenticatedUserID = $_SESSION['user']['ID_User'];
$productOwners = new Productowner($pdo);
$productOwners->GetProduct_project($authenticatedUserID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73)),
            url('img/data-warehousen.jpg') center fixed;
            background-size: cover;
        }
    </style>
    <title>Add Project</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <form id="ajouter-project-form" method="post" action="">
            <div class="mb-4">
                <label for="project-name" class="block text-gray-600 text-sm font-semibold mb-2">Project Name</label>
                <input type="text" id="project-name" name="project-name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Project Name" required>
            </div>
            <div class="mb-4">
                <label for="product-owner" class="block text-gray-600 text-sm font-semibold mb-2">Product Owner</label>
                <select id="product-owner" name="product-owner" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                    <?php
                        
                            echo "<option value=\"{$productOwners[0]['ID_User']}\">{$productOwners[0]['Nom']} {$productOwners[0]['Prenom']}</option>";
                        
                    ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200" name="ajouter-p">
                Add Project
            </button>
        </form>
    </div>
</body>
</html>
