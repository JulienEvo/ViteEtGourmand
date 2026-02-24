-- commande pour lancer le script
-- > mysql -u vite-et-gourmand -p < script/init_dev_db.sql

CREATE DATABASE IF NOT EXISTS vite_et_gourmand
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE vite_et_gourmand;

SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS societe;
DROP TABLE IF EXISTS societe_horaire;
DROP TABLE IF EXISTS horaire;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS avis;
DROP TABLE IF EXISTS plat_type;
DROP TABLE IF EXISTS allergene;
DROP TABLE IF EXISTS plat;
DROP TABLE IF EXISTS plat_allergene;
DROP TABLE IF EXISTS theme;
DROP TABLE IF EXISTS regime;
DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS menu_plat;
DROP TABLE IF EXISTS menu_theme;
DROP TABLE IF EXISTS menu_regime;
DROP TABLE IF EXISTS commande_etat;
DROP TABLE IF EXISTS commande;

SET FOREIGN_KEY_CHECKS = 1;


-- Schéma initial
SOURCE /docker-entrypoint-initdb.d/schemas/001_societe.sql;
SOURCE /docker-entrypoint-initdb.d/schemas/002_user.sql;
SOURCE /docker-entrypoint-initdb.d/schemas/003_plat.sql;
SOURCE /docker-entrypoint-initdb.d/schemas/004_menu.sql;
SOURCE /docker-entrypoint-initdb.d/schemas/005_commande.sql;
SOURCE /docker-entrypoint-initdb.d/schemas/006_avis.sql;


-- Seed initial
SOURCE /docker-entrypoint-initdb.d/seeds/001_societe.sql;
SOURCE /docker-entrypoint-initdb.d/seeds/002_user.sql;
SOURCE /docker-entrypoint-initdb.d/seeds/003_plat.sql;
SOURCE /docker-entrypoint-initdb.d/seeds/004_menu.sql;
SOURCE /docker-entrypoint-initdb.d/seeds/005_commande.sql;
SOURCE /docker-entrypoint-initdb.d/seeds/006_avis.sql;
