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


/*** MENUS ***/
INSERT INTO menu (libelle, description, conditions, quantite_min, tarif_unitaire, quantite_disponible, actif)
VALUES (
        'Végétarien',
        'Végétarien',
        'Conditions : à conserver au frais',
        '2',
        '30',
        '10',
        '1'
       );
INSERT INTO menu (libelle, description, conditions, quantite_min, tarif_unitaire, quantite_disponible, actif)
VALUES (
           'Menu 2',
           'Description 2',
           'Conditions 2',
           '2',
           '40',
           '8',
           '1'
       );
INSERT INTO menu (libelle, description, conditions, quantite_min, tarif_unitaire, quantite_disponible, actif)
VALUES (
           'Menu 4',
           'Description 4',
           'Conditions 4',
           '4',
           '40',
           '12',
           '1'
       );
INSERT INTO menu (libelle, description, conditions, quantite_min, tarif_unitaire, quantite_disponible, actif)
VALUES (
           'Menu 3',
           'Description 3',
           'Conditions 3',
           '3',
           '30',
           '15',
           '1'
       );


/*** MENUS_THEME ***/
INSERT INTO menu_theme (menu_id, theme_id) VALUES (1, 2);
INSERT INTO menu_theme (menu_id, theme_id) VALUES (1, 4);
INSERT INTO menu_theme (menu_id, theme_id) VALUES (1, 6);


/*** MENUS_REGIME ***/
INSERT INTO menu_regime (menu_id, regime_id) VALUES (1, 1);
INSERT INTO menu_regime (menu_id, regime_id) VALUES (1, 3);
INSERT INTO menu_regime (menu_id, regime_id) VALUES (1, 2);
