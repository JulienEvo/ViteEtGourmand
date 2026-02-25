/*** COMMANDE_ETAT ***/
INSERT INTO commande_etat (libelle, couleur) VALUES ('En préparation', '#9CA3AF');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Acceptée', '#3B82F6');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Refusée', '#DC2626');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Annulée', '#6B7280');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Supprimée', '#6B7280');
INSERT INTO commande_etat (libelle, couleur) VALUES ('En cours de livraison', '#1D4ED8');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Livrée', '#22C55E');
INSERT INTO commande_etat (libelle, couleur) VALUES ('En attente du retour de matériel', '#F59E0B');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Terminée', '#15803D');


/*** COMMANDE ***/
INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
           3,
           1,
           9,
           'C26010001',
           '2026-01-01',
           2,
           150,
           10,
           CURRENT_DATE
       );

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
           3,
           2,
           9,
           'C26010002',
           '2026-01-05',
           1,
           75,
           0,
           CURRENT_DATE
       );

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
           4,
           3,
           9,
           'C26010003',
           '2026-01-08',
           3,
           210,
           5,
           CURRENT_DATE
       );

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
           4,
           3,
           9,
           'C26010004',
           '2026-01-12',
           1,
           60,
           0,
           CURRENT_DATE
       );

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, adresse_livraison, cp_livraison, commune_livraison, latitude, longitude, pret_materiel, quantite, remise, total_livraison, total_ttc, created_at)
VALUES
    (4, 1, 1, 'C26020005', '2026-02-19 00:00:00', '23 Rue Gouffrand', '33000', 'Bordeaux', 44.8559, -0.57212, 1, 7, 10, 6.94, 210, '2026-02-08 00:00:00'),
    (4, 3, 1, 'C26020009', '2026-02-11 11:06:00', '23 Rue Gouffrand', '33000', 'Bordeaux', 44.8559, -0.57212, 0, 4, 5, 6.94, 65, '2026-02-09 00:00:00'),
    (3, 2, 1, 'C26020011', '2026-02-12 11:36:00', '12 rue de la Fontaine', '50100', 'Florence', 0, 0, 1, 10, 0, 5, 455, '2026-02-09 00:00:00');
