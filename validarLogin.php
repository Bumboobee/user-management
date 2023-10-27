<?php
  session_start();
  include_once 'sanitizar.php';
  
  //Sanitização dos dados do Formulário de  Login
  $dadosform = sanitizar($_POST);
  $loginform = $dadosform['login'];  
  $senhaform = md5($dadosform['senha']);
  
  if (isset($_SESSION['login'])){
    unset($_SESSION['login']); //Limpa os dados do formulário se guardados anteriormente
  }
  
  //Busca os dados do usuário no Banco para Autenticação
  
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
  
  $sql = "SELECT * FROM usuario WHERE login='$loginform'";
  $result = mysqli_query($conn, $sql); //A query seleciona as linhas da Tabela

  if(mysqli_affected_rows($conn) != 1){ //Não localizou o usuário no banco
    //$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Login Não Localizado!</div>';
    $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Usuário e/ou Senha Inválidos!</div>';
    $_SESSION['login'] = $loginform; //Coloca o login digitado na SESSÃO para reapresentar no Formulário
    $conn->close(); //Fecha a conexão com o Banco
    header("Location:index.php");
    die();
  }
  
  //Se chegou aqui é porque achou o usuário, agora verifica se a senha digitada confere
  $usuario = mysqli_fetch_assoc($result);
  
  $login = $usuario['login'];
  $nome = $usuario['nome'];
  $senha = $usuario['senha'];
  $email = $usuario['email'];
  $permissao = $usuario['permissao'];
  
  if ($senha!=$senhaform){ //Erro na autenticação
    //$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Senha Inválida!</div>';
    $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Usuário e/ou Senha Inválidos!</div>';
    $_SESSION['login'] = $loginform; //Coloca o login digitado na SESSÃO para reapresentar no Formulário
    $conn->close(); //Fecha a conexão com o Banco
    header("Location:index.php");
    die();
  }
  
  //Se chegou até aqui é porque a Autenticação está correta
  //Então coloca as informações do usuário na SESSÃO e chama a página principal da Aplicação
  $_SESSION['usuario']['login']=$login;
  $_SESSION['usuario']['nome']=$nome;
  $_SESSION['usuario']['email']=$email;
  $_SESSION['usuario']['permissao']=$permissao;
  
  $conn->close(); //Fecha a conexão com o Banco
  header("Location:home.php");
