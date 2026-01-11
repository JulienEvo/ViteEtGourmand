-- commande pour lancer le script
-- > mysql -u jchiarotti -p < C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/script/init_prod_db.sql

-- Création de la BDD
CREATE DATABASE vite_et_gourmand
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE vite_et_gourmand;

SET NAMES utf8mb4;

-- Schéma initial
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/001_user.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/002_menu.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/003_commande.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/004_societe.sql;

-- Seed initial
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/001_user.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/002_menu.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/004_societe.sql;

