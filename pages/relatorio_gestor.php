<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';


//DEPENDÊNCIAS
use \App\Entity\Carteira;
use \App\Entity\Usuario;
use \App\Entity\Campanha;
use \App\Entity\Feedback;
use \App\Entity\Produto;
use \App\Session\Login;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//SELECIONA A CAMPANHA ATIVA
$obCampanhaAtiva = Campanha::getCampanhaAtiva();


$saldoColab = Usuario::saldoColaborador();

$totalFeedback = Feedback::getTotalFeedbacks();
$lastFeedbackEnviado = Feedback::getUltimoFeedbackEnviado();
$lastFeedbackRecebido = Feedback::getUltimoFeedbackRecebido();
$produtosMaisTrocado = Produto::getProdutoMaisTrocado();
$produtosMenosTrocado = Produto::getProdutoMenosTrocado();


$result = '';

  foreach($saldoColab as $colaborador){
    $recebidos = $colaborador->recebidos == null ? 0 : $colaborador->recebidos;
    $enviados = $colaborador->enviados == null ? 0 : $colaborador->enviados;

    $result .= '<tr class="linha_saldo_colaborador">
            <td class="moeda_saldo_colaborador">
                <span>'.$colaborador->nome.'</span>
            </td>
            <td class="moeda_saldo_colaborador">
                <span>'.$recebidos.'</span>
            </td>
            <td class="moeda_saldo_colaborador">
                <span>'.$enviados.'</span>
            </td>
            <td class="moeda_saldo_colaborador">
                <span>'.$colaborador->saldo_disponivel.'</span>
            </td>                               
        </tr>                   
    ';
}


//INCLUI O MENU GESTOR
$tituloPagina = 'INFORMAÇÕES GERAIS';
require './../includes/menu_gestor.php';

//https://css-tricks.com/random-numbers-css/
//https://www.w3schools.com/howto/howto_css_flip_card.asp
//https://pt.dreamstime.com/video-estoque-quadro-de-avisos-velho-do-aeroporto-video36154168

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Gestor</title>
  <link rel="stylesheet" href="../css/gestor/home.css">
</head>
<body>
    <!--TELA MENU GESTOR-->
    <div class="content">

        <span class="titulo-tabela"><strong>SALDO POR COLABORADOR</strong></span>
        <div class="box-artigo02">
            <div class="style-tabela">
                <table class="tabela-geral-colaborador">
                    <thead class="cab-geral-colaborador">
                        <tr class="titulo-cab-geral-colaborador">
                            <td class="top center">
                            <strong>Apelido</strong>
                            </td>
                            <td class="top center">
                            <strong>Saldo Recebido</strong>
                            </td>
                            <td class="top center"><strong>Saldo Enviados</strong></td>
                            <td class="top center"><strong>Saldo Disponível</strong></td>                 
                        </tr>
                    </thead>
                        <tbody class="saldo_colaborador">
                            <?=$result?>                
                        </tbody>    
                </table>
            </div>
        </div>

        <div class="box-artigo02">
            <div class="style-tabela">
            <table class="tabela-geral-colaborador">
                <thead class="cab-geral-colaborador">
                <tr class="titulo-cab-geral-colaborador">
                    <th class="top center">
                    <strong>Última Informações</strong>
                    </th>
                    <th class="top center">
                    <strong> Campanha: <?=$obCampanhaAtiva->nome_campanha?> </strong>
                    </th>                    
                </tr>
                </thead>

                <tbody class="saldo_colaborador_estatistica">
                <tr class="linha_saldo_colaborador">
                    <td class="moeda_saldo_colaborador">
                    <span>Total de Feedbacks</span>
                    </td>
                    <td class="moeda_saldo_colaborador">
                    <span> <?=$totalFeedback[0]->total_feedbacks?> </span>
                    </td>                    
                </tr>
                
                <tr class="linha_saldo_colaborador">
                    <td class="moeda_saldo_colaborador">
                    <span>Envio Feedback + Recente</span>
                    </td>
                    <td class="moeda_saldo_colaborador">
                    <span><?=$lastFeedbackEnviado[0]->nome;?></span>
                    </td>                    
                </tr>
            
                <tr class="linha_saldo_colaborador">
                    <td class="moeda_saldo_colaborador">
                    <span>Último Feedback Recebido</span>
                    </td>
                    <td class="moeda_saldo_colaborador">
                    <span> <?=$lastFeedbackRecebido[0]->nome;?> </span>
                    </td>                    
                </tr>
                
                <tr class="linha_saldo_colaborador">
                    <td class="moeda_saldo_colaborador">
                    <span>Produto Mais Trocado</span>
                    </td>
                    <td class="moeda_saldo_colaborador">
                    <span> <?=$produtosMaisTrocado[0]->nome;?> </span>
                    </td>
                </tr>
            
                <tr class="linha_saldo_colaborador">
                    <td class="moeda_saldo_colaborador">
                    <span>Produto Menos Trocado</span>
                    </td >
                    <td class="moeda_saldo_colaborador">
                    <span> <?=$produtosMenosTrocado[0]->nome;?> </span>
                    </td>
                </tr>
                     
                
                </tbody>
            </table>
            </div>
        </div>

    </div>
</body>
</html>

<?php require '../includes/footer.php' ?>