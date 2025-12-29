-- Compte admin minimal
INSERT INTO utilisateur (utilisateur_role, utilisateur_email, utilisateur_password, utilisateur_prenom, utilisateur_nom,
                         utilisateur_telephone, societe_email, utilisateur_adresse, utilisateur_code_postal, utilisateur_commune, utilisateur_pays, createdAt )
VALUES (
        '["ROLE_USER", "ROLE_ADMIN"]',
        'julie_jose@viteetgourmand.fr',
        '$2y$10$HASH_PROD_SECURE',
        'José',
        'Studi',
        '060504030201',
        'jose@vite_et_gourmand.fr',
        '',
        '33000',
        'Bordeaux',
        'France',
        CURRENT_DATE
);


-- Autres utilisateurs
INSERT INTO utilisateur (utilisateur_role, utilisateur_email, utilisateur_password, utilisateur_prenom, utilisateur_nom,
                         utilisateur_telephone, societe_email, utilisateur_adresse, utilisateur_code_postal, utilisateur_commune, utilisateur_pays, createdAt )
VALUES (
           '["ROLE_USER", "ROLE_EMPLOYS"]',
           'test@employe.fr',
           '65df4g6s5d4fg654et9g84654dfg',
           'Amandine',
           'Magnier',
           '0611223344',
           'amagnier@veg_email.fr',
           '12 rue de la place',
           '83510',
           'Lorgues',
           'France',
           CURRENT_DATE
);
