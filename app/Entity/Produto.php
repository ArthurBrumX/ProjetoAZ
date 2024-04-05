<?php

namespace App\Entity;

//Como iremos utilizar a Database na linha 58 temos que definí-lo como uma dependência da classe 'Usuario'.
//Para isso usaremos a linha de código abaixo:
use \App\Db\Database;
use \PDO;

class Produto{
    /**
     * ID unico do produto
     * @var integer
     */
    public $id_produto;

    /**
     * Define o nome do produto
     * @var string
     */
    public $nome;

    /**
     * Define o endereço da imagem do produto
     * @var string
     */
    public $imagem;

    /**
     * Descreve o produto
     * @var string
     */
    public $descricao;

    /**
     * Define a quantidade disponível deste produto
     * @var string
     */
    public $qde_produto;

    /**
     * Define o valor do produto
     * @var string
     */
    public $valor_produto;

    /**
     * Define se o produto está ativo ou inativo
     * @var integer
     */
    public $id_status_produto;

    /**
     * Método responsável por cadastrar um produto novo no banco de dados
     * @var boolean
     */
    public function cadastrar(){
        //INSERIR  NO BANCO
        $db = new Database('produto');
        $db->insert(
                                    [
                                        'nome' => $this->nome,
                                        'descricao' => $this->descricao,
                                        'qde_produto' => $this->qde_produto,
                                        'valor_produto'=> $this->valor_produto,  
                                        'imagem'=>$this->imagem,
                                        'id_status_produto'=>1,
                                        ]
                                    );

        //retornar sucesso
        return true;

    }

    public function trocar_produto(){
        //INSERIR  NO BANCO
        $db = new Database('troca_produto');
        $db->insert(
                                        [
                                        'id_produto' => $this->id_produto,
                                        'qde_troca_produto' => $this->qde_produto,
                                        'id_carteira' => $this->id_status_produto
                                        ]
                                    );

        //retornar sucesso
        return true;

    }
   
    /**
     * Método responsável por obter os produtos do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getProdutos($where = null, $order = null, $limit = null){
        return (new Database('produto'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Método responsável por obter a quantidade de produtos do banco de dados
     * @param string $where
     * @return integer
     */
    public static function getQuantidadeProdutos($where = null){
        return (new Database('produto'))->select($where,null,null,'COUNT(*) AS qtd')->fetchObject()->qtd;
    }

    public function mudarStatusProduto($id,$valor){
        (new Database('produto'))->updateUnico('id_produto = '.$id, 'id_status_produto', $valor);
        return TRUE;
    }

    /**
     * Método responsável por buscar um usuário com base em seu ID
     * @param integer $id_usuario
     * @return Usuario
     */
    public static function getProduto($id_produto){
        return (new Database('produto'))->select('id_produto = '.$id_produto)->fetchObject(self::class);
    }
    /**
     * Método responsável por atualizar um usuário no banco de dados
     * @return boolean
     */
    public function atualizar(){
        return (new Database('produto'))->update('id_produto = '.$this->id_produto,[
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'qde_produto' => $this->qde_produto,
            'valor_produto' => $this->valor_produto,
            'imagem' => $this->imagem,
            'id_status_produto' =>$this->id_status_produto,
        ]);
    }
    /**
 * CARROSEL DOS 4 MAIS TROCADOS
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */

    public static function getProdCardsLojaUser(){
        return (new Database('produto'))->selectMaisTrocados()->fetchAll(PDO::FETCH_CLASS,self::class);
    }
    public static function getProdutoMaisTrocado(){
        return (new Database())->getProdutoMaisTrocado()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    
    public static function getProdutoMenosTrocado(){
        return (new Database())->getProdutoMenosTrocado()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    public function excluirprod(){
        return(new Database('produto'))->delete('id_produto ='.$this->id_produto);
    }

}
