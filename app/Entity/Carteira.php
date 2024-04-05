<?php

namespace App\Entity;

    //Como iremos utilizar a Database na linha 58 temos que definí-lo como uma dependência da classe 'Usuario'.
    //Para isso usaremos a linha de código abaixo:
use \App\Db\Database;
use \PDO;

class Carteira{
    /**
     * ID unico da carteira
     * @var integer
     */
    public $id_carteira;

    /**
     * Define a quantidade de Azcoins recebidos pela campanha
     * @var integer
     */
    public $valor_recebido_campanha;

    /**
     * Define o saldo que o usuario pode doar
     * @var integer
     */
    public $saldo_doacao_usuario;

    /**
     * Define o saldo recebido por outros usuarios
     * @var integer
     */
    public $saldo_recebido_feedback;

    /**
     * Define o saldo separado para aprovação do gestor
     * @var integer
     */

    /**
     * Define o id do usuário (Foreign Key)
     * @var integer
     */
    public $id_usuario;

    /**
     * Define o id da campanha???????????????
     * @var integer
     */
    public $id_campanha;

    /**
     * Define o id da analise????????????????
     * @var integer
     */
    public $id_analise;

    /**
     * Define o id da central de transacao???????????????
     * @var integer
     */
    public $id_central_transacao;

    /**
     * Define o status de aprovação do feedback
     * @var integer
     */
    public $id_status_feedback;

    /**
     * Método responsável por obter as carteiras do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getCarteiras($where = null, $order = null, $limit = null){
        return (new Database('usuario'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Método responsável por buscar uma carteira com base no 'id_usuario'
     * @param integer $id_usuario
     * @return Carteira
     */
    public static function getCarteira($id_usuario){
        return (new Database('carteira'))->select('id_usuario = '.$id_usuario)->fetchObject(self::class);
    }

    /**
     * Método responsável por contar quantas carteiras receberam azcoins
     * @param integer $id_campanha
     * @return Carteira
     */
    public static function rel_admin($id_campanha){
        return (new Database('carteira'))->select('id_campanha = '.$id_campanha, null, null, 'COUNT (*)')->fetchObject()->count;
    }


      /**
     * Método responsável por contar quantas carteiras receberam azcoins
     * @param integer $id_campanha
     * @return Carteira
     */
    public static function countCarteiras($id_campanha){
        return (new Database('carteira'))->select('id_campanha = '.$id_campanha, null, null, 'COUNT (*)')->fetchObject()->count;
    }

    // public function setSaldoPendente(){
    //     $obDatabase = new Database('carteira');
    //     $this->id_carteira = $obDatabase->update('id_usuario ='.$this->id_usuario,[
    //         'saldo_pendente_aprovacao' => $this->saldo_pendente_aprovacao
    //     ]
    //     );
        
    //     if($obDatabase){
    //         return true;
    //     }
    // }FUNÇÃO DESATIVADA COLUNA saldo_pendente_aprovacao REMOVIDA DA TABELA

    // public function setSaldoDoacaoAtt(){
    //     $obDatabase = new Database('carteira');
    //     $this->id_carteira = $obDatabase->update('id_usuario ='.$this->id_usuario,[
    //         'saldo_doacao_usuario' => $this->saldo_doacao_usuario
    //     ]
    //     );
        
    //     if($obDatabase){
    //         return true;
    //     }
    // } A TRIGGER JÁ FAZ ESSA FUNÇÃO DE SUBTRATIR O SALDO DO USUÁRIO
    public function atualizarSaldoCarteira($id_carteira,$saldo){
        return (new Database('carteira'))->atualizaSaldo($id_carteira,$saldo);
    }

    public static function saldosGerais(){
        return (new Database('carteira'))->getSaldosGerais()->fetchObject(self::class);
    }
}