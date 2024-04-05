<?php
    namespace App\Session;

    class Login{

        /**
         * Método responsável por iniciar a sessão
         */
        private static function init(){
            //VERIFICA O STATUS DA SESSÃO
            if(session_status() !== PHP_SESSION_ACTIVE){
                //INICIA A SESSÃO
                session_start();
            }
        }

        /**
         * Método responsável por retornar os dados do usuário logado
         * @return array
         */
        public static function getUsuarioLogado(){
            //INICIA A SESSÃO
            self::init();

            //RETORNA DADOS DO USUARIO
            return self::isLogged() ? $_SESSION['usuario'] : null;
        }

        /**
         * Método responsável por logar o usuário
         * @param object $obUsuario
         */
        public static function login($obUsuario){
            //INICIA A SESSÃO
            self::init();

            //SESSÃO DE USUÁRIO
            //Com a variável '$_SESSION' temos acesso a toda a sessão. É uma variável global do tipo array.
            // É importante não salvar objetos dentro da sessão. Sempre guarde na sessão os dados mais essenciais.
            // Evite guardar informações que você possa conseguir de outras formas no projeto para não deixar os
            // processos mais lentos já que a sessão é um arquivo que está sendo salvo no disco do seu servidor.
            $_SESSION['usuario'] = [
                'id_usuario'        => $obUsuario->id_usuario,
                'nome'              => $obUsuario->nome,
                'email'             => $obUsuario->email,
                'apelido'           => $obUsuario->apelido,
                'imagem'            => $obUsuario->imagem,
                'id_perfil_usuario' => $obUsuario->id_perfil_usuario,
                'id_status_user'    => $obUsuario->id_status_user,
            ];

            if ($obUsuario->id_perfil_usuario == 1 || $obUsuario->id_perfil_usuario == 2){
                $pagina = 'gestor';
            }else if($obUsuario->id_perfil_usuario == 3){
                $pagina = 'user';
            }

            if ($obUsuario->id_status_user == 2){
                self::logout();
                exit;
            } else {
                //REDIRECIONA USUÁRIO PARA HOME USER OU HOME GESTOR
                header('location: .\pages\home_'.$pagina.'.php');
                exit;
            }
        }

        /**
         * Método responsável por deslogar o usuário
         */
        public static function logout(){
            //INICIA A SESSÃO
            self::init();

            //REMOVE A SESSÃO DE USUÁRIO
            unset($_SESSION['usuario']);

            //REDIRECIONA USUÁRIO PARA LOGIN
            header('location: index.php');
            exit;
        }

        /**
         * Método responsável por verificar se o usuário está logado
         * @return boolean
         */
        public static function isLogged(){
            //INICIA A SESSÃO
            self::init();

            //VALIDAÇÃO DA SESSÃO
            return isset($_SESSION['usuario']['id_usuario']);
        }

        /**
         * Método responsável por obrigar o usuário a estar logado para acessar
         */
        public static function requireLogin(){
            if(!self::isLogged()){
                header('location: ../index.php');
                exit;
            }
        }

        /**
         * Método responsável por obrigar o usuário a estar deslogado para acessar
         */
        public static function requireLogout(){
            if(self::isLogged()){
                header('location: index.php');
                exit;
            }
        }
    }