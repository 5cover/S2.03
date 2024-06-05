<?php

    if (isset($_POST["Connexion_Test"]) || (isset($_POST["Inscription_Test"]))) {
    // Vérification du passage par la page de connexion

        if (isset($_POST["Connexion_Test"])) {
            $email = $_POST["id_conx"];
            $mdp = $_POST["mdp_conx"];
            $conf_mdp = null;
        } else {
            $email = $_POST["id_inscr"];
            $mdp = $_POST["mdp_inscr"];
            $conf_mdp = $_POST["conf_mdp_inscr"];
        }

    } else {
        // Si l'utilisateur a réussi à accéder à la page sans cliquer sur le bouton
        echo "Erreur : Vous n'avez pas la permission d'accès à cette page";
    }
?>