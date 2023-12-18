<?php 
class Team{

private $pdo;
private $TeamID;
private $TeamName;

public function __construct($pdo) {
    $this->pdo = $pdo;
}
public function GetTeamName(){
    $teamsQuery = "SELECT TeamID, TeamName FROM Teams";
    $teamsStmt = $this->pdo->prepare($teamsQuery);
    $teamsStmt->execute();
    return $teamsStmt->fetchAll(PDO::FETCH_ASSOC);
}
public function GetMember(){
    $membersQuery = "SELECT ID_User, Nom, Prenom FROM Users WHERE UserRole = 'user' AND ID_User NOT IN (SELECT UserID FROM TeamMembers)";
    $membersStmt = $this->pdo->prepare($membersQuery);
    $membersStmt->execute();
    return  $membersStmt->fetchAll(PDO::FETCH_ASSOC);;
}
public function getUserTeams($userID)
{
    $stmt = $this->pdo->prepare("
    SELECT t.TeamID, t.TeamName, u.Nom AS NomU ,u.Prenom AS PrenomU FROM Teams t  INNER JOIN TeamMembers tm ON t.TeamID = tm.TeamID 
    INNER JOIN
    Users u ON tm.UserID = u.ID_User WHERE u.ID_User = ?
    ");
    $stmt->execute([$userID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function GetTeamId($id){
    $stmt = $this->pdo->prepare("SELECT * FROM teams WHERE TeamID = ?");
    $stmt->execute([$id]);

        if (!$stmt) {
            echo "Error executing query: ";
            exit();   
        }else{
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

  }
  public function GetTeamScrum(){
    
    $teamID= null;
    $teamName= null;
    $scrumMasterID = null;
    $scrumMasterName= null;
    $scrumMasterPrenom= null;
    $teamIDMember= null;
    $userNom= null;
    $userPrenom= null;
    $userRole= null;
    $userID= null;
    

    // SQL query to get teams with Scrum Masters
    $teamsSql = "SELECT
        t.TeamID AS TeamID,
        t.TeamName AS TeamName,
        u.ID_User AS ScrumMasterID,
        u.Nom AS ScrumMasterName,
        u.Prenom AS ScrumMasterPrenom
        FROM
        Teams t
        LEFT JOIN Users u ON t.ScrumMasterID = u.ID_User
        LEFT JOIN TeamMembers tm ON t.TeamID = tm.TeamID";

    $stmtTeams = $this->pdo->prepare($teamsSql);

    if (!$stmtTeams || !$stmtTeams->execute()) {
        die("Error fetching teams: " . $stmtTeams->errorInfo()[2]);
    }

    $stmtTeams->bindColumn('TeamID', $teamID);
    $stmtTeams->bindColumn('TeamName', $teamName);
    $stmtTeams->bindColumn('ScrumMasterID', $scrumMasterID);
    $stmtTeams->bindColumn('ScrumMasterName', $scrumMasterName);
    $stmtTeams->bindColumn('ScrumMasterPrenom', $scrumMasterPrenom);
    $teamData = [];

    while ($stmtTeams->fetch(PDO::FETCH_BOUND)) {
        $teamData[$teamID]['TeamName'] = $teamName;
        $teamData[$teamID]['TeamID'] = $teamID;
        $teamData[$teamID]['ScrumMasterID'] = $scrumMasterID;
        $teamData[$teamID]['ScrumMasterName'] = $scrumMasterName;
        $teamData[$teamID]['ScrumMasterPrenom'] = $scrumMasterPrenom;
        $teamData[$teamID]['Members'] = []; // Initialize Members array
    }

    // SQL query to fetch team members
    $membersSql = "SELECT tm.TeamID, u.Nom AS UserNom, u.Prenom AS UserPrenom, u.UserRole, u.ID_User
        FROM TeamMembers tm
        LEFT JOIN Users u ON tm.UserID = u.ID_User";

    $stmtMembers = $this->pdo->prepare($membersSql);

    if (!$stmtMembers || !$stmtMembers->execute()) {
        die("Error fetching team members: " . $stmtMembers->errorInfo()[2]);
    }

    $stmtMembers->bindColumn('TeamID', $teamIDMember);
    $stmtMembers->bindColumn('UserNom', $userNom);
    $stmtMembers->bindColumn('UserPrenom', $userPrenom);
    $stmtMembers->bindColumn('UserRole', $userRole);
    $stmtMembers->bindColumn('ID_User', $userID);

    while ($stmtMembers->fetch(PDO::FETCH_BOUND)) {
        $teamData[$teamIDMember]['Members'][] = [
            'UserID' => $userID,
            'UserNom' => $userNom,
            'UserPrenom' => $userPrenom,
            'UserRole' => $userRole,
        ];
    }

   
    $stmtTeams->closeCursor();
    $stmtMembers->closeCursor();

    return $teamData;
}

  public function getTeamsID()
{
    return $this->TeamID;
}

public function getTeamsName()
{
    return $this->TeamName;
}
}