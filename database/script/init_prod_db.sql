-- commande pour lancer le script
-- > mysql -u jchiarotti -p < C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/script/init_prod_db.sql

-- Création de la BDD
CREATE DATABASE vite_et_gourmand
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE vite_et_gourmand;

SET NAMES utf8mb4;

-- Schéma initial
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/001_societe.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/002_user.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/003_plat.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/004_menu.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/005_commande.sql;

-- Seed initial
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/001_societe.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/002_user.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/003_plat.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/004_menu.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/005_commande.sql;

