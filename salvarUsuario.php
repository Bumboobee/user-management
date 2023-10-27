<?php
  session_start();
  include_once 'sanitizar.php';
  require_once 'permissaoAdmin.php';
  
    //Sanitização dos dados do Formulário
  $dadosform = sanitizar($_POST);
  $login = $dadosform['login'];
  $nome = $dadosform['nome'];
  $senha = md5($dadosform['senha']);
  $email = $dadosform['email'];
  $permissao = $dadosform['permissao'];
   
  //Array associativo para retorno ao Javascript, pois 
  //tenho que sinalizar se houve erro de validação e a mensagem de erro
  $retornajs = array();  
  //E-mail Validação
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Digite um Email válido.</div>';
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      //echo $retornajs;  //Não consigo retornar assim, só com um echo
      return;
  }

  //Permissão Validação
  if ($permissao=='Selecione'){
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">É necessário selecionar um Tipo de Permissão.</div>'; 
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      return;
  }     

  //Verificar se o nome de Login já NÃO existe!!!
  //Credenciais para conexão com o Banco
  $dsn = "mysql:host=localhost;dbname=crudproduto"; //Data Source Name
  $dbuser = 'root';
  $dbpass = '';
  
  //Conecta com o Banco 
  try{
    $conn = new PDO($dsn,$dbuser,$dbpass); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //Verificar se o Login já NÃO existe!!!
    //Prepared Statements
    $stmt = $conn->prepare('SELECT * FROM usuario WHERE login = :login');
    $stmt->execute(array('login' => $login));
    
    $result = $stmt->fetch();
    
    if (!empty($result)){ //Já tem um usuário com este Login
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Este Login já está sendo usado.</div>'; 
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      return;
    }
    else { //Gravar os Dados 
      $stmt = null;
      $stmt = $conn->prepare("INSERT INTO usuario (login,nome,senha,email,permissao) VALUES (:login, :nome, :senha, :email, :permissao)");
      $stmt->bindParam(':login', $login);
      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':senha', $senha);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':permissao', $permissao);
      
      $stmt->execute();
      
      if ($stmt->rowCount()==1){ //Inseriu com Sucesso
        $retornajs['erro'] = false;
        //Aqui vou usar SESSION
        $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Novo Usuário Cadastrado com Sucesso.</div>';
        //$retornajs['msg'] = '<div class="alert alert-success" role="alert">Novo Usuário Cadastrado com Sucesso.</div>'; 
        header('Content-Type: application/json');
        echo json_encode($retornajs);  //Retorna para o javascript
        return;        
      }else{
        $retornajs['erro'] = true;
        $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Erro ao Cadastrar novo Usuário.</div>'; 
        header('Content-Type: application/json');
        echo json_encode($retornajs);  //Retorna para o javascript
        return;        
      }  
    }
    
  } catch(PDOException $e){
      $retornajs['erro'] = true;
      $retornajs['msg'] = '<div class="alert alert-danger" role="alert">Erro ao Salvar Cadastro Novo Usuário.'.$e->getMessage().'</div>'; 
      header('Content-Type: application/json');
      echo json_encode($retornajs);  //Retorna para o javascript
      return;
  }
