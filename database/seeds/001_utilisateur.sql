-- Compte admin minimal
INSERT INTO utilisateur (utilisateur_role, utilisateur_email, utilisateur_password, utilisateur_prenom, utilisateur_nom,
                         utilisateur_telephone, utilisateur_adresse, utilisateur_code_postal, utilisateur_commune, utilisateur_pays )
VALUES (
        '["ROLE_USER", "ROLE_ADMIN"]',
        'julie_jose@viteetgourmand.fr',
        '$2y$10$HASH_PROD_SECURE',
        'José',
        'Studi',
        '060504030201',
        '',
        '33000',
        'Bordeaux',
        'France'
);
