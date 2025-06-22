<?php
namespace app\models;
use Flight;

class Client {
    private $nom;
    private $prenom;
    private $email;
    private $password;

    public function __construct($nom, $prenom, $email, $password = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPwd() {
        return $this->password;
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM client");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new Client(
                $row['nom'],
                $row['prenom'],
                $row['email']
            );
        }
        return $list;
    }


    public function checkUser($mail,$password){
        $conn = Flight::db();
        $stmt = $conn->prepare("SELECT * FROM client WHERE email = :email AND password = :password");
        $stmt->bindParam(':email', $mail);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true; // Login successful
        } else {
            return false; // Login failed
        }
    }

}
