#--- SOCIETE ---#
CREATE TABLE societe (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(64) NOT NULL,
    type VARCHAR(32) NOT NULL,
    capital FLOAT NULL,
    rcs VARCHAR(64),
    tva VARCHAR(32),
    telephone VARCHAR(32) NOT NULL,
    email VARCHAR(64) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    code_postal VARCHAR(32) NOT NULL,
    commune VARCHAR(64) NOT NULL,
    pays VARCHAR(64) NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- HORAIRE ---#
CREATE TABLE horaire (
    id INT NOT NULL AUTO_INCREMENT,
    societe_id INT NOT NULL,
    jour VARCHAR(32) NOT NULL,
    ouverture TIME NULL,
    fermeture TIME NULL,
    ferme BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    INDEX(societe_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


/*** JOINTURES ***/


CREATE TABLE societe_horaire (
    societe_id INT NOT NULL,
    horaire_id INT NOT NULL,
    PRIMARY KEY (societe_id, horaire_id),
    FOREIGN KEY (societe_id) REFERENCES societe(id) ON DELETE CASCADE,
    FOREIGN KEY (horaire_id) REFERENCES horaire(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;
