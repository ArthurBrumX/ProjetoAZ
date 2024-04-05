<?php
namespace App\Session;

class Modal{
    /**
     * Caminho da imagem do modal
     * @var string
     */
    public $imagem_modal;

    /**
     * Define o texto que irá aparecer no modal
     * @var string
     */
    public $mensagem_modal;

    /**
     * Define o texto do botão do modal
     * @var integer
     */
    public $botao_modal;

    /**
     * Define o texto da descrição no modal
     * @var integer
     */
    public $modal_desc;
    

    /**
     * Método responsável por mostrar o modal na tela
     * @var string $imagem_modal
     * @var string $mensagem_modal
     * @var string $botao_modal
     * @var string $modal_desc
     * @return string
     */
    public static function showModalInfor($imagem_modal = null, $mensagem_modal = null, $botao_modal = null, $modal_desc = null){
        $modal = '';
        //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
        $imagem_modal = !empty($imagem_modal) ? '<img id="img-infor" src="'.$imagem_modal.'" alt="">' : '';
        $mensagem_modal = !empty($mensagem_modal) ? $mensagem_modal : '';
        $botao_modal = !empty($botao_modal) ? $botao_modal : 'CONTINUAR';
        $modal_desc = !empty($modal_desc) ? '<p class="descricao-modal" id="descri-modal-infor">'.$modal_desc.'</p>' : '<p class="descricao-modal" id="descri-modal-infor"></p>';
        //MONTA O MODAL
        $modal = '<dialog id="modal-padrao-infor" class="modal-padrao-ao escondido">
                    <div class="conteudo-modal-padrao">
                        <buttom class="fechar-modal" id="fechar-modal-infor">&times;</buttom> 
                        <h2 class="titulo-modal-geral" id="texto-modal-infor">'.$mensagem_modal.'</h2>
                        '.$imagem_modal.'
                        '.$modal_desc.'
                        <div class="modal-footer">
                            <button type="button" class="botao-modal-padrao" id="botao_editavel_infor">'.$botao_modal.'</button>
                        </div>
                    </div>
                </dialog>';

        

        //RETORNA O MODAL
        return $modal;
    }

    /**
     * Método responsável por mostrar o modal na tela
     * @var string $imagem_modal
     * @var string $mensagem_modal
     * @var string $botao_modal
     * @var string $modal_desc
     * @return string
     */
    public static function showModalForm($imagem_modal = null, $mensagem_modal = null, $botao_modal = null, $modal_desc = null){
        $modal = '';
        //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
        $imagem_modal = !empty($imagem_modal) ? '<img src="'.$imagem_modal.'" alt="">' : '';
        $mensagem_modal = !empty($mensagem_modal) ? $mensagem_modal : '';
        $botao_modal = !empty($botao_modal) ? $botao_modal : 'salvar';
        $modal_desc = !empty($modal_desc) ? '<p class="descricao-modal" id="descri-modal-form">'.$modal_desc.'</p>' : "";

        $modal = '<dialog id="modal-padrao-form" class="modal-padrao-ao escondido">
        <form class="conteudo-modal-padrao" id="formulario">
            <buttom class="fechar-modal" id="fechar-modal-form">&times;</buttom> 
            <h2 class="titulo-modal-geral">'.$mensagem_modal.'</h2>
            '.$imagem_modal.'
            '.$modal_desc.'
            <div class="modal-footer">
                <a class="opcao-modal-botao"><button type="button" class="botao-modal-padrao" data-dismiss="#modal-padrao" id="botao_cancela_form">cancelar</button></a>
                <input type="submit" class="botao-modal-padrao" id="botao_editavel-form" value="'.$botao_modal.'">
            </div>
        </form>
    </dialog>';

    //RETORNA O MODAL
    return $modal;

    }
    
    /**
     * Método responsável por mostrar o modal na tela
     * @var string $imagem_modal
     * @var string $mensagem_modal
     * @var string $botao_modal
     * @var string $modal_desc
     * @return string
     */
    public static function showModalDirec($imagem_modal = null, $mensagem_modal = null, $caminho = null, $modal_desc = null){
        $modal = '';
        //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
        $imagem_modal = !empty($imagem_modal) ? '<img id="img-redic" src="'.$imagem_modal.'" alt="">' : '';
        $mensagem_modal = !empty($mensagem_modal) ? $mensagem_modal : '';
        $botao_modal = !empty($botao_modal) ? $botao_modal : 'Continuar';
        $modal_desc = !empty($modal_desc) ? '<p class="descricao-modal" id="descri-modal-redic">'.$modal_desc.'</p>' : '<p class="descricao-modal" id="descri-modal-redic"></p>';

        $modal = '
        <dialog id="modal-padrao-direc" class="modal-padrao-ao escondido">
            <div class="conteudo-modal-padrao">
                '.$imagem_modal.'
                <buttom class="fechar-modal" id="fechar-modal-direc">&times;</buttom> 
                <h2 class="titulo-modal-geral" id="titulo-redic">'.$mensagem_modal.'</h2>
                '.$modal_desc.'
                <div class="modal-footer">
                    <a href="'.$caminho.'" class="opcao-modal-botao" id="botao_editavel-direc" ><button type="button" class="botao-modal-padrao" data-dismiss="#modal-padrao" id="botao_editavel_direc">CONTINUAR</button></a>
                </div>
            </div>
        </dialog>';

    //RETORNA O MODAL
    return $modal;
    
    }
    
    /**
     * Método responsável por mostrar o modal na tela
     * @var string $imagem_modal
     * @var string $mensagem_modal
     * @var string $botao_modal
     * @var string $modal_desc
     * @return string
     */
    public static function showModalTextArea($mensagem_modal = null,$imagem_modal = null,$modal_desc = null,$titulo_areatexto = null,$botao_modal = null,$rows = null,$cols=null){
        $modal = '';
        //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
        $imagem_modal = !empty($imagem_modal) ? '<img id="img-text" src="'.$imagem_modal.'" alt="">' : '';
        $mensagem_modal = !empty($mensagem_modal) ? $mensagem_modal : '';
        $botao_modal = !empty($botao_modal) ? $botao_modal : 'Continuar';
        $modal_desc = !empty($modal_desc) ? '<p class="descricao-modal" id="descri-modal-text">'.$modal_desc.'</p>' : '';
        $titulo_areatexto = !empty($titulo_areatexto) ? "<h3 class='titulo-modal-Areatexto'>".$titulo_areatexto."</h3>": "<h3 class='titulo-modal-Areatexto'></h3>";

        $modal = '
        <dialog id="modal-padrao-text" class="modal-padrao-ao escondido">
            <form  id="modal-form-TextArea" class="conteudo-modal-padrao">
                <h2 class="titulo-modal-geral" id="titulo-text">'.$mensagem_modal.'</h2>
                '.$imagem_modal.'
                <buttom class="fechar-modal" id="fechar-modal-text">&times;</buttom> 
                
                '.$modal_desc.'
                <div class="divisor-modal-text">'.
                $titulo_areatexto.'
                <textarea id="mensagem-modalText" name="mensagem" rows= "'.$rows.'" cols="'.$cols.'" placeholder="Digite aqui a sua mensagem"></textarea>
                </div>
                <div class="modal-footer" id="conjunto-modal-text-input">
                    <input type="hidden" id="informacao-modal-escondida" value="" name="id">
                    <input type="submit" class="botao-modal-padrao" id="botao_editavel-text" maxlength="240" value="'.$botao_modal.'">
                </form>
            </div>
        </dialog>';

    //RETORNA O MODAL
    return $modal;
    
    }

    /**
     * Método responsável por mostrar o modal na tela
     * @var string $imagem_modal
     * @var string $mensagem_modal
     * @var string $botao_modal
     * @var string $modal_desc
     * @return string
     */
    public static function showModalConf($imagem_modal = null, $mensagem_modal = null, $botao_modal = null, $modal_desc = null){
        $modal = '';
        //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
        $imagem_modal = !empty($imagem_modal) ? '<img src="'.$imagem_modal.'" alt="">' : '';
        $mensagem_modal = !empty($mensagem_modal) ? $mensagem_modal : '';
        $botao_modal = !empty($botao_modal) ? $botao_modal : 'salvar';
        $modal_desc = !empty($modal_desc) ? '<p class="descricao-modal" id="descri-modal-Conf">'.$modal_desc.'</p>' : "";

        $modal = '<dialog id="modal-padrao-conf" class="modal-padrao-ao escondido">
        <form class="conteudo-modal-padrao" id="form-confirma">
            <buttom class="fechar-modal" id="fechar-modal-conf">&times;</buttom> 
            <h2 class="titulo-modal-geral">'.$mensagem_modal.'</h2>
            '.$imagem_modal.'
            '.$modal_desc.'
            <input type="hidden" id="conf-hidden" value="0" name="info-salva">
            <div class="modal-footer">
                <a class="opcao-modal-botao"><button type="button" class="botao-modal-padrao" data-dismiss="#modal-padrao" id="botao_cancela_conf">cancelar</button></a>
                <input type="submit" class="botao-modal-padrao" id="botao_editavel-conf" value="'.$botao_modal.'">
            </div>
        </form>
    </dialog>';

    //RETORNA O MODAL
    return $modal;

    }

}