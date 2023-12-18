<?php
include('User.php');
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