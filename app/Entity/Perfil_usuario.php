<?php

namespace App\Entity;

//Como iremos utilizar a Database na linha 58 temos que definí-lo como uma dependência da classe 'Usuario'.
//Para isso usaremos a linha de código abaixo:
use \App\Db\Database;
use \PDO;

class Perfil_usuario{
    
    /**
     * Define o id do perfil do usuário
     * @var integer 
     */
    public $id_perfil_usuario;

    /**
     * Define o nome do perfil do usuário
     * @var string
     */
    public $descricao_perfil;

    /**
     * Define o perfil do usuário
     * @var bool
     */
    public $permissao;

    /**
     * Método responsável por cadastrar um perfil novo no banco de dados
     * @var boolean
     */
    public function cadastrar(){
        //INSERIR O USUÁRIO NO BANCO
        $obDatabase = new Database('perfil_usuario');
        $this->id_perfil_usuario = $obDatabase->insert([
            'id_perfil_usuario' => $this->id_perfil_usuario,
            'descricao_perfil' => $this->descricao_perfil,
            'permissao' => $this->permissao,
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar um usuário no banco de dados
     * @return boolean
     */
    public function atualizar(){
        return (new Database('usuario'))->update('id_usuario = '.$this->id_usuario,
        [
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
            'apelido' => $this->apelido,
            'id_perfil_usuario' => $this->id_perfil_usuario,
        ]);
    }

    /**
     * Método responsável por excluir um usuário do banco de dados
     * @return boolean
     */
    public function excluir(){
        return (new Database('usuario'))->delete('id_usuario = '.$this->id_perfil_usuario);
    }

    /**
     * Método responsável por obter os usuários do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getUsuarios($where = null, $order = null, $limit = null){
        return (new Database('usuario'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Método responsável por obter a quantidade de usuários do banco de dados
     * @param string $where
     * @return integer
     */
    public static function getQuantidadeUsuarios($where = null){
        return (new Database('usuario'))->select($where,null,null,'COUNT(*) AS qtd')->fetchObject()->qtd;
    }

    /**
     * Método responsável por buscar um usuário com base em seu ID
     * @param integer $id_usuario
     * @return Usuario
     */
    public static function getUsuario($id_usuario){
        return (new Database('usuario'))->select('id_usuario = '.$id_usuario)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar uma instância de usuário com base em seu e-mail
     * @param string $email
     * @return Usuario
     */
    public static function getUsuarioPorEmail($email) {
        return (new Database('usuario'))->select("email = '".$email."'")->fetchObject(self::class);
    }
}