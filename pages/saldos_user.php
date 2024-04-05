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
use \App\Entity\Carteira;
use \App\Entity\Campanha;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//CONSULTA A CARTEIRA
$obCarteira = Carteira::getCarteira($usuarioLogado['id_usuario']);

//CONSULTA A CAMPANHA ATIVA
$obCampanhaAtiva = Campanha::getCampanhaAtiva();

//SELECIONA TODOS OS FEEDBACKS FEITOS NA CAMPANHA VIGENTE
$obFeedbacksCampanhaAtiva = Feedback::getFeedbacks('id_campanha = '.$obCampanhaAtiva->id_campanha);

//GERA UM ARRAY COM OS FEEDBACKS APROVADOS (id_status_feedback = 1) QUE O USUÁRIO LOGADO RECEBEU ORDENANDO POR DATA E HORÁRIO COM LIMITE DE 20 RESULTADOS
$obFeedbacksRecebidos = Feedback::getFeedbacks('destinatario_usuario = '.$usuarioLogado['id_usuario'].' AND id_status_feedback = 1',' id_feedback DESC LIMIT 20');

//ADICIONA OS APELIDOS DOS OBJETOS(USUARIO) DENTRO DO ARRAY '$obFeedbackRecebidos'
$contador = -1;
foreach($obFeedbacksRecebidos as $row){
    $contador++;
    $apelido = Usuario::getUsuario($row->remetente_usuario);
    $apelido = $apelido->apelido;
    $obFeedbacksRecebidos[$contador]->apelido = $apelido;
}

//GERA UM ARRAY COM OS FEEDBACKS APROVADOS (id_status_feedback = 1) QUE O USUÁRIO LOGADO ENVIOU ORDENANDO POR DATA E HORÁRIO COM LIMITE DE 20 RESULTADOS
$obFeedbacksEnviados = Feedback::getFeedbacks('remetente_usuario = '.$usuarioLogado['id_usuario'].'  AND id_status_feedback = 1',' id_feedback DESC LIMIT 20');

//ADICIONA OS APELIDOS DOS OBJETOS(USUARIO) DENTRO DO ARRAY '$obFeedbacksEnviados'
$contador2 = -1;
foreach($obFeedbacksEnviados as $row){
    $contador2++;
    $apelido = Usuario::getUsuario($row->destinatario_usuario);
    $apelido = $apelido->apelido;
    $obFeedbacksEnviados[$contador2]->apelido = $apelido;
}

if(is_object($obCarteira) && property_exists($obCarteira, 'azcoins_recebidos')){
    $azcoins_recebidos = $obCarteira->saldo_recebido_feedback;
}
else {
    $azcoins_recebidos ='0';
}

if(is_object($obCarteira) && property_exists($obCarteira, 'azcoins_enviar')){
    $azcoins_enviar = $obCarteira->valor_recebido_campanha - $obCarteira->saldo_doacao_usuario ;
}
else {
    $azcoins_enviar ='0';
}

//INCLUI O MENU USUARIO
$tituloPagina = 'SALDOS';
require './../includes/menu_user.php';
?>
<body>
    <!--TELA SALDOS-->
    <div class="main-carteira">

        <div class="azscore">
            <div class="azcoinscore">
                <span id="textscore">AZCoin</span>
                <div class="valores">
                    <svg class="carteira" width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.5 1H3.5L2 1.5L1 3V4.5V5.5M1 5.5L3 6.5H5H23L24 7.5L24.5 8V9.5V10M1 5.5V16.5V18L1.5 18.5L2.5 19.5L4 20H21.5H23L24 19L24.5 17.5V16M24.5 10H26V12V16H24.5M24.5 10H20H19L18 10.5L17 11.5L16.5 12.5V14L17.5 15L18.5 16H20H24.5M12.5 13H13M13 13H15.5L10.5 18.5L10 19L5 13H7.5V7.5H12.5H13V13ZM22 4.5H3.5L3 4V3.5L4 3H21H21.5" stroke="#0A2334" stroke-linecap="round"/>
                        <circle cx="19.9502" cy="12.9502" r="0.75" fill="#0A2334"/>
                    </svg>
                    <img class="azcoinzinha" src="..\assets\moedaAZ.png">
                    <span><?= $azcoins_recebidos ?></span>
                </div>
            </div>
    
            <div class="azmeritscore">
                <span id="textscore">AZMerit</span>
                <div class="valores">
                    <svg class="carteira" width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.5 1H3.5L2 1.5L1 3V4.5V5V5.5M1 5.5L3.5 6.5H22L23.5 7L24.5 8V9.5V10H26V16H24.5V17.5V18.5L22.5 20H4L2 19.5L1 18V5.5ZM24 10H19.5L17.5 11L17 12L16.5 13L17 14.5L18 15.5L19.5 16H24M22 4.5H4L3 4L3.5 3H4H21M15 13.5H13V19H7.5V13.5H5L10 8L15 13.5Z" stroke="#0A2334" stroke-linecap="round"/>
                        <circle cx="19.9502" cy="12.9502" r="0.75" fill="#0A2334"/>
                    </svg>
                    <img class="azcoinzinha" src="..\assets\moedaAZ.png">
                    <span><?= $azcoins_enviar ?></span>
                </div>
            </div>
        </div>

        <div class="main-score-history">
            <span>Histórico de Transação</span>
            <div class="div-principal">
                <img class="mr-yellow" src="..\assets\mr-yellow.png">
                <div class="div-table">
                    <span>RECEBIDOS</span>
                    <div class="head-tabela">
                        <!--Nome, valor e data-->
                        <span class="span-nome">Nome</span>
                        <span class="span-valor">Valor</span>
                        <span class="span-data">Data</span>
                    </div>
                    <div class="tabela">
                        <?php
                            for($count = 0; $count<=$contador; $count++)
                            {
                                echo "<hr></hr>";
                                echo "<div class='linha-table'>";
                                    echo "<div class="."element-table".">";
                                        echo "<img class="."img-nome"." src="."../assets/transDar.png".">";
                                        echo "<span class="."span-nome".">".$obFeedbacksRecebidos[$count]->apelido."</span>";
                                    echo "</div>";
                                    echo "<div class="."element-table".">";
                                        echo "<img class="."azcoin"." src="."..\assets\moedaAZ.png".">";
                                        echo "<span class="."span-valor".">".$obFeedbacksRecebidos[$count]->qde_az_enviado."</span>";
                                    echo "</div>";
                                    echo "<div class="."element-table".">";
                                        echo "<span class="."span-data".">".date("d/m/Y", strtotime($obFeedbacksRecebidos[$count]->data_validacao))."</span>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        ?>
                        <hr></hr>
                    </div>
                </div>
                <hr class="linha-divisoria"></hr>
                <div class="div-table">
                    <span>ENVIADOS</span>
                    <div class="head-tabela">
                        <!--Nome, valor e data-->
                        <span class="span-nome">Nome</span>
                        <span class="span-valor">Valor</span>
                        <span class="span-data">Data</span>
                    </div>
                    <div class="tabela">
                        <?php
                            for($count = 0; $count<=$contador2; $count++)
                            {
                                echo "<hr></hr>";
                                echo "<div class='linha-table'>";
                                    echo "<div class="."element-table".">";
                                        echo "<img class="."img-nome"." src="."../assets/transReceber.png".">";
                                        echo "<span class="."span-nome".">".$obFeedbacksEnviados[$count]->apelido."</span>";
                                    echo "</div>";
                                    echo "<div class="."element-table".">";
                                        echo "<img class="."azcoin"." src="."..\assets\moedaAZ.png".">";
                                        echo "<span class="."span-valor".">".$obFeedbacksEnviados[$count]->qde_az_enviado."</span>";
                                    echo "</div>";
                                    echo "<div class="."element-table".">";
                                        echo "<span class="."span-data".">".date("d/m/Y", strtotime($obFeedbacksEnviados[$count]->data_validacao))."</span>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        ?>
                        <hr></hr>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<?php require '../includes/footer.php' ?>