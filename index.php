<?php

require 'conn.class.php';

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__).'/error_log.txt');

$conecta = new conn();


if($_POST){


    $operacao   = addslashes(filter_input(INPUT_GET, 'oper'));
    $nome       = addslashes(filter_input(INPUT_POST, 'nome'));
    $telefone   = addslashes(filter_input(INPUT_POST, 'telefone'));

    switch($operacao){
        case "cad":
            // Cadastro
            try{
                $ultId = oci_parse($conecta->conectaBanco(), $conecta->ultimoId("tabela_nome", "id"));
                $sql = "INSERT INTO tabela_nome (id, nome, telefone) VALUES (".$ultId.", ".$nome.", ".$telefone.")";
    
                $res = oci_parse($conecta->conectaBanco(), $sql);
                if(!$res){
                    echo "Cadastrado com sucesso!";
                }
    
            }catch(Exception $ex){
                echo $ex->getMessage();
            }

            break;
        case "alt":
            // Alteração
            $id     = addslashes(filter_input(INPUT_GET, 'id'));
            try{
                $sql = "UPDATE tabela1 SET nome = ".$nome.", telefone = ".$telefone." WHERE id = ".$id;
    
                $res = oci_parse($conecta->conectaBanco(), $sql);
                if(!$res){
                    echo "Atualizado com sucesso!";
                }
    
            }catch(Exception $ex){
                echo $ex->getMessage();
            }

            break;
        case "exc":
            // Exclusão
            $id     = addslashes(filter_input(INPUT_GET, 'id'));
                try{
                    $sql = "DELETE FROM tabela1 WHERE id =".$id;
        
                    $res = oci_parse($conecta->conectaBanco(), $sql);
                    if(!$res){
                        echo "Excluído com sucesso!";
                    }
        
                }catch(Exception $ex){
                    echo $ex->getMessage();
                }
            break;
        default:
            echo "";
            break;
    
        }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            TESTE CRUD          
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous"/>
    </head>
    <body>
        <form action="index.php" method="POST" name="form_crud">

            <table clas="table">
            </thead>
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Nome
                    </th>
                    <th>
                        Telefone
                    </th>
                    <th>
                        Operação
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT id, nome, telefone FROM tabela_nome";

                    try{
                        $tns = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)) (CONNECT_DATA = (SID = xe)))";

                        $database = "dboracle";
                        $usuario = "system";
                        $pass = "m0d#lM";

                        $conn = oci_connect($usuario, $pass, "//localhost/XE");
//                        $conn = new PDO("oci:dbname=dboracle;charset=utf8", $usuario, $senha);

                        if(!$conn){
                            echo "Erro de conexão";
                        }

                        $res = oci_parse($conn, $sql);

                        //oci_execute($res, OCI_DEFAULT);

                        if(oci_num_rows($res) > 0){
                            While($dados = oci_fetch_array($res, OCI_ASSOC+OCI_RETURN_NULLS)){

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
                                echo "          <button type='button' class='btn btn-outline-primary' onclick='index,php?id=".$dados['id']."&op=alt'>Alterar</button>";
                                echo "          <button type='button' class='btn btn-outline-primary' onclick='index,php?id=".$dados['id']."&op=exc'>Excluir</button>";
                                echo "      </div>";
                                echo "  </td>";
                                echo "</tr>";

                            }
                        }else{
                            return 0;
                        }
                    } catch (Exception $ex) {
                        echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
                    }

                ?>
                </tbody>
            </table>

            <div class="mb-3" style="padding-bottom: 30px">
                <input type="hidden" class="form-control" value="<?php echo $id ?>" name="id">
            </div>
            <div class="mb-3" style="padding-bottom: 30px">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control" placeholder="Nome" aria-label="Nome" value="<?php echo $n ?>" name="nome" required>
            </div>
            <div class="mb-3" style="padding-bottom: 30px">
                <label class="form-label">Telefone</label>
                <input type="tel" class="form-control" placeholder="(xx) xxxx-xxxx" aria-label="Telefone"  value="<?php echo $t ?>" name="telefone" required>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary me-md-2" type="button">Salvar</button>
                <button class="btn btn-outline-primary" type="button">Cancelar</button>
            </div>            
        </form>


    </body>
</html>