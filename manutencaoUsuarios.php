<?php
require_once 'header.php';
require_once 'permissaoAdmin.php';
?>

<main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">  
      <div class="col-md-9">  
        <h3 class="h3 mt-2">Manutenção de Usuários do Sistema</h3>
      </div>
      <div class="col-md-3">
        <!-- Button trigger modal Cadastro Novo Usuário-->
        <button type="button" id="btnNovoUsuario" class="btn btn-outline-primary btn-sm mb-2 mt-2" data-toggle="modal" data-target="#ModalNovoUsuario" > Novo Usuário </button> 
      </div>                  
    </div>
      <span> 
        <?php //Mensagens de Erro e Sucesso na execução das funções              
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>          
      </span>      
  <?php    
    //Credeciais de Conexão com o Banco
    $dsn = "mysql:host=localhost;dbname=crudproduto"; //Data Source Name
    $dbuser = 'root';
    $dbpass = '';
  
    //Conecta com o Banco 
    try{
      $conn = new PDO($dsn,$dbuser,$dbpass); 
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
      //Prepared Statements
      $stmt = $conn->prepare('SELECT login, nome, email, permissao FROM usuario');
      $stmt->execute();
      
      //Retorna os dados em um Array associativo
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      
      //echo '<pre>';
      //print_r($result);
      //echo '</pre>';
      //die();
      
      //echo count($result).'<br>';
    
      //for ($i=0;$i<count($result);$i++){
          //foreach($result[$i] as $chave=>$valor) {
            //echo $chave.'->'.$valor.'<br>';
          //}
      //}       
      //die();
      //var_dump($result);
    } catch (PDOException $e) {
      echo "Erro ao acessar o Banco: " . $e->getMessage();
      die();
    }
    
    //Se conectou ao Banco e fez o SELECT, continua a partir daqui
    echo '<div class="table-responsive">';
      echo '<table class="table table-hover table-sm">';
        echo '<thead >';
          echo '<tr style="background-color: #bee5eb;">';
            echo '<th class="info">Login</th>';
            echo '<th class="info">Nome Completo</th>';
            echo '<th class="info">Email</th>';
            echo '<th class="info">Tipo de Permissão</th>';
            echo '<th class="info"></th>';
          echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        for ($i=0;$i<count($result);$i++){
          echo '<tr>';
          foreach($result[$i] as $chave=>$valor) {
            echo '<td>'.$valor.'</td>';
          }
          echo '<td style="text-align: center;">';
            echo '<!-- Button trigger modal Editar-->';
            echo '<button type="button" class="btn btn-outline-info btn-sm mr-2" data-toggle="modal" data-target="#ModalEditarUsuario" data-login="'.$result[$i]['login'].'" data-nome="'.$result[$i]['nome'].'" data-email="'.$result[$i]['email'].'" data-permissao="'.$result[$i]['permissao'].'">Editar</button>';

            echo '<!-- Button trigger modal RessetarSenha-->';
            echo '<button type="button" class="btn btn-outline-warning btn-sm mr-2" data-toggle="modal" data-target="#ModalRessetarSenha" data-login="'.$result[$i]['login'].'" data-nome="'.$result[$i]['nome'].'">Ressetar Senha</button>'; 

            echo '<!-- Button trigger modal Excluir-->';
            echo '<button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalExcluirUsuario" data-login="'.$result[$i]['login'].'" data-nome="'.$result[$i]['nome'].'">Excluir</button>';                             
          echo '</td>';
          echo '</tr>';
        } 
        echo '</tbody>';
      echo '</table>';
  ?>    
      
  <!-- Modal Novo Usuário -->
  <div class="modal fade" id="ModalNovoUsuario">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="ModalNovoUsuario">Cadastrar Novo Usuário</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formNovoUsuario" method="post">
          <div class="modal-body">
            <span id="msgCadUsrModal"></span>
              <div class="form-group">
                <label for="Login" class="col-form-label">Login</label>
                <input type="text" class="form-control" name="login" id="login" required autofocus>
              </div>
              <div class="form-group">
                <label for="Nome Completo" class="col-form-label">Nome Completo</label>
                <input type="text" class="form-control" name="nome" id="nome" required>
              </div>
              <div class="form-group">
                <label for="senha" class="col-form-label">Senha</label>
                <input type="password" class="form-control" name="senha" id="senha" required>
              </div>                                
              <div class="form-group">
                  <label for="Email" class="col-form-label">Email</label>
                  <input type="text" class="form-control" name="email" id="email" required>
              </div>
              <div class="form-group">
                <label for="permissao" class="col-form-label">Tipo de Permissão</label>
                <select class="form-control" name="permissao" id="permissao">
                  <option value="Selecione">Selecione</option>
                  <option value="Admin">Administrador</option>
                  <option value="Normal">Normal</option>
                  <option value="Leitura">Somente Leitura</option>
                </select>
              </div>                
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnConfirmar" name="btnConfirmar" value="btnConfirmar" class="btn btn-outline-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>  
  
  <!-- Modal Editar Usuário -->
  <div class="modal fade" id="ModalEditarUsuario">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="ModalEditarUsuario">Editar Cadastro do Usuário</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  id="formEditarUsuario" method="post">  
          <div class="modal-body">
            <span id="msgEdtUsrModal"></span>
            <div class="form-group">
              <label for="Login" class="col-form-label">Login</label>
              <input type="text" class="form-control" name="login" id="login" readonly required>
            </div>
            <div class="form-group">
              <label for="Nome Completo" class="col-form-label">Nome Completo</label>
              <input type="text" class="form-control" name="nome" id="nome" required>
            </div>
            <div class="form-group">
                <label for="Email" class="col-form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
              <label for="TipoUsuário" class="col-form-label">Tipo de Permissão</label>
              <select class="form-control" name="permissao" id="permissao">
                <option value="Selecione">Selecione</option>
                <option value="Admin">Administrador</option>
                <option value="Normal">Normal</option>
                <option value="Leitura">Somente Leitura</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnConfirmar" name="btnConfirmar" value="btnConfirmar" class="btn btn-outline-primary"  >Confirmar</button>
          </div>
       </form>
      </div>
    </div>
  </div>  
  
  <!-- Modal Ressetar Senha Usuário -->
  <div class="modal fade" id="ModalRessetarSenha">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="ModalRessetarSenha">Ressetar a Senha do Usuário</h4>
        </div>
        <form  id="formRessetarSenha" method="post">  
          <div class="modal-body">
            <span id="msgRstUsrModal"></span>
            <div class="form-group">
              <label for="Login" class="col-form-label">Login</label>
              <input type="text" class="form-control" name="login" id="login" readonly>
            </div>
            <div class="form-group">
              <label for="Login" class="col-form-label">Nome Completo</label>
              <input type="text" class="form-control" name="nome" id="nome" readonly>
            </div>              
            <div class="form-group">
              <label for="senha" class="col-form-label">Senha Provisória</label>
              <input type="password" class="form-control" name="senha" id="senha" value="" autofocus>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="btnRessetarSenha" name="btnRessetarSenha" value="btnRessetarSenha" class="btn btn-outline-danger"  >Confirmar</button>
          </div>
       </form>
      </div>
    </div>
  </div>  
  
  <!-- Modal Excluir Usuário -->
  <div class="modal fade" id="ModalExcluirUsuario">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirma Exclusão do Usuário?</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form  id="formExcluirUsuario" method="post">  
            <div class="modal-body">
              <span id="msgExcUsuario"></span>
              <div class="row">
                <h5 class="h5 ml-3">Login:</h5>
                <h5 class="h5 ml-2" id="logintxt"></h5>
                <input type="hidden" name="login" id="login">
              </div>
              <div class="row">
                <h5 class="h5 ml-3">Nome:</h5>            
                <h5 class="h5 ml-2" id="nometxt"></h5>
              </div>           
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>                    <button type="submit" id="btnExcluir" name="btnExcluir" value="btnExcluir" class="btn btn-outline-danger"  >Confirmar</button>
            </div>
          </form>
      </div>
    </div>
  </div> 
  
  </div>
</main>

<?php
require_once 'footer.php';

