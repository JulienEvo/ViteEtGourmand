/*** MENUS ***/
INSERT INTO menu (id, titre, description, theme, min_personne, tarif_personne, regime, quantite, actif)
VALUES (
        NULL,
        'Végétarien',
        'Entrée, Plat et dessert végétarien',
        'Végétarien',
        '2',
        '30',
        'regime',
        '10',
        '1'
);

/*** ALLERGENES ***/
INSERT INTO allergene (libelle, description) VALUES ('gluten', '');
INSERT INTO allergene (libelle, description) VALUES ('Arachide', '');
INSERT INTO allergene (libelle, description) VALUES ('Fruits à coque', '');
INSERT INTO allergene (libelle, description) VALUES ('Oeuf', '');
INSERT INTO allergene (libelle, description) VALUES ('Lait', '');
INSERT INTO allergene (libelle, description) VALUES ('Moutarde', '');
INSERT INTO allergene (libelle, description) VALUES ('Poisson', '');
INSERT INTO allergene (libelle, description) VALUES ('Céréales', '');


/*** COMMANDE_ETAT ***/
INSERT INTO commande_etat (libelle, description) VALUES ('En cours', '');
INSERT INTO commande_etat (libelle, description) VALUES ('Acceptée', '');
INSERT INTO commande_etat (libelle, description) VALUES ('Refusée', '');
INSERT INTO commande_etat (libelle, description) VALUES ('Annulée', '');
INSERT INTO commande_etat (libelle, description) VALUES ('En préparation', '');
INSERT INTO commande_etat (libelle, description) VALUES ('Prête', '');
INSERT INTO commande_etat (libelle, description) VALUES ('En livraison', '');
INSERT INTO commande_etat (libelle, description) VALUES ('Livrée', '');
INSERT INTO commande_etat (libelle, description) VALUES ('terminée', '');


/*** PLAT_TYPE ***/
INSERT INTO plat_type (libelle, description) VALUES ('Apéritifs', '');
INSERT INTO plat_type (libelle, description) VALUES ('Entrée', '');
INSERT INTO plat_type (libelle, description) VALUES ('Mises en bouche', '');
INSERT INTO plat_type (libelle, description) VALUES ('Plat', '');
INSERT INTO plat_type (libelle, description) VALUES ('Dessert', '');


/*** THEMES ***/
INSERT INTO theme (libelle, description) VALUES ('Noël', '');
INSERT INTO theme (libelle, description) VALUES ('Réveillon', '');
INSERT INTO theme (libelle, description) VALUES ('Saint-Valentin', '');
INSERT INTO theme (libelle, description) VALUES ('Anniversaire', '');
INSERT INTO theme (libelle, description) VALUES ('Mariage', '');
INSERT INTO theme (libelle, description) VALUES ('Baptême', '');
INSERT INTO theme (libelle, description) VALUES ('Street food', '');
INSERT INTO theme (libelle, description) VALUES ('Gastronomique', '');
INSERT INTO theme (libelle, description) VALUES ('De saison', '');
INSERT INTO theme (libelle, description) VALUES ('Enfant', '');
INSERT INTO theme (libelle, description) VALUES ('Entreprise', '');


/*** REGIMES ***/
INSERT INTO regime (libelle, description) VALUES ('Végétarien', '');
INSERT INTO regime (libelle, description) VALUES ('Vegan', '');
INSERT INTO regime (libelle, description) VALUES ('Sans gluten', '');
INSERT INTO regime (libelle, description) VALUES ('Bio', '');
INSERT INTO regime (libelle, description) VALUES ('Faible en calories', '');
