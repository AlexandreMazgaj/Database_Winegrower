Modèle Logique de Données
=========================

Parcelle (#cadastre: Cadastre, cépage=>Cépage, exist : Bool, exposition : Réel, type-sol : Texte, surface: Réel)

Cépage (#nom : Texte, couleur : Texte)

Vin (#nom : Texte, #année : Entier, prix : Réel, quantité : Entier)

Assemblage (#vin=>Vin, #exploitation=>Exploitation, pourcentage : Réel)

Caractéristique (#nom : Texte, #vin=>Vin, note : Entier)

Évènement Climatique (#exploitation=>Exploitation, #type : Texte, intensité : Réel, #date : Date)

Exploitation (#année : Entier, #parcelle=>Parcelle, gestion-sol : Texte, taille : Texte)

Application Traitement (#date : Date, #traitement : Texte, #exploitation=>Exploitation)

