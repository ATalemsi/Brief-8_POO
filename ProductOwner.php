<?php 
include('User.php');
class Productowner extends User{

    public function addProject($projectName,$productOwnerID){
        try {
            
            $stmt = $this->pdo->prepare("INSERT INTO projects (ProjectName, ProductOwnerID) VALUES (?, ?)");
            $stmt->execute([$projectName, $productOwnerID]);
            echo "Project added successfully!";
            header("Location: project.php");
            exit();
        } catch (PDOException $e) {
            echo "Error adding project: " . $e->getMessage();
        }
    }
    public function GetProduct_project($id){
            $query = "SELECT ID_User, Nom, Prenom FROM Users WHERE UserRole = 'product_owner' AND ID_User = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            

    }
    public function AssignerScrum($projectID,$scrumMasterID){
            try{
                $stmt = $this->pdo->prepare("INSERT INTO ProjectTeams (ProjectID, TeamID) VALUES (?, ?)");
                $stmt->execute([$projectID, $scrumMasterID]);
                echo "Member assigned to team successfully!";
                header("Location: team.php"); 
                exit();
    
            }catch(PDOException $e) {
                echo "Error assigning Scrum to Project: " . $e->getMessage();
            }
         

    }
    function updateProject($id, $projectName) {
    
        $stmt = $this->pdo->prepare("UPDATE projects SET ProjectName = ? WHERE ProjectID = ?");
        $stmt->execute([$projectName, $id]);
    
        if ($stmt) {
            echo "Project updated successfully!";
            header("Location: project.php");
            exit();
        } else {
            echo "Error updating project.";
        }
    }
    public function Supprimer_project($id){
        try{
          $stmt = $this->pdo->prepare("DELETE FROM projects WHERE ProjectID = ?");
         $stmt->execute([$id]);
         header("Location: project.php");
         exit();

        }catch (PDOException $e) {
         echo "Error removing member from team: " . $e->getMessage();
     }
  }

    public function logout()
    {
        

        
        $_SESSION = array();

        
        session_destroy();

        header("Location: ../index.php");
        exit();
    }
    

}