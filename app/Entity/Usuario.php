<?php

namespace App\Entity;

//Como iremos utilizar a Database na linha 58 temos que definí-lo como uma dependência da classe 'Usuario'.
//Para isso usaremos a linha de código abaixo:
use \App\Db\Database;
use \PDO;

class Usuario{
    /**
     * ID unico do usuário
     * @var integer
     */
    public $id_usuario;

    /**
     * Define o nome completo do usuário
     * @var string
     */
    public $nome;

    /**
     * Define o e-mail do usuário
     * @var string
     */
    public $email;

    /**
     * Define a senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Define o apelido do usuário
     * @var string
     */
    public $apelido;

    /**
     * define o endereço da imagem  
    * @var string
    */
    public $imagem;

    /**
     * Define o perfil do usuário
     * @var integer (1/2/3)
     */
    public $id_perfil_usuario;

    /**
     * Define se o usário está ativo
     * Só podem os valores 0 e 1
     * @var integer (0/1)
     */
    public $id_status_user;

    public $recuperar_senha;

    /**
     * Método responsável por cadastrar um usuário novo no banco de dados
     * @return boolean
     */
    public function cadastrar(){
        $obDatabase = new Database('usuario');
        $this->id_usuario = $obDatabase->insert([
            'nome'                      => $this->nome,
            'email'                     => $this->email,
            'senha'                     => $this->senha,
            'apelido'                   => $this->apelido,
            'imagem'                    => $this ->imagem,
            'id_perfil_usuario'         => $this->id_perfil_usuario,
            'id_status_user'            =>1
        ]);

        //RETORNAR SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar um usuário no banco de dados
     * @return boolean
     */
    public function atualizar(){
        return (new Database('usuario'))->update('id_usuario = '.$this->id_usuario,[
            'nome'                      => $this->nome,
            'email'                     => $this->email,
            'senha'                     => $this->senha,
            'apelido'                   => $this->apelido,
            'imagem'                    => $this->imagem,
            'id_perfil_usuario'         => $this->id_perfil_usuario,
            'id_status_user'            => $this->id_status_user,
        ]);
    }

    /**
     * Método responsável por excluir um usuário do banco de dados
     * @return boolean
     */
    public function excluir(){
        return (new Database('usuario'))->delete('id_usuario = '.$this->id_usuario);
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

    public static function RelatorioGeralGestor(){
       return (new Database('usuario'))->selectRelatorioGestor()->fetchObject(self::class);
    }

    public static function getCardsFeedback(){
        return (new Database())->getCardsFeedback()->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /*SABER SALDO USUARIO PARA USAR*/
    public static function getSaldoUsuario($id) {
        return (new Database('usuario'))->selectSaldoUser($id)->fetchObject(self::class);
    }
    public static function getUsuarioRecuperarSenha($where = null, $order = null, $limit = null, $fil = '*'){
        return (new Database('usuario'))->select($where,$order,$limit,$fil)->fetchObject(self::class);
    }

    public function atualizarRecuperarSenha(){
        return (new Database('usuario'))->update('id_usuario = '.$this->id_usuario,[
            'recuperar_senha' => $this->recuperar_senha
        ]);
    }

    public function atualizarSenha(){
        return (new Database('usuario'))->update('id_usuario = '.$this->id_usuario,[
            'senha'           => $this->senha,
            'recuperar_senha' => $this->recuperar_senha
        ]);
    }


    public static function saldoColaborador(){
        return (new Database('usuario'))->getSaldosColaboradores()->fetchAll(PDO::FETCH_CLASS,self::class);   
    }

    
}