<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.php" media="screen">
    <title>Login: Gestor Web</title>
</head>
<body> 
    <div class="container">
        <div class="arealogin">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Cnpj</label>
                    <input type="text" name="cnpj" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Senha</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="text-center">
                    <button type="submit" name="enviar" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>       
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
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>