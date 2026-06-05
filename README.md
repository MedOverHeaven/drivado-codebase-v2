# 🚗 DRIVADO - Plateforme Premium de Location de Voitures

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Vite](https://img.shields.io/badge/Vite-7.x-blueviolet.svg)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

**DRIVADO** est une marketplace moderne, élégante et hautement sécurisée conçue pour connecter les agences de location de voitures locales avec des clients exigeants. Développée avec **Laravel 12**, **Vite** et **Bootstrap 5**, elle offre une expérience utilisateur haut de gamme dotée d'une esthétique sombre et d'animations fluides.

---

## 📖 Sommaire
1. [Le Concept DRIVADO](#-le-concept-drivado)
2. [Fonctionnalités Principales](#-fonctionnalités-principales)
3. [Architecture & Stack Technique](#-architecture--stack-technique)
4. [Guide d'Installation](#-guide-dinstallation)
5. [Structure des Comptes de Test](#-structure-des-comptes-de-test)
6. [Documentation Complémentaire](#-documentation-complémentaire)

---

## 💡 Le Concept DRIVADO

Dans le secteur de la location de voitures, les clients et les agences indépendantes font souvent face à des défis majeurs : manque de transparence sur les prix, processus de réservation laborieux et insécurité des transactions.

**DRIVADO** redéfinit cette expérience en proposant :
* **Aux Clients :** Un catalogue exclusif de véhicules géolocalisés, des tarifs 100 % transparents sans frais cachés, et un système de réservation instantané et sécurisé par Stripe.
* **Aux Agences :** Une vitrine digitale clé en main pour numériser leur flotte, toucher des milliers de clients, et gérer leur activité à l'aide d'un tableau de bord professionnel complet.
* **Confiance & Sécurité :** Un système d'approbation administrative strict pour chaque agence partenaire avant la mise en ligne de ses véhicules.

---

## ✨ Fonctionnalités Principales

### 👤 Espace Client
* **Recherche Avancée :** Filtrage multicritères par localisation (ville ou agence), catégorie de véhicule (SUV, Berline, Citadine, Luxe) et budget quotidien.
* **Cartographie Interactive :** Visualisation géographique des véhicules disponibles sur une carte interactive (Leaflet/OpenStreetMap).
* **Tunnel d'Achat Premium :** Réservation rapide avec calcul en temps réel de la durée et du prix total, intégrant les frais de plateforme.
* **Suivi & Sécurité :** E-mail de confirmation détaillé et interface de suivi après paiement sécurisé.

### 🏢 Espace Agence (Partenaire)
* **Candidature en Ligne :** Formulaire d'inscription dédié récoltant les informations légales (ICE/SIRET, nom commercial, ville).
* **Tableau de Bord Dédié :** Outil de gestion des véhicules, suivi des statistiques et revenus (10 % de commission prélevés par la plateforme).
* **Gestion de Flotte :** Ajout, modification et suppression de véhicules avec gestion des options (transmission, climatisation, carburant, etc.).

### 👑 Espace Administration
* **Gestion des Agences :** Interface d'examen des nouvelles agences candidates avec possibilité de validation ou de rejet.
* **Statistiques Globales :** Suivi en temps réel du volume d'affaires, des commissions générées et du nombre total de locations actives.

---

## 🛠️ Architecture & Stack Technique

La plateforme repose sur une architecture moderne assurant d'excellentes performances et une sécurité renforcée.

### 💻 Stack Frontend
* **Moteur de Template :** Laravel Blade (pour un rendu serveur ultra-rapide).
* **Framework CSS :** Bootstrap 5.3 (entièrement personnalisé avec un thème sombre luxueux et des effets de verre dépoli - *Glassmorphic*).
* **Animations :** Animate.css pour des transitions de navigation fluides et élégantes.
* **Cartes interactives :** LeafletJS pour le géoréférencement des flottes partenaires.
* **Compilation des Assets :** Vite 7 (permettant un chargement instantané).

### ⚙️ Stack Backend & Base de données
* **Framework :** Laravel 12.x (PHP 8.2+).
* **Base de données :** MySQL via le fichier `.env`.
* **ORM :** Eloquent avec relations optimisées (`belongsTo`, `hasMany` avec préchargement Eager Loading).
* **Passerelle de Paiement :** Stripe API (mode Sandbox pour les tests de réservation).

### 🛡️ Sécurité & Middleware
* **RoleMiddleware :** Restreint les accès aux zones réservées selon les rôles utilisateurs (`client`, `agency`, `admin`).
* **ApprovedAgencyMiddleware :** Empêche les agences dont le dossier est "en attente" d'accéder au gestionnaire de flotte tant qu'elles ne sont pas validées par l'administrateur.

---

## 🚀 Guide d'Installation

Suivez ces étapes pour lancer l'application en local sur votre environnement de développement :

### 1. Cloner le Projet
```bash
git clone <url-du-depot>
cd drivado-codebase-v2
```

### 2. Configurer l'Environnement
Copiez le fichier `.env.example` vers `.env` et générez la clé de sécurité :
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Installer les Dépendances
Installez les bibliothèques PHP (Composer) et Javascript (NPM) :
```bash
composer install
npm install
```

### 4. Configurer la Base de Données
Avant de lancer Laravel, démarrez **MySQL** depuis le panneau de contrôle **XAMPP**. Créez ensuite une base de données MySQL nommée `drivado`, vérifiez les identifiants dans le fichier `.env`, puis exécutez les migrations et chargez le jeu d'essai (Seeders) :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=drivado
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# Exécuter les migrations et injecter les fausses données
php artisan migrate:fresh --seed
```

### 5. Compiler les Assets & Lancer le Serveur
Lancez le compilateur frontend et démarrez le serveur PHP local :
```bash
# Compiler les assets pour la production
npm run build

# Démarrer le serveur de développement Laravel
php artisan serve
```
L'application sera accessible sur `http://127.0.0.1:8000`.

> Important : à chaque nouvelle session de travail, démarrez MySQL dans XAMPP avant `php artisan serve`, sinon Laravel ne pourra pas se connecter à la base de données.

---

## 🔑 Structure des Comptes de Test

Les données de test pré-générées lors du `--seed` permettent de se connecter immédiatement à tous les types d'espaces :

| Rôle | Adresse E-mail | Mot de passe | Rôle système |
| :--- | :--- | :--- | :--- |
| **Administrateur** | `admin@drivado.com` | `password` | Supervision globale et validation des agences |
| **Agence Partenaire** | `agency1@example.com` | `password` | Gestion de flotte de véhicules (déjà approuvée) |
| **Agence Partenaire** | `agency2@example.com` | `password` | Deuxième agence de test |
| **Client Standard** | `john@example.com` | `password` | Recherche et parcours de réservation classique |
| **Client Standard** | `jane@example.com` | `password` | Deuxième client de test |

---

## Sécurité & Qualité Backend

Les contrôles principaux côté serveur sont les suivants :
* Les mots de passe sont hashés avec Laravel (`Hash` / cast `hashed`).
* Les routes sensibles sont protégées par `auth`, `RoleMiddleware` et `ApprovedAgencyMiddleware`.
* Les formulaires POST/PATCH utilisent les tokens CSRF de Laravel.
* La confirmation de réservation recalcule le prix, la commission, l'agence et la durée côté serveur afin d'éviter la modification des champs cachés.
* La page de succès d'une réservation vérifie que l'utilisateur connecté est bien propriétaire de la réservation, administrateur, ou agence concernée.
* Les tests automatisés vérifient le chargement de l'accueil, la protection contre la modification frauduleuse du prix et l'interdiction de consulter la réservation d'un autre utilisateur.

---

## 📄 Documentation Complémentaire

Pour une plongée en profondeur dans la structure du code source, la cinématique des paiements Stripe, les politiques de routage et le design system de l'application, veuillez consulter notre fichier de documentation technique :

👉 **[DOCUMENTATION.md](./DOCUMENTATION.md)**

---
*Développé dans le cadre du projet académique ENSAO MGSI-3. v1.0 Premium.*
