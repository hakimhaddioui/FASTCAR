<?php
require_once 'models/repositories/ClientRepository.php';

class ClientController {
    private $clientRepo;
    
    public function __construct() {
        $this->clientRepo = new ClientRepository();
    }
    
    public function index() {
        $clients = $this->clientRepo->findAll();
        ob_start();
        require 'views/clients/index.php';
        return ob_get_clean();
    }
    
    public function create() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client = new Client([
                'cin' => trim($_POST['cin'] ?? ''),
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? ''),
                'adresse' => trim($_POST['adresse'] ?? ''),
                'telephone' => trim($_POST['telephone'] ?? ''),
                'email' => trim($_POST['email'] ?? '')
            ]);
            
            // Validation
            if (empty($client->cin)) $errors[] = "Le CIN est obligatoire";
            if (empty($client->nom)) $errors[] = "Le nom est obligatoire";
            if (empty($client->telephone)) $errors[] = "Le téléphone est obligatoire";
            
            if (empty($errors) && $this->clientRepo->save($client)) {
                header('Location: dashboard.php?action=clients&message=success');
                exit;
            } else {
                $errors[] = "Erreur lors de l'ajout du client";
            }
        }
        
        ob_start();
        require 'views/clients/create.php';
        return ob_get_clean();
    }
    
    public function edit($cin) {
        $client = $this->clientRepo->findById($cin);
        $errors = [];
        
        if (!$client) {
            header('Location: dashboard.php?action=clients&error=not_found');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client->nom = trim($_POST['nom'] ?? '');
            $client->prenom = trim($_POST['prenom'] ?? '');
            $client->adresse = trim($_POST['adresse'] ?? '');
            $client->telephone = trim($_POST['telephone'] ?? '');
            $client->email = trim($_POST['email'] ?? '');
            
            if (empty($client->nom)) $errors[] = "Le nom est obligatoire";
            if (empty($client->telephone)) $errors[] = "Le téléphone est obligatoire";
            
            if (empty($errors) && $this->clientRepo->update($client)) {
                header('Location: dashboard.php?action=clients&message=updated');
                exit;
            } else {
                $errors[] = "Erreur lors de la modification";
            }
        }
        
        ob_start();
        require 'views/clients/edit.php';
        return ob_get_clean();
    }
    
    public function delete($cin) {
        if ($this->clientRepo->delete($cin)) {
            header('Location: dashboard.php?action=clients&message=deleted');
            exit;
        } else {
            header('Location: dashboard.php?action=clients&error=delete_failed');
            exit;
        }
    }
}
?>