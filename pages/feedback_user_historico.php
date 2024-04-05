<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Usuario;
use \App\Entity\Feedback;
use \App\Entity\Campanha;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//OBTÉM OBJETO CAMPANHA ATIVA
$id_campanhaAtiva = Campanha::getCampanhaAtiva();

// print_r($id_campanhaAtiva);
// die();

$remetente_ou_destinatario = isset($_POST['remetente_ou_destinatario']) ? $_POST['remetente_ou_destinatario'] : "destinatario";
$orderfiltro = isset($_POST['filtro']) ? $_POST['filtro'] : "=2";
$fil1 = isset($_POST['fil1']) ? $_POST['fil1'] : "seleciona-feed-colaborador principal-texto-opcao";
$fil2 = isset($_POST['fil2']) ? $_POST['fil2'] : "seleciona-feed-colaborador";
$fil3 = isset($_POST['fil3']) ? $_POST['fil3'] : "seleciona-feed-colaborador";
$ret = isset($_POST['ret']) ? $_POST['ret'] : "test";
$des = isset($_POST['des']) ? $_POST['des'] : "test principal";
$cor1 = isset($_POST['cor1']) ? $_POST['cor1'] : "muda-tela";
$cor2 = isset($_POST['cor2']) ? $_POST['cor2'] : "muda-tela focado";
$tor1 = isset($_POST['tor1']) ? $_POST['tor1'] : 'texto-opcao-feedback-colaborador focado';
$tor2 = isset($_POST['tor2']) ? $_POST['tor2'] : 'texto-opcao-feedback-colaborador';
$tor3 = isset($_POST['tor3']) ? $_POST['tor3'] : 'texto-opcao-feedback-colaborador';
$escondido = isset($_POST['escondido']) ? $_POST['escondido'] : 'conj_botao_editar escondido';
$opcao3= isset($_POST['enviado']) ? $_POST['enviado'] : "<div></div>";
$opcao4= isset($_POST['enviado']) ? $_POST['enviado'] : "<div></div>";



// Verifique qual botão foi clicado $escondido
if (isset($_POST['recebido'])) {
    // $obFeedbacksFiltrados = Feedback::getFeedbackHistDestfunction($id_usu,$orderfiltro);
    $remetente_ou_destinatario = "destinatario";
    $des = "test principal";
    $ret = "test";
    $cor1 = 'muda-tela';
    $cor2 = 'muda-tela focado';
    $orderfiltro = "= 1";

}

elseif (isset($_POST['enviado'])) {
    // $obFeedbacksFiltrados = Feedback::getFeedbackHistRemefunction($id_usu,$orderfiltro);
    $remetente_ou_destinatario = "remetente";
    $ret = "test principal";
    $des = "test";
    $cor1 = 'muda-tela focado';
    $cor2 = 'muda-tela';

    $opcao3= "
    <div class='$fil3'>
        <input type='submit' class='$tor3' id='antigo-filtro' name='Reprovados' value='Recusados'></input>
    </div>
    ";
    $opcao4="
    <div class='$fil2'>
        <input type='submit' class='$tor2' id='recente-filtro' name='Aprovados' value='Aprovados'></input>
    </div>
    ";

}

elseif(isset($_POST['Aprovados'])){
    $orderfiltro = "= 1";
    $fil1="seleciona-feed-colaborador";
    $fil2="seleciona-feed-colaborador principal-texto-opcao";
    $fil3="seleciona-feed-colaborador";
    $tor1 = 'texto-opcao-feedback-colaborador';
    $tor2 = 'texto-opcao-feedback-colaborador focado';
    $tor3 = 'texto-opcao-feedback-colaborador';

    if( $remetente_ou_destinatario == "remetente"){

        $opcao3= "
        <div class='$fil3'>
            <input type='submit' class='$tor3' id='antigo-filtro' name='Reprovados' value='Recusados'></input>
        </div>
        ";
        $opcao4="
        <div class='$fil2'>
            <input type='submit' class='$tor2' id='recente-filtro' name='Aprovados' value='Aprovados'></input>
        </div>
        ";
    }
}

elseif(isset($_POST['Reprovados'])){
    $remetente_ou_destinatario = "remetente";
    $ret = "test principal";
    $des = "test";
    $cor1 = 'muda-tela focado';
    $cor2 = 'muda-tela';

    $orderfiltro = "= 2";
    $fil1="seleciona-feed-colaborador";
    $fil3="seleciona-feed-colaborador principal-texto-opcao";
    $fil2="seleciona-feed-colaborador";
    $tor1 = 'texto-opcao-feedback-colaborador';
    $tor2 = 'texto-opcao-feedback-colaborador';
    $tor3 = 'texto-opcao-feedback-colaborador focado';

    $opcao3= "
    <div class='$fil3'>
        <input type='submit' class='$tor3' id='antigo-filtro' name='Reprovados' value='Recusados'></input>
    </div>
    ";
    $opcao4="
    <div class='$fil2'>
        <input type='submit' class='$tor2' id='recente-filtro' name='Aprovados' value='Aprovados'></input>
    </div>
    ";
    
}

elseif(isset($_POST['geral'])){
    $orderfiltro = '!= 4';
    $fil3="seleciona-feed-colaborador";
    $fil1="seleciona-feed-colaborador principal-texto-opcao";
    $fil2="seleciona-feed-colaborador"; 
    $tor1 = 'texto-opcao-feedback-colaborador focado';
    $tor2 = 'texto-opcao-feedback-colaborador';
    $tor3 = 'texto-opcao-feedback-colaborador';

    if( $remetente_ou_destinatario == "remetente"){

        $opcao3= "
        <div class='$fil3'>
            <input type='submit' class='$tor3' id='antigo-filtro' name='Reprovados' value='Recusados'></input>
        </div>
        ";
        $opcao4="
        <div class='$fil2'>
            <input type='submit' class='$tor2' id='recente-filtro' name='Aprovados' value='Aprovados'></input>
        </div>
        ";
    }

}

$obFeedbacksFiltrados= Feedback:: getFeedbackAproRecufunction($usuarioLogado['id_usuario'], $remetente_ou_destinatario, $orderfiltro);

//INCLUI O MENU USUARIO
$tituloPagina = 'HISTÓRICO DE FEEDBACKS';
require './../includes/menu_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
          <meta charset="utf-8">
          <title>Feedback</title>
          <link rel="stylesheet" href="../css/usuarios/historico_AprovRecu.css">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tomorrow">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow">
    </head>
<body class="home">
<!--TELA JV-->
<div class='caixa-geral-feedbak-colaborador'>
    <div class="borda">
        <form method="POST" class="formula">
            <!-- Campos de entrada ocultos para guardar o qual opção foi marcada -->
            <input type="hidden" name="remetente_ou_destinatario" value="<?= $remetente_ou_destinatario ?>">
            <input type="hidden" name="fil1" value="<?= $fil1 ?>">
            <input type="hidden" name="fil2" value="<?= $fil2 ?>"> 
            <input type="hidden" name="fil3" value="<?= $fil3 ?>">
            <input type="hidden" name="ret" value="<?= $ret ?>">
            <input type="hidden" name="des" value="<?= $des ?>">
            <input type="hidden" name="cor1" value="<?= $cor1 ?>">
            <input type="hidden" name="cor2" value="<?= $cor2 ?>">
            <input type="hidden" name="filtro" value="<?= $orderfiltro ?>">
            <input type="hidden" name="tor1" value="<?= $tor1 ?>">
            <input type="hidden" name="tor2" value="<?= $tor2 ?>">
            <input type="hidden" name="tor3" value="<?= $tor3 ?>">
            <input type="hidden" name="escondido" value="<?= $$escondido ?>">
            
            <div class="filtro-dest">    
                <div class="<?= $ret ?>">
                    <input type='submit' class='<?= $cor1 ?>' name='enviado' value='Enviados'></input>
                </div>
                <div class="<?= $des ?>">
                    <input type='submit' class='<?= $cor2 ?>' name='recebido' value='Recebidos'></input>
                </div>
            </div>
            <div class="filtros">
                <div class='<?= $fil1 ?>'>    
                    <input type='submit' class='<?=$tor1?>' id='todos-filtro' name='geral' value="Meus Feeds"></input>
                </div>
                <?=$opcao4?>
                <?=$opcao3?>
            </div>
        </form>
    </div>
    <div class='conteudo-feedbacks-colaborador'>
    <?php   
            
        foreach ($obFeedbacksFiltrados as $elemento) {
            if($elemento['status']=='APROVADO'){

                $corBorda = "var(--cor-laranja-az)";
                $corBorda2 = "transparent";
                $corTitulo = "var(--cor-branca-para-fundos-escuros)";
                $idF=0;

            }elseif($elemento['status']=='REPROVADO'){
            
                $corBorda = "var(--cor-vermelha)";
                $corBorda2 = $corBorda;
                $corTitulo = "var(--cor-vermelha)";
                
                if($ret=="test principal"){
                    $escondido = "conj_botao_editar";
                    $idF=$elemento['id'];
                }else{
                    $escondido = "conj_botao_editar escondido";
                    $idF=0;
                }
            

            }elseif($elemento['status']=='REPROVADO E EDITADO'){
            
                $corBorda = "var(--cor-vermelha)";
                $corBorda2 = $corBorda;
                $corTitulo = "var(--cor-vermelha)";
                $escondido = "conj_botao_editar escondido";
                $idF=0;
                
            }else{
                $corBorda = "var( --cor-cinza)";
                $corBorda2 = $corBorda;
                $corTitulo = "var( --cor-cinza)";
                $escondido = "conj_botao_editar escondido";
                $idF=0;
            }

        ?>
        <div class="container-card">
            <div class="card">
                <div class="card-frente" style="border-color:<?=$corBorda2?>">
                    <div class="card-frente-conteudo">
                        <img src="..\assets\Icone-Recebido (1).svg" alt="icone.png" class="icone-azcoin-adicionada">
                        <h2 class="valor-azcoin-historico"><?=$elemento['valor']?></h2>
                    </div>
                    <img src="<?=$elemento['img_des']?>" alt="" class="img-feed-frente">
                </div>
                <div class="card-tras" style="border-color: <?=$corBorda?>">
                    <div class="card-tras-conteudo">
                        <div class="carde-cabecalho">
                            <img src="<?= $elemento['img_rem'] ?>" alt="remetente.png" class="imagem-envio remetente">
                            <div class="seta" id="arrowAnim">
                                <div class="arrowSliding">
                                    <div class="arrow"></div>
                                </div>
                                    <div class="arrowSliding delay1">
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="arrowSliding delay2">
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="arrowSliding delay3">
                                        <div class="arrow"></div>
                                    </div>
                            </div>
                            <img src="<?= $elemento['img_des'] ?>" alt="destinatario.png" class="imagem-envio destinatario">
                        </div>
                        <div class="carde-feedback">
                            <div class="identificacao-feedback">
                                <p class="nome-remetente"><?=$elemento['nome_rem']?></p>
                                <p class="nome-destinatario"><?=$elemento['nome_des']?></p>
                            </div>
                            <div class="tes">
                                <h3 style="color: <?=$corTitulo?>;">Feedback</h3>
                                <p class="feedback-enviado"><?=$elemento['mensagem']?></p>
                                <a class="<?=$escondido?>" href="edit_feedReprov_user.php?id_feedreprov=<?=$idF?>">EDITAR</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            ?>
        </div>
    <?php } ?>
    </div>
</div>
</body>
<?php require '../includes/footer.php' ?>
</html>
