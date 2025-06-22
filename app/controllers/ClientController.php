<?php

namespace app\controllers;


use app\models\Client;
use Flight;

class ClientController {

	public function __construct() {

	}
   public function getFormulaireLogin()
    {
        Flight::render('login');
    }

    public function getAccueil()
    {
        Flight::render('accueil');
    }

    public function getClientById()
    {
        $data = Client::getAll();
        Flight::render('template', ['clients' => $data]);     
    }

    public function deconnexion(){
        session_destroy();
        Flight::clear('idDept');
        Flight::render('login', []);   
    }
    public function listClientFront() {
        $data = [
            'title' => 'Liste des Clients',
            'page' => 'list-client',
            'clients' => [
                ['id' => 1, 'name' => 'Client 1', 'email' => 'miaritsoa24@gmail.com', 'phone' => '0341234567', 'notifications' => 5],
                ['id' => 2, 'name' => 'Client 2', 'email' => 'kdjsfd', 'phone' => '0341234567', 'notifications' => 2],
                ['id' => 3, 'name' => 'Client 3', 'email' => 'kdjsfd', 'phone' => '0341234567', 'notifications' => 9],
                ['id' => 4, 'name' => 'Client 4', 'email' => 'kdjsfd', 'phone' => '0341234567', 'notifications' => 3]
            ]
        ];
    
        Flight::render('templatedev', $data);
    }
    public function clientDetail(){
        $data = [
            'title' => 'Détail du client',
            'page' => 'report-client-admin',
            'client' => [
                'nom' => 'Client 1',
                'email' => 'jhdgf@mail.com',
                'telephone' => '0341234567',
                'date_inscription' => '2023-10-01',
                'reports' => [
                    [
                        'id' => 1,
                        'date' => '2023-10-01',
                        'statut' => 'en_cours',
                        'message' => 'Problème avec le service de livraison.'
                    ],
                    [
                        'id' => 2,
                        'date' => '2023-10-02',
                        'statut' => 'valide',
                        'message' => 'Demande de remboursement traitée avec succès.'
                    ],
                    [
                        'id' => 3,
                        'date' => '2023-10-03',
                        'statut' => 'refuse',
                        'message' => 'Réclamation injustifiée selon nos vérifications.'
                    ]
                ]
            ]
        ];
        Flight::render('templatedev', $data);
    }

    public function clientReportDetail(){
       // Données statiques de démonstration
        $demoReport = [
            'client' => [
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@email.com',
                'telephone' => '034 12 345 67'
            ],
            'date' => '2023-11-15',
            'statut' => 'en_cours',
            'message' => "Bonjour,\n\nJe souhaite signaler un problème avec ma dernière commande.\nLe produit reçu ne correspond pas à la description sur le site.\n\nCordialement,\nJean Dupont",
            'attachments' => [
                ['name' => 'photo_produit.jpg', 'url' => '#'],
                ['name' => 'facture.pdf', 'url' => '#'],
                ['name' => 'detail_commande.pdf', 'url' => '#']
            ]
        ];
        $data = [
            'title' => 'Détail du Report',
            'page' => 'form-ticket',
            'demoReport' => $demoReport
        ];
        Flight::render('templatedev', $data);
    }
    

  
 
}

