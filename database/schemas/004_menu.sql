#--- MENU ---#
CREATE TABLE menu (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL,
    description TEXT NULL,
    conditions TEXT NULL,
    quantite_min SMALLINT NOT NULL DEFAULT 1,
    tarif_unitaire DOUBLE NOT NULL,
    quantite_disponible SMALLINT NOT NULL DEFAULT 0,
    pret_materiel TINYINT(1) NOT NULL DEFAULT 0,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- THEME ---#
CREATE TABLE theme (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- REGIME ---#
CREATE TABLE regime (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


/*** JOINTURES ***/

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

