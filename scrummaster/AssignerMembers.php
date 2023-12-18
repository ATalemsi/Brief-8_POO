<?php
include '../ScrumMaster.php';
include '../Team.php';
include '../config.php';

session_start();
$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["assign-member"])) {
    $teamID = $_POST["team-id"];
    $userID = $_POST["user-id"];
    $ASMember = new ScrumMaster($pdo);
    $ASMember->AssignerM($teamID,$userID);
}
$team=new Team($pdo);
$membersQuery =new Team($pdo);
$teams->GetTeamName();
$members->GetMember();
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
    <title>Assign Member to Team</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <form id="assign-member-form" method="post" action="">
            <div class="mb-4">
                <label for="team-id" class="block text-gray-600 text-sm font-semibold mb-2">Select Team</label>
                <select id="team-id" name="team-id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" required>
                    <?php
                        foreach ($teams as $team) {
                            echo "<option value=\"{$team['TeamID']}\">{$team['TeamName']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="user-id" class="block text-gray-600 text-sm font-semibold mb-2">Select Member</label>
                <select id="user-id" name="user-id" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500" required>
                    <?php
                        foreach ($members as $member) {
                            echo "<option value=\"{$member['ID_User']}\">{$member['Nom']} {$member['Prenom']}</option>";
                        }
                    ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200" name="assign-member">
                Assign Member to Team
            </button>
        </form>
    </div>
</body>
</html>
