<?php
    function link_random_part($length = 13): string {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $length);
    }

    function login(string $name, string $mdp) {
        
    }

    function register(string $name, string $mdp) {
        $link = $name.'-'.link_random_part();
        
        login($name, $mdp);
    }

    if (isset($_POST["Connexion_Test"]) || (isset($_POST["Inscription_Test"]))) {
    // Vérification du passage par la page de connexion

        if (isset($_POST["Connexion_Test"])) {
            $name = $_POST["id_conx"];
            $mdp = $_POST["mdp_conx"];
            
            

        } else {
            $name = $_POST["id_inscr"];
            $mdp = $_POST["mdp_inscr"];
            $conf_mdp = $_POST["conf_mdp_inscr"];

            register($name, $mdp);
            
        }

    } else {
        // Si l'utilisateur a réussi à accéder à la page sans cliquer sur le bouton
        echo "Erreur : Vous n'avez pas la permission d'accès à cette page";
    }
?>