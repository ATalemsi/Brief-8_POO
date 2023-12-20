<?php

include '../config.php';
include '../ProductOwner.php';
include '../ProjectC.php';

session_start();
$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectID = $_POST["project_id"];
    $projectID = $_POST["scrum_master_id"];
    $ASScrum = new Productowner($pdo);
    $ASScrum->AssignerScrum($projectID,$scrumMasterID);  
    exit();
}

$projects=new Project($pdo);
$scrumMasters=new Project($pdo);

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
    <title>Assigner Scrum Master</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
    <form method="post" action="">
             <div class="mb-4">
                <label for="project_id" class="block text-gray-600 text-sm font-semibold mb-2">Select Project</label>
                <select name="project_id" id="project_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                            <?php 
                             $projects->GetProject_Without_Scrum();
                            foreach ($projects as $project) : ?>
                        <option value="<?php  echo $project['ProjectID']; ?>"><?php echo $project['ProjectName']; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="scrum_master_id" class="block text-gray-600 text-sm font-semibold mb-2">Select Team And ScrumMaster</label>
                <select name="scrum_master_id" id="scrum_master_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                            <?php 
                            $scrumMasters->Get_Scrum_Without_project();
                            foreach ($scrumMasters as $scrumMaster) : ?>
                        <option value="<?php echo $scrumMaster['TeamID']; ?>"><?php echo $scrumMaster['TeamName']; ?> /SM : <?php echo $scrumMaster['ScrumMasterName']; ?> <?php echo $scrumMaster['ScrumMasterPrenom']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200" name="submit">
                Assigner ScrumMaster
            </button>
        </form>

    </div>
</body>
</html>
