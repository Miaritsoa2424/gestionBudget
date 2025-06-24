-- Désactiver les contraintes de clés étrangères temporairement
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE ticket_importance;
TRUNCATE TABLE importance;
TRUNCATE TABLE statut_ticket;
TRUNCATE TABLE mvt_duree;
TRUNCATE TABLE ticket;
TRUNCATE TABLE message;
TRUNCATE TABLE agent;
TRUNCATE TABLE report_client;
TRUNCATE TABLE statut;
TRUNCATE TABLE categorie_ticket;
TRUNCATE TABLE client;
TRUNCATE TABLE Crm;
TRUNCATE TABLE vente;
TRUNCATE TABLE produit;
TRUNCATE TABLE soldeInitial;
TRUNCATE TABLE Valeur;
TRUNCATE TABLE Type;
TRUNCATE TABLE Categorie;
TRUNCATE TABLE Droit;
TRUNCATE TABLE Dept;

SET FOREIGN_KEY_CHECKS = 1;