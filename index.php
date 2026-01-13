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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Parc Auto</title>
    <head>
    <link href="./output.css" rel="stylesheet">
</head>
</head>
<body class="bg-default font-sans text-gray-800">

    <main class="container py-10">

        <section id="section_header grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <article class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex justify-between items-center hover:shadow-md transition">
                <div class="">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Véhicules</h3>
                    <p>1,248</p>
                </div>
                <div class=""><svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512"><path fill="currentColor" fill-rule="evenodd" d="M128 298.666c23.564 0 42.667 19.103 42.667 42.667S151.564 384 128 384s-42.666-19.103-42.666-42.667s19.102-42.667 42.666-42.667m245.334 0c23.564 0 42.666 19.103 42.666 42.667S396.898 384 373.334 384s-42.667-19.103-42.667-42.667s19.103-42.667 42.667-42.667m-64 42.667c0 7.48 1.283 14.661 3.642 21.334H188.358A63.9 63.9 0 0 0 192 341.333c0-7.48-1.283-14.661-3.642-21.334h124.618a63.9 63.9 0 0 0-3.642 21.334m-24.89-192l5.69 4.267l81.856 61.397l65.025 16.266c17.877 4.47 30.731 19.85 32.182 37.966l.137 3.427v74.667l-16.16 4.04l-17.466 4.367a64.2 64.2 0 0 0 1.626-14.397c0-13.085-3.927-25.252-10.666-35.388l-.001-33.289l-69.174-17.293l-4.18-1.045l-.835-.627l-11.144 11.145a42.67 42.67 0 0 1-30.17 12.497l-225.831-.001v16.299C72.24 305.349 64 322.379 64 341.333c0 3.244.242 6.431.707 9.545l-22.04-22.042V226.943l4.945-5.934l53.333-64l6.397-7.676zM270.23 192H127.318l-35.55 42.666h219.396l6.835-6.836z"/></svg></div>
            </article>

            <article class="">
                <div class="">
                    <h3>Propriétaires</h3>
                    <p>854</p>
                </div>
                <div class=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"><path stroke-linecap="round" d="M12 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/><path d="M22 17.28a2.28 2.28 0 0 1-.662 1.606c-.976.984-1.923 2.01-2.936 2.958a.597.597 0 0 1-.823-.017l-2.918-2.94a2.28 2.28 0 0 1 0-3.214a2.277 2.277 0 0 1 3.233 0l.106.107l.106-.107A2.277 2.277 0 0 1 22 17.28Z"/><path stroke-linecap="round" d="M5 20v-1a7 7 0 0 1 10-6.326"/></g></svg></div>
            </article>

            <article class="">
                <div class="">
                    <h3>Amendes en cours</h3>
                    <p>12,4k €</p>
                </div>
                <div class=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="-2 -3 24 24"><path fill="currentColor" d="m12.8 1.613l6.701 11.161c.963 1.603.49 3.712-1.057 4.71a3.2 3.2 0 0 1-1.743.516H3.298C1.477 18 0 16.47 0 14.581c0-.639.173-1.264.498-1.807L7.2 1.613C8.162.01 10.196-.481 11.743.517c.428.276.79.651 1.057 1.096M10 14a1 1 0 1 0 0-2a1 1 0 0 0 0 2m0-9a1 1 0 0 0-1 1v4a1 1 0 0 0 2 0V6a1 1 0 0 0-1-1"/></svg></div>
            </article>

             <article class="">
                <div class="">
                    <h3>Entretiens</h3>
                    <p>42</p>
                </div>
                <div class=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 7.86c0-.43-.056-.849-.161-1.246c-.092-.349-.522-.432-.776-.177L18.34 8.16a1.767 1.767 0 1 1-2.5-2.5l1.723-1.722c.255-.255.172-.685-.177-.777a4.86 4.86 0 0 0-5.828 6.326c.071.2.031.424-.118.573L3.3 18.2c-.4.4-.4 1.049 0 1.448L4.352 20.7c.4.4 1.047.4 1.447 0l8.14-8.14c.15-.15.374-.19.573-.119A4.86 4.86 0 0 0 21 7.86"/></svg></div>
            </article>

        </section>

        <section id="section_body">

            <div id="risk-vehicles">
                <header class="">
                    <h2>Véhicules à Risque (>300€ Entr. & >200€ Amendes)</h2>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M21 20h-.514c-1.236 1.165-4.568 2-8.486 2s-7.25-.835-8.486-2H3V5c0 1.657 4.03 3 9 3s9-1.343 9-3z"/><path d="M12 8c4.97 0 9-1.343 9-3s-4.03-3-9-3s-9 1.343-9 3s4.03 3 9 3"/><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.657-4.03 3-9 3s-9-1.343-9-3m18 0v7c0 1.657-4.03 3-9 3s-9-1.343-9-3v-7m18 0V5M3 12V5m0 0c0 1.657 4.03 3 9 3s9-1.343 9-3M3 5c0-1.657 4.03-3 9-3s9 1.343 9 3"/></g></svg></span>
                </header>

                <div class="">
                    <div class="">Immatriculation</div>
                    <div class="">Coût Entr.</div>
                    <div class="">Total Amendes</div>
                    <div class="">Statut</div>
                </div>

                <div class="">
                    
                    <div class="">
                        <div class="">AB-123-CD</div>
                        <div class="">450 €</div>
                        <div class="">225 €</div>
                        <div class="">
                            <span>Action Requise</span>
                        </div>
                    </div>
                    <div class="">
                        <div class="">EF-456-GH</div>
                        <div class="">120 €</div>
                        <div class="">90 €</div>
                        <div class="">
                            <span>Action Requise</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="recent-fines">
                <header class="">
                    <h2>Contraventions Récentes</h2>
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M21 20h-.514c-1.236 1.165-4.568 2-8.486 2s-7.25-.835-8.486-2H3V5c0 1.657 4.03 3 9 3s9-1.343 9-3z"/><path d="M12 8c4.97 0 9-1.343 9-3s-4.03-3-9-3s-9 1.343-9 3s4.03 3 9 3"/><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.657-4.03 3-9 3s-9-1.343-9-3m18 0v7c0 1.657-4.03 3-9 3s-9-1.343-9-3v-7m18 0V5M3 12V5m0 0c0 1.657 4.03 3 9 3s9-1.343 9-3M3 5c0-1.657 4.03-3 9-3s9 1.343 9 3"/></g></svg></span>
                </header>

                 <div class="">
                    <div class="">Date</div>
                    <div class="">Véhicule</div>
                    <div class="">Conducteur</div>
                    <div class="">Montant</div>
                </div>

                <div class="">

                    <div class="">
                        <div class="">2023-10-05</div>
                        <div class="">AB-123-CD</div>
                        <div class="">Jean Dupont</div>
                        <div class="">135 €</div>
                    </div>
                    <div class="">
                        <div class="">2023-11-12</div>
                        <div class="">EF-456-GH</div>
                        <div class="">Jean Dupont</div>
                        <div class="">90 €</div>
                    </div>
                    <div class="">
                        <div class="">2023-12-01</div>
                        <div class="">IJ-789-KL</div>
                        <div class="">Sophie Martin</div>
                        <div class="">45 €</div>
                    </div>
                    <div class="">
                        <div class="">2024-01-15</div>
                        <div class="">MN-012-OP</div>
                        <div class="">Lucas Bernard</div>
                        <div class="">45 €</div>
                    </div>
                </div>
            </div>

        </section>

        <section id="section_footer">
            <header class="">
                <h2>Derniers Entretiens</h2>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M21 20h-.514c-1.236 1.165-4.568 2-8.486 2s-7.25-.835-8.486-2H3V5c0 1.657 4.03 3 9 3s9-1.343 9-3z"/><path d="M12 8c4.97 0 9-1.343 9-3s-4.03-3-9-3s-9 1.343-9 3s4.03 3 9 3"/><path stroke="currentColor" stroke-width="2" d="M21 12c0 1.657-4.03 3-9 3s-9-1.343-9-3m18 0v7c0 1.657-4.03 3-9 3s-9-1.343-9-3v-7m18 0V5M3 12V5m0 0c0 1.657 4.03 3 9 3s9-1.343 9-3M3 5c0-1.657 4.03-3 9-3s9 1.343 9 3"/></g></svg></span>
            </header>

            <div class="">
                
                <article class="">
                    <div class="">
                        <span>AB-123-CD</span>
                        <span>2023-09-20</span>
                    </div>
                    
                    <h3 class="">Révision complète</h3>
                    
                    <div class="">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M44 16c0 6.627-5.373 12-12 12c-2.027 0-3.936-.503-5.61-1.39L9 44l-5-5l17.39-17.39A11.95 11.95 0 0 1 20 16c0-6.627 5.373-12 12-12c2.027 0 3.936.502 5.61 1.39L30 13l5 5l7.61-7.61A11.95 11.95 0 0 1 44 16"/></svg> Garage du Centre</span>
                        <span>450 €</span>
                    </div>
                </article>
                <article class="">
                    <div class="">
                        <span>EF-456-GH</span>
                        <span>2023-10-15</span>
                    </div>
                    
                    <h3 class="">Vidange</h3>
                    
                    <div class="">
                        <span> <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M44 16c0 6.627-5.373 12-12 12c-2.027 0-3.936-.503-5.61-1.39L9 44l-5-5l17.39-17.39A11.95 11.95 0 0 1 20 16c0-6.627 5.373-12 12-12c2.027 0 3.936.502 5.61 1.39L30 13l5 5l7.61-7.61A11.95 11.95 0 0 1 44 16"/></svg> Midas</span>
                        <span>120 €</span>
                    </div>
                </article>
                <article class="">
                    <div class="">
                        <span>IJ-789-KL</span>
                        <span>2024-01-10</span>
                    </div>
                    
                    <h3 class="">Changement pneus</h3>
                    
                    <div class="">
                        <span> <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M44 16c0 6.627-5.373 12-12 12c-2.027 0-3.936-.503-5.61-1.39L9 44l-5-5l17.39-17.39A11.95 11.95 0 0 1 20 16c0-6.627 5.373-12 12-12c2.027 0 3.936.502 5.61 1.39L30 13l5 5l7.61-7.61A11.95 11.95 0 0 1 44 16"/></svg> Tesla Service</span>
                        <span>800 €</span>
                    </div>
                </article>
                </div>
        </section>

    </main>

</body>
</html>