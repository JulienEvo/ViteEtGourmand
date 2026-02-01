/*** COMMANDE_ETAT ***/
INSERT INTO commande_etat (libelle, couleur) VALUES ('En préparation', '#9CA3AF');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Acceptée', '#3B82F6');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Refusée', '#DC2626');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Annulée', '#6B7280');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Supprimée', '#6B7280');
INSERT INTO commande_etat (libelle, couleur) VALUES ('En cours de livraison', '#1D4ED8');
INSERT INTO commande_etat (libelle, couleur) VALUES ('Livrée', '#22C55E');
INSERT INTO commande_etat (libelle, couleur) VALUES ('en attente du retour de matériel', '#F59E0B');
INSERT INTO commande_etat (libelle, couleur) VALUES ('terminée', '#15803D');


/*** COMMANDE ***/
INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
    3,
    1,
    6,
    'C26010001',
    '2026-01-01',
    2,
    150,
    10,
    CURRENT_DATE
);

INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise, created_at)
VALUES (
   5,
   2,
   6,
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
    6,
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
   6,
   'C26010004',
   '2026-01-12',
   1,
   60,
   0,
   CURRENT_DATE
);

