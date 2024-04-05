<?php 

//Inclui o autoload
require __DIR__.'../../vendor/autoload.php';

//Dependencia
use \App\Session\Login;
use \App\Entity\Produto;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//GET USUARIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();
$prodexclui = new Produto;

if(isset($_GET ['id_produto'])){
    $id = $_GET['id_produto'];
    $prodexclui = Produto::getProduto($id);
    
};

if(isset($_POST['deleteprod'])){
    $prodexclui->excluirprod();
    header('Location: listar_produto_gestor.php');
    exit();
};

// require './../includes/menu_gestor.php';

?>
<div class="del_prod">
    <div class="caixa_delete">
        <h2 class="exclui_produto" texto>Deseja realmente excluir o produto ?</h2>
        <div class="produto">
            <h3 class="nome_produto"> <?=$prodexclui->nome?> </h3>
            <img class="img_produto" src="<?=$prodexclui->imagem?>">
            
        </div>
        <form class="conj_botoes_delete" method="post" action="">
            <input class="btndelprod" type="submit" name="deleteprod" value="Sim" href="listar_produto_gestor.php">
            <input class="botao_cancela" type="submit" name="desistir" value="Não" href="listar_produto_gestor.php">
        </form>
    </div>
</div>
?>