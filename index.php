<!--
1. Lister les 20 premières personnes (id, nom, prénom, téléphone)
SELECT id, nom, prenom, tel FROM personnes
LIMIT 20;

2. Lister les véhicules avec leur propriétaire (nom + prénom)
SELECT nom, prenom, marque FROM personnes
NATURAL JOIN vehicules;

3. Compter le nombre total de véhicules dans la base
SELECT COUNT(vehicules.id) FROM vehicules

4. Compter le nombre de véhicules par type d’énergie
SELECT COUNT(energie), energie FROM vehicules
GROUP BY energie

5. Top 5 propriétaires qui ont le plus de véhicules
SELECT personnes.nom, personnes.prenom, COUNT(vehicules.id) as Nombre_vehicules FROM personnes
JOIN vehicules ON personnes.id = proprietaire_id
GROUP BY personnes.id
ORDER BY Nombre_vehicules DESC
LIMIT 5;

6. Liste des contraventions avec immatriculation du véhicule et nom du conducteur
SELECT contraventions.id, nom, immatriculation, montant FROM contraventions
JOIN vehicules ON contraventions.vehicule_id = vehicules.id
JOIN personnes ON contraventions.conducteur_id = personnes.id


7. Montant total des contraventions par personne (conducteur)
SELECT SUM(contraventions.montant), prenom  FROM contraventions
JOIN personnes ON personnes.id = contraventions.id
GROUP BY personnes.prenom LIMIT 100;

8. Montant total des contraventions par année et par commune
SELECT SUM(montant) as montant_total, nom, YEAR (date_contravention) as date_annee FROM contraventions
JOIN communes ON contraventions.lieu_id = communes.id
GROUP BY contraventions.lieu_id, date_annee
ORDER BY date_annee, nom DESC LIMIT 100;

9. Liste des 20 derniers entretiens avec garage et véhicule
SELECT date_entretien, marque, nom FROM entretiens
JOIN vehicules ON entretiens.vehicule_id = vehicules.id
JOIN garages ON entretiens.garage_id = garages.id
ORDER BY date_entretien DESC
LIMIT 20;


10. Véhicules qui cumulent plus de 300 € d’entretien et plus de 200 € d’amendes
SELECT SUM(montant) as montant_total, SUM(cout) as cout_total, marque FROM vehicules
JOIN entretiens ON vehicules.id = entretiens.vehicule_id
JOIN contraventions ON vehicules.id = contraventions.vehicule_id
GROUP BY vehicules.immatriculation
HAVING SUM(montant) >= 200 AND SUM(cout)>=300
ORDER BY montant_total ASC LIMIT 100;-->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parc_auto</title>
</head>
<body>
    
</body>
</html>