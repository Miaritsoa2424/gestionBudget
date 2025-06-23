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

}
