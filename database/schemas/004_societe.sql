-- Infos société

CREATE TABLE societe (
    societe_id INT NOT NULL AUTO_INCREMENT,
    societe_libelle VARCHAR(64) NOT NULL,
    societe_type VARCHAR(32) NOT NULL,
    societe_capital FLOAT NULL,
    societe_rcs VARCHAR(64),
    societe_tva VARCHAR(32),
    societe_telephone VARCHAR(32) NOT NULL,
    societe_email VARCHAR(64) NOT NULL,
    societe_adresse VARCHAR(255) NOT NULL,
    societe_code_postal VARCHAR(32) NOT NULL,
    societe_commune VARCHAR(64) NOT NULL,
    societe_pays VARCHAR(64) NOT NULL,
    createdAt DATETIME NOT NULL,
    updatedAt DATETIME NULL,
    PRIMARY KEY (societe_id)
);

CREATE TABLE horaire (
    horaire_id INT NOT NULL AUTO_INCREMENT,
    societe_id INt NOT NULL,
    horaire_jour VARCHAR(32) NOT NULL,
    horaire_ouverture TIME NULL,
    horaire_fermeture TIME NULL,
    horaire_ferme BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (horaire_id),
    INDEX(societe_id)
);

CREATE TABLE societe_horaire (
    societe_id INT NOT NULL,
    horaire_id INT NOT NULL,
    PRIMARY KEY (societe_id, horaire_id),
    FOREIGN KEY (societe_id) REFERENCES societe(societe_id) ON DELETE CASCADE,
    FOREIGN KEY (horaire_id) REFERENCES horaire(horaire_id) ON DELETE CASCADE
);
