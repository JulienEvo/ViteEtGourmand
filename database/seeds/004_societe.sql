-- Société
INSERT INTO societe (societe_libelle, societe_type, societe_capital, societe_rcs, societe_tva, societe_telephone,
                     societe_adresse, societe_code_postal, societe_commune, societe_pays)
VALUES (
    'Vite & Gourmand',
    'SAS',
    '15000',
    'Bordeaux A 123 456 789',
    'FR99887766554',
    '0511223344',
    '14 rue des Saveurs',
    '33000',
    'Bordeaux',
    'France',
);

INSERT INTO horaire (horaire_jour, horaire_ouverture, horaire_fermeture, horaire_ferme)
VALUES (
    'Lundi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (horaire_jour, horaire_ouverture, horaire_fermeture, horaire_ferme)
VALUES (
    'Mardi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (horaire_jour, horaire_ouverture, horaire_fermeture, horaire_ferme)
VALUES (
    'Mercredi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (horaire_jour, horaire_ouverture, horaire_fermeture, horaire_ferme)
VALUES (
    'Jeudi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (horaire_jour, horaire_ouverture, horaire_fermeture, horaire_ferme)
VALUES (
    'Vendredi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (horaire_jour, horaire_ouverture, horaire_fermeture, horaire_ferme)
VALUES (
    'Samedi',
    '09:00:00',
    '23:00:00',
    0
);

INSERT INTO horaire (horaire_jour, horaire_ferme)
VALUES (
    'Dimanche',
    1
);
