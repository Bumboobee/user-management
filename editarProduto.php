<?php
  session_start();
  include_once 'sanitizar.php';
  require_once 'permissaoLeitura.php';

 $dados = sanitizar($_GET); //Sanitização 
 $idproduto = $dados['id'];

  if (!is_numeric($idproduto)){ //Validação 
    die("Id do produto não é numérico!");
  }

  //Se chegou aqui é porque validou
  //Então busca os dados do Produto pelo id
  //Credenciais para conexão com o Banco
  $dbhost = 'localhost:3306';
  $dbuser = 'root';
  $dbpass = '';
  $dbname = 'crudproduto';

  //Abre conexão com o MySQL
  $conn = new mysqli($dbhost, $dbuser, $dbpass,$dbname);

  if($conn->connect_error ){
    die('Falha ao conectar com o MySQL: ' . $conn->connect_error);
  }

  $sql = "SELECT * FROM Produto WHERE id={$idproduto}";
  $result = mysqli_query($conn, $sql); //A query seleciona as linhas da Tabela

  if(mysqli_affected_rows($conn) != 1){ 
    die('Falha ao recuperar dados do produto');
  }

  $produto = mysqli_fetch_assoc($result);

  $conn->close(); //Fecha a conexão com o Banco
  
  $_SESSION['form'] = $produto; 
  $_SESSION['form_name'] = 'editar';
  header("Location:editarProdutoForm.php");
