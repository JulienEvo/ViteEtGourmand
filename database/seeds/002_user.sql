-- Compte admin minimal
INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, poste, created_at)
VALUES (
        '["ROLE_USER", "ROLE_ADMIN"]',
        'jose@vite_et_gourmand.fr',
        '$2y$13$hNViZs9.8bInu/FL.WHAQOI8aB.Rsg746pNiFAW9nYhZYyrohI5cm',
        'José',
        'Studi',
        '060504030201',
        '24 boulevard de la grande avenue',
        '33000',
        'Bordeaux',
        'France',
        'gérant',
        CURRENT_DATE
);

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, poste, created_at)
VALUES (
    '["ROLE_USER", "ROLE_ADMIN"]',
    'julien.chiarotti@gmail.com',
    '$2y$13$hNViZs9.8bInu/FL.WHAQOI8aB.Rsg746pNiFAW9nYhZYyrohI5cm', /* admin */
    'Julien',
    'Chiarotti',
    '0689715695',
    '50 le clos de Lorgues',
    '83510',
    'Lorgues',
    'France',
    'Administrateur',
    CURRENT_DATE
);

/* Utilisateurs */
INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'jean.dupond@test.com',
           '$2y$10$YCmbJt5ezFB6Jn7/lfwif.Tx6jXzOtqdHO.IlAU2Fg81PITvgyCwi', /* jDupond123+ */
           'Jean',
           'Dupond',
           '0711223344',
           '2 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           CURRENT_DATE
);

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
    '["ROLE_USER"]',
    'marie.curie@test.com',
    '$2y$10$AHSKYZO8N/xLCm9pJFCRV.R3veYVDVWUDtNZ6QSx2pF7MQ2rP7/SW', /* mCurie123+ */
    'Marie',
    'Curie',
    '0715264895',
    '23 Rue Gouffrand',
    '33000',
    'Bordeaux',
    'France',
    44.85585,
    -0.57212,
    '',
    CURRENT_DATE
);


/*** AVIS ***/
INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
    3,
    1,
    5,
    'Nous avons commandé un buffet pour notre anniversaire et tout était délicieux ! Service impeccable et produits frais. Je recommande vivement.',
    1,
    CURRENT_DATE
);

INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
   4,
   3,
   4,
   'Traiteur très professionnel. Les plats étaient délicieux et présentés avec soin. Nos invités ont adoré !',
   1,
   CURRENT_DATE
);

INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
    3,
    2,
    5,
    'Une équipe très réactive et sympathique. Les plats faits maison étaient excellents et le buffet parfaitement organisé.',
    1,
    CURRENT_DATE
);

INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
   4,
   4,
   3,
   'Parfait, je recommande',
   null,
   CURRENT_DATE
);

