<?php
namespace app\models;
use Flight;

class Client {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $notification;

    public function __construct($id, $nom, $prenom, $email, $password = null) {
        $this->id = $id;
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

    public function getId() {
        return $this->id;
    }

    public static function getAll() {
        $conn = Flight::db();
        $stmt = $conn->query("SELECT * FROM client");
        $list = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = new Client(
                $row['id_client'],
                $row['nom'],
                $row['prenom'],
                $row['email']
            );
        }
        return $list;
    }


    public static function getClientReportDetail($id_report) {
        $conn = Flight::db();
        $sql = "SELECT rc.*, c.nom, c.prenom, c.email 
                FROM report_client rc
                JOIN client c ON rc.id_client = c.id_client
                WHERE rc.id_report = :id_report";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id_report'=> $id_report
        ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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
