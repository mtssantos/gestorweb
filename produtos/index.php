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
    <title>Produtos</title>
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
                                <a class="nav-link" href="../vendas">
                                    Vendas Realizadas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./">
                                    Produtos
                                </a>
                            </li>
                        </ul>
                    </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Produtos</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <form method="post" action="">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="radio1" name="optCodigo">
                                        <label class="form-check-label" for="radio1">Código</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="radio2" name="optCodigoEan">
                                        <label class="form-check-label" for="radio2">Código Ean</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="radio3" name="optNome">
                                        <label class="form-check-label" for="radio3">Nome</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="radio4" name="optClasse">
                                        <label class="form-check-label" for="radio4">Classe</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="radio5" name="optGrupo">
                                        <label class="form-check-label" for="radio5">Grupo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" name="campo" />
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-outline-secondary btn-enviar">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-light">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Código Ean</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Classe</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Estoque Atual</th>
                                <th scope="col">P. Custo</th>
                                <th scope="col">P. Venda</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            include('../conexao.php');
                            $empresa = $_SESSION['filial'];
                            if (isset($_POST['campo'])) {
                                $campo = $_POST['campo'];
                                $empresa = mysqli_real_escape_string($con, $empresa);
                                $campo = mysqli_real_escape_string($con, $campo);

                                mysqli_set_charset($con, "utf8");

                                $filtro = "";
                                $opr = "";
                            

                                if (isset($_POST['optCodigo'])) {
                                    $filtro = "Codigo";
                                    $opr = "=";
                                    $campo = intval($campo);
                                } elseif (isset($_POST['optCodigoEan'])) {
                                    $filtro = "Codigo_EAN";
                                    $opr = "LIKE";
                                    $campo = "'" . mysqli_real_escape_string($con, $campo) . "'";
                                } elseif (isset($_POST['optNome'])) {
                                    $filtro = "Nome";
                                    $opr = "LIKE";
                                    $campo = "'%" . mysqli_real_escape_string($con, $campo) . "%'";
                                } elseif (isset($_POST['optClasse'])) {
                                    $filtro = "Classe";
                                    $opr = "LIKE";
                                    $campo = "'%" . mysqli_real_escape_string($con, $campo) . "%'";
                                } elseif (isset($_POST['optGrupo'])) {
                                    $filtro = "Grupo";
                                    $opr = "LIKE";
                                    $campo = "'%" . mysqli_real_escape_string($con, $campo) . "%'";
                                } else {
                                    echo "Nenhuma opção selecionada.";
                                }
                            
                           
                                $query = "SELECT * FROM Estoque WHERE Filial = {$empresa} AND {$filtro} {$opr} {$campo}";                                       
                            
                                $result = mysqli_query($con, $query);
                            
                                if ($result) {
                                    $totalEstoque = 0;
                                    $totalCusto = 0;
                                    $totalVenda = 0;


                                    while($exibe = mysqli_fetch_assoc($result)){
                                        $totalEstoque += $exibe['Estoque_Atual'];
                                        $totalCusto += $exibe['PCusto'] * $exibe['Estoque_Atual'];
                                        $totalVenda += $exibe['PVenda'] * $exibe['Estoque_Atual'];   
                                        echo "
                                            <tr>
                                                <td>".$exibe['Codigo']."</td>
                                                <td>".$exibe['Codigo_EAN']."</td>
                                                <td>".$exibe['Nome']."</td>
                                                <td>".$exibe['Classe']."</td>
                                                <td>".$exibe['Grupo']."</td>
                                                <td>".number_format($exibe['Estoque_Atual'], 0, ',', '.')."</td>
                                                <td>".number_format($exibe['PCusto'], 2, ',', '.')."</td>
                                                <td>".number_format($exibe['PVenda'], 2, ',', '.')."</td>                             
                                            </tr>
                                        ";
                                    }
                                } else {
                                    echo "Erro na consulta: " . mysqli_error($con);
                                }
                            } else {

                                $totalEstoque = 0;
                                $totalCusto = 0;
                                $totalVenda = 0;

                                $empresa = mysqli_real_escape_string($con, $empresa);

                                mysqli_set_charset($con, "utf8");
                                
                                $query = "SELECT * FROM Estoque WHERE Filial = {$empresa}";
                            
                                $result = mysqli_query($con, $query);
                            
                                if ($result) {
                                    while($exibe = mysqli_fetch_assoc($result)){
                                        $totalEstoque += $exibe['Estoque_Atual'];
                                        $totalCusto += $exibe['PCusto'] * $exibe['Estoque_Atual'];
                                        $totalVenda += $exibe['PVenda'] * $exibe['Estoque_Atual'];                                   

                                        echo "
                                            <tr>
                                                <td>".$exibe['Codigo']."</td>
                                                <td>".$exibe['Codigo_EAN']."</td>
                                                <td>".$exibe['Nome']."</td>
                                                <td>".$exibe['Classe']."</td>
                                                <td>".$exibe['Grupo']."</td>
                                                <td>".number_format($exibe['Estoque_Atual'], 0, ',', '.')."</td>
                                                <td>".number_format($exibe['PCusto'], 2, ',', '.')."</td>
                                                <td>".number_format($exibe['PVenda'], 2, ',', '.')."</td>                             
                                            </tr>
                                        ";
                                    }
                                } else {
                                    echo "Erro na consulta: " . mysqli_error($con);
                                }
                            }                            
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Totais:</b></td>
                                <td><b><?php echo number_format($totalEstoque, 3, ',', '.'); ?></b></td>
                                <td><b>R$ <?php echo number_format($totalCusto, 2, ',', '.');?></b></td>
                                <td><b>R$ <?php echo number_format($totalVenda, 2, ',', '.'); ?></b></td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </main>
            
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>    
    </body>
</html>