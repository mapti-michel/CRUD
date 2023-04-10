<?php

class crud{

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

	    	$conecta = new conn();
	    	$conecta->conectaBanco();

	        $ultId = $conecta->ultimoId("tabela_nome", "id");

	        $this->setId($ultId);

	        $sql = "INSERT INTO tabela_nome (id, nome, telefone) VALUES (".$this->id.", '".$this->nome."', '".$this->telefone."')";

	        $res = mysqli_query($conecta->conectaBanco(), $sql) or die ("Erro ao inserir os dados. Error: ".mysqli_error());
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
	    	$conecta->conectaBanco();

	        $sql = "UPDATE tabela_nome SET nome = '".$this->nome."', telefone = '".$this->telefone."'' WHERE id = ".$this->id;

	        $res = mysql_query($sql) or die (mensagens::ERROR_SQL_UPDATE." Error: ".mysql_error());
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
	    	$conecta->conectaBanco();

	        $sql = "DELETE FROM tabela_nome WHERE id =".$this->id;

	        $res = mysql_query($sql) or die (mensagens::ERROR_SQL_DELETE." Error: ".mysql_error());
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

	    	$conecta = new conn();
	    	$conecta->conectaBanco();

	        $sql = "SELECT id, nome, telefone FROM tabela_nome";

	        $res = mysqli_query($conecta->conectaBanco(), $sql);// or die("Erro ao executar o comando SQL ao listar dados. SQL: ".$sql);

	        if(mysqli_num_rows($res) > 0){ 
	            While($dados = mysqli_fetch_assoc($res)){

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
	                echo "          <a class='btn btn-outline-primary' href='index.php?op=1'>Novo</a>";
	                echo "      <div class='btn-group' role='group' aria-label='Default button group'>";
	                echo "          <a class='btn btn-outline-primary' href='index.php?op=2&id=".$dados['id']."'>Alterar</a>";
	                echo "          <a type='button' class='btn btn-outline-primary' onclick='index.php?op=3&id=".$dados['id']."'>Excluir</a>";
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
