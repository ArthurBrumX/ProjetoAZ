<?php

include '../vendor/autoload.php';

use \App\Entity\Feedback;

    if(isset($_POST['valor']) && isset($_POST['mensagem']) && isset($_POST['id']) && isset($_POST['campanha']) && isset($_POST['destinatario']) && isset($_POST['remetente']) && isset($_POST['saldo'])){
        
        $valor = floatval($_POST['valor']);
        
        if($valor != 0){
            
            if($_POST['mensagem'] != ""){

                    if(floatval($_POST['saldo'])>=$valor){

                        //CONSULTA O Feedback
                        $obFeed = new Feedback;
                        $obFeed = $obFeed::getFeedback($_POST['id']);

                        // Recupera os valores do formulário
                        $valor =  $_POST['valor'];
                        $mensagem = $_POST['mensagem'];
                        $id=$_POST['id'];
                        $idest= $_POST['destinatario'];
                        $idremet= $_POST['remetente'];
                        $campanha = $_POST['campanha'];

                        // Atualiza os valores usando a função update
                        $novoFeedback = new Feedback();

                        // Define os atributos do novo feedback
                        $novoFeedback->qde_az_enviado = $valor;
                        $novoFeedback->mensagem = $mensagem;
                        $novoFeedback->remetente_usuario = $idremet;
                        $novoFeedback->destinatario_usuario = $idest;
                        $novoFeedback->id_campanha = $campanha;

                        if($novoFeedback->enviarFeed()) {
                                    
                            $obFeed->atualizaFeedback('id_feedback= '.$obFeed->id_feedback,'id_status_feedback',4);
                            
                            // Redireciona após o envio bem-sucedido
                            
                            $return = ['status' => "sucesso",'mensagem' => "Seu feedback foi editado e enviado para análise."];

                            }else{
                                    // Trate o erro se a inserção falhar
                                    $return = ['status' => "falha",'mensagem' => "Erro ao  enviar o feedback. Tente novamente mais tarde."];

                                }

                    }
                    else{
                        // Trate o erro se o saldo for menor do que esta enviando
                        $return = ['status' => "falha", 'mensagem' => "Saldo da carteira Insuficiente."];
                    }
                }
            else{
                    // Trate o erro se a inserção falhar
            $return = ['status' => "falha",'mensagem' =>"É necessário deixar uma mensagem para enviar o feedback."];

                    }

        }
    }else{
        $return = ['status' => "falha",'mensagem' => "Digite um valor válido para o feedback"];
    }


echo json_encode($return);