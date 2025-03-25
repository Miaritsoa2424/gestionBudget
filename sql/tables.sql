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
    previsionOuRealisation TINYINT(1) NOT NULL CHECK (previsionOuRealisation IN (0, 1)),
    montant DECIMAL(15,2) NOT NULL,
    date DATE NOT NULL,
    validation BOOLEAN NOT NULL,
    FOREIGN KEY (idDept) REFERENCES Dept(idDept),
    FOREIGN KEY (idType) REFERENCES Type(idType)
);

CREATE TABLE soldeInitial (
    idSolde INT PRIMARY KEY AUTO_INCREMENT,
    idDept INT NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    dateInsertion DATE NOT NULL,
    FOREIGN KEY (idDept) REFERENCES Dept(idDept)
);

