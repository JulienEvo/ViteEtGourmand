-- Commande

CREATE TABLE commande (
    commande_id INT NOT NULL AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    commande_etat_id INT NOT NULL,
    commande_numero VARCHAR(32),
    commande_date DATETIME,
    commande_reduction DATETIME,
    PRIMARY KEY (commande_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id) ON DELETE CASCADE
);

CREATE TABLE commande_etat (
    commande_etat_id INT NOT NULL AUTO_INCREMENT,
    commande_etat_libelle VARCHAR(32) NOT NULL,
    PRIMARY KEY (commande_etat_id)
);

