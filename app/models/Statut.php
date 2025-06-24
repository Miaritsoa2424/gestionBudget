<?php

namespace app\models;

class Statut
{
    private $id;
    private $nom;

    public function __construct($id = null, $nom = null)
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }

    // Récupérer tous les statuts
    public static function getAll()
    {
        $db = \Flight::db();
        $stmt = $db->query("SELECT * FROM statut");
        $statuts = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $statuts[] = new Statut(
                $row['id_statut'],
                $row['nom']
            );
        }
        return $statuts;
    }

    public static function getById($id) {
        $db = \Flight::db();
        $stmt = $db->prepare("SELECT * FROM statut WHERE id_statut = :id_statut");
        $stmt->execute([':id_statut' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            return new Statut(
                $row['id_statut'],
                $row['nom']
            );
        }
        return null;
    }
}