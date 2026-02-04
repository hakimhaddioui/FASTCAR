# FastCar Location - Système de Gestion de Location de Voitures

Application web pour la gestion d'une agence de location de voitures, développée en PHP avec une architecture MVC.

## 🖼️ Aperçu de l’Application

| Tableau de Bord | Gestion des Voitures |
|-----------------|----------------------|
| ![](assets/screenshots/image1.jfif) | ![](assets/screenshots/image2.jfif) |

| Gestion des Contrats  |  Détail du contrats | 
|-----------------------|---------------------|
| ![](assets/screenshots/image3.jfif) | ![](assets/screenshots/image4.jfif) |

| Exemple de Facture |
|--------------------|
| ![](assets/screenshots/image5.jfif) |


## 🚀 Fonctionnalités

### Gestion des Entités
- ✅ **Gestion des Voitures** : Ajouter, modifier, supprimer et consulter les véhicules
- ✅ **Gestion des Clients** : Gestion complète de la base de clients
- ✅ **Gestion des Agents** : Gestion du personnel
- ✅ **Gestion des Contrats** : Création, modification, suppression et consultation des contrats de location

### Fonctionnalités Avancées
- ✅ **Recherche Globale** : Recherche dans tous les modules (voitures, clients, agents, contrats)
- ✅ **Analyse & Synthèse** : Tableaux de bord avec graphiques interactifs (Chart.js)
  - Statistiques générales
  - Revenus par mois
  - Locations par mois
  - Top clients et voitures
  - Analyse des agents
- ✅ **Génération de Factures** : Impression de factures au format HTML (prêt pour PDF)
- ✅ **Authentification** : Système de connexion/inscription sécurisé
- ✅ **Paramètres Personnalisables** : Thèmes, couleurs, informations entreprise

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx) ou PHP built-in server
- Extension PDO MySQL activée

## 🔧 Installation

### 1. Cloner ou télécharger le projet

```bash
cd location
```

### 2. Configuration de la base de données

1. Créer une base de données MySQL :
```sql
CREATE DATABASE fastcar_location_version_2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Importer le schéma de base de données :
```bash
mysql -u root -p fastcar_location_version_2 < database.sql
```

Ou via phpMyAdmin, importer le fichier `database.sql`


### 4. Créer un utilisateur administrateur

Après avoir importé la base de données, vous devez créer un utilisateur via l'interface d'inscription ou directement en SQL :

```sql
INSERT INTO users (nom, prenom, email, password) 
VALUES ('Admin', 'System', 'admin@fastcar.ma', '$2y$10$...');
```

### 5. Lancer l'application

#### Avec PHP built-in server :
```bash
php -S localhost:8000
```

#### Avec Apache/Nginx :
Placer le dossier dans le répertoire web de votre serveur (htdocs, www, etc.)

### 6. Accéder à l'application

Ouvrir un navigateur et aller à :
- `http://localhost:8000` (si PHP built-in server)
- `http://localhost/location` (si Apache/Nginx)

## 📁 Structure du Projet

```
location/
├── config/
│   └── database.php          # Configuration de la base de données
│   ├── database.sql          # Schéma de la base de données
├── controllers/              # Contrôleurs MVC
│   ├── AnalyticsController.php
│   ├── AgentController.php
│   ├── AuthController.php
│   ├── ClientController.php
│   ├── ContratController.php
│   ├── FactureController.php
│   ├── ParametresController.php
│   ├── SearchController.php
│   └── VoitureController.php
├── models/
│   ├── entities/            # Entités du modèle
│   │   ├── Agent.php
│   │   ├── Client.php
│   │   ├── Contrat.php
│   │   ├── User.php
│   │   └── Voiture.php
│   ├── repositories/        # Répositories pour l'accès aux données
│   │   ├── AgentRepository.php
│   │   ├── ClientRepository.php
│   │   ├── ContratRepository.php
│   │   ├── UserRepository.php
│   │   └── VoitureRepository.php
│   └── services/           # Services métier
│       ├── FactureService.php
│       └── LocationService.php
├── views/                   # Vues (templates)
│   ├── accueil.php
│   ├── analytics/
│   ├── agents/
│   ├── auth/
│   ├── clients/
│   ├── contrats/
│   ├── factures/
│   ├── layouts/
│   ├── parametres/
│   ├── search/
│   └── voitures/
├── assets/                  # Ressources statiques (CSS, JS, images)
├── dashboard.php            # Point d'entrée principal (après connexion)
├── index.php               # Point d'entrée (authentification)
└── README.md               # Ce fichier
```

### Informations de l'Entreprise

Modifier les informations de l'entreprise dans **Paramètres > Entreprise** :
- Nom de l'entreprise
- Adresse du siège social
- Téléphone
- RC, Patente, IF

## 📊 Utilisation

### 1. Connexion

1. Aller sur la page d'accueil
2. Cliquer sur "Se connecter"
3. Entrer les identifiants par défaut 

### 2. Gestion des Voitures

- **Ajouter** : Cliquer sur "Nouvelle Voiture"
- **Modifier** : Cliquer sur l'icône modifier dans la liste
- **Supprimer** : Cliquer sur l'icône supprimer (avec confirmation)

### 3. Créer un Contrat

1. Aller dans "Gérer les Contrats"
2. Cliquer sur "Nouveau Contrat"
3. Sélectionner le client, le véhicule, les dates
4. Le montant est calculé automatiquement
5. Valider le contrat

### 4. Générer une Facture

1. Aller dans "Imprimer une Facture"
2. Sélectionner un contrat
3. Cliquer sur "Imprimer"
4. La facture s'ouvre dans un nouvel onglet (prêt pour impression PDF)

### 5. Recherche

1. Aller dans "Recherche"
2. Entrer un terme de recherche
3. Filtrer par type si nécessaire
4. Consulter les résultats

### 6. Analyse & Synthèse

1. Aller dans "Analyse & Synthèse"
2. Consulter les statistiques et graphiques
3. Exporter les données si nécessaire

## 🛠️ Technologies Utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript
- **Framework CSS** : Bootstrap 5.3
- **Icônes** : Boxicons
- **Graphiques** : Chart.js 4.4
- **Architecture** : MVC (Model-View-Controller)

## 📄 Licence

Ce projet est sous licence MIT © 2026 **Hakim HADDIOUI**.


---
