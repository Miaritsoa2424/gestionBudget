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

CREATE TABLE client(
   id_client INT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   email VARCHAR(50),
   password VARCHAR(50),
   PRIMARY KEY(id_client)
);

CREATE TABLE categorie_ticket(
   id_categorie INT,
   nom VARCHAR(50),
   PRIMARY KEY(id_categorie)
);

CREATE TABLE statut(
   id_status INT,
   nom VARCHAR(50),
   PRIMARY KEY(id_status)
);

CREATE TABLE report_client(
   id_report INT,
   libelle VARCHAR(100),
   piece_jointe VARCHAR(250),
   date_report DATETIME,
   note INT,
   date_note DATE,
   commentaire VARCHAR(1000),
   id_client INT NOT NULL,
   PRIMARY KEY(id_report),
   FOREIGN KEY(id_client) REFERENCES client(id_client)
);

CREATE TABLE agent(
   id_agent INT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   email VARCHAR(50),
   password VARCHAR(50),
   PRIMARY KEY(id_agent)
);

CREATE TABLE message(
   id_message INT,
   id_envoyeur INT,
   id_receveur INT,
   client_agent BOOLEAN,
   date_heure DATETIME NOT NULL,
   PRIMARY KEY(id_message)
);

CREATE TABLE ticket(
   id_ticket INT,
   cout_horaire DECIMAL(15,2),
   sujet VARCHAR(250),
   id_categorie INT NOT NULL,
   id_agent INT NOT NULL,
   id_report INT NOT NULL,
   PRIMARY KEY(id_ticket),
   FOREIGN KEY(id_categorie) REFERENCES categorie_ticket(id_categorie),
   FOREIGN KEY(id_agent) REFERENCES agent(id_agent),
   FOREIGN KEY(id_report) REFERENCES report_client(id_report)
);

CREATE TABLE mvt_duree(
   id_mvt_duree INT,
   duree SMALLINT,
   date_duree DATE,
   id_ticket INT NOT NULL,
   PRIMARY KEY(id_mvt_duree),
   FOREIGN KEY(id_ticket) REFERENCES ticket(id_ticket)
);

CREATE TABLE statut_ticket(
   id_ticket INT,
   id_status INT,
   date_status DATE,
   PRIMARY KEY(id_ticket, id_status),
   FOREIGN KEY(id_ticket) REFERENCES ticket(id_ticket),
   FOREIGN KEY(id_status) REFERENCES statut(id_status)
);