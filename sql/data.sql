-- Suppression des anciennes données
TRUNCATE TABLE Droit;
TRUNCATE TABLE Valeur;
TRUNCATE TABLE Type;
TRUNCATE TABLE Categorie;
TRUNCATE TABLE soldeInitial;
TRUNCATE TABLE Dept;

-- Insertion des départements
INSERT INTO Dept (nomDept, mdp) VALUES
('Finance', 'mdp123'),
('Ressources Humaines', 'mdp456'),
('Informatique', 'mdp789');

-- Insertion des relations entre départements
INSERT INTO Droit (idDeptPere, idDeptFils) VALUES
(1, 2),
(1, 3),
(2, 3);

-- Insertion des catégories (recette = 1, dépense = 0)
INSERT INTO Categorie (nomCategorie, recetteOuDepense) VALUES
('Salaire', 0),
('Matériel', 0),
('Ventes', 1),
('Investissement', 1);

-- Insertion des types liés aux catégories
INSERT INTO Type (idCategorie, nomType) VALUES
(1, 'Paiement mensuel'),
(2, 'Achat PC'),
(3, 'Vente de logiciels'),
(4, 'Actions en bourse');

-- Insertion des valeurs financières
INSERT INTO Valeur (nomRubrique, idType, idDept, previsionOuRealisation, montant, date, validation) VALUES
('Paiement Janvier', 1, 1, 1, 5000000.00, '2025-01-05', 1),
('Achat Ordinateurs', 2, 3, 0, 2000000.00, '2025-02-10', 0),
('Vente SaaS', 3, 3, 1, 8000000.00, '2025-03-15', 1),
('Investissement actions', 4, 1, 0, 3000000.00, '2025-04-20', 1);

-- Insertion des soldes initiaux
INSERT INTO soldeInitial (idDept, montant, dateInsertion) VALUES
(1, 10000000.00, '2025-01-01'),
(2, 5000000.00, '2025-01-01'),
(3, 7000000.00, '2025-01-01');
