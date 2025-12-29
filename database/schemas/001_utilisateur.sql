-- Utilisateur

CREATE TABLE utilisateur (
    utilisateur_id INT NOT NULL AUTO_INCREMENT,
    utilisateur_role JSON NOT NULL,
    utilisateur_email VARCHAR(64) NOT NULL,
    utilisateur_password VARCHAR(255) NOT NULL,
    utilisateur_prenom VARCHAR(32) NOT NULL,
    utilisateur_nom VARCHAR(64) NOT NULL,
    utilisateur_telephone VARCHAR(32) NOT NULL,
    utilisateur_adresse VARCHAR(64) NOT NULL,
    utilisateur_code_postal VARCHAR(32) NOT NULL,
    utilisateur_commune VARCHAR(64) NOT NULL,
    utilisateur_pays VARCHAR(64) NOT NULL,
    createdAt DATETIME NOT NULL,
    updatedAt DATETIME NULL,
    PRIMARY KEY (utilisateur_id)
);

CREATE TABLE role (
    role_id INT NOT NULL AUTO_INCREMENT,
    role_libelle VARCHAR(32) NOT NULL,
    PRIMARY KEY (role_id)
);

CREATE TABLE utilisateur_role (
    utilisateur_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (utilisateur_id, role_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role(role_id) ON DELETE CASCADE
);

CREATE TABLE avis (
    avis_id INT NOT NULL AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    avis_note TINYINT(1) NOT NULL COMMENT 'Note de 1 à 5',
    avis_html TEXT NOT NULL,
    avis_valide BOOLEAN NULL COMMENT 'NULL = pas traité; 1 = validé; 0 = refusé',
    createdAt DATETIME NOT NULL,
    PRIMARY KEY (avis_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id) ON DELETE CASCADE
);

