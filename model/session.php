<?php
    // SESSION SYSTEM
    session_start();
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: .');
        exit();
    }
    if (isset($_SESSION['character'])) { // IF session exists we restore its stored character
        $character = $_SESSION['character'];
    }