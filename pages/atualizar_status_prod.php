<?php 
//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Produto;

//OBRIGADO O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//INCLUI O MENU GESTOR

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $objProd = new Produto;
    $produto = $objProd->getProduto($id);
    $id_validacao = $produto->id_status_produto;

    if($id_validacao == 1){
        $objProd->mudarStatusProduto($id,2);
        header("location: listar_produto_gestor.php");
    }
    elseif($id_validacao == 2){
        $objProd->mudarStatusProduto($id,1);
        header("location: listar_produto_gestor.php");  
    }
}
