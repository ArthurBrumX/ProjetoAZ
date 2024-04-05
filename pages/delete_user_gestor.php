<?php 

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Usuario;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//GET USUARIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

if(isset($_GET ['id_usuario'])){
    $id = $_GET['id_usuario'];
    $afortunado = Usuario::getUsuario($id);
};
if($afortunado->id_perfil_usuario==1){
    $tipoP = "Administrador";
}elseif($afortunado->id_perfil_usuario==2){
    $tipoP = "Gestor";
}else{
    $tipoP = "Colaborador";
};

if($afortunado->id_status_user==1){
    $mudar = 2;
    $text = "Inativar";
}
else{
    $mudar = 1;
    $text = "Ativar";
}

if(isset($_POST['usuario_selecionado'])){

    $afortunado->id_status_user=$mudar;
    $afortunado->atualizar();

    header('Location: listar_user_gestor.php');
    exit();

};

//INCLUI O MENU GESTOR
$tituloPagina = 'INATIVAR USUÁRIO';


require './../includes/menu_gestor.php';
?>
<div class="tudo_del">
    <div class="caixa_delete">
        <h2 class="titulo_del" texto><?=$text?> Perfil ?</h2>
        <div class="usuario">
            <h3 class="nome_usuario"> <?=$afortunado->nome?> </h3>
            <img class="img_usuario" src="<?=$afortunado->imagem?>">
            <h4 class="tipo_usuario"><?=$tipoP?></h4>
        </div>
        <form class="conj_botoes_delete" method="post" action="">
            <input class="botao_del" type="submit" name="usuario_selecionado" value="Confirmar">
            <a class="botao_cancela" href="listar_user_gestor.php">Voltar</a>
        </form>
    </div>
</div>