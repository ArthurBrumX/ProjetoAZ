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



//var dump -> função para printar o que vem no POST????
// POST é um array contendo os inputs
// var_dump($_POST);
 
$modalR = Modal::showModalDirec(null,'CADASTRADO COM SUCESSO','./listar_user_gestor.php',"Pressione Continuar para acessar a lista de Usuarios.");
$modalI = Modal::showModalInfor(null,'ERRO AO CADASTRAR','FECHAR',"Ocorreu um erro ao cadastrar o Usuario. Tente Novamente");
echo $modalI;
echo $modalR;

//INCLUI O MENU GESTOR
$tituloPagina = 'CADASTRAR USUARIO';
require './../includes/menu_gestor.php';


?>
<!--TELA DE CADASTROS-->
<div class="div-form-cadastrar">
    <form method="POST" id="form" enctype="multipart/form-data" class="form-cad-user">  
        <div class="editUser">
            <div class="textos">            
                <div class="caixa-input">
                <input type="text" class="input" id="nomeUsuario" name="nomeUsuario" required>
                <span class="barra"></span>
                <label class="label">
                    <span class="label-letra" style="--index: 0">N</span>
                    <span class="label-letra" style="--index: 1">O</span>
                    <span class="label-letra" style="--index: 2">M</span>
                    <span class="label-letra" style="--index: 3">E</span>
                </label>
            </div>

            <div class="caixa-input">
                <input required="" type="text" class="input" name="apeUsuario">
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
                <input required="" type="email" class="input" name="emailUsuario">
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
                <input required="" type="password" class="input" name="senha">
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
                    <input type='file' accept='image/*' onchange='openFile(event)' id="fotoUsuario" name="fotoUsuario"><br>
                    <img id='output'>

                </div>
                <span class="span-require">SELECIONE UMA FOTO</span>

            </div>
            <div class="div-radio-cadastro-usuario">
                <div class="radio-button">
                    <input class="option" type="radio" name="radioUsuario" value="administrador" id="radioAdm">
                    <span class="radio"></span>
                    <span class="textoradio">Administrador</span>
                </div>

                <div class="radio-button">
                    <input class="option" type="radio" name="radioUsuario" value="colaborador" id="radioColaborador">
                    <span class="radio"></span>
                    <span class="textoradio">Colaborador</span>
                </div>

                <div class="radio-button">
                    <input class="option" type="radio" name="radioUsuario" value="gestor" id="radioGestor">
                    <span class="radio"></span>
                    <span class="textoradio">Gestor</span>
                </div>
                <span class="span-require">SELECIONE SELECIONE UM CARGO</span>
            </div>

            <div class="botaop">
                <input class="btncads" type="reset" value="Cancelar" id='cadas-usua-cancela'>
                <input class="btncads" type="submit" value="Cadastrar" id="cadastrar" name="Btn_CadasUsuario">
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

//Elementos html do modal informativo
const fecharModalInfor = document.getElementById('fechar-modal-infor');
const modalI = document.getElementById('modal-padrao-infor');
var msI = document.getElementById('descri-modal-infor');
const tituloInfor =document.getElementById('texto-modal-infor');


//const erro
const form = document.getElementById("form");
const cancelar = document.getElementById('cadas-usua-cancela')
const spans = document.querySelectorAll('.span-require');

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


function setError(index){
    spans[index].style.display = 'block';
}
function cleanError(index){
    spans[index].style.display = 'none'
}

form.addEventListener('submit',function(event){
    event.preventDefault();

        const foto = document.getElementById("fotoUsuario");
        const nome = document.getElementById("nomeUsuario");

        if (foto.value.length == 0){
            setError(0);
            
            nome.focus()
        }else {
            if((document.getElementById("radioAdm").checked) || (document.getElementById("radioColaborador").checked) || 
            (document.getElementById("radioGestor").checked)){
                event.target.submit();
            }else{
                cleanError(0);
                setError(1);
            }
        }
        
})

cancelar.addEventListener('click',function(){
    cleanError(1);
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
</body>

<?php

if(isset($_POST['nomeUsuario']) && isset($_POST['emailUsuario'])){

    $arquivo = $_FILES['fotoUsuario'];

    if($arquivo['error']) die('Falha ao enviar o arquivo1');

    //definindo o caminho que a foto será salva
    $pasta = '../img/usuarios/'; //mudar o caminho
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
    $nome = $_POST['nomeUsuario'];
    $email = $_POST['emailUsuario'];
    $apelido =$_POST['apeUsuario'];
    $senha = $_POST['senha'];
    
    if(isset($_POST['radioUsuario'])){
        $perfil = $_POST['radioUsuario'];
        if($perfil == 'administrador'){
            $perfil = 1;
        }elseif($perfil == 'gestor'){
            $perfil = 2;
        }
        if($perfil == 'colaborador'){
            $perfil = 3;
        }
    }

    $objUsuario = new Usuario();
    $objUsuario->nome = $nome;
    $objUsuario->email = $email;
    $objUsuario->senha = password_hash($senha, PASSWORD_DEFAULT);
    $objUsuario->apelido = $apelido;
    $objUsuario->imagem= $caminho;
    $objUsuario->id_perfil_usuario = $perfil;
    $objUsuario->id_status_user=1;

    $result = $objUsuario->cadastrar();

    if($result){
        
        ?><script>
            abreModalDirec();
            
        </script><?php

    }else{
        ?><script>
            abreModalInfor();
        </script><?php
    }
}    

require '../includes/footer.php' ?>
