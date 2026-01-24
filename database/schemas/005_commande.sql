#--- COMMANDE ---#
CREATE TABLE commande (
    id INT NOT NULL AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    menu_id INT NOT NULL,
    commande_etat_id TINYINT(3) NOT NULL,
    numero VARCHAR(32),
    date DATETIME,
    montant_ht DECIMAL(10, 0),
    reduction DECIMAL(10, 0),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX(utilisateur_id),
    INDEX(menu_id),
    INDEX(commande_etat_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- COMMANDE_ETAT ---#
CREATE TABLE commande_etat (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL,
    couleur VARCHAR(10) NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

