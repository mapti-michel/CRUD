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


if($_POST){


    $id         = addslashes(filter_input(INPUT_POST, 'id'));
    $nome       = addslashes(filter_input(INPUT_POST, 'nome'));
    $telefone   = addslashes(filter_input(INPUT_POST, 'telefone'));

    // Cadastro
    try{
        $dbmysql    = new crud();
/*                $dbmssql    = new crudsql();
        $dbora      = new crudoracle();*/


        //MySql
        $dbmysql->setNome($nome);
        $dbmysql->setTelefone($telefone);
        $dbmysql->insere();
/*
        //SqlServer
        $dbmssql->setNome($nome);
        $dbmssql->setTelefone($telefone);
        $dbmssql->insere();

        //Oracle
        $dbora->setNome($nome);
        $dbora->setTelefone($telefone);
        $dbora->insere();

*/    
    }catch(Exception $ex){
        echo $ex->getMessage();
    }




    switch($operacao){
        case 2:
            // Alteração
            $id     = addslashes(filter_input(INPUT_GET, 'id'));
            try{
                $dbmysql    = new crud();
/*                $dbmssql    = new crudsql();
                $dbora      = new crudoracle();*/

                //MySql
                $dbmysql->setId($id);
                $dbmysql->setNome($nome);
                $dbmysql->setTelefone($telefone);
                $dbmysql->altera();

/*
                //SqlServer
                $dbmssql->setId($id);
                $dbmssql->setNome($nome);
                $dbmssql->setTelefone($telefone);
                $dbmssql->altera();

                //Oracle
                $dbora->setId($id);
                $dbora->setNome($nome);
                $dbora->setTelefone($telefone);
                $dbora->altera();
    */
            }catch(Exception $ex){
                echo $ex->getMessage();
            }

            break;
        case 3:
            // Exclusão
            $id     = addslashes(filter_input(INPUT_GET, 'id'));
                try{
                    $dbmysql    = new crud();
    /*                $dbmssql    = new crudsql();
                    $dbora      = new crudoracle();*/

                    //MySql
                    $dbmysql->setId($id);
                    $dbmysql->setNome($nome);
                    $dbmysql->setTelefone($telefone);
                    $dbmysql->exclui();
    /*
                    //SqlServer
                    $dbmssql->setId($id);
                    $dbmssql->setNome($nome);
                    $dbmssql->setTelefone($telefone);
                    $dbmssql->exclui();

                    //Oracle
                    $dbora->setId($id);
                    $dbora->setNome($nome);
                    $dbora->setTelefone($telefone);
                    $dbora->exclui();
*/        
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
//                        $dbmssql    = new crudsql();
//                        $dbora      = new crudoracle();

                        //MySql
                        echo "MySQL";
                        $dbmysql->lista();

                        //SqlServer
//                        echo "SQL Server";
//                        $dbmssql->lista();

                        //Oracle
//                        echo "Oracle";
//                        $dbora->lista();

                    } catch (Exception $ex) {
                        echo "Conexão não estabelecida. Verifique sob o erro: ".$ex->getMessage();
                    }

                ?>
                </tbody>
            </table>

<?php

    if($operacao == 1){

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
            echo "  <button class='btn btn-outline-primary' type='button'>Cancelar</button>";
            echo "</div>";

    }


?>

        </form>


    </body>
</html>