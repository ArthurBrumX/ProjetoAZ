<?php

require __DIR__.'/vendor/autoload.php';

define('TITLE', 'Editar Usuario');

//Define que usará a classe Usuario
use \App\Entity\Usuario;

//VALIDAÇÃO DO ID
if(!isset($_GET['id_usuario']) or !is_numeric($_GET['id_usuario'])){
    header('location: index.php?status=error');
    exit;
}

//CONSULTA USUARIO   
$obUser = Usuario::getUsuario($_GET['id_usuario']);

//VALIDAÇÃO 
if(!$obUser instanceof Usuario){
    header('location: index.php?status=error');
    exit;
}


//VERIFICA SE OS DADOS ESTÃO PREENCHIDOS NO POST
if(isset($_POST['nome'],$_POST['email'],$_POST['senha'],$_POST['apelido'])){
    $obUser->nome                 = $_POST['nome'];
    $obUser->email                = $_POST['email'];
    $obUser->senha                = $_POST['senha'];
    $obUser->apelido              = $_POST['apelido'];
    $obUser->id_perfil_usuario    = $_POST['perfil'];
    $obUser->atualizar();
    
    header('location: index.php?status=success');
    exit;
}

include __DIR__.'/includes/menu_user.php';
include __DIR__.'/includes/formulario.php';
include __DIR__.'/includes/footer.php';

?>