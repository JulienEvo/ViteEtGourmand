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
- Serveur : Apache avec VirtualHost pointant vers le dossier `public/`
- Objectif recherché : assure que les fichiers sensibles restent protégés et que le routage Symfony fonctionne correctement.

### 2. PHP & Composer :
- PHP 8.2
- Composer pour gérer les dépendances
- Atouts : compatibilité avec Symfony 7.4 et les bundles utilisés.

### 3. Base de données :
- MariaDB (MySQL)
- Création des tables de la base de données et insertions de données fonctionnelles via un script SQL.
- Objectifs recherchés : Avoir une base de données relationnelle performante et fiable, facilement évolutive et reproductible.

### 4. Variables d'environnement :
- `.env` : valeurs par défaut
- `.env.local` : secrets locaux (APP_SECRET, mot de passe BDD)
- Avantages : sécurise les informations sensibles tout en permettant la portabilité entre environnements.

### 5. Déploiement en production :
- Hébergeur : AlwaysData (https://www.alwaysdata.com/fr/)
- Répertoire racine : `public/`
- Variables d'environnement configurées dans les paramètres avancés
- Objectif recherché : permettre de déployer le site sans exposer les informations sensibles dans le dépôt Git en respectant les bonnes pratiques Symfony.

---

## Sécurité

- Les informations sensibles ne sont pas versionnées
- Les accès sont protégés par le système de sécurité Symfony (rôles)
- Les requêtes sont sécurisées via PDO

---

## Déploiement

Le site est déployé sur un serveur distant via **AlwaysData**.

- Hébergement PHP
- Base de données relationnelle **MariaDB**
- Base de données non relationnelle **MongoDB** (non par défaut)
- Accès distant via **SSH/SFTP**
- Domaine public fourni par l’hébergeur

---

## Comptes de tests

Administrateur
- Email : jose@vite-et-gourmand.fr
- Mot de passe : Administrateur123+

Employé
- Email : employe1@vite-et-gourmand.fr
- Mot de passe : Employe123+

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
