<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use App\Entity\Produto;
use \App\Session\Login;


//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//INSTANCIA UMA VARIAVEL QUE CONECTA A CLASSE PRODUTO
$objProd = new Produto;

$query1 = 'select sum(qde_troca_produto), id_produto from troca_produto group by id_produto order by sum desc';

// $query2 ='select id_produto  from produto where id_status_produto = 1';

//BUSCA TODOS OS PRODUTOS DO BANCO DE DADOS
$prods = $objProd->getProdCardsLojaUser();

//BUSCA OS PRODUTOS MAIS VENDIDOS E ATIVOS DA CAMPANHA ATIVA
//$obMaisVendidosDeTodosOsTempos = $objProd
$todosProdutos = $objProd->getProdutos();

// echo '<pre>';
// print_r($prods);
// echo '</pre>';
// exit;

$carrosel = '';
$card = '';

$cont=0;

foreach($prods as $produto){
    $cont++;
    $carrosel.=
    ' 
    <a href="./comprar_produto_user.php?id_produto='.$produto->id_produto.'">
        <img class="carousel-item carousel-item-'.$cont.' " src=" '.$produto->imagem.' "alt="'.$produto->nome.'" >
    </a>    
     ';
    
}
foreach($todosProdutos as $produto){
    $card.=
    '   <div class="img-card">
        <a href="./comprar_produto_user.php?id_produto='.$produto->id_produto.'">
            <img class="imagem" src="'.$produto->imagem.'" alt="'.$produto->nome.'">
        </a>
        </div>

    ';
}
//INCLUI O MENU USUARIO
$tituloPagina = 'LOJA';
require './../includes/menu_user.php';

?>

<div class="loja">
    
    <h1 class = "titulo_loja">LOJA</h1>
    <div class="carousel"> 
            <div class='carousel-container'>
                                        
                    <?php echo $carrosel;?>
                    <div class="carousel-controls">
                        
                    </div>
            </div>

    </div>
    
    <div id="maisvendidos" class="container">
                <?php echo $card;?>       
    </div>

</div>
    
    

    


<script src="../js/loja.js" defer></script>
<?php require '../includes/footer.php' ?>
