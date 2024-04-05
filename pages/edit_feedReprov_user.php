<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Feedback;
use \App\Entity\Usuario;
use \App\Entity\Campanha;
use \App\Session\Modal;
use \App\Entity\Carteira;
use \App\Entity\Analise;


//OBRIGADO O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//DADOS DA CAMPANHA ATIVA
$campanhaAtiva= Campanha::getCampanhaAtiva();

//BUSCA O ID DO FEEDBACK REPROVADO
if(!isset($_GET['id_feedreprov'])){
    header('location: ./feedback_user_historico.php?status=error');
    exit;
}



//CONSULTA O Feedback
$obFeed = new Feedback;
$obFeed = $obFeed::getFeedback($_GET['id_feedreprov']);

if($obFeed->id_status_feedback==4){
    header('location: ./feedback_user_historico.php?status=error');
    exit;
}

//CONSULTA O REMETENTE
$obRemetente = new Usuario;
$obRemetente = $obRemetente::getUsuario($obFeed->remetente_usuario);

//CONSULTA O DESTINATARIO
$obDestinatario = new Usuario;
$obDestinatario = $obDestinatario::getUsuario($obFeed->destinatario_usuario);


//CONSULTA A CAMPANHA ATIVA
$campanaAtiva= Campanha::getCampanhaAtiva();

//CONSULTA A CARTEIRA DO REMETENTE
$obCarRem= Carteira::getCarteira($obFeed->remetente_usuario);
$saldo = $obCarRem->saldo_doacao_usuario;

//CONSULTA A ANALISE
$obAna = new Analise;
$obAna = Analise::getAnalise($obFeed->id_feedback);
 
// echo '<pre>';
// print_r($saldo);
// echo '</pre>';
// exit;

//Criando o aviso em caso de erro ou irregularidades
$aviso = isset ($_POST['aviso']) ? $_POST['aviso'] : "";

//VALIDAÇÃO DO FEEDBACK
if (!$obFeed instanceof Feedback) {
    header('location: ./feedback_user_historico.php?status=error');
    exit;
}

//VERIFICA SE EXISTE OU NÃO MENSAGEM
if ($obAna->mensagem == ''){    
    $ms = "Justificativa Não Encontrada.";
}
else{
    $ms = $obAna->mensagem;
}

$modalForm = Modal::showModalForm("../assets/Boneco Pensando.png","Você tem certeza quanto suas alterações ?", "Salvar","Não terá como re-editar o feedback.");
$modalInfor = Modal::showModalInfor("../assets/Boneco Pensando.png","Erro na realização da Tarefa","");
$modalRedic = Modal::showModalDirec("../assets/Boneco Positivo.png","Feedback Enviado","feedback_user_historico.php"," ");
echo $modalForm;
echo $modalInfor;
echo $modalRedic;

$tituloPagina = "EDITAR FEEDBACK";
require './../includes/menu_user.php';

?>

<div class="edit_feedReprov_user_tudo">
    <div class="edit_feedReprov_caixa-total">
        <div class="edit_feedReprov_caixa-jusficativa-editar">
            <div class="titulo_rejeitado_feed">
                <h3 class="edit_feedReprov_titulo_reprov">REPROVADO</h3>
            </div>
            <div class="edit_feedReprov_caixa_perfils">
                
                <div class="edit_feedReprov_remetente">
                    <img class="edit_feedReprov_perfil_img" src="<?=$obRemetente->imagem?>">
                    <h4 class="edit_feedReprov_perfil_nome"><?=$obRemetente->apelido?></h4>
                </div>
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
                <div class="edit_feedReprov_destinatario">
                    <img class="edit_feedReprov_perfil_img" src="<?=$obDestinatario->imagem?>">
                    <h4 class="edit_feedReprov_perfil_nome"><?=$obDestinatario->apelido?></h4>
                </div>
            </div>
            <h3 class="edit_feedReprov_titulo">Justificativa</h3>    
            <p class="edit_feedReprov_mensagem-justificativa"><?=$ms?></p>
        </div>
        <div class="edit_feedReprov_caixa-form">
            <form action="" method="POST" class="edit_feedReprov_form" id="form-feed">
                <h2 class="edit_feedReprov_titulo_form">Editar Feedback</h2>
                <h4 class="aviso"><?=$aviso?></h4>

                <div class="edit_feedReprov_caixa-input">
                    <input type="hidden" value="<?=$obFeed->id_feedback?>" name="id">
                    <input type="hidden" value="<?=$campanaAtiva->id_campanha?>" name="campanha">
                    <input type="hidden" value="<?=$obFeed->destinatario_usuario?>" name="destinatario">  
                    <input type="hidden" value="<?=$obFeed->remetente_usuario?>" name="remetente">
                    <input type="hidden" value="<?=$$saldo?>" name="saldo">  
                    <input type="text" class="edit_feedReprov_input" name="valor" value="<?=ceil($obFeed->qde_az_enviado)?>" required>
                    <label class="edit_feedReprov_label">
                        <span class="edit_feedReprov_label-letra" style="--index: 0">V</span>
                        <span class="edit_feedReprov_label-letra" style="--index: 1">A</span>
                        <span class="edit_feedReprov_label-letra" style="--index: 2">L</span>
                        <span class="edit_feedReprov_label-letra" style="--index: 3">O</span>
                        <span class="edit_feedReprov_label-letra" style="--index: 4">R</span>
                    </label>
                </div>

                <div class="edit_feedReprov_areaTexto">
                    <textarea name="mensagem" id="msgFeedbackEdit" cols="38" rows="6" maxlength="240"  require><?=$obFeed->mensagem?></textarea>
                </div>

                <div>
                    <input type="submit" value="SALVAR" name="SALVAR" class="edit_feedReprov_botao_salvar" id="botao-submit">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../js/editFeed.js"></script>