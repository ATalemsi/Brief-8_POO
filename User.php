<?php
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

            if ($user !== false && password_verify($password, $user['PasswordU'])) {
                // Only proceed if $user is not false

                $this->userID = $user['ID_User'];
                $this->nom = $user['Nom'];
                $this->prenom = $user['Prenom'];
                $this->email = $user['Email'];
                $this->tel = $user['Tel'];
                $this->role = $user['UserRole'];

                return $user;
            } else {
                return false;
            }
        }

    public function signUp($nom, $prenom, $email, $tel, $password, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (Nom, Prenom, Email, Tel, PasswordU, UserRole) VALUES (?, ?, ?, ?, ?, ?)");
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