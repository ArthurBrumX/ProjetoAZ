<?php

namespace App\Entity;

//Como iremos utilizar a Database na linha 58 temos que definí-lo como uma dependência da classe 'Usuario'.
//Para isso usaremos a linha de código abaixo:
use \App\Db\Database;
use \PDO;

use \pages\editar_campanha;

class Campanha{
    /**
     * ID unico da campanha
     * @var integer
     */
    public $id_campanha;

    /**
     * Define o nome completo da campanha
     * @var string
     */
    public $nome_campanha;

    /**
     * Define a data de início da campanha
     * @var string
     */
    public $data_inicio;

    /**
     * Define a data final da campanha
     * @var string
     */
    public $data_final;

    /**
     * Define a quantidade de AZcoins por colaborador
     * @var integer
     */
    public $qde_az_por_colaborador;
    
    /**
     * Define o saldo distribuído para todos os usuários
     * @var integer
     */
    public $saldo_distr;

    /**
     * Define o status ativo ou inativo da campanha
     * @var bool
     */
    public $status_campanha;

    /**
     * Método responsável por cadastrar uma campanha nova no banco de dados
     * @var boolean
     */
    public function enviar(){
        //INSERIR A CAMPANHA NO BANCO
        $obDatabase = new Database('Campanha');
        $this->id_campanha = $obDatabase->insert([
            'nome_campanha'             => $this->nome_campanha,
            'qde_az_por_colaborador'    => $this->qde_az_por_colaborador,
            'data_inicio'               => $this->data_inicio,
            'data_final'                => $this->data_final,
            'saldo_distr'               => $this->saldo_distr,
            'status_campanha'           => $this->status_campanha,
        ]);
        return true;
    }

    public function atualizar_campanha($id_campanha){
        return (new Database('Campanha'))->update('id_campanha = ' .$this->id_campanha,[
            'nome_campanha'             => $this->nome_campanha,
            'qde_az_por_colaborador'    => $this->qde_az_por_colaborador,
            'data_inicio'               => $this->data_inicio,
            'data_final'                => $this->data_final,
            'saldo_distr'               => $this->saldo_distr,
            'status_campanha'           => $this->status_campanha,
        ]);
    }

    public function visualizar() {
        return (new Database('Campanha'))
        ->select()
        ->fetchAll(PDO::FETCH_ASSOC);
      }

      
      public static function visualizarCampanha($id_campanha){
        return (new Database('Campanha'))->select('id_campanha = ' .$id_campanha)->fetchObject(self::class);
    }

    /**
     * Método responsável por obter as campanhas do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getCampanhas($where = null, $order = null, $limit = null){
        return (new Database('campanha'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Método responsável por obter a quantidade de campanhas do banco de dados
     * @param string $where
     * @return integer
     */
    public static function getQuantidadeCampanhas($where = null){
        return (new Database('campanha'))->select($where,null,null,'COUNT(*) AS qtd')->fetchObject()->qtd;
    }

    /**
     * Método responsável por buscar a campanha ativa
     * @return Campanha
     */
    public static function getCampanhaAtiva(){
        return (new Database('campanha'))->select('status_campanha = true')->fetchObject(self::class);
    }
}