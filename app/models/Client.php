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


}
