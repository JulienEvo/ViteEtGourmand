/*** SOCIETE ***/
INSERT INTO societe (libelle, statut, capital, rcs, tva, telephone, email,
                     adresse, code_postal, commune, pays, created_at)
VALUES (
    'Vite & Gourmand',
    'SAS',
    '15000',
    'Bordeaux A 123 456 789',
    'FR99887766554',
    '0511223344',
    'contact@vite_et_gourmand.fr',
    '14 rue des Saveurs',
    '33000',
    'Bordeaux',
    'France',
    CURRENT_DATE
);

/*** HORAIRES ***/
INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
VALUES (
    1,
    'Lundi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
VALUES (
    1,
    'Mardi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
VALUES (
    1,
    'Mercredi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
VALUES (
    1,
    'Jeudi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
VALUES (
    1,
    'Vendredi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
VALUES (
    1,
    'Samedi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (societe_id, jour, ferme)
VALUES (
    1,
    'Dimanche',
    1
);
