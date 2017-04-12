Documentation des différents fichiers PHP utilisés dans le projet
=================================================================

database.php
------------
Fichier essentiel, est intégré dans quasiment chaque page php de notre projet. Il nous permet d'effectuer deux actions :
- la connexion à la base de données
- la définition de la fonction "drowTable", nous permettant, pour une table retournée par une requête SQL, de l'afficher sous forme de tableau en HTML

ajout_be.php
-------------
Fichier essentiel, car c'est lui qui est chargé de centraliser les requêtes d'ajout à la base de données, à travers le paramètre 't' désignant le type d'ajout (dans quelle base de donnée veut-on faire un ajout ?), passé par la méthode GET.  
Pour chaque cas, le schéma général reste le même : récupération des différents paramètres par la méthode POST, puis insertion dans la BDD.  
À noter que dans certains cas, une étape supplémentaire est réalisée : une date récupérée depuis un formulaire est explosée afin d'en récupérer l'année, celle-ci devant également être insérée dans la base de donnée. De cette manière, l'utilisateur ne peut pas entrer une date (par exemple une date de traitement de parcelle) et une année qui serait incohérente (sur le même exemple, l'année d'exploitation de la parcelle).

Les fichiers suivants suivent tous le même schéma :
---------------------------------------------------
- ajout_caracteristique.php
- ajout_cepage.php
- ajout_evt_climatique.php
- ajout_exploitation.php
- ajout_parcelle.php
- ajout_traitement.php
- ajout_vin.php

Ils sont en effet composés d'un simple formulaire dont l'utilisateur va remplir les informations.  
À noter que, dans certains fichiers, dans le cas où une liste déroulante de choix faisant rapport à des éléments de la BDD doit être utilisée, deux requêtes SQL sont mises en place :
- une première, en tête de fichier, permettant de récupérer l'ensemble des éléments distincts d'une colonne de la table que l'on souhaite utiliser (par exemple, l'ensemble des différents noms de cépages de la table Cepage)
- une seconde, dans le corps du HTML, qui nous permet, de créer les différents item du menu déroulant, dont la valeur et le nom affiché sont la valeur retourné par une ligne de la requête précédente. **// Pas clair du tout :D À revoir si possible**

ajout_assemblage.php
--------------------
Contrairement aux autres pages d'ajout, celle-ci va devoir effectuer une étape supplémentaire avant d'être envoyée à ajout_be.php :
- une première partie permet d'afficher le formulaire de saisie du vin et du nombre d'exploitations associées
- une seconde partie, ne s'exécutant que si la première partie a été complétée de manière exacte, et s'exécutant autant de fois qu'il y a d'exploitations à définir, et permettant, pour chaque exploitation, de définir l'année, la parcelle, et le pourcentage de cette exploitation composant le vin final.
La requête d'insertion se fait au final à travers l'appel au fichier ajout_be.php, comme expliqué précédemment.

afficher_bdd.php
----------------
Chacune des requêtes permet de récupérer une table de la BDD dans son intégralité, afin de l'afficher sur la page.

index.php (à la racine du projet)
---------------------------------
Il nous permet tout simplement d'effectuer la redirection vers le fichier index.php contenu dans le dossier 'PHP'

index.php (dans le dossier 'PHP')
---------------------------------
Ce fichier nous permet d'établir la présentation globale du site, par l'utilisation de framesets :
- un menu à gauche (menu.php), permettabt d'accèder à l'ensemble des requêtes proposées
- un écran central, affichant à la base accueil.php (message d'accueil du site), et affichant chaque page php lors du clic sur l'item correspondant dans le menu de gauche
- un pied de page (footer.php), affichant les crédits du projet

supprimer_exploitation.php et suppression_BDD.php
---------------------------------------------------
Ces deux pages permettent de nettoyer la BDD intégralement.
- supprimer_exploitation.php est la première page que l'utilisateur va consulter, lui demandant s'il souhaite réellement supprimer la base de données (afin d'éviter toute erreur de manipulation)
- suppression_BDD.php est la page permettant d'exécuter le script SQL permettant de supprimer définitivement le contenu de la BDD

Les fichiers php suivants, correspondant aux requêtes, tout comme ceux correspondant aux ajouts, suivent un même schéma général :
---------------------------------------------------------------------------------------------------------------------------------
- requete_cepage_caracteristique.php
- requete_ecologique_traitement.php
- requete_finance_evenement_climatique.php
- requete_finance_mode_culture.php
