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
            $file = Flight::request()->files->filePath;
    
            // Si un fichier a été trouvé
            if ($file) {
                // On récupère le chemin temporaire du fichier téléchargé
                $file_path = $file['tmp_name'];
    
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

        public function inserValeur()  {
            $valeur = new Valeur(
                Flight::request()->data->idValeur,
                Flight::request()->data->nomRubrique,
                Flight::request()->data->idType,
                Flight::request()->data->previsionOuRealisation,
                Flight::request()->data->montant,
                Flight::request()->data->date,
                Flight::request()->data->validation,
                Flight::request()->data->idDept
            );
        }

        public function savePrevision() {
            // Récupérer les données du formulaire
            $nomRubrique = Flight::request()->data->nature;
            $idType = Flight::request()->data->type;
            $montant = Flight::request()->data->montant;
            $date = date('Y-m-d'); // Date actuelle
            $previsionOuRealisation = 0; // Prévision (1)
            $validation = 0; // Non validé par défaut
            $idDept = Flight::request()->data->idDept;


            // Créer un objet Valeur
            $valeur = new Valeur(null, $nomRubrique, $idType, $previsionOuRealisation, $montant, $date, $validation, $idDept);

            // Sauvegarder dans la base de données
            if ($valeur->insert()) {
                echo "Prévision ajoutée avec succès.";
                Flight::redirect('budget');
            } else {
                echo "Erreur lors de l'ajout de la prévision.";
            }
            
        }

        public function saveRealisation() {
            // Récupérer les données du formulaire
            $nomRubrique = Flight::request()->data->nature;
            $idType = Flight::request()->data->type;
            $montant = Flight::request()->data->montant;
            $date = date('Y-m-d'); // Date actuelle
            $previsionOuRealisation = 1; // Réalisation (0)
            $validation = 1; // Validé par défaut
            $idDept = Flight::request()->data->idDept;


            // Créer un objet Valeur
            $valeur = new Valeur(null, $nomRubrique, $idType, $previsionOuRealisation, $montant, $date, $validation,$idDept);

            // Sauvegarder dans la base de données
            if ($valeur->insert()) {
                Flight::redirect('budget');
            } else {
                echo "Erreur lors de l'ajout de la réalisation.";
            }

        }
    }