<?php

namespace App\Entity;
use \App\Db\Database;
use \PDO;

class Feedback{
    /**
     * ID unico do feedback
     * @var integer
     */
    public $id_feedback;

    /**
     * Define a quantidade de Azcoins enviados no feedback
     * @var integer
     */
    public $qde_az_enviado;

    /**
     * Define a data que o feedback foi validado
     * @var string
     */
    public $data_validacao;

    /**
     * Define a hora que o feedback foi validado
     * @var string
     */
    public $hora_validacao;

    /**
     * Armazena a mensagem que o remetente escrevou para o destinatário
     * @var string
     */
    public $mensagem;

    /**
     * Define o id do remetente (Foreign Key)
     * @var integer
     */
    public $remetente_usuario;

    /**
     * Define o id do destinatário (Foreign Key)
     * @var integer
     */
    public $destinatario_usuario;

    /**
     * Define o status do feedback se foi ou não aprovado
     * @var integer
     */
    public $id_status_feedback;

    /**
     * Define o id da campanha vigente ao enviar o feedback
     * @var integer
     */
    public $id_campanha;

    /**
     * Método responsável por obter as carteiras do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getFeedbacks($where = null, $order = null, $limit = null){
        return (new Database('feedback'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Método responsável por buscar uma carteira com base no 'id_usuario'
     * @param integer $id_usuario
     * @return Feedback
     */
    public static function getFeedback($id_feedback){
        return (new Database('feedback'))->select('id_feedback = '.$id_feedback)->fetchObject(self::class);
    }

    // ---------------------------------------------------------------------------------------------------
    // Funções Tela Banco
    public static function getSaldoDiario(){
        return (new Database('feedback'))->selectFeedbackDiario()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function getSaldoTotal(){
        return (new Database('feedback'))->selectFeedbackTotal()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    // ---------------------------------------------------------------------------------------------------

    /**
     * Método responsável por quantificar as doações por mês
     * @param integer $campanhaAtiva
     * @return array
     */
    public static function countFeedbacksPorMes($campanhaAtiva){
        return (new Database('feedback'))->selectGroup('id_campanha = '.$campanhaAtiva, 'EXTRACT("MONTH" FROM data_validacao)', null, 'EXTRACT("MONTH" FROM data_validacao), COUNT(id_feedback)')->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Método responsável para incrementar informações no query database
     * @param string $id_usu
     * @param string $tipo
     * @param string $filtro_tempo
    */
    public static function getFeedbackHistfunction($id_usu, $tipo, $filtro_tempo) {
        if($tipo=='remetente'){
            $antipo = 'destinatario';
            $diferenciador1= 'rem';
            $diferenciador2= 'des';
        } else{
            $antipo="remetente";
            $diferenciador1= 'des';
            $diferenciador2= 'rem';
        }
        $query = "SELECT 
                    qde_az_enviado AS valor,
                    mensagem,
                    remetente_usuario AS remetente,
                    destinatario_usuario AS destinatario,
                    (SELECT apelido FROM usuario WHERE id_usuario = ".$antipo."_usuario) AS nome_".$diferenciador2.",
                    (SELECT imagem FROM usuario WHERE id_usuario = ".$antipo."_usuario) AS img_".$diferenciador2.",
                    (SELECT apelido FROM usuario WHERE id_usuario = ".$tipo."_usuario) AS nome_".$diferenciador1.",
                    (SELECT imagem FROM usuario WHERE id_usuario = ".$tipo."_usuario) AS img_".$diferenciador1.",
                    apelido AS nome_des,
                    imagem AS img_des,
                    nome_campanha AS campanha
                FROM 
                    feedback AS fee
                    JOIN usuario AS usu ON usu.id_usuario = fee.".$tipo."_usuario
                    JOIN campanha AS cam ON fee.id_campanha = cam.id_campanha
                WHERE 
                    usu.id_usuario =". $id_usu."
                ORDER BY ".
                    $filtro_tempo;
        return (new Database('feedback'))->selectHistFeed($query);
    }

    /**
     * Método responsável por cadastrar um feedback novo no banco de dados
     * @return boolean
    */
    public function enviarFeed(){
        //INSERIR O FEEDBACK NO BANCO
        $obDatabase = new Database('feedback');
        $this->id_feedback = $obDatabase->insert([
            'qde_az_enviado' => $this->qde_az_enviado,
            'data_criacao' => 'now()', 
            'mensagem' => $this->mensagem,
            'remetente_usuario' => $this->remetente_usuario,
            'destinatario_usuario' => $this->destinatario_usuario,
            'id_status_feedback' => 3,
            'id_campanha' => $this->id_campanha           
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por listar os cards
     * sem parametros
    */
    public static function listar_cards(){
        return (new Database())->selectDadosCards()->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Método responsável por aprovar o feedback
     * tabela feedback
     * // $id_status_feedback  (banco de dados => 2=reprovado e 1=aprovado)
     * @return boolean
    */
    public function aprovarFeedback($id_feedback){
        return (new Database('feedback'))->update('id_feedback ='.$id_feedback, ['id_status_feedback'=>1]);
        
    }


    /**
     * Método responsável por justificar o feedback reprovado
     * tabela analise
     * // $id_feedback
     * // $mensagem (justificativa)
     * @return boolean
    */
 

    public function reprovarFeedback($id_feedback){
        (new Database('feedback'))->update('id_feedback ='.$id_feedback, ['id_status_feedback'=>2]);
        return true;
    }
    
    public function reprovarFeedbackAnalise($dados){
        //INSERIR O FEEDBACK REPROVADO NA TABELA ANALISE(que vai mudar o nome depois)
        $obDatabase = new Database('analise');
        $result = $obDatabase->insert($dados);
        //RETORNAR SUCESSO
        return $result;
    }
    public static function getFeedbackAproRecufunction($id_usu, $tipo, $filtro_status) {
        
        if($tipo=='remetente'){
            $antipo = 'destinatario';
            $diferenciador1= 'rem';
            $diferenciador2= 'des';
        } else{
            $antipo="remetente";
            $diferenciador1= 'des';
            $diferenciador2= 'rem';
        }

        $query = "SELECT
                    id_feedback as id,
                    qde_az_enviado AS valor,
                    mensagem,
                    remetente_usuario AS remetente,
                    destinatario_usuario AS destinatario,
                    (SELECT apelido FROM usuario WHERE id_usuario = ".$antipo."_usuario) AS nome_".$diferenciador2.",
                    (SELECT imagem FROM usuario WHERE id_usuario = ".$antipo."_usuario) AS img_".$diferenciador2.",
                    (SELECT apelido FROM usuario WHERE id_usuario = ".$tipo."_usuario) AS nome_".$diferenciador1.",
                    (SELECT imagem FROM usuario WHERE id_usuario = ".$tipo."_usuario) AS img_".$diferenciador1.",
                    nome_campanha AS campanha,
                    status
                FROM 
                    feedback AS fee
                    JOIN usuario AS usu ON usu.id_usuario = fee.".$tipo."_usuario
                    JOIN campanha AS cam ON fee.id_campanha = cam.id_campanha
                    JOIN status_feedback as sta on fee.id_status_feedback = sta.id_status_feedback
                WHERE 
                    usu.id_usuario = ".$id_usu." AND fee.id_status_feedback ".$filtro_status." ORDER BY id_feedback DESC"
                ;
        return (new Database('feedback'))->selectHistFeed($query);
    }

    
    public static function getCarrosselFeedbacks() {
        $query = "SELECT * FROM Feedback";
        return (new Database('feedback'))->selectHistFeed($query);
    }

    public function atualizaFeedback($where,$coluna,$valor){
        return (new Database('feedback'))->updateUnico($where,$coluna,$valor);
    }

    public static function getAnalise($id_feedback){
        return (new Database('analise'))->select('id_feedback= '.$id_feedback)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getQtdAzPendente($id){
        return (new Database('feedback'))->QdePendete($id)->fetchAll(PDO::FETCH_ASSOC);
    }

  
public static function getTotalFeedbacks(){
    return (new Database())->getTotalFeedbacks()->fetchAll(PDO::FETCH_CLASS,self::class);
}


public static function getUltimoFeedbackEnviado(){
    return (new Database())->getLastFeedbackEnviado()->fetchAll(PDO::FETCH_CLASS,self::class);
}


public static function getUltimoFeedbackRecebido(){
    return (new Database())->getLastFeedbackRecebido()->fetchAll(PDO::FETCH_CLASS,self::class);
}

    //FUNÇÕES TELA BANCO 
    public static function getEnviadoHoje(){
        return (new Database('feedback'))->selectFeedbackEnviadoHoje()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function getSDoadosHoje(){
        return (new Database('feedback'))->selectDoadosHoje()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public static function getDistrDoadAguardDoacao(){
        return (new Database('feedback'))->selectDistrDoadAguardDoacao()->fetchAll(PDO::FETCH_CLASS,self::class);
    }
    
}