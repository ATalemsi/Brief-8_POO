<?php
include 'config.php';
session_start();
class User
{
    protected $pdo;
    private $userID;
    private $nom;
    private $prenom;
    private $email;
    private $tel;
    private $role;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['PasswordU'])) {

            $this->userID = $user['ID_User'];
            $this->nom = $user['Nom'];
            $this->prenom = $user['Prenom'];
            $this->email = $user['Email'];
            $this->tel = $user['Tel'];
            $this->role = $user['UserRole'];

            return true;
        } else {
            return false;
        }
    }

    public function signUp($nom, $prenom, $email, $tel, $password, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO Users (Nom, Prenom, Email, Tel, PasswordU, UserRole) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $tel, $hashedPassword, $role]);

        if ($stmt) {
            echo "Registration successful!";
            header("Location: index.php");
            exit();
        } else {
            echo "Error registering user.";
        }
    }

    public function logout()
    {
        
        $this->userID = null;
        $this->nom = null;
        $this->prenom = null;
        $this->email = null;
        $this->tel = null;
        $this->role = null;

        
        $_SESSION = array();

        
        session_destroy();

        header("Location: index.php");
        exit();
    }

    
    public function getUserID()
    {
        return $this->userID;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTel()
    {
        return $this->tel;
    }

    public function getRole()
    {
        return $this->role;
    }
}
//----------------CLASS SCRUM MASTER------------------------------
class ScrumMaster extends User{

    public function addteam($teamName,$scrumMasterID){

        try {
            $stmt = $this->pdo->prepare("INSERT INTO Teams (TeamName, ScrumMasterID) VALUES (?, ?)");
            $stmt->execute([$teamName, $scrumMasterID]);
    
            echo "Team added successfully!";
            header("Location: team.php"); 
            exit();
        } catch (PDOException $e) {
            echo "Error adding team: " . $e->getMessage();
        }
     }
     public function GetScrum($authenticatedUserID){
        $query = "SELECT ID_User, Nom, Prenom FROM Users WHERE UserRole = 'scrum_master' AND ID_User = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$authenticatedUserID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     public function AssignerM($teamID,$userID){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO TeamMembers (TeamID, UserID) VALUES (?, ?)");
            $stmt->execute([$teamID, $userID]);
            echo "Member assigned to team successfully!";
            header("Location: team.php"); 
            exit();

        }catch(PDOException $e) {
            echo "Error assigning member to team: " . $e->getMessage();
        }
     }  
     public function Supprimer_team($id){
           try{
             $stmt = $this->pdo->prepare("DELETE FROM teams WHERE TeamID = ?");
            $stmt->execute([$id]);
            header("Location: teams.php");
            exit();

           }catch (PDOException $e) {
            echo "Error removing member from team: " . $e->getMessage();
        }
     }
     public function Modifier_team($id, $teamName, $scrumMasterID){
        $stmt = $this->pdo->prepare("UPDATE teams SET TeamName = ?, ScrumMasterID = ? WHERE TeamID = ?");
        $stmt->execute([$teamName, $scrumMasterID, $id]);
        if ($stmt) {
            echo "Team updated successfully!";
            header("Location: team.php");
            exit();
        } else {
            echo "Error updating team.";
        }

        
     }
     public function DeleteMmeber($teamID, $userID){
        
        try {
        $stmt = $this->pdo->prepare("DELETE FROM TeamMembers WHERE TeamID = ? AND UserID = ?");
        $stmt->execute([$teamID, $userID]);

        echo "Member removed from team successfully!";
        header("Location: team.php");
        exit();
    } catch (PDOException $e) {
        echo "Error removing member from team: " . $e->getMessage();
    }

     }
     public function GetAllScrum(){
        $query = "SELECT ID_User, Nom, Prenom FROM Users WHERE UserRole = 'scrum_master'";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     

 }
 //---------------------------------------CLASS DASHBOARD--------------------------------

//-------------------------------------CLASS TEAM--------------------------------------------------

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




        public function getProjectName()
    {
        return $this->ProjectName;
    }



}
 ?>

