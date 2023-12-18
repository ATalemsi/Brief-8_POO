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


}