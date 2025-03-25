
-- Insertion de données de test
INSERT INTO Dept (nomDept, mdp) VALUES 
('Finance', 'mdp123'),
('Ressources Humaines', 'mdp456'),
('Informatique', 'mdp789');

INSERT INTO Droit (idDeptPere, idDeptFils) VALUES 
(1, 2),
(1, 3),
(2, 3);

INSERT INTO Categorie (nomCategorie, recetteOuDepense) VALUES 
('Salaires', 0),
('Achats', 0),
('Ventes', 1);

INSERT INTO Type (idCategorie, nomType) VALUES 
(1, 'Rémunération'),
(2, 'Fournitures'),
(3, 'Produits vendus');

INSERT INTO Valeur (nomRubrique, idType, previsionOuRealisation, montant, date, validation) VALUES 
('Paiement des salaires', 1, 1, 5000000, '2025-03-01', TRUE),
('Achat de papier', 2, 0, 150000, '2025-03-05', FALSE),
('Vente de produits', 3, 1, 7000000, '2025-03-10', TRUE);
