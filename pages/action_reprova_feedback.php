<?php

require __DIR__.'../../vendor/autoload.php';
use \App\Entity\Feedback;

$objReprova = new Feedback;

$id_feedback = $_POST['id'];
$mensagem = $_POST['mensagem'];

$dados=[
    'id_feedback'=>$id_feedback,
    'mensagem'=>$mensagem
];
    
$reprovado_analise = $objReprova->reprovarFeedbackAnalise($dados);
$reprovado_feedback = $objReprova->reprovarFeedback($id_feedback);

$send = '';
if($reprovado_feedback){
    $send = ["status" => "OK"];  
}

echo json_encode($send);
