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
        if (isset($_POST['id_client'])) {
            $id_client = $_POST['id_client'];
            // $id_client = 1;
        } else {
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
            $description,
            $piece_jointe,
            date('Y-m-d H:i:s'),
            null, // note
            null, // date_note
            null  // commentaire
        );

        // Sauvegarde du rapport
        $success = false;
        if ($id_client && $report->saveReport($id_client)) {
            $success = true;
        }

        $data = [
            'title' => 'Rapport Client',
            'page' => 'report-client'
        ];
        // Redirection ou affichage selon le résultat
        if ($success) {
            Flight::render('template-client', ['title' => 'Rapport client', 'page' => 'report-client', 'success' => true]);
        } else {
            Flight::render('template-client', ['title' => 'Rapport client', 'page' => 'report-client', 'error' => true]);
        }
    }
}

