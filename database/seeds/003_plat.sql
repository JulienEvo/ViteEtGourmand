/*** PLAT_TYPE ***/
INSERT INTO plat_type (libelle, description) VALUES ('Apéritifs', '');
INSERT INTO plat_type (libelle, description) VALUES ('Entrée', '');
INSERT INTO plat_type (libelle, description) VALUES ('Mises en bouche', '');
INSERT INTO plat_type (libelle, description) VALUES ('Plat', '');
INSERT INTO plat_type (libelle, description) VALUES ('Dessert', '');


/*** ALLERGENES ***/
INSERT INTO allergene (libelle, description) VALUES ('gluten', '');
INSERT INTO allergene (libelle, description) VALUES ('Arachide', '');
INSERT INTO allergene (libelle, description) VALUES ('Fruits à coque', '');
INSERT INTO allergene (libelle, description) VALUES ('Oeuf', '');
INSERT INTO allergene (libelle, description) VALUES ('Lait', '');
INSERT INTO allergene (libelle, description) VALUES ('Moutarde', '');
INSERT INTO allergene (libelle, description) VALUES ('Poisson', '');
INSERT INTO allergene (libelle, description) VALUES ('Céréales', '');


/*** PLAT ***/
INSERT INTO plat (titre, type_id, image, actif) VALUES ('Mini quiches lorraines', 1, 'images/plat/1/Image-1.jpg', 1);
INSERT INTO plat (titre, type_id, image, actif) VALUES ('Gougères au fromage', 1, 'images/plat/1/image-2.jgp', 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Verrines avocat saumon', 1, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Toasts de tapenade', 1, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Brochettes tomate mozzarella', 1, 1);

INSERT INTO plat (titre, type_id, actif) VALUES ('Salade de chèvre chaud', 2, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Carpaccio de saumon citronné', 2, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Velouté de potimarron', 2, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Tartare de tomates et mozzarella', 2, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Feuilleté aux champignons', 2, 1);

INSERT INTO plat (titre, type_id, actif) VALUES ('Lasagnes à la bolognaise', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Risotto aux champignons', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Pavé de cabillaud, beurre blanc', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Burger maison', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Curry de légumes', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Lasagnes aux légumes', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Tofu mariné sauce soja', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Risotto aux asperges', 4, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Wok de légumes sautés', 4, 1);

INSERT INTO plat (titre, type_id, actif) VALUES ('Tiramisu', 5, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Mousse au chocolat', 5, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Crème brûlée', 5, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Fondant au chocolat', 5, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Panna cotta fruits rouges', 5, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Cheesecake', 5, 1);
INSERT INTO plat (titre, type_id, actif) VALUES ('Tarte aux pommes', 5, 1);


/*** PLAT_ALLERGENE ***/
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 1);
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 4);
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 5);
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 6);


/*** PLAT_IMAGE ***/
