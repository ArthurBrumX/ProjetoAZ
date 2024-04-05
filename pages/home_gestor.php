<?php
//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Campanha;
use \App\Entity\Feedback;
use \App\Entity\Carteira;
use \App\Entity\Usuario;

//OBRIGADO O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

$obCampanhaAtiva = Campanha::getCampanhaAtiva();
$saldoEnviadoHoje = Feedback::getEnviadoHoje();
$saldoDoadosHoje = Feedback::getSDoadosHoje();
$saldoDistrDoadoAguardDoacao = Feedback::getDistrDoadAguardDoacao();

// echo '<pre>';
// print_r($saldoDoadosHoje);
// echo '</pre>';
// exit;
//CONSULTA A CAMPANHA ATIVA
$totalFeedback = Feedback::getTotalFeedbacks();
// echo "<pre>"; print_r($saldoTotalGESTOR); echo "</pre>";
// exit;

//INCLUI O MENU GESTOR
$tituloPagina = 'HOME';
require './../includes/menu_gestor.php';

//BUSCA TODOS OS USUÁRIOS ATIVOS NO BANCO DE DADOS
//$getUsuariosAtivos = Usuario::getUsuarios('id_status_user = 1');
//$getUsuariosAtivos = Usuario::RelatorioGeralGestor();
//PEGAR A SOMA DE TODAS AS DOACOES DA CAMPANHA ATIVA
$saldoGeral = Carteira::saldosGerais();
$saldoColab = Usuario::saldoColaborador();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco</title>
    <link rel="stylesheet" href="../css/gestor/telaHome.css">
</head>

<body>
    <!--TELA MENU GESTOR-->
    <!------------------------------------------------------------->

    <main class="main_listar_banco">

        <div class="content_tela_banco ">
            <div class="content">
                <div class="conteiner_cartao-DDA">
                    <!------------------------------------------------------------->
                    <!--Distribuido-->
                    <div class="cartao">
                        <div class="logo_az_cartao">
                            <img class="logo-cartao" src="../assets/Simbolo-Az-Cartao.png" alt="Carregando...">
                            <h1 class="merit_letra">MERIT</h1>
                            <p class="barra">/</p>
                            <img class="logo_final" src="../assets/AZmerit-Simbolo-Cartao.png" alt="carregando...">
                        </div>
                        <!------------------------------------------------------------->

                        <div>
                            <p class="valor-cartao"> R$
                                <?=$saldoDistrDoadoAguardDoacao[0]->distribuido?>
                            </p>
                        </div>
                        <!------------------------------------------------------------->
                        <p class="legenda">Distribuidos</p>
                    </div>
                    <!------------------------------------------------------------->
                   
                    <!------------------------------------------------------------->
                    <!--Doado-->
                    <div class="cartao">
                        <div class="logo_az_cartao">
                            <img class="logo-cartao" src="../assets/Simbolo-Az-Cartao.png" alt="Carregando...">
                            <h1 class="merit_letra">MERIT</h1>
                            <p class="barra">/</p>
                            <img class="logo_final" src="../assets/AZmerit-Simbolo-Cartao.png" alt="carregando...">
                        </div>
                        <!------------------------------------------------------------->
                        <div>
                            <!-- echo $saldoDiarioUSER[0]->sum -->
                            <p class="valor-cartao"> R$
                                <?=$saldoDistrDoadoAguardDoacao[0]->saldo_doado?>
                            </p>
                        </div>
                        <!------------------------------------------------------------->
                        <p class="legenda">Doados</p>
                    </div>

                    <!------------------------------------------------------------->
                 
                    <!------------------------------------------------------------->
                    <!--Aguardando Doacao-->
                    <div class="cartao">
                        <div class="logo_az_cartao">
                            <img class="logo-cartao" src="../assets/Simbolo-Az-Cartao.png" alt="Carregando...">
                            <h1 class="merit_letra">MERIT</h1>
                            <p class="barra">/</p>
                            <img class="logo_final" src="../assets/AZmerit-Simbolo-Cartao.png" alt="carregando...">
                        </div>
                        <!------------------------------------------------------------->
                        <div>
                            <!-- echo $saldoDiarioUSER[0]->sum -->
                            <p class="valor-cartao"> R$
                                <?=$saldoDistrDoadoAguardDoacao[0]->aguardando?>
                            </p>
                        </div>
                        <!------------------------------------------------------------->
                        <p class="legenda">Aguardando Doação</p>
                    </div>
                    <!------------------------------------------------------------->
                </div>
            </div>

            <!----------------------------------------------------------------------------------------------------------------->
            <div class="conteiner_cartao-ET">

                <!------------------------------------------------------------->
              
                <!--Imagem-->
                <img src="../assets/homidaloja.png" alt="Carregando..." id="boneco-banco">
                <!------------------------------------------------------------->

                
            </div>

        </div>

    </main>

    <?php require '../includes/footer.php' ?>

</html>