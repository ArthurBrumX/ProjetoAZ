<?php

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Usuario;
use \App\Session\Modal;


//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

$modalR = Modal::showModalDirec(null,'EDITADO COM SUCESSO','./listar_user_gestor.php',"Pressione Continuar para acessar a lista de Usuarios.");
$modalI = Modal::showModalInfor(null,'ERRO AO EDITAR','FECHAR',"Ocorreu um erro ao salvar as alterações. Tente Novamente mais tarde");
echo $modalI;
echo $modalR;

//CONSULTA O USUÁRIO
$obUser = new Usuario;
$obUser = $obUser::getUsuario($usuarioLogado['id_usuario']);

//INCLUI O MENU GESTOR
$tituloPagina = 'Editar Usuário';
require './../includes/menu_gestor.php';
?>

<div class="home">
    <!--TELA DE CADASTROS-->
    <form method="POST" id="form" enctype="multipart/form-data">
        <div class="caduser">
        
            <div class="caixa-input">
                <input type="text" class="input" id="nome" name="nome" value="<?=$obUser->nome?>" required>
                <span class="barra"></span>
                <label class="label">
                    <span class="label-letra" style="--index: 0">N</span>
                    <span class="label-letra" style="--index: 1">O</span>
                    <span class="label-letra" style="--index: 2">M</span>
                    <span class="label-letra" style="--index: 3">E</span>
                </label>
            </div>

            <div class="caixa-input">
                <input required="" type="text" class="input" name="apelido" value="<?=$obUser->apelido?>">
                <span class="barra"></span>
                <label class="label">
                    <span class="label-letra" style="--index: 0">A</span>
                    <span class="label-letra" style="--index: 1">P</span>
                    <span class="label-letra" style="--index: 2">E</span>
                    <span class="label-letra" style="--index: 3">L</span>
                    <span class="label-letra" style="--index: 3">I</span>
                    <span class="label-letra" style="--index: 3">D</span>
                    <span class="label-letra" style="--index: 3">O</span>
                </label>
            </div>

            <div class="caixa-input">
                <input type="email" class="input" name="email" value="<?=$obUser->email?>" required>
                <span class="barra"></span>
                <label class="label">
                    <span class="label-letra" style="--index: 0">E</span>
                    <span class="label-letra" style="--index: 1">-</span>
                    <span class="label-letra" style="--index: 2">M</span>
                    <span class="label-letra" style="--index: 3">A</span>
                    <span class="label-letra" style="--index: 4">I</span>
                    <span class="label-letra" style="--index: 5">L</span>
                </label>
            </div>

            <div class="caixa-input">
                <input type="password" class="input" name="senha" value="<?=$obUser->senha?>" required>
                <span class="barra"></span>
                <label class="label">
                    <span class="label-letra" style="--index: 0">S</span>
                    <span class="label-letra" style="--index: 1">E</span>
                    <span class="label-letra" style="--index: 2">N</span>
                    <span class="label-letra" style="--index: 3">H</span>
                    <span class="label-letra" style="--index: 4">A</span>
                </label>
            </div>

            <div class="foto">
                <span class="sfoto">Inserir imagem</span>
                <div class="pre-view">
                    <input type="hidden" id="foto_db" value="<?=$obUser->imagem;?>">
                    <input type='file' accept='image/*' onchange='openFile(event)' id="fotoUser" name="fotoUsuario"> <br>
                    <img id='output' src="<?=$obUser->imagem?>">
                </div>
            </div>


            <div class="botaop">
                <input class="btncads" type="submit" value="salvar" id="cadastrar" name="Btn_CadasUsuario">
                <input class="btncads" type="reset" id="cancelar" value="Cancelar">
            </div>
            

        </div>

    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>

//Elementos html do modal Direcionado
const fecharModalDirec = document.getElementById('fechar-modal-direc');
const modalD = document.getElementById('modal-padrao-direc');
var msD = document.getElementById('descri-modal-direc');
const tituloRedic = document.getElementById('titulo-redic');

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

    const form = document.getElementById("form")
    const botcancelar = document.getElementById("cancelar");
    botcancelar.addEventListener('click', function(){
        // console.log('oi');
        window.location.href = "./home_user.php";
    })

    form.addEventListener('submit',function(event){
        event.preventDefault();

            const nome = document.getElementById("nome");
            console.log(nome.value)

            if (nome.value == ""){
                alert ("Favor digite o nome");
                nome.focus()
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
if(isset($_POST['nome']) && isset($_POST['apelido']) && isset($_POST['email'])){
    $senha = $_POST['senha'];
    $arquivo = $_FILES['fotoUsuario'];
    if($arquivo['name'] == ""){

        $obUser->nome = $_POST['nome'];
        $obUser->email = $_POST['email'];
        $senha_tratada =  strlen($senha)> 40 ? $_POST['senha'] : password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $obUser->senha = $senha_tratada;
        $obUser->apelido = $_POST['apelido'];
        $obUser->atualizar();
    
        header('location: home_user.php?status=success');
    }
    else{
        
        if($arquivo['error']) die('Falha ao enviar o arquivo');
        //definindo o caminho que a foto será salva
        $pasta = '../img/usuarios/';
        //recebendo o nome do arquivo
        $nome_arquivo = $arquivo['name'];
        //gera um novo nome para a foto
        $new_name = uniqid();
        //extrai a extensao do arquivo
        $extensao = strtolower(pathinfo($nome_arquivo,PATHINFO_EXTENSION));
        if($extensao != 'png' && $extensao != 'jpeg' && $extensao != 'jpg' && $extensao !='jfif'  ) die("Falha ao enviar o arquivo!");
        //concatena o caminho da pasta mais o novo nome e a extensao
        $caminho = $pasta . $new_name . "." . $extensao;
        $foto = move_uploaded_file($arquivo['tmp_name'],$caminho);   

        $obUser->nome = $_POST['nome'];
        $obUser->email = $_POST['email'];
        $senha_tratada =  strlen($senha)> 40 ? $_POST['senha'] : password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $obUser->senha = $senha_tratada;
        $obUser->apelido = $_POST['apelido'];
        $obUser->imagem = $caminho;
        $obUser->atualizar();
    
        header('location: home_user.php?status=success');
    }
}


require '../includes/footer.php' ?>