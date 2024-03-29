<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['login'])){
       header("Location: login.php");
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
    <link rel="stylesheet" href="./style.php" media="screen">
    <title>Gestor WEB</title>
</head>

    <body>
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="./"><?php echo $_SESSION['fantasia']; ?></a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="./logout.php">Sair</a>
                </div>
            </div>
        </header>
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./">
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./vendas">
                                    Vendas Realizadas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./produtos">
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
                            <?php
                                include('conexao.php');
                                $empresa = $_SESSION['filial'];
                                $datavendas = date('Y-m-d');
                                if(isset($_POST['date'])){
                                    $FilterData = $_POST['date'];
                                    $result = mysqli_query($con, "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Final) AS VALORFINAL, COUNT(Cli_For__Codigo) AS NUMEROCLIENTES FROM Vendas WHERE FILIAL = '{$empresa}' AND DATA = '{$FilterData}'");
                                    if (mysqli_num_rows($result) > 0){
                                        while($exibe = mysqli_fetch_array($result)) {
                                            $numerovendas = $exibe['NUMEROVENDAS'];
                                            $valorbruto = number_format($exibe['VALORBRUTO'], 2, ',', '.');
                                            $valorfinal = number_format($exibe['VALORFINAL'], 2, ',', '.');
                                            if($exibe['VALORFINAL'] == 0 && $exibe['NUMEROCLIENTES'] == 0){
                                                $ticketMedio = number_format(0, 2, ',', '.');
                                            } else {
                                                $ticketMedio = number_format($exibe['VALORFINAL'] / $exibe['NUMEROCLIENTES'], 2, ',', '.');   
                                            }
                                            $datavendas = $FilterData;
                                        }
                                    }
                                } else {
                                    $FilterData = date('d-m-Y');
                                    $result = mysqli_query($con, "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Final) AS VALORFINAL, COUNT(Cli_For__Codigo) AS NUMEROCLIENTES FROM Vendas WHERE FILIAL = '{$empresa}' AND DATA = CURRENT_DATE");
                                    if (mysqli_num_rows($result) > 0){
                                        while($exibe = mysqli_fetch_array($result)) {
                                            $numerovendas = $exibe['NUMEROVENDAS'];
                                            $valorbruto = number_format($exibe['VALORBRUTO'], 2, ',', '.');
                                            $valorfinal = number_format($exibe['VALORFINAL'], 2, ',', '.');
                                            if($exibe['VALORFINAL'] == 0 && $exibe['NUMEROCLIENTES'] == 0){
                                                $ticketMedio = number_format(0, 2, ',', '.');
                                            } else {
                                                $ticketMedio = number_format($exibe['VALORFINAL'] / $exibe['NUMEROCLIENTES'], 2, ',', '.');   
                                            }
                                            $datavendas = $FilterData;
                                        }
                                    } 
                                }
                            ?>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="dropdown" style="margin-right: 10px;">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <?php echo $_SESSION['fantasia']; ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php 
                                       $result = mysqli_query($con, "SELECT * FROM Filial WHERE ID_EMPRESA = '{$empresa}'"); 
                                       if (mysqli_num_rows($result) > 0){
                                        while($exibe = mysqli_fetch_array($result)) {
                                            $codigo = $exibe['ID_FILIAL'];
                                            $cnpj = $exibe['CNPJ'];
                                            echo "<li><a class='dropdown-item' href='#' onclick='trocarUsuario(\"{$cnpj}\", event)'>{$exibe['FANTASIA']}</a></li>";
                                        }
                                       } else {
                                            echo "<li>Nenhuma Filial</li>";
                                       }
                                    ?>
                                </ul>
                            </div>
                            <form method="post" action="" style="margin-left: 10px;">
                                <div class="col">
                                    <input type="date" name="date" value="<?php echo $datavendas; ?>" class="input-date">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary btn-enviar">Buscar</button>
                                </div>
                            </form>
                        </div>


                    </div>
                    <div class="d-flex pt-1 pb-3">
                    <?php
                        $result = mysqli_query($con, "SELECT * FROM Log_Envio WHERE Filial = {$empresa} AND Data = CURRENT_DATE ORDER BY Data, HORA DESC LIMIT 1");
                        while($exibe = mysqli_fetch_assoc($result)){
                            $dataoriginal = $exibe['Data'];
                            $timestamp = strtotime($dataoriginal);
                            $novaData = date("d/m/Y", $timestamp);
                            echo "
                                <span>Última Atualização: <b>".$novaData."</b> - <b>".$exibe['Hora']."</b></span>
                            ";
                        }                 
                    
                    ?>
                        
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold textprimary text-uppercase mb-1">
                                                Quantidade de Vendas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $numerovendas; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-cart-fill h4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold textsucess text-uppercase mb-1">
                                                Valor Bruto</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "R$ $valorbruto"; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-currency-dollar h4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Valor
                                                Líquido
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo "R$ $valorfinal"; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-bag-check-fill h4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Ticket Médio</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "R$ $ticketMedio"; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-tags-fill h4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-light">Análise de Pagamentos</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div id="chartdonut"></div>
                                        <?php 
                                        
                                        $valores = [];

                                        if(isset($_POST['date'])){
                                            $FilterData = $_POST['date'];
                                            $sql = <<<EOT
                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'DINHEIRO')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'DINHEIRO TICKET'))
                                                
                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO CREDITO')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO CREDITO POS')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'POS CREDITO'))

                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO DEBITO')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO DEBITO POS')) OR ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'POS DEBITO'))

                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE a.Descricao = 'PIX' AND FILIAL = $empresa AND DATA = '$FilterData'
                                            EOT;
                                            $consulta = mysqli_query($con, $sql);
                                            while($pagamentos = mysqli_fetch_assoc($consulta)){
                                                if($pagamentos['VALORES'] == 0){
                                                    $valores[] = 0; 
                                                } else {
                                                    $valores[] = $pagamentos['VALORES'];
                                                }
                                                
                                            }
                                        } else {
                                            $FilterData = date('Y-m-d');
                                            $sql = <<<EOT
                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'DINHEIRO')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'DINHEIRO TICKET'))
                                                
                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO CREDITO')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO CREDITO POS')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'POS CREDITO'))

                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO DEBITO')) or ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'CARTAO DEBITO POS')) OR ((a.FILIAL = $empresa AND a.Data = '$FilterData') and (a.Descricao = 'POS DEBITO'))

                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE a.Descricao = 'PIX' AND FILIAL = $empresa AND DATA = '$FilterData'
                                            EOT;
                                            $consulta = mysqli_query($con, $sql);
                                            while($pagamentos = mysqli_fetch_array($consulta)){
                                                if($pagamentos['VALORES'] == 0){
                                                    $valores[] = 0; 
                                                } else {
                                                    $valores[] = $pagamentos['VALORES'];
                                                }
                                                
                                            }
                                            
                                        } 

                                        $valores = implode(',', $valores);
                                                               
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-light">Análise do Mês</h6>
                                </div>
                                <div class="card-body">
                                <?php
                                        if (isset($_POST['date'])) {
                                            $FilterData = $_POST['date'];
                                            $mysqlDate = date('Y-m-d', strtotime(str_replace('/', '-', $FilterData)));
                                        } else {
                                            $FilterData = date('d-m-Y');
                                            $mysqlDate = date('Y-m-d');
                                        }

                                        $result = mysqli_query(
                                            $con,
                                            "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Desconto) AS DESCONTO, SUM(Total_Final) AS VALORFINAL 
                                            FROM Vendas 
                                            WHERE FILIAL = '{$empresa}' AND YEAR(Data) = YEAR('{$mysqlDate}') AND MONTH(Data) = MONTH('{$mysqlDate}')"
                                        );

                                        if ($result === false) {
                                            die(mysqli_error($con));
                                        }

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($exibe = mysqli_fetch_array($result)) {
                                                $numerovendasmes = $exibe['NUMEROVENDAS'];
                                                $valorbrutomes = number_format($exibe['VALORBRUTO'], 2, ',', '.');
                                                $valordescontomes = number_format($exibe['DESCONTO'], 2, ',', '.');
                                                $valorfinalmes = number_format($exibe['VALORFINAL'], 2, ',', '.');
                                                $datavendas = $FilterData;
                                            }
                                        } else {
                                            echo "Nenhum resultado encontrado.";
                                        }

                                        mysqli_free_result($result);
                                ?>
                                    <table class="table text-light">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr class="text-light">
                                                <td>Vendas Realizadas</td>
                                                <td><?php echo $numerovendasmes; ?></td>
                                            </tr>
                                            <tr class="text-light">
                                                <td>Total Vendido Bruto</td>
                                                <td><?php echo "R$ $valorbrutomes"; ?></td>
                                            </tr>
                                            <tr class="text-light">
                                                <td>Total Desconto Vendas</td>
                                                <td><?php echo "R$ $valordescontomes"; ?></td>
                                            </tr>
                                            <tr class="text-light">
                                                <td>Total Vendido Líquido</td>
                                                <td><?php echo "R$ $valorfinalmes"; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php 
                        if(isset($_POST['date'])){
                            $FilterData = $_POST['date']; 
                            mysqli_query($con, "SET SQL_BIG_SELECTS=1");
                            $result = mysqli_query($con, "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Desconto) AS DESCONTO, SUM(Total_Final) AS VALORFINAL, COUNT(Cli_For__Codigo) AS NUMEROCLIENTES FROM Vendas WHERE FILIAL = '{$empresa}' AND YEARWEEK('{$FilterData}', 1) "); 
                            if (mysqli_num_rows($result) > 0){
                                while($exibe = mysqli_fetch_array($result)) {
                                    if($exibe['VALORFINAL'] == 0 && $exibe['NUMEROCLIENTES'] == 0){
                                        $ticketMedio = number_format(0, 2, ',', '.');
                                    } else {
                                        $ticketMedio = number_format($exibe['VALORFINAL'] / $exibe['NUMEROCLIENTES'], 2, ',', '.');   
                                    }
                                }
                            }
                        } else {
                            $FilterData = date('d-m-Y');
                            mysqli_query($con, "SET SQL_BIG_SELECTS=1");
                            $result = mysqli_query($con, "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Desconto) AS DESCONTO, SUM(Total_Final) AS VALORFINAL, COUNT(Cli_For__Codigo) AS NUMEROCLIENTES FROM Vendas WHERE FILIAL = '{$empresa}' AND YEARWEEK(NOW(), 1) ");  
                            if (mysqli_num_rows($result) > 0){
                                while($exibe = mysqli_fetch_array($result)) {
                                    if($exibe['VALORFINAL'] == 0 && $exibe['NUMEROCLIENTES'] == 0){
                                        $ticketMedio = number_format(0, 2, ',', '.');
                                    } else {
                                        $ticketMedio = number_format($exibe['VALORFINAL'] / $exibe['NUMEROCLIENTES'], 2, ',', '.');  
                                    }
                                }
                            }
                        }
                    
                    ?>
                    <?php
                        function executarConsulta($con, $FilterData, $empresa, $tipoConsulta)
                        {
                            $valores = [];
                            $itens = [];

                            $sql = <<<EOT
                                SELECT
                                    p.$tipoConsulta,
                                    COUNT(i.Id) AS QuantidadeItens,
                                    ROUND((COUNT(i.Id) / total.Total) * 100, 2) AS Porcentagem
                                FROM
                                    Estoque p
                                INNER JOIN
                                    Itens i ON p.Codigo = i.Produto__Codigo
                                INNER JOIN Vendas v ON i.Sequencia = v.Sequencia
                                    AND v.Data BETWEEN '$FilterData' AND '$FilterData'
                                    AND v.Filial = '$empresa'
                                CROSS JOIN (
                                    SELECT COUNT(*) AS Total
                                    FROM Itens
                                ) total
                                GROUP BY
                                    p.$tipoConsulta
                            EOT;

                            $consulta = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($consulta)) {
                                $valores[] = ($row['Porcentagem'] == 0) ? 0 : $row['Porcentagem'];
                                
                                if ($row['Porcentagem'] != 0) {
                                    $itens[] = $row[$tipoConsulta];
                                }
                            }

                            return ['valores' => implode(',', $valores), 'itens' => implode(',', $itens)];
                        }

                        mysqli_set_charset($con, 'utf8');

                        if (isset($_POST['date'])) {
                            $FilterData = $_POST['date'];
                        } else {
                            $FilterData = date('Y-m-d');
                        }

                        $resultadoClasse = executarConsulta($con, $FilterData, $empresa, 'Classe');
                        $resultadoGrupo = executarConsulta($con, $FilterData, $empresa, 'Grupo');

                        $valoresClasses = $resultadoClasse['valores'];
                        $classes = $resultadoClasse['itens'];

                        $valoresGrupos = $resultadoGrupo['valores'];
                        $grupos = $resultadoGrupo['itens'];
                    ?>
                    <div class="row">
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-light">Produtos Vendidos por Classe</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div id="chartclass"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-light">Produtos Vendidos por Grupo</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div id="chartgroup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl col-lg-5 d-flex justify-content-center align-items-center">
                            <div class="card shadow mb-4">
                                <div class="d-flex justify-content-center card-header py-3 d-flex flex-row align-items-center">
                                    <h6 class="m-0 font-weight-bold text-light">Produtos por Classe - Geral</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                    <div class="container">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item">
                                                        <a href="#conteudoPercentClass" class="nav-link active" data-toggle="pill">Porcentagem</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#conteudoValueClass" class="nav-link" data-toggle="pill">Valores</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content mt-2">
                                                    <div id="conteudoPercentClass" class="tab-pane fade show active">
                                                        <div id="percentchartproductsclass"></div>
                                                        <?php
                                                            $classesGeral = [];
                                                            $valoresClassesGeral = [];

                                                            mysqli_set_charset($con, 'utf8');
                                                            $sql = <<<EOT
                                                                SELECT
                                                                    p.Classe,
                                                                    COUNT(*) AS QuantidadeItens,
                                                                    ROUND((COUNT(*) * 100.0) / total.TotalGeral, 2) AS Porcentagem
                                                                FROM
                                                                    Estoque p
                                                                CROSS JOIN (
                                                                    SELECT COUNT(*) AS TotalGeral
                                                                    FROM Estoque
                                                                    WHERE Filial = '$empresa'
                                                                ) total
                                                                WHERE
                                                                    p.Filial = '$empresa'
                                                                GROUP BY
                                                                    p.Classe
                                                            EOT;

                                                            mysqli_query($con, "SET SQL_BIG_SELECTS=1");

                                                            $consulta = mysqli_query($con, $sql);
                                                            while($classeProdutos = mysqli_fetch_assoc($consulta)){
                                                                if($classeProdutos['Porcentagem'] == 0){
                                                                    $valoresClassesGeral[] = 0; 
                                                                } else {
                                                                    $classesGeral[] = $classeProdutos['Classe'];
                                                                    $valoresClassesGeral[] = $classeProdutos['Porcentagem'];
                                                                }                                                    
                                                            }

                                                            $valoresClassesGeral = implode(',', $valoresClassesGeral);
                                                            $classesGeral = implode(',', $classesGeral); 
                                                        ?>
                                                    </div>
                                                    <div id="conteudoValueClass" class="tab-pane fade">
                                                        <div id="valuechartproductsclass"></div>
                                                        <?php
                                                            
                                                            $classesGeralTotal = [];
                                                            $valoresClassesGeralTotal = [];

                                                            mysqli_set_charset($con, 'utf8');
                                                            $sql = <<<EOT
                                                                SELECT
                                                                    p.Classe,
                                                                    COUNT(*) AS QuantidadeItens,
                                                                    ROUND(SUM(p.PVenda * p.Estoque_Atual), 2) AS Valor
                                                                FROM
                                                                    Estoque p
                                                                WHERE
                                                                    p.Filial = '$empresa'
                                                                GROUP BY
                                                                    p.Classe
                                                            EOT;

                                                            mysqli_query($con, "SET SQL_BIG_SELECTS=1");

                                                            $consulta = mysqli_query($con, $sql);
                                                            while($classetProdutos = mysqli_fetch_assoc($consulta)){
                                                                if($classetProdutos['Valor'] == 0){
                                                                    $valoresClassesGeralTotal[] = 0; 
                                                                } else {
                                                                    $classesGeralTotal[] = $classetProdutos['Classe'];
                                                                    $valoresClassesGeralTotal[] = $classetProdutos['Valor'];
                                                                }                                                    
                                                            }

                                                            $valoresClassesGeralTotal = implode(',', $valoresClassesGeralTotal);
                                                            $classesGeralTotal = implode(',', $classesGeralTotal); 
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-xl col-lg-5 d-flex justify-content-center align-items-center">
                                <div class="card shadow mb-4">
                                    <div class="d-flex justify-content-center card-header py-3 d-flex flex-row align-items-center">
                                        <h6 class="m-0 font-weight-bold text-light">Produtos por Grupo - Geral</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-center">
                                            <div class="container">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item">
                                                        <a href="#conteudo1" class="nav-link active" data-toggle="pill">Porcentagem</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#conteudo2" class="nav-link" data-toggle="pill">Valores</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content mt-2">
                                                    <div id="conteudo1" class="tab-pane fade show active">
                                                        <div id="percentchartproductsgroup"></div>
                                                        <?php
                                                            $gruposGeral = [];
                                                            $valoresGruposGeral = [];

                                                            mysqli_set_charset($con, 'utf8');
                                                            $sql = <<<EOT
                                                                SELECT
                                                                    p.Grupo,
                                                                    COUNT(*) AS QuantidadeItens,
                                                                    ROUND((COUNT(*) * 100.0) / total.TotalGeral, 2) AS Porcentagem
                                                                FROM
                                                                    Estoque p
                                                                CROSS JOIN (
                                                                    SELECT COUNT(*) AS TotalGeral
                                                                    FROM Estoque
                                                                    WHERE Filial = '$empresa'
                                                                ) total
                                                                WHERE
                                                                    p.Filial = '$empresa'
                                                                GROUP BY
                                                                    p.Grupo
                                                            EOT;

                                                            mysqli_query($con, "SET SQL_BIG_SELECTS=1");

                                                            $consulta = mysqli_query($con, $sql);
                                                            while($classeProdutos = mysqli_fetch_assoc($consulta)){
                                                                if($classeProdutos['Porcentagem'] == 0){
                                                                    $valoresGruposGeral[] = 0; 
                                                                } else {
                                                                    $gruposGeral[] = $classeProdutos['Grupo'];
                                                                    $valoresGruposGeral[] = $classeProdutos['Porcentagem'];
                                                                }                                                    
                                                            }

                                                            $valoresGruposGeral = implode(',', $valoresGruposGeral);
                                                            $gruposGeral = implode(',', $gruposGeral); 
                                                        ?>
                                                    </div>
                                                    <div id="conteudo2" class="tab-pane fade">
                                                        <div id="valuechartproductsgroup"></div>
                                                        <?php
                                                            $gruposGeralTotal = [];
                                                            $valoresGruposGeralTotal = [];
                                                        
                                                            mysqli_set_charset($con, 'utf8');

                                                            $sql = <<<EOT
                                                                SELECT
                                                                    p.Grupo,
                                                                    COUNT(*) AS QuantidadeItens,
                                                                    ROUND(SUM(p.PVenda * p.Estoque_Atual), 2) AS Valor
                                                                FROM
                                                                    Estoque p
                                                                WHERE
                                                                    p.Filial = '$empresa'
                                                                GROUP BY
                                                                    p.Grupo
                                                            EOT;

                                                            mysqli_query($con, "SET SQL_BIG_SELECTS=1");

                                                            $consulta = mysqli_query($con, $sql);                                                        
                                                            while($grupotProdutos = mysqli_fetch_assoc($consulta)){
                                                                if($grupotProdutos['Valor'] == 0){
                                                                    $valoresGruposGeralTotal[] = 0; 
                                                                } else {
                                                                    $gruposGeralTotal[] = $grupotProdutos['Grupo'];
                                                                    $valoresGruposGeralTotal[] = $grupotProdutos['Valor'];
                                                                }                                                    
                                                            }

                                                            $valoresGruposGeralTotal = implode(',', $valoresGruposGeralTotal);
                                                            $gruposGeralTotal = implode(',', $gruposGeralTotal);                                                                                              
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
        </main>
                            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script type="text/javascript">
            var options = {
                series: [<?php echo $valoresClasses; ?>],
                labels: [<?php echo "'" . str_replace(",", "','", $classes) . "'"; ?>],
                chart: {
                    type: 'donut',
                    width: 450,
                    background: '#1C3341',
                    foreColor: '#fff',  
                },
                dataLabels: {
                    enabled: true,
                },
                legend: {
                    position: 'bottom'
                },
                theme: {
                    mode: 'dark', 
                    palette: 'palette1',
                    monochrome: {
                        enabled: false,
                        color: 'transparent',
                        shadeTo: 'dark',
                        shadeIntensity: 0.65,
                    },
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                            }
                        }
                    }
                },
            };
    
            var chart = new ApexCharts(document.querySelector("#chartclass"), options);
            chart.render();
        </script>

        <script type="text/javascript">
            var options = {
                series: [<?php echo $valoresGrupos; ?>],
                labels: [<?php echo "'" . str_replace(",", "','", $grupos) . "'"; ?>],
                chart: {
                    type: 'donut',
                    width: 450,
                    background: '#1C3341',
                    foreColor: '#fff',  
                },
                dataLabels: {
                    enabled: true,
                },
                legend: {
                    position: 'bottom'
                },
                theme: {
                    mode: 'dark', 
                    palette: 'palette2',
                    monochrome: {
                        enabled: false,
                        color: 'transparent',
                        shadeTo: 'dark',
                        shadeIntensity: 0.65,
                    },
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                            }
                        }
                    }
                },
            };
    
            var chart = new ApexCharts(document.querySelector("#chartgroup"), options);
            chart.render();
        </script>

        <script type="text/javascript">
      
            var options = {
                series: [{
                    data: [<?php echo $valoresClassesGeral; ?>]
                }],
                chart: {
                    height: 350,
                    width: 1200,
                    type: 'bar',
                    foreColor: '#fff', 
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top',  
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val + "%";
                    },
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        colors: ["#fff"]
                    }
                },
                
                xaxis: {
                    categories: [<?php echo "'" . str_replace(",", "','", $classesGeral) . "'"; ?>],
                    position: '',
                    colors: ["#fff"],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    stroke: {
                        color: '#fff',
                        width: 0,
                        dashArray: 0,
                    },
                    crosshairs: {
                        fill: {
                            type: 'solid',
                            color: '#fff',
                            gradient: {
                                colorFrom: '#fff',
                                colorTo: '#fff',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return val + "%";
                        }
                    }
                }
                };

                var chart = new ApexCharts(document.querySelector("#percentchartproductsclass"), options);
                chart.render();
        </script>

        <script type="text/javascript">
            
            var options = {
                series: [{
                    data: [<?php echo $valoresClassesGeralTotal; ?>]
                }],
                chart: {
                    height: 350,
                    width: 1200,
                    type: 'bar',
                    foreColor: '#fff', 
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top',  
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    },
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        colors: ["#fff"]
                    }
                },
                
                xaxis: {
                    categories: [<?php echo "'" . str_replace(",", "','", $classesGeralTotal) . "'"; ?>],
                    position: '',
                    colors: ["#fff"],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    stroke: {
                        color: '#fff',
                        width: 0,
                        dashArray: 0,
                    },
                    crosshairs: {
                        fill: {
                            type: 'solid',
                            color: '#fff',
                            gradient: {
                                colorFrom: '#fff',
                                colorTo: '#fff',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return val.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    }
                }
                };

                var chart = new ApexCharts(document.querySelector("#valuechartproductsclass"), options);
                chart.render();
        </script>

        <script type="text/javascript">
                 var options = {
                    series: [{
                        data: [<?php echo $valoresGruposGeral; ?>]
                    }],
                    chart: {
                        height: 350,
                        width: 1200,
                        type: 'bar',
                        foreColor: '#fff', 
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top',  
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return val + "%";
                        },
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            colors: ["#fff"]
                        }
                    },
                    
                    xaxis: {
                        categories: [<?php echo "'" . str_replace(",", "','", $gruposGeral) . "'"; ?>],
                        position: '',
                        colors: ["#fff"],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        stroke: {
                            color: '#fff',
                            width: 0,
                            dashArray: 0,
                        },
                        crosshairs: {
                            fill: {
                                type: 'solid',
                                color: '#fff',
                                gradient: {
                                    colorFrom: '#fff',
                                    colorTo: '#fff',
                                    stops: [0, 100],
                                    opacityFrom: 0.4,
                                    opacityTo: 0.5,
                                }
                            }
                        }
                    },
                    yaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            show: false,
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#percentchartproductsgroup"), options);
                chart.render();
        </script>

        <script type="text/javascript">
                 var options = {
                    series: [{
                        data: [<?php echo $valoresGruposGeralTotal; ?>]
                    }],
                    chart: {
                        height: 350,
                        width: 1200,
                        type: 'bar',
                        foreColor: '#fff', 
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            dataLabels: {
                                position: 'top',  
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return val.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        },
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            colors: ["#fff"]
                        }
                    },
                    
                    xaxis: {
                        categories: [<?php echo "'" . str_replace(",", "','", $gruposGeralTotal) . "'"; ?>],
                        position: '',
                        colors: ["#fff"],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        stroke: {
                            color: '#fff',
                            width: 0,
                            dashArray: 0,
                        },
                        crosshairs: {
                            fill: {
                                type: 'solid',
                                color: '#fff',
                                gradient: {
                                    colorFrom: '#fff',
                                    colorTo: '#fff',
                                    stops: [0, 100],
                                    opacityFrom: 0.4,
                                    opacityTo: 0.5,
                                }
                            }
                        }
                    },
                    yaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            show: false,
                            formatter: function (val) {
                                return val;
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#valuechartproductsgroup"), options);
                chart.render();
        </script>

        <!-- <script type="text/javascript">
             var options = {
                series: [{
                    data: [35000, 50000, 100000, 64, 22, 43, 21, 100]
                }, {
                    data: [12000, 20000, 60000, 52, 13, 44, 32, 150]
                }],
                chart: {
                    type: 'bar',
                    height: 430,
                    width: 600,
                    foreColor: '#fff',  
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: false,
                    width: 1,
                    colors: ['#fff']
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                xaxis: {
                    categories: ['Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                }
            };
    
            var chart = new ApexCharts(document.querySelector("#chartmensality"), options);
            chart.render();
        </script>

        <script type="text/javascript">
            var options = {
                series: [
                {
                    name: 'Actual',
                    data: [
                    {
                        x: '2011',
                        y: 12,
                        goals: [
                        {
                            name: 'Expected',
                            value: 14,
                            strokeWidth: 5,
                            strokeHeight: 10,
                            strokeLineCap: 'round',
                            strokeColor: '#775DD0'
                        }
                        ]
                    },
                    {
                        x: '2012',
                        y: 44,
                        goals: [
                        {
                            name: 'Expected',
                            value: 54,
                            strokeWidth: 5,
                            strokeHeight: 10,
                            strokeLineCap: 'round',
                            strokeColor: '#775DD0'
                        }
                        ]
                    },
                    {
                        x: '2013',
                        y: 54,
                        goals: [
                        {
                            name: 'Expected',
                            value: 52,
                            strokeWidth: 5,
                            strokeHeight: 10,
                            strokeLineCap: 'round',
                            strokeColor: '#775DD0'
                        }
                        ]
                    },
                    {
                        x: '2014',
                        y: 66,
                        goals: [
                        {
                            name: 'Expected',
                            value: 61,
                            strokeWidth: 5,
                            strokeHeight: 10,
                            strokeLineCap: 'round',
                            strokeColor: '#775DD0'
                        }
                        ]
                    },
                    {
                        x: '2015',
                        y: 81,
                        goals: [
                        {
                            name: 'Expected',
                            value: 66,
                            strokeWidth: 5,
                            strokeHeight: 10,
                            strokeLineCap: 'round',
                            strokeColor: '#775DD0'
                        }
                        ]
                    },
                    {
                        x: '2016',
                        y: 67,
                        goals: [
                        {
                            name: 'Expected',
                            value: 70,
                            strokeWidth: 5,
                            strokeHeight: 10,
                            strokeLineCap: 'round',
                            strokeColor: '#775DD0'
                        }
                        ]
                    }
                    ]
                }
                ],
                chart: {
                    height: 350,
                    width:600,
                    type: 'bar',
                    foreColor: '#fff',  
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                colors: ['#00E396'],
                dataLabels: {
                    formatter: function(val, opt) {
                        const goals =
                        opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
                            .goals
                    
                        if (goals && goals.length) {
                        return `${val} / ${goals[0].value}`
                        }
                        return val
                    }
                },
                legend: {
                    show: true,
                    showForSingleSeries: true,
                    customLegendItems: ['Atual', 'Expectativa'],
                    markers: {
                        fillColors: ['#00E396', '#775DD0']
                    }
                    }
                };
    
            var chart = new ApexCharts(document.querySelector("#chartmeta"), options);
            chart.render();
        </script> -->

        <script type="text/javascript">
            var options = {
                series: [<?= $valores ?>],
                labels: ['Dinheiro', 'Cartão de Crédito', 'Cartão de Débito', 'PIX'],
                chart: {
                    type: 'donut',
                    width: 380,
                    background: '#1C3341',
                    foreColor: '#fff',  
                },
                dataLabels: {
                    enabled: true,
                },
                legend: {
                    position: 'bottom'
                },
                theme: {
                    mode: 'dark', 
                    palette: 'palette1',
                    monochrome: {
                        enabled: false,
                        color: 'transparent',
                        shadeTo: 'dark',
                        shadeIntensity: 0.65,
                    },
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                            }
                        }
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#chartdonut"), options);
            chart.render();
        </script>       

    </body>

</html>