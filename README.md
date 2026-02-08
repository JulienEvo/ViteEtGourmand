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

``` bash
  composer install
```

### 3. Configuration de l’environnement
Configurer les variables d’environnement, notamment la connexion à la base de données, dans le fichier `.env.local`.

```
APP_ENV=dev
APP_DEBUG=1
DATABASE_URL="mysql://user:password@236@127.0.0.1:3306/vite_et_gourmand?serverVersion=mariadb-10.11"
DATABASE_USER="user"
DATABASE_PASSWORD="password"
```

Configurer le serveur web local (VirtualHost) qui pointe directement sur le dossier `public/` de Symfony : 
- Ajouter une entrée au fichier `C:\Windows\System32\drivers\etc\hosts` :
```
127.0.0.1   viteetgourmand.local
```
- Ajouter le VirtualHost à la configuration d'Apache dans le fichier `..\apache\conf\extra\vhosts.conf` :
```
  <VirtualHost *:80>
      ServerName viteetgourmand.local
      DocumentRoot "chemin_du_dossier_public"
      <Directory "chemin_du_dossier_public">
          AllowOverride All
          Require all granted
      </Directory>
  </VirtualHost>
```

### 4. Base de données
Exécuter le script pour créer la base de données et insérer les données nécessaires au bon fonctionnement. 
``` bash
  mysql -u user -p < ../ViteEtGourmand/database/script/init_dev_db.sql
```

### 5. Lancement de l’application
Démarrer le serveur web local et accéder à l’application via un navigateur.
```
http://viteetgourmand.local/
```

---

## Mise en place de l'environnement de travail

Pour ce projet, l'environnement de travail a été configuré de manière à permettre un développement local efficace et un 
déploiement sécurisé en production.

### 1. Développement local :
- Serveur : Symfony Server ou VirtualHost Apache pointant vers `public/`
- Justification : assure que les fichiers sensibles restent protégés et que le routage Symfony fonctionne correctement.

### 2. PHP & Composer :
- PHP 8.2
- Composer pour gérer les dépendances
- Justification : compatibilité avec Symfony 6 et les bundles utilisés.

### 3. Base de données :
- MariaDB (MySQL)
- Création via script SQL `CREATE DATABASE IF NOT EXISTS vite_et_gourmand`
- Justification : assure que la base peut être créée même si elle existe déjà, facilitant les tests et réinitialisations.

### 4. Variables d'environnement :
- `.env` : valeurs par défaut commit
- `.env.local` : secrets locaux (APP_SECRET, mot de passe BDD)
- Justification : sécurise les informations sensibles tout en permettant la portabilité entre environnements.

### 5. Déploiement en production :
- Hébergeur : Alwaysdata
- Répertoire racine : `public/`
- Variables d'environnement configurées dans les paramètres avancés
- Justification : permet de déployer le site sans exposer les secrets dans le dépôt Git et en respectant les bonnes pratiques Symfony.

Cet environnement permet de développer, tester et déployer le projet de manière sécurisée, organisée et conforme aux bonnes pratiques.

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
