# 🔄 Guide d'Intégration Jenkins CI/CD - DRIVADO

## 📋 Table des matières
1. [Introduction](#introduction)
2. [Prérequis](#prérequis)
3. [Création d'une Pipeline Jenkins](#création-dune-pipeline-jenkins)
4. [Configuration du Référentiel GitHub](#configuration-du-référentiel-github)
5. [Configuration du Webhook GitHub](#configuration-du-webhook-github)
6. [Consultation des Résultats de Tests](#consultation-des-résultats-de-tests)
7. [Troubleshooting](#troubleshooting)

---

## 📌 Introduction

Ce guide vous explique comment configurer **Jenkins** pour automatiser les tests et le déploiement du projet DRIVADO à chaque `git push` sur la branche `main`.

Le pipeline Jenkins accomplira les tâches suivantes :
- ✅ Récupère le code source depuis GitHub
- ✅ Installe les dépendances avec Composer
- ✅ Configure l'environnement et génère la clé d'application Laravel
- ✅ Exécute les migrations de base de données sur une base de test SQLite en mémoire
- ✅ Lance les tests unitaires et fonctionnels
- ✅ Génère un rapport de couverture HTML
- ✅ Envoie une notification par email en cas d'échec

---

## 🔧 Prérequis

Avant de configurer Jenkins, assurez-vous que vous disposez de :

### Sur le serveur Jenkins (Windows)
- **Jenkins** 2.387+ installé et en fonctionnement
- **PHP 8.5+** installé et accessible via la ligne de commande (`php --version`)
- **Composer** installé globalement ou dans le répertoire du projet
- **Git** installé et configuré
- **Java Runtime Environment (JRE)** pour exécuter Jenkins

### Accès et Permissions
- Un compte GitHub avec accès au repository
- Un token GitHub (Personal Access Token) pour l'authentification
- Un compte Jenkins avec les permissions d'administrateur pour créer des pipelines

### Plugins Jenkins Recommandés
Installez les plugins suivants via **Manage Jenkins > Manage Plugins > Available** :
- ✅ **GitHub Integration** (github)
- ✅ **GitHub Authentication Plugin** (github-oauth)
- ✅ **Email Extension Plugin** (email-ext)
- ✅ **Pipeline** (workflow-aggregator)
- ✅ **Git Plugin** (git)

---

## 🏗️ Création d'une Pipeline Jenkins

### Étape 1 : Accéder à Jenkins
1. Ouvrez votre navigateur et allez sur `http://localhost:8080` (ou l'adresse de votre serveur Jenkins)
2. Connectez-vous avec vos identifiants

### Étape 2 : Créer une Nouvelle Tâche
1. Cliquez sur **"Nouvelle Tâche"** (ou **"New Item"** en anglais)
2. Donnez un nom à votre tâche : `DRIVADO-CI-CD` ou `DRIVADO-Pipeline`
3. Sélectionnez le type **"Pipeline"**
4. Cliquez sur **"OK"**

### Étape 3 : Configurer la Pipeline

#### Section : Général
- ✅ **Nom** : `DRIVADO-CI-CD`
- ✅ **Description** : `Pipeline CI/CD pour le projet DRIVADO - Laravel 12 Marketplace`
- ✅ Cochez "GitHub project" et entrez l'URL de votre repository :
  ```
  https://github.com/YOUR_USERNAME/drivado
  ```

#### Section : Triggers de Build (Déclencheurs)
1. Cochez **"GitHub hook trigger for GITScm polling"**
   - Cela permettra à Jenkins de se déclencher automatiquement via le webhook GitHub
2. *(Optionnel)* Vous pouvez aussi ajouter un trigger de polling : 
   - Cochez **"Poll SCM"** et entrez `H/15 * * * *` pour vérifier toutes les 15 minutes

#### Section : Définition de Pipeline
Sélectionnez l'option **"Pipeline script from SCM"** :
- **SCM** : `Git`
- **URL du Repository** : 
  ```
  https://github.com/YOUR_USERNAME/drivado.git
  ```
- **Credentials** : 
  - Cliquez sur **"Add" > "Jenkins"**
  - Sélectionnez **"Username with password"** ou **"SSH Key"**
  - Entrez vos identifiants GitHub
  - Cliquez sur **"Add"**
  - Puis sélectionnez-les dans la liste déroulante
- **Branche à construire** : `*/main`
- **Chemin du script** : `Jenkinsfile` (c'est le chemin par défaut)

### Étape 4 : Configuration Avancée (Optionnel)

#### Options de Construction
- **Timeout de build** : 30 minutes
- **Supprimer les anciens builds** : 10 derniers builds

#### E-mails de Notification
Allez dans **Configure > Post-build Actions > Add post-build action > Email Notification** :
- **Destinataires** : votre adresse email
- Cochez "Send e-mail for every unsuccessful build"

### Étape 5 : Sauvegarde
Cliquez sur **"Enregistrer"** ou **"Save"** pour finir la configuration

---

## 🔗 Configuration du Référentiel GitHub

### Étape 1 : Préparer le Repository
Assurez-vous que le fichier `Jenkinsfile` se trouve à la racine de votre repository :
```
drivado/
├── Jenkinsfile          ✅ (fichier de configuration de pipeline)
├── .env.example
├── composer.json
├── phpunit.xml
└── ...
```

### Étape 2 : Créer un Personal Access Token (PAT) GitHub
1. Allez sur **GitHub > Settings > Developer settings > Personal access tokens**
2. Cliquez sur **"Tokens (classic)"** ou **"Generate new token"**
3. Donnez un nom au token : `Jenkins-DRIVADO-CI`
4. Sélectionnez les scopes suivants :
   - ✅ `repo` (accès complet au repository)
   - ✅ `admin:repo_hook` (gestion des webhooks)
5. Cliquez sur **"Generate token"**
6. **Copiez le token** (vous ne pourrez plus le voir après)

### Étape 3 : Configurer l'Authentification GitHub dans Jenkins
1. Allez dans **Jenkins > Manage Jenkins > Credentials**
2. Cliquez sur le domaine **"(global)"**
3. Cliquez sur **"Add Credentials"** (en haut à gauche)
4. Remplissez les champs :
   - **Kind** : "Username with password"
   - **Username** : votre nom d'utilisateur GitHub
   - **Password** : le Personal Access Token que vous avez copié
   - **ID** : `github-pat-drivado`
   - **Description** : `GitHub Personal Access Token for DRIVADO`
5. Cliquez sur **"Create"**

---

## 🔔 Configuration du Webhook GitHub

### Étape 1 : Accéder aux Paramètres du Webhook
1. Allez sur votre repository GitHub
2. Cliquez sur **Settings > Webhooks**
3. Cliquez sur **"Add webhook"**

### Étape 2 : Configurer le Webhook
Remplissez les champs avec les informations suivantes :

| Champ | Valeur |
|-------|--------|
| **Payload URL** | `http://JENKINS_SERVER:8080/github-webhook/` |
| **Content type** | `application/json` |
| **Secret** | *(laisser vide, optionnel)* |
| **SSL verification** | Active |

> **⚠️ Important** : Remplacez `JENKINS_SERVER` par l'adresse IP ou le domaine de votre serveur Jenkins
> 
> Exemples :
> - Local : `http://localhost:8080/github-webhook/`
> - Serveur distant : `http://192.168.1.100:8080/github-webhook/`
> - Domaine : `http://jenkins.example.com:8080/github-webhook/`

### Étape 3 : Sélectionner les Événements
Sélectionnez **"Let me select individual events"** et cochez :
- ✅ **Push events** (déclenche la pipeline à chaque push)
- ✅ **Pull requests** *(optionnel)*

### Étape 4 : Activer le Webhook
Cochez **"Active"** et cliquez sur **"Add webhook"**

### Étape 5 : Vérifier la Connexion
GitHub enverra un test de ping à Jenkins. Allez dans les détails du webhook et vérifiez que le dernier envoi a reçu une réponse `200 OK`.

---

## 📊 Consultation des Résultats de Tests

### Vue d'ensemble de la Build
1. Allez sur la page d'accueil de Jenkins
2. Cliquez sur votre pipeline **"DRIVADO-CI-CD"**
3. Vous verrez l'historique des builds avec leurs statuts :
   - 🟢 **Succès** : Tous les tests sont passés
   - 🟡 **Instable** : Des tests ont échoué, voir les logs
   - 🔴 **Échec** : La pipeline a échoué

### Détails d'une Build
1. Cliquez sur le numéro de la build (ex: `#42`)
2. Vous verrez :
   - **Build Status** : L'état global
   - **Console Output** : Les logs complets
   - **Test Results** : Résumé des tests
   - **HTML Report** : *(si généré)* Le rapport de couverture

### Logs et Output
- Cliquez sur **"Console Output"** pour voir le flux complet d'exécution
- Recherchez les sections marquées avec des séparateurs `==========`
- Chaque stage est clairement identifié :
  - `Checkout`
  - `Environment Setup`
  - `Dependencies`
  - `Key Generation`
  - `Database Migration`
  - `Tests`
  - `Test Report`

### Rapport de Couverture (HTML)
Après un build réussi :
1. Les rapports HTML sont générés dans `build/coverage/`
2. Vous pouvez les télécharger depuis Jenkins
3. Ouvrez le fichier `index.html` pour voir la couverture de code détaillée

### Notifications par Email
- Si vous avez configuré les notifications, vous recevrez un email :
  - 📧 **À la réussite** : ✅ BUILD PASSED
  - 📧 **À l'instabilité** : ⚠️ BUILD UNSTABLE
  - 📧 **À l'échec** : ❌ BUILD FAILED

---

## 🚀 Exécuter Manuellement la Pipeline

Vous pouvez également déclencher une build manuellement :
1. Allez sur la page de la pipeline
2. Cliquez sur **"Build Now"** ou **"Lancer un build"**
3. Consultez les logs en direct en cliquant sur le numéro de build

---

## ⚙️ Troubleshooting

### Problème : Le webhook GitHub ne déclenche pas la pipeline

**Solutions** :
1. Vérifiez la **Payload URL** dans les paramètres du webhook
   - Elle doit être accessible de l'extérieur (pas `localhost`)
   - Testez : `curl -X GET http://JENKINS_SERVER:8080/github-webhook/`
2. Vérifiez les **deliveries** dans le webhook GitHub
   - Allez dans GitHub > Webhook > Recent deliveries
   - Regardez les réponses d'erreur
3. Assurez-vous que le plugin **GitHub Integration** est installé
4. Redémarrez Jenkins si vous avez ajouté des plugins

### Problème : Erreur "php: command not found"

**Solutions** :
1. Vérifiez que PHP est installé : `php --version`
2. Ajoutez PHP au `PATH` du système Windows
3. Redémarrez Jenkins après modification du PATH
4. Ou utilisez le chemin absolu dans le Jenkinsfile :
   ```
   C:\php\php.exe artisan test
   ```

### Problème : Erreur lors de la migration de base de données

**Solutions** :
1. Assurez-vous que le `.env` est correctement créé
2. Vérifiez les permissions d'accès au répertoire de travail
3. Consultez les logs de migration dans la console Jenkins
4. Testez localement : `php artisan migrate --env=testing`

### Problème : Les tests échouent dans Jenkins mais réussissent localement

**Solutions** :
1. Vérifiez que l'environnement de test utilise SQLite en mémoire (voir `phpunit.xml`)
2. Assurez-vous que toutes les migrations sont exécutées
3. Vérifiez les variables d'environnement dans `phpunit.xml`
4. Testez avec : `composer test` localement

### Problème : Pas de rapport HTML généré

**Solutions** :
1. Assurez-vous que `phpunit.xml` contient la section `<coverage>`
2. Vérifiez que le répertoire `build/` existe et est accessible en écriture
3. Les rapports HTML sont générés uniquement si la couverture est calculée
4. Consultez les logs pour les erreurs liées à PHPUnit

---

## 📞 Support et Aide Supplémentaire

### Documentation Officielle
- [Jenkins Documentation](https://www.jenkins.io/doc/)
- [GitHub Webhooks Guide](https://docs.github.com/en/developers/webhooks-and-events/webhooks)
- [Laravel Testing Documentation](https://laravel.com/docs/12.x/testing)
- [PHPUnit Documentation](https://phpunit.de/)

### Ressources Utiles
- [Jenkinsfile Guide](https://www.jenkins.io/doc/book/pipeline/jenkinsfile/)
- [GitHub Actions Alternative](https://docs.github.com/en/actions) (si vous préférez GitHub Actions)
- [Docker + Jenkins](https://www.jenkins.io/doc/book/installing/docker/) (pour une expérience plus portable)

---

## 📝 Notes Finales

- Cette pipeline est configurée pour la **branche `main`** uniquement
- Tous les tests utilisent une **base de données SQLite en mémoire** pour éviter d'affecter la base de données réelle
- Les notifications par email nécessitent une **configuration SMTP** dans Jenkins
- Les logs sont conservés pendant 10 builds (configurable)
- Le timeout de build est fixé à 30 minutes

Pour des questions supplémentaires ou des problèmes, consultez les logs détaillés dans la console Jenkins ou contactez l'équipe DevOps.

---

**Version** : 1.0  
**Dernière mise à jour** : Juin 2026  
**Projet** : DRIVADO - Plateforme Premium de Location de Voitures  
**Stack** : Laravel 12, PHP 8.5+, Windows
