<?php
    
    $envs = parse_ini_file('.env');
    $con = mysqli_connect($envs["CONNECTION"], $envs["USER_ROOT"], $envs["PASSWORD"], $envs["DATABASE"]);

    if (!$con){
        echo "Erro de acesso ao banco de dados!";
    } else {
        // Faz Nada.
    }
?>