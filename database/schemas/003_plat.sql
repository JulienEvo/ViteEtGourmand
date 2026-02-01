#--- PLAT ---#
CREATE TABLE plat (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NULL,
    type_id INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- PLAT_TYPE ---#
CREATE TABLE plat_type (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- ALLERGENE ---#
CREATE TABLE allergene (
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

