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
INSERT INTO menu (libelle, description, conditions, quantite_min, tarif_unitaire, quantite_disponible, pret_materiel, actif)
VALUES
    ('Végétarien', 'Végétarien', 'Conditions : à conserver au frais', 2, 30, 60, 1, 1),
    ('Menu Entreprise', 'Une cuisine soignée et de saison, spécialement élaborée pour sublimer vos événements d’entreprise.', '- A réserver maximum 7 jours avant la date de l&#039;évènement. \r\n- Prêt matériel à restituer sous 10 jours ouvrés.', 10, 45, 120, 1, 1),
    ('Menu Junior', 'Des recettes simples et savoureuses pour faire plaisir aux enfants.', 'Destiné aux enfants de moins de 15 ans.\r\nConserver les entrées au frais.', 4, 15, 80, 0, 1),
    ('Menu Classic', 'Des plats authentiques et généreux, pour un repas tout en simplicité.', '- A consommer sous 2 jours.', 2, 32, 10, 0, 1);


/*** MENUS_THEME ***/
INSERT INTO `menu_theme` (`menu_id`, `theme_id`)
    VALUES
    (1, 2),
    (1, 4),
    (1, 6),
    (2, 1),
    (2, 9),
    (2, 11),
    (3, 4),
    (3, 7),
    (3, 9),
    (3, 10),
    (4, 9);


/*** MENUS_REGIME ***/
INSERT INTO `menu_regime` (`menu_id`, `regime_id`)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (2, 4),
    (3, 5),
    (4, 3),
    (4, 5);


/*** MENUS_PLAT ***/
INSERT INTO menu_plat (menu_id, plat_id)
VALUES
    (1, 2),
    (1, 8),
    (1, 15),
    (1, 24),
    (2, 3),
    (2, 9),
    (2, 18),
    (2, 23),
    (3, 5),
    (3, 14),
    (3, 26),
    (4, 1),
    (4, 6),
    (4, 11),
    (4, 21);
