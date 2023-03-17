<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Login: Gestor Web</title>
</head>
<body>
   <div class="container">
        <h5 class="center-align">Entre para realizar login:</h5>
        <form method="POST" action="login.php">
            <div class="row">
                <div class="input-field col s12">
                    <input id="cnpj" name="cnpj" type="text" class="validate">
                    <label for="cnpj">Cnpj</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" name="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="center-align">
                    <button class="btn waves-effect waves-light btn-large" type="submit" name="enviar">Entrar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
        <?php
    include('conexao.php');
    $loginerro = " ";
    if(isset($_POST['enviar'])){
        $cnpj = mysqli_real_escape_string($con, $_POST['cnpj']);
        $password = mysqli_real_escape_string($con, md5($_POST['password']));
        $consulta = mysqli_query($con, "select * from Empresas where cnpj = '$cnpj' and password = '$password'");
        if(mysqli_num_rows($consulta) == 1)  {
            session_start();
            $dados = mysqli_fetch_array($consulta);
            $_SESSION['login'] = $dados['CNPJ'];
            $_SESSION['fantasia'] = $dados['FANTASIA'];
            header('Location: index.php');
            $loginerro = " ";  
            echo $loginerro;   
        } else {
            $loginerro = "<br />
                <div class='container center-align'>
                    <div class='text-center'>
                        Email ou senha inválidos.
                    </div>
                </div>";

            echo $loginerro;
        }
    }
    ?>
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> 
</body>
</html>