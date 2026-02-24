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
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Mini quiches lorraine', '', 1, 'images/plats/mini_quiches_lorraine.jfif', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Salade tomates Mozzarella', '', 1, 'images/plats/Salade_tomates_mozarella.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Verrines avocat saumon', '', 1, 'images/plats/Verrines_avocat_saumon.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Toasts de tapenade', '', 1, 'images/plats/Toasts_tapenade_verte_tomates_sechees.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Brochettes tomate mozzarella', '', 1, 'images/plats/Brochettes_tomate_mozzarella.jpg', 1);

INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Salade de chèvre chaud', '', 2, 'images/plats/Salade_chevre_chaud.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Carpaccio de saumon citronné', '', 2, 'images/plats/Carpaccio_saumon_citronne.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Velouté de potimarron', '', 2, 'images/plats/Veloute_potimarron.png', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Tartare de tomates et mozzarella', '', 2, 'images/plats/Tartare_tomates_mozzarella.jpeg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Feuilleté aux champignons', 'Feuilletés de champignons sauvages crémeux déglacés au vin blanc', 2, 'images/plats/Feuillete_champignons.jpg', 1);

INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Lasagnes à la bolognaise', '', 4, 'images/plats/Lasagnes_bolognaise.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Risotto aux champignons', '', 4, 'images/plats/Risotto_champignons.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Filet de Cabillaud à la Pêche et Romarin, beurre blanc', '', 4, 'images/plats/Filet_Cabillaud_Peche_Romarin.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Burger gourmet', '', 4, 'images/plats/Burger_gourmet.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Curry de légumes', '', 4, 'images/plats/Curry_legumes.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Lasagnes aux légumes', '', 4, 'images/plats/Lasagnes_legumes.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Tofu croustillant sauce coco, arachides et érable', '', 4, 'images/plats/Tofu_croustillant_sauce_coco_arachides_érable.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Risotto aux asperges', '', 4, 'images/plats/Risotto_asperges.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Wok de légumes sautés', '', 4, 'images/plats/Wok_legumes_sautes.jpg', 1);

INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Tiramisu', '', 5, 'images/plats/Tiramisu.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Mousse au chocolat', '', 5, 'images/plats/Mousse_chocolat.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Crème brûlée', '', 5, 'images/plats/Creme_brulee.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Fondant au chocolat', '', 5, 'images/plats/Fondant_chocolat.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Panna cotta fruits rouges', '', 5, 'images/plats/Panna_cotta_fruits_rouges.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Mini cheesecakes passion & agrumes', '', 5, 'images/plats/Mini_cheesecakes_passion_agrumes.jpg', 1);
INSERT INTO plat (libelle, description, type_id, image, actif) VALUES ('Tarte aux pommes', '', 5, 'images/plats/Tarte_pommes.jpg', 1);


/*** PLAT_ALLERGENE ***/
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 1);
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 4);
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 5);
INSERT INTO plat_allergene (plat_id, allergene_id) VALUES (1, 6);


