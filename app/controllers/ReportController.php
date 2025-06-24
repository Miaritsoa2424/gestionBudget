<?php

namespace app\controllers;


use app\models\Client;
use app\models\Report;
use Flight;

class ReportController {

	public function __construct() {

	}


    public function insertReport() {
        // Récupérer les données du formulaire
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;

        if (isset($_SESSION['id_client'])) {
            $id_client = $_SESSION['id_client'] ?? null; // À adapter selon votre gestion de session
            // $id_client = $_SESSION['id_client'] ?? 1; // À adapter selon votre gestion de session
        }
       else {
            $id_client = null; // Si l'id client n'est pas fourni, on le met à null
        }
        // $id_client = 1;
        // Gestion de la pièce jointe (on prend le nom du premier fichier s'il y en a)
        $piece_jointe = null;
        if (isset($_FILES['attachments']) && $_FILES['attachments']['error'][0] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = basename($_FILES['attachments']['name'][0]);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['attachments']['tmp_name'][0], $targetPath)) {
                $piece_jointe = $fileName;
            }
        }

        // Création de l'objet Report
        $report = new Report(
            null, // id
            $description,
            $piece_jointe,
            date('Y-m-d H:i:s'),
            null, // note
            null, // date_note
            null,  // commentaire,
            0,
            $id_client
        );

        // Sauvegarde du rapport
        if (!$id_client) {
            die('Erreur : id_client manquant');
        }

        // ...reste du code...
        try {
            $success = false;
            if ($id_client && $report->saveReport($id_client)) {
                $success = true;
            }
        } catch (\PDOException $e) {
            die('Erreur SQL : ' . $e->getMessage());
        }

        $data = [
            'title' => 'Rapport Client',
            'page' => 'report-client'
        ];
        // Redirection ou affichage selon le résultat
        if ($success) {
            Flight::render('template-client', ['title' => 'Rapport client', 'page' => 'report-client', 'success' => true, 'donnees' => $report]);
        } else {
            Flight::render('template-client', ['title' => 'Rapport client', 'page' => 'report-client', 'error' => true, 'donnees' => $report]);
        }
    }

    public function submitRating() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id_client = $_SESSION['id_client'] ?? null;
        $id_agent = $data['id_agent'] ?? null;
        $note = $data['note'] ?? null;
        $commentaire = $data['commentaire'] ?? null;

        if (!$id_client || !$id_agent || !$note) {
            Flight::json(['success' => false, 'error' => 'Paramètres manquants']);
            return;
        }

        // Récupérer le dernier report_client lié à ce client et cet agent
        $db = Flight::db();
        $sql = "SELECT rc.id_report
                FROM report_client rc
                JOIN ticket t ON t.id_report = rc.id_report
                WHERE rc.id_client = :id_client AND t.id_agent = :id_agent
                ORDER BY rc.date_report DESC
                LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id_client' => $id_client, 
            'id_agent' => $id_agent
        ]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            Flight::json(['success' => false, 'error' => 'Aucun rapport trouvé']);
            return;
        }

        $id_report = $row['id_report'];

        // Mettre à jour la note, date_note et commentaire
        $sql2 = "UPDATE report_client SET note = :note, date_note = NOW(), commentaire = :comm WHERE id_report = :id_report";
        $stmt2 = $db->prepare($sql2);
        $ok = $stmt2->execute([
            ':note' => $note, 
            ':comm' => $commentaire, 
            ':id_report' => $id_report
        ]);

        Flight::json(['success' => $ok]);
    }
}

