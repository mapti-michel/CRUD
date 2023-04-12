<?php

require_once 'conn.class.php';

require_once 'crud.class.php';
require_once 'crudsql.class.php';
require_once 'crudoracle.class.php';



ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__).'/error_log.txt');

$conexao = new conn();

$operacao   = addslashes(filter_input(INPUT_GET, 'op'));
$idSelec    = addslashes(filter_input(INPUT_GET, 'id'));
$message    = addslashes(filter_input(INPUT_GET, 'm'));


if($_POST){

    $nome       = addslashes(filter_input(INPUT_POST, 'nome'));
    $telefone   = addslashes(filter_input(INPUT_POST, 'telefone'));


    //MySql
    switch($operacao){
        case 1:
            // Cadastro
            try{
                $dbmysql    = new crud();

                $dbmysql->setNome($nome);
                $dbmysql->setTelefone($telefone);
                $dbmysql->insere();

            }catch(Exception $ex){
                echo $ex->getMessage();
            }

            break;
        case 2:
            // Alteração
            try{
                $dbmysql    = new crud();

                $dbmysql->setId($idSelec);
                $dbmysql->setNome($nome);
                $dbmysql->setTelefone($telefone);
                $dbmysql->altera();

            }catch(Exception $ex){
                echo $ex->getMessage();
            }

            break;
        case 3:
            // Exclusão
                try{
                    $dbmysql    = new crud();
                    $dbmysql->setId($idSelec);
                    $dbmysql->exclui();

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


        <script src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>        

    </head>
    <body>

            <table class="table">
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

                    try{

                        $dbmysql    = new crud();
                        echo "<h2 class='alert alert-primary'>CRUD</h2>";
                        echo "<div class='d-grid gap-2 col-6 mx-auto' style='padding-bottom: 20px;'>";
                        echo "  <a class='btn btn-primary' href='index.php?op=1'>Novo +</a>";
                        echo "</div>";
                        echo "<hr style='padding-bottom: 20px;'>";
                        $dbmysql->lista();


                    } catch (Exception $ex) {
                        echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
                    }

                ?>
                </tbody>
            </table>

<?php
    
    switch ($operacao) {
        case 1:
            echo "<form action='index.php?op=1' method='POST' name='form_crud'>";
            echo "<div class='mb-3' style='padding-bottom: 30px'>";
            echo "  <input type='hidden' class='form-control' name='id'>";
            echo "</div>";
            echo "<div class='mb-3' style='padding-bottom: 30px'>";
            echo "  <label class='form-label'>Nome</label>";
            echo "  <input type='text' class='form-control' placeholder='Nome' aria-label='Nome' name='nome' required>";
            echo "</div>";
            echo "<div class='mb-3' style='padding-bottom: 30px'>";
            echo "  <label class='form-label'>Telefone</label>";
            echo "  <input type='tel' class='form-control' placeholder='(xx) xxxx-xxxx' aria-label='Telefone' name='telefone' required>";
            echo "</div>";
            echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>";
            echo "  <button class='btn btn-primary me-md-2' type='submit'>Salvar</button>";
            echo "  <a class='btn btn-outline-primary' href='index.php'>Cancelar</a>";
            echo "</div>";
            break;

        case 2:
            $dbmysql = new crud();
            $dbmysql->setId($idSelec);
            $dbmysql->listaComId();

            break;

        case 3:
            $dbmysql    = new crud();
            $dbmysql->setId($idSelec);
            $dbmysql->exclui();


            break;            
        
        default:
            echo "";
            break;
    }


    
?>

        </form>

<?php
    switch ($message) {
        case 1:
            echo "<h6 class='alert alert-info'>Criado com sucesso !</h6>";
            echo "<meta http-equiv='refresh' content='5;url=index.php'>";
            break;
        case 2:
            echo "<h6 class='alert alert-warning'>Alterado com sucesso !</h6>";
            echo "<meta http-equiv='refresh' content='5;url=index.php'>";
            break;
        case 3:
            echo "<h6 class='alert alert-danger'>Excluído com sucesso !</h6>";
            echo "<meta http-equiv='refresh' content='5;url=index.php'>";
            break;
        
        default:
            echo "";
            break;
    }

?>



    </body>
</html>