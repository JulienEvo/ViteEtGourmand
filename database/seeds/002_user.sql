-- Comptes administrateur
INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, poste, created_at)
VALUES (
        '["ROLE_USER", "ROLE_ADMIN"]',
        'jose@vite-et-gourmand.fr',
        '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
        'José',
        'Studi',
        '06050403020',
        '24 cr Pasteur',
        '33000',
        'Bordeaux',
        'France',
        'gérant',
        '2025-02-12 14:40:47'
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
    '2025-02-12 10:25:21'
);


-- Comptes employés
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
           'Livreur',
           '2025-05-16 09:40:47'
       );

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_EMPLOYE","ROLE_USER"]',
           'employe2@vite-et-gourmand.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Issac',
           'Newton',
           '0103030303',
           '18 Rue Beck',
           '33800',
           'Bordeaux',
           'France',
           44.822,
           -0.550368,
           'Chef de cuisine',
           '2025-03-09 14:40:47'
       );


-- Comptes utilisateurs
INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'jean.dupond@vg-mail.fr',
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
           '2025-05-02 14:40:47'
);

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
    '["ROLE_USER"]',
    'marie.curie@vg-mail.fr',
    '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
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
    '2025-05-21 12:25:47'
);

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'albert.einstein@vg-mail.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Albert',
           'Einstein',
           '0609090909',
           '5 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           '2025-06-10 18:40:47'
       );

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'charles.darwin@vg-mail.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Charles',
           'Darwin',
           '0608080808',
           '21 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           '2025-06-12 08:12:51'
       );

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'louis.pasteur@vg-mail.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Louis',
           'Pasteur',
           '0607070707',
           '2 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           '2025-06-12 08:12:51'
       );

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'nikola.tesla@vg-mail.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Nikola',
           'Tesla',
           '0607070707',
           '2 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           '2025-06-18 17:12:51'
       );

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'stephen.hawking@vg-mail.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Stephen',
           'Hawking',
           '0606060606',
           '11 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           '2025-09-05 15:55:51'
       );

INSERT INTO utilisateur (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, latitude, longitude, poste, created_at)
VALUES (
           '["ROLE_USER"]',
           'antoine.lavoisier@vg-mail.fr',
           '$2y$10$0Bx/sGuv5JAzc3cVJmHgZ.MIUEu3ezNl0UoSrWojbdBqKDT0KATdC', /* ViteEtGourmand123+ */
           'Antoine',
           'Lavoisier',
           '0605050505',
           '19 Rue Georges Nègrevergne',
           '33700',
           'Mérignac',
           'France',
           44.817,
           -0.680099,
           '',
           '2025-09-15 15:55:51'
       );

