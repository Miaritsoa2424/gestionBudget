<?php
namespace app\models;
use Flight; 
use PDO;
class Type {
    private $idType;
    private $idCategorie;
    private $nomType;
    private $conn;

    // Constructeur qui prend des valeurs pour les attributs
    public function __construct($idType, $idCategorie, $nomType) {
        $this->setIdType($idType);
        $this->setIdCategorie($idCategorie);
        $this->setNomType($nomType);
        $this->conn = Flight::db();  // Connexion à la base de données
    }

    // Getters et Setters
    public function getIdType() {
        return $this->idType;
    }

    public function setIdType($idType) {
        $this->idType = $idType;
    }

    public function getIdCategorie() {
        return $this->idCategorie;
    }

    public function setIdCategorie($idCategorie) {
        $this->idCategorie = $idCategorie;
    }

    public function getNomType() {
        return $this->nomType;
    }

    public function setNomType($nomType) {
        $this->nomType = $nomType;
    }

    public static function getAll() {
        $sql = "SELECT * FROM Type";
        $conn = Flight::db();
        $stmt = $conn->query($sql);
        $types = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $type = new Type($row['idType'], $row['idCategorie'], $row['nomType']);
            $types[] = $type;
        }
        return $types;
    }

    // Méthode pour obtenir un type par son nom
    public static function getTypeByName($nomType) {
        $sql = "SELECT * FROM Type WHERE nomType = ?";
        $conn = Flight::db();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nomType]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $type = new Type($row['idType'], $row['idCategorie'], $row['nomType']);
            return $type;
        }
        return false;
    }

    // Méthode pour obtenir un type par son ID
    public static function getTypeById($idType) {
        $sql = "SELECT * FROM Type WHERE idType = ?";
        $conn = Flight::db();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idType]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $type = new Type($row['idType'], $row['idCategorie'], $row['nomType']);
            return $type;
        }
        return false;
    }
    public static function getAllType() {
        $sql = "SELECT * FROM Type";
        $conn = Flight::db();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // Utiliser fetchAll() pour récupérer les résultats sous forme de tableau associatif
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($rows) {
            return $rows; // Retourner directement le tableau de résultats
        }
    
        return false;
    }
    
}
?>
