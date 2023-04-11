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
	        	echo "<h5 style='font-color:green;'>Cadastrado com sucesso!</h5><br>";
	            echo "<meta http-equiv='refresh' content='2;url=index.php'>";
	        }

	    }catch(Exception $ex){
	        echo $ex->getMessage();
	    }

	}

	public function altera(){
	    try{
	    	require_once "conn.class.php";

	    	$conecta = new conn();

	        $sql = "UPDATE tabela_nome SET nome = '".$this->nome."', telefone = '".$this->telefone."' WHERE id = ".$this->id;


	        $res = mysqli_query($conecta->conectaBanco(), $sql) or die ("Erro ao alterar os dados. Error: ".mysqli_error());
	        if($res){
	            echo "<h5 style='font-color:green;'>Atualizado com sucesso!</h5><br>";
	            echo "<meta http-equiv='refresh' content='2;url=index.php'>";
	        }

	    }catch(Exception $ex){
	        echo $ex->getMessage();
	    }
	}

	public function exclui(){
	    try{
	    	require_once "conn.class.php";

	    	$conecta = new conn();

	        $sql = "DELETE FROM tabela_nome WHERE id =".$this->id;

	        $res = mysqli_query($conecta->conectaBanco(), $sql) or die ("Erro ao alterar os dados. Error: ".mysqli_error());
	        if($res){
	            echo "<h5 style='font-color:green;'>Excluído com sucesso!</h5><br>";
	            echo "<meta http-equiv='refresh' content='2;url=index.php'>";
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
	                echo "          <a class='btn btn-outline-primary' href='index.php?op=2&id=".$dados['id']."'>Alterar</button>";
	                echo "          <a class='btn btn-outline-primary' href='index.php?op=3&id=".$dados['id']."'>Excluir</a>";
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

	public function listaComId(){
	    try{

	    	require_once "conn.class.php";

	    	$conecta = new conn();
	    	$conecta->conectaBanco();

	        $sql = "SELECT id, nome, telefone FROM tabela_nome where id = ".$this->id;

	        $res = mysqli_query($conecta->conectaBanco(), $sql);// or die("Erro ao executar o comando SQL ao listar dados. SQL: ".$sql);

	        if(mysqli_num_rows($res) > 0){ 
	            $dados = mysqli_fetch_assoc($res);

	        echo "<form form action='index.php?op=2&id=".$dados['id']."' method='POST' name='form_crud'>";

            echo "<div class='mb-3' style='padding-bottom: 30px'>";
            echo "  <input type='hidden' class='form-control' name='id' value='".$dados['id']."'>";
            echo "</div>";
            echo "<div class='mb-3' style='padding-bottom: 30px'>";
            echo "  <label class='form-label'>Nome</label>";
            echo "  <input type='text' class='form-control' placeholder='Nome' aria-label='Nome' value='".$dados['nome']."' name='nome' required>";
            echo "</div>";
            echo "<div class='mb-3' style='padding-bottom: 30px'>";
            echo "  <label class='form-label'>Telefone</label>";
            echo "  <input type='tel' class='form-control' placeholder='(xx) xxxx-xxxx' aria-label='Telefone' name='telefone' value='".$dados['telefone']."' required>";
            echo "</div>";
            echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>";
            echo "  <button class='btn btn-primary me-md-2' type='submit'>Salvar</button>";
            echo "  <button class='btn btn-outline-primary' type='button'>Cancelar</button>";
            echo "</div>";

//            echo "</form>";

			 
	        }else{
	            echo "Sem dados na tabela";
	        }
	    } catch (Exception $ex) {
	        echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
	    }

	}


	public function modalAltera(){

//	echo "<!-- Button trigger modal -->";
//	echo "	<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalAltera'>";
//  	echo "		Launch demo modal";
//	echo "	</button>";
	echo "<!-- Modal -->";
	echo "<div class='modal fade' id='modalAltera' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
  	echo "	<div class='modal-dialog'>";
    echo "		<div class='modal-content'>";
    echo "			<div class='modal-header'>";
    echo "				<h1 class='modal-title fs-5' id='exampleModalLabel'>Modal title</h1>";
    echo "				<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
    echo "			</div>";
    echo "			<div class='modal-body'>";
    echo "				...";
    echo "			</div>";
    echo "			<div class='modal-footer'>";
    echo "				<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>";
    echo "				<button type='button' class='btn btn-primary'>Salvar</button>";
    echo "			</div>";
    echo "		</div>";
  	echo "	</div>";
	echo "</div>";

	}

	public function modalExclui(){

	}


}
