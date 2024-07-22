<?php

require"/../lib/session.php";
require"/../lib/pdo.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Insère l'avis en bdd pour que l'employé le récupère sur sa page
        if(isset($_POST['submit_review'])) {
            
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ((!empty($name)) && (!empty($comment))) {
                $sql = "INSERT INTO reviews (name, comment, validate) VALUES (?, ?, 0)";
                try{
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$name, $comment]);
                    $_SESSION['message'] = "Votre avis a bien été envoyé. Merci de votre contribution !";
                } catch(Exception $e){
                        $_SESSION['error'] = "Nous avons rencontré un problème. Merci de recommencer ultérieurement.";
                }
            }
            header('Location: index.php#review');
            exit();
        }
        // Vérification du role
        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employe') {
            header('Location: index.php');
            exit();
            // Validation / Invalidation par l'employé
            if(isset($_POST['action'])) {
                $id = filter_input(INPUT_POST,'id', FILTER_VALIDATE_INT);
                $action = $_POST['action'];
                
                if ($action === 'validate') {
                    $status = 1;
                } elseif ($action === 'invalidate') {
                    $status = 2;
                }
                
                if (!empty($id)) {
                    $sql = "UPDATE reviews SET validate = ? WHERE id = ?";
                    try {
                        $stmt = $pdo->prepare($sql);
                        
                        $stmt->execute([$status, $id]);
                        $_SESSION['message'] = "L'avis a bien été traité";
                    } catch(Exception $e){
                        $_SESSION['error'] = "Erreur lors du traitement de l'avis.";
                    }
                }
            header('Location: employe.php');
            exit();
            }
        }
    } else {
    die("Token CSRF invalide.");
    }
}
require "/template/header.php";