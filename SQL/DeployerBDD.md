Déployer la BDD ExpViticole
============

Le schema
--------

	->SCHEMA expviticole
		->DOMAIN dANNEE
		->TYPE dCADASTRE
		->TABLE Cepage
		->TABLE Parcelle
		->TABLE Exploitation
		->TABLE EvenementClimatique
		->TABLE Assemblage
		->TABLE Caracteristique
		->TABLE Applicationtraitement
		->TABLE Vin
		
Déployer le schema
-----------

* Se connecter au server PostgreSQL de l'UTC (necessite d'etre sur le réseau #VPN):
`psql -h tuxa.sme.utc -d dbnf17p*** -U nf17p***`

* Une fois connecté, executer le fichier .sql:
`=> \i /[...]/creation_BDD.sql`

Tester la BDD
----------

Executer le fichier `=> \i /[...]/test_BDD.sql`

Supprimer le schema
-----------

*Attention !!:* Suppresion = Perte de données

Utiliser `=> DROP SCHEMA expviticole CASCADE;` pour nettoyer la BDD
(Ou executer le fichier `=>\i /[...]/nettoyage_BDD.sql`)
