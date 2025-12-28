-- Menu

CREATE TABLE menu (
    menu_id INT NOT NULL AUTO_INCREMENT,
    menu_titre VARCHAR(32) NOT NULL,
    menu_description TEXT NOT NULL,
    menu_theme VARCHAR(64) NOT NULL,
    menu_min_personne SMALLINT NOT NULL,
    menu_tarif_personne DOUBLE NOT NULL,
    menu_regime VARCHAR(64) NOT NULL,
    menu_quantite SMALLINT NOT NULL,
    PRIMARY KEY (menu_id)
);

CREATE TABLE image (
    image_id INT NOT NULL AUTO_INCREMENT,
    image_titre VARCHAR(64) NOT NULL,
    image_lien VARCHAR(255) NOT NULL,
    createdAt DATETIME NOT NULL,
    updatedAt DATETIME NULL,
    PRIMARY KEY (image_id)
);

CREATE TABLE menu_image (
    menu_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (menu_id, image_id),
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES image(image_id) ON DELETE CASCADE
);

CREATE TABLE plat (
    plat_id INT NOT NULL AUTO_INCREMENT,
    plat_titre VARCHAR(64) NOT NULL,
    plat_type_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (plat_id)
);

CREATE TABLE plat_type (
    plat_type_id INT NOT NULL AUTO_INCREMENT,
    plat_type_libelle VARCHAR(32) NOT NULL,
    PRIMARY KEY (plat_type_id)
);

CREATE TABLE allergene (
    allergene_id INT NOT NULL AUTO_INCREMENT,
    allergene_libelle VARCHAR(32) NOT NULL,
    PRIMARY KEY (allergene_id)
);

CREATE TABLE plat_allergene (
    plat_id INT NOT NULL,
    allergene_id INT NOT NULL,
    PRIMARY KEY (plat_id, allergene_id),
    FOREIGN KEY (plat_id) REFERENCES plat(plat_id) ON DELETE CASCADE,
    FOREIGN KEY (allergene_id) REFERENCES allergene(allergene_id) ON DELETE CASCADE
);

CREATE TABLE conditions (
    condition_id INT NOT NULL AUTO_INCREMENT,
    condition_libelle VARCHAR(32) NOT NULL,
    condition_description TEXT NOT NULL,
    PRIMARY KEY (condition_id)
);

CREATE TABLE menu_condition (
    menu_id INT NOT NULL,
    condition_id INT NOT NULL,
    PRIMARY KEY (menu_id, condition_id),
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id) ON DELETE CASCADE,
    FOREIGN KEY (condition_id) REFERENCES conditions(condition_id) ON DELETE CASCADE
);

CREATE TABLE regime (
    regime_id INT NOT NULL AUTO_INCREMENT,
    regime_libelle VARCHAR(32) NOT NULL,
    regime_description TEXT NOT NULL,
    PRIMARY KEY (regime_id)
);

CREATE TABLE menu_regime (
    menu_id INT NOT NULL,
    regime_id INT NOT NULL,
    PRIMARY KEY (menu_id, regime_id),
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id) ON DELETE CASCADE,
    FOREIGN KEY (regime_id) REFERENCES regime(regime_id) ON DELETE CASCADE
);

CREATE TABLE menu_plat (
    menu_id INT NOT NULL,
    plat_id INT NOT NULL,
    PRIMARY KEY (menu_id, plat_id),
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id) ON DELETE CASCADE,
    FOREIGN KEY (plat_id) REFERENCES plat(plat_id) ON DELETE CASCADE
);

