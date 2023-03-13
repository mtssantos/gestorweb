<?php
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
        
    $con = mysqli_connect($_ENV["CONNECTION"], $_ENV["USER_ROOT"], $_ENV["PASSWORD"], $_ENV["DATABASE"]);

    if (!$con){
        echo "Erro de acesso ao banco de dados!";
    } else {
        // Faz Nada.
    }
?>