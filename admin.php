<?php
include('User.php');
class Admin extends User{
   public function registerProductOwner($nom, $prenom, $email, $tel, $password, $role) {
            
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                
                $stmt = $this->pdo->prepare("INSERT INTO Users (Nom, Prenom, Email, Tel, PasswordU, UserRole) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $tel, $hashedPassword, $role]);
                if ($stmt) {
                echo "Product Owner added successfully!";
                header("Location: users.php");
            } else {
                echo "Error Registration Product Owner.";
            }
      
    }
   public function updateProductOwner($id, $nom, $prenom, $email, $tel, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $stmt = $this->pdo->prepare("UPDATE users SET Nom = ?, Prenom = ?, Email = ?, Tel = ?, PasswordU = ?, UserRole = ? WHERE ID_User = ?");
        $stmt->execute([$nom, $prenom, $email, $tel, $hashedPassword, $role, $id]);
    
        if ($stmt) {
            echo "Product Owner updated successfully!";
            header("Location: admin/users.php");
            exit();
        } else {
            echo "Error updating user.";
        }
    }
    public function Get_Role($id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE ID_User = ?");
    $stmt->execute([$id]);

    if ($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Error executing query: " ;
        exit();
    }

    }
    public function Delete_user($id){
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE ID_User = ?");
        $stmt->execute([$id]);

        header("Location: /admin/users.php");
    exit();
    }
     public function Get_User(){
        $id=null;
        $Nom=null;
        $Prenom=null;
        $UserRole=null;

        $sql = "SELECT ID_User, Nom, Prenom, UserRole
        FROM users ";
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt) {
            die("Error preparing statement: " . $this->pdo->errorInfo());
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->errorInfo());
        }
        // Bind the result variables
        $stmt->bindColumn('ID_User', $id);
        $stmt->bindColumn('Nom', $Nom);
        $stmt->bindColumn('Prenom', $Prenom);
        $stmt->bindColumn('UserRole', $UserRole);

        $users = [];

        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            $users[] = [
                'ID_User' => $id,
                'Nom' => $Nom,
                'Prenom' => $Prenom,
                'UserRole' => $UserRole,
                
            ];
        }
        $stmt->closeCursor();
        return $users;

     }
}