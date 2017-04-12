/* INSERT TEST */

INSERT INTO Cepage (nom, couleur) VALUES
	('sauvignon', 'blanc'),
	('pinot noir', 'rouge'),
	('gamay', 'rouge'),
	('muscadelle', 'blanc')
;

INSERT INTO Parcelle (cadastre, cepage, exist, exposition, type_sol, surface) VALUES 
	((12, 'AD', 300), 'sauvignon', true, 0.6, 'argileux', 12000.80),
	((12, 'AD', 301), 'gamay', true, 0.5, 'argileux', 12200.80),
	((12, 'AD', 302), 'muscadelle', true, 0.9, 'non argileux', 962.01),
	((12, 'AD', 303), 'muscadelle', true, 0.9, 'argileux', 962.01)
;

INSERT INTO Exploitation (annee, parcelle, gestion_sol, taille) VALUES
	(2017, (12, 'AD', 300), 'engrais', 'a la main'),
	(2016, (12, 'AD', 301), 'engrais', 'a la main'),
	(2016, (12, 'AD', 300), 'engrais', 'a la main'),
	(2015, (12, 'AD', 300), 'engrais', 'pas a la main'),
	(2014, (12, 'AD', 300), 'engrais', 'pas a la main'),
	(2015, (12, 'AD', 302), 'engrais', 'a la main'),
	(2014, (12, 'AD', 303), 'engrais', 'a la main')
;

INSERT INTO Vin (nom, annee, prix, quantite) VALUES
	('chateau lafite', 2015, 25.62, 10000),
	('chateau lafite', 2016, 25.62, 10000),
	('chateau lafite', 2017, 30.00, 11000),
	('chateau grand', 2017, 80.00, 100)
;

INSERT INTO Caracteristique (nom, vin_nom, vin_annee, note) VALUES
	('robe', 'chateau lafite', 2015, 15.5),
	('gout', 'chateau lafite', 2015, 15.5),
	('robe', 'chateau lafite', 2016, 18.5),
	('gout', 'chateau lafite', 2016, 18.5),
	('robe', 'chateau lafite', 2017, 19.5),
	('gout', 'chateau lafite', 2017, 18.5),
	('robe', 'chateau grand', 2017, 20.0),
	('gout', 'chateau grand', 2017, 20.0)
;

INSERT INTO Assemblage (vin_nom, vin_annee, exp_annee, exp_parcelle, pourcentage) VALUES 
	('chateau lafite', 2015, 2014, (12, 'AD', 300), 1.0),
	('chateau lafite', 2016, 2014, (12, 'AD', 300), 0.1),
	('chateau lafite', 2016, 2015, (12, 'AD', 300), 0.9),
	('chateau lafite', 2017, 2015, (12, 'AD', 302), 1.0),
	('chateau grand', 2017, 2016, (12, 'AD', 301), 0.2),
	('chateau grand', 2017, 2014, (12, 'AD', 303), 0.4),
	('chateau grand', 2017, 2015, (12, 'AD', 302), 0.4)
;

INSERT INTO ApplicationTraitement (date, traitement, exp_annee, exp_parcelle) VALUES 
	('2014-08-13', 'phyto1' , 2014, (12, 'AD', 300))
;

INSERT INTO EvenementClimatique (exp_annee, exp_parcelle, type, intensite, date) VALUES
	(2015, (12, 'AD', 302), 'grele', 3.89, '2015-02-12'),
	(2015, (12, 'AD', 300), 'grele', 3.14, '2015-02-12'),
	(2016, (12, 'AD', 301), 'orage', 3.37, '2016-10-26'),
	(2017, (12, 'AD', 300), 'grele', 1.2, '2017-02-12')
;
