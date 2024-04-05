<?php
// echo '<pre>';
// print_r($usuarioLogado);
// echo '</pre>';
// exit;

//INCLUI O AUTO LOAD
require __DIR__.'../../vendor/autoload.php';

//DEPENDÊNCIAS
use \App\Session\Login;
use \App\Entity\Campanha;
use \App\Entity\Usuario;

//OBRIGADO O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

$obCampanha = new Campanha;
$id_campanha = $_GET['id'];
$editCampanha = $obCampanha->visualizarCampanha($id_campanha);
    
    if(isset($_POST['nome_camp'], $_POST['input-quantidade'], $_POST['data1'], $_POST['data2'])){
    $editCampanha->nome_campanha = addslashes($_POST['nome_camp']);
    $editCampanha->qde_az_por_colaborador = addslashes($_POST['input-quantidade']);
    $editCampanha->data_inicio = addslashes($_POST['data1']);
    // $editCampanha->hora_inicio = addslashes($_POST['hora1']);
    $editCampanha->data_final = addslashes($_POST['data2']);
    // $editCampanha->hora_final = addslashes($_POST['hora2']); 
    $data_inicio = DateTime::createFromFormat('Y-m-d', $editCampanha->data_inicio);
    $data_final = DateTime::createFromFormat('Y-m-d', $editCampanha->data_final);

    
    if ($data_inicio < $data_final) {
        $status_campanha = 1;   
    } else {
        $status_campanha = 0;
    }
    $editCampanha->status_campanha = $status_campanha;
    $editCampanha->atualizar_campanha($id_campanha);

}

//INCLUI O MENU GESTOR
require './../includes/menu_gestor.php';

?>

<div class="campanha">
    
    <div class="tudo">
        <img class="boneco" src="../assets/homirisonhodolike.png" alt="Carregando...">
        <form class="form" method="POST">
            <div class="primeira-div">
                <div class="posicao-input">
                    <div id="caracteristicas" class="caixa-input">
                    <input required="" name="nome_camp" type="text" class="input" id="nome_camp" value="<?php echo $editCampanha->nome_campanha ; ?>">
                        <label class="label">
                            <span class="label-letra" style="--index: 0">N</span>
                            <span class="label-letra" style="--index: 1">o</span>
                            <span class="label-letra" style="--index: 2">m</span>
                            <span class="label-letra" style="--index: 3">e</span>
                            <span class="label-letra" style="--index: 4" id="espaco">_</span>
                            <span class="label-letra" style="--index: 5">D</span>
                            <span class="label-letra" style="--index: 6">a</span>
                            <span class="label-letra" style="--index: 7" id="espaco">_</span>
                            <span class="label-letra" style="--index: 8">C</span>
                            <span class="label-letra" style="--index: 9">a</span>
                            <span class="label-letra" style="--index: 10">m</span>
                            <span class="label-letra" style="--index: 11">p</span>
                            <span class="label-letra" style="--index: 12">a</span>
                            <span class="label-letra" style="--index: 13">n</span>
                            <span class="label-letra" style="--index: 14">h</span>
                            <span class="label-letra" style="--index: 15">a:</span>
                        </label>
                        <svg class="visualizar" id="open-modal" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg>
                        <hr class="linha-input">
                    </div>

                    <span id="usuarios">
                        <?php
                            $obUsuarios = new Usuario;
                            $qtd = $obUsuarios->getQuantidadeUsuarios('id_status_user = 1');
                        ?>
                    </span>

                    <div class="caixa-input2">
                        <input onchange="multiplicar()" required="" type="number" class="input" name="input-quantidade" id="input-quantidade" value="<?php echo $editCampanha->qde_az_por_colaborador; ?>">
                        <label class="label">
                            <span class="label-letra" style="--index: 1">A</span>
                            <span class="label-letra" style="--index: 2">Z</span>
                            <span class="label-letra" style="--index: 3">m</span>
                            <span class="label-letra" style="--index: 4">e</span>
                            <span class="label-letra" style="--index: 5">r</span>
                            <span class="label-letra" style="--index: 6">i</span>
                            <span class="label-letra" style="--index: 7">t</span>
                            <span class="label-letra" style="--index: 8" id="espaco">_</span>
                            <span class="label-letra" style="--index: 9">P</span>
                            <span class="label-letra" style="--index: 10">o</span>
                            <span class="label-letra" style="--index: 11">r</span>
                            <span class="label-letra" style="--index: 12" id="espaco">_</span>
                            <span class="label-letra" style="--index: 13">C</span>
                            <span class="label-letra" style="--index: 14">o</span>
                            <span class="label-letra" style="--index: 15">l</span>
                            <span class="label-letra" style="--index: 16">a</span>
                            <span class="label-letra" style="--index: 17">b</span>
                            <span class="label-letra" style="--index: 18">o</span>
                            <span class="label-letra" style="--index: 19">r</span>
                            <span class="label-letra" style="--index: 20">a</span>
                            <span class="label-letra" style="--index: 21">d</span>
                            <span class="label-letra" style="--index: 22">o</span>
                            <span class="label-letra" style="--index: 23">r</span>
                            <span class="label-letra" style="--index: 24">:</span>
                        </label>
                        <hr class="linha-input">

                        <div class="saldo-distribuido">
                            <img class="moeda" src="..\assets\moedaAZ.png" alt="">
                            <span  class="valor"> Total Distribuído AZ: <var name="saldo_distr" id="saldo_distr"></var></span>
                        </div>
                    </div>

                </div> 
                                                
            </div>
            
            <div class="posicao-data">
                <div class = "input-data">
                    <input name="data1" type="date" id="data_inicio" class="infos data1" value="<?php echo $editCampanha->data_inicio ?>"> 
                </div>
                
                <div class ="input-data">   
                    <input name="data2" type="date" id="data_final" class="infos data2" value="<?php echo $editCampanha ->data_final?>">
                </div>
            </div>
            
            <div class="botoes">
                <button type="submit" name="cancelar" id="letra-botao" class="custom-btn-2 btn-2">Cancelar</button>
                <button type="submit" value="salvar" name="salvar" id="letra-botao" class="custom-btn btn-1">Salvar</button>
            </div>
        </form>
    </div>

    <script>
    function Autoload() {
        console.log("Página carregada e função autoload executada.");
    }
    window.onload = Autoload;
    </script>

    <?php require "../includes/modais/listar_campanhas.php"?>

    <script src="../js/modal.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        function multiplicar() {
            var valorUm = parseInt(document.getElementById("input-quantidade").value)

            if(isNaN(valorUm)){
            valorUm = 0
        }
        $.ajax({
            url: 'envio_gestor.php',
            type: 'POST',
            success: function(data){
                console.log('Dados recebidos:', data); 
                var valorDois = parseInt(document.getElementById("usuarios").value);

                if (isNaN(valorDois)) {
                    valorDois = <?=$qtd ?>;
                }


                var saldo_distr = valorUm * valorDois;

                var saldo_distr_texto = document.getElementById("saldo_distr").innerText = saldo_distr;
                var saldo_distr = parseInt(saldo_distr_texto, 10);
            },
            error: function() {
                console.error('Error fetching saldo_distr value');
            }
        });
    }
    </script>

</div>

<?php require '../includes/footer.php' ?>