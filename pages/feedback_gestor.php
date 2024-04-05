<?php
require __DIR__.'/../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Feedback;
use \App\Session\Modal;

$new_obj = new Feedback();
$cards = $new_obj->listar_cards();

// echo "<pre>"; print_r($cards); echo "</pre>";
//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

$results = '';
$blank_screen = '';
$blank_screen .='
    <div class="telavazia">
        <span class="textotelavazia">Está vazio por aqui...</span>
        <img class="giftelavazia" src="..\assets\telavazia.gif" alt="">
    </div>
';



foreach($cards as $card){
    $results .= '
                <div id="newcard" class="container-card-1">
                    <div class="card-1">
                        <div id="front" class="card-frente-1">
                            <!-- <h1>Cartao</h1> -->
                            
                            <div class="card-frente-conteudo-1">
                                <div class="card-frente-cabecalho">
                                    <img src="./../assets/Icone-Recebido (1).svg" alt="icone moeda" class="icone-azcoin-adicionada-1" id="moeda">
                                    <h2 class="valor">'.$card['doacao'].'</h2>
                                </div>
                            </div>
                            <img id="img_avatar" src="'.$card['img_remetente'].'" alt="IMAGEM">
                        </div>

                        <div id="back" class="card-tras-1">
                            <!-- <h1 id="id_feed_card">'.$card['id_feedback'].'</h1> -->
                                <div class="img_rem_dest">
                                    <img src="'.$card['img_remetente'].'" alt="IMAGEM_remetente" id="img_card_verso">
                                    
                                    <!-- Bloco da animacao das setas no verso do card -->
                                        <div class="seta-1" id="arrowAnim-1">
                                            <div class="arrowSliding-1">
                                                <div class="arrow-1"></div>
                                            </div>
                                                <div class="arrowSliding-1 delay1-1">
                                                    <div class="arrow-1"></div>
                                                </div>
                                                <div class="arrowSliding-1 delay2-1">
                                                    <div class="arrow-1"></div>
                                                </div>
                                                <div class="arrowSliding-1 delay3-1">
                                                    <div class="arrow-1"></div>
                                                </div>
                                        </div>

                                    <img src="'.$card['img_destinatario'].'" alt="IMAGEM_destinatario" id="img_card_verso">
                                </div>
                                <div class="de_para">
                                    <p class="nome-card-remet-gestor">'.$card['remetente'].'</p>
                                    <p class="nome-card-dest-gestor">'.$card['destinatario'].'</p>
                                </div>
                                <h3 class="feedback-titulo-1">Feedback</h3>
                                <p class="feedback-enviado-1">'.$card['mensagem'].'</p>
                            <div class="btn_verso_card">
                                <button id="aprovar" class="button-like" idFeedback="'.$card['id_feedback'].'">
                                    <img src="../assets/Like.svg" class="img-like">
                                     </button> 
                                <button id="reprovar" class="button-dislike" idFeedback="'.$card['id_feedback'].'">
                                    <img src="../assets/Dislike.svg" class="img-dislike">
                              
                                </button> 
                            </div>
                        </div>
                    </div>
                </div>
    ';
}

$ModalAprovado=Modal::showModalInfor("./../assets/Boneco Positivo.png","Aprovadíssimo!!!","APROVAR",null);
echo $ModalAprovado;

$ModalReprovado=Modal::showModalTextArea("Refletir!!!","./../assets/Boneco Pensando.png",null,"Justificativa","Reprovar",6,35);
echo $ModalReprovado;

//INCLUI O MENU GESTOR
$tituloPagina = 'APROVAR FEEDBACKS';
require './../includes/menu_gestor.php';
?>
<div class='caixa-geral-feedbak-colaborador-1'>    
    <div class='conteudo-feedbacks-colaborador-1'>

        <div id="contain_card">
            <?=$results == '' ? $blank_screen : $results;?>
        </div>
    </div>
</div>

    <!-- BLOCO DOS MODAIS -->
    <div class="joinha">
        <div id="modal-like" class="modal-feed">
            <div class="modal-dialog" style="color: red"><strong>
                <br>
                <div class="modal-content">
                    <header class="container-feed-like" id="header-cont-feed-like">
                        <a href="#" class="closebtn-feed"><sup>x</sup></a>
                        <h2>Aprovado!!!</h2>
                    </header>                    
                    <div class="container-feed-like" id="cont-feed-like">
                        <a href="#positivo"><img src="./../assets/Boneco Positivo.png" alt="Carregando..." id="positivo"></a>
                        <p id="aviso-like">Thank you!!!</p>
                        
                        <!-- NÃO APAGAR (o ID (id_modal_like) está sendo usado pelo JAVASCRIPT) -->
                        <p id="id_modal_like" style="color: red"></p> 
                    </div>                        
                        <footer class="container-feed-like" id="footer-cont-feed-like">
                            <div class="aprova-modal">

                            <button>APROVAR!!!!!</button>
                            
                            </div>
                        </footer>
                </div>
                <br>
            </strong></div>
        </div>


        <div id="modal-dislike" class="modal-feed">
            <div class="modal-dialog" style="color: red"><strong>
                <br>
                <div class="modal-content">
                    <header class="container-feed-dislike" id="header-cont-feed-dislike">
                        <a href="#" class="closebtn-feed"><sup>x</sup></a>
                        <h2>Refletir!!!</h2>
                    </header>
                    <div class="container-feed-dislike" id="cont-feed-dislike">
                        <img src="./../assets/Boneco Negativo.png" alt="Carregando..." id="negativo">

                        <!-- NÃO APAGAR (o ID (id_modal_like) está sendo usado pelo JAVASCRIPT) -->
                        <p id="id_modal_dislike" style="color: red"></p>
                        <p id="aviso-dislike">Por favor informe a sua análise</p>
                        
                    </div>
                    <footer class="container-feed-dislike" id="footer-cont-feed-dislike">
                        <div class="justify-modal">
                            <form  id="reprovar_feedback" method="post">
                                    <!-- <input type="hidden" id="id_reprovar" name="id_reprovar"> -->
                                    <label for="mensagem" id="justificativa_modal">Justificativa</label> 
                                    <textarea id="mensagem" name="mensagem" rows="6" cols="35" placeholder="Digite aqui a sua justificativa."></textarea>
                              <input type="submit" value="Reprovar">
                            </form>
                        </div>                            
                    </footer>
                </div>
             
            </strong></div>
        </div>
    </div>


    <script>
        const btn_like = document.querySelectorAll("#aprovar")
        const btn_dislike = document.querySelectorAll("#reprovar")
        const formulario = document.getElementById("modal-form-TextArea")
        const id_modal_like = document.getElementById("id_modal_like")
        const id_modal_dislike = document.getElementById("informacao-modal-escondida")
        const checkout = document.getElementById("botao_editavel_infor")

        
        //Elementos html do modal informativo
        const fecharModalInfor = document.getElementById('fechar-modal-infor');
        const modalI = document.getElementById('modal-padrao-infor');
        var msI = document.getElementById('descri-modal-infor');
        var tituloInfor = document.getElementById("texto-modal-infor")
        var imgAprov = document.getElementById("img-infor")

        //Elementos html do modal com area de texto
        const fecharModalText = document.getElementById('fechar-modal-text');
        const modalA = document.getElementById('modal-padrao-text');
        var msA = document.getElementById('descri-modal-text');
        var tituloText = document.getElementById('titulo-text');

        tituloInfor.style.color="green"
        tituloText.style.fontSize="30px";
        tituloInfor.style.fontSize="30px";
        imgAprov.style.width="auto";
        imgAprov.style.height="auto";
        
/// MODAL INFORMATIVO PARA APROVAÇÂO DO FEEDBACK
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

        //faz o botão X fechar o modal com formulario
        fecharModalInfor.addEventListener("click", function(event) {
            event.preventDefault();
            saiModalInfor();
        });

        //Faz o fade fechar o modal informativo de erro
        modalI.addEventListener("click", function(event) {
            if (event.target === modalI) {
                saiModalInfor();
            }
        });

/// MODAL DE COM AREA DE TEXTO PARA REPROVADOS

          //funcão responsavel por abrir o modal AreaText
          function abreModalText() {
            modalA.classList.remove("escondido");
            modalA.classList.add("amostra");
        }

        //função responsável por fechar o modal AreaText
        function saiModalText() {
            modalA.classList.remove("amostra");
            modalA.classList.add("escondido");
        }

        //faz o botão X fechar o modal com AreaText
        fecharModalText.addEventListener("click", function(event) {
            event.preventDefault();
            saiModalText();
        });

        //Faz o fade fechar o modal AreaText
        modalA.addEventListener("click", function(event) {
            if (event.target === modalA) {
                saiModalText();
            }
        });

        
 

        btn_like.forEach((element) => {
            element.addEventListener('click', function(event){
                event.preventDefault();
                let id = element.getAttribute("idFeedback")
                id_modal_like.innerText = id
                abreModalInfor()
                

                checkout.addEventListener('click',async function(){

                    let id_feedback = id_modal_like.textContent;
                    // console.log(id_feedback)

                    let data_php = await fetch('./action_aprova_feedback.php', {
                    method: 'POST',
                    body: JSON.stringify(id_feedback) 
                    });

                    let response = await data_php.json()

                    console.log(response)

                    if(response.status == "OK"){
                        location.href = "./feedback_gestor.php";
                    }else{
                        alert("ERROR");
                    }
                    })
            })
        })


        btn_dislike.forEach((element) => {
            element.addEventListener('click', function(event){
                event.preventDefault();
                id = element.getAttribute("idFeedback")
                console.log(id)
                id_modal_dislike.value = id
                document.getElementById('informacao-modal-escondida').value = id
                abreModalText()
                })
        })

        formulario.addEventListener('submit',async function(event){
                event.preventDefault();
               
                const formData = new FormData(formulario);

                let data_php = await fetch('./action_reprova_feedback.php', {
                method: 'POST',
                body: formData
                });

                let response = await data_php.json()

                if(response.status == "OK"){
                    location.href = "./feedback_gestor.php";
                }else{
                    alert("ERROR");
                }
            })
    </script>

<?php require '../includes/footer.php' ?>