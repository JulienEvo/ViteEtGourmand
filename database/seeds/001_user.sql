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
    '$2y$13$hNViZs9.8bInu/FL.WHAQOI8aB.Rsg746pNiFAW9nYhZYyrohI5cm',
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
