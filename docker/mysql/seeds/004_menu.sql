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
    ('Menu Végétarien', 'Végétarien', 'Conditions : à conserver au frais', 2, 30, 60, 1, 1),
    ('Menu Entreprise', 'Une cuisine soignée et de saison, spécialement élaborée pour sublimer vos événements d’entreprise.', '- A réserver maximum 7 jours avant la date de l&#039;évènement. \r\n- Prêt matériel à restituer sous 10 jours ouvrés.', 10, 45, 120, 1, 1),
    ('Menu Junior', 'Des recettes simples et savoureuses pour faire plaisir aux enfants.', 'Destiné aux enfants de moins de 15 ans.\r\nConserver les entrées au frais.', 4, 15, 80, 0, 1),
    ('Menu Élégance', 'Entrée raffinée, plat gastronomique et dessert maison', 'Commande 48h à l’avance.\r\nConserver les entrées au frais.', 2, 35, 100, 0, 1),
    ('Menu Saveurs du Sud', 'Assortiment de spécialités méditerranéennes', 'Produits frais différents selon la saison. Nous contacter pour plus de détails', '15', '28', '85', '0', '1'),
    ('Menu Végétarien Gourmand', 'Plats créatifs 100% végétariens avec produits de saison', 'Option vegan disponible sur demande', '8', '26', '62', '0', '1'),
    ('Menu Prestige', 'Menu haut de gamme avec produits nobles (foie gras, saumon, etc.)', 'Service inclus', '12', '55', '55', '0', '1'),
    ('Menu Cocktail Dinatoire', 'Pièces salées et sucrées variées pour réception debout', 'A commander 7 jours avant l\'événement', '20', '22', '150', '0', '1'),
    ('Menu Barbecue Chic', 'Grillades premium avec accompagnements et desserts', 'Disponible en extérieur uniquement', '25', '30', '70', '0', '1'),
    ('Menu Brunch', 'Assortiment sucré/salé (viennoiseries, œufs, boissons)', 'Service uniquement le week-end', '6', '20', '95', '0', '1'),
    ('Menu Mariage', 'Menu complet avec cocktail, repas et dessert personnalisé', 'Devis personnalisé obligatoire', '25', '75', '48', '0', '1'),
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
    (4, 9),
    (4, 1),
    (4, 6),
    (5, 1),
    (5, 11),
    (5, 2),
    (5, 10),
    (6, 3),
    (6, 9),
    (6, 4),
    (7, 8),
    (7, 5),
    (7, 7),
    (7, 6),
    (8, 6),
    (8, 7),
    (8, 5),
    (9, 9),
    (9, 4),
    (9, 10),
    (10, 3),
    (11, 11),
    (11, 2),
    (11, 10),
    (12, 1),
    (12, 5);


/*** MENUS_REGIME ***/
INSERT INTO `menu_regime` (`menu_id`, `regime_id`)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (2, 4),
    (3, 5),
    (4, 3),
    (4, 1),
    (5, 5),
    (5, 4),
    (6, 3),
    (7, 1),
    (7, 5),
    (8, 4),
    (9, 2),
    (10, 3),
    (10, 1),
    (11, 4),
    (12, 3);


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
    (4, 21),

    (5, 3),
    (5, 8),
    (5, 18),
    (5, 23),

    (6, 4),
    (6, 7),
    (6, 17),
    (6, 20),

    (7, 2),
    (7, 4),
    (7, 12),
    (7, 25),

    (8, 1),
    (8, 10),
    (8, 14),
    (8, 23),

    (9, 4),
    (9, 8),
    (9, 19),
    (9, 24),

    (10, 5),
    (10, 9),
    (10, 16),
    (10, 22),

    (11, 2),
    (11, 7),
    (11, 15),
    (11, 21),

    (12, 1),
    (12, 8),
    (12, 12),
    (12, 25);
