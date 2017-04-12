/* Sélection de l'intégralité des parcelles */
SELECT * FROM Parcelle;

/* Sélection de l'intégralité des parcelles où le sol est argilleux */
SELECT * 
	FROM Parcelle
	WHERE type_sol = 'argileux'
;

/* Sélection de l'intégralité des caractéristiques de type 'robe' */
SELECT * FROM Caracteristique WHERE (nom = 'robe');

/* Info sur les cépages utilisés pour le 'chateau lafite' de 2016 */
SELECT * 
	FROM Cepage
	WHERE nom IN (SELECT Parcelle.cepage 
		FROM Parcelle
			INNER JOIN Exploitation ON Exploitation.parcelle = Parcelle.cadastre
			INNER JOIN Assemblage ON Assemblage.exp_annee = Exploitation.annee AND Assemblage.exp_parcelle = Exploitation.parcelle
			INNER JOIN Vin ON Vin.annee = Assemblage.vin_annee AND Vin.nom = Assemblage.vin_nom
		WHERE Vin.nom = 'chateau lafite' AND Vin.annee = 2016
	)
;

/* Info sur les vins dont les parcelles ont été touchées par de la grêle pendant le premier trimestre 2015 */
SELECT * 
	FROM Vin
	WHERE (nom, annee) IN (SELECT Assemblage.vin_nom, Assemblage.vin_annee
		FROM Assemblage
			INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
			INNER JOIN EvenementClimatique ON EvenementClimatique.exp_annee = Exploitation.annee AND EvenementClimatique.exp_parcelle = Exploitation.parcelle
		WHERE EvenementClimatique.type = 'grele' AND EvenementClimatique.date >= '2015-01-01' AND EvenementClimatique.date < '2015-04-01'
	)
;

/* Question : comment, pour un vin, les modes de culture (gestion du sol, taille) appliqués ont-ils modifié ses caractéristiques ? */
SELECT Vin.annee, Caracteristique.nom, Caracteristique.note, Assemblage.pourcentage, Exploitation.gestion_sol, Exploitation.taille
	FROM Caracteristique
		INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
		INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
		INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
	WHERE Vin.nom='chateau lafite'
;


/* Evolution du chiffre d'affaire d'un vin (ici chateau lafite) dans le temps, en fonction des événements climatiques */
SELECT Vin.annee, Vin.prix*Vin.quantite AS chiffre_affaire,  EvtSurVin.date, EvtSUrVin.type, EvtSurVin.intensite, EvtSurVin.pourcentage
	FROM Vin
		LEFT JOIN (
			SELECT (Assemblage.vin_nom, Assemblage.vin_annee) AS vin, EvenementClimatique.date, EvenementClimatique.type, EvenementClimatique.intensite, Assemblage.pourcentage
				FROM EvenementClimatique
					INNER JOIN Exploitation ON EvenementClimatique.exp_parcelle=Exploitation.parcelle AND EvenementClimatique.exp_annee=Exploitation.annee
					INNER JOIN Assemblage ON Assemblage.exp_annee=Exploitation.annee AND Assemblage.exp_parcelle=Exploitation.parcelle
		) AS EvtSurVin ON EvtSurVin.vin = (Vin.nom, vin.annee)
	WHERE Vin.nom = 'chateau lafite' ORDER BY Vin.annee
;


/* Note moyenne des vins */
SELECT (vin_nom, vin_annee), AVG(note) AS moyenne
    FROM Caracteristique
    GROUP BY (vin_nom, vin_annee)
	ORDER BY moyenne DESC
;            


/* EvtSurVin: Liste les événements climatiques qui ont touché l'intégralité des vins */
SELECT (Assemblage.vin_nom, Assemblage.vin_annee) AS vin, EvenementClimatique.date AS date, EvenementClimatique.type AS type, EvenementClimatique.intensite AS intensite, Assemblage.pourcentage AS pourcentage
	FROM EvenementClimatique
		INNER JOIN Exploitation ON EvenementClimatique.exp_parcelle=Exploitation.parcelle AND EvenementClimatique.exp_annee=Exploitation.annee
		INNER JOIN Assemblage ON Assemblage.exp_annee=Exploitation.annee AND Assemblage.exp_parcelle=Exploitation.parcelle
;


/* Note moyenne des cepages(qui représentent plus de 50% de l'assemblage d'un vin) pour une caractéristique (ici 'robe'):  */
SELECT AssemblageEnCepage.cepage, ROUND(AVG(Caracteristique.note), 2) AS moyenne, COUNT(Caracteristique.note)
	FROM  (
		SELECT (Assemblage.vin_nom, Assemblage.vin_annee) AS vin, Parcelle.cepage AS cepage , SUM(Assemblage.pourcentage) AS pourcentage
			FROM Parcelle
				INNER JOIN Exploitation ON Exploitation.parcelle = Parcelle.cadastre
				INNER JOIN Assemblage ON Assemblage.exp_annee = Exploitation.annee AND Assemblage.exp_parcelle = Exploitation.parcelle
				GROUP BY Parcelle.cepage, (Assemblage.vin_nom, Assemblage.vin_annee)
	) AS AssemblageEnCepage
		INNER JOIN Vin ON (Vin.nom, Vin.annee) = AssemblageEnCepage.vin
		INNER JOIN Caracteristique ON (Caracteristique.vin_nom, Caracteristique.vin_annee) = AssemblageEnCepage.vin
	WHERE Caracteristique.nom = 'robe' AND AssemblageEnCepage.pourcentage > 0.5 GROUP BY AssemblageEnCepage.cepage
;


/* Question : à partir d'une caractéristique (ici 'robe'), donner le mode de culture et la note associée */
SELECT (Exploitation.gestion_sol, Exploitation.taille) AS Mode_de_culture, Caracteristique.note, Vin.nom AS nom_du_vin
    FROM Caracteristique
		INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
		INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
		INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
	WHERE Caracteristique.nom = 'robe'
;


/* Question : comment, pour un vin donné (ici 'chateau lafite'), ses différentes caractéristiques ont-elles été affectées par les événements climatiques (vision pluriannuelle) */
SELECT Vin.annee, Caracteristique.nom, Caracteristique.note, EvenementClimatique.type, EvenementClimatique.intensite
        FROM Caracteristique
                INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
                INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
                INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
                INNER JOIN EvenementClimatique ON EvenementClimatique.exp_annee = Exploitation.annee AND EvenementClimatique.exp_parcelle = Exploitation.parcelle
        WHERE Vin.nom='chateau lafite'
;


/* Question : comment, pour un vin donné (ici 'chateau lafite') et une caractéristique donnée (ici 'robe'), les modes de culture (gestion du sol, taille) appliqués ont-ils modifié sa qualité (notes de ses différentes caractéristiques) ? */
/* La donnée sélectionnée par le vigneron est donc le nom du vin */
SELECT Vin.annee, Caracteristique.note, Assemblage.pourcentage, (Exploitation.gestion_sol, Exploitation.taille) AS Mode_de_culture
	FROM Caracteristique
		INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
		INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
		INNER JOIN Exploitation ON  Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
	WHERE Vin.nom='chateau lafite' AND Caracteristique.nom = 'robe'
;

/* Requête permettant d'obetnir le chiffre d'affaire moyen des vins dont la majorité du cépage provient d'une parcelle où un mode culture choisi (ici engrais et taille à la main) est appliqué */
SELECT (Exploitation.gestion_sol, Exploitation.taille) AS Mode_Culture, ROUND(AVG(Vin.prix*Vin.quantite), 2) AS ChiffreAffaireMoyen
	FROM Vin
		INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
		INNER JOIN Exploitation ON Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle   
	WHERE Exploitation.gestion_sol='engrais' AND Exploitation.taille='a la main'
	GROUP BY (Exploitation.gestion_sol, Exploitation.taille)
;

/* Question : comment, pour une caractéristique donnée (ici 'gout'), les différents assemblages ont-ils modifié sa note ? */
SELECT (Vin.nom,Vin.annee), Caracteristique.note,  Assemblage.pourcentage, Cepage.nom, (Parcelle.cadastre, Exploitation.annee) AS ParcelleAnnee
        FROM Caracteristique
                INNER JOIN Vin ON Vin.nom = Caracteristique.vin_nom AND Vin.annee = Caracteristique.vin_annee
                INNER JOIN Assemblage ON Vin.nom = Assemblage.vin_nom AND Vin.annee = Assemblage.vin_annee
                INNER JOIN Exploitation ON Exploitation.annee = Assemblage.exp_annee AND Exploitation.parcelle = Assemblage.exp_parcelle
                INNER JOIN Parcelle ON Parcelle.cadastre = Exploitation.parcelle
                INNER JOIN Cepage ON Cepage.nom = Parcelle.cepage
        WHERE Caracteristique.nom='gout'
;
