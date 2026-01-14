<?php
$serveur = "localhost";
$nom_base = "parc_auto";
$utilisateur = "root";
$mot_de_passe = "root"; 

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$nom_base;charset=utf8", $utilisateur, $mot_de_passe);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Requêtes Stats
$reponse = $bdd->query("SELECT COUNT(id) FROM vehicules");
$totalVehicules = $reponse->fetchColumn();

$reponse = $bdd->query("SELECT COUNT(id) FROM personnes");
$totalProprietaires = $reponse->fetchColumn();

$reponse = $bdd->query("SELECT SUM(montant) FROM contraventions");
$totalAmendes = $reponse->fetchColumn();
$totalAmendesAffiche = ($totalAmendes > 1000) ? number_format($totalAmendes / 1000, 1) . 'k €' : $totalAmendes . ' €';

$reponse = $bdd->query("SELECT COUNT(id) FROM entretiens");
$totalEntretiens = $reponse->fetchColumn();

//Véhicules 
$sql = "SELECT vehicules.immatriculation, SUM(entretiens.cout) as cout_entr, SUM(contraventions.montant) as total_amendes 
        FROM vehicules
        JOIN entretiens ON vehicules.id = entretiens.vehicule_id
        JOIN contraventions ON vehicules.id = contraventions.vehicule_id
        GROUP BY vehicules.id
        HAVING cout_entr > 300 AND total_amendes > 200
        LIMIT 6";
$vehiculesRisque = $bdd->query($sql)->fetchAll();

//Contraventions
$sql = "SELECT contraventions.date_contravention, vehicules.immatriculation, personnes.nom, personnes.prenom, contraventions.montant
        FROM contraventions
        JOIN vehicules ON contraventions.vehicule_id = vehicules.id
        LEFT JOIN personnes ON contraventions.conducteur_id = personnes.id
        ORDER BY contraventions.date_contravention DESC LIMIT 15";
$contraventionsRecentes = $bdd->query($sql)->fetchAll();

//Entretiens
$sql = "SELECT entretiens.date_entretien, entretiens.description, entretiens.cout, vehicules.immatriculation, garages.nom as garage
        FROM entretiens
        JOIN vehicules ON entretiens.vehicule_id = vehicules.id
        JOIN garages ON entretiens.garage_id = garages.id
        ORDER BY entretiens.date_entretien DESC LIMIT 3";
$derniersEntretiens = $bdd->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Parc Auto</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <main class="tableau-de-bord">

        <article class="carte carte-stat">
            <div class="info-stat">
                <h3>Total Véhicules</h3>
                <div class="chiffre"><?php echo $totalVehicules; ?></div>
            </div>
            <div class="icone fond-bleu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
            </div>
        </article>

        <article class="carte carte-stat">
            <div class="info-stat">
                <h3>Total Propriétaires</h3>
                <div class="chiffre"><?php echo $totalProprietaires; ?></div>
            </div>
            <div class="icone fond-vert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </article>

        <article class="carte carte-stat">
            <div class="info-stat">
                <h3>Amendes en cours</h3>
                <div class="chiffre"><?php echo $totalAmendesAffiche; ?></div>
            </div>
            <div class="icone fond-rouge">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </article>

        <article class="carte carte-stat">
            <div class="info-stat">
                <h3>Entretiens</h3>
                <div class="chiffre"><?php echo $totalEntretiens; ?></div>
            </div>
            <div class="icone fond-orange">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </article>

        <div class="carte carte-large bordure-rouge">
            <div class="entete-carte">
                <h2>Véhicules à Risque (>300€ Entr. & >200€ Amendes)</h2>
                <svg class="icone-grise" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#9ca3af"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
            </div>
            
            <div class="tableau">
                <div class="ligne entete">
                    <div>Immatriculation</div>
                    <div class="adroite">Coût Entr.</div>
                    <div class="adroite">Total Amendes</div>
                    <div class="adroite">Statut</div>
                </div>
                
                <?php if (empty($vehiculesRisque)): ?>
                    <div class="ligne"><div>R.A.S</div></div>
                <?php else: ?>
                    <?php foreach ($vehiculesRisque as $v): ?>
                        <div class="ligne">
                            <div class="gras"><?php echo $v['immatriculation']; ?></div>
                            <div class="texte-orange adroite"><?php echo $v['cout_entr']; ?> €</div>
                            <div class="texte-rouge adroite"><?php echo $v['total_amendes']; ?> €</div>
                            <div class="adroite"><span class="badge-rouge">Action Requise</span></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="carte carte-large bordure-orange">
            <div class="entete-carte">
                <h2>Contraventions Récentes</h2>
                <svg class="icone-grise" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#9ca3af"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
            </div>

             <div class="tableau">
                <div class="ligne entete">
                    <div>Date</div>
                    <div>Véhicule</div>
                    <div>Conducteur</div>
                    <div class="adroite">Montant</div>
                </div>

                <?php foreach ($contraventionsRecentes as $c): ?>
                    <div class="ligne">
                        <div class="date-courte"><?php echo $c['date_contravention']; ?></div>
                        <div class="gras"><?php echo $c['immatriculation']; ?></div>
                        <div><?php echo $c['nom'] . ' ' . $c['prenom']; ?></div>
                        <div class="gras adroite"><?php echo $c['montant']; ?> €</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <section class="carte section-basse-carte bordure-orange">
            <div class="entete-carte">
                 <h2>Derniers Entretiens</h2>
                 <svg class="icone-grise" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#9ca3af"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
            </div>
           
            <div class="conteneur-flex">
                <?php foreach ($derniersEntretiens as $e): ?>
                    <article class="carte-simple">
                        <div class="haut">
                            <span class="badge-gris"><?php echo $e['immatriculation']; ?></span>
                            <span class="date"><?php echo $e['date_entretien']; ?></span>
                        </div>
                        <div class="description">
                            <?php echo (strlen($e['description']) > 25) ? substr($e['description'], 0, 25) . '...' : $e['description']; ?>
                        </div>
                        <div class="bas">
                            <span class="garage-nom"><?php echo $e['garage']; ?></span>
                            <span class="gras"><?php echo $e['cout']; ?> €</span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

</body>
</html>