<?php
session_start();
include '../config.php';
include '../ProductOwner.php';
include '../ProjectC.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $projecthandl=new Project($pdo);
    $project=$projecthandl->GetProjectID($id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["updateId"];
    $projectName = $_POST["modifier-project-name"];
    $updateProject= new Productowner($pdo);
    $updateProject->updateProject($id, $projectName);
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
    <title>Modifier Project</title>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <!-- Project Update Form -->
        <form id="modifier-form" method="post" action="modifier.php">
            <input type="hidden" name="updateId" value="<?= $id ?>" class="hidden">
            <div class="mb-4">
                <label for="modifier-project-name" class="block text-gray-600 text-sm font-semibold mb-2">Project Name</label>
                <input type="text" id="modifier-project-name" name="modifier-project-name" value="<?= $project['ProjectName'] ?? 'not found' ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200" name="update">
                Update Project
            </button>
        </form>

    </div>
</body>

</html>
