
CREATE TABLE utilisateur (
    id INT NOT NULL AUTO_INCREMENT,
    roles JSON NOT NULL,
    email VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    prenom VARCHAR(32) NOT NULL,
    nom VARCHAR(64) NOT NULL,
    telephone VARCHAR(32) NOT NULL,
    adresse VARCHAR(64) NOT NULL,
    code_postal VARCHAR(32) NOT NULL,
    commune VARCHAR(64) NOT NULL,
    pays VARCHAR(64) NOT NULL,
    latitude FLOAT NULL,
    longitude FLOAT NULL,
    poste VARCHAR(64) NULL,
    actif BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;
