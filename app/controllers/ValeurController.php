<?php

namespace app\controllers;

use app\models\Crm;
use app\models\Vente;
use Flight;
use app\models\Valeur;

class ValeurController
{
    public function getFormulaireImportCSV()
    {
        Flight::render('importCSV');
    }

    public function doImportCSV()
    {
        // On récupère le fichier CSV directement à partir de l'input
        $file = Flight::request()->files->filePath;

        // Si un fichier a été trouvé
        if ($file) {
            // On récupère le chemin temporaire du fichier téléchargé
            $file_path = $file['tmp_name'];

            // Appel à la méthode dans la classe Valeur pour importer les données du fichier CSV
            $valeurs = Valeur::getListeValeurFromCsv($file_path);

            // Redirection ou retour après l'importation
            Flight::redirect('/budget');
        } else {
            // Si le fichier n'a pas été trouvé ou téléchargé, on affiche une erreur
            Flight::flash('error', 'Aucun fichier téléchargé.');
            Flight::redirect('/import');
        }
    }

    // public function inserValeur()  {
    //     $valeur = new Valeur(
    //         Flight::request()->data->idValeur,
    //         Flight::request()->data->nomRubrique,
    //         Flight::request()->data->idType,
    //         Flight::request()->data->previsionOuRealisation,
    //         Flight::request()->data->montant,
    //         Flight::request()->data->date,
    //         Flight::request()->data->validation
    //     );
    // }

    // public function savePrevision() {
    //     // Récupérer les données du formulaire
    //     $nomRubrique = Flight::request()->data->nature;
    //     $idType = Flight::request()->data->type;
    //     $montant = Flight::request()->data->montant;
    //     $date = date('Y-m-d'); // Date actuelle
    //     $previsionOuRealisation = 0; // Prévision (1)
    //     $validation = 0; // Non validé par défaut

    //     // Créer un objet Valeur
    //     $valeur = new Valeur(null, $nomRubrique, $idType, $previsionOuRealisation, $montant, $date, $validation);

    //     // Sauvegarder dans la base de données
    //     if ($valeur->insert()) {
    //         echo "Prévision ajoutée avec succès.";
    //         Flight::redirect('budget');
    //     } else {
    //         echo "Erreur lors de l'ajout de la prévision.";
    //     }

    // }

    public function saveRealisation()
    {
        // Récupérer les données du formulaire
        $nomRubrique = Flight::request()->data->nature;
        $idType = Flight::request()->data->type;
        $montant = Flight::request()->data->montant;
        $idDept = $_SESSION['idDept'];
        $date = Flight::request()->data->dateReal; // Date actuelle
        $previsionOuRealisation = 1; // Réalisation (0)
        $validation = 0; // Validé par défaut

        // Créer un objet Valeur
        $valeur = new Valeur(0, $nomRubrique, $idType, $previsionOuRealisation, $montant, $date, $validation, $idDept);

        // Sauvegarder dans la base de données
        if ($valeur->insert()) {
            Flight::redirect('budget');
        } else {
            echo "Erreur lors de l'ajout de la réalisation.";
        }
    }

    public function saveCRM()
    {
        // Récupérer les données du formulaire
        $montant = Flight::request()->data->valeur;
        $idDept = $_SESSION['idDept'];
        $date = Flight::request()->data->dateCrm; // Date actuelle
        $crm = Flight::request()->data->idCrm;
        $labelCRM = Crm::findById($crm)->getLabel();

        $sommeCRM = Crm::getResteCRMValue($idDept, $date);
        if ($sommeCRM > $montant) {
            $previsionOuRealisation = 1;
            $validation = 1;

            // Exemple de valeurs valides (ils doivent exister dans les tables produit et client)
            
            // Création d'un objet Vente
            
            // Sauvegarde dans la base de données
            for ($i=0; $i < rand(1, 10); $i++) { 
                $idProduit = rand(1,10);
                $idClient = rand(1,8);
                $dateVente = $date; // date du jour
                $quantite = rand(1,5);
                $vente = new Vente($idProduit, $idClient, $dateVente, $quantite);
                $vente->save();
            }

            // Créer un objet Valeur
            $valeur = new Valeur(0, $labelCRM, 7, $previsionOuRealisation, $montant, $date, $validation, $idDept);

            // Sauvegarder dans la base de données
            if ($valeur->insert()) {
                Flight::redirect('budget');
            } else {
                echo "Erreur lors de l'ajout de la réalisation.";
            }
        } else {
            $previsionOuRealisation = 1;
            $validation = 0;

            // Créer un objet Valeur
            $valeur = new Valeur(0, $labelCRM, 7, $previsionOuRealisation, $montant, $date, $validation, $idDept);

            // Sauvegarder dans la base de données
            if ($valeur->insert()) {
                Flight::redirect('budget');
            } else {
                echo "Erreur lors de l'ajout de la réalisation.";
            }
        }
    }

    public function savePrevision()
    {
        // Récupérer les données du formulaire
        $nomRubrique = Flight::request()->data->nature;
        $idType = Flight::request()->data->type;
        $montant = Flight::request()->data->montant;
        $idDept = $_SESSION['idDept'];
        $date = Flight::request()->data->datePrev; // Date actuelle
        $previsionOuRealisation = 0; // Réalisation (0)
        $validation = 0; // Validé par défaut

        // Créer un objet Valeur
        $valeur = new Valeur(0, $nomRubrique, $idType, $previsionOuRealisation, $montant, $date, $validation, $idDept);

        // Sauvegarder dans la base de données
        if ($valeur->insert()) {
            Flight::redirect('budget');
        } else {
            echo "Erreur lors de l'ajout de la réalisation.";
        }
    }
}
