-- Base de données pour FastCar Location
-- Gestion d'une Agence de Location de Voitures
CREATE DATABASE IF NOT EXISTS fastcar_location_version_2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fastcar_location_version_2;

-- Table des utilisateurs (pour l'authentification)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    theme VARCHAR(20) DEFAULT 'light',
    primary_color VARCHAR(20) DEFAULT 'blue',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des agents
CREATE TABLE IF NOT EXISTS agents (
    num_agent VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nom (nom),
    INDEX idx_prenom (prenom)
);

-- Table des clients
CREATE TABLE IF NOT EXISTS clients (
    cin VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    adresse TEXT NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nom (nom),
    INDEX idx_email (email),
    INDEX idx_telephone (telephone)
);

-- Table des voitures
CREATE TABLE IF NOT EXISTS voitures (
    matricule VARCHAR(50) PRIMARY KEY,
    marque VARCHAR(100) NOT NULL,
    modele VARCHAR(100) NOT NULL,
    prix_journalier DECIMAL(10, 2) NOT NULL,
    etat_courant ENUM('Disponible', 'Louée', 'En maintenance') DEFAULT 'Disponible',
    kilometrage_actuel INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_marque (marque),
    INDEX idx_etat (etat_courant)
);

-- Table des contrats de location
CREATE TABLE IF NOT EXISTS contrats (
    num_contrat VARCHAR(100) PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    montant_total DECIMAL(10, 2) NOT NULL,
    mode_paiement ENUM('Espèce', 'Carte', 'Virement') DEFAULT 'Espèce',
    kilometrage_location INT DEFAULT 0,
    etat_vehicule_location VARCHAR(255) DEFAULT 'Très bon état',
    cin_client VARCHAR(50) NOT NULL,
    matricule_vehicule VARCHAR(50) NOT NULL,
    num_agent VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cin_client) REFERENCES clients(cin) ON DELETE RESTRICT,
    FOREIGN KEY (matricule_vehicule) REFERENCES voitures(matricule) ON DELETE RESTRICT,
    FOREIGN KEY (num_agent) REFERENCES agents(num_agent) ON DELETE RESTRICT,
    INDEX idx_date_debut (date_debut),
    INDEX idx_date_fin (date_fin),
    INDEX idx_cin_client (cin_client),
    INDEX idx_matricule_vehicule (matricule_vehicule),
    INDEX idx_num_agent (num_agent)
);

-- Table des paramètres de l'entreprise
CREATE TABLE IF NOT EXISTS parametres_entreprise (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_entreprise VARCHAR(255) DEFAULT 'FastCar Location',
    adresse_siege TEXT DEFAULT 'Bd Mohammed V, Casablanca',
    telephone VARCHAR(20) DEFAULT '05 22 33 44 55',
    rc VARCHAR(50) DEFAULT '123456',
    patente VARCHAR(50) DEFAULT '78901234',
    if_field VARCHAR(50) DEFAULT '98765432',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertion des données initiales
INSERT INTO parametres_entreprise (nom_entreprise, adresse_siege, telephone, rc, patente, if_field) 
VALUES ('FastCar Location', 'Bd Mohammed V, Casablanca', '05 22 33 44 55', '123456', '78901234', '98765432');

-- Insertion d'un utilisateur par défaut Admin
INSERT INTO users (nom, prenom, email, password, role, theme, primary_color) VALUES 
('Admin', 'System', 'admin@fastcar.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'dark', 'blue');

-- Insertion des AGENTS
INSERT INTO agents (num_agent, nom, prenom) VALUES 
('AG-2024-001', 'BENSAID', 'Amina'),
('AG-2025-002', 'ALAOUI', 'Mehdi'),
('AG-2025-004', 'EL FASSI', 'Youssef');

-- Insertion des CLIENTS
INSERT INTO clients (cin, nom, prenom, adresse, telephone, email) VALUES 
('AB123456', 'EL FADLI', 'Karim', '24, Avenue Hassan II, Casablanca', '0612-345678', 'karim.elfadli@gmail.com'),
('CD789012', 'ALAMI', 'Samira', '15, Rue Mohammed V, Rabat', '0623-456789', 'samira.alami@gmail.com'),
('EF345678', 'BENNOUNA', 'Ahmed', '45, Boulevard Zerktouni, Marrakech', '0634-567890', 'ahmed.bennouna@gmail.com'),
('GH901234', 'CHAFIK', 'Leila', '78, Avenue des FAR, Tanger', '0645-678901', 'leila.chafik@gmail.com'),
('IJ567890', 'MOUTAOUAKIL', 'Hassan', '33, Rue Palestine, Agadir', '0656-789012', 'hassan.moutaouakil@outlook.com'),
('KL123456', 'RAHALI', 'Nadia', '12, Rue Ghazali, Fès', '0667-890123', 'nadia.rahali@gmail.com'),
('MN789012', 'ZEROUAL', 'Omar', '56, Avenue Mohammed VI, Meknès', '0678-901234', 'omar.zeroual@gmail.com'),
('OP345678', 'TAZI', 'Sofia', '89, Boulevard Hassan I, Oujda', '0689-012345', 'sofia.tazi@gmail.com'),
('QR901234', 'BELKHAYAT', 'Mehdi', '22, Rue Ibn Sina, Tétouan', '0690-123456', 'mehdi.belkhayat@gmail.com'),
('ST567890', 'LAMRANI', 'Fatima', '67, Avenue Al Massira, Safi', '0601-234567', 'fatima.lamrani@outlook.com');

-- Insertion des VOITURES
INSERT INTO voitures (matricule, marque, modele, prix_journalier, etat_courant, kilometrage_actuel) VALUES 
('12345-A-26', 'Dacia', 'Sandero Stepway', 280.00, 'Disponible', 32850),
('23456-B-26', 'Renault', 'Clio V', 300.00, 'Louée', 24500),
('34567-A-26', 'Peugeot', '208', 300.00, 'Disponible', 18700),
('45678-B-26', 'Hyundai', 'i20', 300.00, 'En maintenance', 41200),
('56789-E-34', 'Toyota', 'Yaris', 350.00, 'Disponible', 15600),
('67890-F-56', 'Volkswagen', 'Golf 8', 400.00, 'Disponible', 28900),
('78901-G-78', 'Mercedes', 'Classe A', 600.00, 'Disponible', 12500),
('34007-A-26', 'Volkswagen', 'Tiguan', 800.00, 'Disponible', 16500),
('32067-A-26', 'Volkswagen', 'Touareg', 1000.00, 'Disponible', 10000);
