<?php

    // Local
    $username = "root";
    $password = "root";
    $database = "zoo_arcadia";
    $hostname = "localhost";

try 
{
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // Activation des erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // mode de fetch par défaut : FETCH_ASSOC / FETCH_OBJ / FETCH_BOTH
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} 
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}


