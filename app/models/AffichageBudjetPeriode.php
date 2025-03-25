<?php

namespace app\Models;

class AffichageBudjetPeriode {
    public function getPrevisionByDate($date, $idDept)  {
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

    public function getRealisationByDate($date, $idDept)  {
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

    public function getRealisationPrevisionInInterDate($date_debut, $date_fin, $idDept)  {
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
}