CREATE TABLE avis (
    id INT NOT NULL AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    commande_id INT NOT NULL,
    note TINYINT(1) NOT NULL COMMENT 'Note de 1 à 5',
    commentaire TEXT NOT NULL,
    valide BOOLEAN NULL COMMENT 'NULL = pas traité - 1 = validé - 0 = refusé',
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

