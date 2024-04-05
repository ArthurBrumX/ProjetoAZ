//elementos html do formulário principal
const botaoSubmit = document.getElementById('botao-submit'); 
const formulario = document.getElementById('form-feed');

// Elementos html do modal com formulário
const modalF = document.getElementById('modal-padrao-form');
const formModal = document.getElementById('formulario');
const fecharModalForm = document.getElementById('fechar-modal-form');
const cancelaBotao = document.getElementById('botao_cancela_form');

//Elementos html do modal informativo
const fecharModalInfor = document.getElementById('fechar-modal-infor');
const modalI = document.getElementById('modal-padrao-infor');
var msI = document.getElementById('descri-modal-infor');


//Elementos html do modal de redirecionamento
const modalD = document.getElementById("modal-padrao-direc");
const fecharModalDirec = document.getElementById("fechar-modal-direc");
var msR = document.getElementById('descri-modal-redic');


////////////////////////////////////////////////////////////////////////////

//funcão responsavel por abrir o modal com formulário
function abreModalForm() {
    modalF.classList.remove("escondido");
    modalF.classList.add("amostra");
}

//função responsável por fechar o modal com formulário
function saiModalForm() {
    modalF.classList.remove("amostra");
    modalF.classList.add("escondido");
}

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


//funcão responsavel por abrir o modal Redirecionar
function abreModalRedic() {
    modalD.classList.remove("escondido");
    modalD.classList.add("amostra");
}

//função responsável por fechar o redirecionador
function saiModalDirec() {
    modalD.classList.remove("amostra");
    modalD.classList.add("escondido");
}
//////////////////////////////////////////////////////////////////////////////


// ABRE OS MODAIS CHAMADOS

botaoSubmit.addEventListener("click", function(event) {
    event.preventDefault();
    abreModalForm();
});
// FIM DO ABRE OS MODAIS CHAMADOS

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
//FECHA OS MODAIS CHAMADOS

//Faz o fade fechar o modal com formulario
modalF.addEventListener("click", function(event) {
    if (event.target === modalF) {
        saiModalForm();
    }
});



//faz o botão cancelar fechar o modal com formulario
cancelaBotao.addEventListener("click", function(event) {
    event.preventDefault();
    saiModalForm();
});

//faz o botão X fechar o modal com formulario
fecharModalForm.addEventListener("click", function(event) {
    event.preventDefault();
    saiModalForm();
});

//faz o botão X fechar o modal informativo
fecharModalInfor.addEventListener("click", function(event) {
    event.preventDefault();
    saiModalInfor();
});

fecharModalDirec.addEventListener("click",function(event){
    event.preventDefault();
    saiModalDirec();
})

modalD.addEventListener("click",function(event){
    if (event.target === modalD) {
    saiModalDirec();
}})




// FIM DO FECHA OS MODAIS CHAMADOS

formModal.addEventListener("submit", async function(event) {
    event.preventDefault();

    const formNovo = new FormData(formulario);

    let dados_php = await fetch('../actions/verificaFeedEdit.php',{
        method:'POST',
        body: formNovo
    });

    let resposta = await dados_php.json();
    saiModalForm();

    if (resposta.status == 'sucesso'){
        msR.innerHTML = resposta.mensagem;
        msR.style.color = "green";
        msR.style.fontWeight="bold" 
        saiModalForm();
        abreModalRedic();
    } else {
        saiModalForm();
        abreModalInfor();
        msI.innerHTML = resposta.mensagem;
        msI.style.color = "red";
        msI.style.fontWeight="bold" 

    }
});
