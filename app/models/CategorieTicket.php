<?php
namespace app\models;

class CategorieTicket
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

    // Récupérer toutes les catégories
    public static function getAll()
    {
        $db = \Flight::db();
        $stmt = $db->query("SELECT * FROM categorie_ticket");
        $categories = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $categories[] = new CategorieTicket(
                $row['id_categorie'],
                $row['nom']
            );
        }
        return $categories;
    }
}