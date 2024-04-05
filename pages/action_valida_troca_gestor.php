<?php

require __DIR__.'../../vendor/autoload.php';

use App\Entity\ControleEnvio;

$objControleEnvio = new ControleEnvio;

$id_troca = json_decode(file_get_contents('php://input'), true);

$aprovado = $objControleEnvio->atualizarStatusEnvioProduto($id_troca);

if($aprovado) {
    $send = ["status" => "OK"];  
}

echo json_encode($send);

