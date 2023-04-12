<?php

class conn{
    private $usuario;
    private $senha;
    private $host;
    private $server;
    private $database;
    private $porta;
    private $tns;
    private static $conecta;


    public function setUsuario($user){
        $this->usuario = $user;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function setHost($host){
        $this->host = $host;
    }

    public function setServer($server){
        $this->server = $server;
    }

    public function setDatabase($database){
        $this->database = $database;
    }

    public function setPorta($porta){
        $this->porta = $porta;
    }

    public function setTns($tns){
        $this->tns = $tns;
    }

    public function conectaBancoOracle(){
        $ini = parse_ini_file("config.ini", TRUE);

        $this->setUsuario($ini['localoracle']['user']);
        $this->setSenha($ini['localoracle']['pass']);
        $this->setHost($ini['localoracle']['host']);
        $this->setServer($ini['localoracle']['server']);
        $this->setDatabase($ini['localoracle']['database']);
        $this->setPorta($ini['localoracle']['database']);

        $this->setTns("(DESCRIPTION=(ADDRESS_LIST = (ADDRESS =  (PROTOCOL = TCP)(HOST = ".$this->host.")(PORT = ".$this->porta.")))(CONNECT_DATA=(SERVER = ".$this->server.")))");



        try{

            //Oracle
            $conn = new PDO("oci:ORCL=".$this->tns,$this->usuario,$this->senha);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
     

            if(!$conn){
                $erro = oci_error();
                trigger_error(htmlentities($erro['message'], ENT_QUOTES), E_USER_ERROR);
                exit();
            }

            return $conn;
    

        }catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

    public function conectaBanco(){
        $ini = parse_ini_file("config.ini", TRUE);

        $this->setUsuario($ini['localmysql']['user']);
        $this->setSenha($ini['localmysql']['pass']);
        $this->setHost($ini['localmysql']['host']);
        $this->setDatabase($ini['localmysql']['database']);

        try{

            //MySQL
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $conecta = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database) or die("Há um problema de conexão. Erro: ".mysqli_error());

            return $conecta;
    

        }catch(Exception $ex){
            echo "Problemas na conexão. Mensagem de erro: ".$ex->getMessage();
        }

    }

    public function conectaBancoSqlServer(){
        $ini = parse_ini_file("config.ini", TRUE);

        $this->setUsuario($ini['localsql']['user']);
        $this->setSenha($ini['localsql']['pass']);
        $this->setHost($ini['localsql']['host']);
        $this->setDatabase($ini['localsql']['database']);
        $this->setPorta($ini['localsql']['porta']);

        try{

            //SQL Server
            $conecta = $pdo = new PDO ("mssql:host=$this->host;dbname=$this->database","$this->usuario","$this->senha");

            //mssql_connect($this->host, $this->usuario, $this->senha) or die("Há um problema de conexão com o servidor");

            //mssql_select_db($this->database) or die("Erro ao selecionar a base de dados");

            return $conecta;
    

        }catch(Exception $ex){
            echo "Problemas na conexão. Mensagem de erro: ".$ex->getMessage();
        }

    }


    function ultimoIdSqlServer($tabela, $id){
        
        try{
            $this->conectaBanco();
            $sql = "SELECT MAX(".$id.") AS ID FROM ".$tabela." LIMIT 1";
            $resultado = mssql_query($sql) or die ("Erro no comando do ");
            if(mssql_num_rows($resultado) > 0){
                $dados = mssql_fetch_array($resultado);
                return $dados["ID"] + 1;
            }else{
                return 0;
            }
        } catch (Exception $ex) {
            echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
        }
    }

    function ultimoIdOracle($tabela, $id){
        
        try{
            $this->conectaBanco();
            $sql = "SELECT MAX(".$id.") AS ID FROM ".$tabela." LIMIT 1";
            $resultado = oci_parse(conn::$conecta, $sql);
            if(oci_num_rows($resultado) > 0){
                $dados = oci_fetch_array($resultado, OCI_ASSOC+OCI_RETURN_NULLS);
                return $dados["ID"] + 1;
            }else{
                return 0;
            }
        } catch (Exception $ex) {
            echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
        }
    }


    function ultimoId($tabela, $id){
        
        try{
            $this->conectaBanco();
            $sql = "SELECT MAX(".$id.") AS ID FROM ".$tabela." LIMIT 1";
            $resultado = mysqli_query($this->conectaBanco(), $sql) or die("Problemas na execução de id da tabela. Erro: ".mysqli_error());
            if(mysqli_num_rows($resultado) > 0){
                $dados = mysqli_fetch_array($resultado);
                return $dados["ID"] + 1;
            }else{
                return 0;
            }
        } catch (Exception $ex) {
            echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
        }
    }    

}