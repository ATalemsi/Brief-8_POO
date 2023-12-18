<?php
class Project{
    private $pdo;
    private $ProjectName;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getUserProjects($userID)
      {
          $stmt = $this->pdo->prepare("
              SELECT DISTINCT p.ProjectName, u.Nom AS OwnerNom, u.Prenom AS OwnerPrenom, t.TeamName
              FROM Projects p
              INNER JOIN ProjectTeams pt ON p.ProjectID = pt.ProjectID
              INNER JOIN TeamMembers tm ON pt.TeamID = tm.TeamID
              INNER JOIN Users u ON tm.UserID = u.ID_User
              INNER JOIN Teams t ON pt.TeamID = t.TeamID
              WHERE u.ID_User = ?
          ");
          $stmt->execute([$userID]);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    public function GetProject_Without_Scrum(){
        $stmt = $this->pdo->prepare("
        SELECT p.ProjectID AS ProjectID, p.ProjectName, uProductOwner.Nom AS ProductOwner, uScrumMaster.Nom AS ScrumMaster, t.TeamName
        FROM projects p
        LEFT JOIN users uProductOwner ON p.ProductOwnerID = uProductOwner.ID_User
        LEFT JOIN projectteams pt ON p.ProjectID = pt.ProjectID
        LEFT JOIN Teams t ON pt.TeamID = t.TeamID
        LEFT JOIN users uScrumMaster ON t.ScrumMasterID = uScrumMaster.ID_User
        WHERE uScrumMaster.ID_User IS NULL AND t.TeamID IS NULL
          ");
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function GetTeam_Without_Project(){
        $stmt = $this->pdo->prepare("
        SELECT p.ProjectID AS ProjectID, p.ProjectName, uProductOwner.Nom AS ProductOwner, uScrumMaster.Nom AS ScrumMaster, t.TeamName
        FROM projects p
        LEFT JOIN users uProductOwner ON p.ProductOwnerID = uProductOwner.ID_User
        LEFT JOIN projectteams pt ON p.ProjectID = pt.ProjectID
        LEFT JOIN Teams t ON pt.TeamID = t.TeamID
        LEFT JOIN users uScrumMaster ON t.ScrumMasterID = uScrumMaster.ID_User
        WHERE uScrumMaster.ID_User IS NULL AND t.TeamID IS NULL
          ");
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }        
        public function getProjectName()
    {
        return $this->ProjectName;
    }
   


}
?>