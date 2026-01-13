#--- PLAT ---#
CREATE TABLE plat (
    id INT NOT NULL AUTO_INCREMENT,
    titre VARCHAR(64) NOT NULL,
    type_id INT NOT NULL,
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


#--- IMAGE ---#
CREATE TABLE image (
    id INT NOT NULL AUTO_INCREMENT,
    fichier VARCHAR(64) NOT NULL,
    titre VARCHAR(64) NOT NULL,
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


CREATE TABLE plat_image (
    plat_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (plat_id, image_id),
    FOREIGN KEY (plat_id) REFERENCES plat(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES image(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


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

