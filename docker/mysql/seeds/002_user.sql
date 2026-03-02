-- Compte admin minimal
INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, poste, created_at)
VALUES (
        '["ROLE_USER", "ROLE_ADMIN"]',
        'jose@vite_et_gourmand.fr',
        '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
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
    '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
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
    '$2y$10$oIKSFWtFLpN0P7DMaWg/vODTJuzWS2IRr9xOSkEJWqP4edOqbwPc.', /* mCurie123+ */
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

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
    '["ROLE_EMPLOYE","ROLE_USER"]',
    'employe1@vite-et-gourmand.fr',
    '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
    'Gustave',
    'Eiffel',
    '0102020202',
    '26 Rue Beck',
    '33800',
    'Bordeaux',
    'France',
    44.822,
    -0.550368,
    'Serveur',
    '2026-02-09 14:40:47'
);
