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
    5,
    1,
    9,
    'C26010001',
    '2026-01-01',
    2,
    150,
    10,
    '2025-12-22 15:22:21'
);

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
   7,
   2,
   8,
   'C26010002',
   '2026-01-05',
   1,
   75,
   0,
   '2025-12-28 10:42:21'
);

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
    6,
    3,
    7,
    'C26010003',
    '2026-01-08',
    3,
    210,
    5,
    '2025-01-05 09:13:21'
);

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
   8,
   4,
   9,
   'C26010004',
   '2026-01-12',
   1,
   60,
   0,
   '2025-01-08 17:54:21'
);

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, adresse_livraison, cp_livraison, commune_livraison, latitude, longitude, pret_materiel, quantite, remise, total_livraison, total_ttc, created_at)
VALUES
    (9, 5, 7, 'C26020005', '2026-02-19 00:00:52', '23 Rue Gouffrand', '33000', 'Bordeaux', 44.8559, -0.57212, 1, 7, 10, 6.94, 210, '2026-02-08 13:24:21'),
    (10, 6, 9, 'C26020009', '2026-02-11 11:06:20', '05 Rue Gouffrand', '33000', 'Bordeaux', 44.8559, -0.57212, 0, 4, 0, 6.94, 65, '2026-02-09 22:42:21'),
    (11, 7, 5, 'C26020011', '2026-02-16 16:36:42', '12 rue de la Fontaine', '50100', 'Florence', 0, 0, 1, 10, 0, 5, 455, '2026-02-12 09:15:44'),
    (12, 8, 9, 'C26020011', '2026-02-21 08:54:12', '33 rue de la Fontaine', '50100', 'Florence', 0, 0, 1, 10, 10, 5, 455, '2026-02-14 19:20:31'),
    (7, 9, 9, 'C26020011', '2026-03-01 11:36:04', '15 rue de la Fontaine', '50100', 'Florence', 0, 0, 1, 10, 0, 5, 455, '2026-02-23 17:52:32'),
    (6, 12, 1, 'C26020011', '2026-03-06 22:13:20', '06 rue de la Fontaine', '50100', 'Florence', 0, 0, 1, 10, 0, 5, 455, '2026-02-28 10:34:33');
