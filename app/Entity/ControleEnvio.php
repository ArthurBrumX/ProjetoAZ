<?php

namespace App\Entity;

    //Como iremos utilizar a Database na linha 58 temos que definí-lo como uma dependência da classe 'Usuario'.
    //Para isso usaremos a linha de código abaixo:
use \App\Db\Database;
use DateTime;
use \PDO;

class ControleEnvio{

    /**
     * Método responsável por montar a lista de controle de envio de produtos trocados na loja
     * função de consulta(select)
     * sem parametros
    */
    public static function ListarProdutosParaEnvio(){
        return (new Database())->selectControleProdutosEnviar()->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Método responsável por alterar o status(pendente ou enviado) dos produtos trocados na loja e que seguirão para envio
     * Função de atualização(update)
     * $id_troca_produto integer
    */
    public function atualizarStatusEnvioProduto($id_troca_produto){
        $dia = date('Y-m-d');
        (new Database('troca_produto'))->update('id_troca_produto ='.$id_troca_produto, ['status'=>'enviado', 'data_envio'=>"$dia"]);
        return true;       
    }
    
}