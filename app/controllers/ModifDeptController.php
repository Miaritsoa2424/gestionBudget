<?php 
namespace app\controllers;

use app\models\Departement;
use Flight;

class ModifDeptController
{
    public function getPageDepartement() {
        // Récupérer les départements depuis le modèle
        $depts = Departement::getAllDepartement();
        
        // Rendre la vue avec les départementsç
        $data = [
            'page' => 'departement',
            'depts' => $depts
        ];
        Flight::render('template', $data);
        // Flight::render('template', ['page' => 'departement','depts' => $depts]);
    }
    public function modifierDepartement() {
        $id = Flight::request()->data->idDept;
        $nom = Flight::request()->data->nomDept;
        $mdp = Flight::request()->data->mdp;
        
        // Appeler la méthode de modification du modèle
        $dept = Departement::getDepartementById($id);
        $dept->modifierDepartement($nom, $mdp);
        
        // Rediriger vers la page des départements après la modification
        $this->getPageDepartement();
    }
    public function supprimerDepartement($id) {
        // Appeler la méthode de suppression du modèle
        $dept = Departement::getDepartementById($id);
        $dept->supprimerDepartement();
        
        // Rediriger vers la page des départements après la suppression
        $this->getPageDepartement();
    }
}