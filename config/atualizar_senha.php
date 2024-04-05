<?php
session_start();
require __DIR__.'../../vendor/autoload.php';
use \App\Entity\Usuario;

$obUser = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar senha</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bodyLogin">

    <div class="janelaModal" id="janelaModal"> <!-- div do modal -->
        <div class="modalRecu">
            <p class = "p_modal">Senha atualizada com sucesso.</p>
            <button class="fechar_atu" id="fechar_recu" onclick="fechar()">OK</button>
        </div>

    </div>
    <?php
       $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);

        if(!empty($chave)){
            $fil = 'id_usuario';
            $result_usuario = Usuario::getUsuarioRecuperarSenha("recuperar_senha = '" . $chave. "'",null, 1, $fil);

            if ($result_usuario !== null && is_object($result_usuario)){
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($dados['SendNovaSenha'])){                    
                    $obUser->id_usuario = $result_usuario->id_usuario;
                    $obUser->recuperar_senha = 'NULL';
                    $obUser->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
                    
                    

                    if ($obUser->atualizarSenha()){
                        ?>
                        <script>
                        function abrirModal(){
                            const modal = document.getElementById('janelaModal')
                            modal.classList.add('abrir')
                            
                        }
                        var mostrarModal = 1;

                        if (mostrarModal == 1) {
                            abrirModal();
                         }
                        </script>

                        <?php
                    } else {
                        echo "Erro na execução";
                    }
                }
            }
            else{
                $_SESSION['msg'] = "<p class='p_msgErroAtu'>Link inválido, Solicite um novo link."; 
                header('Location:recuperar_senha.php'); //TALVEZ TENHA QUE MUDAR ESSE LINK
                
            }
        }
        else{
            $_SESSION['msg'] = "<p class='p_msgErroAtu'>Link inválido, Solicite um novo link."; 
            header('Location:recuperar_senha.php'); //TALVEZ TENHA QUE MUDAR ESSE LINK
        }
    ?>

    <form method="POST" class="form-recuperar">
        <?php
        $usuario = "";
        if(isset($dados['senha'])){
            $usuario = $dados['senha'];
        }
        ?>
        <h1 class="text_h1">atualizar senha</h1>
        <div class="campo_recu">

            <svg class="icons-login" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18.6974 10.6047C18.2397 10.6047 17.8602 10.2251 17.8602 9.76744V7.53488C17.8602 4.0186 16.8667 1.67442 11.9997 1.67442C7.13275 1.67442 6.13926 4.0186 6.13926 7.53488V9.76744C6.13926 10.2251 5.75973 10.6047 5.30205 10.6047C4.84438 10.6047 4.46484 10.2251 4.46484 9.76744V7.53488C4.46484 4.29767 5.24624 0 11.9997 0C18.7532 0 19.5346 4.29767 19.5346 7.53488V9.76744C19.5346 10.2251 19.1551 10.6047 18.6974 10.6047Z" fill="#D75B36"/>
              <path d="M12 20.0927C10.0018 20.0927 8.37207 18.463 8.37207 16.4648C8.37207 14.4667 10.0018 12.8369 12 12.8369C13.9981 12.8369 15.6279 14.4667 15.6279 16.4648C15.6279 18.463 13.9981 20.0927 12 20.0927ZM12 14.5113C10.9283 14.5113 10.0465 15.3932 10.0465 16.4648C10.0465 17.5364 10.9283 18.4183 12 18.4183C13.0716 18.4183 13.9535 17.5364 13.9535 16.4648C13.9535 15.3932 13.0716 14.5113 12 14.5113Z" fill="#D75B36"/>
              <path d="M17.5814 23.9999H6.4186C1.49581 23.9999 0 22.5041 0 17.5813V15.3488C0 10.426 1.49581 8.93018 6.4186 8.93018H17.5814C22.5042 8.93018 24 10.426 24 15.3488V17.5813C24 22.5041 22.5042 23.9999 17.5814 23.9999ZM6.4186 10.6046C2.42233 10.6046 1.67442 11.3637 1.67442 15.3488V17.5813C1.67442 21.5665 2.42233 22.3255 6.4186 22.3255H17.5814C21.5777 22.3255 22.3256 21.5665 22.3256 17.5813V15.3488C22.3256 11.3637 21.5777 10.6046 17.5814 10.6046H6.4186Z" fill="#D75B36"/>
            </svg>

            <div class="div_senha">
                <input type="password" name="senha" id="senha" placeholder="Senha" autocomplete="current-password" requi red minl ength="4" maxlength="20" class="inputLogin" value="<?php if(isset($dados['senha'])){echo $dados['senha'];}?>" >
                <i class="bi bi-eye-fill" onclick="mostrarSenha()" id="btn-senha"></i>
            </div>

        </div>
        
        <div class="lembrou_recu">
            <p class="p_recu">Lembrou? <a href="../index.php" class="a_recu"> clique aqui</a> para logar.</p>
        </div>

        <div class="div_botao_recu">
            <input type="submit" value="Atualizar" name="SendNovaSenha" class="entrar_recu">
        </div>

    </form>
        
<script src="../js/script.js"></script>
</body>
</html>