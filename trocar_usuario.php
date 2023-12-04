<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cnpj'])) {
        $cnpj = $_POST['cnpj'];
        error_log('Arquivo PHP chamado. CNPJ: ' . $cnpj);

        if (trocarUsuario($cnpj)) {
            echo 'success';
        } else {
            echo 'failure';
        }
    } else {
        echo 'Invalid request';
    }
?>

