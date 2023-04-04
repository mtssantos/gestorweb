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
                                <a class="nav-link" href="#">
                                    Produtos
                                </a>
                            </li>
                        </ul>

                        <h6
                            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-ligth text-uppercase">
                            <span>Relatórios</span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text" class="align-text-bottom"></span>
                                    Vendas no Mês
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text" class="align-text-bottom"></span>
                                    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text" class="align-text-bottom"></span>
                                    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text" class="align-text-bottom"></span>
                                    
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
                            <form method="post" action="">
                                <div class="col">
                                    <input type="date" name="date" value="<?php echo $datavendas; ?>" class="input-date"><button type="submit" class="btn btn-sm btn-outline-secondary btn-enviar">Buscar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex pt-1 pb-3">
                    <?php
                        $result = mysqli_query($con, "SELECT * FROM Log_Envio WHERE Filial = {$empresa} ORDER BY DATA, HORA DESC LIMIT 1");
                        while($exibe = mysqli_fetch_assoc($result)){
                            echo "
                                <span>Última Atualização: ".$exibe['Data']."-".$exibe['Hora']."</span>
                            ";
                        }                 
                    
                    ?>
                        
                    </div>
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
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

                        <!-- Earnings (Monthly) Card Example -->
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

                        <!-- Earnings (Monthly) Card Example -->
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

                        <!-- Pending Requests Card Example -->
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
                                                WHERE a.Descricao = 'DINHEIRO' OR Descricao = 'DINHEIRO TICKET' AND FILIAL = $empresa AND DATA = '$FilterData'
                                                
                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE a.Descricao = 'CARTAO CREDITO' OR Descricao = 'CARTAO CREDITO POS' AND FILIAL = $empresa AND DATA = '$FilterData'

                                                UNION ALL

                                                select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                WHERE a.Descricao = 'CARTÃO DEBITO' OR Descricao = 'CARTÃO DEBITO POS' AND FILIAL = $empresa AND DATA = '$FilterData'

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
                                                    WHERE a.Descricao = 'DINHEIRO' OR Descricao = 'DINHEIRO TICKET' AND FILIAL = $empresa AND DATA = '$FilterData'
                                                    
                                                    UNION ALL

                                                    select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                    WHERE a.Descricao = 'CARTAO CREDITO' OR Descricao = 'CARTAO CREDITO POS' AND FILIAL = $empresa AND DATA = '$FilterData'

                                                    UNION ALL

                                                    select SUM(a.VALOR) AS VALORES from Pagamentos a
                                                    WHERE a.Descricao = 'CARTAO DEBITO' OR Descricao = 'CARTAO DEBITO POS' AND FILIAL = $empresa AND DATA = '$FilterData'

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
                                        if(isset($_POST['date'])){
                                            $FilterData = $_POST['date'];
                                            $result = mysqli_query($con, "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Desconto) AS DESCONTO, SUM(Total_Final) AS VALORFINAL FROM Vendas WHERE FILIAL = '{$empresa}' AND MONTH('{$FilterData}') ");
                                            if (mysqli_num_rows($result) > 0){
                                                while($exibe = mysqli_fetch_array($result)) {
                                                    $numerovendasmes = $exibe['NUMEROVENDAS'];
                                                    $valorbrutomes = number_format($exibe['VALORBRUTO'], 2, ',', '.');
                                                    $valordescontomes = number_format($exibe['DESCONTO'], 2, ',', '.');
                                                    $valorfinalmes = number_format($exibe['VALORFINAL'], 2, ',', '.');
                                                    $datavendas = $FilterData;
                                                }
                                            }
                                        } else {
                                            $FilterData = date('d-m-Y');
                                            $result = mysqli_query($con, "SELECT COUNT(*) AS NUMEROVENDAS, SUM(Total_Produtos) AS VALORBRUTO, SUM(Total_Desconto) AS DESCONTO, SUM(Total_Final) AS VALORFINAL FROM Vendas WHERE FILIAL = '{$empresa}' AND MONTH(CURRENT_DATE)");
                                            if (mysqli_num_rows($result) > 0){
                                                while($exibe = mysqli_fetch_array($result)) {
                                                    $numerovendasmes = $exibe['NUMEROVENDAS'];
                                                    $valorbrutomes = number_format($exibe['VALORBRUTO'], 2, ',', '.');
                                                    $valordescontomes = number_format($exibe['DESCONTO'], 2, ',', '.');
                                                    $valorfinalmes = number_format($exibe['VALORFINAL'], 2, ',', '.');
                                                    $datavendas = $FilterData;
                                                }
                                            } 
                                        }  
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
                    <div class="row">
                        <div class="col">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-light">Ticket Médio Semanal - Em desenvolvimento</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-center">
                                            <div id="chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
        </main>
                            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script type="text/javascript">
            var options = {
                chart: {
                    type: 'area',
                    background: '#1C3341',
                    foreColor: '#fff',
                },
                theme:{
                    mode: 'dark', 
                    monochrome: {
                        enabled: false,
                        color: '#fff',
                        shadeTo: 'dark',
                        shadeIntensity: 0.65,
                    },
                },
                series: [{
                    name: 'Ticket Médio',
                    data: [0,20,40,60,80,100,120]
                }],
                xaxis: {
                    categories: ['Domingo','Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']
                },
                responsive: [{
                    breakpoint: undefined,
                    options: {},
                }]
            }

            var chart = new ApexCharts(document.querySelector("#chart"), options);

            chart.render();
        </script>

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
                        width: 250
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