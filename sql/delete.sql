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


-- AGENTS
INSERT INTO agent (nom, prenom, email, password) VALUES
('Durand', 'Paul', 'paul.durand@email.com', 'agent123'),
('Leroy', 'Sophie', 'sophie.leroy@email.com', 'agent456'),
('Martin', 'Luc', 'luc.martin@email.com', 'agent789'),
('Bernard', 'Julie', 'julie.bernard@email.com', 'agent321'),
('Petit', 'Marc', 'marc.petit@email.com', 'agent654');

-- TICKETS
INSERT INTO ticket (cout_horaire, sujet, id_categorie, id_agent, id_report, id_statut, date_creation) VALUES
(50.00, 'Connexion impossible', 1, 1, 1, 1, '2025-06-22 10:15:00'),
(60.00, 'Demande de devis', 2, 2, 2, 2, '2025-06-21 09:45:00'),
(55.00, 'Erreur système', 1, 1, 1, 1, '2025-06-23 11:00:00'),
(70.00, 'Problème facture', 2, 2, 2, 2, '2025-06-24 12:00:00'),
(65.00, 'Bug application', 1, 1, 1, 1, '2025-06-25 13:00:00'),
(80.00, 'Demande info', 2, 3, 2, 2, '2025-06-26 14:00:00');