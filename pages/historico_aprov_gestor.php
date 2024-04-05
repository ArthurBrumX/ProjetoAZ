<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;

//OBRIGADO O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//INCLUI O MENU GESTOR
require './../includes/menu_gestor.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historico de Aprovação</title>
    <link rel="stylesheet" href="..\css\usuarios\lista_usuario.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tomorrow">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow">
  </head>
<body>
    <?php
    $fundo1 = 'filtro'; 
    $fundo2 = 'filtro focos';
    $filtro = 'order by data_analise, hora_analise';

    if(isset($_POST['recente'])){
        $fundo1 = 'filtro';
        $fundo2 = 'filtro focos';
        $filtro = 'order by data_analise, hora_analise';
    }
    elseif(isset($_POST['antigos'])){
        $fundo2 = 'filtro';
        $fundo1 = 'filtro focos';
        $filtro = 'order by data_analise DESC, hora_analise';
    }
    
    ?>
    <div class='caixa-geral-feedbak-colaborador'>
        <div class="borda">
            <div class="conjunto-feed">
                <form method="POST" class="cabecalho">
                    <div class='<?=$fundo1?>'>
                        <input type="submit" value="Recente" name="antigos" class="opcao">
                    </div>
                    <div class='<?=$fundo2?>'>
                        <input type="submit" value="Antigos" name="recente" class="opcao">
                    </div>
                </form>
            </div>
            <?php
            $feedback = $user->listarAprov($filtro);
            echo '<div class="caixa-feeds">';
            foreach ($feedback as $elemento){
                    ?>
                    <div class="container-card">
                        <div class="card">
                            <div class="card-frente">
                                <div class="card-frente-conteudo">
                                    <div class="gestor-correspondente">
                                        <div class="info-gestor">
                                            <div class="simb">
                                                <img src="<?=$elemento['img_gestor']?>" alt="gestor.png" class="foto-gestor">
                                            </div> 
                                            <div class="por">
                                                <p class="nome-aprovador"><?=$elemento['nome_gestor']?></p>
                                            </div>   
                                        </div>
                                        <div class="info-aprova">
                                            <div class="simbAprov">
                                                <img src="img\Aprovado-icon.png" alt="aprovado.png" class="iconAprova">
                                            </div>
                                            <p class="data"><?=date("d/m/Y", strtotime($elemento['data_analise']))?></p>
                                        </div>
                                    </div>
                                    <div class="motivo">
                                        <h3 class="titulo-card"> Justificativa </h3>
                                        <p class="justificativa"><?=$elemento['justificativa']?></p>
                                    </div>
                                    <div class="valor">
                                        <img src="img/Icone-Recebido (1).svg" alt="icone.png" class="icone-azcoin-adicionada">
                                        <h2 class="valor-azcoin-historico"><?=$elemento['valor']?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-tras">
                                <div class="card-tras-conteudo">
                                    <div class="carde-cabecalho">
                                        <img src="<?=$elemento['img_remetente']?>" alt="remetente.png" class="imagem-envio remetente">
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
                                        <img src="<?=$elemento['img_destinatário']?>" alt="destinatario.png" class="imagem-envio destinatario">
                                    </div>
                                    <div class="carde-feedback">
                                        <div class="identificacao-feedback">
                                            <p class="nome-remetente"><?=$elemento['nome_remetente']?></p>
                                            <p class="nome-destinatario"><?=$elemento['nome_destinatário']?></p>
                                        </div>
                                        <div class="tes">
                                            <h2 class="nome-campanha"><?=$elemento['campanha']?></h2>
                                            <h3 class="feedback-titulo">Feedback</h3>
                                            <p class="feedback-enviado"><?=$elemento['feed']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>