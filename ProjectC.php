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
              FROM projects p
              INNER JOIN projectteams pt ON p.ProjectID = pt.ProjectID
              INNER JOIN teammembers tm ON pt.TeamID = tm.TeamID
              INNER JOIN users u ON tm.UserID = u.ID_User
              INNER JOIN teams t ON pt.TeamID = t.TeamID
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
        LEFT JOIN teams t ON pt.TeamID = t.TeamID
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
        LEFT JOIN teams t ON pt.TeamID = t.TeamID
        LEFT JOIN users uScrumMaster ON t.ScrumMasterID = uScrumMaster.ID_User
        WHERE uScrumMaster.ID_User IS NULL AND t.TeamID IS NULL
          ");
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }  
    public function Get_Scrum_Without_project(){
        $scrumMasters = $this->pdo->query("SELECT t.TeamID AS TeamID, t.TeamName, u.Nom AS ScrumMasterName, u.Prenom AS ScrumMasterPrenom
                    FROM teams t
                    INNER JOIN users u ON u.ID_User = t.ScrumMasterID
                    LEFT JOIN projectteams pt ON t.TeamID = pt.TeamID
                    WHERE pt.ProjectID IS NULL");
                     $scrumMasters->execute();
                     return $scrumMasters->fetchAll(PDO::FETCH_ASSOC);
    }  
    public function GetProjectID($id){
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE ProjectID = ?");
        $stmt->execute([$id]);

    if ($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Error executing query: ";
        exit();
    }

    }  
    public function GetProject_product(){
    
        $projectID= null;
        $projectName= null;
        $productOwner = null;
        $scrumMaster= null;   
        $teamName= null;    
        // SQL query to get teams with Scrum Masters
        $sql = "SELECT p.ProjectID, p.ProjectName, uProductOwner.Nom AS ProductOwner, uScrumMaster.Nom AS ScrumMaster, t.TeamName
        FROM projects p
        JOIN projectteams pt ON p.ProjectID = pt.ProjectID
        JOIN Teams t ON pt.TeamID = t.TeamID
        LEFT JOIN users uProductOwner ON p.ProductOwnerID = uProductOwner.ID_User
        LEFT JOIN users uScrumMaster ON t.ScrumMasterID = uScrumMaster.ID_User";
    
        $stmtPeoject = $this->pdo->prepare($sql);
    
        if (!$stmtPeoject) {
            die("Error preparing statement: " . $this->pdo->errorInfo());
        }
        
        // Execute the statement
        if (!$stmtPeoject->execute()) {
            die("Error executing statement: " . $stmtPeoject->errorInfo());
        }
        

                // Bind the result variables
                $stmtPeoject->bindColumn('ProjectID', $projectID);
                $stmtPeoject->bindColumn('ProjectName', $projectName);
                $stmtPeoject->bindColumn('ProductOwner', $productOwner);
                $stmtPeoject->bindColumn('ScrumMaster', $scrumMaster);
                $stmtPeoject->bindColumn('TeamName', $teamName);

                $projects = [];
    
    
       
    
        while ($stmtPeoject->fetch(PDO::FETCH_BOUND)) {
            $projects  []= [
                'ProjectID' => $projectID,
                'ProjectName' => $projectName,
                'ProductOwner' => $productOwner,
                'ScrumMaster' => $scrumMaster,
                'TeamName' => $teamName,
            ];
        }
        
    
        return $projects ;
            
    } 
    public function GetAllproject(){
        $projectID= null;
        $projectName= null;
        $productOwner = null;
        
        $query = "SELECT projects.ProjectID ,projects.ProjectName ,users.Nom AS ProductOwner FROM projects INNER JOIN users ON users.ID_User=projects.ProductOwnerID ";
        $stmt2 = $this->pdo->prepare($query);


        if (!$stmt2) {
            die("Error preparing statement: " . $this->pdo->errorInfo());
          }
          
          // Execute the statement
          if (!$stmt2->execute()) {
            die("Error executing statement: " . $stmt2->errorInfo());
          }

          // Bind the result variables
          $stmt2->bindColumn('ProjectID', $projectID);
          $stmt2->bindColumn('ProjectName', $projectName);
          $stmt2->bindColumn('ProductOwner', $productOwner);
          $projectall = [];
          while ($stmt2->fetch(PDO::FETCH_BOUND)) {
            $projectall[] = [
                'ProjectID' => $projectID,
                'ProjectName' => $projectName,
                'ProductOwner' => $productOwner,
            ];
        
        }
          return $projectall;

        
    }
        public function getProjectName()
    {
        return $this->ProjectName;
    }
   


}
?>