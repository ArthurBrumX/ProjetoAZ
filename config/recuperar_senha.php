<?php
session_start();
require __DIR__.'../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 
use \App\Entity\Usuario;

$mail = new PHPMailer(true);
$obUser = new Usuario;

?>

<div class="msg_atualizar">
    <?php
        if (isset($_SESSION['msg'])) {
             echo $_SESSION['msg'];
    
            // Limpar a mensagem da sessão para não exibi-la novamente após atualizações
            unset($_SESSION['msg']);
    }
    ?>
</div>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Senha</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bodyLogin">

     <div class="janelaModal" id="janelaModal"> <!-- div do modal -->
        <div class="modalRecu">
            <p class = "p_modal">Foi enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha.</p>
            <button class="fechar_recu" id="fechar_recu" onclick="fechar()">OK</button>
        </div>
    </div>


   <?php

    
    if (isset($_POST['SendRecupSenha'])){
        $fil = 'id_usuario, email';
        $result_usuario = Usuario::getUsuarioRecuperarSenha("email = '" . $_POST['email'] . "'",null, 1, $fil);

    

        if(($result_usuario > 0)){
            $chave_recuperar_senha = password_hash($result_usuario->id_usuario, PASSWORD_DEFAULT);
            // echo "<br>chave: $chave_recuperar_senha<br>";
            $obUser->email = $result_usuario->email;
            $obUser->id_usuario = $result_usuario->id_usuario;
            $obUser-> recuperar_senha = "$chave_recuperar_senha";
        

            if ($obUser->atualizarRecuperarSenha()) {
                $link = "http://192.168.22.9/fabrica275/Projeto-AZ/config/atualizar_senha.php?chave=$chave_recuperar_senha";
                echo $link;  

    
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  

                $mail->isSMTP();                                       
                $mail->Host       = 'smtp.gmail.com';                     
                $mail->SMTPAuth   = true;                                 
                $mail->Username   = 'fabrica.hub.academy@gmail.com';                //email da fabrica nessa linha  
                $mail->Password   = 'ciaiabsuzjimabht';                            //senha fabrica
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                $mail->Port       = 465; 
            
                $mail->setFrom('AZMerit@gmail.com', 'Atendimento AZMerit'); 
                $mail->addAddress($obUser->email);

                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Recuperar senha';
                $mail->Body    = "Você solicitou a alteração da senha.</b></b> Para continuar o processo de alteração da sua senha, clique no link abaixo ou cole o endereço no seu navegador:</b></b><a href='".$link."'></a>" . $link;
                $mail->AltBody = "Você solicitou a alteração da senha.\n\nPara continuar o processo de alteração da sua senha, clique no link abaixo ou cole o endereço no seu navegador:\n\n" . $link;;

                $mail->send();
                ?>
                <script>
                    function abrirModal(){
                        const modal = document.getElementById('janelaModal')
                        modal.classList.add('abrir')
                    }
                    var mostrarModal = 1;
                    if (mostrarModal == 1){
                        abrirModal();
                    }
                </script>
                <?php
            }
            else {
                echo "Erro na execução";
            }
        }
        else{
            ?>

            <div class="msgErroRecu">
              <p class="p_msgErro">Usuário não encontrado!</p>
            </div>

            <?php
        }
    }
    ?>

    <form class="form-recuperar" action="" method="POST" autocomplete="on">
            <h1 class="text_h1">Recuperar Senha</h1>
            <div class="campo_recu">
                <svg class="icons-login" width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 1C6.3724 1 1 6.3724 1 13C1 19.6276 6.3724 25 13 25C19.6276 25 25 19.6276 25 13C25 6.3724 19.6276 1 13 1Z" stroke="#D75B36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4.59961 21.4001C4.59961 21.4001 5.31477 19.0001 12.9996 19.0001C20.6845 19.0001 21.3996 21.4001 21.3996 21.4001M12.9989 15.7647C14.1106 15.7647 15.1768 15.3346 15.9629 14.569C16.749 13.8034 17.1906 12.7651 17.1906 11.6824C17.1906 10.5997 16.749 9.56135 15.9629 8.79577C15.1768 8.0302 14.1106 7.6001 12.9989 7.6001C11.8872 7.6001 10.821 8.0302 10.0349 8.79577C9.2488 9.56135 8.80718 10.5997 8.80718 11.6824C8.80718 12.7651 9.2488 13.8034 10.0349 14.569C10.821 15.3346 11.8872 15.7647 12.9989 15.7647Z" stroke="#D75B36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="email" name="email" id="ilogin" placeholder="E-mail"
                autocomplete="email" class="inputLogin" value="<?php if(isset($dados['email'])){echo $dados['email'];}?>">
            </div>

            <div class="lembrou_recu">
                <p class="p_recu">Lembrou? <a href="../index.php" class="a_recu"> clique aqui</a> para logar.</p>
            </div>

            <div class="div_botao_recu">
                <input type="submit" value="Recuperar" class="entrar_recu" name="SendRecupSenha">
            </div>

      </form>

<script src="../js/script.js"></script>
</body>
</html>