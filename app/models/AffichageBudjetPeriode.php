<?php

namespace app\Models;

use DateTime;
use Flight;
use PDO;

class AffichageBudjetPeriode {
    function getSoldeActuelle($dateDebut, $idDept) {
        try {
            $conn = Flight::db();
            $sql = "SELECT getSoldeActuelle('$dateDebut', $idDept) AS solde";
            $stmt = $conn->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? $result['solde'] : 0;
        } catch (\PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
            return null;
        }
    }
    

    public static function getDebutsDeMois($dateDeb, $dateFin) {
        $dates = [];

        // Convertir les dates en objets DateTime
        $start = new DateTime($dateDeb);
        $end = new DateTime($dateFin);

        // Se placer au début du mois suivant si la date de départ n'est pas le 1er
        if ($start->format('d') != '01') {
            $start->modify('first day of next month');
        }

        // Boucle tant que la date de début est avant la date de fin
        while ($start <= $end) {
            $dates[] = $start->format('Y-m-d'); // Ajouter le début du mois à la liste
            $start->modify('first day of next month'); // Passer au mois suivant
        }

        return $dates;
    }

    public function getPrevisionByDate($date, $idDept)
    {
        $mois = date('m', strtotime($date));
        $annee = date('Y', strtotime($date));

        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=gestion', 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $query = "SELECT v.*, t.nomType, c.nomCategorie, c.recetteOuDepense
                      FROM Valeur v
                      JOIN Type t ON v.idType = t.idType
                      JOIN Categorie c ON t.idCategorie = c.idCategorie
                      WHERE v.previsionOuRealisation = 0
                      AND MONTH(v.date) = :mois
                      AND YEAR(v.date) = :annee
                      AND v.idDept = :idDept";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':mois', $mois, \PDO::PARAM_INT);
            $stmt->bindParam(':annee', $annee, \PDO::PARAM_INT);
            $stmt->bindParam(':idDept', $idDept, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => 'Erreur de base de données: ' . $e->getMessage()];
        }
    }

    public function getRealisationByDate($date, $idDept)
    {
        $mois = date('m', strtotime($date));
        $annee = date('Y', strtotime($date));

        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=gestion', 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $query = "SELECT v.*, t.nomType, c.nomCategorie, c.recetteOuDepense
                      FROM Valeur v
                      JOIN Type t ON v.idType = t.idType
                      JOIN Categorie c ON t.idCategorie = c.idCategorie
                      WHERE v.previsionOuRealisation = 1
                      AND MONTH(v.date) = :mois
                      AND YEAR(v.date) = :annee
                      AND v.idDept = :idDept";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':mois', $mois, \PDO::PARAM_INT);
            $stmt->bindParam(':annee', $annee, \PDO::PARAM_INT);
            $stmt->bindParam(':idDept', $idDept, \PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => 'Erreur de base de données: ' . $e->getMessage()];
        }
    }

    public function getRealisationPrevisionInInterDate($date_debut, $date_fin, $idDept)
    {
        $resultats = [];
        $dateCourante = strtotime($date_debut);
        $dateFin = strtotime($date_fin);

        while ($dateCourante <= $dateFin) {
            $date = date('Y-m-d', $dateCourante);

            $previsions = $this->getPrevisionByDate($date, $idDept);

            $realisations = $this->getRealisationByDate($date, $idDept);

            $resultats[] = [
                'mois' => date('m', $dateCourante),
                'annee' => date('Y', $dateCourante),
                'previsions' => $previsions,
                'realisations' => $realisations
            ];

            $dateCourante = strtotime("+1 month", $dateCourante);
        }

        return $resultats;
    }

    public static function getBudgetByMonthYear($idDept, $mois, $annee)
    {
        $sql = "SELECT 
                    Type.nomType AS rubrique, 
                    SUM(CASE WHEN Valeur.previsionOuRealisation = 0 THEN Valeur.montant ELSE 0 END) AS prevision,
                    SUM(CASE WHEN Valeur.previsionOuRealisation = 1 THEN Valeur.montant ELSE 0 END) AS realisation
                FROM Valeur 
                JOIN Type ON Valeur.idType = Type.idType 
                JOIN Categorie ON Type.idCategorie = Categorie.idCategorie
                WHERE Valeur.idDept = :idDept 
                  AND Valeur.validation = 1
                  AND YEAR(Valeur.date) = :annee 
                  AND MONTH(Valeur.date) = :mois 
                GROUP BY Valeur.idType, Type.nomType";

        // Paramètres pour la requête
        $params = [
            ':idDept' => $idDept,
            ':annee' => $annee,
            ':mois' => $mois
        ];

        $stmt = Flight::db()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getRealisationTotalByMonthYear($idDept, $mois, $annee)
    {
        $sql = "SELECT 
                SUM(CASE 
                    WHEN Categorie.recetteOuDepense = 1 AND Valeur.previsionOuRealisation = 1 THEN Valeur.montant
                    ELSE 0
                END) AS totalRecettes,
                SUM(CASE 
                    WHEN Categorie.recetteOuDepense = 0 AND Valeur.previsionOuRealisation = 1 THEN Valeur.montant
                    ELSE 0
                END) AS totalDepenses
            FROM Valeur 
            JOIN Type ON Valeur.idType = Type.idType 
            JOIN Categorie ON Type.idCategorie = Categorie.idCategorie
            WHERE Valeur.idDept = :idDept 
                AND Valeur.validation = 1
              AND YEAR(Valeur.date) = :annee 
              AND MONTH(Valeur.date) = :mois";

        // Paramètres pour la requête
        $params = [
            ':idDept' => $idDept,
            ':annee' => $annee,
            ':mois' => $mois
        ];

        // Préparer et exécuter la requête
        $stmt = Flight::db()->prepare($sql);
        $stmt->execute($params);

        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
