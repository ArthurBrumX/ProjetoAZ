<?php
//echo '<pre>';
//print_r($us);
//echo '</pre>';
//exit;

require __DIR__.'../../vendor/autoload.php';

use \App\Session\Login;
use \App\Entity\Usuario;
use \App\Entity\Carteira;
use App\Entity\Feedback;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//DADOS DO USUÁRIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//INCLUI O MENU USUARIO
$tituloPagina = 'ENVIAR FEEDBACK';
require '../includes/menu_user.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Index</title>
        <link rel="stylesheet" href="../css/usuarios/enviar.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    </head>
<body>

<!--TELA HOME USUARIO-->
<div class="tela-enviar-az-coins">
    <div class="div1">
        <div class="flip-card">
            <div class="flip-card-inner">

                <div class="flip-card-front">
                    <p class="heading_8264">AZCARD</p>
                    <img src="../assets/Simbolo-Az-Cartao.png" alt="" class="logo">
                    <svg version="1.1" class="chip" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="30px" viewBox="0 0 50 50" xml:space="preserve">  <image id="image0" width="50" height="50" x="0" y="0" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAABGdBTUEAALGPC/xhBQAAACBjSFJN
                        AAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAB6VBMVEUAAACNcTiVeUKVeUOY
                        fEaafEeUeUSYfEWZfEaykleyklaXe0SWekSZZjOYfEWYe0WXfUWXe0WcgEicfkiXe0SVekSXekSW
                        ekKYe0a9nF67m12ZfUWUeEaXfESVekOdgEmVeUWWekSniU+VeUKVeUOrjFKYfEWliE6WeESZe0GS
                        e0WYfES7ml2Xe0WXeESUeEOWfEWcf0eWfESXe0SXfEWYekSVeUKXfEWxklawkVaZfEWWekOUekOW
                        ekSYfESZe0eXekWYfEWZe0WZe0eVeUSWeETAnmDCoWLJpmbxy4P1zoXwyoLIpWbjvXjivnjgu3bf
                        u3beunWvkFWxkle/nmDivXiWekTnwXvkwHrCoWOuj1SXe0TEo2TDo2PlwHratnKZfEbQrWvPrWua
                        fUfbt3PJp2agg0v0zYX0zYSfgkvKp2frxX7mwHrlv3rsxn/yzIPgvHfduXWXe0XuyIDzzISsjVO1
                        lVm0lFitjVPzzIPqxX7duna0lVncuHTLqGjvyIHeuXXxyYGZfUayk1iyk1e2lln1zYTEomO2llrb
                        tnOafkjFpGSbfkfZtXLhvHfkv3nqxH3mwXujhU3KqWizlFilh06khk2fgkqsjlPHpWXJp2erjVOh
                        g0yWe0SliE+XekShhEvAn2D///+gx8TWAAAARnRSTlMACVCTtsRl7Pv7+vxkBab7pZv5+ZlL/UnU
                        /f3SJCVe+Fx39naA9/75XSMh0/3SSkia+pil/KRj7Pr662JPkrbP7OLQ0JFOijI1MwAAAAFiS0dE
                        orDd34wAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfnAg0IDx2lsiuJAAACLElEQVRIx2Ng
                        GAXkAUYmZhZWPICFmYkRVQcbOwenmzse4MbFzc6DpIGXj8PD04sA8PbhF+CFaxEU8iWkAQT8hEVg
                        OkTF/InR4eUVICYO1SIhCRMLDAoKDvFDVhUaEhwUFAjjSUlDdMiEhcOEItzdI6OiYxA6YqODIt3d
                        I2DcuDBZsBY5eVTr4xMSYcyk5BRUOXkFsBZFJTQnp6alQxgZmVloUkrKYC0qqmji2WE5EEZuWB6a
                        lKoKdi35YQUQRkFYPpFaCouKIYzi6EDitJSUlsGY5RWVRGjJLyxNy4ZxqtIqqvOxaVELQwZFZdkI
                        JVU1RSiSalAt6rUwUBdWG1CP6pT6gNqwOrgCdQyHNYR5YQFhDXj8MiK1IAeyN6aORiyBjByVTc0F
                        qBoKWpqwRCVSgilOaY2OaUPw29qjOzqLvTAchpos47u6EZyYnngUSRwpuTe6D+6qaFQdOPNLRzOM
                        1dzhRZyW+CZouHk3dWLXglFcFIflQhj9YWjJGlZcaKAVSvjyPrRQ0oQVKDAQHlYFYUwIm4gqExGm
                        BSkutaVQJeomwViTJqPK6OhCy2Q9sQBk8cY0DxjTJw0lAQWK6cOKfgNhpKK7ZMpUeF3jPa28BCET
                        amiEqJKM+X1gxvWXpoUjVIVPnwErw71nmpgiqiQGBjNzbgs3j1nus+fMndc+Cwm0T52/oNR9lsdC
                        S24ra7Tq1cbWjpXV3sHRCb1idXZ0sGdltXNxRateRwHRAACYHutzk/2I5QAAACV0RVh0ZGF0ZTpj
                        cmVhdGUAMjAyMy0wMi0xM1QwODoxNToyOSswMDowMEUnN7UAAAAldEVYdGRhdGU6bW9kaWZ5ADIw
                        MjMtMDItMTNUMDg6MTU6MjkrMDA6MDA0eo8JAAAAKHRFWHRkYXRlOnRpbWVzdGFtcAAyMDIzLTAy
                        LTEzVDA4OjE1OjI5KzAwOjAwY2+u1gAAAABJRU5ErkJggg=="></image>
                    </svg>
                    <svg version="1.1" class="contactless" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" xml:space="preserve">  <image id="image0" width="50" height="50" x="0" y="0" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAQAAAC0NkA6AAAABGdBTUEAALGPC/xhBQAAACBjSFJN
                        AAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAJcEhZ
                        cwAACxMAAAsTAQCanBgAAAAHdElNRQfnAg0IEzgIwaKTAAADDklEQVRYw+1XS0iUURQ+f5qPyjQf
                        lGRFEEFK76koKGxRbWyVVLSOgsCgwjZBJJYuKogSIoOonUK4q3U0WVBWFPZYiIE6kuArG3VGzK/F
                        fPeMM/MLt99/NuHdfPd888/57jn3nvsQWWj/VcMlvMMd5KRTogqx9iCdIjUUmcGR9ImUYowyP3xN
                        GQJoRLVaZ2DaZf8kyjEJALhI28ELioyiwC+Rc3QZwRYyO/DH51hQgWm6DMIh10KmD4u9O16K49it
                        VoPOAmcGAWWOepXIRScAoJZ2Frro8oN+EyTT6lWkkg6msZfMSR35QTJmjU0g15tIGSJ08ZZMJkJk
                        HpNZgSkyXosS13TkJpZ62mPIJvOSzC1bp8vRhhCakEk7G9/o4gmZdbpsTcKu0m63FbnBP9Qrc15z
                        bkbemfgNDtEOI8NO5L5O9VYyRYgmJayZ9nPaxZrSjW4+F6Uw9yQqIiIZwhp2huQTf6OIvCZyGM6g
                        DJBZbyXifJXr7FZjGXsdxADxI7HUJFB6iWvsIhFpkoiIiGTJfjJfiCuJg2ZEspq9EHGVpYgzKqwJ
                        qSAOEwuJQ/pxPvE3cYltJCLdxBLiSKKIE5HxJKcTRNeadxfhDiuYw44zVs1dxKwRk/uCxIiQkxKB
                        sSctRVAge9g1E15EHE6yRUaJecRxcWlukdRIbGFOSZCMWQA/iWauIP3slREHXPyliqBcrrD71Amz
                        Z+rD1Mt2Yr8TZc/UR4/YtFnbijnHi3UrN9vKQ9rPaJf867ZiaqDB+czeKYmd3pNa6fuI75MiC0uX
                        XSR5aEMf7s7a6r/PudVXkjFb/SsrCRfROk0Fx6+H1i9kkTGn/E1vEmt1m089fh+RKdQ5O+xNJPUi
                        cUIjO0Dm7HwvErEr0YxeibL1StSh37STafE4I7zcBdRq1DiOkdmlTJVnkQTBTS7X1FYyvfO4piaI
                        nKbDCDaT2anLudYXCRFsQBgAcIF2/Okwgvz5+Z4tsw118dzruvIvjhTB+HOuWy8UvovEH6beitBK
                        xDyxm9MmISKCWrzB7bSlaqGlsf0FC0gMjzTg6GgAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjMtMDIt
                        MTNUMDg6MTk6NTYrMDA6MDCjlq7LAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIzLTAyLTEzVDA4OjE5
                        OjU2KzAwOjAw0ssWdwAAACh0RVh0ZGF0ZTp0aW1lc3RhbXAAMjAyMy0wMi0xM1QwODoxOTo1Nisw
                        MDowMIXeN6gAAAAASUVORK5CYII="></image>
                    </svg>
                    <p class="name">
                        <?php
                            echo $usuarioLogado['apelido'];
                        ?>
                    </p>
                </div>

                <div class="flip-card-back">
                    <div class="strip"></div>
                    <p class="saldo">SALDO</p> 
                    <div class="sstrip">
                        <p class="code">
                            <?php
                               $saldo = Carteira::getCarteira($usuarioLogado['id_usuario']);
                               $saldo_pendente = Feedback::getQtdAzPendente($usuarioLogado['id_usuario']);
                               $valor_soma = $saldo_pendente[0]['sum'];

                               if(is_object($saldo) && property_exists($saldo, 'saldo_doacao_usuario')){
                                   $saldo_doacao = ($saldo->saldo_doacao_usuario) - $valor_soma;

                                   if(is_null($saldo_doacao)){
                                        echo "00";
                                        $saldo_doacao  = 00;
                                   }elseif ($saldo_doacao == 0){
                                        echo "00";
                                        $saldo_doacao  = 00;
                                   }else{
                                        echo $saldo_doacao;
                                   }

                               }else {
                                   echo "00";
                                   $saldo_doacao  = 00;
                               }
                            ?>
                        </p>
                    </div>
                    
                </div>

            </div>
        </div>
        <img class="boneco" src="../assets/supergirl.png" alt="">
    </div>   
    <dialog id="dialog" class="dialog-feedback">
                <div class="div-dialog-feedback">
                    <p class="titulo-modal-envia">ENVIADO COM SUCESSO</p>
                    <div class="btn_ok_feedback">
                        <button id="redirecionarConcluido" class="btn_dialog_feed">CONTINUAR</button>
                    </div>
                    
                </div>
    </dialog>         

    <div class="wrap-enviar">
        <form method="POST" class="enviar-form" id="form_enviar_Feedback">
            <span class="enviar-form-title"></span>
            <div class="wrap-input">
                <span class="focus-input-form" data-placeholder="Enviar para"></span>
                <select class="btn-enviar-para" name="Colaborador" id="Colaborador" >
                    <option value="1">SELECIONE COLABORADOR</option>
                    <?php
                    $fil = 'id_usuario, nome';
                    $usuarios = Usuario::getUsuarios('id_usuario != '.$usuarioLogado['id_usuario'].' AND id_perfil_usuario = 3 AND id_status_user = 1 ', 'nome', null);

                    foreach ($usuarios as $option) {
                        // Certifique-se de que os valores não estão vazios
                        $id_usuario = $option->id_usuario;
                        $nome = $option->nome;

                        echo '<option  value="'. $id_usuario .' ">  '. $nome  .' </option>';
                    }
                    ?>
                </select>

                </script>
                <span class="span-require">SELECIONE UM COLABORADOR</span>
                <input type="hidden" name="usuariologado" value="<?php echo $usuarioLogado['id_usuario']; ?>">
                <input type="hidden" name="saldoParaDoar" value="<?php echo $saldo_doacao;?>" id="saldoParaDoar">
                
            </div>
            <div class="wrap-input">
                <span class="focus-input-form" data-placeholder="Quantidade de Azcoins"></span>
                <input type="text" name="quantia" id="quantia" class="input-form-qtd" autocomplete="off" placeholder="AZ$ 1000">
                <span class="span-require">VALOR DE SALDO MENOR QUE QUANTIA QUE VOCÊ QUER ENVIAR</span>
                <span class="span-require">ADICIONE UM VALOR PARA ENVIAR</span>


            </div>
            <div class="wrap-input-text">                    
                <span class="focus-input-form" data-placeholder="Mensagem"></span>
                <textarea name="mensagem" id="msgFeedback" cols="38" rows="15"  maxlength="240"></textarea>
                <span class="span-require">ADICIONE UMA MENSAGEM MAIS DETRALHADA</span>
            </div>
            <div class="container-enviar-form-btn">
                <button class="enviar-form-btn" name =  'btn_feed' id='btn_feed'>ENVIAR</button>
            </div>

            <dialog id="dialog_confirmar" class="dialog-feedback" >
                <div class="div-dialog-feedback">
                    <buttom class="fechar-modal" id="fechar-modal-infor">&times;</buttom>
                    <div class="conteudo-modal-enviar-az">
                        <h3 class="titulo-modal-envia">Quantidade de AZCoins a ser enviada é :</h3><span class="span_quantia_modal">AZ$</span><span id="quantiaModal" class="span_quantia_modal"></span>
                        <p class="paragrafo-modal-envia" id="destinatario-envio">Para: <span id="destinatario"></span></p>
                        <div class="btns-dialog-feedback">
                            <button id = 'btn_cancelar' class="btn_dialog_feed_cancelar">CANCELAR</button>
                            <button name = 'btn_confirmar' type="submit" id="btn_confirmar" class="btn_dialog_feed">CONFIRMAR</button>
                        </div>
                    </div>
                </div>
            </dialog>

        </form>
    </div>
</div>

<!-- Script para aplicar a máscara -->
<script>



const selecionaColaborador = document.getElementById('Colaborador')
selecionaColaborador.addEventListener('change',function(){
    console.log(selecionaColaborador.value)
})


    $(document).ready(function() {
        $('#quantia').mask('000000000', { reverse: true });
    });

    $(document).ready(function() {
        $('#Colaborador').select2();
    });

</script>

<script src="../js/enviar_user.js"></script>    

<?php require '../includes/footer.php';
?>


