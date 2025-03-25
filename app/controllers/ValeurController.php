<?php
    namespace app\controllers;
    use Flight;
    use app\models\Valeur;
    class ValeurController{
        public function getFormulaireImportCSV() {
            Flight::render('importCSV');
        }

        public function doImportCSV() {
            // On récupère le fichier CSV directement à partir de l'input
            $file = Flight::request()->files->file;
    
            if ($file) {
                // On récupère le chemin temporaire du fichier téléchargé
                $file_path = $file->tmp_name;
    
                // Appel à la méthode dans la classe Valeur pour importer les données du fichier CSV
                $valeurs = Valeur::getListeValeurFromCsv($file_path);
    
                // Redirection ou retour après l'importation
                Flight::redirect('/valeur/liste');
            } else {
                // Si le fichier n'a pas été trouvé ou téléchargé, on affiche une erreur
                Flight::flash('error', 'Aucun fichier téléchargé.');
                Flight::redirect('/valeur/import');
            }
        }


    }