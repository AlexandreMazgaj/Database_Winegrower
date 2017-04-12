DROP SCHEMA ExpViticole CASCADE; /*Nous permet de créer la base de données, même si le nettoyage_BDD.sql n'a pas été exécuté*/

CREATE SCHEMA ExpViticole;
SET search_path TO ExpViticole;

CREATE DOMAIN dANNEE AS INT CHECK (VALUE > 0);

CREATE TYPE dCADASTRE AS (
    prefixe INT,    
    section VARCHAR,
    num INT
);


CREATE TABLE Cepage (
    nom VARCHAR PRIMARY KEY,
    couleur VARCHAR
);

CREATE TABLE Parcelle (
    cadastre dCADASTRE PRIMARY KEY,
    cepage VARCHAR REFERENCES Cepage(nom),
    exist BOOLEAN,
    exposition DECIMAL(2, 2) CHECK (exposition BETWEEN 0 AND 1),
    type_sol VARCHAR,
    surface DECIMAL(10, 2) CHECK (surface > 0)
);

CREATE TABLE Exploitation (
    annee dANNEE,
    parcelle dCADASTRE REFERENCES Parcelle(cadastre),
    gestion_sol VARCHAR,
    taille VARCHAR,
    PRIMARY KEY (annee, parcelle)
);

CREATE TABLE Vin (
    nom VARCHAR,
    annee dANNEE,
    prix DECIMAL(10, 2) CHECK(prix > 0),
    quantite INT,
    PRIMARY KEY (nom, annee)
);


CREATE TABLE Assemblage (
    vin_nom VARCHAR,
    vin_annee dAnnee,
    exp_annee dAnnee,
    exp_parcelle dCADASTRE,
    pourcentage DECIMAL(3, 2) CHECK (pourcentage > 0 AND pourcentage <= 1),
    FOREIGN KEY (exp_annee, exp_parcelle) REFERENCES Exploitation(annee, parcelle),
    FOREIGN KEY (vin_nom, vin_annee) REFERENCES Vin (nom, annee),
    PRIMARY KEY (vin_nom, vin_annee, exp_annee, exp_parcelle)
);

CREATE FUNCTION check_assemblage() RETURNS BOOLEAN AS $check_assemblage$ 
BEGIN
	RETURN (SELECT COUNT(*)
		FROM (SELECT (SUM(pourcentage) = 1) AS valide
				FROM Assemblage 
				GROUP BY (vin_nom, vin_annee)
				) AS AssamblageVin
		WHERE valide = FALSE) = 0;
END;
$check_assemblage$ LANGUAGE plpgsql;

CREATE FUNCTION trigger_assemblage() RETURNS TRIGGER AS $trigger_assemblage$
BEGIN
	IF NOT check_assemblage() THEN
		RAISE EXCEPTION 'objection !! (La somme des pourcentage est différente de 100%)';
		ROLLBACK TRANSACTION;
	END IF;
	RETURN NEW;
END;
$trigger_assemblage$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_assemblage AFTER INSERT OR UPDATE OR DELETE
    ON Assemblage
    FOR EACH STATEMENT
    EXECUTE PROCEDURE trigger_assemblage();


CREATE TABLE ApplicationTraitement (
    date DATE,
    traitement VARCHAR,
    exp_annee dANNEE,
    exp_parcelle dCADASTRE,
    FOREIGN KEY (exp_annee, exp_parcelle) REFERENCES Exploitation(annee, parcelle),
    PRIMARY KEY (date, traitement, exp_annee, exp_parcelle),
    CHECK(date_part('year', date) = exp_annee)
);

CREATE TABLE EvenementClimatique (
    exp_annee dANNEE,
    exp_parcelle dCADASTRE,
    type VARCHAR,
    intensite DECIMAL (4, 2) CHECK (intensite >= 0 AND intensite <=10),
    date DATE,
    FOREIGN KEY (exp_annee, exp_parcelle) REFERENCES Exploitation(annee,parcelle),
    PRIMARY KEY (exp_annee, exp_parcelle, type, date),
    CHECK(date_part('year', date) = exp_annee)
);

CREATE TABLE Caracteristique (
    nom VARCHAR,
    vin_nom VARCHAR,
    vin_annee dANNEE,
    note DECIMAL (4, 2) CHECK (note>=0 AND note<=20),
    FOREIGN KEY (vin_nom, vin_annee) REFERENCES Vin (nom, annee),
    PRIMARY KEY (nom, vin_nom, vin_annee)
);


SET search_path TO public, ExpViticole;
