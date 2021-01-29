<?php
require_once 'Pessoa.php';
$p = new Pessoa("crudpessoa","localhost","root","");
?>

<?php
//------------ CODIGO DETECTAR ERRO NO PHP------
    //error_reporting(E_ALL);
   // ini_set('display_errors', 'On');
    //include ("Pessoa.php");
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud-Pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <?php
    
       
        if (isset($_POST['nome'])) //CLCOU EM CADASTRAR OU EDITAR
        {
           //------------EDITAR-------------
           if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {

            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            //$nome = $_POST['nome'];
            //$strWithSlashes = filter_var($nome, FILTER_SANITIZE_ADD_SLASHES);
            $telefone = addslashes($_POST['telefone']);
            //$telefone = $_POST['telefone'];
            //$strWithSlashes = filter_var($telefone, FILTER_SANITIZE_ADD_SLASHES);
            $email = addslashes($_POST['email']);
            //$email = $_POST['email'];
            //$strWithSlashes = filter_var($email, FILTER_SANITIZE_ADD_SLASHES);
  
            if(!empty($nome) && !empty($telefone) && !empty($email) )
            {
                 //editar
            $p->atualizarDados($id_upd, $nome, $telefone, $email);
                 header("location: index.php");
                
            }
             else
            {
                ?>
                <div >
                    
                    <h4> Preencha todos os campos</h4>
                </div>
               
                <?php  
            }
               
           }
           //----------------CADATRAR------------
           else{
          $nome = addslashes($_POST['nome']);
          //$nome = $_POST['nome'];
          //$strWithSlashes = filter_var($nome, FILTER_SANITIZE_ADD_SLASHES);
          $telefone = addslashes($_POST['telefone']);
          //$telefone = $_POST['telefone'];
          //$strWithSlashes = filter_var($telefone, FILTER_SANITIZE_ADD_SLASHES);
          $email = addslashes($_POST['email']);
          //$email = $_POST['email'];
          //$strWithSlashes = filter_var($email, FILTER_SANITIZE_ADD_SLASHES);

          if(!empty($nome) && !empty($telefone) && !empty($email) )
          {
               //cadastrar
               if(!$p->cadastrarPessoa($nome, $telefone, $email))
               {
                ?>
                <div >
                    
                    <h4> Email ja esta cadastrado</h4>
                </div>
               
                <?php
               }
          }
           else
          {   
              ?>
              <div >
                 
                  <h4> Preencha todos os campos</h4>
              </div>
             
              <?php

            }
           }
    }
        
?>

<?php
       if (isset($_GET['id_up'])) // SE A PESSOA CLICOU EM ATUALIZAR
       {
           $id_update = addslashes($_GET['id_up']);
           $res = $p->buscarDadosPessoa($id_update);
       }

?>
    <section id="esquerda">
          <form method="POST">
                 <h2>Cadastrar Pessoa</h2>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome"
                value="<?php if(isset($res)){echo $res['nome'];}?>">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone"
                value="<?php if(isset($res)){echo $res['telefone'];}?>">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                value="<?php if(isset($res)){echo $res['email'];}?>">
                <input type="submit" value="<?php if(isset($res)) {echo"Atualizar";} else{echo"Cadastrar";} ?>">
          
          </form>
    </section>

    <section id="direita">

    <table>
              <tr id="titulo">
                    <td>id</td>
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td colspan="2">Email</td>
              </tr>

            <?php
             $dados = $p->buscarDados();
             if(count($dados) > 0) //TEM PESSOAS NO BANCO DE DADOS
             {
                 for ($i=0; $i < count($dados);$i++){
                     echo"<tr>";
                     foreach ($dados[$i] as $key => $value){
                         if($key != "id"){
                             echo"<td>".$value."</td>";
                         }
                     }
                     ?>
                     <td>
                         <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                         <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                    </td>
                     <?php
                     echo"</tr>";
                 }
                 
             }
             else//O BANCO DE DADOS ESTA VAZIO
             {   
                 ?>
                     <div  >
                     
                         <h4> Ainda não ha pessoas cadastradas</h4>

                     </div>
                
                 
                 <?php
                }   
            ?>
          </table>
    </section>

</body>
</html>

<?php
 
     if(isset($_GET['id']))
     {
         $id_pessoa = addslashes($_GET['id']);
         $p->excluirPessoa($id_pessoa);
         header("location: index.php");
     }

?>