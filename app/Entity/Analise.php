<?php

namespace App\Entity;
use \App\Db\Database;
use \PDO;

class Analise{
    /**
     * ID unico da analise
     * @var integer
     */
    public $id_analise;

    /**
     * Define a quantidade de Azcoins que o remetente tentou enviar no feedback
     * @var integer
     */
    public $qde_enviado;

    /**
     * Define a data que a analise foi feita
     * @var string
     */
    public $data_analise;

    /**
     * Define a hora que a analise foi feita
     * @var string
     */
    public $hora_analise;

    /**
     * Armazena a mensagem que justifica o porquê o feedback foi reprovado
     * @var string
     */
    public $mensagem;

    /**
     * Define o id do feedback (Foreign Key)
     * @var integer
     */
    public $id_feedback;

    /**
     * Define o id do status do feedback (Foreign Key)
     * @var integer
     */
    public $id_status_feedback;
    
    /**
     * Define o id da carteira (Foreign Key)
     * @var integer
     */
    public $id_carteira;

    /**
     * Método responsável por buscar uma analise com base no 'id_feedback'
     * @param integer $id_feedback
     * @return Analise
    */    
    public static function getAnalise($id_feedback){
        return (new Database('analise'))->select('id_feedback= '.$id_feedback)->fetchObject(self::class);
    }
}