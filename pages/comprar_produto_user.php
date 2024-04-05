<?php
//echo '<pre>';
//print_r($us);
//echo '</pre>';
//exit;

require __DIR__.'../../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Carteira;
use \App\Entity\Produto;
use \App\Entity\Usuario;
use \App\Session\Modal;


//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();
// $saldo = Usuario::getSaldoUsuario($usuarioLogado['id_usuario']);

$carteira = Carteira::getCarteira($usuarioLogado['id_usuario']);
$carteira_usuario = $carteira->id_carteira;

// echo '<pre>';
// print_r($carteira->saldo_recebido_feedback);
// echo '</pre>';
// exit;

if(isset($_GET['id_produto'])){

    $id_prod = $_GET['id_produto'];

    $produto = Produto::getProdutos('id_produto = '.$id_prod);

}

$ModalI= Modal::showModalInfor(null, " ", "CONTINUAR", " ");
echo $ModalI;

$tituloPagina = 'COMPRA DE PRODUTO';
require '../includes/menu_user.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>COMPRA DE PRODUTO</title>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    </head>
<body>

<!--TELA HOME USUARIO-->
<div class="tela-compra-produto-user">
    <div class="main">
        <div class="descricao_produto">
            <div class="produto">
                <h2 class="h2_compra_produto"> <?=$produto[0]->nome;?> </h2>    
                <img  src="<?=$produto[0]->imagem;?>" alt="">
            </div>
            <div class="div_text_descricao_produto">
                <h3 class="h3_compra_produto">DESCRIÇÃO DO PRODUTO</h3>
                <p class="p_compra_produto"> <?=$produto[0]->descricao;?> </p>
                <h3 class="h3_compra_produto">Valor: <?=$produto[0]->valor_produto;?> AZ</h3>
                <h3 class="h3_compra_produto">Estoque: <?=$produto[0]->qde_produto;?></h3>
            </div>    
        </div>

        
        
        <div class="comprar_produto">
            
            <form method="POST" class="fomr-comprar-prod">
                <input type="hidden" id="id_produto" name="id_produto" value="<?=$produto[0]->id_produto;?>">

            
                <div class="quant_prod">
                        <div>
                            <h2>Troque agora!</h2>
                        </div>

                        <div class="quant_prod_select">
                            <h3>Quantidade:</h3>
                            <input type="number" value="1" id="quantidade_produto" name="quantidade_produto" class="quantidade_produto">
                        </div>
                </div>
            
                <button type="submit" class="comprar-form-btn" name="comprar" id="comprar">TROCAR</button>
            
            </form>
            <div class="avatar_comprar">
                <img src="../assets/boneco_produto.png" alt="">

            </div>
            
        </div>

    </div>
</div>
<script>
//Elementos html do modal informativo
const fecharModalInfor = document.getElementById('fechar-modal-infor');
const modalI = document.getElementById('modal-padrao-infor');
var msI = document.getElementById('descri-modal-infor');
var tituloModal = document.getElementById('texto-modal-infor')

//funcão responsavel por abrir o modal informativo
function abreModalInfor() {
    modalI.classList.remove("escondido");
    modalI.classList.add("amostra");
}

//função responsável por fechar o modal informativo
function saiModalInfor() {
    modalI.classList.remove("amostra");
    modalI.classList.add("escondido");
}

//FAZ O botão editavel fechar  o modal informativo.
document.getElementById("botao_editavel_infor").addEventListener("click", function(event) {
    event.preventDefault();
    saiModalInfor();
    window.location ='./loja_user.php';
})

//Faz o fade fechar o modal informativo de erro
modalI.addEventListener("click", function(event) {
    if (event.target === modalI) {
        saiModalInfor();
    }
});

//faz o botão X fechar o modal com formulario
fecharModalInfor.addEventListener("click", function(event) {
    event.preventDefault();
    saiModalInfor();
});

</script>
<?php
//CADASTRAR A TROCA DE PRODUTO
if(isset($_POST['id_produto'])){
    
    $id = $_POST['id_produto'];
    $qtdade = $_POST['quantidade_produto'];
    $debito = $qtdade * $produto[0]->valor_produto;
    $id_carteira = $carteira_usuario;
    $objProduto = new Produto();
    $objProduto->id_produto = $id;
    $objProduto->qde_produto = $qtdade;
    $objProduto->id_status_produto = $id_carteira;

    if($carteira->saldo_recebido_feedback < $debito){
        ?>
        <script>
            abreModalInfor();
            tituloModal.innerHTML = "ERRO AO REALIZAR TROCA";
            msI.innerHTML = "Saldo insuficiente!!";
            msI.style.color = "red";
            tituloModal.color = "red";
        </script>
        <?php
    }
    else if($qtdade <=0){
        ?>
        <script>
            abreModalInfor();
            tituloModal.innerHTML = "ERRO AO REALIZAR TROCA"
            msI.innerHTML = "É preciso escolher uma quantidade de produto válida maior que 0.";
            msI.style.color = "red";
            tituloModal.color = "red";
        </script>
        <?php
    }

    else if($qtdade > $produto[0]->qde_produto){
        ?>
        <script>
            abreModalInfor();
            tituloModal.innerHTML = "ERRO AO REALIZAR TROCA";
            msI.innerHTML = "Quantidade desejada maior do que disponivel em estoque!";
            msI.style.color = "red";
            tituloModal.color = "red";
        </script>
        <?php
       
    }
    else if($produto[0]->qde_produto <= 0){
        ?>
        <script>
            abreModalInfor();
            tituloModal.innerHTML = "ERRO AO REALIZAR TROCA";
            msI.innerHTML = "Produto indisponível para troca!!";
            msI.style.color = "red";
            tituloModal.color = "red";
        </script>
        <?php

    }
    else {
        $result = $objProduto->trocar_produto();
        $carteira->atualizarSaldoCarteira($carteira_usuario,$debito);

        if($result){
            ?>
            <script>
                abreModalInfor();
                tituloModal.innerHTML = "Troca efetuada com sucesso!!";
                msI.innerHTML = "Sua solicitação de troca foi enviada e recebida.";
                msI.style.color = "green";
                tituloModal.color = "green";
            </script>
            <?php

        }else{
            
            ?>
            <script>
                abreModalInfor();
                tituloModal.innerHTML = "Erro ao cadastrar sua Troca.";
                msI.innerHTML = "Sua solicitação de troca foi enviada mas não recebida. Tente Novamente mais tarde";
                msI.style.color = "red";
                tituloModal.color = "red";
            </script>
            <?php  
        }

    }
        
}

require '../includes/footer.php';
?>
