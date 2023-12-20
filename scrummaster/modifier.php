<?php
include '../ScrumMaster.php';
include '../Team.php';
$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();

$updateteam= new ScrumMaster($pdo);
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $teamhandl=new Team($pdo);
    $team=$teamhandl->GetTeamId($id);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["updateId"];
    $teamName = $_POST["modifier-team-name"];
    $scrumMasterID = $_POST["modifier-scrum-master"];
    $updateteam->Modifier_team($id,$teamName,$scrumMasterID);
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
    <title>Modifier Team</title>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <!-- Team Update Form -->
        <form id="modifier-form" method="post" action="modifier.php">
            <input type="hidden" name="updateId" value="<?= $id ?>" class="hidden">
            <div class="mb-4">
                <label for="modifier-team-name" class="block text-gray-600 text-sm font-semibold mb-2">Team Name</label>
                <input type="text" id="modifier-team-name" name="modifier-team-name" value="<?= $team['TeamName'] ?? 'not found' ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="modifier-scrum-master" class="block text-gray-600 text-sm font-semibold mb-2">Scrum Master</label>
                <select id="modifier-scrum-master" name="modifier-scrum-master" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500">
                    <?php
                    // Assuming $pdo is your PDO database connection
                    $scrumMasters= new ScrumMaster($pdo);
                    $scrumMasters->GetAllScrum();

                    foreach ($scrumMasters as $scrumMaster) {
                        echo "<option value=\"{$scrumMaster['ID_User']}\" " . ($team['ScrumMasterID'] == $scrumMaster['ID_User'] ? 'selected' : '') . ">{$scrumMaster['Nom']} {$scrumMaster['Prenom']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200" name="update">
                Update Team
            </button>
        </form>
    </div>
</body>

</html>
