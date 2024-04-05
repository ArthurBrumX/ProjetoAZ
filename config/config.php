<?php
$dbHost = 'localhost';
$dbName = 'AZMerit';
$dbUser = 'postgres';
$dbPass = '1234';

//Tratamento de exceção do JV//
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try{
    $conexao = new PDO("pgsql:host=$dbHost;dbname=" . $dbName, $dbUser, $dbPass, $options);
    //echo "conexao relizada com sucesso";
}catch(PDOException $err){
    //echo "banco não conectado" . " " .$err->getMessage();
//Código de erro do JV//
    die($err->getMessage());
}
?>

<?php //CONFIG DO GABRIEL

$dbName = 'AZMerit';
$dbHost = 'localhost';
$dbUser = 'postgres';
$dbPass = '1234';

class banco{
    private $pdo;
    public $msgErro="";

    public function conectar($dbHost,$dbName,$dbUser,$dbPass)
    {
        global $pdo;
        try{
            $pdo = new PDO("pgsql:host=$dbHost;dbname=".$dbName, $dbUser, $dbPass);
            echo "conexao relizada com sucesso";
        }catch(PDOException $e){
            echo "banco não conectado" . " " .$msgErro = $e->getMessage();
        }
    }
}
?>