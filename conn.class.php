<?php

class conn{
    private $usuario;
    private $senha;
    private $server;
    private $database;
    private $porta;
    private static $conecta;


    public function setUsuario($user){
        $this->usuario = $user;
    }

    public function setSenha($senha){
        $this->senha = $senha;
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

    public function conectaBanco(){
        $ini = parse_ini_file("config.ini", TRUE);

        $this->setUsuario($ini['local']['user']);
        $this->setSenha($ini['local']['pass']);
        $this->setServer($ini['local']['server']);
        $this->setDatabase($ini['local']['database']);
        $this->setPorta($ini['local']['database']);


        $tns = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$this->server.")(PORT = ".$this->porta.")) (CONNECT_DATA = (SID = ".$this->database.")))";

        try{
            $conecta = oci_connect($this->usuario, $this->senha, $tns);
            mb_internal_encoding("UTF-8");

            if(!$conecta){
                $erro = oci_error();
                trigger_error(htmlentities($erro['message'], ENT_QUOTES), E_USER_ERROR);
                exit();
            }
    

        }catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

    function ultimoId($tabela, $id){
        $this->conectaBanco();
        
        try{
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

}