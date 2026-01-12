CREATE TABLE menu (
    id INT NOT NULL AUTO_INCREMENT,
    titre VARCHAR(32) NOT NULL,
    description TEXT NOT NULL,
    min_personne SMALLINT NOT NULL,
    tarif_personne DOUBLE NOT NULL,
    theme VARCHAR(64) NOT NULL,
    regime VARCHAR(64) NOT NULL,
    quantite SMALLINT NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE menu_image (
    id INT NOT NULL AUTO_INCREMENT,
    menu_id INT NOT NULL,
    fichier VARCHAR(64) NOT NULL,
    titre VARCHAR(64) NOT NULL,
    PRIMARY KEY (id),
    INDEX (menu_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE plat (
    id INT NOT NULL AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL,
    type_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE plat_type (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE allergene (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE conditions (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE theme (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE regime (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


/*************************************************************************/

CREATE TABLE plat_allergene (
    plat_id INT NOT NULL,
    allergene_id INT NOT NULL,
    PRIMARY KEY (plat_id, allergene_id),
    FOREIGN KEY (plat_id) REFERENCES plat(id) ON DELETE CASCADE,
    FOREIGN KEY (allergene_id) REFERENCES allergene(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE menu_condition (
    menu_id INT NOT NULL,
    condition_id INT NOT NULL,
    PRIMARY KEY (menu_id, condition_id),
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (condition_id) REFERENCES conditions(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE menu_theme (
    menu_id INT NOT NULL,
    theme_id INT NOT NULL,
    PRIMARY KEY (menu_id, theme_id),
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (theme_id) REFERENCES theme(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE menu_regime (
    menu_id INT NOT NULL,
    regime_id INT NOT NULL,
    PRIMARY KEY (menu_id, regime_id),
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (regime_id) REFERENCES regime(id) ON DELETE CASCADE
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8mb4
    COLLATE=utf8mb4_unicode_ci;

CREATE TABLE menu_plat (
    menu_id INT NOT NULL,
    plat_id INT NOT NULL,
    PRIMARY KEY (menu_id, plat_id),
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (plat_id) REFERENCES plat(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

