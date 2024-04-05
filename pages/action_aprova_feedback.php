<?php

require __DIR__.'../../vendor/autoload.php';
use \App\Entity\Feedback;

$objAprova = new Feedback;

$id_feedback = json_decode(file_get_contents('php://input'), true);

$aprovado = $objAprova->aprovarFeedback($id_feedback);

if($aprovado) {
    $send = ["status" => "OK"];  
}

echo json_encode($send);
