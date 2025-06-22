<?php

namespace app\controllers;

use app\models\Departement;
use setasign\fpdf\fpdf;
use Flight;

class PdfController {
    public static function exportPDF() {
        $db = Flight::db();
        $dateDebut = Flight::request()->data->dateDeb;
        $dateFin = Flight::request()->data->dateFin;
        $idDept = Flight::request()->data->idDept;

        if (!Departement::getDroit($_SESSION['idDept'],$idDept)) {
            // echo Departement::getDroit($_SESSION['idDept'],$idDept);
            die("Ne peut pas voir le budget");
        }   

        // Vérifier si les dates sont valide
        if (!$dateDebut || !$dateFin) {
            die("Veuillez spécifier une date de début et une date de fin.");
        }

        // Récupérer les mois dans la période
        $query = "SELECT DISTINCT YEAR(date) AS year, MONTH(date) AS month 
                  FROM Valeur 
                  WHERE validation = 1 
                  AND date BETWEEN :dateDebut AND :dateFin 
                  ORDER BY YEAR(date) ASC, MONTH(date) ASC";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':dateDebut' => $dateDebut,
            ':dateFin' => $dateFin
        ]);
        $periodes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($periodes)) {
            die("Aucune donnée validée entre $dateDebut et $dateFin.");
        }

        // Création du PDF
        $pdf = new \FPDF();
        
        // Groupement par mois
        foreach ($periodes as $periode) {
            $pdf->SetFont('Arial', 'B', 14);
            $year = $periode['year'];
            $month = $periode['month'];
            $monthName = date("F Y", strtotime("$year-$month-01"));

            // Récupérer les données pour ce mois spécifique
            $query = "
                SELECT 
                    nomType, 
                    SUM(CASE WHEN previsionOuRealisation = 0 THEN montant ELSE 0 END) AS prevision,
                    SUM(CASE WHEN previsionOuRealisation = 1 THEN montant ELSE 0 END) AS realisation
                FROM Valeur 
                JOIN Type as t
                ON t.idType = Valeur.idType
                WHERE YEAR(date) = :year AND MONTH(date) = :month AND validation = 1 AND idDept = :idDept
                GROUP BY nomType
                ORDER BY nomType ASC
            ";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':year' => $year,
                ':month' => $month,
                ':idDept' => $idDept
            ]);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (!$data) continue;

            // Nouvelle page pour chaque mois
            $pdf->AddPage();
            $pdf->Cell(190, 10, 'Rapport Budget - ' . $monthName, 0, 1, 'C');
            $pdf->Ln(10);

            // En-tête du tableau
            $header = ['Rubrique', 'Prevision', 'Realisation', 'Ecart'];
            $widths = [70, 40, 40, 40];

            $pdf->SetFont('Arial', 'B', 12);
            foreach ($header as $i => $col) {
                $pdf->Cell($widths[$i], 10, $col, 1, 0, 'C');
            }
            $pdf->Ln();

            // Affichage des données
            $pdf->SetFont('Arial', '', 12);
            foreach ($data as $row) {
                $prevision = $row['prevision'] ?? 0;
                $realisation = $row['realisation'] ?? 0;
                $ecart = $prevision - $realisation;

                $pdf->Cell($widths[0], 10, $row['nomType'], 1, 0, 'L');
                $pdf->Cell($widths[1], 10, number_format($prevision, 2), 1, 0, 'R');
                $pdf->Cell($widths[2], 10, number_format($realisation, 2), 1, 0, 'R');
                $pdf->Cell($widths[3], 10, number_format($ecart, 2), 1, 0, 'R');
                $pdf->Ln();
            }
        }

        // Téléchargement du PDF
        $pdf->Output('D', 'Rapport_Budgetaire.pdf');
    }
}