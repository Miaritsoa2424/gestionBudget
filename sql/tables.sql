DROP DATABASE IF EXISTS gestion;
CREATE DATABASE IF NOT EXISTS gestion;

USE gestion;
-- Création des tables
CREATE TABLE Dept (
    idDept INT PRIMARY KEY AUTO_INCREMENT,
    nomDept VARCHAR(100) NOT NULL,
    mdp VARCHAR(255) NOT NULL
);

CREATE TABLE Droit (
    idDeptPere INT,
    idDeptFils INT,
    PRIMARY KEY (idDeptPere, idDeptFils),
    FOREIGN KEY (idDeptPere) REFERENCES Dept(idDept),
    FOREIGN KEY (idDeptFils) REFERENCES Dept(idDept)
);

SELECT de.idDept,de.nomDept FROM Dept as de JOIN Droit as dr on dr.idDeptFils = de.idDept WHERE idDeptPere = 2;

CREATE TABLE Categorie (
    idCategorie INT PRIMARY KEY AUTO_INCREMENT,
    nomCategorie VARCHAR(100) NOT NULL,
    recetteOuDepense TINYINT(1) NOT NULL CHECK (recetteOuDepense IN (0, 1))
);

CREATE TABLE Type (
    idType INT PRIMARY KEY AUTO_INCREMENT,
    idCategorie INT NOT NULL,
    nomType VARCHAR(100) NOT NULL,
    FOREIGN KEY (idCategorie) REFERENCES Categorie(idCategorie)
);

CREATE TABLE Valeur (
    idValeur INT PRIMARY KEY AUTO_INCREMENT,
    nomRubrique VARCHAR(100) NOT NULL,
    idType INT NOT NULL,
    idDept INT NOT NULL,
    previsionOuRealisation TINYINT(1) NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    date DATE NOT NULL,
    validation TINYINT(1) NOT NULL,
    FOREIGN KEY (idType) REFERENCES Type(idType),
    FOREIGN KEY (idDept) REFERENCES Dept(idDept)
);


CREATE TABLE soldeInitial (
    idSolde INT PRIMARY KEY AUTO_INCREMENT,
    idDept INT NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    dateInsertion DATE NOT NULL,
    FOREIGN KEY (idDept) REFERENCES Dept(idDept) ON DELETE CASCADE
);

CREATE TABLE produit (
    idProduit INT PRIMARY KEY AUTO_INCREMENT,
    nomProduit VARCHAR(100) NOT NULL,
    prix DECIMAL(15,2) NOT NULL,
    stock INT NOT NULL CHECK (stock >= 0)
);

CREATE TABLE client (
    idClient INT PRIMARY KEY AUTO_INCREMENT,
    nomClient VARCHAR(100) NOT NULL
);

CREATE TABLE vente (
    idVente INT PRIMARY KEY AUTO_INCREMENT,
    idProduit INT NOT NULL,
    idClient INT NOT NULL,
    dateVente DATE NOT NULL,
    quantite INT NOT NULL CHECK (quantite > 0),
    FOREIGN KEY (idProduit) REFERENCES produit(idProduit),
    FOREIGN KEY (idClient) REFERENCES client(idClient)
);

CREATE TABLE Crm(
    idCrm INT PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(500) NOT NULL
);

-- UPDATE 11-07-2025

CREATE TABLE Etat (
    idEtat INT PRIMARY KEY AUTO_INCREMENT,
    nom CHAR(50) NOT NULL
);

-- Table Importance
CREATE TABLE Importance (
    idImportance INT PRIMARY KEY AUTO_INCREMENT,
    nom CHAR(50) NOT NULL
);

-- Table TypeDemande
CREATE TABLE TypeDemande (
    idTypeDemande INT PRIMARY KEY AUTO_INCREMENT,
    nom CHAR(100) NOT NULL
);

-- Table Demande
CREATE TABLE Demande (
    idDemande INT PRIMARY KEY AUTO_INCREMENT,
    idClient INT NOT NULL,
    valideOuPas BOOLEAN NOT NULL,
    description VARCHAR(255),
    sujet VARCHAR(255),
    dateDemande DATE NOT NULL,
    FOREIGN KEY (idClient) REFERENCES client(idClient)
);

-- Table Ticket
CREATE TABLE Ticket (
    idTicket INT PRIMARY KEY AUTO_INCREMENT,
    idDemande INT NOT NULL,
    idImportance INT NOT NULL,
    idTypeDemande INT NOT NULL,
    idEtat INT NOT NULL,
    idDept INT NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE DEFAULT NULL,
    FOREIGN KEY (idDept) REFERENCES Dept(idDept),
    FOREIGN KEY (idTypeDemande) REFERENCES TypeDemande(idTypeDemande),
    FOREIGN KEY (idDemande) REFERENCES Demande(idDemande),
    FOREIGN KEY (idImportance) REFERENCES Importance(idImportance),
    FOREIGN KEY (idEtat) REFERENCES Etat(idEtat)
);

CREATE VIEW Vue_TicketsComplets AS
SELECT
    t.idTicket,
    t.dateDebut,
    t.dateFin,
    
    -- Données du Ticket
    t.idDept,
    
    -- Données de la Demande liée
    d.idDemande,
    d.idClient,
    d.valideOuPas,
    d.description,
    d.sujet,
    d.dateDemande,
    
    -- Données de l'État
    e.idEtat,
    e.nom AS nomEtat,
    
    -- Données de l'Importance
    i.idImportance,
    i.nom AS nomImportance,
    
    -- Données du Type de Demande
    td.idTypeDemande,
    td.nom AS nomTypeDemande
    
FROM Ticket t
JOIN Demande d ON t.idDemande = d.idDemande
JOIN Etat e ON t.idEtat = e.idEtat
JOIN Importance i ON t.idImportance = i.idImportance
JOIN TypeDemande td ON t.idTypeDemande = td.idTypeDemande;

