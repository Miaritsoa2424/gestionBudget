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
('Entretien', 0); -- Dépense

-- Insertion de types associés à chaque catégorie
INSERT INTO Type (idCategorie, nomType) VALUES 
(1, 'Rémunération'),      -- Type pour "Salaires"
(2, 'Fournitures'),       -- Type pour "Achats"
(3, 'Produits vendus'),   -- Type pour "Ventes"
(4, 'Campagnes pub'),     -- Type pour "Publicité"
(5, 'Achat matériel'),    -- Type pour "Investissements"
(6, 'Maintenance');       -- Type pour "Entretien"

-- Insertion des valeurs (prévisions et réalisations) pour chaque mois et année
-- Département Finance (prévisions et réalisations pour mars 2025)
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
('Paiement des salaires', 1, 1, 1, 5000000, '2025-03-01', 1),   -- Réalisation pour "Paiement des salaires"
('Achat de fournitures', 2, 1, 0, 150000, '2025-03-02', 0),    -- Prévision pour "Achat de fournitures"
('Investissements en équipements', 5, 1, 0, 2000000, '2025-03-03', 0),  -- Prévision pour "Investissements"
('Recette de vente de services', 3, 1, 1, 8000000, '2025-03-05', 1);  -- Réalisation pour "Recette de vente de services"

-- Département Ressources Humaines (prévisions et réalisations pour mars 2025)
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
('Salaire employés', 1, 2, 1, 4000000, '2025-03-01', 1),  -- Réalisation pour "Salaire employés"
('Achat de fournitures de bureau', 2, 2, 0, 100000, '2025-03-04', 0),  -- Prévision pour "Achat de fournitures"
('Recette de formation', 3, 2, 1, 2000000, '2025-03-08', 1);  -- Réalisation pour "Recette de formation"

-- Département Informatique (prévisions et réalisations pour mars 2025)
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
('Salaire du personnel informatique', 1, 3, 1, 6000000, '2025-03-01', 1),  -- Réalisation pour "Salaire du personnel"
('Achat de matériel informatique', 2, 3, 0, 1200000, '2025-03-02', 0),  -- Prévision pour "Achat de matériel"
('Recette vente de logiciels', 3, 3, 1, 5000000, '2025-03-07', 1);  -- Réalisation pour "Recette vente de logiciels"

-- Département Marketing (prévisions et réalisations pour mars 2025)
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
('Publicité sur réseaux sociaux', 4, 4, 0, 300000, '2025-03-05', 0),  -- Prévision pour "Publicité sur réseaux sociaux"
('Recette publicité en ligne', 3, 4, 1, 2000000, '2025-03-10', 1);  -- Réalisation pour "Recette publicité en ligne"

-- Département Logistique (prévisions et réalisations pour mars 2025)
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES 
('Investissement en matériel logistique', 5, 5, 0, 1000000, '2025-03-02', 0),  -- Prévision pour "Investissement en matériel logistique"
('Entretien des équipements', 6, 5, 0, 500000, '2025-03-06', 0),  -- Prévision pour "Entretien des équipements"
('Recette livraison de produits', 3, 5, 1, 4000000, '2025-03-10', 1);  -- Réalisation pour "Recette livraison de produits"

-- Insertion des soldes initiaux pour les départements
INSERT INTO soldeInitial (idDept, montant, dateInsertion) VALUES
(1, 1000000.00, '2025-01-01'),  -- Solde initial pour le département Finance
(2, 500000.00, '2025-01-01'),   -- Solde initial pour le département Ressources Humaines
(3, 1500000.00, '2025-01-01');  -- Solde initial pour le département Informatique

