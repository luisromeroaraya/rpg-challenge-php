<?php
    try
    {
        $db = new PDO('mysql:host=database;dbname=oopgame;charset=utf8', 'root', 'root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // we show an alert if there is an error
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
?>