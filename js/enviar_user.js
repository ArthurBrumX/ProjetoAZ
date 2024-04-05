const openModalBtn = document.getElementById('btn_feed');
const closeModalBtn = document.getElementById('btn_cancelar');
const modalConfir = document.getElementById('dialog_confirmar');
const quantiaSpan = document.getElementById('quantiaModal');
const destinatarioSpan = document.getElementById('destinatario');
const msgFeedback = document.getElementById('msgFeedback');
const botaoX = document.getElementById('fechar-modal-infor');

const spans = document.querySelectorAll('.span-require');


var quantiaInput = document.getElementById('quantia');
var saldoParaDoarInput = document.getElementById('saldoParaDoar');


function setError(index){
    spans[index].style.display = 'block';
}

function cleanError(index){
    spans[index].style.display = 'none'
}

openModalBtn.addEventListener('click', function (event) {
    event.preventDefault();

    var quantiaValue = parseFloat(quantiaInput.value);
    var saldoParaDoarValue = parseFloat(saldoParaDoarInput.value);

    if($('.btn-enviar-para').val() == 1){
        setError(0);
    }else{
        cleanError(0);
        if( quantiaValue > saldoParaDoarValue){
            cleanError(2);
            setError(1);
        }else{
            cleanError(1);
            if(isNaN(quantiaValue) || quantiaValue == 0){
                setError(2);      
            }else{
                cleanError(2);
                if(msgFeedback.value.length < 50){
                    setError(3);      
                }else{
                    cleanError(3);
                    quantiaSpan.textContent = document.querySelector('.input-form-qtd').value;
                    destinatarioSpan.textContent = document.querySelector('#Colaborador option:checked').text;

                    // Abrir o modal
                    modalConfir.showModal();
                }
            }
    }
}
});

modalConfir.addEventListener("click", function(event){
    if (event.target === modalConfir) {
        modalConfir.close();
    }
})

botaoX.addEventListener("click", function(event){
    event.preventDefault();
    modalConfir.close();
})

//função de fechar o modal
closeModalBtn.addEventListener('click', function (event) {
    event.preventDefault();
    modalConfir.close();
});

function desabilitaBotao(){
    document.getElementById("btn_confirmar").disabled = true;
}



const modal = document.getElementById("dialog");
const redirecionarConcluido = document.getElementById("redirecionarConcluido");
const formulario = document.getElementById("form_enviar_Feedback");

formulario.addEventListener("submit", async function(event){
    desabilitaBotao();
    event.preventDefault();
    const formData = new FormData(formulario);

    let dados_php = await fetch('../pages/enviar_userJson.php', {
        method: 'POST',
        body: formData
    });

    let resposta = await dados_php.json()

    if (resposta.status == 'OK'){
        modalConfir.close()
        modal.show()

        redirecionarConcluido.addEventListener('click',function(){
            window.location.href = window.location.href;
        })
    }
   
})



