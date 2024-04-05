<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//Inclui o autoload
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Entity\Produto;
use \App\Db\Pagination;
use \App\Session\Login;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

// FILTRO DE BUSCA
// O ideal é usar o 'filter_input' para evitar que algum usuário mal intencionado tente expor alguma parte do código.
$busca = filter_input(INPUT_GET, 'busca');

//FILTRO DE STATUS
$Status = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_NUMBER_INT);
$Status = in_array($Status,['1','2']) ? $Status : '';

//CONDIÇÕES SQL
$condicoes = [
    strlen($busca) ? "nome ILIKE '%".str_replace(' ','%',$busca)."%'" : null,
    strlen($Status) ? "id_status_produto = "."'$Status'" : null,
];
//REMOVE POSIÇÕES VAZIAS
$condicoes = array_filter($condicoes);

//CLÁUSULA WHERE PARA MONTAR NO FILTRO
$where = implode(' AND ',$condicoes);
$order = "id_produto DESC";

//QUANTIDADE TOTAL DE PRODUTOS
$quantidadeProdutos = Produto::getQuantidadeProdutos($where);

//PAGINAÇÃO
$obPagination = new Pagination($quantidadeProdutos, $_GET['pagina'] ?? 1, 10);

//OBTÉM OS USUÁRIOS
$produtos = Produto::getProdutos($where,$order,$obPagination->getLimit());

//ALGUMA MENSAGEM QUE É PRA APARECER EM ALGUM LUGAR
$mensagem = '';
if(isset($_GET['status'])){
    switch($_GET['status']){
        case 'success':
            $mensagem = '<div>Ação executada com sucesso!</div>';
            break;
        case 'error':
            $mensagem = '<div>Ação não executada!</div>';
            break;
        }
}

//ORGANIZA A LISTAGEM
$resultados = '';
foreach($produtos as $produto){

    //VARIAVEL 'perfilUsuario'
    if($produto->id_status_produto == 1){
        $statusProduto = 'EM ESTOQUE';
    }elseif($produto->id_status_produto == 2){
        $statusProduto = 'INDISPONíVEL';
    }else{
        $statusProduto = "INDETERMINADO";
    }if($produto->qde_produto == 0 OR $produto->id_qde_produto = NULL){
        $quant = "EM FALTA";
        $statusProduto = 'INDISPONíVEL';
    }else{
        $quant = $produto->qde_produto;
    }

    $resultados .= '<tr>
                        <td data-lable="Nome: ">'.$produto->nome.'</td>
                        <td data-lable="Descrição: ">'.$produto->descricao.'</td>
                        <td data-lable="Status: ">'.$statusProduto.'</td>
                        <td data-lable="Quantidade: ">'.$quant.'</td>
                        <td data-lable="Valor AZCoin: ">'.$produto->valor_produto.'</td>
                        <td data-lable="Editar: ">
                            <a href="editar_produto_gestor.php?id_produto='.$produto->id_produto.'">
                                <svg width="24" height="24" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9666 1.20887C16.5785 -0.402949 19.1916 -0.402963 20.8035 1.20887L23.7911 4.19646C25.403 5.80829 25.403 8.42156 23.7911 10.0334L9.22746 24.597C8.96945 24.855 8.61952 25 8.25464 25H1.37577C0.615961 25 0 24.3841 0 23.6242V16.7453C0 16.3805 0.144952 16.0305 0.40295 15.7725L14.9666 1.20887ZM18.8579 3.1545C18.3206 2.61724 17.4495 2.61724 16.9122 3.1545L15.7034 4.36337L20.6366 9.29661L21.8455 8.08775C22.3827 7.55046 22.3827 6.67938 21.8455 6.14211L18.8579 3.1545ZM18.691 11.2422L13.7577 6.309L2.75155 17.3152V22.2484H7.68478L18.691 11.2422Z" fill="black"/>
                                </svg>
                            </a>
                        </td>
                        <td data-lable="Inativar: ">
                            <a href="atualizar_status_prod.php?id='.$produto->id_produto.'">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 26 26" style="fill:#1A1A1A;">
                                    <path d="M 11.5 -0.03125 C 9.542969 -0.03125 7.96875 1.59375 7.96875 3.5625 L 7.96875 4 L 4 4 C 3.449219 4 3 4.449219 3 5 L 3 6 L 2 6 L 2 8 L 4 8 L 4 23 C 4 24.644531 5.355469 26 7 26 L 19 26 C 20.644531 26 22 24.644531 22 23 L 22 8 L 24 8 L 24 6 L 23 6 L 23 5 C 23 4.449219 22.550781 4 22 4 L 18.03125 4 L 18.03125 3.5625 C 18.03125 1.59375 16.457031 -0.03125 14.5 -0.03125 Z M 11.5 2.03125 L 14.5 2.03125 C 15.304688 2.03125 15.96875 2.6875 15.96875 3.5625 L 15.96875 4 L 10.03125 4 L 10.03125 3.5625 C 10.03125 2.6875 10.695313 2.03125 11.5 2.03125 Z M 6 8 L 11.125 8 C 11.25 8.011719 11.371094 8.03125 11.5 8.03125 L 14.5 8.03125 C 14.628906 8.03125 14.75 8.011719 14.875 8 L 20 8 L 20 23 C 20 23.5625 19.5625 24 19 24 L 7 24 C 6.4375 24 6 23.5625 6 23 Z M 8 10 L 8 22 L 10 22 L 10 10 Z M 12 10 L 12 22 L 14 22 L 14 10 Z M 16 10 L 16 22 L 18 22 L 18 10 Z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>';
}

//CASO NÃO ENCONTRAR NENHUM RESULTADO
$resultados = !empty($resultados) ? $resultados :   '<div class = "div-tabela">
                                                        <span style="text-align:center;">Nenhum Produto Encontrado</span>
                                                    </div>';

//GETS
unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÃO
$paginacao  = '';
$paginas    = $obPagination->getPages();
foreach($paginas as $key=>$pagina){
    $cordefundo = $pagina['atual'] ? 'rgb(215, 91, 54)' : 'rgb(23,61,87)';
    
    $paginacao .=   '<a style="background-color:'.$cordefundo.';" class="botao_pagina" href="?pagina='.$pagina['pagina'].'&'.$gets.'">'
                        .$pagina['pagina'].
                    '</a>';
}

//INCLUI O MENU GESTOR
$tituloPagina = 'LISTA DE PRODUTOS';
require './../includes/menu_gestor.php';
?>
<!--PÁGINA PRINCIPAL-->
<main class="main_listar">
    <form method="get" class="formulario_listar">
        <div>
            <label>Nome:</label>
            <input type="text" name="busca" value="<?=$busca?>">
        </div>

        <div>
            <label>Status:</label>
            <select name="filtroStatus">
                <option value="">Todos</option>
                <option value="1" <?=$Status == '1' ? 'selected' : ''?>>EM ESTOQUE</option>
                <option value="2" <?=$Status == '2' ? 'selected' : ''?>>EM FALTA</option>
            </select>
        </div>

        <div>
            <button class="botao_filtrar" type="submit">FILTRAR</button>
        </div>
    </form>

    <div class="div_tabela">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Quantidade</th>
                    <th>Valor AZCoin</th>
                    <th colspan="2">Editar/Excluir</th>
                </tr>
            </thead>
            <tbody class="tabela">
                <?=$resultados?>
            </tbody>
        </table>
    </div>

    <div class="listar_paginacao">
        <?=$paginacao?>
    </div>

</main>
<script>
    const list_gest_botao=document.getElementById("open-modal");
    list_gest_botao.addEventListener('click', function(excluirprod){
        // console.log('oi');
        window.location.href = "./listar_produto_gestor.php";
    })
</script>

<?php require './../includes/footer.php'; ?>