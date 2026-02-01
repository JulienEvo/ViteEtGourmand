# Vite & Gourmand

## Présentation du projet

« Vite & Gourmand » est une entreprise constituée de deux personnes, Julie et José. Elle existe
depuis 25 ans à Bordeaux, et propose leurs prestations pour tous types d'événements (simple repas
comme Noel ou encore Pâques) au travers de menus en constante évolution.

Cette application web et web mobile dynamique développé en PHP avec le framework Symfony permet la visualisation et la consultation de menus pour des visiteurs qui pourront s'inscrire et se connecter 
en tant qu'utilisateurs afin d'effectuer des commandes de menus faits maison, livrées à domicile, et de gérer leurs informations via leur espace.

Les administrateurs et employés pourront, via cette application, gérer les menus, les plats, les commandes ainsi que les avis envoyés par 
des clients.

## Technologies utilisées

- Langage : **PHP 8.2**
- Framework : **Symfony** (reposytory / templates twig / contrôleurs)
- Gestionnaire de dépendances : **Composer**
- Serveur web : **Apache**
- SGBD : **MariaDB** (MySQL)
- **HTML** / **CSS** / **JavaScript**
- Gestion de versions : **Git**

---

## Installation

### 1. Récupération du projet
Cloner le dépôt Git sur la machine locale.
``` bash 
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

## Déploiement

Le site est déployé sur un serveur distant via **AlwaysData**.

- Hébergement PHP
- Base de données **MariaDB**
- Accès distant via **SSH/SFTP**
- Domaine public fourni par l’hébergeur

---

## Comptes de test

Administrateur
- Email : admin@test.fr
- Mot de passe : Admin123+

Employé
- Email : employe@test.fr
- Mot de passe : Employe123+

Utilisateur
- Email : utilisateur@test.fr
- Mot de passe : Utilisateur123+

---

## Accès au site de production

URL du site : https://vite-et-gourmand.alwaysdata.net/

---

## Auteur
Chiarotti Julien

Projet réalisé dans le cadre de l’ECF Studi - Graduate Développeur PHP/Symfony - 2025/2026
