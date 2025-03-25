<?php
namespace app\controllers;

use setasign\fpdf\fpdf;
use Flight;

class PdfController {
    public static function exportPDF() {
        $db = Flight::db();
        $dateDebut = Flight::request()->data->dateDeb;
        $dateFin = Flight::request()->data->dateFin;

        // Vérifier si les dates sont valides
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

            // Récupérer les données pour ce mois spécifique (recettes et dépenses)
            $query = "SELECT
                        v.nomRubrique, 
                        c.idCategorie,
                        SUM(CASE WHEN v.previsionOuRealisation = 0 THEN v.montant ELSE 0 END) AS prevision,
                        SUM(CASE WHEN v.previsionOuRealisation = 1 THEN v.montant ELSE 0 END) AS realisation,
                        c.recetteOuDepense
                    FROM Valeur v
                    JOIN Type t ON v.idType = t.idType
                    JOIN Categorie c ON t.idCategorie = c.idCategorie
                    WHERE YEAR(v.date) = :year AND MONTH(v.date) = :month AND v.validation = 1
                    GROUP BY v.nomRubrique, c.idCategorie
                    ORDER BY v.nomRubrique ASC
            ";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':year' => $year,
                ':month' => $month
            ]);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (!$data) continue;

            // Calcul des recettes et des dépenses
            $totalRecettesPrevision = 0;
            $totalDepensesPrevision = 0;
            $totalRecettesRealisation = 0;
            $totalDepensesRealisation = 0;

            foreach ($data as $row) {
                if ($row['recetteOuDepense'] == 0) { // Depense
                    $totalDepensesPrevision += $row['prevision'];
                    $totalDepensesRealisation += $row['realisation'];
                } else { // Recette
                    $totalRecettesPrevision += $row['prevision'];
                    $totalRecettesRealisation += $row['realisation'];
                }
            }

            // Calcul des soldes
            $soldePrevision = $totalRecettesPrevision - $totalDepensesPrevision;
            $soldeRealisation = $totalRecettesRealisation - $totalDepensesRealisation;

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

                $pdf->Cell($widths[0], 10, $row['nomRubrique'], 1, 0, 'L');
                $pdf->Cell($widths[1], 10, number_format($prevision, 2), 1, 0, 'R');
                $pdf->Cell($widths[2], 10, number_format($realisation, 2), 1, 0, 'R');
                $pdf->Cell($widths[3], 10, number_format($ecart, 2), 1, 0, 'R');
                $pdf->Ln();
            }

            // Solde de prévision et réalisation
            $pdf->Ln(5);
            $pdf->Cell(70, 10, 'Total Recettes (Prevision):', 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($totalRecettesPrevision, 2), 0, 1, 'R');
            $pdf->Cell(70, 10, 'Total Depenses (Prevision):', 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($totalDepensesPrevision, 2), 0, 1, 'R');
            $pdf->Cell(70, 10, 'Solde Prevision:', 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($soldePrevision, 2), 0, 1, 'R');

            $pdf->Cell(70, 10, 'Total Recettes (Realisation):', 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($totalRecettesRealisation, 2), 0, 1, 'R');
            $pdf->Cell(70, 10, 'Total Depenses (Realisation):', 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($totalDepensesRealisation, 2), 0, 1, 'R');
            $pdf->Cell(70, 10, 'Solde Realisation:', 0, 0, 'L');
            $pdf->Cell(40, 10, number_format($soldeRealisation, 2), 0, 1, 'R');
        }

        // Téléchargement du PDF
        $pdf->Output('D', 'Rapport_Budgetaire.pdf');
    }
}
