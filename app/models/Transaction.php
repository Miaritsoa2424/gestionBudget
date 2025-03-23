<?php

namespace app\models;

use Flight;

class Transaction {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insererTransfert($idUser, $montant) {
        // Vérifier les valeurs des paramètres
        // if (!is_numeric($montant) || $montant <= 0) {
        //     // error_log("Erreur lors de l'insertion : montant doit être un nombre positif : ".$montant);

        //     return false; // montant doit être un nombre positif
        // }
      

        $type_transfert = 'entree';
        $status_transfert = 0;
    
        try {
            // Vérifier si l'utilisateur existe dans la table `utilisateur`
            // $stmt = $this->db->prepare("SELECT COUNT(*) FROM utilisateur WHERE idUser = :idUser");
            // $stmt->execute([':idUser' => $idUser]);
            // // if ($stmt->fetchColumn() == 0) {
            // //     // error_log("Erreur lors de l'insertion : idUser non trouvé : ".$idUser);
            // //     return false; // idUser non trouvé
            // // }
    
            // Préparer la requête d'insertion
            $sql = "INSERT INTO transfert (idUser, montant, type_transfert, status_transfert, dateTransfert) 
                    VALUES (:idUser, :montant, :type_transfert, :status_transfert, now())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':idUser' => $idUser,
                ':montant' => $montant,
                ':type_transfert' => $type_transfert,
                ':status_transfert' => $status_transfert
            ]);
    
            return true; // Insertion réussie
        } catch (\PDOException $e) {
            // Gérer les erreurs
            // error_log("Erreur lors de l'insertion : " . $e->getMessage());
            return false;
        }
    }


    public function acheterCadeaux($idUser, $montant) {
        $type_transfert = 'sortie';
        $status_transfert = true;
    
        try {
            // Vérifier si l'utilisateur existe dans la table `utilisateur`
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM utilisateur WHERE idUser = :idUser");
            $stmt->execute(['idUser' => $idUser]);
            if ($stmt->fetchColumn() == 0) {
                error_log("Erreur lors de l'insertion : idUser non trouvé : ".$idUser);
                return false; // idUser non trouvé
            }
    
            // Préparer la requête d'insertion
            $sql = "INSERT INTO transfert (idUser, montant, type_transfert, status_transfert, dateTransfert) 
                    VALUES (:idUser, :montant, :type_transfert, :status_transfert, now())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':idUser' => $idUser,
                ':montant' => $montant,
                ':type_transfert' => $type_transfert,
                ':status_transfert' => $status_transfert
            ]);
    
            return true; // Insertion réussie
        } catch (\PDOException $e) {
            // Gérer les erreurs
            error_log("Erreur lors de l'insertion : " . $e->getMessage());
            return false;
        }
    }




    public function getTransfertNonValide() {
        try {
            $query = "select * from transfert as t join utilisateur as u on t.idUser = u.idUSer WHERE type_transfert ='entree' AND status_transfert = 'false' ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // error_log("Erreur lors de la récupération des transfert : " . $e->getMessage());
            return false;
        }
    }
    public function getSoldeUser($idUser) {
        $queryEntree = "SELECT SUM(montant) AS debit FROM transfert WHERE idUser = :user AND status_transfert = 1 AND type_transfert = 'entree'";
        $querySortie = "SELECT SUM(montant) AS credit FROM transfert WHERE idUser = :user AND type_transfert = 'sortie'";
        
        try {
            // Préparation et exécution de la requête pour les entrées
            $stmtEntree = $this->db->prepare($queryEntree);
            $stmtEntree->execute([':user' => $idUser]);
            $resultEntree = $stmtEntree->fetch(\PDO::FETCH_ASSOC);
            $debit = $resultEntree['debit'] ?? 0; // Si null, initialise à 0
            // error_log("debit=".$debit);
    
            // Préparation et exécution de la requête pour les sorties
            $stmtSortie = $this->db->prepare($querySortie);
            $stmtSortie->execute([':user' => $idUser]);
            $resultSortie = $stmtSortie->fetch(\PDO::FETCH_ASSOC);
            $credit = $resultSortie['credit'] ?? 0; // Si null, initialise à 0
    
            // Calcul du solde
            $solde = $debit - $credit;
    
            return $solde;
        } catch (\PDOException $e) {
            // Gestion des erreurs de la base de données
            // error_log("Erreur lors de la récupération du solde : " . $e->getMessage());
            return null;
        }
    }

    public function getCommission() {
        try {
            $query = "SELECT montant FROM commission";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // error_log("Erreur lors de /la récupération des cadeaux : " . $e->getMessage());
            return false;
        }
    }

    public function updateCommission($montant){
        // Préparer la requête SQL
        $sql = "UPDATE commission 
                SET montant = :montant"; 
        // Exécuter la requête avec une connexion PDO
        $db = Flight::db();
        $stmt = $db->prepare($sql);

        try {
            $stmt->execute([
                ':montant' => $montant
            ]);

            // Vérifier si une ligne a été mise à jour
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
                return false;

        }
    }
    
    
    public function updateTransfert($idTransfert){
        // Préparer la requête SQL
        $sql = "UPDATE transfert 
                SET status_transfert = 1 
                WHERE idTransfert = :idTransfert";

        // Exécuter la requête avec une connexion PDO
        $db = Flight::db();
        $stmt = $db->prepare($sql);

        try {
            $stmt->execute([
                ':idTransfert' => $idTransfert
            ]);

            // Vérifier si une ligne a été mise à jour
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
                return false;

        }
    }

    
}