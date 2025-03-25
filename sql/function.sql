-- calcul des benefice pour un departement entre la date d'insertion et une date donnée
DELIMITER //

CREATE FUNCTION calculBenefice(p_dateDebut DATE, p_idDept INT)
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    DECLARE v_dateInitial DATE;
    DECLARE v_benefice DECIMAL(15,2);

    -- Récupérer la date d'insertion initiale pour le département
    SELECT dateInsertion INTO v_dateInitial
    FROM soldeInitial
    WHERE idDept = p_idDept
    LIMIT 1;
    
    IF v_dateInitial IS NULL THEN
        RETURN 0;
    END IF;
    
    -- Calculer le bénéfice en prenant seulement les réalisations validées
    SELECT 
        IFNULL(SUM(CASE WHEN c.recetteOuDepense = 1 THEN v.montant ELSE 0 END), 0)
      - IFNULL(SUM(CASE WHEN c.recetteOuDepense = 0 THEN v.montant ELSE 0 END), 0)
    INTO v_benefice
    FROM Valeur v
    JOIN Type t ON v.idType = t.idType
    JOIN Categorie c ON t.idCategorie = c.idCategorie
    WHERE v.idDept = p_idDept
      AND v.validation = 1
      AND v.previsionOuRealisation = 1  -- Ne prendre que les réalisations
      AND v.date BETWEEN v_dateInitial AND p_dateDebut;
    
    RETURN v_benefice;
END; //

DELIMITER ;

SELECT calculBenefice('2025-04-30', 1) AS beneficeDept1;

-- getSoldeActuelle pour un departement
DELIMITER //

CREATE or REPLACE FUNCTION getSoldeActuelle(dateDebut DATE, idDept INT) 
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    DECLARE soldeActuel DECIMAL(15,2);

    -- Calcul du bénéfice en utilisant la fonction getBenefice existante
    SET soldeActuel = calculBenefice(dateDebut, idDept);

    -- Ajouter ce bénéfice au solde initial du département
    SET soldeActuel = soldeActuel + (
        SELECT COALESCE(SUM(s.montant), 0) 
        FROM soldeInitial s 
        WHERE s.idDept = idDept AND s.dateInsertion <= dateDebut
    );

    -- Retourner le solde actuel
    RETURN soldeActuel;
END //

DELIMITER ;

SELECT getSoldeActuelle('2025-04-30', 1) AS soldeActuelDept1;


-- getBenefice pour un departement entre deux dates
DELIMITER //

CREATE FUNCTION getBenefice(p_dateDebut DATE, p_dateFin DATE, p_idDept INT)
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    DECLARE v_benefice DECIMAL(15,2);

    -- Calculer le bénéfice en prenant seulement les réalisations validées
    SELECT 
        IFNULL(SUM(CASE WHEN c.recetteOuDepense = 1 THEN v.montant ELSE 0 END), 0)
      - IFNULL(SUM(CASE WHEN c.recetteOuDepense = 0 THEN v.montant ELSE 0 END), 0)
    INTO v_benefice
    FROM Valeur v
    JOIN Type t ON v.idType = t.idType
    JOIN Categorie c ON t.idCategorie = c.idCategorie
    WHERE v.idDept = p_idDept
      AND v.validation = 1
      AND v.previsionOuRealisation = 1  -- Ne prendre que les réalisations
      AND v.date BETWEEN p_dateDebut AND p_dateFin;

    RETURN v_benefice;
END //

DELIMITER ;

-- getSoldeActuelle pour un departement
DELIMITER //

CREATE FUNCTION getSolde(p_dateDebut DATE, p_dateFin DATE, p_idDept INT)
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    DECLARE soldeActuel DECIMAL(15,2);

    -- Calcul du solde actuel à partir de la fonction getSoldeActuelle
    SET soldeActuel = getSoldeActuelle(p_dateDebut, p_idDept);

    -- Ajouter le bénéfice pour la période de p_dateDebut à p_dateFin
    SET soldeActuel = soldeActuel + getBenefice(p_dateDebut, p_dateFin, p_idDept);

    -- Retourner le solde final
    RETURN soldeActuel;
END //

DELIMITER ;

SELECT getSolde('2025-04-01', '2025-04-30', 1) AS soldeDept1;


-- get donnee pour budget

DELIMITER //

CREATE FUNCTION getData(dateDebut DATE, dateFin DATE, idDept INT)
RETURNS TABLE
BEGIN
    RETURN
    ( 
        SELECT 
            CASE 
                WHEN c.recetteOuDepense = 0 THEN 'Recette'
                WHEN c.recetteOuDepense = 1 THEN 'Dépense'
            END AS rubrique,
            -- Somme des prévisions pour les recettes et dépenses
            SUM(CASE WHEN v.previsionOuRealisation = 0 AND c.recetteOuDepense = 0 THEN v.montant ELSE 0 END) AS montantPrevisionRecette,
            SUM(CASE WHEN v.previsionOuRealisation = 0 AND c.recetteOuDepense = 1 THEN v.montant ELSE 0 END) AS montantPrevisionDepense,
            -- Somme des réalisations pour les recettes et dépenses
            SUM(CASE WHEN v.previsionOuRealisation = 1 AND c.recetteOuDepense = 0 THEN v.montant ELSE 0 END) AS montantRealisationRecette,
            SUM(CASE WHEN v.previsionOuRealisation = 1 AND c.recetteOuDepense = 1 THEN v.montant ELSE 0 END) AS montantRealisationDepense,
            -- Calcul de l'écart pour les recettes et dépenses
            SUM(CASE WHEN v.previsionOuRealisation = 0 AND c.recetteOuDepense = 0 THEN v.montant ELSE 0 END) - 
            SUM(CASE WHEN v.previsionOuRealisation = 1 AND c.recetteOuDepense = 0 THEN v.montant ELSE 0 END) AS ecartRecette,
            SUM(CASE WHEN v.previsionOuRealisation = 0 AND c.recetteOuDepense = 1 THEN v.montant ELSE 0 END) - 
            SUM(CASE WHEN v.previsionOuRealisation = 1 AND c.recetteOuDepense = 1 THEN v.montant ELSE 0 END) AS ecartDepense
        FROM 
            Valeur v
            JOIN Type t ON v.idType = t.idType
            JOIN Categorie c ON t.idCategorie = c.idCategorie
        WHERE 
            v.idDept = idDept
            AND v.date BETWEEN dateDebut AND dateFin
        GROUP BY 
            c.recetteOuDepense
    );
END //

DELIMITER ;
