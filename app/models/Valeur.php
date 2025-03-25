<?php
namespace app\models;
use Flight;
class Valeur {
    private $idValeur;
    private $nomRubrique;
    private $idType;
    private $previsionOuRealisation;
    private $montant;
    private $date;
    private $validation;
    private $conn;

// Constructeur qui prend des valeurs pour les attributs
    public function __construct($idValeur, $nomRubrique, $idType, $previsionOuRealisation, $montant, $date, $validation) {
        $this->setIdValeur($idValeur);
        $this->setNomRubrique($nomRubrique);
        $this->setIdType($idType);
        $this->setPrevisionOuRealisation($previsionOuRealisation);
        $this->setMontant($montant);
        $this->setDate($date);
        $this->setValidation($validation);
        $this->conn = Flight::db();  // Connexion à la base de données
    }
    // Getters et Setters
    public function getIdValeur() {
        return $this->idValeur;
    }

    public function setIdValeur($idValeur) {
        $this->idValeur = $idValeur;
    }

    public function getNomRubrique() {
        return $this->nomRubrique;
    }

    public function setNomRubrique($nomRubrique) {
        $this->nomRubrique = $nomRubrique;
    }

    public function getIdType() {
        return $this->idType;
    }

    public function setIdType($idType) {
        $this->idType = $idType;
    }

    public function getPrevisionOuRealisation() {
        return $this->previsionOuRealisation;
    }

    public function setPrevisionOuRealisation($previsionOuRealisation) {
        $this->previsionOuRealisation = $previsionOuRealisation;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getValidation() {
        return $this->validation;
    }

    public function setValidation($validation) {
        $this->validation = $validation;
    }

    // Méthode pour sauvegarder ou insérer la valeur dans la base de données
    public function insert() {
        $sql = "INSERT INTO Valeur (nomRubrique, idType, previsionOuRealisation, montant, date, validation) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $this->getNomRubrique(), 
            $this->getIdType(), 
            $this->getPrevisionOuRealisation(), 
            $this->getMontant(), 
            $this->getDate(), 
            0
        ]);
    }

    public static function gestionPrevisionRealisation($previsionOuRealisation) {
        // Convertir la valeur en minuscule pour ignorer la casse
        $previsionOuRealisation = strtolower(trim($previsionOuRealisation));
        
        // Vérifier si la valeur est numérique ou une chaîne
        if ($previsionOuRealisation === "prevision" || $previsionOuRealisation === "1") {
            return 1;  // pour "prevision" ou "1"
        } elseif ($previsionOuRealisation === "realisation" || $previsionOuRealisation === "0") {
            return 0;  // pour "realisation" ou "0"
        } else {
            return null;  // retourne null si la valeur n'est pas valide
        }
    }
    
    public static function getListeValeurFromCsv($filePath = "") {
        $valeurs = [];
        
        // Ouvrir le fichier CSV en mode lecture
        if (($fileCsv = fopen($filePath, "r")) !== false) {
            // Lire la première ligne pour obtenir les en-têtes
            $headers = fgetcsv($fileCsv, 1000, ";");
    
            // Vérifier si les en-têtes sont valides
            if ($headers === false) {
                echo "Erreur : impossible de lire l'entête du fichier.";
                fclose($fileCsv);
                return [];
            }
    
            // Lire chaque ligne du fichier
            while (($data = fgetcsv($fileCsv, 1000, ";")) !== false) {
                // Associer les valeurs aux en-têtes pour créer un tableau associatif
                $row = array_combine($headers, $data);
    
                // Nettoyer les valeurs pour supprimer les guillemets ou simples cotes
                foreach ($row as $key => $value) {
                    // Supprimer les guillemets ou simples cotes entourant les valeurs
                    $row[$key] = trim($value, "'\""); // Cela enlève les guillemets ou les simples cotes
                }
    
                // Utiliser la fonction gestionPrevisionRealisation pour convertir le texte en 1 ou 0
                $previsionOuRealisationValue = Valeur::gestionPrevisionRealisation($row['previsionOuRealisation'] ?? '');
    
                // Créer un objet Valeur pour chaque ligne et ajouter à la liste
                $valeur = new Valeur(
                    $row['idValeur'] ?? null, // idValeur
                    $row['nomRubrique'] ?? null, // nomRubrique
                    $row['idType'] ?? null, // idType
                    $previsionOuRealisationValue, // previsionOuRealisation
                    $row['montant'] ?? null, // montant
                    $row['date'] ?? null, // date
                    0  // validation
                );
                $valeurs[] = $valeur;

                // Sauvegarder la valeur dans la base de données
                $valeur->insert();
            }
    
            // Fermer le fichier après lecture
            fclose($fileCsv);
        } else {
            // Si le fichier ne peut pas être ouvert, afficher une erreur
            echo "Erreur : impossible d'ouvrir le fichier.";
        }
    
        // Afficher les objets pour débogage
        // foreach ($valeurs as $val) {
        //     print_r($val);
        //     echo "<br>";
        // }
    
        // Retourner la liste des objets Valeur
        return $valeurs;
    }
}
?>
