<?php

namespace app\models;

use Flight;

class Statistique {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Récupère les 5 meilleurs produits vendus
     * @return array Tableau des meilleurs produits avec leur quantité totale vendue
     */
    public function getBestProduct() {
        $query = "
            SELECT p.idProduit, p.nomProduit, SUM(v.quantite) as total_vendu
            FROM vente v
            JOIN produit p ON v.idProduit = p.idProduit
            GROUP BY v.idProduit
            ORDER BY total_vendu DESC
            LIMIT 5
        ";

        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les clients les plus fidèles (plus gros acheteurs)
     * @param int $limit Nombre de clients à retourner
     * @return array
     */
    public function getTopCustomers() {
        $query = "
            SELECT c.id_client, c.nom, SUM(v.quantite * p.prix) as total_achats
            FROM client c
            JOIN vente v ON c.id_client = v.idClient
            JOIN produit p ON v.idProduit = p.idProduit
            GROUP BY c.id_client
            ORDER BY total_achats DESC
            LIMIT 5
        ";
        
        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les CRM qui ont le plus fonctionné et augmenté les ventes
     * Note: Cette implémentation suppose que vous avez une logique pour lier les CRM aux ventes
     * (par exemple via une table de liaison). Comme cette table n'est pas définie dans votre schéma,
     * je fais une implémentation de base qui pourrait nécessiter des ajustements.
     * @return array Tableau des CRM les plus efficaces
     */
    public function getBestCrm() {
        // Implémentation de base - à adapter selon votre logique métier
        $query = "
            SELECT c.idCrm, c.label, COUNT(v.idVente) as ventes_associees
            FROM Crm c
            LEFT JOIN vente v ON /* Ici devrait être votre condition de liaison entre CRM et ventes */
            GROUP BY c.idCrm
            ORDER BY ventes_associees DESC
        ";

        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Version alternative de getBestCrm si vous avez une table de liaison entre CRM et clients
     * (supposons que vous avez une table client_crm avec idClient et idCrm)
     */
    public function getBestCrmAlternative() {
        $query = "
            SELECT crm.idCrm, crm.label, COUNT(v.idVente) as ventes_associees
            FROM Crm crm
            JOIN client_crm cc ON crm.idCrm = cc.idCrm
            JOIN vente v ON cc.idClient = v.idClient
            GROUP BY crm.idCrm
            ORDER BY ventes_associees DESC
        ";

        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Version améliorée avec gestion des mois sans vente
    public function getSalesByMonth($year = null) {
        if ($year === null) {
            $year = date('Y');
        }

        $query = "SELECT 
                        MONTH(dateVente) as mois,
                        SUM(quantite) as total_ventes
                    FROM vente
                    WHERE YEAR(dateVente) = :year
                    GROUP BY mois
                    ORDER BY mois
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':year' => $year
        ]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Remplir les mois manquants avec 0
        $allMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonths[$i] = ['mois' => $i, 'total_ventes' => 0];
        }

        foreach ($result as $row) {
            $allMonths[$row['mois']] = $row;
        }

        return array_values($allMonths);
    }

    function getChiffreAffaire($year): float {
        $sql = "
            SELECT SUM(p.prix * v.quantite) AS chiffre_affaire
            FROM vente v
            JOIN produit p ON v.idProduit = p.idProduit
            WHERE YEAR(v.dateVente) = :year
        ";
    
        $stmt = Flight::db()->prepare($sql);
        $stmt->execute([
            'year' => $year
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        return $result['chiffre_affaire'] ?? 0.0;
    }
    
    public static function getTicketParMois($etat, $dept, $annee) {
        $pdo = Flight::db();

        $query = "
            SELECT MONTH(dateDebut) as mois, COUNT(*) as nb
            FROM Ticket
            WHERE YEAR(dateDebut) = :annee
        ";

        $params = [':annee' => $annee];

        // Ajouter dynamiquement les filtres seulement si les paramètres sont renseignés
        if (!empty($etat)) {
            $query .= " AND idEtat = :etat";
            $params[':etat'] = $etat;
        }

        if (!empty($dept)) {
            $query .= " AND idDept = :dept";
            $params[':dept'] = $dept;
        }

        $query .= " GROUP BY mois ORDER BY mois;";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $mois = ['Jan.', 'Fév.', 'Mars', 'Avr.', 'Mai', 'Juin', 'Juil.', 'Août', 'Sep.', 'Oct.', 'Nov.', 'Déc.'];
        $valeurs = array_fill(0, 12, 0);

        foreach ($result as $row) {
            $valeurs[$row['mois'] - 1] = (int)$row['nb'];
        }

        return [
            'mois' => $mois,
            'valeurs' => $valeurs
        ];
    }


    public function getDepartements() {
        $query = "SELECT idDept, nomDept FROM Dept";
        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getEtats() {
        $query = "SELECT idEtat, nom FROM Etat";
        $result = $this->db->query($query);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Top 5 clients par nombre de tickets
    public function getTopClientsByTickets() {
        $sql = "
            SELECT c.nom, c.prenom, COUNT(t.id_ticket) as nb_tickets
            FROM client c
            JOIN report_client rc ON rc.id_client = c.id_client
            JOIN ticket t ON t.id_report = rc.id_report
            GROUP BY c.id_client
            ORDER BY nb_tickets DESC
            LIMIT 5
        ";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Satisfaction client par agent (moyenne des notes)
    public function getSatisfactionByAgent() {
        $sql = "
            SELECT a.nom, a.prenom, AVG(rc.note) as satisfaction
            FROM agent a
            JOIN ticket t ON t.id_agent = a.id_agent
            JOIN report_client rc ON rc.id_report = t.id_report
            WHERE rc.note IS NOT NULL
            GROUP BY a.id_agent
        ";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Temps de traitement moyen par catégorie
    public function getTimeByCategory() {
        $sql = "
            SELECT ct.nom as categorie, AVG(md.duree) as temps_moyen
            FROM categorie_ticket ct
            JOIN ticket t ON t.id_categorie = ct.id_categorie
            JOIN mvt_duree md ON md.id_ticket = t.id_ticket
            GROUP BY ct.id_categorie
        ";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Budget prévisionnel (total, dépensé, reste)
    public function getBudgetPrevisionnel() {
        // Total = somme des prévisions, Dépensé = somme des réalisations, Reste = Total - Dépensé
        $sqlTotal = "SELECT SUM(montant) as total FROM Valeur WHERE previsionOuRealisation = 0";
        $sqlDepense = "SELECT SUM(montant) as depense FROM Valeur WHERE previsionOuRealisation = 1";
        $total = $this->db->query($sqlTotal)->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0;
        $depense = $this->db->query($sqlDepense)->fetch(\PDO::FETCH_ASSOC)['depense'] ?? 0;
        $reste = $total - $depense;
        return [
            'total' => $total,
            'depense' => $depense,
            'reste' => $reste
        ];
    }
}
?>