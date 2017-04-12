NOTE DE CLARIFICATION - Projet NF17
===================================
*Modélisation d'une exploitation viticole dans une base de données*  
par Alexandre Mazgaj, Martin Hebant, Vincent Brebion et Emmanuelle Lejeail

-----------------------------------

Descriptif/contexte:
--------------------
Un viticulteur souhaite suivre la qualité de son vin, son impact écologique et l'évolution de son chiffre d'affaire sur les différents vins qu'il produit.
Dans ce but, nous allons réaliser une base de données administrée en SQL. Celle-ci regroupera toutes les infos relatives aux parcelles, vins, modes de culture, et événements climatiques afin de répondre aux objectifs que nous allons détailler ci-après.

-----------------------------------

Objectifs:
----------
Notre objectif est de créer une base de données non-redondante pour pouvoir répondre aux besoins d'un exploitant viticole en extrayant certaines données pertinentes en fonction d’autres, de façon à ce que le viticulteur puisse les analyser.


**Ces besoins sont:**
- financiers: mettre en avant le chiffre d'affaire lié à la vente d'un vin par rapport à sa méthode de culture. Montrer l'influence des événements climatiques sur le chiffre d'affaire lié à la vente d'un vin.
- qualitatifs: mettre en avant la qualité d'un vin en fonction des cépages dont il provient et de l'assemblage, ainsi qu'en fonction du mode de culture.
- écologiques: faire ressortir la qualité d'un vin en fonction du mode de culture (quel type de désherbage? quel type de traitement phytosanitaire?)


**Choix de modélisation:**
- nous proposons d'étudier le chiffre d'affaire lié à un vin à partir du prix unitaire et de la quantité de bouteilles vendues.
- on appelle exploitation d'une parcelle le fait de l'utiliser une année. L'exploitation représente l'utilisation de la parcelle sur cette année et le mode de culture utilisé.
- la qualité du vin sera représentée sous la forme d'une note (/10) par caractéristiques (un vin peut être noté sur sa robe, son goût...).
- on précise les traitements phytosanitaires pratiqués chaque année, avec leur nom (entré par le viticulteur) et leur date.


**Les données utilisées:**
- Les parcelles: cépage utilisé, exposition, surface, type de sol et existence de la parcelle
- Le mode de culture: gestion du sol, mode de taille, type de traitement phytosanitaire.
- Les vins: prix, nombre de bouteilles vendues, année, note qualitative, assemblage.
- Les évènements climatiques: type, intensité par exploitation touchée, date.


**Les informations que nous avons choisi de ne pas implémenter** dans notre base de données:
- En ce qui concerne le vin: le circuit de vente.


**Objectifs finaux**:  
Créer un site permettant la gestion de l'exploitation ainsi qu'un outil d'analyse des données permettant de montrer :
- L'évolution du chiffre d'affaire d'un vin en fonction des evenement climatiques qui l'on touchés (pour permettre de calculer la perte génerer pour les assurances, objectif financier)
- Les cépages qui donnent les meilleurs notes pour une caractéristique (en vue d'améliorer la qualité des assemblages, objectif qualitatif)
- L'influence des modes de culuture (mode de taille, mode de gestion du sol) sur la qualité global d'un vin (dans le but d'améliorer les modes de culture, objectif écologique)
- Permettre de suivre le chiffre d'affaire d'un vin selon les modes de cultures des différentes parcelles dont il provient (objectif financier).
- L'influence des traitements phytosanitaires sur les caractéristiques d'un vin (objectif à la fois qualitatif et écologique pour optimiser le nombre de traitements et réduire son empreinte écologique)
- L'évolution du chiffre d'affaire d'un vin selon les traitements phytosanitaires subis par les parcelles dont il provient (objectif à la fois écologique et financier)
- L'influence des évènements climatiques sur la qualité d'un vin donné (objectif qualitatif)
- Pouvoir surveiller l'influence des différents assemblages pour une caracteristique donnée (objectif qualitatif)

-----------------------------------

Echéances:
----------
Note de clarification : samedi 11 Mars  
MCD (schéma UML) et MLD : samedi 18 Mars  
SQL 1.0 : samedi 25 Mars  
SQL 2.0 et PHP : samedi 1^er Avril 

-----------------------------------

Equipe:
-------
Emmanuelle - GI02 - SQL, UML et HTML/PHP  
Vincent - GI01 - SQL, UML et HTML/PHP  
Alexandre - GI02 - SQL, UML et HTML/PHP  
Martin - GI02 - SQL, UML et HTML/PHP  

------------------------------
