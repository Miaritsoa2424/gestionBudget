-- Insertion de départements
INSERT INTO Dept (nomDept, mdp) VALUES 
('Finance', 'mdp123'),
('Ressources Humaines', 'mdp456'),
('Informatique', 'mdp789'),
('Marketing', 'mdp101'),
('Logistique', 'mdp102');

-- Insertion des relations de droits entre départements
INSERT INTO Droit (idDeptPere, idDeptFils) VALUES 
(1, 2),  -- Finance peut accéder à Ressources Humaines
(1, 3),  -- Finance peut accéder à Informatique
(1, 4),  -- Finance peut accéder à Marketing
(1, 5),  -- Finance peut accéder à Logistique
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);  -- Finance peut accéder à Logistique
  -- Finance peut accéder à Logistique
  -- Finance peut accéder à Logistique
  -- Finance peut accéder à Logistique
  -- Finance peut accéder à Logistique

-- (2, 3),  -- Ressources Humaines peut accéder à Informatique
-- (2, 4),  -- Ressources Humaines peut accéder à Marketing
-- (3, 5);  -- Informatique peut accéder à Logistique


-- Insertion de catégories (recettes et dépenses)
INSERT INTO Categorie (nomCategorie, recetteOuDepense) VALUES 
('Salaires', 0),  -- Dépense
('Achats', 0),    -- Dépense
('Ventes', 1),    -- Recette
('Publicité', 1), -- Recette
('Investissements', 0),  -- Dépense
('Entretien', 0), -- Dépense
('CRM', 0);  -- Dépense

-- Insertion de types associés à chaque catégorie
INSERT INTO Type (idCategorie, nomType) VALUES 
(1, 'Rémunération'),      -- Type pour "Salaires"
(2, 'Fournitures'),       -- Type pour "Achats"
(3, 'Produits vendus'),   -- Type pour "Ventes"
(4, 'Campagnes pub'),     -- Type pour "Publicité"
(5, 'Achat matériel'),    -- Type pour "Investissements"
(6, 'Maintenance'),       -- Type pour "Entretien"
(7,'Reaction CRM');  -- Dépense

-- Département Finance
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
-- Paiement des salaires
('Paiement des salaires', 1, 1, 0, 5200000, '2025-03-01', 0),  -- Prévision
('Paiement des salaires', 1, 1, 1, 5000000, '2025-03-01', 1),  -- Réalisation

-- Achat de fournitures
('Achat de fournitures', 2, 1, 0, 150000, '2025-03-02', 0),    -- Prévision
('Achat de fournitures', 2, 1, 1, 130000, '2025-03-03', 1),    -- Réalisation

-- Investissements en équipements
('Investissements en équipements', 5, 1, 0, 2000000, '2025-03-03', 0),  -- Prévision
('Investissements en équipements', 5, 1, 1, 1800000, '2025-03-10', 1),  -- Réalisation

-- Recette de vente de services
('Recette de vente de services', 3, 1, 0, 8500000, '2025-03-04', 0),  -- Prévision
('Recette de vente de services', 3, 1, 1, 8000000, '2025-03-05', 1);  -- Réalisation

-- Département Ressources Humaines
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
-- Salaire employés
('Salaire employés', 1, 2, 0, 4200000, '2025-03-01', 0),  -- Prévision
('Salaire employés', 1, 2, 1, 4000000, '2025-03-01', 1),  -- Réalisation

-- Achat de fournitures de bureau
('Achat de fournitures de bureau', 2, 2, 0, 100000, '2025-03-04', 0),  -- Prévision
('Achat de fournitures de bureau', 2, 2, 1, 95000, '2025-03-06', 1),   -- Réalisation

-- Recette de formation
('Recette de formation', 3, 2, 0, 2100000, '2025-03-07', 0),  -- Prévision
('Recette de formation', 3, 2, 1, 2000000, '2025-03-08', 1);  -- Réalisation

-- Département Informatique
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
-- Salaire du personnel informatique
('Salaire du personnel informatique', 1, 3, 0, 6100000, '2025-03-01', 0),  -- Prévision
('Salaire du personnel informatique', 1, 3, 1, 6000000, '2025-03-01', 1),  -- Réalisation

-- Achat de matériel informatique
('Achat de matériel informatique', 2, 3, 0, 1200000, '2025-03-02', 0),  -- Prévision
('Achat de matériel informatique', 2, 3, 1, 1150000, '2025-03-05', 1),  -- Réalisation

-- Recette vente de logiciels
('Recette vente de logiciels', 3, 3, 0, 5500000, '2025-03-06', 0),  -- Prévision
('Recette vente de logiciels', 3, 3, 1, 5000000, '2025-03-07', 1);  -- Réalisation

-- Département Marketing
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
-- Publicité sur réseaux sociaux
('Publicité sur réseaux sociaux', 4, 4, 0, 300000, '2025-03-05', 0),  -- Prévision
('Publicité sur réseaux sociaux', 4, 4, 1, 280000, '2025-03-08', 1),  -- Réalisation

-- Recette publicité en ligne
('Recette publicité en ligne', 3, 4, 0, 2100000, '2025-03-09', 0),  -- Prévision
('Recette publicité en ligne', 3, 4, 1, 2000000, '2025-03-10', 1);  -- Réalisation

-- Département Logistique
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
-- Investissement en matériel logistique
('Investissement en matériel logistique', 5, 5, 0, 1000000, '2025-03-02', 0),  -- Prévision
('Investissement en matériel logistique', 5, 5, 1, 950000, '2025-03-09', 1),  -- Réalisation

-- Entretien des équipements
('Entretien des équipements', 6, 5, 0, 500000, '2025-03-06', 0),  -- Prévision
('Entretien des équipements', 6, 5, 1, 480000, '2025-03-08', 1),  -- Réalisation

-- Recette livraison de produits
('Recette livraison de produits', 3, 5, 0, 4200000, '2025-03-09', 0),  -- Prévision
('Recette livraison de produits', 3, 5, 1, 4000000, '2025-03-10', 1);  -- Réalisation

-- Insertion des soldes initiaux pour les départements
INSERT INTO soldeInitial (idDept, montant, dateInsertion) VALUES
(1, 1000000.00, '2025-01-01'),  -- Solde initial pour le département Finance
(2, 500000.00, '2025-01-01'),   -- Solde initial pour le département Ressources Humaines
(3, 1500000.00, '2025-01-01');  -- Solde initial pour le département Informatique

INSERT INTO produit (nomProduit, prix, stock) VALUES
('Ballon de football', 25000.00, 50),
('Raquette de tennis', 85000.00, 20),
('Tapis de yoga', 30000.00, 40),
('Haltères 10kg', 40000.00, 30),
('Chaussures de course', 120000.00, 25),
('Gants de boxe', 45000.00, 15),
('Casque de vélo', 60000.00, 10),
('Maillot de sport', 20000.00, 60),
('Sac de sport', 35000.00, 35),
('Filet de volley', 50000.00, 12);


-- INSERT INTO vente (idProduit, idClient, dateVente, quantite) VALUES
-- (1, 1, '2025-04-01', 2),
-- (3, 2, '2025-04-02', 1),
-- (5, 3, '2025-04-05', 1),
-- (4, 1, '2025-04-06', 2),
-- (2, 4, '2025-04-07', 1),
-- (6, 5, '2025-04-08', 1),
-- (7, 6, '2025-04-09', 1),
-- (8, 2, '2025-04-10', 3),
-- (9, 7, '2025-04-11', 2),
-- (10, 8, '2025-04-12', 1);

INSERT INTO Crm (label) VALUES
('Email de bienvenue avec reduction Popup de chat en direct'),
('Campagne Google Ads Facebook ciblee Partenariat avec des influenceurs'),
('Sondages questions interactives Codes promo reserves aux followers'),
('Retargeting sur reseaux sociaux Placement produit en magasin lie a la pub'),
('Video comparative Essai gratuit echantillon'),
('Paiement en 3x sans frais Notification push Votre panier expire'),
('Flyers avec QR code vers offre offline Evenement eclair degustation demo'),
('Questionnaire post evenement Goodies avec lien vers site'),
('Email recap avec fiche produit Envoi dechantillon gratuit'),
('Envoyer un parcours personnalise Preparez vous a levenement Offrir un diagnostic materiel gratuit sur place'),
('Envoyer une notification geolocalisee avec un code vitrine exclusive Afficher un QR code pour scanner les avis clients'),
('Lui proposer un contenu expert ex 5 erreurs a eviter avec vos crampons Inviter a un live QA avec un pro'),
('Envoyer les creneaux de forte affluence a eviter Proposer un rendez vous en magasin avec un expert'),
('Faire apparaitre une annonce Google avec un guide dachat localise Proposer un essai en partenariat avec un club local'),
('Envoyer un programme de parrainage avec recompenses ex equipement offert Offrir un duo de places pour un match partenaire'),
('Debloquer un badge Nouveau membre avec avantage immediat Proposer un jeu concours pour gagner un coaching'),
('Envoyer des recommandations personnalisees par sport Programmer un rappel pour essai en magasin'),
('Envoyer un message prive avec une demo exclusive Proposer un essai du produit en boutique avec cadeau'),
('Activer une alerte Stock faible Envoyer un tutoriel dutilisation du produit'),
('Envoyer un itineraire personnalise Declencher une offre Passage en magasin ex 15 pourcent'),
('Proposer des tarifs groupe Offrir un audit gratuit du materiel de lequipe'),
('Debloquer des avis clients verifies Proposer une reduction immediate sur le produit scanne'),
('Envoyer un guide sportif saisonnier ex Preparer la saison de volley Donner acces a des ventes privees'),
('Proposer une version longue avec un expert Inviter a une session de test en reel'),
('Repondre personnellement avec une offre de remerciement Inviter a tester les nouveautes en avant premiere'),
('Preparer une surprise en magasin cadeau decoration Offrir un credit valable 1 semaine'),
('Mettre en place un parcours de decouverte de la marque Programmer un appel de suivi meme sans gain'),
('Lui envoyer un role Ambassadeur avec missions Organiser des meetups sportifs prives'),
('Envoyer une fiche produit enrichie video avis Proposer un comparatif en temps reel avec dautres modeles');



-- CLIENTS
INSERT INTO client (id_client, nom, prenom, email, password) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@email.com', 'pass123'),
(2, 'Martin', 'Claire', 'claire.martin@email.com', 'pass456');

-- CATEGORIES DE TICKET
INSERT INTO categorie_ticket (id_categorie, nom) VALUES
(1, 'Technique'),
(2, 'Commercial');

-- STATUTS
INSERT INTO statut (id_statut, nom) VALUES
(1, 'Ouvert'),
(2, 'En cours'),
(3, 'Fermé');

-- AGENTS
INSERT INTO agent (id_agent, nom, prenom, email, password) VALUES
(1, 'Durand', 'Paul', 'paul.durand@email.com', 'agent123'),
(2, 'Leroy', 'Sophie', 'sophie.leroy@email.com', 'agent456');


-- INSERT INTO report_client (id_report, libelle, piece_jointe, date_report, note, date_note, commentaire, id_client, statut) VALUES
-- (1, 'Problème de connexion', 'screenshot1.png', '2025-06-22 10:00:00', 4, '2025-06-22', 'Connexion impossible ce matin.', 1, 1),
-- (2, 'Demande de devis', NULL, '2025-06-21 09:30:00', 5, '2025-06-21', 'Merci pour la rapidité.', 2, 0);



-- TICKETS (avec id_statut et date_creation)
-- INSERT INTO ticket (id_ticket, cout_horaire, sujet, id_categorie, id_agent, id_report, id_statut, date_creation) VALUES
-- (1, 50.00, 'Connexion impossible', 1, 1, 1, 1, '2025-06-22 10:15:00'),
-- (2, 60.00, 'Demande de devis', 2, 2, 2, 2, '2025-06-21 09:45:00');

-- MOUVEMENTS DE DUREE
-- INSERT INTO mvt_duree (id_mvt_duree, duree, date_duree, id_ticket) VALUES
-- (1, 30, '2025-06-22', 1),
-- (2, 45, '2025-06-21', 2);

-- -- STATUTS DES TICKETS
-- INSERT INTO statut_ticket (id_ticket, id_statut, date_statut) VALUES
-- (1, 1, '2025-06-22'),
-- (1, 2, '2025-06-22'),
-- (2, 1, '2025-06-21'),
-- (2, 3, '2025-06-22');


-- -- TICKET_IMPORTANCE
-- INSERT INTO ticket_importance (id, id_ticket, id_importance) VALUES
-- (1, 1, 1),
-- (2, 2, 2);

-- MESSAGES (avec contenu)
-- INSERT INTO message (id_message, id_envoyeur, id_receveur, client_agent, date_heure, contenu) VALUES
-- (1, 1, 1, TRUE, '2025-06-22 10:05:00', 'Bonjour, j-ai un problème de connexion.'),
-- (2, 2, 1, FALSE, '2025-06-22 10:10:00', 'Merci pour votre retour rapide.');

INSERT INTO importance (libelle) VALUES 
('Très faible'),
('Faible'),
('Moyenne'),
('Élevée'),
('Critique');

INSERT INTO Dept (nomDept, mdp) VALUES 
('Commercial', 'mdp123');

INSERT INTO Categorie (nomCategorie, recetteOuDepense) VALUES 
('Commerciale', 0);  -- Dépense

INSERT INTO Type (idCategorie, nomType) VALUES 
(8, 'Tickets');

INSERT INTO soldeInitial (idDept, montant, dateInsertion) VALUES
(6, 1000000.00, '2025-01-01'); -- Solde initial pour le département Finance


INSERT INTO Droit (idDeptPere, idDeptFils) VALUES (
  6,6
),(1,6)
;




