<?php
    // use DevCoder/DotEnv;

    // (new DotEnv(__DIR__ . '/.env'))->load();

    $ini = parse_ini_file('.user.ini', true);

    $con = mysqli_connect($ini["CONFIGURACAO"]["CONNECTION"], $ini["CONFIGURACAO"]["USER_ROOT"], $ini["CONFIGURACAO"]["PASSWORD"], $ini["CONFIGURACAO"]["DATABASE"]);

    if (!$con){
        echo "Erro de acesso ao banco de dados!";
        echo $ini["CONFIGURACAO"]["CONNECTION"];
        echo $ini["CONFIGURACAO"]["USER_ROOT"];
        echo $ini["CONFIGURACAO"]["PASSWORD"];
        echo $ini["CONFIGURACAO"]["DATABASE"];
    } else {
        // Faz Nada.
    }
?>