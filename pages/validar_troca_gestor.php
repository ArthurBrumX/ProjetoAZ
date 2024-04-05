<?php
require __DIR__.'/../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\ControleEnvio;
use \App\Session\Modal;

// Este arquivo(validar_troca_gestor.php) gera a tela de produtos trocados(na loja) para serem enviados.
// Esta tela MOSTRARÁ apenas os PRODUTOS PENDENTES.

$objControleEnvio = new ControleEnvio();
$controle = $objControleEnvio::ListarProdutosParaEnvio();

// echo "<pre>"; print_r($controle); echo "</pre>"; 
// die;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

$res_control = '';
foreach($controle as $control){
        $res_control .='<tr>
                            <td data-lable="Nome: ">'.$control['colaborador'].'</td>
                            <td data-lable="Descrição: ">'.$control['produto'].'</td>
                            <td data-lable="Quantidade: ">'.$control['quantidade'].'</td>
                            <td data-lable="Data da Troca: ">'.date("d/m/Y",strtotime($control['data_troca_prod'])).'</td>
                            <td data-lable="Status: ">PENDENTE</td>
                            <td>
                                <button class="btn_pendente" type="submit" idTrocaProd="'.$control['id_troca_produto'].'"  id="checkout">Enviar</button>
                            </td>  
                        </tr>';
}
$ModalC=Modal::showModalConf('..\assets\Boneco Pensando.png','Deseja enviar o(s) produto(s) deste pedido ?','CONFIRMAR',null);
$ModalI=Modal::showModalInfor(null,'Erro ao Enviar Pedido','CONTINUAR','Ocorreu um erro Inesperado, Tente novamente.');
echo $ModalC;
echo $ModalI;
//INCLUI O MENU GESTOR
$tituloPagina = 'Envio de produtos';
require './../includes/menu_gestor.php';
?>
<main class="main_listar">

    <button id="btn_link"><a class="direcionador-enviados" href="validar_troca_gestor_enviar.php">PRODUTOS ENVIADOS</a></button>

    <div class="div_tabela">
        <table>
            <thead>
                <tr>
                    <th>Nome do colaborador</th>
                    <th>Descrição do Produto</th>
                    <th>Quantidade</th>
                    <th>Data da troca</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?= $res_control == "" ? "<td colspan=7><h1 id='ternario'>End Of File!</h1></td>" : $res_control; ?>
            </tbody>
        </table>
    </div>

</main>

<script>
    const btn_pendente_js = document.querySelectorAll("#checkout")

    // Elementos html do modal confirmar
    const modalC = document.getElementById('modal-padrao-conf');
    const confModal = document.getElementById('form-confirma');
    const fecharModalconf = document.getElementById('fechar-modal-conf');
    const cancelaBotao = document.getElementById('botao_cancela_conf');
    var salvaId = document.getElementById('conf-hidden');

    //Elementos html do modal informativo
    const fecharModalInfor = document.getElementById('fechar-modal-infor');
    const modalI = document.getElementById('modal-padrao-infor');
    var msI = document.getElementById('descri-modal-infor');

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
    })

    //Faz o fade fechar o modal informativo de erro
    modalI.addEventListener("click", function(event) {
        if (event.target === modalI) {
            saiModalInfor();
        }
    });

    //faz o botão X fechar o modal informativo
    fecharModalInfor.addEventListener("click", function(event) {
        event.preventDefault();
        saiModalInfor();
    });


    //funcão responsavel por abrir o modal com formulário
    function abreModalConf(id) {
        modalC.classList.remove("escondido");
        modalC.classList.add("amostra");
        salvaIda.value=id;
    }

    //função responsável por fechar o modal com formulário
    function saiModalConf() {
        modalC.classList.remove("amostra");
        modalC.classList.add("escondido");
    }

    //Faz o fade fechar o modal com formulario
    modalC.addEventListener("click", function(event) {
        if (event.target === modalC) {
            saiModalConf();
        }
    });

    //faz o botão cancelar fechar o modal com formulario
    cancelaBotao.addEventListener("click", function(event) {
        event.preventDefault();
        saiModalConf();
    });

    //faz o botão X fechar o modal com formulario
    fecharModalconf.addEventListener("click", function(event) {
        event.preventDefault();
        saiModalConf();
    });

    btn_pendente_js.forEach((element) => {
        element.addEventListener('click',function(event){
            event.preventDefault()
                
            id = element.getAttribute("idTrocaProd")
            salvaId.value=id;

            modalC.classList.remove("escondido");
            modalC.classList.add("amostra");

            confModal.addEventListener('submit', async function(event){ //async
                event.preventDefault();
                console.log(salvaId.value);

                let data_php = await fetch('./action_valida_troca_gestor.php', {
                method: 'POST',
                body: JSON.stringify(salvaId.value)
                });

                let response = await data_php.json()
                saiModalConf();

                // console.log(response)

                if(response.status == "OK"){
                    location.href = "./validar_troca_gestor.php";
                }else{
                    msI.innerHTML = resposta.mensagem;
                    msI.style.color = "red";
                    msI.style.fontWeight="bold";
                    abreModalInfo()
                }
            })
        })
    })
</script>
<?php require '../includes/footer.php' ?>