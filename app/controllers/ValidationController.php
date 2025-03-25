<?php

namespace app\controllers;

use app\models\Validation;
use Flight;

class ValidationController {
	public function getListValidation() {

        $validation = new Validation();
        $data = [
            'page' => 'validation',
            'validations' => $validation->getAllValidation()
        ];
        Flight::render('template', $data);
    }

    public function valider($id)  {
        $validation = new Validation();
        $success = $validation->setValidationValider($id);

        if ($success) {
            Flight::redirect('/validation');
        } else {
            Flight::halt(500, 'Erreur lors de la mise à jour de la validation. Vérifiez les logs pour plus de détails.');
        }
    }

    public function refuser($id) {
        $validation = new Validation();
        $success = $validation->setValidationRefuser($id);

        if ($success) {
            Flight::redirect('/validation');
        } else {
            Flight::halt(500, 'Erreur lors de la mise à jour de la validation. Vérifiez les logs pour plus de détails.');
        }
    }
 
}