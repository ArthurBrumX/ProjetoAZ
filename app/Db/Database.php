<?php

    namespace App\Db;

    //Como iremos utilizar o PDO no sistema temos que definí-lo como uma dependência da classe 'Database'.
    //Para isso usaremos a linha de código abaixo:
    use PDO;

    //Apenas use durante o modo de desenvolvimento como mencionado no comentário na linha 86
    use PDOException;

    class Database{
        //Dentro da classe 'Database' serão definidos os valores das credenciais de acesso
        // ao bando de dados e por isso elas serão constantes ('const') e algumas
        // informações variáveis dentro da classe
        /**
         * Host de conexão com o banco de dados
         * @var string
         */
        const HOST = '10.28.0.10';

        // <<<<<<< HEAD

        // const HOST = 'localhost';

        /**
         * Nome do banco de dados
         * @var string
         */
        const NAME = 'AZMerit';
        // const NAME = 'test_az';

        /**
         * Usuário do banco de dados
         * @var string
         */
        const USER = 'postgres';
        
        /**
         * Senha de acesso ao banco de dados
         * @var string
         */
        const PASS = '1234';

        /**
         * Nome da table a ser manipulada
         * @var string
         */
        private $table;


        // A propriedade '$connection' será uma instância de PDO
        /**
         * Instância de conexão com o banco de dados
         * @var PDO
         */
        private $connection;

        /**
         * Define a tabela e instancia a conexão
         * @param string $table
         */
        public function __construct($table = null){
            $this->table = $table;
            //Como o código para a instância do PDO leva muitas linhas será criado o método abaixo:
            $this->setConnection();
        }
        
        /**
         * Método responsável por criar uma conexão com o banco de dados
         */
        private function setConnection(){
            //Ao utilizar o 'try/catch' a gente deixa o programa mais seguro para que
            // sejam tratados os possíveis erros que hajam no sistema.
            try{
                $this->connection = new PDO('pgsql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
                //Já que estamos trabalhando com as 'querys' dentro do banco de dados o PDO
                // não irá travar o nosso sistema caso haja algum erro na query. Ele apenas
                // irá informar com um 'WARNING'. Para isso precisamos tratar de uma outra forma
                // esse dado porque é interessante travar o sistema já que não queremos que ele
                // execute mais nada depois desse erro. E para gerar o 'FATAL ERRO' e travar o sistema
                // utilizamos a próxima lina de código que recebe 2 parâmetros.
                //O primeiro atributo é o que desejamos alterar e o segundo é o valor novo que
                // irá receber.
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            //Aconselhado usar a 'PDOException' do que a 'Exception' para gerenciar as exceções
            catch(PDOException $e){
                //Usar 'die('Error: '.$e->getMessage());' apenas durante o desenvolvimento do
                // aplicativo fechado para que a mensagem de erro não seja exposta pro usuário final.
                //O aconselhado é exibir uma mensagem mais amigável para o usuário final e gravar
                // a mensagem de erro real no seu registro de erros (error log) para que os dados
                // dos erros fiquem disponíveis apenas internamente.
                die('Error: '.$e->getMessage());
            }
        }

        /**
         * Método responsável por inserir dados no banco
         * @param array $values [field => value]
         * @return integer ID inserido
         */
        public function insert($values){
            //DADOS DA QUERY:
            $fields = array_keys($values);
            $binds = array_pad([],count($fields),'?');

            //O PDO ajuda a tratar o SQL injection para isso podemos passar os valores como parâmetros
            // dinâmicos e no momento da execução da query o PDO faz a validação para ver se os dados
            // passados são realmente seguros para serem inseridos no banco de dados.

            //MONTA A QUERY:
            $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

            //EXECUTA O INSERT
            $this->execute($query, array_values($values));
            
            //RETORNA O ID INSERIDO
            return $this->connection->lastInsertId();
        }

        //Como todas as querys que montarmos teremos que fazer o mesmo padrão de execução podemos
        // padronizar criando um método único para além de montar a query executá-la também.
        /**
         * Método responsável por executar queries dentro do banco de dados
         * @param string $query
         * @param array $params
         * @return \PDOStatement
         */
        public function execute($query,$params = []){
            try{
                $statement = $this->connection->prepare($query);
                $statement->execute($params);
                return $statement;
            }
            catch(PDOException $e){
                die('ERROR: '.$e->getMessage());
            }
        }
        


        /**
         * Método responsável por executar uma consulta no banco usando ORDER BY
         * @param string $where
         * @param string $order
         * @param string $limit
         * @param string $fields
         * @return \PDOStatement
         */
        public function select($where = null, $order = null, $limit = null, $fields = '*'){
            //DADOS DA QUERY
            //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
            $where = !empty($where) ? 'WHERE '.$where : '';
            $order = !empty($order) ? 'ORDER BY '.$order : '';
            $limit = !empty($limit) ? 'LIMIT '.$limit : '';

            //MONTA A QUERY
            $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        public function selectHistFeed($query){
            
            return $this->execute($query);
        }

            //LISTA TODOS OS FEEDBACKS ENVIADOS OU RECEBIDOS PELO USUARIO
        public function relatorio_campanhas($where = null, $order = null, $limit = null, $fields = '*'){
            //DADOS DA QUERY
            //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
            $where = !empty($where) ? 'WHERE '.$where : '';
            $order = !empty($order) ? 'ORDER BY '.$order : '';
            $limit = !empty($limit) ? 'LIMIT '.$limit : '';

            //MONTA A QUERY
            $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        // ---------------------------------------------------------------------------------------------------
        // Funcoe Tela Banco (Arthur)
        
        public function selectFeedbackDiario(){
            //DADOS DA QUERY
            //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
            //MONTA A QUERY
            $query = 'SELECT sum(qde_az_enviado) FROM public.feedback
                         WHERE data_validacao = CURRENT_DATE';

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        
        public function selectFeedbackTotal(){
            //DADOS DA QUERY
            //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
            $query = 'SELECT sum(qde_az_enviado) FROM public.feedback
                        INNER JOIN campanha
                        ON feedback.id_campanha = campanha.id_campanha AND campanha.status_campanha = True';

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        public function selectPorcentagemGastos(){
            //DADOS DA QUERY
            $query = 'SELECT saldo_distr, sum(feedback.qde_az_enviado), ((sum(feedback.qde_az_enviado)*100) / saldo_distr) as porcent
                        FROM campanha JOIN feedback
                        ON campanha.id_campanha = feedback.id_campanha
                        WHERE campanha.id_campanha = 1 AND feedback.id_status_feedback = 1
                        GROUP BY saldo_distr';

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        //funcao que faz a query para o banco de dados
        public function selectPorcentagemTrocados(){
            //DADOS DA QUERY
            $query = 'SELECT sum(qde_troca_produto) FROM public.troca_produto';

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        //funcao que faz a query para o banco de dados
        public function selectValorDaCamanhaAtiva(){
            //DADOS DA QUERY
            $query = 'SELECT sum(saldo_distr) FROM public.campanha where status_campanha = true';
            //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
            $query = 'SELECT sum(qde_az_enviado) FROM public.feedback
                        INNER JOIN campanha
                        ON feedback.id_campanha = campanha.id_campanha AND campanha.status_campanha = True';

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        // ---------------------------------------------------------------------------------------------------


        /**
         * Método responsável por executar uma consulta no banco usando GROUP BY
         * @param string $where
         * @param string $group
         * @param string $limit
         * @param string $fields
         * @return \PDOStatement
         */
        public function selectGroup($where = null, $group = null, $limit = null, $fields = '*'){
            //DADOS DA QUERY
            //É feita uma condição ternária (n=3) para dar valores caso existam algum valor na variável
            $where = !empty($where) ? 'WHERE '.$where : '';
            $group = !empty($group) ? 'GROUP BY '.$group : '';
            $limit = !empty($limit) ? 'LIMIT '.$limit : '';

            //MONTA A QUERY
            $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$group.' '.$limit;

            //EXECUTA A QUERY
            return $this->execute($query);
        }

        /**
         * Método responsável por executar atualizações no banco de dados
         * @param string $where
         * @param array $values [ field => value ]
         * @return boolean
         */
        public function update($where, $values){
            //DADOS DA QUERY
            $fields = array_keys($values);

            //MONTA A QUERY
            $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

            //EXECUTAR A QUERY
            $this->execute($query,array_values($values));

            return true;
        }

        /**
         * Método responsável por excluir dados do banco de dados
         * @param string $where
         * @return boolean
         */
        public function delete($where){
            //MONTA A QUERY
            $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

            //EXECUTA A QUERY
            $this->execute($query);

            //RETORNA SUCESSO
            return true;
        }


    /**
     * Método responsável por execuar uma consulta no banco de dados
    */
    public function selectDadosCards()
    {
        $query = "SELECT f.id_feedback, us1.apelido as remetente, us1.imagem as img_remetente, us2.apelido as destinatario, us2.imagem as img_destinatario, qde_az_enviado as doacao, mensagem, id_status_feedback
            FROM feedback f
            LEFT JOIN usuario us1 
                ON f.remetente_usuario = us1.id_usuario
            LEFT JOIN usuario us2
                ON f.destinatario_usuario = us2.id_usuario
        WHERE f.id_status_feedback = 3
        ORDER BY f.id_feedback";

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    public function getCardsFeedback()
    {

        $query = "SELECT usuario.nome as apelido,usuario.id_usuario,usuario.imagem,feedback.mensagem,feedback.qde_az_enviado
        from usuario
        join feedback on usuario.id_usuario = feedback.destinatario_usuario
        join campanha on feedback.id_campanha = campanha.id_campanha and campanha.status_campanha = true
        order by feedback.id_feedback desc
        limit 5";

        //EXECUTA A QUERY
        return $this->execute($query);
    }


    public function selectRelatorioGestor()
    {
        $query = "select usuario.nome, sum(carteira.saldo_recebido_feedback) as feedback_recebido,
        sum(feedback.qde_az_enviado) as feedback_doado
        from usuario
        inner join carteira on usuario.id_usuario = carteira.id_usuario 
        inner join feedback on (usuario.id_usuario = feedback.remetente_usuario or usuario.id_usuario = feedback.destinatario_usuario )and id_status_user = 1
        where usuario.id_usuario = 25
        group by usuario.nome";

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    //QUERY DO TESMAN

    public function selectMaisTrocados()
    {
        $query = "SELECT distinct(produto.id_produto), produto.nome,produto.imagem, produto.descricao,produto.valor_produto
        FROM produto 
        JOIN troca_produto 
        ON produto.id_produto = troca_produto.id_produto
        GROUP BY produto.id_produto
        ORDER BY produto.id_produto DESC
        LIMIT 6";
    
    return $this->execute($query);
    }




     /**
     * Método responsável por execuar uma consulta no banco de dados
    */
    // public function insertReprovados()
    // {
    //     $query = "INSERT INTO analise (qde_enviado, mensagem, id_feedback, id_carteira) VALUES
    //     ();"

    //     //EXECUTA A QUERY
    //     return $this->execute($query);
    // }
    public function selectSaldoUser($id)
    {
        $query = "select usuario.id_usuario,usuario.nome,carteira.saldo_recebido_feedback
        from usuario
        join carteira
        on usuario.id_usuario=carteira.id_usuario and usuario.id_usuario='$id'";
    
        return $this->execute($query);
    }
   
    public function  atualizaSaldo($id,$saldo)
    {
        $query = "update carteira set saldo_recebido_feedback = saldo_recebido_feedback - $saldo where id_carteira=$id";
    
    return $this->execute($query);
    }

    

    public function updateUnico($where, $fieldName, $value){
        // MONTA A QUERY
        $query = 'UPDATE '.$this->table.' SET '.$fieldName.'=? WHERE '.$where;
    
        // EXECUTAR A QUERY
        $this->execute($query, [$value]);
    
        return true;
    }

    public function QdePendete($id){
        $query = "SELECT sum(qde_az_enviado) FROM feedback WHERE remetente_usuario = $id and id_status_feedback = 3";
        return $this->execute($query);
    }
    

    /**
     * Método responsável por executar uma consulta no banco de dados
     * Gera uma lista de usuarios com os produtos já trocados para serem enviados
    */
    public function selectControleProdutosEnviar()
    {
        $query = "SELECT u.nome as colaborador,u.apelido, u.id_usuario, p.nome as produto, p.id_produto as id_prod, tp.qde_troca_produto as quantidade, tp.id_troca_produto, tp.data_troca_prod, tp.status, tp.data_envio
        FROM usuario u
        INNER JOIN carteira c 
            ON u.id_usuario = c.id_usuario
        INNER JOIN troca_produto tp
            ON tp.id_carteira = c.id_carteira
        INNER JOIN produto p
            ON p.id_produto = tp.id_produto 
        ORDER BY tp.data_troca_prod";

        //EXECUTA A QUERY
        return $this->execute($query);
    }



    public function getSaldosGerais(){
        $query = 'SELECT sum(valor_recebido_campanha) as distribuido,
        sum(saldo_recebido_feedback) as saldo_doado,
        ( sum(valor_recebido_campanha) - sum(saldo_recebido_feedback)) as aguardando
        FROM  carteira join usuario ON carteira.id_usuario = usuario.id_usuario
        AND usuario.id_status_user = 1
        ';

    return $this->execute($query);

    }

    public function getSaldosColaboradores() {
        $query ='SELECT usuario.id_usuario, nome, saldo_recebido_feedback as recebidos,saldo_doacao_usuario as saldo_disponivel,sum(feedback.qde_az_enviado) as enviados
        FROM usuario
        LEFT JOIN carteira on usuario.id_usuario = carteira.id_usuario
        LEFT JOIN feedback on carteira.id_usuario = feedback.remetente_usuario
        GROUP BY usuario.id_usuario,nome, saldo_recebido_feedback,saldo_doacao_usuario
        ORDER BY saldo_recebido_feedback ASC';
    
    return $this->execute($query);
    }

    public function getTotalFeedbacks()
    {
        $query = "SELECT COUNT(*) AS total_feedbacks
		FROM feedback
		WHERE id_status_feedback = 1";

        //EXECUTA A QUERY
        return $this->execute($query);
    }


    public function getLastFeedbackEnviado()
    {
        $query = "Select feedback.id_feedback, remetente_usuario, usuario.nome
		FROM feedback
		INNER Join usuario on usuario.id_usuario = feedback.remetente_usuario
		GROUP BY feedback.id_feedback,feedback.remetente_usuario, usuario.nome
		ORDER BY feedback.id_feedback DESC";

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    public function getLastFeedbackRecebido()
    {
        $query = "SELECT feedback.id_feedback, destinatario_usuario , usuario.nome
        FROM feedback
        INNER Join usuario on usuario.id_usuario = feedback.destinatario_usuario
        GROUP BY feedback.id_feedback,feedback.destinatario_usuario, usuario.nome
        ORDER BY id_feedback Desc";

        //EXECUTA A QUERY
        return $this->execute($query);
    }


    public function getProdutoMaisTrocado()
    {
        $query = "SELECT produto.nome, sum(troca_produto.qde_troca_produto) AS produto_mais_trocado
		FROM troca_produto
		INNER JOIN produto ON produto.id_produto = troca_produto.id_produto
		GROUP BY produto.nome
		ORDER BY produto_mais_trocado DESC
		limit 1";

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    public function getProdutoMenosTrocado()
    {
        $query = "SELECT produto.nome, sum(troca_produto.qde_troca_produto) AS produto_mais_trocado
		FROM troca_produto
		INNER JOIN produto ON produto.id_produto = troca_produto.id_produto
		GROUP BY produto.nome
		ORDER BY produto_mais_trocado ASC
		LIMIT 1";

        //EXECUTA A QUERY
        return $this->execute($query);
    }

      // Funcoe Tela Banco
      public function selectFeedbackEnviadoHoje(){
        $query = 'SELECT sum(qde_az_enviado) FROM feedback
                    INNER JOIN campanha
                    ON feedback.id_campanha = campanha.id_campanha AND campanha.status_campanha = True
                    WHERE data_validacao = CURRENT_DATE';
        return $this->execute($query);
    }

    public function selectDoadosHoje(){

        $query = 'SELECT sum(saldo_doacao_usuario) FROM carteira
                    INNER JOIN feedback
                    ON data_validacao = CURRENT_DATE';
        return $this->execute($query);
    }

    public function selectDistrDoadAguardDoacao(){
        $query = 'SELECT sum(valor_recebido_campanha) as distribuido,
                    sum(saldo_recebido_feedback) as saldo_doado,
                    ( sum(valor_recebido_campanha) - sum(saldo_recebido_feedback)) as aguardando
                    FROM  carteira join usuario ON carteira.id_usuario = usuario.id_usuario
                    AND usuario.id_status_user = 1';
        return $this->execute($query);
    }
    
    }
