#--- COMMANDE ---#
CREATE TABLE commande (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    etat_id INT NOT NULL,
    numero VARCHAR(32),
    date DATETIME,
    reduction DATETIME,
    PRIMARY KEY (id),
    INDEX(user_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


#--- COMMANDE_ETAT ---#
CREATE TABLE commande_etat (
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(32) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

