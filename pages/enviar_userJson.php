<?php

require __DIR__.'../../vendor/autoload.php';

use \App\Entity\Usuario;
use App\Entity\Campanha;
use \App\Entity\Feedback;
use \App\Entity\Carteira;

$return = '';
if(isset($_POST['quantia'])){
    $campAtiva = campanha::getCampanhaAtiva();
    $feed = new Feedback();
    $feed->remetente_usuario = $_POST['usuariologado'];
    $feed->destinatario_usuario = $_POST['Colaborador'];

    // Remover pontos e substituir vírgula por ponto
    $quantia = str_replace(['.', ','], ['', '.'], $_POST['quantia']);
    $feed->qde_az_enviado = $quantia;

    $feed->mensagem = $_POST['mensagem'];
    $feed->id_campanha = $campAtiva->id_campanha;

    $saldo = Carteira::getCarteira($feed->remetente_usuario);
    $saldo_doacao = $saldo->saldo_doacao_usuario;
    $saldo_doacao_att = $saldo_doacao - $quantia;

    // enviando para saldo pendente 
    // $carteira = new Carteira();
    // $saldoPendenteAnterior = $saldo->saldo_pendente_aprovacao;
    // $carteira->saldo_pendente_aprovacao = $quantia + $saldoPendenteAnterior; COLUNA REMOVIDA DO BANCO
    // $carteira->id_usuario = $_POST['usuariologado'];

    // $carteira->saldo_doacao_usuario = $saldo_doacao_att;
    $result = false;

    if($feed->enviarFeed()){
        $result = true;
    }
    

    if($result == true){
        $return = [
            'status' => "OK"
        ];
    }else{
        $return = [
            'status' => 'ERROR' 
        ];
    }

}
echo json_encode($return);

