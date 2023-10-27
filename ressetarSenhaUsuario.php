<?php
  session_start();
  include_once 'sanitizar.php';  
  require_once 'permissaoAdmin.php';
  
    //Sanitização dos dados do Formulário
  $dadosform = sanitizar($_POST);
  $login = $dadosform['login'];
  $nome = $dadosform['nome'];
  $senha = md5($dadosform['senha']);
   
  //Array associativo para retorno ao Javascript, pois 
  //tenho que sinalizar se houve erro de validação e a mensagem de erro
  $retornajs = array();  
  
  //Senha Validação
  if (empty($senha)){
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Senha NÃO pode ser vazia!</div>';
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      //echo $retornajs;  //Não consigo retornar assim, só com um echo
      return;
  }

  //Salvar Alteração
  //Credenciais para conexão com o Banco
  $dsn = "mysql:host=localhost;dbname=crudproduto"; //Data Source Name
  $dbuser = 'root';
  $dbpass = '';
  
  //Conecta com o Banco 
  try{
    $conn = new PDO($dsn,$dbuser,$dbpass); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //Prepared Statements
    $stmt = $conn->prepare('UPDATE usuario SET senha=:senha WHERE login=:login');
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    
    if ($stmt->rowCount()==1){ //Alterou com Sucesso
      $retornajs['erro'] = false;
      //$retornajs['msg'] = '<div class="alert alert-success" role="alert">Usuário Alterado com Sucesso.</div>'; 
      $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Senha Alterada com Sucesso.</div>';
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      return;        
    }else{
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Erro ao Alterar a Senha.</div>'; 
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      return;        
    }
        
  } catch(PDOException $e){
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Erro ao Gravar Nova Senha.'.$e->getMessage().'</div>'; 
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      return;
  }
