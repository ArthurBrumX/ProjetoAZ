<?php

require __DIR__.'/vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Usuario;

//OBRIGA O USUÁRIO A NÃO ESTAR LOGADO
Login::requireLogout();

//MENSAGEM DE ALERTA
$alertaLogin = '';

//VALIDAÇÃO DO POST
if(isset($_POST['botaoLogin'])){

  //BUSCA USUÁRIO POR E-MAIL
  $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);

  //VALIDA A INSTÂNCIA E A SENHA
  if(!$obUsuario instanceof Usuario || !password_verify($_POST['senha'],$obUsuario->senha)){
    $alertaLogin = 'E-mail ou senha inválidos';
  }
  else if($obUsuario instanceof Usuario && password_verify($_POST['senha'],$obUsuario->senha)){
    //LOGA O USUÁRIO
    Login::login($obUsuario);
  }
}

$alertaLogin = !empty($alertaLogin) ? '<div class ="msg_atualizar">'.$alertaLogin.'</div>' : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela Login</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bodyLogin">

  <img src="./img/produtos/thiago-removebg.png" alt="Fundo laranja" id="atorLogin">
  <div class="loader">
    <img src="./img/produtos/0099.png" alt="Moeda" id="moedaFrente">
  </div>

  <section id="sectionLogin">
    
    <div class="imgLogin">
      <img src="./img/produtos/logo_branca (1).png" alt="..." id="img-login">
    </div>
    
    <div class="formDiv-login">
      <form class="formLogin" action="" method="POST" autocomplete="on">
        <?=$alertaLogin?>
        
        <div class="campo">
          <svg class="icons-login" width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 1C6.3724 1 1 6.3724 1 13C1 19.6276 6.3724 25 13 25C19.6276 25 25 19.6276 25 13C25 6.3724 19.6276 1 13 1Z" stroke="#D75B36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M4.59961 21.4001C4.59961 21.4001 5.31477 19.0001 12.9996 19.0001C20.6845 19.0001 21.3996 21.4001 21.3996 21.4001M12.9989 15.7647C14.1106 15.7647 15.1768 15.3346 15.9629 14.569C16.749 13.8034 17.1906 12.7651 17.1906 11.6824C17.1906 10.5997 16.749 9.56135 15.9629 8.79577C15.1768 8.0302 14.1106 7.6001 12.9989 7.6001C11.8872 7.6001 10.821 8.0302 10.0349 8.79577C9.2488 9.56135 8.80718 10.5997 8.80718 11.6824C8.80718 12.7651 9.2488 13.8034 10.0349 14.569C10.821 15.3346 11.8872 15.7647 12.9989 15.7647Z" stroke="#D75B36" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <input type="email" name="email" id="ilogin" placeholder="E-mail" autocomplete="email" required maxlength="30" class="inputLogin">
        </div>

        <div class="campo">
          <svg class="icons-login" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.6974 10.6047C18.2397 10.6047 17.8602 10.2251 17.8602 9.76744V7.53488C17.8602 4.0186 16.8667 1.67442 11.9997 1.67442C7.13275 1.67442 6.13926 4.0186 6.13926 7.53488V9.76744C6.13926 10.2251 5.75973 10.6047 5.30205 10.6047C4.84438 10.6047 4.46484 10.2251 4.46484 9.76744V7.53488C4.46484 4.29767 5.24624 0 11.9997 0C18.7532 0 19.5346 4.29767 19.5346 7.53488V9.76744C19.5346 10.2251 19.1551 10.6047 18.6974 10.6047Z" fill="#D75B36"/>
            <path d="M12 20.0927C10.0018 20.0927 8.37207 18.463 8.37207 16.4648C8.37207 14.4667 10.0018 12.8369 12 12.8369C13.9981 12.8369 15.6279 14.4667 15.6279 16.4648C15.6279 18.463 13.9981 20.0927 12 20.0927ZM12 14.5113C10.9283 14.5113 10.0465 15.3932 10.0465 16.4648C10.0465 17.5364 10.9283 18.4183 12 18.4183C13.0716 18.4183 13.9535 17.5364 13.9535 16.4648C13.9535 15.3932 13.0716 14.5113 12 14.5113Z" fill="#D75B36"/>
            <path d="M17.5814 23.9999H6.4186C1.49581 23.9999 0 22.5041 0 17.5813V15.3488C0 10.426 1.49581 8.93018 6.4186 8.93018H17.5814C22.5042 8.93018 24 10.426 24 15.3488V17.5813C24 22.5041 22.5042 23.9999 17.5814 23.9999ZM6.4186 10.6046C2.42233 10.6046 1.67442 11.3637 1.67442 15.3488V17.5813C1.67442 21.5665 2.42233 22.3255 6.4186 22.3255H17.5814C21.5777 22.3255 22.3256 21.5665 22.3256 17.5813V15.3488C22.3256 11.3637 21.5777 10.6046 17.5814 10.6046H6.4186Z" fill="#D75B36"/>
          </svg>

          <div class="div_senha">
            <input type="password" name="senha" id="senha" placeholder="Senha" autocomplete="current-password" required minlength="4" maxlength="20" class="inputLogin">
            <i class="bi bi-eye-fill" onclick="mostrarSenha()" id="btn-senha"></i>
          </div>
        </div>

        <a href="./config/recuperar_senha.php" class="botao">Esqueci minha senha.</a>

        <div class="EntrarLogin"> 
          <input type="submit" value="ENTRAR" class="entrar" name="botaoLogin">
        </div>

      </form>
    </div>

  </section>
<script src="./js/script.js"></script>
</body>
</html>