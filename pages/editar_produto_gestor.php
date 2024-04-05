<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Produto;
use \App\Session\Modal;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//VALIDAÇÃO DO ID
if(!isset($_GET['id_produto']) or !is_numeric($_GET['id_produto'])){
    header('location: listar_produto_gestor.php?status=error');
    exit;
}

//CONSULTA O USUÁRIO
$obProduto = new Produto;
$obProduto = $obProduto::getProduto($_GET['id_produto']);


//VALIDAÇÃO DO PRODUTO
if(!$obProduto instanceof Produto){
    header('location: listar_produto_gestor.php?status=error');
    exit;
}

$modalR = Modal::showModalDirec(null,'CADASTRADO COM SUCESSO','./listar_produto_gestor.php',"Pressione Continuar para acessar a lista de Produtos.");
$modalI = Modal::showModalInfor(null,'ERRO AO CADASTRAR','FECHAR',"Ocorreu um erro ao cadastrar o produto. Tente Novamente");
echo $modalI;
echo $modalR;

//INCLUI O MENU GESTOR
$tituloPagina = 'Editar Produto';
require './../includes/menu_gestor.php';
?>

<div class="div-form-editar-produto">
    <!--TELA CADASTRO PRODUTO-->
    <form method="POST" id="form" enctype="multipart/form-data" class="form-editar-produto">
        <div class="editProd">
            <div class="textos">
       
                <div class="caixa-input">
                    <input type="text" class="input" name="nome" value="<?=$obProduto->nome?>" required>
                    <span class="barra"></span>
                    <label class="label">
                        <span class="label-letra" style="--index: 0">N</span>
                        <span class="label-letra" style="--index: 1">O</span>
                        <span class="label-letra" style="--index: 2">M</span>
                        <span class="label-letra" style="--index: 3">E</span>
                    </label>
                </div>

                <div class="caixa-input">
                    <input type="text" class="input" name="descricao" value="<?=$obProduto->descricao?>" required>
                    <span class="barra"></span>
                    <label class="label">
                        <span class="label-letra" style="--index: 0">D</span>
                        <span class="label-letra" style="--index: 1">E</span>
                        <span class="label-letra" style="--index: 2">S</span>
                        <span class="label-letra" style="--index: 3">C</span>
                        <span class="label-letra" style="--index: 4">R</span>
                        <span class="label-letra" style="--index: 5">I</span>
                        <span class="label-letra" style="--index: 6">Ç</span>
                        <span class="label-letra" style="--index: 7">Ã</span>
                        <span class="label-letra" style="--index: 8">O</span>
                    </label>
                </div>

                <div class="caixa-input">
                    <input type="text" class="input" name="quantidade" value="<?=$obProduto->qde_produto?>" required>
                    <span class="barra"></span>
                    <label class="label">
                        <span class="label-letra" style="--index: 0">Q</span>
                        <span class="label-letra" style="--index: 1">U</span>
                        <span class="label-letra" style="--index: 2">A</span>
                        <span class="label-letra" style="--index: 3">N</span>
                        <span class="label-letra" style="--index: 4">T</span>
                        <span class="label-letra" style="--index: 5">I</span>
                        <span class="label-letra" style="--index: 6">D</span>
                        <span class="label-letra" style="--index: 7">A</span>
                        <span class="label-letra" style="--index: 8">D</span>
                        <span class="label-letra" style="--index: 9">E</span>
                    </label>
                </div>

                <div class="caixa-input">
                    <input type="text" class="input" name="valor" value="<?=$obProduto->valor_produto?>" required>
                    <span class="barra"></span>
                    <label class="label">
                        <span class="label-letra" style="--index: 0">V</span>
                        <span class="label-letra" style="--index: 1">A</span>
                        <span class="label-letra" style="--index: 2">L</span>
                        <span class="label-letra" style="--index: 3">O</span>
                        <span class="label-letra" style="--index: 4">R</span>
                    </label>
                </div>

                <div class="foto">
                    <span class="sfoto">Inserir imagem</span>
                    <div class="pre-view">
                        <input type="file" accept='image/*' onchange='openFile(event)' id="fotoProd" name="foto"><br>
                        <img src="<?=$obProduto->imagem?>" id="output">
                    </div>
                </div>

                <div class="botaop">
                    <a id="cancelar" href="listar_produto_gestor.php" class="btncancelar">Cancelar</a>
                    <input class="btncads" id="botao_submit" type= "submit" value="Salvar" name="Btn_CadasProduto">
                </div>

            </div>
        </div>
    </form>
    
</div>
<script>

    //Elementos html do modal Direcionado
const fecharModalDirec = document.getElementById('fechar-modal-direc');
const modalD = document.getElementById('modal-padrao-direc');
var msD = document.getElementById('descri-modal-direc');
const tituloRedic = document.getElementById('titulo-redic');
const botaoEditavelDirec =document.getElementById('botao_editavel-direc');

//Elementos html do modal informativo
const fecharModalInfor = document.getElementById('fechar-modal-infor');
const modalI = document.getElementById('modal-padrao-infor');
var msI = document.getElementById('descri-modal-infor');
const tituloInfor =document.getElementById('texto-modal-infor');

tituloRedic.style.color ='green';
tituloInfor.style.color = 'red';

//////////////////////////MODAL INFORMATIVO/////////////////////////
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

document.getElementById('botao_editavel_infor').addEventListener("click",function(event){
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

////////////////////////////MODAL INFORMATIVO//////////////////////
//funcão responsavel por abrir o modal Direcionado
function abreModalDirec() {
    modalD.classList.remove("escondido");
    modalD.classList.add("amostra");
}

//função responsável por fechar o modal Direcionado
function saiModalDirec() {
    modalD.classList.remove("amostra");
    modalD.classList.add("escondido");
}

fecharModalDirec.addEventListener("click",function(event){
    event.preventDefault();
    saiModalDirec();
})

modalD.addEventListener("click", function(event) {
    if (event.target === modalD) {
        saiModalDirec();
    }
});


    const form =document.getElementById("form")
    const botcancelar=document.getElementById("cancelar");
    const botaoSubmit =document.getElementById('botao_submit');
    botcancelar.addEventListener('click', function(){
        // console.log('oi');
        window.location.href = "./listar_produto_gestor.php";
    })

    botaoSubmit.addEventListener("click", function(event){
        event.preventDefault();
        abreModalDirec();
    })

botaoEditavelDirec.addEventListener('click',function(event){
    form.submit();
    fecharModalDirec();
    
})

    form.addEventListener('submit',function(event){
        event.preventDefault();

            const foto = document.getElementById("fotoProd");
            const nome = document.getElementById("nome");

            if (foto.value.length == 0){
                modalI.innerHTML="Selecione uma Foto";
                abreModalInfor();
            }else {
                event.target.submit();

            }
    })
    
    var openFile = function(event) {
        var input = event.target;

        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var output = document.getElementById('output');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    };
</script>
<?php

//VERIFICA SE OS DADOS ESTÃO PREENCHIDOS NO POST
if(isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['quantidade']) && isset($_POST['valor'])){

    $arquivo = $_FILES['foto'];

    if($arquivo['error']) die('Falha ao enviar o arquivo');

    //definindo o caminho que a foto será salva
    $pasta = '../img/produtos/';//mudar o caminho
    //recebendo o nome do arquivo
    $nome_arquivo = $arquivo['name'];
    //gera um novo nome para a foto
    $new_name = uniqid();
    //extrai a extensao do arquivo
    $extensao = strtolower(pathinfo($nome_arquivo,PATHINFO_EXTENSION));

    if($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg'&& $extensao !='jfif' ) die("Falha ao enviar o arquivo!");
    //concatena o caminho da pasta mais o novo nome e a extensao
    $caminho = $pasta . $new_name . "." . $extensao;
    $foto = move_uploaded_file($arquivo['tmp_name'],$caminho);
    $obProduto->nome = $_POST['nome'];
    $obProduto->descricao = $_POST[ 'descricao'];
    $obProduto->qde_produto = $_POST ['quantidade'];
    $obProduto->valor_produto = $_POST[ 'valor'];
    $obProduto->imagem = $caminho;
    $obProduto->atualizar();

}

require '../includes/footer.php' ?>