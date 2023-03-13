<?php
    $con = mysqli_connect(getenv("CONNECTION"), getenv("USER_ROOT"), getenv("PASSWORD"), getenv("DATABASE"));

    if (!$con){
        echo "Erro de acesso ao banco de dados!";
    } else {
        // Faz Nada.
    }
?>