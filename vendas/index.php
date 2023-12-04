<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['login'])){
       header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.php" media="screen">
    <title>Vendas Realizadas</title>
</head>
<body>
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="../"><?php echo $_SESSION['fantasia']; ?></a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-targe t="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="../logout.php">Sair</a>
                </div>
            </div>
        </header>
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./vendas">
                                    Vendas Realizadas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../produtos">
                                    Produtos
                                </a>
                            </li>
                        </ul>
                        <div class="navbar-nav-responsive">
                            <div class="nav-item text-nowrap">
                                <a class="nav-link px-3" href="./logout.php">Sair</a>
                            </div>
                        </div>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Vendas Realizadas</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <form method="post" action="">
                                <div class="col">
                                    <input type="date" name="date-inicial" value="<?php echo $datainicial; ?>" class="input-date-initial m-1"><input type="date" name="date-final" value="<?php echo $datafinal; ?>" class="input-date-initial m-1"><button type="submit" class="btn btn-sm btn-outline-secondary btn-enviar">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-light">
                        <thead>
                            <tr>
                                <th scope="col">Sequência</th>
                                <th scope="col">Data</th>
                                <th scope="col">Total Produtos</th>
                                <th scope="col">Desconto</th>
                                <th scope="col">Total Final</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                            include('../conexao.php');
                            $empresa = $_SESSION['filial'];
                            if(isset($_POST['date-inicial']) and isset($_POST['date-final'])){
                                $datainicial = $_POST['date-inicial'];
                                $datafinal = $_POST['date-final'];  
                                $result = mysqli_query($con, "SELECT * FROM Vendas WHERE FILIAL = {$empresa} and DATA BETWEEN '{$datainicial}' AND '{$datafinal}'");
                                while($exibe = mysqli_fetch_assoc($result)){
                                    $dataoriginal = $exibe['Data'];
                                    $timestamp = strtotime($dataoriginal);
                                    $novaData = date("d/m/Y", $timestamp);
                                    echo "
                                    <tr>
                                        <td>".$exibe['Sequencia']."</td>
                                        <td>".$novaData."</td>
                                        <td> R$ ".number_format($exibe['Total_Produtos'], 2, ',', '.')."</td>
                                        <td> R$ ".number_format($exibe['Total_Desconto'], 2, ',', '.')."</td>
                                        <td> R$ ".number_format($exibe['Total_Final'], 2, ',', '.')."</td>
                                    </tr>
                                    ";
                                }
                            } else {
                                $datainicial = 'CURRENT_DATE';
                                $datafinal = 'CURRENT_DATE';
                                $result = mysqli_query($con, "SELECT * FROM Vendas WHERE FILIAL = {$empresa} and DATA BETWEEN {$datainicial} AND {$datafinal}");
                                while($exibe = mysqli_fetch_assoc($result)){
                                    $dataoriginal = $exibe['Data'];
                                    $timestamp = strtotime($dataoriginal);
                                    $novaData = date("d/m/Y", $timestamp);
                                    echo "
                                    <tr>
                                        <td>".$exibe['Sequencia']."</td>
                                        <td>".$novaData."</td>
                                        <td> R$ ".number_format($exibe['Total_Produtos'], 2, ',', '.')."</td>
                                        <td> R$ ".number_format($exibe['Total_Desconto'], 2, ',', '.')."</td>
                                        <td> R$ ".number_format($exibe['Total_Final'], 2, ',', '.')."</td>
                                    </tr>
                                    ";
                                }
                            }
                           ?>
                        </tbody>
                        <?php 
                                if(isset($_POST['date-inicial']) and isset($_POST['date-final'])){
                                    $datainicial = $_POST['date-inicial'];
                                    $datafinal = $_POST['date-final'];  
                                    $result = mysqli_query($con, "SELECT SUM(Total_Final) as Valor FROM Vendas WHERE FILIAL = {$empresa} and DATA BETWEEN '{$datainicial}' AND '{$datafinal}'");
                                    while($exibe = mysqli_fetch_assoc($result)){
                                        $valor = number_format($exibe['Valor'], 2, ',', '.');
                                        
                                    }
                                } else {
                                    $datainicial = 'CURRENT_DATE';
                                    $datafinal = 'CURRENT_DATE';
                                    $result = mysqli_query($con, "SELECT SUM(Total_Final) as Valor FROM Vendas WHERE FILIAL = {$empresa} and DATA BETWEEN {$datainicial} AND {$datafinal}");
                                    while($exibe = mysqli_fetch_assoc($result)){
                                        $valor = number_format($exibe['Valor'], 2, ',', '.');
                                    }
                                }
                        
                        
                        ?>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total de Vendas:</b></td>
                                <td><b>R$ <?php echo $valor; ?></b></td>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </main>
            </body>
</html>