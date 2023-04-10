<?php


class crudsql{

	private $id;
	private $nome;
	private $telefone;


	public function setId($id){
		$this->id = $id;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}


	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}


	public function insere(){
	    try{
	    	require_once "conn.class.php";
	    	require_once "mensagens.class.php";

	    	$conecta = new conn();
	    	$conecta->conectaBancoSqlServer();

	        $ultId = $conecta->ultimoIdSqlServer("tabela_nome", "id");

	        $this->setId($ultId);

	        $sql = "INSERT INTO tabela_nome (id, nome, telefone) VALUES (".$this->id.", '".$this->nome."', '".$this->telefone."')";

	        $res = mssql_query($sql) or die (mensagens::ERROR_SQL_INSERT);
	        if($res){
	        	echo "Cadastrado com sucesso!";
	        }

	    }catch(Exception $ex){
	        echo $ex->getMessage();
	    }

	}

	public function altera(){
	    try{
	    	require_once "conn.class.php";
	    	require_once "mensagens.class.php";

	    	$conecta = new conn();
	    	$conecta->conectaBancoSqlServer();

	        $sql = "UPDATE tabela_nome SET nome = '".$this->nome."', telefone = '".$this->telefone."'' WHERE id = ".$this->id;

	        $res = mssql_query($sql) or die (mensagens::ERROR_SQL_UPDATE);
	        if($res){
	            echo "Atualizado com sucesso!";
	        }

	    }catch(Exception $ex){
	        echo $ex->getMessage();
	    }
	}

	public function exclui(){
	    try{
	    	require_once "conn.class.php";
	    	require_once "mensagens.class.php";

	    	$conecta = new conn();
	    	$conecta->conectaBancoSqlServer();

	        $sql = "DELETE FROM tabela_nome WHERE id =".$this->id;

	        $res = mssql_query($sql) or die (mensagens::ERROR_SQL_DELETE);
	        if($res){
	            echo "Excluído com sucesso!";
	        }

	    }catch(Exception $ex){
	        echo $ex->getMessage();
	    }

	}

	public function lista(){
	    try{

	    	require_once "conn.class.php";
	    	require_once "mensagens.class.php";

	    	$conecta = new conn();
	    	$conecta->conectaBancoSqlServer();

	        $sql = "SELECT id, nome, telefone FROM tabela_nome";

	        $res = mssql_query($sql) or die(mensagens::ERROR_SQL_LISTA);

	        if(mssql_num_rows($res) > 0){ 
	            While($dados = mssql_fetch_array($res)){

	                echo "<tr>";
	                echo "  <td>";
	                echo        $dados['id'];
	                echo "  </td>";
	                echo "  <td>";
	                echo        $dados['nome'];
	                echo "  </td>";
	                echo "  <td>";
	                echo        $dados['telefone'];
	                echo "  </td>";
	                echo "  <td>";
	                echo "      <div class='btn-group' role='group' aria-label='Default button group'>";
	                echo "          <button type='button' class='btn btn-outline-primary' onclick='index.php?id=".$dados['id']."&op=alt'>Alterar</button>";
	                echo "          <button type='button' class='btn btn-outline-primary' onclick='index.php?id=".$dados['id']."&op=exc'>Excluir</button>";
	                echo "      </div>";
	                echo "  </td>";
	                echo "</tr>";

	            }
	        }else{
	            echo "Sem dados na tabela";
	        }
	    } catch (Exception $ex) {
	        echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
	    }

	}


}
