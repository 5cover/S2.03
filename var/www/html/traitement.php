<?php
    $db = new mysqli("localhost", "user", "resu", "paolo");

    $db->execute_query("set schema 'users';");

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

    function login(string $name) {
        
    }

    function get_user(string $name): array|null {
        $query = <<<SQL
            select * from _user where name=?
        SQL;
        return $db->execute_query($query, [ $name ])->fetch_row();
    }  

    function register(string $name, string $email_address, string $first_name, string $last_name, string $password_hash) {

        $query = <<<SQL
        insert into _user (id, name, email_address, first_name, last_name, password_hash, validated)
        values (?, ?, ?, ?, ?, ?, false);
        SQL;
        
        $result = $mysqli->execute_query($query,
            [
                $name.'-'.link_random_part(), // id
                $name,
                $email_address,
                $first_name,
                $last_name,
                $password_hash
            ]);

        syslog(LOG_INFO, "register user $name: $result");
        
        login($name);
    }

    if (isset($_POST["Connexion_Test"]) || (isset($_POST["Inscription_Test"]))) {
    // Vérification du passage par la page de connexion

        if (isset($_POST["Connexion_Test"])) {
            $name = $_POST["id_conx"];
            $mdp = $_POST["mdp_conx"];
            
            if (password_verify($_POST["conf_mdp_inscr"], $password_hash)) {
                
            } else {
                // mot de passe incorrect
            }

            $me = get_user($name);
            if ($me === null) {
                // utilisateur non trouvé
            } else {
                
            }

        } else {
            $password_hash = password_hash($_POST["mdp_inscr"]);
            if (!password_verify($_POST["conf_mdp_inscr"], $password_hash)) {
                // erreur: confirmation différente du mdp
            }

            register($_POST["id_inscr"], $_POST["email_inscr"], $_POST["prenom_inscr"], $_POST["nom_inscr"], $password_hash);
        }

    } else {
        // Si l'utilisateur a réussi à accéder à la page sans cliquer sur le bouton
        echo "Erreur : Vous n'avez pas la permission d'accès à cette page";
    }
?>