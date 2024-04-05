<?php
require __DIR__.'/../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\ControleEnvio;

// Este arquivo(validar_troca_gestor_enviar.php) gera a tela de produtos marcados(checked) como enviados.
// Esta tela MOSTRARÁ apenas os PRODUTOS ENVIADOS.

$objControleEnvio = new ControleEnvio();
$controle = $objControleEnvio::ListarProdutosParaEnvio();

// echo "<pre>"; print_r($controle); echo "</pre>"; echo "<br>";
// die;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

$res_control = '';
$t = $s = 0;
foreach($controle as $control){
    $t++;
    if($control['status'] == "enviado"){
        $s++;
        $res_control .='
                        <tr>
                            <td class="cellCenter">'.$s.'</td>
                            <td>'.$control['colaborador'].'</td>
                            <td>'.$control['produto'].'</td>
                            <td>'.$control['quantidade'].'</td>
                            <td>'.date("d/m/Y",strtotime($control['data_troca_prod'])).'</td>
                            <td>
                                <div class="listaAgrupada">
                                    <div class="listaEnviadoProd">
                                        <div id="div_status">
                                            <h3>ENVIADO</h3>
                                        </div>
                                    </div>
                            </td>
                            <td>'.$control['data_envio'].'</td>
                                </div>
                        </tr>
                    ';
    }
}

//INCLUI O MENU GESTOR
$tituloPagina = 'Produtos enviados';
require './../includes/menu_gestor.php';
?>
<main class="main_listar">
    <button id="btn_link"><a href="validar_troca_gestor.php">VOLTAR PARA PENDENTES</a></button>

    <div class="div_tabela">
        <table>
            <thead>
                <tr>
                    <th>Seq</th>
                    <th>Nome do colaborador</th>
                    <th>Descrição do Produto</th>
                    <th>Quantidade</th>
                    <th>Data da troca (na loja)</th>
                    <th>Status</th>
                    <th>Data do Envio</th>
                </tr>
            </thead>
            <tbody>
                <?= $res_control == "" ? "<td colspan=7><h1 id='ternario'>End Of File!</h1></td>" : $res_control; ?>
            </tbody>
        </table>
    </div>

</main>

<?php require '../includes/footer.php' ?>