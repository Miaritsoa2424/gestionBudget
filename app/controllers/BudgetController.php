<?php

namespace app\controllers;

use app\models\Departement;
use Flight;

class BudgetController
{
   public function getBudget()
   {
      $data = ['page' => 'budget'];
      Flight::render('template', $data);
   }

}
