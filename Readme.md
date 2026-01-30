# Vite & Gourmand
« Vite & Gourmand » est une entreprise constituée de deux personnes, Julie et José. Elle existe
depuis 25 ans à Bordeaux, et propose leurs prestations pour tout événement (simple repas
comme Noel ou encore Pâques) au travers d’un menu en constante évolution.

Cette application dynamique développé en PHP avec le framework Symfony permet la visualisation et la consultation de menus pour des visiteurs qui pourront s'inscrire et se connecter 
en tant qu'utilisateurs afin d'effectuer des commandes de menus faits maison, livrées à domicile, et de gérer leurs informations via leur espace.

Les administrateurs et employés pourront, via cette application, gérer les menus, les commandes ainsi que les avis envoyés par 
des clients.

## Prérequis

Pour exécuter le projet en local, les éléments suivants sont nécessaires :

- Langage : PHP 8.2
- Framework : Symfony
- Gestionnaire de dépendances : Composer
- Serveur web : Apache
- SGBD : MariaDB (MySQL)
- HTML / CSS / JavaScript
- Gestion de versions : Git

---

# Installation

### 1. Récupération du projet
Cloner le dépôt Git sur la machine locale.
```
git clone https://github.com/JulienEvo/ViteEtGourmand.git
```

### 2. Installation des dépendances
Installer les dépendances PHP via Composer.
```
composer install
```

### 3. Configuration de l’environnement
Configurer les variables d’environnement, notamment la connexion à la base de données, dans le fichier `.env.local`.

Configurer le serveur web local (VirtualHost) qui pointe directement sur le dossier `public/` de Symfony : 
- Ajouter une entrée au fichier `C:\Windows\System32\drivers\etc\hosts` : `127.0.0.1   viteetgourmand.local`
- Ajouter le VirtualHost à la configuration d'Apache

### 4. Base de données
Exécuter le script pour créer la base de données et insérer les données nécessaires au bon fonctionnement. 
```
mysql -u jchiarotti -p < C:/www/STUDI/EXAMEN/ECF/ViteEtGourmand/database/script/init_prod_db.sql
```

### 5. Lancement de l’application
Démarrer le serveur web local et accéder à l’application via un navigateur.
```
http://viteetgourmand.local/
```

---

## Sécurité

- Les informations sensibles ne sont pas versionnées
- Les accès sont protégés par le système de sécurité Symfony
- Les requêtes sont sécurisées via le composant PDO

---

# Déploiement
L’application est conçue pour être déployée sur un serveur Windows avec :
- Apache
- PHP
- MariaDB

---

## Auteur
Chiarotti Julien

Projet réalisé dans le cadre de l’ECF Studi - Graduate Développeur PHP/Symfony - 2025/2026
