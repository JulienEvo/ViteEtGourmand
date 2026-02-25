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

- Back-end : **PHP 8.2**
- Framework : **Symfony** (repositories / templates twig / contrôleurs)
- Front-end : **HTML** / **CSS** / **JavaScript**
- Gestionnaire de dépendances : **Composer**
- Serveur web : **Apache**
- SGBD : **MariaDB** (MySQL)
- Base NoSQL : **MongoDB**
- Gestion de versions : **Git**
- Containerisation : **Docker / Docker Compose**

---

## Installation local avec Docker

Le projet **Vite & Gourmand** est entièrement containérisé avec Docker afin de :
- Garantir un environnement identique pour toutes installations
- Éviter les conflits de versions (PHP, MariaDB, MongoDB)
- Simplifier l'installation
- Centraliser tous les services via `docker-compose`

### Architecture des services
- Service : `app` (Symfony, PHP, Apache) - port : 8000
- Service : `database` (Base de données MariaDB) - port : 3306
- Service : `mongodb` (Base MongoDB) - port : 27017
- Service : `mailer` (MailHog) - port : 8025

### 1. Installation du projet

#### Prérequis
- Docker
- Docker Compose

#### Cloner le dépot
``` bash 
  git clone https://github.com/JulienEvo/ViteEtGourmand.git
```
Et on se place dans le dossier du projet :
``` bash 
  cd vite-et-gourmand
```

#### Lancer les conteneurs
``` bash 
  docker compose up -d --build
```
Cette commande :
- Construit l'image PHP
- Démarre MariaDB
- Démarre MongoDB
- Démarre MailHog
- Monte le volume du projet dans `/var/www`

#### Lancer les dépendances Symfony
``` bash 
  docker compose exec app composer install
```

### 2. Configuration des variables d'environnement
Configurer les variables d’environnement dans le fichier `.env.local` à la racine du projet.

```
APP_ENV=dev
APP_DEBUG=1
DATABASE_URL="mysql://user:password@database:3306/vite_et_gourmand?serverVersion=mariadb-10.11"
DATABASE_USER="user"
DATABASE_PASSWORD="password"
MONGODB_URL=mongodb://mongodb:27017/vite_gourmand_mongo
```
`database` et `mongodb` correspondent aux noms des services Docker

### 3. Base de données
Exécuter le script pour créer la base de données et insérer les données nécessaires au bon fonctionnement. 
``` bash
  docker compose exec -T database mysql -u user -p < script/init_dev_db.sql
```

### 4. Accès aux services
```
  http://localhost:8000
```

### 5. Arrêter l'environnement
``` bash
  docker compose down
```
Avec l'option `-v` pour supprimer les volumes (reset de la base de données)

### 6. Conclusion
Docker est une solution simple, efficace et professionnelle pour installer et configurer un environnement de travail sain et fonctionnel.

---

## Sécurité

- Les informations sensibles ne sont pas versionnées
- Les accès sont protégés par le système de sécurité Symfony (rôles)
- Protection CSRF sur les formulaires eet validation des données

---

## Déploiement

Le site est déployé sur un serveur distant via **AlwaysData**.

- Hébergement PHP
- Base de données relationnelle **MariaDB**
- Base de données non relationnelle **MongoDB** (installé manuellement)
- Accès distant via **SFTP**
- Domaine public fourni par l’hébergeur

---

## Comptes de tests

Administrateur
- Email : jose@vite-et-gourmand.fr
- Mot de passe : ViteEtGourmand123+

Employé
- Email : employe1@vite-et-gourmand.fr
- Mot de passe : ViteEtGourmand123+

Utilisateur
- Email : utilisateur1@studi.fr
- Mot de passe : Utilisateur123+

---

## Accès au site de production

URL du site : https://vite-et-gourmand.alwaysdata.net/

---

## Auteur
Chiarotti Julien

Projet réalisé dans le cadre de l’ECF Studi - Graduate Développeur PHP/Symfony - 2025/2026
