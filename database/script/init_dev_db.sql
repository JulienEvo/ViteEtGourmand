-- commande pour lancer le script
-- > mysql -u jchiarotti -p < C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/script/init_dev_db.sql


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
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/001_societe.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/002_user.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/003_plat.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/004_menu.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/005_commande.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/schemas/006_avis.sql;


-- Seed initial
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/001_societe.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/002_user.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/003_plat.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/004_menu.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/005_commande.sql;
SOURCE C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/seeds/006_avis.sql;
